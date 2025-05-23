<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Invitation - {{ $placement->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #4f46e5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .placement-details {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6b7280;
            font-size: 12px;
        }

        .profile-reminder {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .highlight {
            color: #2d3748;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Placement Invitation: {{ $placement->name }}</h1>
    </div>


    <div class="content">
        <p>Dear {{ $candidate->name }},</p>

        <p>You have been invited to take the following assessment:</p>

        <div class="placement-details">
            <h3>Assessment Details:</h3>
            <p><strong>Placemment:</strong> {{ $placement->name }}</p>

            <p><strong>Total Number Openings:</strong> {{ $placement->no_of_openings }}</p>
            <p><strong>Discription:</strong> {{ $placement->description }}</p>

        </div>

        <div class="profile-reminder">
            <p><strong>Important Notice:</strong> Before proceeding to the MCQ Test, please ensure your profile is fully
                completed. Incomplete profiles may not be considered for further rounds. Also make sure to login with
                the current user credentials.</p>

        </div>

        <div class="placement-details" style="margin-top:20px;">
            <p><strong>Action Required:</strong></p>
            <a href="{{ route('candidate.dashboard') }}" class="button"
                style="background-color: #3b82f6;color:#e5e7eb;text-decoration:none">
                Complete Your Profile
            </a>

        </div>


    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>

    </div>

</body>

</html>
