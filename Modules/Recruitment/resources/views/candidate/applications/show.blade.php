@extends('recruitment::candidate.layouts.app')

@section('title', 'Application Details')
@section('content')
    <div class="py-8 dark:bg-slate-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with breadcrumb -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Application Details</h1>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <a href="{{ route('candidate.applications.index') }}"
                            class="hover:text-blue-600 dark:hover:text-blue-400">Applications</a>
                        <span class="mx-2">›</span>
                        <span>Details</span>
                    </div>
                </div>
                <a href="{{ route('candidate.applications.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-white bg-white dark:bg-slate-800 hover:bg-gray-50 hover:dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Applications
                </a>
            </div>

            <!-- Main content card -->
            <div
                class="bg-white dark:bg-slate-900 shadow-lg rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Header with job title and status -->
                <div
                    class="px-6 py-5 sm:px-8 bg-gradient-to-r from-blue-50 to-white dark:from-slate-800 dark:to-slate-900 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl leading-6 font-semibold text-gray-900 dark:text-white">
                            {{ $application->job->title }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-600 dark:text-gray-400">
                            <span class="inline-flex items-center">
                                <svg class="h-4 w-4 mr-1 text-gray-500 dark:text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ $application->job->client }}
                            </span>
                        </p>
                    </div>
                    <div>
                        @php
                            $statusClasses = [
                                'pending' =>
                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 border-yellow-200 dark:border-yellow-700',
                                'screening' =>
                                    'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 border-blue-200 dark:border-blue-700',
                                'interview' =>
                                    'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100 border-purple-200 dark:border-purple-700',
                                'offered' =>
                                    'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 border-green-200 dark:border-green-700',
                                'rejected' =>
                                    'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 border-red-200 dark:border-red-700',
                                'withdrawn' =>
                                    'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600',
                            ];
                            $statusClass =
                                $statusClasses[$application->status] ??
                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600';
                        @endphp
                        <span
                            class="px-4 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full border {{ $statusClass }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>

                <!-- Application details -->
                <div>
                    <dl>
                        <!-- Job Location -->
                        <div class="bg-gray-50 dark:bg-slate-800 px-6 py-5 sm:px-8 sm:grid sm:grid-cols-3 sm:gap-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="mr-2 h-5 w-5 text-gray-400 dark:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Job Location
                            </dt>
                            <dd class="mt-3 sm:mt-0 sm:col-span-2">
                                <div
                                    class="bg-white dark:bg-slate-900 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition duration-150">
                                    <div class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $application->job->locations->pluck('name')->join(', ') ?: 'Not specified' }}
                                    </div>
                                </div>
                            </dd>
                        </div>

                        <!-- Application Date -->
                        <div class="bg-white dark:bg-slate-900 px-6 py-5 sm:px-8 sm:grid sm:grid-cols-3 sm:gap-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="mr-2 h-5 w-5 text-gray-400 dark:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Application Date
                            </dt>
                            <dd class="mt-3 text-base text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                {{ $application->created_at->format('F d, Y') }}
                            </dd>
                        </div>

                        <!-- Last Updated -->
                        <div class="bg-gray-50 dark:bg-slate-800 px-6 py-5 sm:px-8 sm:grid sm:grid-cols-3 sm:gap-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="mr-2 h-5 w-5 text-gray-400 dark:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Last Updated
                            </dt>
                            <dd class="mt-3 text-base text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                {{ $application->updated_at->format('F d, Y') }}
                            </dd>
                        </div>

                        <!-- Job Description -->
                        <div class="bg-white dark:bg-slate-900 px-6 py-5 sm:px-8 sm:grid sm:grid-cols-3 sm:gap-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-start pt-1">
                                <svg class="mr-2 h-5 w-5 text-gray-400 dark:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Job Description
                            </dt>
                            <dd class="mt-3 sm:mt-0 sm:col-span-2">
                                <div
                                    class="prose dark:prose-invert max-w-none p-5 bg-gray-50 dark:bg-slate-800 dark:text-white rounded-lg">
                                    {!! $application->job->description !!}
                                </div>
                            </dd>
                        </div>

                        <!-- Cover Letter (if exists) -->
                        @if ($application->cover_letter)
                            {{-- <div class="bg-gray-50 dark:bg-slate-800 px-6 py-5 sm:px-8 sm:grid sm:grid-cols-3 sm:gap-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-start pt-1">
                                    <svg class="mr-2 h-5 w-5 text-gray-400 dark:text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Your Cover Letter
                                </dt>
                                <dd class="mt-3 sm:mt-0 sm:col-span-2">
                                    <div
                                        class="prose dark:prose-invert max-w-none p-5 bg-white dark:bg-slate-900 dark:text-white rounded-lg border border-gray-100 dark:border-gray-800">
                                        {!! nl2br(e($application->cover_letter)) !!}
                                    </div>
                                </dd>
                            </div> --}}
                            <div
                                class="bg-gray-50 dark:bg-slate-800 px-4 py-5 sm:px-6 md:px-8 sm:grid sm:grid-cols-3 sm:gap-6 rounded-xl shadow-sm">
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-start gap-2 sm:col-span-1">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mt-0.5 shrink-0"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>Your Cover Letter</span>
                                </dt>
                                <dd class="mt-4 sm:mt-0 sm:col-span-2">
                                    <div
                                        class="prose dark:prose-invert max-w-none p-5 rounded-xl bg-white dark:bg-slate-900 dark:text-white border border-gray-200 dark:border-gray-800 shadow-sm transition-all duration-300">
                                        {!! nl2br(e($application->cover_letter)) !!}
                                    </div>
                                </dd>
                            </div>
                        @endif

                        <!-- Resume (if exists) -->
                        @if ($application->resume_path)
                            <div class="bg-white dark:bg-slate-900 px-6 py-5 sm:px-8 sm:grid sm:grid-cols-3 sm:gap-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <svg class="mr-2 h-5 w-5 text-gray-400 dark:text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Resume
                                </dt>
                                <dd class="mt-3 sm:mt-0 sm:col-span-2">
                                    <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        View Resume
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Action buttons -->
                @if ($application->status !== 'withdrawn' && $application->status !== 'rejected' && $application->status !== 'closed')
                    <div
                        class="px-6 py-5 sm:px-8 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800">
                        <div class="flex justify-end">
                            <form action="{{ route('candidate.applications.withdraw', $application->id) }}"
                                method="POST" id="withdraw-form">
                                @csrf
                                <button type="button" id="withdraw-button"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-white bg-white dark:bg-slate-800 hover:bg-gray-50 hover:dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Withdraw Application
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        console.log('Script section loaded');
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            const withdrawButton = document.getElementById('withdraw-button');
            const withdrawForm = document.getElementById('withdraw-form');

            console.log('Withdraw button:', withdrawButton);
            console.log('Withdraw form:', withdrawForm);

            if (withdrawButton && withdrawForm) {
                console.log('Adding event listener');
                withdrawButton.addEventListener('click', function() {
                    console.log('Button clicked');
                    if (confirm(
                            'Are you sure you want to withdraw this application? This action cannot be undone.'
                        )) {
                        console.log('Submitting form');
                        withdrawForm.submit();
                    }
                });
            }
        });
    </script>
@endsection
