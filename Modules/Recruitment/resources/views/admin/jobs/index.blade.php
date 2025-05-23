@extends('layouts.admin')

@section('content')
    <style>
        .button-loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .button-loading:after {
            content: "";
            display: inline-block;
            width: 1em;
            height: 1em;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
            margin-left: 0.5em;
            vertical-align: middle;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white rounded-xl shadow-lg">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Job Openings</h1>
                    <a href="{{ route('admin.jobs.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Create Job Opening
                    </a>
                </div>

                <!-- Filters Section -->
                <form action="{{ route('admin.jobs.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                    <!-- Search -->
                    <div>
                        <input type="text" name="search" placeholder="Search jobs..."
                            value="{{ request('search', '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select name="filters[status]"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('filters.status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="open" {{ request('filters.status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ request('filters.status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <!-- Experience Filter -->
                    <div>
                        <select name="filters[experience_required]"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            <option value="">All Experience</option>
                            {{-- <option value="0-1" {{ request('filters.experience_required') == '0-1' ? 'selected' : '' }}>
                                Entry Level (0-1)</option>
                            <option value="2-5" {{ request('filters.experience_required') == '2-5' ? 'selected' : '' }}>
                                Mid Level (2-5)</option>
                            <option value="5+" {{ request('filters.experience_required') == '5+' ? 'selected' : '' }}>
                                Senior (5+)</option> --}}
                            <option value="0-1" {{ request('filters.experience_required') == '0-1' ? 'selected' : '' }}>
                                0-1 Years</option>
                            <option value="2-5" {{ request('filters.experience_required') == '1-3' ? 'selected' : '' }}>
                                1-3 Years</option>
                            <option value="5+" {{ request('filters.experience_required') == '3-5' ? 'selected' : '' }}>
                                3-5 Years</option>
                            <option value="0-1" {{ request('filters.experience_required') == '5-8' ? 'selected' : '' }}>
                                5-8 Years</option>
                            <option value="2-5" {{ request('filters.experience_required') == '8-10' ? 'selected' : '' }}>
                                8-10 Years</option>
                            <option value="5+" {{ request('filters.experience_required') == '10+' ? 'selected' : '' }}>
                                10+ Years</option>
                        </select>
                    </div>

                    <!-- Sorting -->
                    <div class="md:col-span-2 flex gap-4">
                        <select name="sort_column"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            <option value="created_at" {{ request('sort_column') == 'created_at' ? 'selected' : '' }}>Sort
                                by Date</option>
                            <option value="title" {{ request('sort_column') == 'title' ? 'selected' : '' }}>Sort by Title
                            </option>
                        </select>

                        <select name="sort_direction"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending
                            </option>
                            <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending
                            </option>
                        </select>
                    </div>

                    <!-- Filter Actions -->
                    <div class="md:col-span-5 flex gap-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.jobs.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Reset
                        </a>
                    </div>
                </form>

                <!-- Active Filters -->
                @if (request()->hasAny(['search', 'filters', 'sort_column', 'sort_direction']))
                    <div class="mb-6 p-3 bg-indigo-50 dark:bg-slate-800 rounded-lg">
                        <span class="text-sm text-indigo-700 dark:text-indigo-300">
                            Active filters:
                            @if (request('search'))
                                "{{ request('search') }}"
                            @endif
                            @if (request('filters.status'))
                                • Status: {{ request('filters.status') }}
                            @endif
                            @if (request('filters.experience_required'))
                                • Experience: {{ request('filters.experience_required') }}
                            @endif
                        </span>
                    </div>
                @endif

                <!-- Job Openings Table -->
                <div class="overflow-x-auto max-h-[500px] overflow-y-auto border rounded-lg">
                    <table class="w-full border-collapse bg-white shadow-lg rounded-lg dark:bg-slate-800 dark:text-white">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Description</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Posted Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Experience</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-gray-700">
                            @forelse ($jobOpenings as $job)
                                <tr class="hover:bg-gray-400 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $job->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ Str::limit($job->description, 100) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $job->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        <button data-id="{{ $job->id }}"
                                            onclick="toggleJobStatus(this, '{{ $job->id }}', '{{ $job->status }}')"
                                            class="px-3 py-1 text-xs font-semibold rounded-full 
                                            {{ $job->status === 'open'
                                                ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                                                : 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400' }}">
                                            {{ ucfirst($job->status) }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $job->experience_required }} Years</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.jobs.show', $job->id) }}"
                                                class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                                View
                                            </a>
                                            <a href="{{ route('admin.jobs.edit', $job->id) }}"
                                                class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-800 transition ease-in-out duration-150">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                        No job openings found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $jobOpenings->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('resetFilters').onclick = function() {
            // Get the form and reset button
            const form = document.querySelector('form');
            const resetButton = this;

            // Reset search input
            const searchInput = form.querySelector('input[name="search"]');
            if (searchInput) searchInput.value = '';

            // Reset all select elements
            form.querySelectorAll('select').forEach(select => {
                select.value = '';
            });

            // Show loading state
            resetButton.disabled = true;
            resetButton.innerHTML = 'Resetting...';

            // Clear all parameters from current URL
            const baseUrl = window.location.href.split('?')[0];

            // Redirect to the base URL without any paameters
            window.location.href = baseUrl;

            // Show notification
            if (typeof toastr !== 'undefined') {
                toastr.info('Filters have been reset');
            }

            return false; // Prevent any default button behavior
        }

        // Function to toggle job status
        function toggleJobStatus(button, jobId, currentStatus) {
            // Prevent multiple clicks
            if (button.classList.contains('button-loading')) {
                return;
            }

            // Add loading state
            button.classList.add('button-loading');
            button.disabled = true;

            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').content;

            // Make API request
            fetch(`/admin/jobs/${jobId}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update button text
                        const newStatus = currentStatus === 'open' ? 'closed' : 'open';
                        button.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                        // Update button styling
                        button.classList.remove('bg-green-500', 'bg-red-500');
                        button.classList.add(newStatus === 'open' ? 'bg-green-500' : 'bg-red-500');

                        // Update button attributes
                        button.setAttribute('onclick', `toggleJobStatus(this, '${jobId}', '${newStatus}')`);

                        // Show success message
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.message || 'Status updated successfully');
                        }
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(data.message || 'Failed to update status');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Failed to update status. Please try again.');
                    }
                })
                .finally(() => {
                    // Remove loading state
                    button.classList.remove('button-loading');
                    button.disabled = false;
                });
        }

        // Initialize any existing status toggle buttons
        document.addEventListener('DOMContentLoaded', function() {
            // Add click handler for any dynamically added buttons
            document.body.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('status-toggle')) {
                    // The onclick attribute will handle the toggle
                    return;
                }
            });
        })
    </script>
@endsection
