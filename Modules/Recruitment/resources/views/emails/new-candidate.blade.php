<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Our Recruitment Portal</title>
    <style>
        /* Reset and base styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            background-color: #f5f7fb;
            color: #2d3748;
        }

        /* Main container */
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Header styles */
        h1 {
            color: #1a365d;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #4299e1;
            display: inline-block;
        }

        /* Content styling */
        .content {
            margin: 1.5rem 0;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .credentials {
            background: #ebf8ff;
            padding: 1.5rem;
            border-left: 4px solid #4299e1;
            margin: 1.5rem 0;
        }

        .credentials strong {
            color: #2b6cb0;
            display: inline-block;
            min-width: 100px;
        }

        /* Login button styling */
        .login-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #4299e1;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            margin: 1rem 0;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .login-btn:hover {
            background: #3182ce;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 153, 225, 0.3);
        }

        /* Security note */
        .security-note {
            color: #38a169;
            background: #f0fff4;
            padding: 1rem;
            border-radius: 6px;
            border: 1px solid #c6f6d5;
            margin: 1.5rem 0;
            position: relative;
            padding-left: 2.5rem;
        }

        .security-note:before {
            content: "🔒";
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Footer styling */
        .footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            color: #718096;
        }

        /* Responsive design */
        @media (max-width: 640px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome {{ $candidate->name }}! 👋</h1>

        <div class="content">
            <p>Your account has been created successfully. Here are your login details:</p>

            <div class="credentials">
                <p><strong>Email:</strong> {{ $candidate->email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>

            <div class="security-note">
                Please change your password after your first login for security reasons.
            </div>

            <p>Access your personalized dashboard to track your application progress:</p>
            {{-- <a href="{{ route('candidate.login') }}" class="login-btn">
                🚀 Launch Your Dashboard
            </a> --}}
            <a href="{{ route('candidate.dashboard') }}" class="login-btn">
                🚀 Launch Your Dashboard
            </a>
        </div>


    </div>
</body>

</html>
