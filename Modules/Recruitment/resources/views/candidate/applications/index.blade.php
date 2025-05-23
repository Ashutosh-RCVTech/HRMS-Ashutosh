@extends('recruitment::candidate.layouts.app')

@section('title', 'My Job Applications')

@section('content')
    <div class="py-6 min-h-screen dark:bg-slate-900">
        <div class="container mx-auto px-4 dark:bg-slate-900">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">My Job Applications</h1>

            <div class="mt-6 flex flex-col md:flex-row gap-6">
                <!-- Sidebar / Filters -->
                <div class="w-full md:w-64 flex-shrink-0">
                    <div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4">
                        <h2 class="font-medium text-gray-700 dark:text-white mb-4">Application Status</h2>
                        <ul>
                            <li class="mb-2">
                                <a href="{{ route('candidate.applications.index') }}"
                                    class="block px-3 py-2 rounded-md {{ !$status ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 dark:text-white hover:bg-gray-50 hover:dark:bg-slate-800' }}">
                                    All Applications ({{ $statusCounts['total'] }})
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('candidate.applications.index', ['status' => 'pending']) }}"
                                    class="block px-3 py-2 rounded-md {{ $status === 'pending' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 dark:text-white hover:bg-gray-50 hover:dark:bg-slate-800' }}">
                                    Pending ({{ $statusCounts['pending'] }})
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('candidate.applications.index', ['status' => 'screening']) }}"
                                    class="block px-3 py-2 rounded-md {{ $status === 'screening' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 dark:text-white hover:bg-gray-50 hover:dark:bg-slate-800' }}">
                                    Screening ({{ $statusCounts['screening'] }})
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('candidate.applications.index', ['status' => 'interview']) }}"
                                    class="block px-3 py-2 rounded-md {{ $status === 'interview' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 dark:text-white hover:bg-gray-50 hover:dark:bg-slate-800' }}">
                                    Interview ({{ $statusCounts['interview'] }})
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('candidate.applications.index', ['status' => 'offered']) }}"
                                    class="block px-3 py-2 rounded-md {{ $status === 'offered' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 dark:text-white hover:bg-gray-50 hover:dark:bg-slate-800' }}">
                                    Offered ({{ $statusCounts['offered'] }})
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('candidate.applications.index', ['status' => 'rejected']) }}"
                                    class="block px-3 py-2 rounded-md {{ $status === 'rejected' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 dark:text-white hover:bg-gray-50 hover:dark:bg-slate-800' }}">
                                    Rejected ({{ $statusCounts['rejected'] }})
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('candidate.applications.index', ['status' => 'withdrawn']) }}"
                                    class="block px-3 py-2 rounded-md {{ $status === 'withdrawn' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 dark:text-white hover:bg-gray-50 hover:dark:bg-slate-800' }}">
                                    Withdrawn
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Search and Sort Controls -->
                    <div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4 mb-6">
                        <form action="{{ route('candidate.applications.index') }}" method="GET" id="search-form">
                            @if ($status)
                                <input type="hidden" name="status" value="{{ $status }}">
                            @endif

                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1">
                                    <label for="search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input id="search" name="search" value="{{ $search }}"
                                            placeholder="Search job titles, companies..."
                                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md leading-5 bg-white dark:bg-slate-800 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:text-white">
                                    </div>
                                </div>

                                {{-- <div class="flex items-center space-x-2">
                                    <label for="sort" class="text-sm font-medium text-gray-700 dark:text-white">Sort
                                        by:</label>
                                    <select id="sort" name="sort"
                                        class="border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-slate-800 dark:text-white">
                                        <option value="created_at" {{ $sortColumn === 'created_at' ? 'selected' : '' }}>
                                            Date Applied</option>
                                        <option value="status" {{ $sortColumn === 'status' ? 'selected' : '' }}>Status
                                        </option>
                                        <option value="job_title" {{ $sortColumn === 'job_title' ? 'selected' : '' }}>Job
                                            Title</option>
                                        <option value="company" {{ $sortColumn === 'company' ? 'selected' : '' }}>Company
                                        </option>
                                    </select>

                                    <select id="direction" name="direction"
                                        class="border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-slate-800 dark:text-white">
                                        <option value="desc" {{ $sortDirection === 'desc' ? 'selected' : '' }}>Descending
                                        </option>
                                        <option value="asc" {{ $sortDirection === 'asc' ? 'selected' : '' }}>Ascending
                                        </option>
                                    </select>

                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Filter
                                    </button>
                                </div> --}}
                                <div class="flex flex-wrap items-center gap-3 sm:space-x-2 sm:flex-nowrap">
                                    <label for="sort"
                                        class="text-sm font-medium text-gray-700 dark:text-white whitespace-nowrap">Sort
                                        by:</label>

                                    <select id="sort" name="sort"
                                        class="w-full sm:w-auto border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-slate-800 dark:text-white">
                                        <option value="created_at" {{ $sortColumn === 'created_at' ? 'selected' : '' }}>
                                            Date Applied</option>
                                        <option value="status" {{ $sortColumn === 'status' ? 'selected' : '' }}>Status
                                        </option>
                                        <option value="job_title" {{ $sortColumn === 'job_title' ? 'selected' : '' }}>Job
                                            Title</option>
                                        <option value="company" {{ $sortColumn === 'company' ? 'selected' : '' }}>Company
                                        </option>
                                    </select>

                                    <select id="direction" name="direction"
                                        class="w-full sm:w-auto border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-slate-800 dark:text-white">
                                        <option value="desc" {{ $sortDirection === 'desc' ? 'selected' : '' }}>Descending
                                        </option>
                                        <option value="asc" {{ $sortDirection === 'asc' ? 'selected' : '' }}>Ascending
                                        </option>
                                    </select>

                                    <button type="submit"
                                        class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Filter
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <!-- Applications List -->
                    <div class="bg-white dark:bg-slate-900 shadow overflow-hidden sm:rounded-md">
                        @if (session('success'))
                            <div class="bg-green-50 dark:bg-green-900 border-l-4 border-green-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($applications->count() > 0)
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($applications as $application)
                                    <li>
                                        <a href="{{ route('candidate.applications.show', $application->id) }}"
                                            class="block hover:bg-gray-50 dark:hover:bg-slate-800">
                                            <div class="px-4 py-4 sm:px-6">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center">
                                                        <p
                                                            class="text-lg font-medium text-blue-600 dark:text-blue-400 truncate">
                                                            {{ $application->job->title }}</p>
                                                    </div>
                                                    <div class="ml-2 flex-shrink-0 flex">
                                                        @php
                                                            $statusClasses = [
                                                                'pending' =>
                                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
                                                                'screening' =>
                                                                    'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
                                                                'interview' =>
                                                                    'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
                                                                'offered' =>
                                                                    'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                                                                'rejected' =>
                                                                    'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
                                                                'withdrawn' =>
                                                                    'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                            ];
                                                            $statusClass =
                                                                $statusClasses[$application->status] ??
                                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                                        @endphp
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                            {{ ucfirst($application->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mt-2 sm:flex sm:justify-between">
                                                    <div class="sm:flex sm:flex-col">
                                                        <p
                                                            class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 dark:text-gray-500"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2h1v1H4v-1h1v-2a1 1 0 011-1h8a1 1 0 011 1zM9 5h2v4H9V5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            {{ $application->job->client }}
                                                        </p>
                                                        <p
                                                            class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 dark:text-gray-500"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            {{ $application->job->locations->pluck('name')->join(', ') ?:
                                                                'Not
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            specified' }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 dark:text-gray-500"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <p>
                                                            Applied on <time
                                                                datetime="{{ $application->created_at->format('Y-m-d') }}">{{ $application->created_at->format('M d, Y') }}</time>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="py-10 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No applications found
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    @if ($search)
                                        No applications match your search criteria.
                                    @elseif($status)
                                        You don't have any applications with status "{{ $status }}".
                                    @else
                                        You haven't applied to any jobs yet.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if ($applications->hasPages())
                        <div class="mt-6 dark:text-white">
                            {{ $applications->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit form when sort or direction changes
            const sortSelect = document.getElementById('sort');
            const directionSelect = document.getElementById('direction');

            if (sortSelect && directionSelect) {
                sortSelect.addEventListener('change', function() {
                    directionSelect.value = 'desc'; // Reset to descending when sort changes
                    document.getElementById('search-form').submit();
                });

                directionSelect.addEventListener('change', function() {
                    document.getElementById('search-form').submit();
                });
            }
        });
    </script>
@endsection
{{-- @include('recruitment::candidate.coming-soon') --}}
