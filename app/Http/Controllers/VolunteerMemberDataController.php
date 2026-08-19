<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Membership;
use App\Models\Volunteer;
use App\Services\AuditLogger;

class VolunteerMemberDataController extends Controller
{
    /**
     * Display the Area-wise Member Data explorer interface for authenticated volunteers.
     */
    public function index(Request $request)
    {
        $volunteer = Auth::guard('volunteer')->user();
        if (!$volunteer || $volunteer->status !== 'approved' || (isset($volunteer->is_active) && !$volunteer->is_active)) {
            return redirect()->route('volunteer.login')->withErrors(['volunteer_id' => 'Unauthorized access.']);
        }

        // Fetch distinct available districts from verified memberships
        $districts = Membership::where('payment_status', 'success')
            ->where('is_completed', 1)
            ->whereNotNull('district')
            ->where('district', '!=', '')
            ->distinct()
            ->orderBy('district')
            ->pluck('district');

        return view('volunteer.member_data', compact('volunteer', 'districts'));
    }

    /**
     * AJAX endpoint to fetch cascading areas (Mandals and Panchayats) based on selection.
     */
    public function getAreas(Request $request)
    {
        $district = $request->query('district');
        $mandal = $request->query('mandal');

        $query = Membership::where('payment_status', 'success')
            ->where('is_completed', 1);

        if ($district) {
            $query->where('district', $district);
        }

        if ($mandal) {
            $query->where('mandal', $mandal);
            $panchayats = $query->whereNotNull('grama_panchayat')
                ->where('grama_panchayat', '!=', '')
                ->distinct()
                ->orderBy('grama_panchayat')
                ->pluck('grama_panchayat');

            return response()->json(['panchayats' => $panchayats]);
        }

        $mandals = $query->whereNotNull('mandal')
            ->where('mandal', '!=', '')
            ->distinct()
            ->orderBy('mandal')
            ->pluck('mandal');

        return response()->json(['mandals' => $mandals]);
    }

