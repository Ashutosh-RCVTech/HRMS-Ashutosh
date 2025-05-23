<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Reset Your Password</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            width: 100%;
            line-height: 1.5;
        }

        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 45px 0;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .header {
            background-color: #4f46e5;
            padding: 25px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .content {
            padding: 35px 30px;
            color: #374151;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.15s ease-in-out;
        }

        .button:hover {
            background-color: #4338ca;
        }

        .warning {
            border-left: 4px solid #f59e0b;
            padding-left: 15px;
            margin: 30px 0;
            color: #78350f;
        }

        .url-info {
            margin-top: 25px;
            padding: 15px;
            background-color: #f3f4f6;
            border-radius: 6px;
            word-break: break-all;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Reset Your Password</h1>
            </div>
            <div class="content">
                <p class="greeting">Hello!</p>

                <p>You are receiving this email because we received a password reset request for your account.</p>

                <div class="button-container">
                    <a href="{{ $resetUrl }}" class="button">Reset Password</a>
                </div>

                <p>This password reset link will expire in 60 minutes.</p>

                <div class="warning">
                    If you did not request a password reset, no further action is required.
                </div>

                <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your
                    web browser:</p>

                <div class="url-info">
                    {{ $resetUrl }}
                </div>

                <p>Thank you,<br>The Team</p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
