<div class="container mx-auto p-4 dark:bg-slate-900">
    <div class="mb-8 flex flex-wrap items-center justify-between">
        <div class="w-full md:w-1/2">
            <h1 class="text-3xl font-bold text-black dark:text-white">
                {{ $job->title }}
            </h1>

            @auth('candidate')
                <div class="mt-2">
                    <span class="text-sm text-gray-600 dark:text-white">
                        {{ $job->job_type }}
                    </span>
                </div>
            @endauth
        </div>

        <div class="mt-4 w-full md:mt-0 md:w-1/4">
            @if ($job->company_logo)
                <img src="{{ asset($job->client_logo_path) }}" alt="{{ $job->client }} logo"
                    class="h-20 w-20 rounded-lg object-contain dark:bg-white p-2">
            @endif
        </div>
    </div>

    <div class="mb-8 rounded-lg bg-white p-6 shadow-sm dark:bg-slate-900">
        <div class="mb-4 flex items-center">
            <h2 class="text-xl font-semibold text-black dark:text-white">
                {{ $job->client }}
            </h2>
            <span class="mx-4 text-gray-400">•</span>
            <p class="text-gray-600 dark:text-white">
                {{ $job->locations->pluck('name')->join(', ') }}
            </p>
        </div>

        <div class="flex items-center text-gray-600 dark:text-white">
            <span class="mr-2 font-medium">Experience:</span>
            <span>{{ $job->experience_required }} years</span>
        </div>
    </div>

    <div class="mb-8 rounded-lg bg-white p-6 shadow-sm dark:bg-slate-900">
        <h2 class="mb-4 text-2xl font-bold text-black dark:text-white">
            Job Description
        </h2>
        <div class="prose text-gray-700 dark:text-white">
            {!! $job->description !!}
        </div>
    </div>

    <!-- Skills -->
    <div class="mb-8 rounded-lg bg-white p-6 shadow-sm dark:bg-slate-900">
        <h2 class="mb-4 text-2xl font-bold text-black dark:text-white">
            Required Skills
        </h2>
        @if ($job->skills->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach ($job->skills->take(4) as $skill)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $skill->name }}
                    </span>
                @endforeach
                @if ($job->skills->count() > 4)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        +{{ $job->skills->count() - 4 }} more
                    </span>
                @endif
            </div>
        @endif
    </div>

    <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-slate-900">
        @auth('candidate')
            @if ($job->application)
                <button class="cursor-not-allowed rounded-lg bg-green-100 px-6 py-3 text-green-600" disabled>
                    ✓ Applied {{ $job->application->created_at->diffForHumans() }}
                </button>
            @else
                <a href="{{ route('candidate.jobs.show', $job->id) }}"
                    class="rounded-lg bg-blue-600 px-6 py-3 text-white transition hover:bg-blue-700 dark:bg-darkblack-700 dark:hover:bg-darkblack-600">
                    ⚡ Quick Apply Now
                </a>
            @endif
        @else
            <div class="space-y-4">
                <a href="{{ route('candidate.login') }}"
                    class="inline-block rounded-lg bg-blue-600 px-6 py-3 text-white transition hover:bg-blue-700 dark:bg-darkblack-700 dark:hover:bg-darkblack-600">
                    🔒 Login to Apply
                </a>

                <p class="text-gray-600 dark:text-white">
                    Don't have an account?
                    <a href="{{ route('candidate.register') }}"
                        class="text-blue-600 underline transition hover:text-blue-700 dark:text-blue-400">
                        Register here
                    </a>
                </p>
            </div>
        @endauth
    </div>
</div>
