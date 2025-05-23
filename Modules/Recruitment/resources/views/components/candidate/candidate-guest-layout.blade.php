@props(['title' => 'Candidate Portal'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark:bg-slate-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RCV Recruitment') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset(Vite::asset('resources/css/candidate/app.css')) }}">
    <script src="{{ asset(Vite::asset('resources/js/candidate/app.js')) }}"></script>

</head>

<body class="bg-white min-h-screen dark:bg-slate-900">
    <div class="min-h-screen  bg-darkblack-500">
        {{ $slot }}
    </div>
</body>

</html>
