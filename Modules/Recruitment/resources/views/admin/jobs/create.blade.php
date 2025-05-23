@extends('layouts.admin')
@section('content')
    <div class="container mx-auto px-4 py-8 mt-24 dark:bg-slate-900 dark:text-white" id="job-form">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Create New Job Opening</h1>
            <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Jobs
            </a>
        </div>

        <form id="jobOpening_form" method="POST" action="{{ route('admin.jobs.store') }}" class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 mb-4">
            @csrf

            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <button type="button" class="flex items-center tab-button cursor-pointer bg-transparent" data-tab="1" tabindex="0" role="button">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold transition-all duration-300">1</div>
                        <div class="ml-2 text-sm font-medium">Basic Details</div>
                    </button>
                    <button type="button" class="flex items-center tab-button cursor-pointer bg-transparent" data-tab="2" tabindex="0" role="button">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold transition-all duration-300">2</div>
                        <div class="ml-2 text-sm font-medium">Requirements</div>
                    </button>
                    <button type="button" class="flex items-center tab-button cursor-pointer bg-transparent" data-tab="3" tabindex="0" role="button">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold transition-all duration-300">3</div>
                        <div class="ml-2 text-sm font-medium">Compensation</div>
                    </button>
                    <button type="button" class="flex items-center tab-button cursor-pointer bg-transparent" data-tab="4" tabindex="0" role="button">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold transition-all duration-300">4</div>
                        <div class="ml-2 text-sm font-medium">Location</div>
                    </button>
                </div>
                <div class="relative mt-4">
                    <div class="h-1 bg-gray-200 dark:bg-gray-700 w-full rounded"></div>
                    <div id="progress-bar" class="h-1 bg-blue-600 rounded absolute left-0 top-0 transition-all duration-300" style="width:0%"></div>
                </div>
            </div>

            <!-- Tab 1: Basic Details -->
            <div class="tab-content" data-content="1">
                <div class="space-y-6">
                    <!-- Job Title -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2" for="title">
                            Job Title
                            <span class="text-red-500">*</span>
                        </label>
                        <input class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition duration-200"
                            id="title" name="title" type="text" placeholder="e.g., Senior Software Engineer" required>
                        @error('title')
                            <span class="text-red-500 text-sm dark:text-red-400 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Job Description -->
                    <div class="mb-4 relative">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">
                            Job Description
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea id="job_description" name="description"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition duration-200"
                                rows="6" placeholder="Enter a detailed job description...">{{ old('description', $job->description ?? '') }}</textarea>
                            <div class="absolute right-2 top-2 flex space-x-2">
                                <button type="button" id="generate-ai-description"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Generate AI Description
                                </button>
                                <button id="popover-btn" type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('description')
                            <span class="text-red-500 text-sm dark:text-red-400 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Experience Required -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2" for="experience_required">
                            Experience Required
                            <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition duration-200"
                            id="experience_required" name="experience_required" required>
                            <option value="">Select Experience Range</option>
                            @foreach ($experienceRanges as $value => $label)
                                <option value="{{ $value }}" {{ old('experience_required') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('experience_required')
                            <span class="text-red-500 text-sm dark:text-red-400 font-medium mt-1 block">Please select experience range</span>
                        @enderror
                    </div>

                    <!-- Number of Openings -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2" for="no_of_openings">
                            Number of Openings
                            <span class="text-red-500">*</span>
                        </label>
                        <input class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition duration-200"
                            id="no_of_openings" name="no_of_openings" type="number" min="1"
                            value="{{ old('no_of_openings', $job->no_of_openings ?? 1) }}" required>
                        @error('no_of_openings')
                            <span class="text-red-500 text-sm dark:text-red-400 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Client Selection -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2" for="client">
                            Client
                            <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition duration-200"
                            name="client" id="client">
                            @foreach ($clients as $client)
                                <option value="{{ $client->name }}"
                                    {{ old('client', $job->client ?? '') == $client->name ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client')
                            <span class="text-red-500 text-sm dark:text-red-400 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Next Button -->
                <div class="flex justify-end mt-8">
                    <button class="next-tab inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200"
                        type="button" data-next="2">
                        Next
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tab 2: Job Requirements -->
            <div class="tab-content hidden" data-content="2">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="jobType">Job Type</label>
                <div class="flex flex-wrap gap-3 mb-6">
                    @foreach ($jobTypes as $type)
                        <input type="hidden" name="selected_job_types[]" value="" id="job-{{ $type->id }}">
                        <button type="button" data-selected="false"
                            onclick="toggleSelection(this,'job-{{ $type->id }}')"
                            class="job-type-btn px-4 py-2 bg-gray-400 rounded transition-colors duration-200"
                            data-id="{{ $type->id }}">
                            <span class="plus-symbol">+</span>
                            <span class="check-symbol hidden">✓</span>
                            {{ $type->name }}
                        </button>
                    @endforeach
                </div>

                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="schedule">Schedule</label>
                <div class="flex flex-wrap gap-3 mb-6">
                    @foreach ($schedules as $schedule)
                        <input type="hidden" name="selected_schedules[]" value=""
                            id="schedule-{{ $schedule->id }}">
                        <button type="button" data-selected="false"
                            onclick="toggleSelection(this, 'schedule-{{ $schedule->id }}')"
                            data-id="{{ $schedule->id }}"
                            class="schedule-btn px-4 py-2 bg-gray-400 rounded transition-colors duration-200">
                            <span class="plus-symbol">+</span>
                            <span class="check-symbol hidden">✓</span>
                            {{ $schedule->name }}
                        </button>
                    @endforeach
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                        for="education_level">Education Level</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                        name="education_level" id="education_level">
                        @foreach ($educationLevels as $level)
                            <option value="{{ $level->name }}"
                                {{ old('education_level', $job->education_level ?? '') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('education_level')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                        for="degree">Specific Degree</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                        name="degree" id="degree">
                        @foreach ($degrees as $degree)
                            <option value="{{ $degree->name }}"
                                {{ old('degree', $job->degree_id ?? '') == $degree->id ? 'selected' : '' }}>
                                {{ $degree->name }}</option>
                        @endforeach
                    </select>
                    @error('degree')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="skills">Required
                        Skills</label>
                    <div class="relative">
                        <input type="text" id="skill-search"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            placeholder="Search for skills...">
                        <div id="skill-suggestions"
                            class="absolute z-10 w-full bg-white dark:bg-slate-200 shadow-lg rounded-b hidden">
                            <!-- Suggestions will appear here -->
                        </div>
                    </div>

                    <div id="selected-skills" class="mt-4 flex flex-wrap gap-2">
                        <!-- Selected skills will appear here -->
                    </div>
                    <input type="hidden" name="skill_ids[]" id="skill-ids">
                </div>


                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-4">
                    <button
                        class="back-tab bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button" data-prev="1">Back</button>
                    <button
                        class="next-tab bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button" data-next="3">Next</button>
                </div>
            </div>

            <!-- Tab 3: Compensation & Benefits -->
            <div class="tab-content hidden" data-content="3">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="benefits">Benefits</label>
                <div class="flex flex-wrap gap-3 mb-6">
                    @foreach ($benefits as $benefit)
                        <input type="hidden" name="selected_benefits[]" value=""
                            id="benefit-{{ $benefit->id }}">
                        <button type="button" data-selected="false"
                            onclick="toggleSelection(this, 'benefit-{{ $benefit->id }}')" data-id="{{ $benefit->id }}"
                            class="benefit-btn px-4 py-2 bg-gray-400 rounded transition-colors duration-200">
                            <span class="plus-symbol">+</span>
                            <span class="check-symbol hidden">✓</span>
                            {{ $benefit->name }}
                        </button>
                    @endforeach
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                        for="min_salary">Minimum Salary (₹ p.a)</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                        id="min_salary" name="min_salary" type="number" required>
                    @error('min_salary')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                        for="max_salary">Maximum Salary (₹ p.a)</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                        id="max_salary" name="max_salary" type="number" required>
                    @error('max_salary')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-4">
                    <button
                        class="back-tab bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button" data-prev="2">Back</button>
                    <button
                        class="next-tab bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button" data-next="4">Next</button>
                </div>
            </div>

            <!-- Tab 4: Location & Timeline -->
            <div class="tab-content hidden" data-content="4">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="location">Locations</label>
                <div class="flex flex-wrap gap-3 mb-6">
                    @foreach ($locations as $location)
                        <input type="hidden" name="selected_locations[]" value=""
                            id="location-{{ $location->id }}">
                        <button type="button" data-selected="false"
                            onclick="toggleSelection(this, 'location-{{ $location->id }}')"
                            data-id="{{ $location->id }}"
                            class="location-btn px-4 py-2 bg-gray-400 rounded transition-colors duration-200">
                            <span class="plus-symbol">+</span>
                            <span class="check-symbol hidden">✓</span>
                            {{ $location->name }}
                        </button>
                    @endforeach
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="location_type"
                            class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">Location Type</label>
                        <select id="location_type" name="location_type"
                            class="w-full p-2 border rounded dark:bg-slate-900">
                            <option>On-site</option>
                            <option>Remote</option>
                            <option>Hybrid</option>
                        </select>
                        @error('location_type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="application_deadline"
                            class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">Application
                            Deadline</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white dark:placeholder:text-gray-400 dark:border-gray-500"
                            id="application_deadline" name="application_deadline" type="date" required>

                        @error('application_deadline')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <!-- Submission Buttons -->
                <div class="flex justify-between mt-6">
                    <div class="space-x-4">
                        <button type="submit" name="status" value="draft"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Save as Draft
                        </button>
                        <button type="button" id="reviewJob"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Review & Submit
                        </button>
                    </div>
                </div>
            </div>

            <!-- Review Job Modal -->
            <div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white dark:bg-slate-900">
                    <div class="flex justify-between items-center border-b pb-3">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Review Job Posting</h3>
                        <button id="closeReview" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="reviewContent" class="mt-4 space-y-6 max-h-[60vh] overflow-y-auto">
                        <!-- Basic Details Section -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-lg">Basic Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <p class="font-medium">Job Title</p>
                                    <p id="review-title" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Client</p>
                                    <p id="review-client" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Experience Required</p>
                                    <p id="review-experience" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Number of Openings</p>
                                    <p id="review-openings" class="dark:text-white"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Job Description -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-lg">Job Description</h3>
                            <div class="bg-gray-50 dark:bg-darkblack-400 p-4 rounded-lg">
                                <p id="review-description" class="whitespace-pre-wrap"></p>
                            </div>
                        </div>

                        <!-- Requirements Section -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-lg">Requirements</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <p class="font-medium">Job Types</p>
                                    <p id="review-job-types" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Schedule</p>
                                    <p id="review-schedules" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Education</p>
                                    <p id="review-education" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Required Skills</p>
                                    <p id="review-skills" class="dark:text-white"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Compensation Section -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-lg">Compensation & Benefits</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <p class="font-medium">Salary Range</p>
                                    <p id="review-salary" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Benefits</p>
                                    <p id="review-benefits" class="dark:text-white"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Location & Timeline -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-lg">Location & Timeline</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <p class="font-medium">Locations</p>
                                    <p id="review-locations" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Location Type</p>
                                    <p id="review-location-type" class="dark:text-white"></p>
                                </div>
                                <div class="space-y-2">
                                    <p class="font-medium">Application Deadline</p>
                                    <p id="review-deadline" class="dark:text-white"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <button id="closeReviewBtn"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Close
                        </button>
                        <button id="confirmReviewBtn"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Confirm & Submit
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $("#jobOpening_form").submit(function(e) {
                e.preventDefault();
                let form = $(this)[0];
                let data = new FormData(form);

                // Add selected skills
                let skills = $("#skill-ids").val();
                if (skills) {
                    data.append('skill_ids', skills);
                }

                // Determine the action based on the submit button clicked
                let submitButton = $(document.activeElement);
                let isDraft = submitButton.val() === 'draft';

                // If it's a draft, ensure optional fields are not required
                if (isDraft) {
                    // Remove required attribute from fields
                    $('#jobOpening_form input[required], #jobOpening_form select[required]').removeAttr(
                        'required');
                }

                $.ajax({
                    url: "{{ route('admin.jobs.store') }}",
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.errors) {
                            // Clear previous error messages
                            $('.text-red-500').remove();
                            
                            // Display field-specific errors
                            $.each(response.errors, function(field, errors) {
                                // Find the input field
                                const inputField = $(`[name="${field}"]`);
                                if (inputField.length) {
                                    // Create error message element
                                    const errorMessage = $('<span>')
                                        .addClass('text-red-500 text-sm dark:text-red-400 font-medium mt-1 block')
                                        .text(errors[0]);
                                    
                                    // Insert error message after the input field
                                    inputField.after(errorMessage);
                                    
                                    // Show toastr for the first error
                                    if (field === Object.keys(response.errors)[0]) {
                                        toastr.error(errors[0]);
                                    }
                                } else {
                                    // If field not found, show in toastr
                                    toastr.error(errors[0]);
                                }
                            });
                        } else {
                            toastr.success(response.message);
                            // Redirect after successful submission to listing
                            window.location.href = '/admin/jobs';
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('An error occurred: ' + error);
                        }
                        console.log(xhr.responseText);
                    }
                });
            });



            // Review Modal Functionality
            const reviewButton = document.getElementById('reviewJob');
            const reviewModal = document.getElementById('reviewModal');
            const closeButtons = document.querySelectorAll('#closeReview, #closeReviewBtn');
            const confirmButton = document.getElementById('confirmReviewBtn');
            const experienceSelect = document.getElementById('experience_required');
    
            experienceSelect.addEventListener('invalid', function(e) {
                e.preventDefault();
                this.setCustomValidity('Please select experience range');
            });
            
            experienceSelect.addEventListener('change', function() {
                this.setCustomValidity('');
            });

            // Format currency
            const formatCurrency = (amount) => {
                return new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    maximumFractionDigits: 0
                }).format(amount);
            };

            // Format date
            const formatDate = (dateString) => {
                return new Date(dateString).toLocaleDateString('en-IN', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            };

            // Get selected items text - Updated to remove symbols
            const getSelectedItems = (selector) => {
                return Array.from(document.querySelectorAll(selector))
                    .filter(item => item.getAttribute('data-selected') === 'true')
                    .map(item => {
                        // Remove the +, ✓ symbols and trim extra spaces
                        let text = item.textContent.replace(/[+✓]/g, '').trim();
                        // Remove any leading/trailing spaces or special characters
                        return text.replace(/^\W+|\W+$/g, '').trim();
                    })
                    .filter(text => text) // Remove empty strings
                    .join(', ') || 'None selected';
            };

            // Get selected skills
            const getSelectedSkills = () => {
                const skillsContainer = document.getElementById('selected-skills');
                if (!skillsContainer || !skillsContainer.children.length) {
                    return 'None selected';
                }
                return Array.from(skillsContainer.children)
                    .map(skill => skill.textContent.replace(/[×✕]/g, '').trim()) // Remove × symbol if present
                    .filter(text => text) // Remove empty strings
                    .join(', ') || 'None selected';
            };

            // Update review content
            const updateReviewContent = () => {
                // Basic Details
                document.getElementById('review-title').textContent = document.getElementById('title').value ||
                    'Not specified';
                document.getElementById('review-client').textContent = document.getElementById('client')
                    .selectedOptions[0].text || 'Not specified';
                document.getElementById('review-experience').textContent =
                    `${document.getElementById('experience_required').value || '0'} years`;
                document.getElementById('review-openings').textContent = document.getElementById(
                    'no_of_openings').value || '1';

                // Description
                document.getElementById('review-description').textContent = document.getElementById(
                    'job_description').value || 'No description provided';

                // Requirements
                document.getElementById('review-job-types').textContent = getSelectedItems(
                    '.job-type-btn[data-selected="true"]');
                document.getElementById('review-schedules').textContent = getSelectedItems(
                    '.schedule-btn[data-selected="true"]');
                document.getElementById('review-education').textContent =
                    `${document.getElementById('education_level').value} - ${document.getElementById('degree').value}`;
                document.getElementById('review-skills').textContent = getSelectedSkills();

                // Compensation
                const minSalary = document.getElementById('min_salary').value;
                const maxSalary = document.getElementById('max_salary').value;
                document.getElementById('review-salary').textContent = minSalary && maxSalary ?
                    `${formatCurrency(minSalary)} - ${formatCurrency(maxSalary)}` : 'Not specified';
                document.getElementById('review-benefits').textContent = getSelectedItems(
                    '.benefit-btn[data-selected="true"]');

                // Location & Timeline
                document.getElementById('review-locations').textContent = getSelectedItems(
                    '.location-btn[data-selected="true"]');
                document.getElementById('review-location-type').textContent = document.getElementById(
                    'location_type').value;
                document.getElementById('review-deadline').textContent = document.getElementById(
                        'application_deadline').value ?
                    formatDate(document.getElementById('application_deadline').value) : 'Not specified';
            };

            // Function to close modal
            const closeModal = (e) => {
                e.preventDefault();
                e.stopPropagation();
                reviewModal.classList.add('hidden');
                document.body.style.overflow = '';
            };

            // Event Listeners
            reviewButton.addEventListener('click', (e) => {
                e.preventDefault();
                updateReviewContent();
                reviewModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            // Close button handlers
            closeButtons.forEach(button => {
                button.addEventListener('click', closeModal);
            });

            // Close on outside click
            reviewModal.addEventListener('click', (e) => {
                if (e.target === reviewModal) {
                    closeModal(e);
                }
            });

            // Confirm button handler
            confirmButton.addEventListener('click', (e) => {
                e.preventDefault();
                const form = document.getElementById('jobOpening_form');
                let statusInput = form.querySelector('input[name="status"]');
                if (!statusInput) {
                    statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    form.appendChild(statusInput);
                }
                statusInput.value = 'open';
                form.submit();
            });
        });
    </script>
@endsection
