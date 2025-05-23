@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Candidate Details</h1>
                    <div class="flex gap-4">
                        <a href="{{ route('admin.candidates.edit', $candidate->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Edit Candidate
                        </a>
                        <a href="{{ route('admin.candidates.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-medium mb-6">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start space-x-4">
                                @if ($candidate->basicDetail?->profile_image_path)
                                    <img src="{{ asset('storage/' . $candidate->basicDetail->profile_image_path) }}"
                                        alt="Profile Image" class="w-24 h-24 rounded-lg object-cover">
                                @endif
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $candidate->name }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">{{ $candidate->email }}</p>
                                    @if ($candidate->basicDetail?->mobile)
                                        <div class="mt-2">
                                            <span
                                                class="text-gray-600 dark:text-gray-300">{{ $candidate->basicDetail->mobile }}</span>
                                            <span
                                                class="ml-2 px-2 py-1 text-xs font-semibold rounded-full 
                                          {{ $candidate->basicDetail->mobile_verified
                                              ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                                              : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-400' }}">
                                                {{ $candidate->basicDetail->mobile_verified ? 'Verified' : 'Pending' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="space-y-2">
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Location:</span>
                                    {{ $candidate->basicDetail?->location ?? 'N/A' }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Availability:</span>
                                    {{ $candidate->basicDetail?->availability
                                        ? date('M d, Y', strtotime($candidate->basicDetail->availability))
                                        : 'N/A' }}
                                </p>
                                @if ($candidate->basicDetail?->resume_path)
                                    <a href="{{ asset('storage/' . $candidate->basicDetail->resume_path) }}"
                                        class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download Resume
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Career Profile -->
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-medium mb-6">Career Profile</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Current Industry:</span>
                                    {{ $candidate->careerProfile?->current_industry ?? 'N/A' }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Department:</span>
                                    {{ $candidate->careerProfile?->department ?? 'N/A' }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Desired Job Type:</span>
                                    {{ $candidate->careerProfile?->desired_job_type ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Expected Salary:</span>
                                    {{ $candidate->careerProfile?->expected_salary
                                        ? number_format($candidate->careerProfile->expected_salary, 2)
                                        : 'N/A' }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Preferred Work Location:</span>
                                    {{ $candidate->careerProfile?->preferred_work_location ?? 'N/A' }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Preferred Shift:</span>
                                    {{ $candidate->careerProfile?->preferred_shift ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employment History -->
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-medium mb-6">Employment History</h2>
                        @forelse($candidate->employments as $employment)
                            <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $employment->position }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300">{{ $employment->company }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ date('M Y', strtotime($employment->start_date)) }} -
                                    {{ $employment->current ? 'Present' : date('M Y', strtotime($employment->end_date)) }}
                                </p>
                                @if ($employment->description)
                                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                                        {{ $employment->description }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No employment history available.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Education -->
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-xl font-medium mb-6">Education</h2>
                        @forelse($candidate->educations as $education)
                            <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $education->degree }}</h3>
                                <p class="text-gray-600 dark:text-gray-300">{{ $education->institution }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $education->year }}
                                    @if ($education->grade)
                                        - Grade: {{ $education->grade }}
                                    @endif
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No education history available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
