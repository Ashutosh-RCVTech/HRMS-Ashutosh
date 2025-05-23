<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response to Your Message</title>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            max-width: 640px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .footer {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .message-container {
            background-color: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin: 1.5rem 0;
        }

        .reply-container {
            padding: 1.5rem;
            border-left: 4px solid #3b82f6;
            background-color: #eff6ff;
            margin: 1.5rem 0;
        }

        .text-primary {
            color: #1e40af;
        }

        .font-semibold {
            font-weight: 600;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2 class="text-primary font-semibold text-2xl">Response to Your Message</h2>
    </div>

    <p class="mb-4">Dear {{ $contact->name }},</p>

    <p class="mb-4">Thank you for contacting us. We've received your message and are pleased to provide you with a
        response.</p>

    <div class="reply-container">
        {!! nl2br(e($contact->reply_message)) !!}
    </div>

    <p class="mb-4">For your reference, here is your original message:</p>

    <div class="message-container">
        <p class="font-semibold mb-2">Subject: {{ $contact->subject }}</p>
        <p class="text-sm mb-2">Sent on: {{ $contact->created_at->format('M d, Y H:i') }}</p>
        <p class="font-semibold mb-2">Your message:</p>
        <p class="whitespace-pre-wrap">{!! nl2br(e($contact->message)) !!}</p>
    </div>

    <p class="mb-4">If you have any further questions or need additional assistance, please don't hesitate to reach
        out to us again.</p>

    <p class="mb-4">Best regards,<br>
        <span class="font-semibold">{{ $contact->replied_by_user->name }}</span><br>
        {{ config('app.name') }} Team
    </p>

    <div class="footer">
        <p class="mb-2">This email was sent in response to your message submitted through our contact form.</p>
        <p class="text-sm">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>

</html>
