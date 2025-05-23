@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-2xl mb-4 font-semibold text-gray-900 dark:text-white">Registered Colleges</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" id="college-search" placeholder="Search colleges..." value="{{ request('search') }}"
                        class="w-64 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#bf125d] focus:border-transparent">
                    <span class="absolute right-3 top-2.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <!-- Loading spinner -->
                    <div id="search-loading" class="hidden absolute right-10 top-2.5">
                        <svg class="animate-spin h-5 w-5 text-[#bf125d]" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div id="colleges-table">
                @include('recruitment::admin.colleges.partials.colleges-table')
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('college-search');
            const collegesTable = document.getElementById('colleges-table');
            const loadingSpinner = document.getElementById('search-loading');
            let searchTimeout;

            // Function to update the URL without reloading the page
            function updateURL(search) {
                const url = new URL(window.location);
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }
                window.history.pushState({}, '', url);
            }

            // Function to fetch colleges
            async function fetchColleges(url = null) {
                try {
                    loadingSpinner.classList.remove('hidden');
                    const targetUrl = url || `${window.location.pathname}?search=${searchInput.value.trim()}`;
                    const response = await fetch(targetUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const html = await response.text();
                    collegesTable.innerHTML = html;

                    if (!url) {
                        updateURL(searchInput.value.trim());
                    }
                } catch (error) {
                    console.error('Error fetching colleges:', error);
                } finally {
                    loadingSpinner.classList.add('hidden');
                }
            }

            // Handle search input with debouncing
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    fetchColleges();
                }, 500); // 500ms debounce delay
            });

            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                const element = e.target.closest('.pagination a');
                if (element) {
                    e.preventDefault();
                    fetchColleges(element.href);
                }
            });


            // Make the function global
            window.toggleCollegeStatus = function(collegeId) {
                const button = event.target;

                fetch(`/admin/colleges/${collegeId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            button.textContent = data.is_active ? 'Active' : 'Inactive';
                            button.className = `status-badge px-3 py-1 rounded-full text-sm font-medium ${
                    data.is_active 
                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                }`;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            };
        });
    </script>
@endsection
