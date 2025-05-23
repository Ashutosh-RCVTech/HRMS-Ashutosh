@extends('recruitment::candidate.layouts.app')

@section('title', 'Coming Soon')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="container mx-auto bg-white rounded-lg shadow-md p-6 dark:bg-slate-900">
            <!-- Header Section -->
            {{-- <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Coming Soon!
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                We're working hard to bring you an amazing experience. This feature will be available soon.
            </p>
        </div> --}}

            <!-- Main Card -->
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-xl overflow-hidden">
                <!-- Hero Banner -->
                <div
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-800 px-6 py-8 md:px-10 md:py-12">
                    <div class="flex flex-col items-center text-center justify-center">
                        <div class="mb-6">
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Under Development</h2>
                            <p class="text-blue-100 text-lg">Thanks for your patience while we build something great!</p>
                        </div>
                        <div class="flex-shrink-0">
                            <svg class="h-16 w-16 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="px-6 py-8 md:px-10">
                    <div class="text-center mb-8">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900 mb-6">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Feature Coming Soon</h3>
                        <p class="text-gray-600 dark:text-gray-400">We're working hard to bring you a better experience.</p>
                    </div>

                    <!-- Loading Animation -->
                    <div class="flex justify-center space-x-4 mb-8">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                            <div class="w-3 h-3 bg-blue-500 rounded-full mx-1 animate-pulse" style="animation-delay: 0.2s">
                            </div>
                            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>

                    <!-- Return Button -->
                    <div class="text-center">
                        <a href="{{ route('candidate.dashboard') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Return to Home
                        </a>
                    </div>
                </div>
            </div>

            <!-- Timeline Section (Optional) -->
            {{-- <div class="mt-12">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 text-center">Expected Timeline</h3>
            <div class="space-y-6">
                <div class="flex">
                    <div class="flex flex-col items-center mr-4">
                        <div class="w-4 h-4 bg-blue-600 rounded-full"></div>
                        <div class="h-full w-0.5 bg-blue-200 dark:bg-blue-800"></div>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 flex-1">
                        <h4 class="font-semibold text-blue-600 dark:text-blue-400">Development Phase</h4>
                        <p class="text-gray-600 dark:text-gray-400">Currently in progress</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="flex flex-col items-center mr-4">
                        <div class="w-4 h-4 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                        <div class="h-full w-0.5 bg-blue-200 dark:bg-blue-800"></div>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 flex-1">
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300">Testing Phase</h4>
                        <p class="text-gray-600 dark:text-gray-400">Coming next</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="flex flex-col items-center mr-4">
                        <div class="w-4 h-4 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 flex-1">
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300">Launch</h4>
                        <p class="text-gray-600 dark:text-gray-400">Coming soon</p>
                    </div>
                </div>
            </div>
        </div> --}}
        </div>
    </div>
@endsection
