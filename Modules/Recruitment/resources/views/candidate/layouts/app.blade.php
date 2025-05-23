<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RCVJob Board')</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'></script>

    <!-- Scripts -->
    @vite(['resources/css/candidate/app.css', 'resources/js/candidate/app.js'])

    <style>
        .input-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-slate-900 transition-colors duration-200 min-h-screen">

    <div class="container mx-auto py-8 space-y-8">
        @include('recruitment::candidate.components.header')

        <div class="mt-24">
            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    @include('recruitment::candidate.components.mobile-menu')

    <script>
        // Clear any existing notifications first
        toastr.clear();

        // Configure Toastr options
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000,
            extendedTimeOut: 2000,
            preventDuplicates: true,
            newestOnTop: true
        };

        // Show notifications only if they exist in the session
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('profile_incomplete'))
            toastr.warning("{{ session('profile_incomplete') }}");
        @endif
    </script>
</body>

</html>
