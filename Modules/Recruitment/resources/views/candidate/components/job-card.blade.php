@if (!empty($job))
    <div
        class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-6 transform transition-transform duration-300 hover:shadow-slate-400">
        <div class="flex justify-between">
            <div>
                <h2 class="text-lg font-medium dark:text-white">{{ $job->title }}</h2>
                <div class="flex items-center mt-1 text-gray-600 dark:text-white">
                    <span class="font-medium">{{ $job->client ?? 'Company Name' }}</span>
                    {{-- if()
                <span>
                    class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors
                    duration-200">
                    Details</span> --}}
                </div>
            </div>
            <img src="{{ asset('images/logo/logo-white.png') }}" class="h-12 w-auto" alt="Company Logo" />
        </div>

        <div class="mt-4 text-gray-600 dark:text-white">
            <span>₹{{ $job->min_salary ?? 'N/A' }} - ₹{{ $job->max_salary ?? 'N/A' }} LPA</span>
        </div>

        <p class="mt-3 text-gray-600 dark:text-white">Experience Required:
            {{ $job->experience_required ?? 'Not Specified' }} Yrs</p>

        <div class="flex flex-wrap gap-2 mt-3">
            @foreach ($job->skills as $skill)
                <span
                    class="text-blue-600 bg-blue-100 dark:bg-blue-900 dark:text-blue-300 px-2 py-1 rounded-md">{{ $skill->name }}</span>
            @endforeach
        </div>

        <div class="flex justify-between items-center mt-4 text-gray-500 dark:text-white">
            <span>{{ $job->created_at->diffForHumans() }}</span>
            <a href="{{ route('candidate.jobs.show', ['id' => $job->id]) }}"
                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Details
            </a>
        </div>
    </div>
@endif
