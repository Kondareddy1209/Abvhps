<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rudrasena Volunteer Identity Card</title>
    <style>
        @page {
            size: 350pt 580pt;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f3f4f6;
            -webkit-print-color-adjust: exact;
        }
        .card-container {
            width: 350pt;
            height: 580pt;
            background: #ffffff;
            position: relative;
            box-sizing: border-box;
            border: 2px solid #ea580c;
        }
        .header-strip {
            background-color: #1e293b;
            color: #ffffff;
            padding: 16px 12px;
            text-align: center;
            border-bottom: 4px solid #ea580c;
        }
        .header-title {
            color: #ea580c;
            font-size: 13pt;
            font-weight: 900;
            letter-spacing: 1px;
            margin: 0;
            text-transform: uppercase;
        }
        .header-subtitle {
            color: #cbd5e1;
            font-size: 7.5pt;
            font-weight: bold;
            margin-top: 3px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .badge-pill {
            display: inline-block;
            background-color: #ea580c;
            color: #ffffff;
            font-size: 7pt;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .photo-wrapper {
            text-align: center;
            margin-top: 12px;
        }
        .photo-frame {
            width: 105pt;
            height: 120pt;
            margin: 0 auto;
            border: 3pt solid #ea580c;
            border-radius: 6pt;
            background-color: #f8fafc;
            overflow: hidden;
            display: block;
        }
        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .no-photo {
            line-height: 120pt;
            color: #94a3b8;
            font-size: 9pt;
            font-weight: bold;
        }
        .name-title {
            text-align: center;
            font-size: 12pt;
            font-weight: 900;
            color: #0f172a;
            margin-top: 8px;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .details-table {
            width: 88%;
            margin: 0 auto;
            border-collapse: collapse;
            font-size: 8.5pt;
        }
        .details-table td {
            padding: 3.5pt 0;
            vertical-align: middle;
        }
        .label-cell {
            width: 38%;
            color: #64748b;
            font-weight: 800;
            font-size: 7.5pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .value-cell {
            width: 62%;
            color: #1e293b;
            font-weight: 800;
        }
        .id-highlight {
            color: #ea580c;
            font-weight: 900;
            font-size: 10pt;
            letter-spacing: 1.5px;
        }
        .blood-highlight {
            color: #dc2626;
            font-weight: 900;
        }
        .footer-banner {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #ea580c;
            color: #ffffff;
            text-align: center;
            font-size: 6.5pt;
            font-weight: bold;
            padding: 4px 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <!-- Header Strip -->
        <div class="header-strip">
            <div style="font-size: 16pt; margin-bottom: 2px;">🔱</div>
            <h1 class="header-title">ABVHPS RUDRASENA DAL</h1>
            <div class="header-subtitle">Akhanda Bharatha Viswa Hindu Parirakshana Samiti</div>
            <div class="badge-pill">Official Rudrasena Volunteer Identity Card</div>
        </div>

        <!-- Photo Section -->
        <div class="photo-wrapper">
            <div class="photo-frame">
                @if(!empty($cardData['photo_path']) && file_exists(public_path('storage/' . $cardData['photo_path'])))
                    <img src="{{ public_path('storage/' . $cardData['photo_path']) }}" alt="Photo">
                @elseif(!empty($cardData['photo_base64']))
                    <img src="{{ $cardData['photo_base64'] }}" alt="Photo">
                @else
                    <div class="no-photo">PHOTO</div>
                @endif
            </div>
        </div>

        <!-- Rudrasena Full Name -->
        <div class="name-title">{{ $cardData['full_name'] ?? 'RUDRASENA WARRIOR' }}</div>

        <!-- Mapped Metrics Table -->
        <table class="details-table">
            <tr>
                <td class="label-cell">Rudrasena ID</td>
                <td class="value-cell id-highlight">: {{ $cardData['rudrasena_id'] ?? 'PENDING APPROVAL' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Member ID</td>
                <td class="value-cell">: {{ $cardData['membership_id'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Volunteer Type</td>
                <td class="value-cell">: {{ strtoupper($cardData['volunteer_type'] ?? 'Standard') }}</td>
            </tr>
            <tr>
                <td class="label-cell">Cadder</td>
                <td class="value-cell">: {{ strtoupper($cardData['assigned_cadder'] ?? 'Rudrasena Member') }}</td>
            </tr>
            <tr>
                <td class="label-cell">Locality</td>
                <td class="value-cell">: {{ strtoupper($cardData['assigned_locality'] ?? 'HQ') }}</td>
            </tr>
            <tr>
                <td class="label-cell">Blood Group</td>
                <td class="value-cell blood-highlight">: {{ $cardData['blood_group'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Phone</td>
                <td class="value-cell">: +91 {{ $cardData['mobile'] ?? ($cardData['phone'] ?? 'N/A') }}</td>
            </tr>
        </table>

        <!-- Footer Bottom Line -->
        <div class="footer-banner">
            Official Non-Transferable Identity Card &bull; abvhps.org
        </div>
    </div>
</body>
</html>
