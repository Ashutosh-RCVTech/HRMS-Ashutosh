@extends('recruitment::candidate.layouts.app')

@section('content')
    <!-- Container to maintain consistent max-width -->
    <div class="container mx-auto py-8">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div
                class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]">
            </div>
            <div class="relative px-6 py-12 sm:px-12 sm:py-16">
                <div class="max-w-4xl">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                            {{ $job->title }}
                        </h1>
                        <span
                            class="inline-flex px-3 py-1 text-sm font-medium rounded-full whitespace-nowrap
                    {{ $job->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>

                    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6 text-sm text-white/90">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 text-gray-700 dark:text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-gray-800 dark:text-white">{{ $job->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 text-gray-700 dark:text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="text-gray-800 dark:text-white">{{ $job->no_of_openings }} Positions</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 text-gray-700 dark:text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-800 dark:text-white">Posted
                                {{ $job->created_at->format('F d, Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 text-gray-800 dark:text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-800 dark:text-white">{{ $job->application_deadline->diffForHumans() }}
                                deadline</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Overview Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            @foreach ([['title' => 'Experience', 'value' => $job->experience_required . ' Years'], ['title' => 'Education', 'value' => $job->education_level ?? 'Not specified'], ['title' => 'Degree', 'value' => $job->degree ?? 'Not specified'], ['title' => 'Locations', 'value' => $job->locations->pluck('name')->join(', ') ?? 'Not specified']] as $item)
                <div
                    class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
                    <div class="text-sm font-medium text-gray-500 dark:text-white mb-1">{{ $item['title'] }}</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item['value'] }}</div>
                </div>
            @endforeach
        </div>

        <!-- Main Content Grid - Improved layout structure -->
        <div class="grid grid-cols-1 gap-8">
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column - Job Description -->
                <div class="lg:col-span-8 space-y-8 order-1">
                    <!-- Job Description Card -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Job Description
                        </h2>
                        <div class="prose prose-gray dark:text-white max-w-none">
                            <div id="job-description" class="overflow-hidden"
                                style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; max-height: 6em;">
                                {{ $job->description }}
                            </div>
                            <div id="job-description-full" class="hidden">
                                {{ $job->description }}
                            </div>
                            <button id="read-more-btn"
                                class="mt-4 text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 font-medium flex items-center gap-2">
                                <span>Read More</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Work Schedule -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Work Schedule
                        </h2>
                        {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($job->schedules as $schedule)
                                <div
                                    class="px-6 py-4 bg-primary-500/10 dark:bg-primary-500/5 rounded-lg border border-primary-100 dark:border-primary-800 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-900 dark:text-white font-medium">{{ $schedule->name }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-white col-span-full">No schedules specified.</p>
                            @endforelse
                        </div> --}}


                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($job->schedules as $schedule)
                                <div
                                    class="px-4 py-2 w-fit inline-flex items-center gap-2 bg-primary-500/10 dark:bg-primary-500/5 rounded-lg border border-gray-100 dark:border-gray-800">
                                    <svg class="w-5 h-5 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-900 dark:text-white font-medium">{{ $schedule->name }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-white col-span-full">No schedules specified.</p>
                            @endforelse
                        </div>

                    </div>

                    <!-- Required Skills -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Required Skills
                        </h2>
                        <div class="flex flex-wrap gap-3">
                            @forelse($job->skills as $skill)
                                <span
                                    class="px-4 py-2 text-sm font-medium bg-primary-500 text-white rounded-lg border border-primary-100 dark:border-primary-800">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <p class="text-gray-500 dark:text-white">No specific skills mentioned.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column - Job Details -->
                <div class="lg:col-span-4 space-y-8 order-2">
                    <!-- Salary Card -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            {{-- <svg class="w-6 h-6 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> --}}
                            Salary Range
                        </h2>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            ₹{{ number_format($job->min_salary) }} - ₹{{ number_format($job->max_salary) }}
                        </div>
                        <p class="text-gray-500 dark:text-white">Annual salary range</p>
                    </div>

                    <!-- Job Types -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Job Types</h2>
                        <div class="space-y-3">
                            @forelse($job->jobTypes as $type)
                                <div
                                    class="px-4 py-3 bg-gray-50 dark:bg-slate-900 rounded-lg text-gray-700 dark:text-white w-fit inline-flex items-center gap-3 border border-gray-100 dark:border-gray-800">
                                    <svg class="w-5 h-5 text-primary-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $type->name }}
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-white">No job types specified.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            {{-- <svg class="w-6 h-6 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> --}}
                            Benefits
                        </h2>
                        <div class="grid grid-cols-1 gap-4">
                            @forelse($job->benefits as $benefit)
                                <div
                                    class="w-fit inline-flex items-center gap-3 p-4 bg-gray-50 dark:bg-slate-900 rounded-lg border border-gray-100 dark:border-gray-800">
                                    <svg class="w-5 h-5 text-primary-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-gray-700 dark:text-white">{{ $benefit->name }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-white">No benefits specified.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Section - Always at the bottom -->
            {{-- <div class="order-3 col-span-full">
                @if ($job->status == 'open')
                    @auth('candidate')
                        @if (!$job->isAppliedByCandidate(auth('candidate')->id()))
                            <div
                                class="bg-gradient-to-r from-primary-500/10 to-primary-600/10 dark:from-primary-500/5 dark:to-primary-600/5 rounded-xl p-1">
                                <!-- Application Form -->
                                <div class="bg-white dark:bg-slate-900 rounded-lg">
                                    <div class="mx-auto">
                                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">
                                            Apply for this Position
                                        </h2>
                                        <form id="job_application_form" method="POST" class="space-y-8"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Cover Letter -->
                                            <div class="space-y-1">
                                                <label for="cover_letter"
                                                    class="block text-sm font-medium text-gray-700 dark:text-white">
                                                    Cover Letter
                                                </label>
                                                <textarea id="cover_letter" name="cover_letter" rows="6"
                                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-slate-900 dark:border-gray-600 dark:text-white resize-none"
                                                    placeholder="Tell us why you're perfect for this role..." required></textarea>
                                            </div>

                                            <!-- Resume Upload -->
                                            <div class="space-y-4">
                                                <label for="resume"
                                                    class="block text-sm font-medium text-gray-700 dark:text-white">
                                                    Resume
                                                </label>
                                                <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx"
                                                    class="block w-full text-sm text-gray-500 dark:text-white
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-medium
                                    file:bg-primary-50 file:text-primary-700
                                    dark:file:bg-primary-900/30 dark:file:text-primary-300
                                    hover:file:bg-primary-100 dark:hover:file:bg-primary-900/40
                                    transition-colors"
                                                    required />
                                                <p class="text-sm text-gray-500 dark:text-white">
                                                    Accepted formats: PDF, DOC, DOCX (Max 5MB)
                                                </p>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="flex justify-center">
                                                <button type="submit" id="submit_application"
                                                    class="inline-flex items-center justify-center px-8 py-3 bg-gray-300 text-gray-500 font-medium rounded-lg shadow-sm cursor-not-allowed"
                                                    disabled>
                                                    <span>Submit Application</span>
                                                    <svg class="w-5 h-5 ml-2 -mr-1 transition-transform" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-100 dark:bg-slate-900 rounded-xl p-8 text-center">
                                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                                    You have already applied for this position
                                </h2>
                            </div>
                        @endif
                    @else
                        <!-- Login Prompt -->
                        <div class="bg-gray-100 dark:bg-slate-900 rounded-xl p-8 text-center">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                                Please log in to apply
                            </h2>
                            <p class="text-gray-500 dark:text-white mb-4">
                                You need to be logged in to submit an application.
                            </p>
                            <a href="{{ route('candidate.login') }}"
                                class="inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200">
                                Log In
                            </a>
                        </div>
                    @endauth
                @else
                    <div class="bg-gray-100 dark:bg-slate-900 rounded-xl p-8 text-center">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                            Position Closed
                        </h2>
                        <p class="text-gray-500 dark:text-white">
                            This position is no longer accepting new applications.
                        </p>
                    </div>
                @endif
            </div> --}}

            <!-- Application Section - Always at the bottom -->
            <div class="order-3 col-span-full">
                @if ($job->status == 'open')
                    @auth('candidate')
                        @if (!$job->isAppliedByCandidate(auth('candidate')->id()))
                            <div
                                class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                                <!-- Application Form -->
                                <div class="p-8 sm:p-10">
                                    <div class="text-center mb-8">
                                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                            Apply for this Position
                                        </h2>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            Complete the form below to submit your application
                                        </p>
                                    </div>

                                    <form id="job_application_form" method="POST" class="space-y-6"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <!-- Cover Letter -->
                                        {{-- <div>
                                            <label for="cover_letter" class="block text-2xl font-semibold text-gray-900 dark:text-white font-medium mb-2">
                                                Cover Letter <span class="text-red-500">*</span>
                                            </label>
                                            <textarea id="cover_letter" name="cover_letter" rows="5"
                                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                                placeholder="Tell us why you're the perfect candidate for this role..." required></textarea>
                                        </div> --}}

                                        <div class="mb-6">
                                            <label for="cover_letter"
                                                class="block text-2xl font-semibold text-gray-900 dark:text-white font-medium mb-2">
                                                Cover Letter <span class="text-red-500">*</span>
                                            </label>
                                            <textarea id="cover_letter" name="cover_letter" rows="5"
                                                class="block w-full px-5 py-4 rounded-2xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white placeholder-gray-400 shadow-sm focus:ring-4 focus:ring-primary-500/40 focus:border-primary-500 focus:outline-none transition-all duration-300 ease-in-out"
                                                placeholder="Tell us why you're the perfect candidate for this role..." required></textarea>
                                        </div>


                                        <!-- Resume Upload -->
                                        <div>
                                            <label for="resume"
                                                class="block text-2xl font-semibold text-gray-900 dark:text-white font-medium mb-2">
                                                Resume <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex items-center gap-4">
                                                <label class="flex-1 cursor-pointer">
                                                    <span class="sr-only">Choose resume file</span>
                                                    <input type="file" id="resume" name="resume"
                                                        accept=".pdf,.doc,.docx"
                                                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                            file:mr-4 file:py-2.5 file:px-4
                                                            file:rounded-lg file:border-0
                                                            file:text-sm file:font-medium
                                                            file:bg-primary-500/10 file:text-primary-700 dark:file:text-primary-400
                                                            hover:file:bg-primary-500/20 dark:hover:file:bg-primary-500/10
                                                            transition-colors"
                                                        required />
                                                </label>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                Accepted formats: PDF, DOC, DOCX (Max 5MB)
                                            </p>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="pt-4">
                                            <button type="submit" id="submit_application"
                                                class="w-full flex justify-center items-center px-6 py-3.5 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                                disabled>
                                                <span id="submit-text">Submit Application</span>
                                                <svg id="submit-spinner" class="hidden w-5 h-5 ml-2 animate-spin"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                <svg id="submit-arrow" class="w-5 h-5 ml-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div
                                class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-8 text-center">
                                <div class="mx-auto max-w-md">
                                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                                        Application Submitted
                                    </h2>
                                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                                        You've already applied for this position. We'll review your application and get back to
                                        you soon.
                                    </p>
                                    <div class="mt-6">
                                        <a href="{{ route('candidate.applications') }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            View My Applications
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Login Prompt -->
                        <div
                            class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-8 text-center">
                            <div class="mx-auto max-w-md">
                                <svg class="mx-auto h-12 w-12 text-primary-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                                    Login to Apply
                                </h2>
                                <p class="mt-2 text-gray-600 dark:text-gray-400">
                                    You need to be logged in to submit an application for this position.
                                </p>
                                <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">
                                    <a href="{{ route('candidate.login') }}"
                                        class="inline-flex justify-center items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                        Sign In
                                    </a>
                                    <a href="{{ route('candidate.register') }}"
                                        class="inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg shadow-sm text-gray-700 dark:text-white bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                        Create Account
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endauth
                @else
                    <div
                        class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-8 text-center">
                        <div class="mx-auto max-w-md">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                                Position Closed
                            </h2>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">
                                This position is no longer accepting applications. Check out our other open positions.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('candidate.jobs.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Browse Jobs
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Job Overview</h2>
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Required Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach (explode(',', $job->required_skills) as $skill)
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-sm text-gray-800 dark:text-gray-200">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Job Details</h3>
                    <div class="space-y-2">
                        <p><span class="font-medium">Experience:</span> {{ $job->experience_required }}</p>
                        <p><span class="font-medium">Location:</span> {{ $job->location_type }}</p>
                        <p><span class="font-medium">Salary Range:</span> {{ $job->min_salary }} - {{ $job->max_salary }}</p>
                        <p><span class="font-medium">Education:</span> {{ $job->education_level }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $("#job_application_form").submit(function(e) {
                e.preventDefault();
                let form = $(this)[0];
                let data = new FormData(form);

                $.ajax({
                    url: "{{ route('candidate.jobs.apply', $job->id) }}",
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = response.redirect;
                        } else {
                            toastr.error(response.message || 'Failed to apply.');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'An error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        toastr.error(errorMsg);
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const coverLetter = document.getElementById('cover_letter');
            const resumeUpload = document.getElementById('resume');
            const submitButton = document.getElementById('submit_application');

            function validateForm() {
                const coverLetterFilled = coverLetter.value.trim().length > 0;
                const resumeUploaded = resumeUpload.files.length > 0;

                if (coverLetterFilled && resumeUploaded) {
                    submitButton.disabled = false;
                    submitButton.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                    submitButton.classList.add('bg-primary-500', 'hover:bg-primary-600', 'text-white');
                } else {
                    submitButton.disabled = true;
                    submitButton.classList.remove('bg-primary-500', 'hover:bg-primary-600', 'text-white');
                    submitButton.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                }
            }

            coverLetter.addEventListener('input', validateForm);
            resumeUpload.addEventListener('change', validateForm);

            // Initial validation
            validateForm();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const readMoreBtn = document.getElementById('read-more-btn');
            const jobDescription = document.getElementById('job-description');
            const jobDescriptionFull = document.getElementById('job-description-full');
            let isExpanded = false;

            // Only show read more button if content is truncated
            if (jobDescription.scrollHeight > jobDescription.clientHeight) {
                readMoreBtn.classList.remove('hidden');
            } else {
                readMoreBtn.classList.add('hidden');
            }

            readMoreBtn.addEventListener('click', function() {
                isExpanded = !isExpanded;
                if (isExpanded) {
                    jobDescription.style.display = 'none';
                    jobDescriptionFull.style.display = 'block';
                    readMoreBtn.innerHTML = `
                        <span>Read Less</span>
                        <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    `;
                } else {
                    jobDescription.style.display = '-webkit-box';
                    jobDescriptionFull.style.display = 'none';
                    readMoreBtn.innerHTML = `
                        <span>Read More</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    `;
                }
            });
        });
    </script>
@endsection
