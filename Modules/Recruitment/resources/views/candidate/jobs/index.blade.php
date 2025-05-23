@extends('layouts.landing')
@section('content')
    <div class="bg-gray-50 min-h-screen mx-auto pt-20 pb-8 dark:bg-slate-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Search Header --}}
            <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mb-6 dark:bg-slate-900">
                <form id="search-form" action="{{ route('candidate.jobs.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Skills/Job Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search"
                                class="w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300 dark:bg-slate-900 dark:text-white"
                                placeholder="Skills, Companies or Job Titles">
                        </div>

                        <!-- Location Input -->
                        {{-- <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                            <select name="location"
                                class="w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300 dark:bg-slate-900 dark:text-white">
                                <option value="">All Locations</option>
                                @foreach ($locations ?? [] as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}


                        <!-- Location Input with Autocomplete -->
                        <div class="relative" x-data="{ open: false, suggestions: [], search: '', locationId: '' }" @click.away="open = false">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>

                            <input type="text" 
                                x-model="search"
                                @input.debounce.300ms="fetchSuggestions"
                                @focus="open = true"
                                class="w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-slate-900 dark:text-white"
                                placeholder="Search location...">

                            <input type="hidden" name="location" :value="locationId">

                            <!-- Suggestions Dropdown -->
                            <ul x-show="open && suggestions.length > 0" class="absolute z-50 w-full bg-white border mt-1 rounded-lg shadow dark:bg-slate-800 max-h-60 overflow-y-auto">
                                <template x-for="item in suggestions" :key="item.id">
                                    <li @click="search = item.name; locationId = item.id; open = false"
                                        class="px-4 py-2 hover:bg-primary-100 dark:hover:bg-slate-700 cursor-pointer dark:text-white">
                                        <span x-text="item.name"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <!-- Experience Dropdown -->
                        <div class="relative">
                            <select name="experience"
                                class="w-full py-3 px-4 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300 dark:bg-slate-900 dark:text-white">
                                <option value="">Experience Level</option>
                                <option value="0-2">0-2 years</option>
                                <option value="2-5">2-5 years</option>
                                <option value="5-8">5-8 years</option>
                                <option value="8+">8+ years</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <button type="submit"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                            <span>Search</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Main Content --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Filters Sidebar --}}
                {{-- <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 sticky top-24 dark:bg-slate-900">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 dark:text-white">Filters</h3>

                        <!-- Filter Categories -->
                        <div class="space-y-4">
                            <!-- Location Filter -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2 dark:text-white">Location</h4>
                                <select name="location_filter"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-900 dark:text-white">
                                    <option value="">All Locations</option>
                                    @foreach ($locations ?? [] as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Experience Filter -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2 dark:text-white">Experience</h4>
                                <select name="experience_filter"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-900 dark:text-white">
                                    <option value="">All Experience</option>
                                    <option value="0-2">0-2 years</option>
                                    <option value="2-5">2-5 years</option>
                                    <option value="5-8">5-8 years</option>
                                    <option value="8+">8+ years</option>
                                </select>
                            </div>

                            <!-- Salary Range Filter -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2 dark:text-white">Salary Range</h4>
                                <select name="salary_range"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-900 dark:text-white">
                                    <option value="">Any Salary</option>
                                    <option value="0-50000" {{ request('salary_range')=='0-50000' ? 'selected' : '' }}>
                                        ₹0 - ₹50,000</option>
                                    <option value="50000-100000" {{ request('salary_range')=='50000-100000' ? 'selected'
                                        : '' }}>₹50,000 - ₹100,000</option>
                                    <option value="100000+" {{ request('salary_range')=='100000+' ? 'selected' : '' }}>
                                        ₹100,000+</option>
                                </select>
                            </div>

                            <!-- Job Type Filter -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2 dark:text-white">Job Type</h4>
                                <select name="job_type"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-900 dark:text-white">
                                    <option value="">All Job Types</option>
                                    @foreach ($jobTypes ?? [] as $jobType)
                                    <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Job Freshness Filter -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2 dark:text-white">Job Freshness</h4>
                                <select name="job_freshness"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-900 dark:text-white">
                                    <option value="">All Jobs</option>
                                    <option value="1">Last 24 hours</option>
                                    <option value="3">Last 3 days</option>
                                    <option value="7">Last 7 days</option>
                                    <option value="30">Last 30 days</option>
                                </select>
                            </div>
                        </div>

                        <!-- All Filters Button -->
                        <button
                            class="w-full mt-6 border border-primary-600 text-primary-600 px-4 py-2 rounded-md hover:bg-primary-50 transition-colors flex items-center justify-center">
                            <span>All Filters</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                </div> --}}

                {{-- Job Listings & Details --}}
                <div class="lg:col-span-12">
                    <div class="grid grid-cols-1 md:grid-cols-7 gap-6">
                        {{-- Job Cards List --}}
                        <div class="md:col-span-3">
                            <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 dark:bg-slate-900">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 sm:mb-0">
                                        Showing {{ $jobs->total() }} results
                                    </h2>
                                    <select name="sort" id="sort-select"
                                        class="rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-900 dark:text-white">
                                        <option value="created_at-desc">Newest First</option>
                                        <option value="created_at-asc">Oldest First</option>
                                        <option value="title-asc">Title A-Z</option>
                                        <option value="title-desc">Title Z-A</option>
                                    </select>
                                </div>
                                <div id="jobs-container" class="space-y-4 max-h-[calc(100vh-280px)] overflow-y-auto">
                                    @include('recruitment::candidate.jobs.partials.job_listings')
                                </div>
                                <div class="mt-6 pagination">
                                    @include('recruitment::candidate.jobs.partials.pagination')
                                </div>
                            </div>
                        </div>

                        {{-- Job Details Panel --}}
                        <div class="md:col-span-4">
                            <div
                                class="bg-white rounded-xl shadow-sm p-4 md:p-6 dark:bg-slate-900 sticky top-24 max-h-[calc(100vh-140px)] overflow-y-auto">
                                <div id="job-details-container">
                                    <div class="text-gray-500 dark:text-white text-center py-12">
                                        Select a job to view details
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('search-form');
            const jobsContainer = document.getElementById('jobs-container');
            const sortSelect = document.getElementById('sort-select');
            let controller = null;

            // Handle all filter changes
            function handleFilterChange() {
                const formData = new FormData(searchForm);

                // Add sort value to form data
                formData.append('sort', sortSelect.value);

                const params = new URLSearchParams(formData);

                // Remove empty search parameter completely if empty
                if (!params.get('search')) {
                    params.delete('search');
                }

                const queryString = params.toString();

                // Update URL with filters
                const newUrl = `${window.location.pathname}?${queryString}`;
                window.history.pushState({
                    path: newUrl
                }, '', newUrl);

                // Abort previous request if it exists
                if (controller) {
                    controller.abort();
                }

                // Create a new AbortController
                controller = new AbortController();
                const signal = controller.signal;

                // Show loading state
                jobsContainer.style.opacity = '0.5';

                // Make new request
                fetch(`/candidate/jobs?${queryString}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        signal: signal // Pass the abort signal to fetch
                    })
                    .then(response => response.json())
                    .then(data => {
                        jobsContainer.innerHTML = data.html;
                        document.querySelector('.pagination').innerHTML = data.pagination;
                        jobsContainer.style.opacity = '1';
                    })
                    .catch(error => {
                        // Only log errors that aren't from aborting previous requests
                        if (error.name !== 'AbortError') {
                            console.error('Error:', error);
                        }
                        jobsContainer.style.opacity = '1';
                    });
            }

            // Debounce function
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Add event listeners
            const debouncedFilter = debounce(handleFilterChange, 300);

            // Listen to form submission
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                handleFilterChange();
            });

            // Listen to input changes
            searchForm.querySelectorAll('input, select').forEach(element => {
                element.addEventListener('change', debouncedFilter);
                if (element.type === 'text') {
                    element.addEventListener('input', debouncedFilter);
                }
            });

            // Listen to sort select changes
            sortSelect.addEventListener('change', handleFilterChange);

            // Job Selection Handling
            function loadJobDetails(jobId) {
                // Highlight selected card
                document.querySelectorAll('.job-card').forEach(card => {
                    card.classList.remove('selected');
                    card.querySelector('.selection-indicator').classList.add('opacity-0');
                });

                const selectedCard = document.querySelector(`.job-card[data-job-id="${jobId}"]`);
                if (selectedCard) {
                    selectedCard.classList.add('selected');
                    selectedCard.querySelector('.selection-indicator').classList.remove('opacity-0');
                }

                // Load details
                fetch(`/candidate/jobs/${jobId}/details`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('job-details-container').innerHTML = html;
                    });
            }

            // Event delegation for job cards
            document.getElementById('jobs-container').addEventListener('click', function(e) {
                const jobCard = e.target.closest('.job-card');
                if (jobCard) {
                    const jobId = jobCard.dataset.jobId;
                    history.pushState({
                        jobId
                    }, '', `/candidate/jobs?selected=${jobId}`);
                    loadJobDetails(jobId);
                }
            });

            // Handle initial selection
            const urlParams = new URLSearchParams(window.location.search);
            const selectedJobId = urlParams.get('selected');
            if (selectedJobId) {
                loadJobDetails(selectedJobId);
            } else if (document.querySelector('.job-card')) {
                loadJobDetails(document.querySelector('.job-card').dataset.jobId);
            }

            // Handle back/forward navigation
            window.addEventListener('popstate', function(event) {
                if (event.state && event.state.jobId) {
                    loadJobDetails(event.state.jobId);
                }
            });
        });
    </script>
@endsection
