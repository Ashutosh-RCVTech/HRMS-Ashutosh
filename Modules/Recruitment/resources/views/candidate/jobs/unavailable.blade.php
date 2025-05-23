@extends('recruitment::candidate.layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow rounded-xl p-6 md:p-8 text-center">
        <h2 class="text-2xl font-bold mb-4 text-red-600 dark:text-red-400">This Job Is No Longer Available</h2>
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            We're sorry, but the job you're trying to view is no longer accepting applications or has been removed.
        </p>
        <a href="{{ route('candidate.jobs.index') }}"
           class="inline-block bg-primary-500 hover:bg-primary-600 text-white font-medium px-6 py-2 rounded-lg transition">
            Browse Other Jobs
        </a>
    </div>
@endsection