    /**
     * Search and preview member records with server-side validation.
     */
    public function search(Request $request)
    {
        $volunteer = Auth::guard('volunteer')->user();
        if (!$volunteer || $volunteer->status !== 'approved') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Rate limiting for search (max 30 requests/minute)
        $throttleKey = 'vol_member_search:' . $volunteer->id . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 30)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'error' => "Rate limit exceeded. Please wait {$seconds} seconds before searching again."
            ], 429);
        }
        RateLimiter::hit($throttleKey, 60);

        // Sanitize and validate inputs
        $validated = $request->validate([
            'district' => 'nullable|string|max:100',
            'mandal' => 'nullable|string|max:100',
            'grama_panchayat' => 'nullable|string|max:100',
            'search' => 'nullable|string|max:100',
        ]);

        $query = $this->buildFilteredQuery($validated);

        // Limit preview to 100 records for fast browser rendering
        $totalCount = (clone $query)->count();
        $members = $query->take(100)->get();

        $data = $members->map(function ($m, $index) {
            // Photo URL handling
            $photoUrl = null;
            if (!empty($m->photo_path)) {
                $photoUrl = asset('storage/' . $m->photo_path);
            }

            return [
                'serial_no' => $index + 1,
                'full_name' => e($m->full_name),
                'gender' => e($m->gender ?? 'Not Specified'),
                'membership_id' => $m->membership_id,
                'photo_url' => $photoUrl,
                'district' => e($m->district ?? '—'),
                'mandal' => e($m->mandal ?? '—'),
                'grama_panchayat' => e($m->grama_panchayat ?? '—'),
            ];
        });

        return response()->json([
            'success' => true,
            'total_count' => $totalCount,
            'displayed_count' => $data->count(),
            'members' => $data,
        ]);
    }

    /**
     * Export Member Data to PDF format.
     */
    public function exportPdf(Request $request)
    {
        $volunteer = Auth::guard('volunteer')->user();
        if (!$volunteer || $volunteer->status !== 'approved') {
            return redirect()->route('volunteer.login')->withErrors(['volunteer_id' => 'Unauthorized.']);
        }

        // Rate limiting for exports (max 10 exports/minute)
        $throttleKey = 'vol_member_export:' . $volunteer->id . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Export rate limit reached. Please wait {$seconds} seconds before generating another export.");
        }
        RateLimiter::hit($throttleKey, 60);

        $validated = $request->validate([
            'district' => 'nullable|string|max:100',
            'mandal' => 'nullable|string|max:100',
            'grama_panchayat' => 'nullable|string|max:100',
            'search' => 'nullable|string|max:100',
        ]);

        $query = $this->buildFilteredQuery($validated);
        $totalCount = (clone $query)->count();

        // Safety limit: max 500 records per PDF to avoid memory exhaustion
        if ($totalCount > 500) {
            return back()->with('error', "The selected area contains {$totalCount} members. Please narrow down your selection to Mandal or Grama Panchayat (Max 500 records per PDF).");
        }

        if ($totalCount === 0) {
            return back()->with('error', 'No active members found in the selected area to export.');
        }

        $members = $query->take(500)->get();

        // Construct human-readable area summary
        $areaParts = array_filter([
            $validated['grama_panchayat'] ?? null,
            $validated['mandal'] ?? null,
            $validated['district'] ?? null,
        ]);
        $areaSummary = !empty($areaParts) ? implode(', ', $areaParts) : 'All Configured Regions';

        // Prepare safe data collection with embedded photo representation
        $exportData = [];
        foreach ($members as $index => $m) {
            $photoBase64 = null;
            if (!empty($m->photo_path) && Storage::disk('public')->exists($m->photo_path)) {
                try {
                    $fileContent = Storage::disk('public')->get($m->photo_path);
                    $mimeType = Storage::disk('public')->mimeType($m->photo_path) ?: 'image/jpeg';
                    $photoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($fileContent);
                } catch (\Throwable $e) {
                    $photoBase64 = null;
                }
            }

            $exportData[] = [
                'serial_no' => $index + 1,
                'full_name' => $m->full_name,
                'gender' => $m->gender ?? 'Not Specified',
                'membership_id' => $m->membership_id,
                'photo_base64' => $photoBase64,
                'district' => $m->district ?? '—',
                'mandal' => $m->mandal ?? '—',
                'grama_panchayat' => $m->grama_panchayat ?? '—',
            ];
        }

        // Audit Logging (PII-free)
        AuditLogger::log(
            'MEMBER_DATA_EXPORT',
            'Volunteer',
            $volunteer->volunteer_id,
            [
                'format' => 'PDF',
                'area_summary' => $areaSummary,
                'district' => $validated['district'] ?? 'ALL',
                'mandal' => $validated['mandal'] ?? 'ALL',
                'grama_panchayat' => $validated['grama_panchayat'] ?? 'ALL',
                'records_exported' => count($exportData),
            ],
            'Volunteer',
            $volunteer->volunteer_id,
            $volunteer->id
        );

        $pdf = Pdf::loadView('pdf.member_data_export_pdf', [
            'members' => $exportData,
            'areaSummary' => $areaSummary,
            'volunteer' => $volunteer,
            'generatedAt' => now()->format('d M Y, h:i A') . ' IST',
            'totalRecords' => count($exportData),
        ])->setPaper('a4', 'portrait');

        $safeFilename = 'abvhps_member_data_' . substr(md5(uniqid('', true)), 0, 8) . '.pdf';

        return $pdf->download($safeFilename);
    }

    /**
     * Export Member Data to CSV format using chunked streaming.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $volunteer = Auth::guard('volunteer')->user();
        if (!$volunteer || $volunteer->status !== 'approved') {
            abort(403, 'Unauthorized access.');
        }

        // Rate limiting for exports
        $throttleKey = 'vol_member_export:' . $volunteer->id . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            abort(429, 'Export rate limit exceeded. Please wait a minute before exporting again.');
        }
        RateLimiter::hit($throttleKey, 60);

        $validated = $request->validate([
            'district' => 'nullable|string|max:100',
            'mandal' => 'nullable|string|max:100',
            'grama_panchayat' => 'nullable|string|max:100',
            'search' => 'nullable|string|max:100',
        ]);

        $query = $this->buildFilteredQuery($validated);
        $totalCount = (clone $query)->count();

        $areaParts = array_filter([
            $validated['grama_panchayat'] ?? null,
            $validated['mandal'] ?? null,
            $validated['district'] ?? null,
        ]);
        $areaSummary = !empty($areaParts) ? implode(', ', $areaParts) : 'All Configured Regions';

        // Audit Logging (PII-free)
        AuditLogger::log(
            'MEMBER_DATA_EXPORT',
            'Volunteer',
            $volunteer->volunteer_id,
            [
                'format' => 'CSV',
                'area_summary' => $areaSummary,
                'district' => $validated['district'] ?? 'ALL',
                'mandal' => $validated['mandal'] ?? 'ALL',
                'grama_panchayat' => $validated['grama_panchayat'] ?? 'ALL',
                'records_exported' => $totalCount,
            ],
            'Volunteer',
            $volunteer->volunteer_id,
            $volunteer->id
        );

        $safeFilename = 'abvhps_member_data_' . substr(md5(uniqid('', true)), 0, 8) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$safeFilename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($query) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Banner
            fputcsv($file, ['# ABVHPS MEMBER DATA — AUTHORIZED ORGANIZATIONAL USE ONLY']);
            fputcsv($file, ['No.', 'Full Name', 'Gender', 'Membership ID', 'District', 'Mandal', 'Grama Panchayat', 'Photo Available']);

            $serialNo = 1;
            $query->chunk(200, function ($members) use ($file, &$serialNo) {
                foreach ($members as $m) {
                    // Prevent CSV Formula Injection
                    $safeName = $this->sanitizeCsvField($m->full_name);
                    $safeGender = $this->sanitizeCsvField($m->gender ?? 'Not Specified');
                    $hasPhoto = !empty($m->photo_path) ? 'Yes' : 'No';

                    fputcsv($file, [
                        $serialNo++,
                        $safeName,
                        $safeGender,
                        $m->membership_id,
                        $this->sanitizeCsvField($m->district ?? ''),
                        $this->sanitizeCsvField($m->mandal ?? ''),
                        $this->sanitizeCsvField($m->grama_panchayat ?? ''),
                        $hasPhoto,
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper to construct safe, parameterized filtered query for approved memberships.
     */
    protected function buildFilteredQuery(array $filters)
    {
        $query = Membership::where('payment_status', 'success')
            ->where('is_completed', 1)
            ->select([
                'membership_id',
                'full_name',
                'gender',
                'photo_path',
                'district',
                'mandal',
                'grama_panchayat',
                'assembly_segment',
            ]);

        // Server-Side Geographic Hierarchy Validation
        if (!empty($filters['district'])) {
            $query->where('district', $filters['district']);
        }

        if (!empty($filters['mandal'])) {
            $query->where('mandal', $filters['mandal']);
        }

        if (!empty($filters['grama_panchayat'])) {
            $query->where('grama_panchayat', $filters['grama_panchayat']);
        }

        if (!empty($filters['search'])) {
            $term = '%' . trim($filters['search']) . '%';
            $query->where('full_name', 'LIKE', $term);
        }

        return $query->orderBy('district')->orderBy('mandal')->orderBy('full_name');
    }

    /**
     * Sanitize string against CSV Formula Injection (=, +, -, @).
     */
    protected function sanitizeCsvField(?string $value): string
    {
        if ($value === null) {
            return '';
        }
        $val = trim($value);
        if (in_array(substr($val, 0, 1), ['=', '+', '-', '@'], true)) {
            return "'" . $val;
        }
        return $val;
    }
}
