@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold">Edit Candidate</h1>
                </div>

                <form action="{{ route('admin.candidates.update', $candidate->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Account Information -->
                    <div class="mb-8 border-b pb-4">
                        <h2 class="text-xl font-medium mb-6">Account Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Full
                                    Name*</label>
                                <input type="text" name="name" value="{{ old('name', $candidate->name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Email*</label>
                                <input type="email" name="email" value="{{ old('email', $candidate->email) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Password</label>
                                <input type="password" name="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700"
                                    placeholder="Leave blank to keep current">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Basic Details -->
                    <div class="mb-8 border-b pb-4">
                        <h2 class="text-xl font-medium mb-6">Basic Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Name*</label>
                                <input type="text" name="basic_detail[name]"
                                    value="{{ old('basic_detail.name', $candidate->basicDetail->name ?? '') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('basic_detail.name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Location*</label>
                                <input type="text" name="basic_detail[location]"
                                    value="{{ old('basic_detail.location', $candidate->basicDetail->location ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('basic_detail.location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Mobile*</label>
                                <input type="text" name="basic_detail[mobile]"
                                    value="{{ old('basic_detail.mobile', $candidate->basicDetail->mobile ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('basic_detail.mobile')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Availability</label>
                                <input type="date" name="basic_detail[availability]"
                                    value="{{ old('basic_detail.availability', $candidate->basicDetail->availability ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Resume
                                    Headline</label>
                                <input type="text" name="basic_detail[resume_headline]"
                                    value="{{ old('basic_detail.resume_headline', $candidate->basicDetail->resume_headline ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Resume
                                    (PDF/DOC)</label>
                                <input type="file" name="basic_detail[resume]"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @if ($candidate->basicDetail->resume_path ?? false)
                                    <p class="text-sm mt-2 dark:text-gray-300">
                                        Current Resume:
                                        <a href="{{ Storage::url($candidate->basicDetail->resume_path) }}" target="_blank"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                            {{ basename($candidate->basicDetail->resume_path) }}
                                        </a>
                                    </p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Profile
                                    Image</label>
                                <input type="file" name="basic_detail[profile_image]"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @if ($candidate->basicDetail->profile_image_path ?? false)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($candidate->basicDetail->profile_image_path) }}"
                                            alt="Profile Image" class="h-20 w-20 rounded-full object-cover">
                                    </div>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Key
                                    Skills*</label>
                                <input type="text" name="basic_detail[key_skills]"
                                    value="{{ old('basic_detail.key_skills', implode(', ', $candidate->basicDetail->key_skills ?? [])) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('basic_detail.key_skills')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Profile
                                    Summary</label>
                                <textarea name="basic_detail[profile_summary]" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">{{ old('basic_detail.profile_summary', $candidate->basicDetail->profile_summary ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Education Section -->
                    <div class="mb-8 border-b pb-4">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-medium">Education Details</h2>
                            <button type="button" onclick="addEducation()"
                                class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                Add Education
                            </button>
                        </div>
                        <div id="educations-container">
                            @foreach (old('educations', $candidate->educations ?? []) as $index => $education)
                                <div class="education-entry grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Degree*</label>
                                        <input type="text" name="educations[{{ $index }}][degree]"
                                            value="{{ old("educations.$index.degree", is_array($education) ? $education['degree'] ?? '' : $education->degree) }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Institution*</label>
                                        <input type="text" name="educations[{{ $index }}][institution]"
                                            value="{{ old("educations.$index.institution", is_array($education) ? $education['institution'] ?? '' : $education->institution) }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Year*</label>
                                        <input type="number" name="educations[{{ $index }}][year]"
                                            value="{{ old("educations.$index.year", is_array($education) ? $education['year'] ?? '' : $education->year) }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Grade</label>
                                        <input type="text" name="educations[{{ $index }}][grade]"
                                            value="{{ old("educations.$index.grade", is_array($education) ? $education['grade'] ?? '' : $education->grade) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Employment Section -->
                    <div class="mb-8 border-b pb-4">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-medium">Employment History</h2>
                            <button type="button" onclick="addEmployment()"
                                class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                Add Employment
                            </button>
                        </div>
                        <div id="employments-container">
                            @foreach (old('employments', $candidate->employments ?? []) as $index => $employment)
                                <div class="employment-entry grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Company*</label>
                                        <input type="text" name="employments[{{ $index }}][company]"
                                            value="{{ old("employments.$index.company", is_array($employment) ? $employment['company'] ?? '' : $employment->company) }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Position*</label>
                                        <input type="text" name="employments[{{ $index }}][position]"
                                            value="{{ old("employments.$index.position", is_array($employment) ? $employment['position'] ?? '' : $employment->position) }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Start
                                            Date*</label>
                                        <input type="date" name="employments[{{ $index }}][start_date]"
                                            value="{{ old("employments.$index.start_date", is_array($employment) ? $employment['start_date'] ?? '' : $employment->start_date) }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">End
                                            Date</label>
                                        <input type="date" name="employments[{{ $index }}][end_date]"
                                            value="{{ old("employments.$index.end_date", is_array($employment) ? $employment['end_date'] ?? '' : $employment->end_date) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Career Profile Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-medium mb-6">Career Profile</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Current
                                    Industry*</label>
                                <input type="text" name="career_profile[current_industry]"
                                    value="{{ old('career_profile.current_industry', $candidate->careerProfile->current_industry ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Department*</label>
                                <input type="text" name="career_profile[department]"
                                    value="{{ old('career_profile.department', $candidate->careerProfile->department ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Desired Job
                                    Type*</label>
                                <select name="career_profile[desired_job_type]" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    <option value="Full-time"
                                        {{ old('career_profile.desired_job_type', $candidate->careerProfile->desired_job_type ?? '') == 'Full-time' ? 'selected' : '' }}>
                                        Full-time</option>
                                    <option value="Part-time"
                                        {{ old('career_profile.desired_job_type', $candidate->careerProfile->desired_job_type ?? '') == 'Part-time' ? 'selected' : '' }}>
                                        Part-time</option>
                                    <option value="Contract"
                                        {{ old('career_profile.desired_job_type', $candidate->careerProfile->desired_job_type ?? '') == 'Contract' ? 'selected' : '' }}>
                                        Contract</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Employment
                                    Type*</label>
                                <select name="career_profile[desired_employment_type]" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    <option value="Permanent"
                                        {{ old('career_profile.desired_employment_type', $candidate->careerProfile->desired_employment_type ?? '') == 'Permanent' ? 'selected' : '' }}>
                                        Permanent</option>
                                    <option value="Temporary"
                                        {{ old('career_profile.desired_employment_type', $candidate->careerProfile->desired_employment_type ?? '') == 'Temporary' ? 'selected' : '' }}>
                                        Temporary</option>
                                    <option value="Freelance"
                                        {{ old('career_profile.desired_employment_type', $candidate->careerProfile->desired_employment_type ?? '') == 'Freelance' ? 'selected' : '' }}>
                                        Freelance</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Preferred
                                    Shift*</label>
                                <select name="career_profile[preferred_shift]" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    <option value="Day"
                                        {{ old('career_profile.preferred_shift', $candidate->careerProfile->preferred_shift ?? '') == 'Day' ? 'selected' : '' }}>
                                        Day</option>
                                    <option value="Night"
                                        {{ old('career_profile.preferred_shift', $candidate->careerProfile->preferred_shift ?? '') == 'Night' ? 'selected' : '' }}>
                                        Night</option>
                                    <option value="Flexible"
                                        {{ old('career_profile.preferred_shift', $candidate->careerProfile->preferred_shift ?? '') == 'Flexible' ? 'selected' : '' }}>
                                        Flexible</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Preferred
                                    Work Location*</label>
                                <input type="text" name="career_profile[preferred_work_location]"
                                    value="{{ old('career_profile.preferred_work_location', $candidate->careerProfile->preferred_work_location ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Expected
                                    Salary*</label>
                                <input type="number" step="0.01" name="career_profile[expected_salary]"
                                    value="{{ old('career_profile.expected_salary', $candidate->careerProfile->expected_salary ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.candidates.index') }}"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Update Candidate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        let educationIndex = {{ old('educations') ? count(old('educations')) : count($candidate->educations ?? []) }};
        let employmentIndex = {{ old('employments') ? count(old('employments')) : count($candidate->employments ?? []) }};

        function addEducation() {
            const html = `
            <div class="education-entry grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Degree*</label>
                    <input type="text" name="educations[${ educationIndex}][degree]" required class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Institution*</label>
                    <input type="text" name="educations[${educationIndex}][institution]" required class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Year*</label>
                    <input type="number" name="educations[${educationIndex}][year]" required class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Grade</label>
                    <input type="text" name="educations[${educationIndex}][grade]" class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
                </div>
            </div>`;
            document.getElementById('educations-container').insertAdjacentHTML('beforeend', html);
            educationIndex++;
        }

        function addEmployment() {
            const html = `
            <div class="employment-entry grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Company*</label>
                    <input type="text" name="employments[${employmentIndex}][company]" required class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Position*</label>
                    <input type="text" name="employments[${employmentIndex}][position]" required class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Start Date*</label>
                    <input type="date" name="employments[${employmentIndex}][start_date]" required class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">End Date</label>
                    <input type="date" name="employments[${employmentIndex}][end_date]" class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
                </div>
            </div>`;
            document.getElementById('employments-container').insertAdjacentHTML('beforeend', html);
            employmentIndex++;
        }
    </script>
@endsection
