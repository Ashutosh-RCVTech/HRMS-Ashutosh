@foreach($jobs as $job)
<div class="job-card border border-gray-200 rounded-lg p-6 hover:shadow-md transition-all duration-200 dark:bg-slate-900 cursor-pointer relative group"
    data-job-id="{{ $job->id }}">
    <div
        class="absolute inset-0 border-2 border-transparent group-hover:border-primary-100 transition-all duration-200 pointer-events-none opacity-0 selection-indicator">
    </div>

    <div class="flex flex-col md:flex-row gap-4">
        <!-- Company Logo -->
        <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center">
            <!-- Logo Logic -->
            @if($job->company_logo)
            <img src="{{ $job->company_logo }}" alt="{{ $job->client }}" class="max-w-full max-h-full">
            @else
            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                {{ substr($job->client, 0, 1) }}
            </div>
            @endif
        </div>

        <!-- Job Details (Middle) -->
        <div class="flex-1">
            <!-- Job Title and Bookmark -->
            <div class="flex justify-between items-start">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <a href="{{ route('candidate.jobs.show', $job->id) }}" class="hover:text-primary-600">
                        {{ $job->title }}
                    </a>
                </h3>
                {{-- <button class="bookmark-job" data-job-id="{{ $job->id }}">
                    <svg
                        class="w-6 h-6 {{ $job->isBookmarkedByCandidate(Auth::guard('candidate')->id()) ? 'text-primary-600 fill-current' : 'text-gray-400' }}"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </button> --}}
            </div>

            <!-- Company Name -->
            <p class="text-gray-600 mt-1 dark:text-white">{{ $job->client }}</p>

            <!-- Job Metadata -->
            <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-600 dark:text-white">
                <!-- Experience -->
                <span class="inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ $job->experience_required }} years
                </span>

                <!-- Location -->
                <span class="inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    {{ $job->locations->pluck('name')->join(', ') }}
                </span>

                <!-- Salary -->
                @if($job->min_salary && $job->max_salary)
                <span class="inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    ${{ number_format($job->min_salary) }} - ${{ number_format($job->max_salary) }}
                </span>
                @endif

                <!-- Posted Time -->
                <span class="inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Posted {{ $job->created_at->diffForHumans() }}
                </span>

                <!-- Applicants Count (if available) -->
                @if(isset($job->applicants_count))
                <span class="inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{ $job->applicants_count ?? 'Over 500' }} applicants
                </span>
                @endif
            </div>

            <!-- Skills -->
            @if($job->skills->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($job->skills->take(4) as $skill)
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    {{ $skill->name }}
                </span>
                @endforeach
                @if($job->skills->count() > 4)
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    +{{ $job->skills->count() - 4 }} more
                </span>
                @endif
            </div>
            @endif
        </div>

        <!-- Apply Button (Right Side) -->
        <div class="flex flex-col justify-center items-end space-y-3">
            @auth('candidate')
            @if($job->isAppliedByCandidate(auth()->id()))
            <span class="px-4 py-2 text-sm font-medium text-green-700 bg-green-100 rounded-md">
                Applied
            </span>
            @else
            <a href="{{ route('candidate.jobs.show', $job->id) }}"
                class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors">
                Quick Apply
            </a>
            @endif
            @else
            <a href="{{ route('candidate.jobs.show', $job->id) }}"
                class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors">
                Quick Apply
            </a>
            @endauth

            <!-- Login to check skill match score (if available) -->
            {{-- @if(!Auth::guard('candidate')->check())
            <a href="{{ route('candidate.login') }}" class="text-sm text-primary-600 hover:underline">
                Login to check your skill match score
            </a>
            @endif --}}
        </div>
    </div>
</div>
@endforeach

<style>
    .job-card.selected {
        border-color: rgb(var(--primary-500));
        background-color: rgba(var(--primary-500), 0.05);
    }

    .job-card.selected .selection-indicator {
        border-color: rgb(var(--primary-500));
        opacity: 1 !important;
    }
</style>
