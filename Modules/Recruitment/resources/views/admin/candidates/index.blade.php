@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Candidates</h1>
                    <a href="{{ route('admin.candidates.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Add New Candidate
                    </a>
                </div>

                <!-- Search and Filters -->
                <form method="GET" action="{{ route('admin.candidates.index') }}" class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                        </div>

                        <!-- Location Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Location</label>
                            <input type="text" name="location" value="{{ request('location') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                        </div>

                        <!-- Industry Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Industry</label>
                            <select name="industry"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                <option value="">All Industries</option>
                                <!-- Add industry options -->
                            </select>
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.candidates.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Candidates Table -->
                <div class="overflow-x-auto max-h-[500px] overflow-y-auto border rounded-lg">
                    <table class="w-full border-collapse bg-white shadow-lg rounded-lg dark:bg-slate-800 dark:text-white">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Location</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Experience</th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Quiz Result</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-gray-700">
                            @forelse($candidates as $candidate)
                                <tr class="hover:bg-gray-400 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if ($candidate->basicDetail?->profile_image_path)
                                                <img src="{{ asset('storage/' . $candidate->basicDetail->profile_image_path) }}"
                                                    alt="Profile Image" class="w-8 h-8 rounded-full mr-3">
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $candidate->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $candidate->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $candidate->basicDetail?->location ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ count($candidate->employments) ? count($candidate->employments) . ' years' : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        @if ($candidate->mcqTests && $candidate->mcqTests->count() > 0)
                                            <select
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                                onchange="if (this.value) {
                                                    const [quizId, testId] = this.value.split('-');
                                                    window.open('/candidate/mcq/exam-mcq-user-result/' + quizId + '/' + testId, '_blank');
                                                }">
                                                <option value="">Select a test</option>
                                                @foreach ($candidate->mcqTests as $test)
                                                    <option value="{{ $test->quiz_id }}-{{ $test->id }}">
                                                        Quiz ID: {{ $test->quiz_id }} (ID: {{ $test->id }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">No tests taken</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $candidate->basicDetail?->mobile_verified
                                                ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                                                : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-400' }}">
                                            {{ $candidate->basicDetail?->mobile_verified ? 'Verified' : 'Pending' }}
                                        </span>
                                    </td>


                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.candidates.show', $candidate->id) }}"
                                                class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C1.627 10.4 2.5 8.5 4.25 7.5A11.95 11.95 0 0112 6.5c3.5 0 6.5 2 8.25 1.5 1.75.5 2.625 2.5 2.25 4.5a1.012 1.012 0 01-.65 1.122c-.44.123-.9.25-1.35.378a9.001 9.001 0 01-5.9 2.028H12" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ route('admin.candidates.edit', $candidate->id) }}"
                                                class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-800 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.candidates.destroy', $candidate->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">
                                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                        No candidates found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $candidates->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection
