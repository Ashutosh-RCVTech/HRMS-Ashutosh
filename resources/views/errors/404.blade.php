@extends("recruitment::candidate.layouts.app")

@section('content')
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow rounded-xl p-6 md:p-8 text-center">
        <h2 class="text-2xl font-bold mb-4 text-red-600 dark:text-red-400">404 - Page Not Found</h2>
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            Oops! The page you're looking for doesn't exist or has been moved.
        </p>
        <a href="{{ route('landing') }}"
           class="inline-block bg-primary-500 hover:bg-primary-600 text-white font-medium px-6 py-2 rounded-lg transition">
            Go to Homepage
        </a>
    </div>
@endsection