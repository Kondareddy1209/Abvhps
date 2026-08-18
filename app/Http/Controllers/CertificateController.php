<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaxCertificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CertificateController extends Controller
{
    /**
     * Auto-sync existing files from public/certifications folder into DB if not present
     */
    protected function syncExistingCertificates()
    {
        $predefined = [
            '12A.pdf' => [
                'title' => 'Section 12A Income Tax Exemption Certificate',
                'certificate_type' => 'Section 12A',
                'document_number' => '12A-ABVHPS-EXEMPT',
                'description' => 'Official Income Tax Department 12A Registration Certificate granting non-profit tax exemption.',
            ],
            '80G.pdf' => [
                'title' => 'Section 80G Tax Exemption Certificate',
                'certificate_type' => 'Section 80G',
                'document_number' => '80G-ABVHPS-DEDUCT',
                'description' => '50% Tax deduction eligibility certificate for devotees & donors under Section 80G of Income Tax Act.',
            ],
            'CSR certificate.pdf' => [
                'title' => 'Ministry of Corporate Affairs CSR-1 Registration',
                'certificate_type' => 'CSR-1',
                'document_number' => 'CSR000-ABVHPS-MCA',
                'description' => 'MCA registration document certifying ABVHPS as an authorized eligible entity for Corporate CSR initiatives.',
            ],
            '10AC.pdf' => [
                'title' => 'Form 10AC Statutory Registration Order',
                'certificate_type' => 'Section 10AC',
                'document_number' => 'FORM-10AC-REG',
                'description' => 'Order for provisional/permanent registration under Section 12A / 80G in Form 10AC.',
            ],
        ];

        $certPath = public_path('certifications');
        if (File::isDirectory($certPath)) {
            $files = File::files($certPath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                $relPath = 'certifications/' . $filename;

                $exists = TaxCertificate::where('file_path', $relPath)->exists();
                if (!$exists) {
                    $meta = $predefined[$filename] ?? [
                        'title' => pathinfo($filename, PATHINFO_FILENAME) . ' Certificate',
                        'certificate_type' => 'Statutory Compliance',
                        'document_number' => null,
                        'description' => 'Official compliance document.',
                    ];

                    TaxCertificate::create([
                        'title' => $meta['title'],
                        'certificate_type' => $meta['certificate_type'],
                        'document_number' => $meta['document_number'],
                        'file_path' => $relPath,
                        'description' => $meta['description'],
                        'is_active' => true,
                    ]);
                }
            }
        }
    }

    /**
     * Public Tax & Compliance Certificates Download Desk
     */
    public function publicIndex()
    {
        $this->syncExistingCertificates();

        $certificates = TaxCertificate::where('is_active', true)->orderBy('id', 'asc')->get();
        return view('compliance_certificates', compact('certificates'));
    }

    /**
     * Admin Certificates Management Desk
     */
    public function adminIndex()
    {
        $this->syncExistingCertificates();

        $certificates = TaxCertificate::orderBy('id', 'desc')->get();

        $stats = [
            'total_certificates' => $certificates->count(),
            'active_certificates' => $certificates->where('is_active', true)->count(),
            'types_count' => $certificates->groupBy('certificate_type')->count(),
        ];

        return view('admin.certificates_index', compact('certificates', 'stats'));
    }

    /**
     * Admin Store New / Replacement Compliance Certificate
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'certificate_type' => 'required|string|max:100',
            'document_number' => 'nullable|string|max:100',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
            'certificate_pdf' => 'required|file|mimes:pdf|max:15360', // Max 15MB
            'description' => 'nullable|string',
        ]);

        $filePath = $request->file('certificate_pdf')->store('certificates', 'public');

        TaxCertificate::create([
            'title' => $request->title,
            'certificate_type' => $request->certificate_type,
            'document_number' => $request->document_number,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'file_path' => $filePath,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.certificates.index')->with('success', 'Official Compliance Certificate uploaded and published successfully.');
    }

    /**
     * Admin Toggle Active Status
     */
    public function adminToggle($id)
    {
        $cert = TaxCertificate::findOrFail($id);
        $cert->is_active = !$cert->is_active;
        $cert->save();

        return redirect()->back()->with('success', 'Certificate visibility status updated.');
    }

    /**
     * Admin Delete Certificate
     */
    public function adminDelete($id)
    {
        $cert = TaxCertificate::findOrFail($id);
        if ($cert->file_path && !str_starts_with($cert->file_path, 'certifications/') && Storage::disk('public')->exists($cert->file_path)) {
            Storage::disk('public')->delete($cert->file_path);
        }
        $cert->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate removed successfully.');
    }
}
