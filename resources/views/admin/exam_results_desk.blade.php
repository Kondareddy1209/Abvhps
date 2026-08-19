@extends('layouts.app')

@section('title', 'Result Entry Desk — ' . $exam->exam_title . ' | ABVHPS Admin')

@section('content')
<style>
    /* ── ABVHPS Result Desk – Institutional Table Design ── */
    :root {
        --border: #d1d5db;
        --bg-header: #f8f7f5;
        --accent: #7c2d12;
        --accent-light: #fef3c7;
        --green: #15803d;
        --green-bg: #f0fdf4;
        --red: #b91c1c;
        --red-bg: #fef2f2;
        --amber: #b45309;
        --amber-bg: #fffbeb;
        --gray: #374151;
        --gray-light: #6b7280;
    }
    body { background: #f5f4f2; }
    .rd-wrap { max-width: 1280px; margin: 0 auto; padding: 24px 16px; }
    .rd-breadcrumb { font-size: 11px; color: var(--gray-light); margin-bottom: 16px; }
    .rd-breadcrumb a { color: var(--accent); text-decoration: none; }
    .rd-breadcrumb a:hover { text-decoration: underline; }

    /* Exam Header Card */
    .rd-exam-header {
        background: #fff;
        border: 1px solid var(--border);
        padding: 20px 24px;
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }
    .rd-exam-title { font-size: 17px; font-weight: 700; color: #111; margin: 0 0 4px; }
    .rd-exam-meta { font-size: 11px; color: var(--gray-light); }
    .rd-exam-meta span { margin-right: 16px; }
    .rd-type-badge {
        display: inline-block;
        font-size: 10px; font-weight: 700;
        letter-spacing: 1px; text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 2px;
    }
    .rd-type-mcq { background: #dbeafe; color: #1d4ed8; }
    .rd-type-theory { background: #fce7f3; color: #9d174d; }
    .rd-type-default { background: #f3f4f6; color: #374151; }

    /* Stats Bar */
    .rd-stats { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .rd-stat-box {
        background: #fff;
        border: 1px solid var(--border);
        padding: 12px 20px;
        min-width: 120px;
        text-align: center;
    }
    .rd-stat-n { font-size: 24px; font-weight: 800; color: #111; }
    .rd-stat-l { font-size: 10px; color: var(--gray-light); text-transform: uppercase; letter-spacing: 0.8px; margin-top: 2px; }

    /* Alert / Flash */
    .rd-alert {
        padding: 12px 16px;
        border-left: 4px solid;
        margin-bottom: 16px;
        font-size: 13px;
        font-weight: 500;
    }
    .rd-alert-success { border-color: #15803d; background: #f0fdf4; color: #14532d; }
    .rd-alert-error   { border-color: #b91c1c; background: #fef2f2; color: #7f1d1d; }

    /* Publish / Unpublish Action Bar */
    .rd-action-bar {
        background: var(--bg-header);
        border: 1px solid var(--border);
        padding: 14px 20px;
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .rd-action-bar h2 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #111; margin: 0; }
    .btn-publish {
        background: var(--green);
        color: #fff;
        border: none;
        padding: 9px 22px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        cursor: pointer;
        text-transform: uppercase;
    }
    .btn-publish:hover { background: #166534; }
    .btn-unpublish {
        background: transparent;
        color: var(--red);
        border: 1px solid var(--red);
        padding: 8px 18px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-unpublish:hover { background: var(--red-bg); }
    .btn-secondary {
        background: transparent;
        color: var(--gray);
        border: 1px solid var(--border);
        padding: 8px 16px;
        font-size: 11px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        display: inline-block;
    }
    .btn-secondary:hover { background: #f3f4f6; }
    .btn-save {
        background: var(--accent);
        color: #fff;
        border: none;
        padding: 6px 14px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-save:hover { background: #991b1b; }

    /* Filter Bar */
    .rd-filter-bar {
        background: #fff;
        border: 1px solid var(--border);
        padding: 12px 16px;
        margin-bottom: 16px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    .rd-filter-bar label { font-size: 11px; font-weight: 600; color: var(--gray-light); text-transform: uppercase; }
    .rd-filter-bar select, .rd-filter-bar input[type="text"] {
        border: 1px solid var(--border);
        padding: 5px 10px;
        font-size: 12px;
        color: #111;
        background: #fff;
    }
    .rd-filter-bar select:focus, .rd-filter-bar input:focus { outline: 2px solid var(--accent); }
    .btn-filter {
        background: var(--accent);
        color: #fff;
        border: none;
        padding: 6px 16px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-transform: uppercase;
    }
    .btn-filter:hover { background: #991b1b; }
    .btn-clear { color: var(--gray-light); font-size: 11px; text-decoration: underline; cursor: pointer; }

    /* Main Table */
    .rd-table-wrap {
        background: #fff;
        border: 1px solid var(--border);
        overflow-x: auto;
    }
    table.rd-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    table.rd-table thead th {
        background: var(--bg-header);
        border-bottom: 2px solid var(--border);
        padding: 10px 12px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--gray-light);
        text-align: left;
        white-space: nowrap;
    }
    table.rd-table tbody tr { border-bottom: 1px solid #f0f0f0; }
    table.rd-table tbody tr:last-child { border-bottom: none; }
    table.rd-table tbody tr:hover { background: #fafaf9; }
    table.rd-table td { padding: 10px 12px; vertical-align: top; }
    .td-ticket { font-family: 'Courier New', monospace; font-size: 11px; font-weight: 700; color: #1e40af; }
    .td-name { font-weight: 600; color: #111; }
    .td-school { font-size: 11px; color: var(--gray-light); }

    /* Status badges */
    .badge {
        display: inline-block;
        padding: 2px 8px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-radius: 2px;
    }
    .badge-pass    { background: var(--green-bg);  color: var(--green); }
    .badge-fail    { background: var(--red-bg);    color: var(--red); }
    .badge-pending { background: #f3f4f6;           color: var(--gray-light); }
    .badge-draft      { background: var(--amber-bg); color: var(--amber); }
    .badge-published  { background: var(--green-bg); color: var(--green); }

    /* Inline Result Form */
    .result-form { display: none; }
    .result-form.open { display: block; }
    .result-form-inner {
        background: #f8f7f5;
        border: 1px solid var(--border);
        padding: 14px;
        margin-top: 8px;
    }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 10px; }
    .form-group label { display: block; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray-light); margin-bottom: 3px; }
    .form-group input, .form-group select, .form-group textarea {
        width: 100%;
        border: 1px solid var(--border);
        padding: 6px 8px;
        font-size: 12px;
        color: #111;
        background: #fff;
        box-sizing: border-box;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
        outline: 2px solid var(--accent);
        outline-offset: 0;
    }
    .form-actions { margin-top: 10px; display: flex; gap: 8px; align-items: center; }
    .link-cancel { font-size: 11px; color: var(--gray-light); cursor: pointer; text-decoration: underline; }
    .form-error { color: var(--red); font-size: 11px; margin-top: 4px; }

    /* Pagination */
    .rd-pagination { padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: var(--gray-light); border-top: 1px solid var(--border); background: #fff; }

    /* Confirm Modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.45); z-index: 9999;
        align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: #fff;
        border: 1px solid var(--border);
        padding: 32px;
        max-width: 480px;
        width: 90%;
    }
    .modal-box h3 { font-size: 15px; font-weight: 700; color: #111; margin: 0 0 12px; }
    .modal-box p  { font-size: 13px; color: var(--gray); line-height: 1.6; margin: 0 0 8px; }
    .modal-box .modal-warn { color: var(--amber); font-size: 12px; font-weight: 600; margin-bottom: 16px; }
    .modal-actions { display: flex; gap: 12px; margin-top: 20px; }
</style>

<div class="rd-wrap">

    {{-- Breadcrumb --}}
    <p class="rd-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Admin</a> ›
        <a href="{{ route('admin.exams.index') }}">Exam Management</a> ›
        Result Entry Desk
    </p>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="rd-alert rd-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rd-alert rd-alert-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="rd-alert rd-alert-error">
            @foreach($errors->all() as $err) {{ $err }}<br> @endforeach
        </div>
    @endif

    {{-- Exam Header --}}
    <div class="rd-exam-header">
        <div>
            <div class="rd-exam-meta" style="margin-bottom:6px;">
                <span>
                    @php
                        $typeLabel = match($exam->exam_type ?? '') {
                            'mcq'    => 'MCQ Based',
                            'theory' => 'Theory Based',
                            default  => strtoupper($exam->exam_type ?? 'Standard'),
                        };
                        $typeClass = match($exam->exam_type ?? '') {
                            'mcq'    => 'rd-type-mcq',
                            'theory' => 'rd-type-theory',
                            default  => 'rd-type-default',
                        };
                    @endphp
                    <span class="rd-type-badge {{ $typeClass }}">{{ $typeLabel }}</span>
                </span>
                <span>DB ID: {{ $exam->id }}</span>
            </div>
            <h1 class="rd-exam-title">{{ $exam->exam_title }}</h1>
            <p class="rd-exam-meta">
                <span>📅 {{ $exam->exam_date_time ? \Carbon\Carbon::parse($exam->exam_date_time)->format('d M Y, H:i') : '—' }}</span>
                <span>📍 {{ $exam->exam_center_location ?? '—' }}</span>
                <span>Status: <strong>{{ ucfirst($exam->status ?? '—') }}</strong></span>
            </p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:flex-start;">
            <a href="{{ route('admin.exams.index') }}" class="btn-secondary">← Exam List</a>
            <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn-secondary">Edit Exam</a>
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="rd-stats">
        <div class="rd-stat-box">
            <div class="rd-stat-n">{{ $stats['total'] }}</div>
            <div class="rd-stat-l">Registered</div>
        </div>
        <div class="rd-stat-box">
            <div class="rd-stat-n">{{ $stats['pending'] }}</div>
            <div class="rd-stat-l">Pending Results</div>
        </div>
        <div class="rd-stat-box">
            <div class="rd-stat-n">{{ $stats['drafted'] }}</div>
            <div class="rd-stat-l">Results Drafted</div>
        </div>
        <div class="rd-stat-box">
            <div class="rd-stat-n">{{ $stats['published'] }}</div>
            <div class="rd-stat-l">Published</div>
        </div>
        <div class="rd-stat-box">
            <div class="rd-stat-n">{{ $stats['notif_logged'] }}</div>
            <div class="rd-stat-l">Notified</div>
        </div>
        <div class="rd-stat-box">
            <div class="rd-stat-n" style="color:{{ $stats['notif_failed'] > 0 ? 'var(--red)' : 'inherit' }};">{{ $stats['notif_failed'] }}</div>
            <div class="rd-stat-l">Notif. Failed</div>
        </div>
    </div>

    {{-- Action Bar --}}
    <div class="rd-action-bar">
        <div>
            <h2>Result Entry &amp; Publication Desk</h2>
            <p style="font-size:11px;color:var(--gray-light);margin:4px 0 0;">
                Enter results and save as Draft. Review, then Publish to make results visible to candidates.
                Publishing triggers result-announcement notifications.
            </p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            @if($stats['published'] > 0)
                <form method="POST" action="{{ route('admin.exams.unpublish_results', $exam->id) }}"
                      onsubmit="return confirm('Move ALL results for this exam back to Draft? This will hide them from candidates. Notification logs are preserved.');">
                    @csrf
                    <button type="submit" class="btn-unpublish">Unpublish Results</button>
                </form>
            @endif
            <button type="button" class="btn-publish" onclick="openPublishModal()">
                Publish Results
            </button>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.exams.results', $exam->id) }}" class="rd-filter-bar">
        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;width:100%;">
            <div>
                <label>Result Status</label>
                <select name="result_status">
                    <option value="">All</option>
                    <option value="pending"  {{ $filterStatus === 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="passed"   {{ $filterStatus === 'passed'   ? 'selected' : '' }}>Passed</option>
                    <option value="failed"   {{ $filterStatus === 'failed'   ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div>
                <label>Publication</label>
                <select name="publication_status">
                    <option value="">All</option>
                    <option value="draft"     {{ $filterPub === 'draft'     ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $filterPub === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div style="flex:1;min-width:180px;">
                <label>Search</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Name, Hall Ticket, ID…">
            </div>
            <div style="display:flex;gap:8px;align-items:flex-end;padding-top:14px;">
                <button type="submit" class="btn-filter">Filter</button>
                <a href="{{ route('admin.exams.results', $exam->id) }}" class="btn-clear">Clear</a>
            </div>
        </div>
    </form>

    {{-- Results Table --}}
    <div class="rd-table-wrap">
        <table class="rd-table" id="results_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hall Ticket</th>
                    <th>Candidate</th>
                    <th>Parent / Guardian ID</th>
                    <th>Marks</th>
                    <th>Grade</th>
                    <th>Outcome</th>
                    <th>Publication</th>
                    <th>Notified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    @php
                        $pct = null;
                        if ($app->total_marks > 0 && $app->marks_obtained !== null) {
                            $pct = round(($app->marks_obtained / $app->total_marks) * 100, 1);
                        }
                        $parentId = $app->father_membership_id ?: $app->guardian_mobile_or_id ?: '—';
                    @endphp
                    <tr>
                        <td style="color:var(--gray-light);font-size:11px;">{{ $app->id }}</td>
                        <td class="td-ticket">{{ $app->hall_ticket_number }}</td>
                        <td>
                            <div class="td-name">{{ $app->full_name }}</div>
                            <div class="td-school">{{ $app->school_college_name }}</div>
                        </td>
                        <td style="font-size:11px;font-family:monospace;">{{ $parentId }}</td>
                        <td style="font-size:12px;">
                            @if($app->marks_obtained !== null)
                                {{ $app->marks_obtained }}{{ $app->total_marks ? ' / '.$app->total_marks : '' }}
                                @if($pct !== null)
                                    <div style="font-size:10px;color:var(--gray-light);">{{ $pct }}%</div>
                                @endif
                            @else
                                <span style="color:var(--gray-light);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($app->grade)
                                <span class="badge badge-pending" style="background:#f3f4f6;color:#111;">{{ $app->grade }}</span>
                            @else
                                <span style="color:var(--gray-light);font-size:11px;">—</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $outClass = match($app->result_status ?? 'pending') {
                                    'passed' => 'badge-pass',
                                    'failed' => 'badge-fail',
                                    default  => 'badge-pending',
                                };
                            @endphp
                            <span class="badge {{ $outClass }}">{{ ucfirst($app->result_status ?? 'pending') }}</span>
                        </td>
                        <td>
                            <span class="badge {{ ($app->result_publication_status ?? 'draft') === 'published' ? 'badge-published' : 'badge-draft' }}">
                                {{ ucfirst($app->result_publication_status ?? 'draft') }}
                            </span>
                            @if($app->result_published_at)
                                <div style="font-size:10px;color:var(--gray-light);margin-top:2px;">
                                    {{ \Carbon\Carbon::parse($app->result_published_at)->format('d M y') }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @php
                                $notifLogged = \App\Models\NotificationLog::where('notifiable_type', App\Models\ExamApplication::class)
                                    ->where('notifiable_id', $app->id)
                                    ->where('event_type', 'exam_result_announced')
                                    ->exists();
                            @endphp
                            @if($notifLogged)
                                <span class="badge badge-pass" style="font-size:10px;">✓ Yes</span>
                            @else
                                <span style="color:var(--gray-light);font-size:11px;">—</span>
                            @endif
                        </td>
                        <td>
                            <button type="button"
                                    class="btn-save"
                                    style="background:transparent;color:var(--accent);border:1px solid var(--accent);padding:5px 10px;"
                                    onclick="toggleForm('form-{{ $app->id }}', this)">
                                Enter / Edit
                            </button>
                        </td>
                    </tr>

                    {{-- Inline Result Entry Form --}}
                    <tr class="result-form" id="form-{{ $app->id }}">
                        <td colspan="10" style="padding:0;">
                            <div class="result-form-inner">
                                <form method="POST"
                                      action="{{ route('admin.exams.results.save', $app->id) }}"
                                      id="save-form-{{ $app->id }}">
                                    @csrf
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label>Marks Obtained</label>
                                            <input type="number" name="marks_obtained" min="0"
                                                   value="{{ old('marks_obtained', $app->marks_obtained) }}"
                                                   id="marks_{{ $app->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Total Marks</label>
                                            <input type="number" name="total_marks" min="1"
                                                   value="{{ old('total_marks', $app->total_marks) }}"
                                                   id="total_{{ $app->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Grade</label>
                                            <input type="text" name="grade" maxlength="10"
                                                   value="{{ old('grade', $app->grade) }}"
                                                   placeholder="A / B+ / Distinction…">
                                        </div>
                                        <div class="form-group">
                                            <label>Result Outcome *</label>
                                            <select name="result_status" required>
                                                <option value="pending" {{ ($app->result_status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="passed"  {{ ($app->result_status ?? '') === 'passed'  ? 'selected' : '' }}>Pass</option>
                                                <option value="failed"  {{ ($app->result_status ?? '') === 'failed'  ? 'selected' : '' }}>Fail</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Winner Rank (1–6)</label>
                                            <input type="number" name="winner_rank" min="1" max="6"
                                                   value="{{ old('winner_rank', $app->winner_rank) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Prize Title</label>
                                            <input type="text" name="prize_title_won" maxlength="255"
                                                   value="{{ old('prize_title_won', $app->prize_title_won) }}"
                                                   placeholder="Gold Trophy / Silver…">
                                        </div>
                                        <div class="form-group" style="grid-column:span 2;">
                                            <label>Remarks</label>
                                            <textarea name="result_remarks" rows="2" maxlength="1000">{{ old('result_remarks', $app->result_remarks) }}</textarea>
                                        </div>
                                        <div class="form-group" style="display:flex;align-items:center;gap:6px;padding-top:14px;">
                                            <input type="checkbox" name="show_on_winners_wall" value="1"
                                                   id="winners_{{ $app->id }}"
                                                   {{ $app->show_on_winners_wall ? 'checked' : '' }}>
                                            <label for="winners_{{ $app->id }}" style="font-size:11px;text-transform:none;">Show on Winners Wall</label>
                                        </div>
                                    </div>

                                    {{-- Validation: marks <= total --}}
                                    <p class="form-error" id="marks-error-{{ $app->id }}" style="display:none;">
                                        Marks obtained cannot exceed total marks.
                                    </p>

                                    <div class="form-actions">
                                        <button type="submit" class="btn-save"
                                                onclick="return validateMarks({{ $app->id }})">
                                            Save Draft
                                        </button>
                                        <span class="link-cancel" onclick="toggleForm('form-{{ $app->id }}', null)">Cancel</span>
                                        <span style="font-size:10px;color:var(--gray-light);margin-left:auto;">
                                            Result saved as Draft. Use "Publish Results" above to make it visible to candidates.
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="padding:40px;text-align:center;color:var(--gray-light);">
                            <div style="font-size:13px;font-weight:600;">No candidates registered for this exam.</div>
                            <div style="font-size:11px;margin-top:4px;">Candidates register via the public exam application form.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($applications->hasPages())
        <div class="rd-pagination">
            <span>Showing {{ $applications->firstItem() }}–{{ $applications->lastItem() }} of {{ $applications->total() }} candidates</span>
            <div>{{ $applications->links() }}</div>
        </div>
        @endif
    </div>

</div>

{{-- Publish Confirmation Modal --}}
<div class="modal-overlay" id="publish_modal">
    <div class="modal-box">
        <h3>Publish Examination Results</h3>
        <p>You are about to publish results for:</p>
        <p style="font-weight:700;color:#111;">{{ $exam->exam_title }}</p>
        <p>
            <strong>{{ $stats['total'] }}</strong> candidate result(s) will become visible to candidates on
            <a href="{{ route('exam.results_portal') }}" target="_blank" style="color:var(--accent);">/exam-results</a>.
        </p>
        <p class="modal-warn">
            ⚠ Result-announcement notifications will be dispatched to all candidates.<br>
            Email: via {{ config('mail.default', 'log') }} driver
            ({{ config('mail.default') === 'log' ? 'logged to file, not delivered to inbox' : 'configured mailer' }}) |
            WhatsApp: Not configured | In-App: Enabled
        </p>
        <p style="font-size:11px;color:var(--gray-light);">
            Publishing twice will NOT send duplicate notifications — each channel is logged and
            skipped if already sent for this exam.
        </p>
        <div class="modal-actions">
            <form method="POST" action="{{ route('admin.exams.publish_results', $exam->id) }}">
                @csrf
                <button type="submit" class="btn-publish">Publish Results Now</button>
            </form>
            <button type="button" class="btn-secondary" onclick="closePublishModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
    function openPublishModal()  { document.getElementById('publish_modal').classList.add('open'); }
    function closePublishModal() { document.getElementById('publish_modal').classList.remove('open'); }

    // Close modal on overlay click
    document.getElementById('publish_modal').addEventListener('click', function(e) {
        if (e.target === this) closePublishModal();
    });

    function toggleForm(id, btn) {
        const row = document.getElementById(id);
        const isOpen = row.classList.contains('open');
        // Close all open forms first
        document.querySelectorAll('.result-form.open').forEach(r => r.classList.remove('open'));
        if (!isOpen) { row.classList.add('open'); }
    }

    function validateMarks(appId) {
        const marks = parseInt(document.getElementById('marks_' + appId)?.value || 0);
        const total = parseInt(document.getElementById('total_' + appId)?.value || 0);
        const errEl = document.getElementById('marks-error-' + appId);
        if (total > 0 && marks > total) {
            errEl.style.display = 'block';
            return false;
        }
        errEl.style.display = 'none';
        return true;
    }

    // Auto-open form if there were validation errors (Laravel redirects back)
    @if($errors->any())
        // Try to open the form for the submitted application
        @foreach($applications as $app)
            @if(old('marks_obtained') !== null || $errors->has('marks_obtained'))
                // Heuristic: open first form that has an error
            @endif
        @endforeach
    @endif
</script>

@endsection
