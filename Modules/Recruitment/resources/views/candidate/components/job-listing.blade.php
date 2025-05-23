{{-- <div class="flex-1">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 dark:bg-slate-900">
        <h2 class="text-xl font-bold dark:text-white mb-4 sm:mb-0">Recommended jobs <span
                class="text-primary-500">{{ count($jobs ?? []) }}</span></h2>
        <div class="flex items-center gap-2">
            <span class="text-gray-500 dark:text-white">Sort by:</span>
            <select class="bg-transparent dark:text-white">
                <option>Last updated</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($jobs ?? [] as $job)
            @include('recruitment::candidate.components.job-card', ['job' => $job])
        @empty
            <div class="col-span-3 text-center py-8 text-gray-500 dark:text-white">
                No jobs found
            </div>
        @endforelse
    </div>
    <div id="jobListings"></div>
</div> --}}

<div class="flex-1">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 dark:bg-slate-900">
        <h2 class="text-xl font-bold dark:text-white mb-4 sm:mb-0">Recommended jobs <span
                class="text-primary-500">{{ count($jobs ?? []) }}</span></h2>
        <div class="flex items-center gap-2">
            <span class="text-gray-500 dark:text-white">Sort by:</span>
            <select class="bg-transparent dark:text-white">
                <option>Last updated</option>
            </select>
        </div>
    </div>

    <!-- Job Listings Container with Scroll -->
    <div id="jobListings" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[calc(100vh-160px)] overflow-y-auto">
        @foreach ($jobs as $job)
            @include('recruitment::candidate.components.job-card', ['job' => $job])
        @endforeach
    </div>

    <!-- Loading Indicator for AJAX -->
    <div id="loadingMore" class="text-center py-4 text-gray-500 dark:text-white hidden">
        Loading more jobs...
    </div>
</div>

{{-- Pagination (for AJAX) --}}
@if ($jobs instanceof \Illuminate\Pagination\LengthAwarePaginator && $jobs->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        <div class="flex-1 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-white">
                    Showing
                    <span class="font-medium">{{ $jobs->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $jobs->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $jobs->total() }}</span>
                    results
                </p>
            </div>

            <div class="flex items-center space-x-2">
                {{-- Previous Page Link --}}
                @if ($jobs->onFirstPage())
                    <span class="px-4 py-2 text-gray-400 cursor-not-allowed rounded-md">
                        Previous
                    </span>
                @else
                    <a href="{{ $jobs->previousPageUrl() }}"
                       class="px-4 py-2 bg-white dark:bg-slate-900 border border-gray-300 dark:border-darkblack-400 rounded-md text-gray-700 dark:text-white hover:bg-gray-50">
                        Previous
                    </a>
                @endif

                {{-- Next Page Link --}}
                @if ($jobs->hasMorePages())
                    <a href="{{ $jobs->nextPageUrl() }}"
                       class="px-4 py-2 bg-white dark:bg-slate-900 border border-gray-300 dark:border-darkblack-400 rounded-md text-gray-700 dark:text-white hover:bg-gray-50">
                        Next
                    </a>
                @else
                    <span class="px-4 py-2 text-gray-400 cursor-not-allowed rounded-md">
                        Next
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif

<script>
    // Handle infinite scrolling and loading more jobs
    let page = 2; // Start from the second page as first batch is already loaded
    const loadingIndicator = document.getElementById('loadingMore');
    const jobListings = document.getElementById('jobListings');
    let isLoading = false;
    let lastPageReached = false;

    jobListings.addEventListener('scroll', function () {
        if (
            !isLoading &&
            !lastPageReached &&
            jobListings.scrollTop + jobListings.clientHeight >= jobListings.scrollHeight - 50
        ) {
            loadMoreJobs();
        }
    });

    function loadMoreJobs() {
    isLoading = true;
    loadingIndicator.classList.remove('hidden');

    fetch(`/jobs?page=${page}`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                jobListings.insertAdjacentHTML('beforeend', data.html); // Append instead of overwrite
                page++;
                lastPageReached = page > data.lastPage;
            } else {
                lastPageReached = true;
            }
            isLoading = false;
            loadingIndicator.classList.add('hidden');
        })
        .catch(error => {
            console.error('Error loading more jobs:', error);
            isLoading = false;
            loadingIndicator.classList.add('hidden');
        });
}


</script>
