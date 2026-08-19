<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ABVHPS Member Directory Export</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 10mm 15mm 10mm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1f2937;
            font-size: 8.5pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }
        .header-container {
            border-bottom: 2.5px solid #ea580c;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .org-title {
            color: #c2410c;
            font-size: 13pt;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            text-align: center;
        }
        .doc-title {
            color: #1e293b;
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 2px 0 0;
            text-align: center;
        }
        .doc-badge {
            background-color: #fff7ed;
            border: 1px solid #fdba74;
            color: #9a3412;
            font-size: 7.5pt;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            display: inline-block;
            margin-top: 3px;
            text-transform: uppercase;
        }
        .meta-table {
            width: 100%;
            margin-top: 6px;
            border-collapse: collapse;
            font-size: 7.5pt;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .meta-table td {
            padding: 4px 8px;
        }
        .meta-label {
            color: #64748b;
            font-weight: bold;
            text-transform: uppercase;
        }
        .meta-val {
            color: #0f172a;
            font-weight: bold;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8pt;
        }
        .data-table th {
            background-color: #ea580c;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 7.5pt;
            letter-spacing: 0.3px;
            padding: 6px 5px;
            border: 1px solid #c2410c;
            text-align: left;
        }
        .data-table td {
            padding: 5px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        .photo-box {
            width: 32px;
            height: 32px;
            border-radius: 3px;
            border: 1px solid #cbd5e1;
            display: block;
            object-fit: cover;
        }
        .no-photo {
            width: 32px;
            height: 32px;
            background-color: #f1f5f9;
            border: 1px dashed #cbd5e1;
            color: #94a3b8;
            font-size: 6pt;
            text-align: center;
            line-height: 32px;
            border-radius: 3px;
        }
        .member-id {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            font-size: 8.5pt;
            color: #047857;
            letter-spacing: 0.5px;
        }
        .footer-note {
            margin-top: 12px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 6px;
            font-size: 6.5pt;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header Block -->
    <div class="header-container">
        <div class="org-title">Akhanda Bharatha Viswa Hindu Parirakshana Samiti</div>
        <div class="doc-title">Member Directory &amp; Area Data Ledger</div>
        <div style="text-align: center;">
            <span class="doc-badge">Authorized Organizational Use Only</span>
        </div>

        <table class="meta-table">
            <tr>
                <td style="width: 50%;">
                    <span class="meta-label">Selected Area Scope:</span> 
                    <span class="meta-val">{{ $areaSummary }}</span>
                </td>
                <td style="width: 25%;">
                    <span class="meta-label">Exported By Vol ID:</span> 
                    <span class="meta-val" style="color: #ea580c; font-family: monospace;">{{ $volunteer->volunteer_id }}</span>
                </td>
                <td style="width: 25%; text-align: right;">
                    <span class="meta-label">Total Records:</span> 
                    <span class="meta-val">{{ $totalRecords }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="meta-label">Generated Timestamp:</span> 
                    <span class="meta-val">{{ $generatedAt }}</span>
                </td>
                <td style="text-align: right;">
                    <span class="meta-label">Classification:</span> 
                    <span class="meta-val" style="color: #b45309;">Confidential</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">#</th>
                <th style="width: 9%; text-align: center;">Photo</th>
                <th style="width: 32%;">Member Full Name</th>
                <th style="width: 12%;">Gender</th>
                <th style="width: 22%;">12-Digit Membership ID</th>
                <th style="width: 20%;">Region / Mandal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $m)
                <tr>
                    <td style="text-align: center; font-weight: bold; color: #64748b;">
                        {{ $m['serial_no'] }}
                    </td>
                    <td style="text-align: center;">
                        @if(!empty($m['photo_base64']))
                            <img src="{{ $m['photo_base64'] }}" class="photo-box" alt="Photo" style="margin: 0 auto;"/>
                        @else
                            <div class="no-photo" style="margin: 0 auto;">Photo</div>
                        @endif
                    </td>
                    <td>
                        <strong style="color: #0f172a; font-size: 8.5pt;">{{ $m['full_name'] }}</strong>
                    </td>
                    <td>
                        <span style="text-transform: capitalize; color: #334155;">{{ $m['gender'] }}</span>
                    </td>
                    <td>
                        <span class="member-id">{{ $m['membership_id'] }}</span>
                    </td>
                    <td style="color: #475569; font-size: 7.5pt;">
                        {{ $m['grama_panchayat'] !== '—' ? $m['grama_panchayat'] . ', ' : '' }}{{ $m['mandal'] !== '—' ? $m['mandal'] : $m['district'] }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                        No approved member records found in this area.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer Security Notice -->
    <div class="footer-note">
        <strong>SECURITY NOTICE:</strong> This document contains authorized ABVHPS organizational member directory records. 
        It is intended strictly for internal seva coordination by verified volunteers. 
        Unauthorized reproduction, distribution, copying, or digital dissemination is strictly prohibited under samiti privacy guidelines.
    </div>

</body>
</html>
