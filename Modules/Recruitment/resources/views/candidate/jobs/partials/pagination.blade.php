{{-- {{ $jobs->withQueryString()->links() }} --}}


{{-- 
@if ($jobs->hasPages())
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
    @endif --}}
    
{{-- Updated to use the new pagination method --}}

@if ($jobs->hasPages())
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-700 dark:text-white">
            Showing
            <span class="font-medium">{{ $jobs->count() }}</span>
            of
            <span class="font-medium">{{ $jobs->total() }}</span>
            results
        </p>

        {{-- Loader shown when more jobs are loading --}}
        <div id="loadingIndicator" class="mt-4 hidden">
            <svg class="animate-spin h-6 w-6 text-primary-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>
    </div>
@endif
