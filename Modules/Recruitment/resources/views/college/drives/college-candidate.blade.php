@extends('recruitment::college.layouts.app')

@section('content')




    <!-- Modal Container -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-3xl min-h-[600px] flex flex-col">
            <!-- Increased width and added min-height -->
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-xl font-semibold">Select Candidates</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>

            <!-- Modal Body - Expanded height -->
            <div class="p-4 flex-1 flex flex-col">
                <div class="relative h-full flex flex-col md:flex-row gap-6"> <!-- Flex row on medium screens -->



                    <div class="relative flex-1 mt-4"> <!-- Added flex-1 for remaining space -->
                        <!-- Dropdown toggle -->
                        <button id="dropdown-toggle"
                            class="w-full border-2 border-gray-300 hover:border-blue-500 p-3 rounded-lg text-left bg-white shadow-sm hover:shadow-md transition-all duration-200 ease-in-out">
                            <span class="text-gray-600">Select Candidates</span>
                            <span class="float-right text-gray-400">▼</span>
                        </button>

                        <!-- Dropdown menu - Increased height -->
                        <div id="dropdown-menu"
                            class="absolute left-0 right-0 bg-white border-2 border-blue-500 mt-1 rounded-lg shadow-xl hidden z-10 transform origin-top transition-all duration-150 ease-out max-h-[500px]">
                            <!-- Increased max-height -->
                            <!-- Search input -->
                            <div class="p-2 bg-gray-50 border-b-2 border-gray-100">
                                <input type="text" id="search-input"
                                    class="w-full border-2 border-gray-200 rounded-lg px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all"
                                    placeholder="Search by name or email">
                            </div>

                            <!-- Options container with scroll -->
                            <div id="options-container" class="max-h-[350px] overflow-y-auto"> <!-- Adjusted height -->
                                <!-- Loading indicator -->
                                <div id="loading-indicator" class="hidden p-4 text-center text-gray-500">
                                    <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <!-- No results message -->
                            <div id="no-results" class="hidden p-4 text-center text-gray-500">No candidates found</div>
                        </div>
                    </div>

                    <!-- Selected Options (Right Side) -->
                    <!-- Selected Options (Right Side) -->
                    <div class="relative flex flex-col md:w-1/2 bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">Selected Candidates</h3>
                            <button id="remove-all-btn" onclick="removeAllSelected()"
                                class="text-sm text-red-500 hover:text-red-700 bg-white px-3 py-1 rounded-md shadow-sm transition-all duration-200 hidden hover:bg-red-50">
                                Clear All
                            </button>
                        </div>

                        <!-- Add search input for selected items -->
                        <div class="mb-3">
                            <input type="text" id="selected-search-input"
                                class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-500 outline-none"
                                placeholder="Search selected items...">
                        </div>

                        <div id="selected-options"
                            class="flex-1 flex flex-wrap gap-3 p-2 overflow-y-auto bg-white rounded-lg border border-gray-200 min-h-[150px] max-h-[400px] transition-all">
                            <!-- Selected items will be added here -->
                        </div>

                        <div class="mt-4 flex justify-end items-center space-x-2">
                            <span id="selected-count"
                                class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                                0
                            </span>
                            <span class="text-sm text-gray-500">selected</span>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 border-t flex justify-end gap-2">
                <button onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button onclick="submitSelection()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Confirm Selection
                </button>
            </div>
        </div>
    </div>




    {{-- Mutiple new candiadte Assigned in placement  --}}


    {{-- <div id="mainModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">User Details</h3>
                <span id="rowCount" class="text-gray-600">0 rows added</span>
            </div>

            <div id="inputContainer">
                <!-- Initial Input Card -->
                <div class="input-card mb-4 border p-4 rounded relative">
                    <div class="flex gap-4 mb-2 p-3">
                        <input type="text" placeholder="Name" class="name-input border rounded p-2 w-1/2" required>
                        <input type="email" placeholder="Email" class="email-input border rounded p-2 w-1/2" required>
                    </div>
                    <span class="text-red-500 email-error hidden">Invalid or duplicate email</span>
                    <button onclick="removeInputCard(this)" class="absolute top-1 right-1 text-red-500"><svg class="h-6 w-6 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg></button>
                </div>
            </div>

            <button onclick="addInputCard()" class="mb-4 text-blue-500">+ Add More</button>

            <div class="flex justify-end gap-2 mt-4">
                <button onclick="openNewCandidateAssignedModal()" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button onclick="handleSubmit()" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </div>
        </div>
    </div> --}}


    {{-- <div id="mainModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
            <!-- Fixed Header -->
            <div class="flex justify-between items-center mb-4 sticky top-0 bg-white py-4 border-b z-10">
                <h3 class="text-lg font-semibold">User Details</h3>
                <span id="rowCount" class="text-gray-600">0 rows added</span>
            </div>

            <div id="inputContainer" class="pt-4">
                <!-- Initial Input Card -->
                <div class="input-card mb-4 border p-4 rounded relative">
                    <div class="flex gap-4 mb-2">
                        <div class="w-1/2">
                            <input type="text" placeholder="Name" class="name-input border rounded p-2 w-full" required>
                            <span class="text-red-500 name-error hidden">Name must be at least 2 characters</span>
                        </div>
                        <div class="w-1/2">
                            <input type="email" placeholder="Email" class="email-input border rounded p-2 w-full"
                                required>
                            <span class="text-red-500 email-error hidden">Invalid or duplicate email</span>
                        </div>
                    </div>
                    <button onclick="removeInputCard(this)" class="absolute top-1 right-1 text-red-500">×</button>
                </div>
            </div>

            <button onclick="addInputCard()" class="mb-4 text-blue-500">+ Add More</button>

            <div class="flex justify-end gap-2 mt-4">
                <button onclick="openNewCandidateAssignedModalcloseModal()"
                    class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button onclick="handleSubmit()" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </div>
        </div>
    </div> --}}

    <div id="mainModal"
        class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-start justify-center overflow-y-auto pt-20">
        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl p-6 relative animate-fade-in">

            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b pb-4 sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-gray-800">User Details</h3>
                <span id="rowCount" class="text-sm text-gray-500">0 rows added</span>
            </div>

            <!-- Input Cards Container -->
            <div id="inputContainer" class="space-y-4 mt-6">

                <!-- Input Card -->
                <div class="input-card bg-gray-50 p-4 rounded-lg border relative shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="w-full md:w-1/2">
                            <input type="text" placeholder="Name"
                                class="name-input w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <span class="text-sm text-red-500 name-error hidden">Name must be at least 2 characters</span>
                        </div>
                        <div class="w-full md:w-1/2">
                            <input type="email" placeholder="Email"
                                class="email-input w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <span class="text-sm text-red-500 email-error hidden">Invalid or duplicate email</span>
                        </div>
                    </div>
                    <button onclick="removeInputCard(this)"
                        class="absolute top-2 right-2 text-red-500 text-xl hover:text-red-700 transition">
                        &times;
                    </button>
                </div>
            </div>

            <!-- Add More Button -->
            <div class="mt-4">
                <button onclick="addInputCard()" class="text-blue-600 hover:text-blue-800 font-medium transition">
                    + Add More
                </button>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-6 border-t pt-4">
                <button onclick="openNewCandidateAssignedModalcloseModal()"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg transition">
                    Cancel
                </button>
                <button onclick="handleSubmit()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition">
                    Submit
                </button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-1/3 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-semibold mb-4">Are you sure?</h3>
            <div class="flex justify-end gap-2">
                <button onclick="closeConfirmationModal()" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button onclick="confirmSubmission()" class="bg-blue-500 text-white px-4 py-2 rounded">OK</button>
            </div>
        </div>
    </div>




    {{-- Main header --}}
    <div class="container mx-auto px-4 py-8 dark:bg-gray-900 min-h-screen">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 transition-all duration-300">
            <!-- Top Row: Assigned Placement, Search Form, Per Page Selector -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <!-- Left: Assigned Placement -->
                <div class="flex items-center gap-4">

                    <button onclick="openModal()" type="button"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Assigned Placements
                    </button>


                    <button onclick="toggleSelectionMode()"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        Revoked Placement
                    </button>

                    <button onclick="openNewCandidateAssignedModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Assign New Candidate
                    </button>

                    <a href="{{ route('college.candidate.import', ['placementid' => $placementId]) }}"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white rounded-lg transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4M9 13l3 3 3-3m-3-7 3 3 3-3m-3 10 3-3 3 3" />
                        </svg>
                        Import by Excel
                    </a>
                </div>
                <!-- Middle: Search Form -->
                <div class="">
                    <form method="GET" class="relative group">
                        <div class="relative">
                            <label
                                class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs text-blue-500 dark:text-blue-400 transition-all transform origin-left scale-75 opacity-0 group-focus-within:opacity-100 pointer-events-none">
                                Search Candidates
                            </label>
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="search-input" name="search"
                                placeholder="Search by name or email..." value="{{ request('search') }}"
                                class="w-full pl-10 pr-24 py-3 border-2 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 dark:focus:border-blue-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-300 transition-all duration-300 shadow-sm hover:shadow-md">
                            <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center space-x-1">
                                <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center space-x-1">
                                    @if (request('search'))
                                        <button type="button"
                                            onclick="document.getElementById('search-input').value=''; this.form.submit()"
                                            class="p-1.5 text-gray-400 hover:text-red-500 rounded-full transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @endif
                                    <button type="submit"
                                        class="px-4 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 dark:from-blue-600 dark:to-blue-700 text-white rounded-lg shadow-sm transition-all flex items-center">
                                        Go
                                    </button>
                                </div>

                                <button type="submit"
                                    class="px-4 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 dark:from-blue-600 dark:to-blue-700 text-white rounded-lg shadow-sm transition-all flex items-center">
                                    Go
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Right: Per Page Selector -->
                <div class="sm:w-56">
                    <form method="GET">
                        <div class="relative">
                            <label
                                class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs text-blue-500 dark:text-blue-400 transition-all transform origin-left scale-75 opacity-0 group-focus-within:opacity-100 pointer-events-none">
                                Items per page
                            </label>
                            <div class="relative">
                                <select name="per_page" onchange="this.form.submit()"
                                    class="w-full pl-4 pr-10 py-3 border-2 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 dark:focus:border-blue-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 appearance-none transition-all duration-300 shadow-sm hover:shadow-md cursor-pointer">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 items
                                    </option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 items
                                    </option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 items
                                    </option>
                                </select>
                                <div
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-300 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Second Row: Selected Users and Assignment Button -->
            <div class="mb-6 relative">
                <!-- Cross icon button (initially hidden) -->
                <button id="clear-selection-btn" onclick="removeAllSelectedUsers()"
                    class="absolute top-0 right-0 p-2 text-red-500 hover:text-red-700 hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div id="selected-users"
                    class="hidden p-7 bg-white dark:bg-gray-700 p-3 rounded-lg shadow-lg max-w-xs max-h-40 overflow-y-auto space-y-2">
                    <!-- Selected users will appear here -->
                </div>
                <div id="assignment-action" class="hidden mt-4 flex flex-col items-center">
                    <button onclick="openAssignmentModal()"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
                        Assigned
                    </button>
                </div>
            </div>




            <!-- Assignment Modal (hidden by default) -->
            <div id="assignment-modal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 w-80">
                    <p class="mb-4 text-gray-800 dark:text-gray-200">
                        Are you sure you want to assign the selected candidates to this placement?
                    </p>
                    <div class="flex justify-end space-x-2">
                        <button onclick="confirmAssignment()"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                            Confirm
                        </button>
                        <button onclick="closeAssignmentModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-100 rounded-lg">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl border dark:border-gray-700 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <input type="checkbox" id="select-all"
                                    class="hidden rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                SR No</th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Name</th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Email</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($collegeCandidate as $index => $candidate)
                            <tr data-candidate-id="{{ $candidate->id }}"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" data-candidate-id="{{ $candidate->candidate_id }}"
                                        class="selection-checkbox hidden rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        onchange="handleCandidateSelection(this)">
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-200">
                                    {{ $collegeCandidate->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ $candidate->candidate_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ $candidate->candidate_email }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                @if ($collegeCandidate->hasPages())
                    <nav class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                            <span>Showing</span>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-200">{{ $collegeCandidate->firstItem() }}</span>
                            <span>to</span>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-200">{{ $collegeCandidate->lastItem() }}</span>
                            <span>of</span>
                            <span
                                class="font-medium text-gray-700 dark:text-gray-200">{{ $collegeCandidate->total() }}</span>
                            <span>results</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            @if ($collegeCandidate->onFirstPage())
                                <span
                                    class="px-4 py-2 border rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $collegeCandidate->previousPageUrl() }}"
                                    class="px-4 py-2 border dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            @endif
                            <div class="flex items-center space-x-1">
                                @php
                                    $currentPage = $collegeCandidate->currentPage();
                                    $lastPage = $collegeCandidate->lastPage();
                                    $startPage = max($currentPage - 2, 1);
                                    $endPage = min($currentPage + 2, $lastPage);
                                @endphp
                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    @if ($page == $currentPage)
                                        <span class="px-4 py-2 rounded-lg bg-blue-500 text-white shadow-sm">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $collegeCandidate->url($page) }}"
                                            class="px-4 py-2 border dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors shadow-sm">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endfor
                                @if ($endPage < $lastPage)
                                    <span class="px-2 py-2 text-gray-400">...</span>
                                    <a href="{{ $collegeCandidate->url($lastPage) }}"
                                        class="px-4 py-2 border dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors shadow-sm">
                                        {{ $lastPage }}
                                    </a>
                                @endif
                            </div>
                            @if ($collegeCandidate->hasMorePages())
                                <a href="{{ $collegeCandidate->nextPageUrl() }}"
                                    class="px-4 py-2 border dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="px-4 py-2 border rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </nav>
                @endif
            </div>
        </div>
    </div>





    <script>
        const removeAllBtn = document.getElementById('remove-all-btn');

        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function submitSelection() {
            // Handle selected candidates here
            const selected = Array.from(document.querySelectorAll('#selected-options > div'))
                .map(div => div.id.replace('selected-', ''));

            closeModal();
        }

        // Close modal when clicking outside
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });





        let placementId = @json($placementId);
        let selectionMode = false;
        let selectedCandidates = JSON.parse(localStorage.getItem('selectedCandidates')) || [];

        // Toggle selection mode
        function toggleSelectionMode() {
            selectionMode = !selectionMode;
            document.querySelectorAll('.selection-checkbox, #select-all').forEach(el => {
                el.classList.toggle('hidden', !selectionMode);
            });
            updateSelectedUsersBox();
        }



        // Handle individual selection
        function handleCandidateSelection(checkbox) {
            const candidateId = checkbox.dataset.candidateId;
            const candidateName = checkbox.closest('tr').querySelector('td:nth-child(3)').textContent;
            const candidateEmail = checkbox.closest('tr').querySelector('td:nth-child(4)').textContent;
            const index = selectedCandidates.findIndex(c => c.id === candidateId);

            if (checkbox.checked) {
                if (selectedCandidates.length >= 10) {
                    alert('Maximum 10 candidates can be selected');
                    checkbox.checked = false;
                    return;
                }
                if (index === -1) {
                    selectedCandidates.push({
                        id: candidateId,
                        name: candidateName,
                        email: candidateEmail
                    });
                }
            } else {
                if (index !== -1) {
                    selectedCandidates.splice(index, 1);
                }
            }

            persistSelection();
            updateSelectedUsersBox();
        }

        // Update selected users display
        // Update selected users display
        function updateSelectedUsersBox() {
            const selectedUsersContainer = document.getElementById('selected-users');
            const assignmentAction = document.getElementById('assignment-action');
            const clearSelectionBtn = document.getElementById('clear-selection-btn');

            // Clear existing content
            selectedUsersContainer.innerHTML = '';

            // Check if there are any selected candidates
            if (selectedCandidates.length === 0) {
                selectedUsersContainer.classList.add('hidden');
                assignmentAction.classList.add('hidden');
                clearSelectionBtn.classList.add('hidden');
            } else {
                selectedUsersContainer.classList.remove('hidden');
                assignmentAction.classList.remove('hidden');
                clearSelectionBtn.classList.remove('hidden');

                // Set up a grid with 4 columns (adjust if needed)
                selectedUsersContainer.classList.add('grid', 'grid-cols-4', 'gap-2');

                selectedCandidates.forEach(candidate => {
                    const div = document.createElement('div');
                    div.className =
                        'flex items-center justify-between py-1 px-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded border border-gray-300 dark:border-gray-600';
                    div.innerHTML = `
                <span class="text-sm dark:text-gray-200 truncate">${candidate.candidate_name}</span>
                <button onclick="removeCandidate('${candidate.candidate_id }')" 
                        class="ml-2 text-red-500 hover:text-red-700 text-sm">
                    ✕
                </button>
            `;
                    selectedUsersContainer.appendChild(div);
                });
            }
        }




        // Remove candidate from selection
        function removeCandidate(candidateId) {
            selectedCandidates = selectedCandidates.filter(c => c.id !== candidateId);
            persistSelection();
            updateSelectedUsersBox();

            // Uncheck checkbox if exists on current page
            const checkbox = document.querySelector(`.selection-checkbox[data-candidate-id="${candidateId}"]`);
            if (checkbox) {
                checkbox.checked = false;
                handleCandidateSelection(checkbox);
            }
        }



        // Persist to localStorage
        function persistSelection() {
            localStorage.setItem('selectedCandidates', JSON.stringify(selectedCandidates));
        }

        // Initialize checkboxes on load


        // Initial update of selected users box
        document.addEventListener('DOMContentLoaded', () => {
            // Set initial checkbox states
            document.querySelectorAll('.selection-checkbox').forEach(checkbox => {
                const candidateId = checkbox.dataset.candidateId;
                checkbox.checked = selectedCandidates.some(c => c.id === candidateId);
            });

            // Handle select all (current page only)
            document.getElementById('select-all').addEventListener('change', function(e) {
                const checkboxes = document.querySelectorAll('.selection-checkbox:not(:checked)');
                const remainingSlots = 10 - selectedCandidates.length;

                if (e.target.checked && checkboxes.length > remainingSlots) {
                    alert(`You can only select ${remainingSlots} more candidates`);
                    e.target.checked = false;
                    return;
                }

                checkboxes.forEach(checkbox => {
                    if (remainingSlots > 0) {
                        checkbox.checked = e.target.checked;
                        handleCandidateSelection(checkbox);
                    }
                });
            });

            updateSelectedUsersBox();
        });

        // Clear selection when form submitted or page left


        // Clear selection when navigating away
        window.addEventListener('beforeunload', () => {
            if (!selectionMode) {
                localStorage.removeItem('selectedCandidates');
            }
        });


        // Open the modal
        function openAssignmentModal() {
            document.getElementById('assignment-modal').classList.remove('hidden');
        }

        // Close the modal
        function closeAssignmentModal() {
            document.getElementById('assignment-modal').classList.add('hidden');
        }

        // Confirm assignment action
        function confirmAssignment() {
            if (selectedCandidates.length === 0) {
                toastr.warning('No candidates selected for assignment.');
                return;
            }

            // CSRF Token setup for Laravel
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('college.assigned.placement') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        placementId: placementId,
                        candidates: selectedCandidates // send array of selected candidate IDs or objects
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message || 'Candidates successfully assigned!');

                        // Clear selected users
                        selectedCandidates = [];
                        persistSelection();
                        updateSelectedUsersBox();

                        closeAssignmentModal();
                    } else {
                        toastr.error(data.message || 'Failed to assign candidates.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An unexpected error occurred.');
                });
        }


        function removeAllSelectedUsers() {
            // Clear the array of selected candidates
            selectedCandidates = [];
            // Optionally, remove the stored value from localStorage
            localStorage.removeItem('selectedCandidates');
            // Update the UI (assumes updateSelectedUsersBox() refreshes the display)
            updateSelectedUsersBox();
        }


        const routeUrl = "{{ route('college.candidate') }}";
        const dropdownToggle = document.getElementById('dropdown-toggle');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const optionsContainer = document.getElementById('options-container');
        const searchInput = document.getElementById('search-input');
        const selectedOptionsDiv = document.getElementById('selected-options');
        const selectedCount = document.getElementById('selected-count');
        let currentPage = 1;
        let totalPages = 1; // Track total pages
        let loading = false;
        let allOptions = [];

        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Toggle dropdown visibility
        dropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown if clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Load options from the server using the Laravel route URL
        function loadOptions(page, search = '') {
            if (loading || page > totalPages) return;
            loading = true;
            // document.getElementById('loading-indicator').classList.remove('hidden');
            fetch(`${routeUrl}?page=${page}&search=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    totalPages = data.last_page;
                    if (data.data.length === 0 && page === 1) {
                        document.getElementById('no-results').classList.remove('hidden');
                    } else {
                        document.getElementById('no-results').classList.add('hidden');
                    }
                    data.data.forEach(candidate => {
                        allOptions.push(candidate);
                        const optionItem = document.createElement('div');
                        optionItem.className =
                            "flex items-center p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-0 transition-colors duration-100 ease-in-out";

                        // Create checkbox for multi-select
                        const checkbox = document.createElement('input');
                        checkbox.type = "checkbox";
                        checkbox.className = "mr-2";
                        checkbox.value = candidate.candidate_id;
                        checkbox.addEventListener('change', function() {
                            if (this.checked) {
                                addSelected(candidate);
                            } else {
                                removeSelected(candidate);
                            }
                        });
                        optionItem.appendChild(checkbox);

                        // Container for candidate image and details
                        const infoDiv = document.createElement('div');
                        infoDiv.className = "flex items-center";

                        // Candidate image or fallback SVG
                        let img;
                        if (candidate.image_url) {
                            img = document.createElement('img');
                            img.src = candidate.image_url;
                            img.alt = candidate.candidate_name;
                            img.className = "h-8 w-8 rounded-full mr-2";
                        } else {
                            const svgWrapper = document.createElement('div');
                            svgWrapper.innerHTML = `<svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                           </svg>`;
                            img = svgWrapper.firstElementChild;
                        }
                        infoDiv.appendChild(img);

                        // Candidate details (name and email)
                        const detailsDiv = document.createElement('div');
                        const nameDiv = document.createElement('div');
                        nameDiv.className = "font-medium";
                        nameDiv.textContent = candidate.candidate_name;
                        const emailDiv = document.createElement('div');
                        emailDiv.className = "text-sm text-gray-500";
                        emailDiv.textContent = candidate.candidate_email;
                        detailsDiv.appendChild(nameDiv);
                        detailsDiv.appendChild(emailDiv);
                        infoDiv.appendChild(detailsDiv);

                        optionItem.appendChild(infoDiv);
                        optionsContainer.appendChild(optionItem);
                    });
                    loading = false;
                })
                .catch(() => {
                    loading = false;
                }).finally(() => {
                    loading = false;
                    document.getElementById('loading-indicator').classList.add('hidden');
                });;
        }

        // Add selected candidate as a tag
        function addSelected(candidate) {
            if (document.getElementById('selected-' + candidate.candidate_id)) return;




            const selectedDiv = document.createElement('div');
            selectedDiv.id = 'selected-' + candidate.candidate_id;
            selectedDiv.className =
                "flex items-center bg-blue-100 rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-150 ease-in-out hover:bg-blue-200 cursor-pointer group";

            // Add candidate details
            const detailsDiv = document.createElement('div');
            detailsDiv.className = "flex-1";

            const nameDiv = document.createElement('div');
            nameDiv.className = "font-medium text-gray-700";
            nameDiv.textContent = candidate.candidate_name;

            const emailDiv = document.createElement('div');
            emailDiv.className = "text-xs text-gray-500 truncate";
            emailDiv.textContent = candidate.candidate_email;

            detailsDiv.appendChild(nameDiv);
            detailsDiv.appendChild(emailDiv);
            selectedDiv.appendChild(detailsDiv);

            // Remove button
            const removeBtn = document.createElement('span');
            removeBtn.textContent = '×';
            removeBtn.className = "ml-2 text-gray-400 hover:text-red-600 transition-colors";
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                removeSelected(candidate);
                const checkboxes = optionsContainer.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => {
                    if (cb.value == candidate.candidate_id) {
                        cb.checked = false;
                    }
                });
            });

            selectedDiv.appendChild(removeBtn);
            selectedOptionsDiv.appendChild(selectedDiv);
            updateRemoveAllButton();
            updateSelectedCount();
        }

        // Remove candidate tag
        function removeSelected(candidate) {
            const selectedDiv = document.getElementById('selected-' + candidate.candidate_id);
            if (selectedDiv) {

                selectedOptionsDiv.removeChild(selectedDiv);
                updateRemoveAllButton();
                updateSelectedCount();

            }


        }

        // Add this after your existing search input event listener
        const selectedSearchInput = document.getElementById('selected-search-input');
        selectedSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const selectedItems = selectedOptionsDiv.querySelectorAll('div[id^="selected-"]');

            selectedItems.forEach(item => {
                const name = item.querySelector('.font-medium').textContent.toLowerCase();
                const email = item.querySelector('.text-xs').textContent.toLowerCase();
                const match = name.includes(searchTerm) || email.includes(searchTerm);
                item.style.display = match ? 'flex' : 'none';
            });
        });

        // Listen for changes in the search input to filter options
        searchInput.addEventListener('input', function() {
            optionsContainer.innerHTML = '';
            allOptions = [];
            currentPage = 1;

            totalPages = 1;
            loadOptions(currentPage, this.value);
        });

        // Infinite scroll: load next page when scrolling near bottom
        optionsContainer.addEventListener('scroll', function() {
            const scrollThreshold = 100; // Load more when 100px from bottom
            const position = optionsContainer.scrollTop + optionsContainer.clientHeight;
            const height = optionsContainer.scrollHeight;

            if (position + scrollThreshold >= height && !loading && currentPage < totalPages) {
                currentPage++;
                loadOptions(currentPage, searchInput.value);
            }
        });

        // Initial load
        loadOptions(currentPage);


        function removeAllSelected() {
            // Remove all selected items


            selectedOptionsDiv.innerHTML = '';

            // Uncheck all checkboxes
            const checkboxes = optionsContainer.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);
            updateRemoveAllButton();
            updateSelectedCount();

            // Optional: Add fade-out animation
            selectedOptionsDiv.classList.add('opacity-50');
            setTimeout(() => selectedOptionsDiv.classList.remove('opacity-50'), 200);

        }


        function updateRemoveAllButton() {
            const hasItems = selectedOptionsDiv.children.length > 0;
            removeAllBtn.classList.toggle('hidden', !hasItems);
        }


        function updateSelectedCount() {

            const countElement = document.getElementById('selected-count');


            const count = selectedOptionsDiv.children.length;
            countElement.textContent = count;

            // Optional: Add animation for count changes
            countElement.classList.add('scale-110');
            setTimeout(() => countElement.classList.remove('scale-110'), 200);
        }


        ///////////////////////////////////////////////////////////////////////////////////////

        let inputCards = [];
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


        document.getElementById('mainModal').addEventListener('click', function(e) {
            if (e.target === this) { // Check if click is on the modal backdrop
                openNewCandidateAssignedModalcloseModal();
            }
        });




        function openNewCandidateAssignedModal() {
            document.getElementById('mainModal').classList.remove('hidden');
        }

        function openNewCandidateAssignedModalcloseModal() {
            document.getElementById('mainModal').classList.add('hidden');
        }


        function addInputCard() {
            const template = document.querySelector('.input-card').cloneNode(true);
            template.querySelector('.name-input').value = '';
            template.querySelector('.email-input').value = '';
            template.querySelector('.name-error').classList.add('hidden');
            template.querySelector('.email-error').classList.add('hidden');
            document.getElementById('inputContainer').appendChild(template);
            updateRowCount();
        }


        function removeInputCard(button) {
            if (document.querySelectorAll('.input-card').length > 1) {
                button.closest('.input-card').remove();
                updateRowCount();
                validateAllEmails();
            }
        }


        function validateName(input) {
            const name = input.value.trim();
            const errorElement = input.closest('.input-card').querySelector('.name-error');

            if (name.length < 2) {
                errorElement.textContent = 'Name must be at least 2 characters';
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            }

            errorElement.classList.add('hidden');
            input.classList.remove('border-red-500');
            return true;
        }


        function validateAllNames() {
            let allValid = true;
            document.querySelectorAll('.name-input').forEach(input => {
                if (!validateName(input)) allValid = false;
            });
            return allValid;
        }

        function validateEmail(input) {
            const email = input.value;
            const errorElement = input.closest('.input-card').querySelector('.email-error');

            if (!emailRegex.test(email)) {
                errorElement.textContent = 'Invalid email format';
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            }

            const emails = [...document.querySelectorAll('.email-input')]
                .map(e => e.value)
                .filter(e => e === email);

            if (emails.length > 1) {
                errorElement.textContent = 'Email already exists';
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            }

            errorElement.classList.add('hidden');
            input.classList.remove('border-red-500');
            return true;
        }

        function validateAllEmails() {
            let allValid = true;
            document.querySelectorAll('.email-input').forEach(input => {
                if (!validateEmail(input)) allValid = false;
            });
            return allValid;
        }


        function updateRowCount() {
            const count = document.querySelectorAll('.input-card').length;
            document.getElementById('rowCount').textContent = `${count} rows added`;
        }


        function handleSubmit() {
            const namesValid = validateAllNames();
            const emailsValid = validateAllEmails();

            if (!namesValid || !emailsValid) {
                alert('Please fix validation errors');
                return;
            }

            openNewCandidateAssignedModalcloseModal();

            confirmSubmission();

        }



        function confirmSubmission() {
            const data = [];
            document.querySelectorAll('.input-card').forEach(card => {
                data.push({
                    name: card.querySelector('.name-input').value,
                    email: card.querySelector('.email-input').value
                });
            });

            console.log(data);
            fetch("{{ route('college.candedate.placement.insert.assignd') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        placement_id: placementId,
                        candidates: data
                    })
                })
                .then(response => response.json())
                .then(data => {

                    toastr.success("Candidate Registered on background and Placement assigned sucuessfully")
                    alert('Data saved successfully!');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error saving data');
                });
        }

        // Event Listeners
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('email-input')) {
                validateEmail(e.target);
            }

            if (e.target.classList.contains('name-input')) {
                validateName(e.target);
            }
        });
    </script>
    <style>
        #selected-users::-webkit-scrollbar {
            width: 6px;
        }

        #selected-users::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        #selected-users::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .dark #selected-users::-webkit-scrollbar-track {
            background: #374151;
        }

        .dark #selected-users::-webkit-scrollbar-thumb {
            background: #6b7280;
        }

        /* Custom scrollbar */
        #options-container::-webkit-scrollbar {
            width: 8px;
        }

        #options-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        #options-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        #options-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        #selected-options {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        #selected-options::-webkit-scrollbar {
            width: 6px;
        }

        #selected-options::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        #selected-options::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        #selected-options::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        #remove-all-btn {
            transform-origin: top right;
            transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out, transform 0.2s ease-in-out;
        }

        #selected-options {
            gap: 8px;
        }

        #selected-options>div {
            flex: 0 0 calc(50% - 4px);
            /* Two columns layout */
            max-width: calc(50% - 4px);
            min-width: 200px;
        }
    </style>
@endsection
