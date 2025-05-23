@extends('layouts.admin')
@section('content')
    <div class="container mx-auto px-4 py-8 mt-24 dark:bg-slate-900 dark:text-white" id="job-form">
        <h1 class="text-2xl font-bold mb-6">Edit Job Details</h1>

        <form id="jobOpening_edit_form" method="POST"
            class="bg-white rounded-lg shadow-lg p-8 mb-4 dark:bg-slate-900 dark:text-white">
            @csrf
            @method('PUT')

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
            <div class="tab-content hidden" data-content="1">
                <div class="space-y-6">
                    <!-- Job Title -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                            for="title">Job Title</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            id="title" name="title" type="text" placeholder="Job Title"
                            value="{{ old('title', $job->title) }}" required>
                        @error('title')
                            <span class="text-red-500 text-sm dark:text-red-400 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 relative">
                        <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white">
                            Job Description
                        </label>
                        <textarea id="job_description" name="description"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            rows="6">{{ old('description', $job->description) }}</textarea>
                        <div class="flex items-center mt-2">
                            <button type="button" id="generate-ai-description"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Generate AI Description
                            </button>
                            <div class="relative ml-4">
                                <button id="popover-btn" type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div id="description-help" class="invisible opacity-0 absolute z-20 right-0 mt-2 w-96 p-4 bg-white dark:bg-slate-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg transition-all duration-200">
                            <h4 class="font-bold mb-2 text-blue-600">AI Job Description Help</h4>
                            <ul class="list-disc ml-5 text-sm text-gray-700 dark:text-gray-200">
                                <li><b>Job Title</b> (e.g., Senior Software Engineer)</li>
                                <li><b>Experience Required</b> (select a range)</li>
                                <li><b>Degree</b> (select a specific degree)</li>
                                <li><b>Education Level</b> (e.g., Bachelor's, Master's)</li>
                                <li><b>Client</b> (select the client)</li>
                                <li><b>Skills</b> (add at least one skill)</li>
                            </ul>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <b>Tip:</b> Fill all the above fields for the best AI-generated job description.
                            </p>
                        </div>
                        @error('description')
                            <span class="text-red-500 text-sm dark:text-red-400 font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                            for="experience_required">Experience Required</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            id="experience_required" name="experience_required" required>
                            <option value="">Select Experience Range</option>
                            @foreach ($experienceRanges as $value => $label)
                                <option value="{{ $value }}" {{ old('experience_required', $job->experience_required) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('experience_required')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                            for="no_of_openings">Number of Openings</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            id="no_of_openings" name="no_of_openings" type="number" min="1"
                            value="{{ old('no_of_openings', $job->no_of_openings) }}" required>
                        @error('no_of_openings')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                            for="client">Specific Client</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            name="client" id="client">
                            @foreach ($clients as $client)
                                <option value="{{ $client->name }}"
                                    {{ old('client', $job->client) == $client->name ? 'selected' : '' }}>
                                    {{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Next Button -->
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('admin.jobs.index') }}"
                        class="inline-block font-bold py-2 px-4 rounded text-sm bg-red-500 hover:bg-red-700 text-white">
                        Cancel
                    </a>
                    <button
                        class="next-tab bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button" data-next="2">
                        Next
                    </button>
                </div>
            </div>

            <!-- Tab 2: Job Requirements -->
            <div class="tab-content hidden" data-content="2">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="jobType">Job Type</label>
                <div class="flex flex-wrap gap-3 mb-6">
                    @foreach ($jobTypes as $type)
                        <input type="hidden" name="selected_job_types[]"
                            value="{{ $job->jobTypes->contains($type->id) ? $type->id : '' }}"
                            id="job-{{ $type->id }}">
                        <button type="button"
                            data-selected="{{ $job->jobTypes->contains($type->id) ? 'true' : 'false' }}"
                            onclick="toggleSelection(this,'job-{{ $type->id }}')"
                            class="job-type-btn px-4 py-2 rounded transition-colors duration-200 {{ $job->jobTypes->contains($type->id) ? 'bg-blue-500 text-white' : 'bg-gray-400' }}"
                            data-id="{{ $type->id }}">
                            <span class="plus-symbol">{{ $job->jobTypes->contains($type->id) ? '' : '+' }}</span>
                            <span class="check-symbol {{ $job->jobTypes->contains($type->id) ? '' : 'hidden' }}">✓</span>
                            {{ $type->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Similar structure for schedules -->
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="schedule">Schedule</label>
                <div class="flex flex-wrap gap-3 mb-6">
                    @foreach ($schedules as $schedule)
                        <input type="hidden" name="selected_schedules[]"
                            value="{{ $job->schedules->contains($schedule->id) ? $schedule->id : '' }}"
                            id="schedule-{{ $schedule->id }}">
                        <button type="button"
                            data-selected="{{ $job->schedules->contains($schedule->id) ? 'true' : 'false' }}"
                            onclick="toggleSelection(this, 'schedule-{{ $schedule->id }}')"
                            class="schedule-btn px-4 py-2 rounded transition-colors duration-200 {{ $job->schedules->contains($schedule->id) ? 'bg-blue-500 text-white' : 'bg-gray-400' }}"
                            data-id="{{ $schedule->id }}">
                            <span class="plus-symbol">{{ $job->schedules->contains($schedule->id) ? '' : '+' }}</span>
                            <span
                                class="check-symbol {{ $job->schedules->contains($schedule->id) ? '' : 'hidden' }}">✓</span>
                            {{ $schedule->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Education and Degree Selection -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                        for="education_level">Education Level</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                        name="education_level" id="education_level">
                        @foreach ($educationLevels as $level)
                            <option value="{{ $level->name }}"
                                {{ old('education_level', $job->education_level) == $level->name ? 'selected' : '' }}>
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
                                {{ old('degree', $job->degree) == $degree->name ? 'selected' : '' }}>
                                {{ $degree->name }}</option>
                        @endforeach
                    </select>
                    @error('degree')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Skills Section -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="skills">Required
                        Skills</label>
                    <div class="relative">
                        <input type="text" id="skill-search"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            placeholder="Search for skills...">
                        <div id="skill-suggestions"
                            class="absolute z-10 w-full bg-white dark:bg-slate-200 shadow-lg rounded-b hidden">
                        </div>
                    </div>

                    <div id="selected-skills" class="mt-4 flex flex-wrap gap-2">
                        @foreach ($job->skills as $skill)
                            <span
                                class="skill-pill flex items-center bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-100 px-3 py-1 rounded-full text-sm">
                                {{ $skill->name }}
                                <span
                                    class="remove-skill text-red-500 hover:text-red-700 font-bold text-lg ml-1 cursor-pointer">×</span>
                            </span>
                        @endforeach
                    </div>
                    <input type="hidden" name="skill_ids[]" id="skill-ids"
                        value="{{ $job->skills->pluck('id')->join(',') }}">
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
                        <input type="hidden" name="selected_benefits[]"
                            value="{{ $job->benefits->contains($benefit->id) ? $benefit->id : '' }}"
                            id="benefit-{{ $benefit->id }}">
                        <button type="button"
                            data-selected="{{ $job->benefits->contains($benefit->id) ? 'true' : 'false' }}"
                            onclick="toggleSelection(this, 'benefit-{{ $benefit->id }}')"
                            class="benefit-btn px-4 py-2 rounded transition-colors duration-200 {{ $job->benefits->contains($benefit->id) ? 'bg-blue-500 text-white' : 'bg-gray-400' }}"
                            data-id="{{ $benefit->id }}">
                            <span class="plus-symbol">{{ $job->benefits->contains($benefit->id) ? '' : '+' }}</span>
                            <span
                                class="check-symbol {{ $job->benefits->contains($benefit->id) ? '' : 'hidden' }}">✓</span>
                            {{ $benefit->name }}
                        </button>
                    @endforeach
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                        for="min_salary">Minimum Salary (₹ p.a)</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                        id="min_salary" name="min_salary" type="number"
                        value="{{ old('min_salary', $job->min_salary) }}" required>
                    @error('min_salary')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                        for="max_salary">Maximum Salary (₹ p.a)</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                        id="max_salary" name="max_salary" type="number"
                        value="{{ old('max_salary', $job->max_salary) }}" required>
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
                        <input type="hidden" name="selected_locations[]"
                            value="{{ $job->locations->contains($location->id) ? $location->id : '' }}"
                            id="location-{{ $location->id }}">
                        <button type="button"
                            data-selected="{{ $job->locations->contains($location->id) ? 'true' : 'false' }}"
                            onclick="toggleSelection(this, 'location-{{ $location->id }}')"
                            class="location-btn px-4 py-2 rounded transition-colors duration-200 {{ $job->locations->contains($location->id) ? 'bg-blue-500 text-white' : 'bg-gray-400' }}"
                            data-id="{{ $location->id }}">
                            <span class="plus-symbol">{{ $job->locations->contains($location->id) ? '' : '+' }}</span>
                            <span
                                class="check-symbol {{ $job->locations->contains($location->id) ? '' : 'hidden' }}">✓</span>
                            {{ $location->name }}
                        </button>
                    @endforeach
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="location_type"
                            class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">Location Type</label>
                        <select id="location_type" name="location_type"
                            class="w-full p-2 border rounded dark:bg-slate-900"
                            value="{{ old('location_type', $job->location_type) }}">
                            <option value="On-site" {{ $job->location_type == 'On-site' ? 'selected' : '' }}>On-site
                            </option>
                            <option value="Remote" {{ $job->location_type == 'Remote' ? 'selected' : '' }}>Remote
                            </option>
                            <option value="Hybrid" {{ $job->location_type == 'Hybrid' ? 'selected' : '' }}>Hybrid
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="application_deadline"
                            class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">Application
                            Deadline</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            id="application_deadline" name="application_deadline" type="date"
                            value="{{ old('application_deadline', $job->application_deadline->format('Y-m-d')) }}"
                            required>
                    </div>
                </div>

                <!-- Submission Buttons -->
                <div class="flex justify-between mt-6">
                    <div class="space-x-4">
                        <button type="submit" name="status" value="draft"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Update Draft
                        </button>
                        <button
                            class="back-tab bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button" data-prev="3">Back</button>
                        {{-- <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update
                        Job</button> --}}
                        <button type="button" id="reviewJob"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Review & Update
                        </button>
                    </div>
                </div>

                <!-- Review Job Modal -->
                <div id="reviewModal"
                    class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                    <div
                        class="bg-white dark:bg-slate-900 dark:text-white w-full max-w-2xl rounded-2xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center border-b pb-3 dark:border-gray-700">
                            <h2 class="text-xl font-semibold">Review Job Details</h2>
                            <button id="closeReview"
                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Content -->
                        <div id="reviewContent" class="mt-4 space-y-6">
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
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            $("#jobOpening_edit_form").submit(function(e) {
                e.preventDefault();
                let form = $(this)[0];
                let data = new FormData(form);

                // Add selected skills
                let skills = $("#skill-ids").val();
                if (skills) {
                    data.append('skill_ids', skills);
                }

                $.ajax({
                    url: "{{ route('admin.jobs.update', $job->id) }}",
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
                const form = document.getElementById('jobOpening_edit_form');
                const submitButton = document.createElement('button');
                submitButton.type = 'submit';
                submitButton.name = 'status';
                submitButton.value = 'published';
                submitButton.style.display = 'none';

                form.appendChild(submitButton);
                submitButton.click();
                form.removeChild(submitButton);

                reviewModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        });
    </script>
@endsection
