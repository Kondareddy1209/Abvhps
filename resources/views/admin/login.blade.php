<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ABVHPS - Central Admin Security Gate</title>
    
    <!-- Pure Built-in Structural Stylesheet to prevent layout scattering without internet -->
    <style>
        body {
            background-color: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-h: 100vh;
            min-height: 100vh;
        }
        .login-wrapper {
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }
        .branding-title {
            color: #ea580c;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 1px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .branding-sub {
            color: #6b7280;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin: 0 0 25px 0;
            text-transform: uppercase;
        }
        .form-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }
        .form-header {
            text-align: center;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .form-header h2 {
            color: #1f2937;
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }
        .form-header p {
            color: #9ca3af;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 4px 0 0 0;
        }
        .input-group {
            margin-bottom: 16px;
        }
        .input-label {
            display: block;
            color: #4b5563;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            font-weight: 500;
            color: #111827;
            background-color: #ffffff;
            outline: none;
        }
        .form-control:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 2px rgba(234, 88, 12, 0.15);
        }
        .password-container {
            position: relative;
        }
        .eye-toggle-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
            outline: none;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
            margin-bottom: 20px;
        }
        .btn-submit {
            width: 100%;
            background-color: #ea580c;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background-color 0.2s;
            box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.2);
        }
        .btn-submit:hover {
            background-color: #d97706;
        }
        .btn-submit:active {
            transform: scale(0.99);
        }
        .alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #dc2626;
            border-radius: 8px;
            padding: 12px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .footer-text {
            text-align: center;
            margin-top: 24px;
            color: #9ca3af;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        
        <div style="text-align: center;">
            <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; margin: 0 auto 6px auto; display: block; border: 2px solid #E65100;" alt="ABVHPS Logo">
            <h1 class="branding-title">Akhanda Bharata</h1>
            <p class="branding-sub">Viswa Hindu Parirakshana Samiti</p>
        </div>

        <!-- Central Form Block -->
        <div class="form-card">
            <div class="form-header">
                <h2>Administrative Gate Entrance</h2>
                <p>Initialize Secure Commander Session</p>
            </div>

            <!-- Error Alerts Block -->
            @if($errors->any())
                <div class="alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form Submissions Pipelines -->
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <!-- Input Group 1: Email -->
                <div class="input-group">
                    <label class="input-label">Administrative Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="admin@abvhps.org">
                </div>

                <!-- Input Group 2: Password with Eye Toggle -->
                <div class="input-group">
                    <label class="input-label">Security Password *</label>
                    <div class="password-container">
                        <input type="password" id="security_passphrase_input" name="password" required class="form-control" placeholder="••••••••">
                        <button type="button" onclick="togglePassphraseVisibilityEye()" class="eye-toggle-btn" id="eye_icon_toggle_node" title="Show Password">
                            👁️
                        </button>
                    </div>
                </div>

                <!-- Remember Cookie Option -->
                <div class="checkbox-container">
                    <input type="checkbox" id="remember_checkbox" name="remember" style="margin: 0; cursor: pointer;">
                    <label Bres-mode for="remember_checkbox" style="cursor: pointer; user-select: none;">Remember Device Context</label>
                </div>

                <!-- Submit Action Trigger -->
                <button type="submit" class="btn-submit">
                    Login to Dashboard
                </button>
            </form>
        </div>

        <!-- Footer Meta Nodes -->
        <div class="footer-text">
            ABVHPS Central Security Mesh © 2026
        </div>

    </div>

    <!-- ====================================================================== -->
    <!-- JAVASCRIPT PASSPHRASE VISIBILITY TOGGLE CONTROLLER ENGINE -->
    <!-- ====================================================================== -->
    <script>
        function togglePassphraseVisibilityEye() {
            const passwordInput = document.getElementById('security_passphrase_input');
            const eyeIconNode = document.getElementById('eye_icon_toggle_node');
            
            if (!passwordInput || !eyeIconNode) return;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIconNode.innerText = '🙈'; // Dynamic Closed Eye status graphics
                eyeIconNode.setAttribute('title', 'Hide Password');
            } else {
                passwordInput.type = 'password';
                eyeIconNode.innerText = '👁️'; // Open Eye normal graphics
                eyeIconNode.setAttribute('title', 'Show Password');
            }
        }
    </script>

</body>
</html>
