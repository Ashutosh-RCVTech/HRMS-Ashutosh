<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RCVJobBoard') }}</title>
    <link href="
    https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css
    " rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'></script>
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])



    {{-- <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet"> --}}

</head>

<body>
    {{ $slot }}

    {{-- <script type="module" src="{{ asset('js/admin/app.js') }}"></script> --}}

    <script>
        // Check for any validation errors and display them with toastr
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif

        // Display success message if exists
        @if (session('status'))
            toastr.success('{{ session('status') }}');
        @endif
    </script>

</body>

</html>
