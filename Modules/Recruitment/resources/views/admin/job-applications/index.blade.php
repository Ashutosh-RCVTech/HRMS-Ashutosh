@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <!-- Search and Filter Form -->
                <form method="GET" action="{{ route('admin.job-applications.index') }}" class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div>
                            <label for="search"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Search jobs, candidates, or clients"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                        </div>

                        <!-- Experience Filter -->
                        <div>
                            <label for="experience"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Experience Required</label>
                            <select name="experience" id="experience"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="">All Experience Levels</option>
                                @foreach ($filterOptions['experience_levels'] as $exp)
                                    <option value="{{ $exp }}"
                                        {{ request('experience') === $exp ? 'selected' : '' }}>
                                        {{ ucfirst($exp) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location Type Filter -->
                        <div>
                            <label for="location_type"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Location Type</label>
                            <select name="location_type" id="location_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="">All Location Types</option>
                                @foreach ($filterOptions['location_types'] as $type)
                                    <option value="{{ $type }}"
                                        {{ request('location_type') === $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location Filter -->
                        <div>
                            <label for="location"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Location</label>
                            <select name="location" id="location"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="">All Locations</option>
                                @foreach ($filterOptions['locations'] as $type)
                                    <option value="{{ $type }}"
                                        {{ request('location') === $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Education Level Filter -->
                        <div>
                            <label for="education_level"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Education Level</label>
                            <select name="education_level" id="education_level"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="">All Education Levels</option>
                                @foreach ($filterOptions['education_levels'] as $level)
                                    <option value="{{ $level }}"
                                        {{ request('education_level') === $level ? 'selected' : '' }}>
                                        {{ ucfirst($level) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Salary Range -->
                        <div>
                            <label for="min_salary" class="block text-sm font-medium text-gray-700 dark:text-white">Min
                                Salary</label>
                            <div class="relative mt-1">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600 dark:text-gray-300">₹</span>
                                <input type="number" name="min_salary" id="min_salary"
                                    value="{{ request('min_salary', 100000) }}"
                                    class="pl-7 pr-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div>
                            <label for="sort_field" class="block text-sm font-medium text-gray-700 dark:text-white">Sort
                                By</label>
                            <select name="sort_field" id="sort_field"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="job_applications.created_at"
                                    {{ request('sort_field') == 'job_applications.created_at' ? 'selected' : '' }}>
                                    Application Date</option>
                                <option value="job_openings.min_salary"
                                    {{ request('sort_field') == 'job_openings.min_salary' ? 'selected' : '' }}>Salary
                                </option>
                                <option value="job_openings.experience_required"
                                    {{ request('sort_field') == 'job_openings.experience_required' ? 'selected' : '' }}>
                                    Experience</option>
                            </select>
                        </div>

                        <div>
                            <label for="sort_direction" class="block text-sm font-medium text-gray-700 dark:text-white">Sort
                                Direction</label>
                            <select name="sort_direction" id="sort_direction"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>
                                    Descending</option>
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.job-applications.index') }}"
                            class="ml-3 inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Reset Filters
                        </a>
                    </div>
                </form>

                <!-- Applications List -->
                <div class="overflow-x-auto max-h-[500px] overflow-y-auto border rounded-lg">
                    <table class="w-full border-collapse bg-white shadow-lg rounded-lg dark:bg-slate-800 dark:text-white">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Candidate
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Job Details
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Client & Locations
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-gray-700">
                            @forelse ($applications as $application)
                                <tr class="hover:bg-gray-400">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $application->candidate->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-300">
                                            {{ $application->candidate->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $application->job->title }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-300">
                                            Experience: {{ $application->job->experience_required }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-300">
                                            Salary: ₹{{ number_format($application->job->min_salary) }} -
                                            ₹{{ number_format($application->job->max_salary) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $application->job->client }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-300">
                                            @foreach ($application->job->locations as $location)
                                                {{ $location->name }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    {{-- <td class="px-6 py-4">
                                        <select
                                            class="form-select status-select px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $application->status === 'accepted'
                                            ? 'bg-green-100 text-green-800'
                                            : ($application->status === 'rejected'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-yellow-100 text-yellow-800') }}"
                                            data-id="{{ $application->id }}">
                                            <option value="applied"
                                                {{ $application->status == 'applied' ? 'selected' : '' }}>Applied</option>
                                            <option value="screening"
                                                {{ $application->status == 'screening' ? 'selected' : '' }}>Screening
                                            </option>
                                            <option value="interview"
                                                {{ $application->status == 'interview' ? 'selected' : '' }}>Interview
                                            </option>
                                            <option value="test" {{ $application->status == 'test' ? 'selected' : '' }}>
                                                Test</option>
                                            <option value="accepted"
                                                {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted
                                            </option>
                                            <option value="rejected"
                                                {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected
                                            </option>
                                            <option value="offered"
                                                {{ $application->status == 'offered' ? 'selected' : '' }}>Offered</option>
                                            <option value="withdrawn"
                                                {{ $application->status == 'withdrawn' ? 'selected' : '' }}>Withdrawn
                                            </option>
                                            <option value="closed"
                                                {{ $application->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                        <div class="text-xs text-gray-500 mt-1 dark:text-gray-300">
                                            Applied: {{ $application->created_at->format('M d, Y') }}
                                        </div>
                                    </td> --}}
                                    <td class="px-6 py-4">
                                        <select
                                            class="form-select status-select px-6 py-2 text-sm font-bold rounded-full shadow-sm transition-colors duration-200
            {{ match ($application->status) {
                'accepted' => 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900',
                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900',
                'applied' => 'bg-blue-100 text-blue-800 dark:bg-blue-200 dark:text-blue-900',
                'screening' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-200 dark:text-indigo-900',
                'interview' => 'bg-purple-100 text-purple-800 dark:bg-purple-200 dark:text-purple-900',
                'test' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-200 dark:text-yellow-900',
                'offered' => 'bg-teal-100 text-teal-800 dark:bg-teal-200 dark:text-teal-900',
                'withdrawn' => 'bg-gray-100 text-gray-800 dark:bg-gray-300 dark:text-gray-900',
                'closed' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-300 dark:text-zinc-900',
                default => 'bg-neutral-100 text-neutral-800 dark:bg-neutral-200 dark:text-neutral-900',
            } }}"
                                            data-id="{{ $application->id }}">
                                            <option value="applied"
                                                {{ $application->status == 'applied' ? 'selected' : '' }}>Applied</option>
                                            <option value="screening"
                                                {{ $application->status == 'screening' ? 'selected' : '' }}>Screening
                                            </option>
                                            <option value="interview"
                                                {{ $application->status == 'interview' ? 'selected' : '' }}>Interview
                                            </option>
                                            <option value="test" {{ $application->status == 'test' ? 'selected' : '' }}>
                                                Test</option>
                                            <option value="accepted"
                                                {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted
                                            </option>
                                            <option value="rejected"
                                                {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected
                                            </option>
                                            <option value="offered"
                                                {{ $application->status == 'offered' ? 'selected' : '' }}>Offered</option>
                                            <option value="withdrawn"
                                                {{ $application->status == 'withdrawn' ? 'selected' : '' }}>Withdrawn
                                            </option>
                                            <option value="closed"
                                                {{ $application->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                        <div class="text-xs text-gray-500 mt-1 dark:text-gray-300">
                                            Applied: {{ $application->created_at->format('M d, Y') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.job-applications.show', $application->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View
                                            Details</a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                            No applications found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $applications->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </main>

        <script>
            document.querySelectorAll('.status-select').forEach(select => {
                select.addEventListener('change', function() {
                    const applicationId = this.dataset.id;
                    const newStatus = this.value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/admin/job-applications/${applicationId}/status`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest' // Ensures Laravel treats it as an AJAX request
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw err;
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Status updated successfully:', data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error updating status');
                        });
                });
            });
        </script>
    @endsection
