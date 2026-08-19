<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABVHPS Exam Results Announced</title>
    <style>
        body {
            font-family: Georgia, 'Times New Roman', serif;
            background: #f9f7f4;
            margin: 0;
            padding: 0;
            color: #1a1a1a;
        }
        .wrapper {
            max-width: 600px;
            margin: 32px auto;
            background: #ffffff;
            border: 1px solid #e0d8cc;
        }
        .header {
            background: #7c2d12;
            padding: 24px 32px;
            text-align: center;
        }
        .header h1 {
            color: #fef3c7;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin: 0 0 4px 0;
        }
        .header p {
            color: #fcd34d;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 0;
        }
        .body {
            padding: 32px;
        }
        .salutation {
            font-size: 14px;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        .announcement-box {
            background: #fef9f0;
            border-left: 4px solid #b45309;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .announcement-box .label {
            font-size: 10px;
            font-weight: bold;
            color: #78350f;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .announcement-box .value {
            font-size: 14px;
            font-weight: bold;
            color: #1a1a1a;
        }
        .ticket-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 12px 20px;
            margin: 16px 0;
            text-align: center;
        }
        .ticket-box .label {
            font-size: 10px;
            font-weight: bold;
            color: #0369a1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .ticket-box .number {
            font-family: 'Courier New', monospace;
            font-size: 22px;
            font-weight: bold;
            color: #0c4a6e;
            letter-spacing: 3px;
        }
        .body-text {
            font-size: 13px;
            color: #374151;
            line-height: 1.7;
            margin: 16px 0;
        }
        .cta-btn {
            display: block;
            width: fit-content;
            margin: 24px auto;
            background: #b45309;
            color: #ffffff;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 12px 28px;
        }
        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 24px 0;
        }
        .instructions {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.6;
        }
        .footer {
            background: #f3f4f6;
            border-top: 1px solid #e0d8cc;
            padding: 16px 32px;
            text-align: center;
        }
        .footer p {
            font-size: 10px;
            color: #9ca3af;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- Header -->
    <div class="header">
        <h1>Akhanda Bharatha Viswa Hindu Parirakshana Samiti</h1>
        <p>Examination Results — Official Notification</p>
    </div>

    <!-- Body -->
    <div class="body">

        <p class="salutation">Dear <strong>{{ $candidateName }}</strong>,</p>

        <p class="body-text">
            The results for the following examination conducted by ABVHPS have been officially announced and are now available for public viewing.
        </p>

        <div class="announcement-box">
            <div class="label">Examination</div>
            <div class="value">{{ $examTitle }}</div>
        </div>

        <div class="ticket-box">
            <div class="label">Your Hall Ticket Number</div>
            <div class="number">{{ $hallTicketNumber }}</div>
        </div>

        <p class="body-text">
            You may view your result by visiting the ABVHPS Exam Results portal and entering your Hall Ticket Number.
        </p>

        <a href="{{ $resultsUrl }}" class="cta-btn">View Your Result</a>

        <hr class="divider">

        <p class="instructions">
            To view your result:<br>
            1. Visit the ABVHPS Exam Results page using the link above.<br>
            2. Enter your 11-digit Hall Ticket Number: <strong>{{ $hallTicketNumber }}</strong><br>
            3. Your result will be displayed immediately.<br><br>
            If you experience any difficulty, please contact the ABVHPS Examination Desk.
        </p>

        <hr class="divider">

        <p class="body-text">
            Regards,<br>
            <strong>ABVHPS Examination Administration</strong><br>
            Akhanda Bharatha Viswa Hindu Parirakshana Samiti
        </p>

    </div>

    <!-- Footer -->
    <div class="footer">
        <p>ABVHPS Central Examination Board &mdash; Official Communication</p>
        <p style="margin-top:4px;">This is an automated notification. Please do not reply to this email.</p>
    </div>

</div>

</body>
</html>
