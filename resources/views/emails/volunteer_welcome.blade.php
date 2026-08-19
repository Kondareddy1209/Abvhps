<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to ABVHPS Volunteer Wing</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 24px;
            color: #334155;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #1e293b;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 4px solid #ea580c;
        }
        .header h1 {
            color: #ea580c;
            margin: 0;
            font-size: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header p {
            color: #cbd5e1;
            margin: 5px 0 0;
            font-size: 12px;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .greeting {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .credentials-box {
            background-color: #fff7ed;
            border: 2px solid #fed7aa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .credentials-box h2 {
            margin: 0 0 12px;
            font-size: 14px;
            color: #c2410c;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .credential-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px dashed #fdba74;
            font-size: 13px;
        }
        .credential-row:last-child {
            border-bottom: none;
        }
        .credential-label {
            color: #7c2d12;
            font-weight: 600;
        }
        .credential-value {
            color: #0f172a;
            font-weight: bold;
            font-family: 'Consolas', 'Courier New', monospace;
        }
        .btn-portal {
            display: inline-block;
            background-color: #ea580c;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 15px;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" width="56" height="56" style="border-radius: 50%; object-fit: cover; display: inline-block; margin-bottom: 6px; border: 2px solid #ffffff;" alt="ABVHPS Logo">
            <h1>AKHANDA BHARATHA VISWA HINDU PARIRAKSHANA SAMITI</h1>
            <p>ABVHPS Central Administrative Board</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Namaste {{ $volunteerData['full_name'] ?? 'Volunteer' }},
            </div>
            
            <p>
                Hearty congratulations! Your application for the <strong>ABVHPS Volunteer Wing</strong> has been verified and officially approved by the Central Administrative Board.
            </p>

            <!-- Credentials Box -->
            <div class="credentials-box">
                <h2>🔐 Your Official Volunteer Credentials</h2>
                <div class="credential-row">
                    <span class="credential-label">Volunteer ID:</span>
                    <span class="credential-value" style="color: #ea580c; font-size: 16px; font-weight: bold;">{{ $volunteerData['volunteer_id'] ?? ($volunteerData['formatted_volunteer_id'] ?? 'N/A') }}</span>
                </div>
                <div class="credential-row">
                    <span class="credential-label">Login ID:</span>
                    <span class="credential-value" style="color: #ea580c; font-size: 15px; font-weight: bold;">{{ $volunteerData['volunteer_login_id'] ?? ($volunteerData['volunteer_id'] ?? 'N/A') }}</span>
                </div>
                <div class="credential-row">
                    <span class="credential-label">Default Password:</span>
                    <span class="credential-value" style="color: #047857; font-size: 14px;">{{ $volunteerData['plainPassword'] ?? 'password' }}</span>
                </div>
                <div class="credential-row">
                    <span class="credential-label">Assigned Cadder:</span>
                    <span class="credential-value">{{ $volunteerData['designation'] ?? ($volunteerData['cadre'] ?? 'Volunteer') }}</span>
                </div>
                <div class="credential-row">
                    <span class="credential-label">Assigned Locality:</span>
                    <span class="credential-value">{{ $volunteerData['locality'] ?? 'HQ' }}</span>
                </div>
            </div>

            <p style="font-size: 13px; color: #475569;">
                📎 <strong>Attached:</strong> Your official <strong>Digital PVC Volunteer Identity Card</strong> is attached to this email as a PDF. You may download, print, or present it as proof of your authorized voluntary affiliation.
            </p>

            <div style="text-align: center; margin: 25px 0 10px;">
                <a href="{{ url('/volunteer/login') }}" class="btn-portal">
                    Access Volunteer Portal &rarr;
                </a>
            </div>

            <p style="font-size: 11px; color: #94a3b8; margin-top: 20px;">
                * Please change your password upon your first login to keep your account secure.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; 2026 ABVHPS Central Board. Survey No: 1826, Shanmukhapuram, Porumamilla, Kadapa, AP - 516193.<br>
            Dedicated to the preservation and protection of Sanatana Dharma.
        </div>
    </div>
</body>
</html>
