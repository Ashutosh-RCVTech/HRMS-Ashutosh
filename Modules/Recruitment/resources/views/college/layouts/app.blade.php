<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RCV College Portal')</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'></script>

    <!-- Scripts -->
    @vite(['resources/css/college/app.css', 'resources/js/college/app.js'])

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
    {{-- Check if it's a guest route or requires authentication --}}
    @php
        $guestRoutes = [
            'college.login',
            'college.register',
            'college.password.request',
            'college.password.reset',
            'college.verification.notice',
        ];
        $currentRouteName = Route::currentRouteName();
        $isGuestRoute = in_array($currentRouteName, $guestRoutes);
    @endphp

    @if ($isGuestRoute)
        {{-- Guest Routes --}}
        <div class="container mx-auto">
            @yield('content')
        </div>
    @else
        {{-- Authenticated Routes --}}
        @auth('college')
            <div class="container mx-auto py-4 space-y-4">
                @include('recruitment::college.components.header')

                <div class="mt-24">
                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>

            @include('recruitment::college.components.mobile-menu')
        @else
            {{-- Redirect to login for protected routes --}}
            <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-slate-900">
                <div class="w-full max-w-md p-8 space-y-6 bg-white dark:bg-slate-800 rounded-xl shadow-md">
                    <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">
                        Please Login to Access the College Portal
                    </h2>
                    <div class="text-center">
                        <a href="{{ route('college.login') }}"
                            class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                            Go to Login
                        </a>
                    </div>
                </div>
            </div>
        @endauth
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toastr configuration
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Show toastr messages
            @if (Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif

            @if (Session::has('info'))
                toastr.info("{{ Session::get('info') }}");
            @endif

            @if (Session::has('warning'))
                toastr.warning("{{ Session::get('warning') }}");
            @endif
        });
    </script>
</body>

</html>
