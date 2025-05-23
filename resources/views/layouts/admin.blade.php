<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RCVJobBoard') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'></script>

    <!-- Scripts -->
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])

    <style>
        .toast-top-right {
            top: 70px !important;
            right: 12px !important;
            z-index: 9999 !important;
        }
        .toast-error, .toast-success, .toast-info, .toast-warning {
            background-color: #fff !important;
            color: #000 !important;
        }
        .toast-error {
            border-left: 4px solid #dc3545 !important;
        }
        .toast-success {
            border-left: 4px solid #28a745 !important;
        }
        .toast-info {
            border-left: 4px solid #17a2b8 !important;
        }
        .toast-warning {
            border-left: 4px solid #ffc107 !important;
        }
    </style>
</head>

<body class="dark:bg-slate-900 dark:text-white h-screen">
    <div class="layout-wrapper active w-full dark:bg-slate-900 flex flex-col">

        <div class="relative flex w-full dark:bg-slate-900 dark:text-white">
            <x-sidebar />

            <!-- Header -->
            @include('layouts.header')

            <!-- Main Content Area -->
            @yield('content')

        </div>
    </div>

    {{-- <script type="module" src="{{ asset('js/admin/app.js') }}"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toastr configuration
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": false
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
