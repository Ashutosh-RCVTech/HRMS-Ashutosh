@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 dark:bg-slate-800 dark:text-white rounded-xl shadow-md mb-6 p-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-3">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $job->title }}</h1>
                            <span
                                class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $job->status === 'open'
                                    ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                                    : 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $job->user->name }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $job->created_at->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- First Column -->
                <div class="lg:col-span-3 space-y-4">
                    <!-- Job Description -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4 relative">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Job Description</h2>
                        <div id="job-description-container"
                            class="relative overflow-hidden max-h-48 transition-all duration-300">
                            <p id="job-description" class="text-gray-800 dark:text-gray-300 leading-relaxed line-clamp-5">
                                {{ $job->description }}
                            </p>
                            <div id="gradient-overlay"
                                class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white dark:from-slate-800 to-transparent pointer-events-none">
                            </div>
                        </div>
                        <button id="view-more-btn"
                            class="mt-2 text-indigo-600 dark:text-indigo-400 hover:underline text-sm hidden">
                            View More
                        </button>
                    </div>



                </div>

                <!-- Second Column -->
                <div class="space-y-4">
                    <!-- Salary Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Salary Details</h2>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-indigo-600">
                                ₹{{ number_format($job->min_salary) }} - ₹{{ number_format($job->max_salary) }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $job->location_type }}</p>
                        </div>
                    </div>

                    <!-- Job Types and Schedules -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Job Details</h2>
                        <div class="space-y-2">
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400">Job Types</h3>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @forelse($job->jobTypes as $type)
                                        <span
                                            class="px-2 py-1 text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded">
                                            {{ $type->name }}
                                        </span>
                                    @empty
                                        <p class="text-xs text-gray-500">No types</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Details -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Job Locations</h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse($job->locations as $location)
                                <span
                                    class="px-2 py-1 text-xs bg-green-100 dark:bg-primary-900 text-white dark:text-green-300 rounded">
                                    {{ $location->name }}
                                </span>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">No locations specified</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Schedules -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Work Schedules</h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse($job->schedules as $schedule)
                                <span
                                    class="px-2 py-1 text-xs bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded">
                                    {{ $schedule->name }}
                                </span>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">No schedules specified</p>
                            @endforelse
                        </div>
                    </div>
                   
                </div>

                <!-- Third Column -->
                <div class="space-y-4">

                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Additional Details</h2>
                        <div class="space-y-2">
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400">Application Deadline</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $job->application_deadline->format('F d, Y') }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400">Degree Required</h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $job->degree ?? 'Not specified' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Job Overview -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Job Overview</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400">Experience</h3>
                                <p class="text-sm">{{ $job->experience_required }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400">Education</h3>
                                <p class="text-sm">{{ $job->education_level }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Required Skills -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Required Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse($job->skills as $skill)
                                <span
                                    class="px-2 py-1 text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">No specific skills mentioned</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                        <h2 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">Benefits</h2>
                        <div class="grid md:grid-cols-2 gap-2">
                            @forelse($job->benefits as $benefit)
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $benefit->name }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">No benefits specified</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const descriptionContainer = document.getElementById('job-description-container');
            const description = document.getElementById('job-description');
            const viewMoreBtn = document.getElementById('view-more-btn');
            const gradientOverlay = document.getElementById('gradient-overlay');

            let isExpanded = false;

            // Helper to check if content overflows
            function isOverflowing() {
                // 192px is the height for Tailwind's max-h-48
                return description.scrollHeight > 192;
            }

            // Initial check: only show button/gradient if overflowing
            function updateViewMoreVisibility() {
                // Always start collapsed
                descriptionContainer.classList.add('max-h-48');
                descriptionContainer.classList.remove('max-h-full');
                gradientOverlay.classList.add('hidden');
                viewMoreBtn.classList.add('hidden');

                setTimeout(() => {
                    if (isOverflowing()) {
                        // Show collapsed state and show button/gradient
                        descriptionContainer.classList.add('max-h-48');
                        descriptionContainer.classList.remove('max-h-full');
                        gradientOverlay.classList.remove('hidden');
                        viewMoreBtn.classList.remove('hidden');
                        viewMoreBtn.textContent = 'View More';
                        isExpanded = false;
                    } else {
                        // No overflow, keep expanded and hide button/gradient
                        descriptionContainer.classList.remove('max-h-48');
                        descriptionContainer.classList.add('max-h-full');
                        gradientOverlay.classList.add('hidden');
                        viewMoreBtn.classList.add('hidden');
                    }
                }, 50);
            }

            updateViewMoreVisibility();

            viewMoreBtn.addEventListener('click', function() {
                if (!isExpanded) {
                    descriptionContainer.classList.remove('max-h-48');
                    descriptionContainer.classList.add('max-h-full');
                    description.classList.remove('line-clamp-5');
                    gradientOverlay.classList.add('hidden');
                    viewMoreBtn.textContent = 'View Less';
                    isExpanded = true;
                } else {
                    descriptionContainer.classList.add('max-h-48');
                    descriptionContainer.classList.remove('max-h-full');
                    description.classList.add('line-clamp-5');
                    gradientOverlay.classList.remove('hidden');
                    viewMoreBtn.textContent = 'View More';
                    isExpanded = false;
                }
            });
        });
    </script>
@endsection
