@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold">Add New Candidate</h1>
                </div>

                <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Account Information -->
                    <div class="mb-8 border-b pb-4">
                        <h2 class="text-xl font-medium mb-6">Account Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Full
                                    Name*</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Email*</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Password*</label>
                                <input type="password" name="password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
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
                                <input type="text" name="basic_detail[name]" value="{{ old('basic_detail.name') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('basic_detail.name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Location*</label>
                                <input type="text" name="basic_detail[location]"
                                    value="{{ old('basic_detail.location') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('basic_detail.location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Mobile*</label>
                                <input type="text" name="basic_detail[mobile]" value="{{ old('basic_detail.mobile') }}"
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
                                    value="{{ old('basic_detail.availability') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Resume
                                    Headline</label>
                                <input type="text" name="basic_detail[resume_headline]"
                                    value="{{ old('basic_detail.resume_headline') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Resume
                                    (PDF/DOC)</label>
                                <input type="file" name="basic_detail[resume]"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Profile
                                    Image</label>
                                <input type="file" name="basic_detail[profile_image]"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Key
                                    Skills*</label>
                                <input type="text" name="basic_detail[key_skills]"
                                    value="{{ old('basic_detail.key_skills') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                @error('basic_detail.key_skills')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Profile
                                    Summary</label>
                                <textarea name="basic_detail[profile_summary]" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">{{ old('basic_detail.profile_summary') }}</textarea>
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
                            @if (old('educations'))
                                @foreach (old('educations') as $index => $education)
                                    <div class="education-entry grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <!-- Education fields -->
                                    </div>
                                @endforeach
                            @endif
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
                            @if (old('employments'))
                                @foreach (old('employments') as $index => $employment)
                                    <div class="employment-entry grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <!-- Employment fields -->
                                    </div>
                                @endforeach
                            @endif
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
                                    value="{{ old('career_profile.current_industry') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Department*</label>
                                <input type="text" name="career_profile[department]"
                                    value="{{ old('career_profile.department') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Desired Job
                                    Type*</label>
                                <select name="career_profile[desired_job_type]" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Employment
                                    Type*</label>
                                <select name="career_profile[desired_employment_type]" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    <option value="Permanent">Permanent</option>
                                    <option value="Temporary">Temporary</option>
                                    <option value="Freelance">Freelance</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Preferred
                                    Shift*</label>
                                <select name="career_profile[preferred_shift]" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                                    <option value="Day">Day</option>
                                    <option value="Night">Night</option>
                                    <option value="Flexible">Flexible</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Preferred
                                    Work Location*</label>
                                <input type="text" name="career_profile[preferred_work_location]"
                                    value="{{ old('career_profile.preferred_work_location') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus: ring-indigo-500 dark:bg-slate-800 dark:text-white dark:border-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Expected
                                    Salary*</label>
                                <input type="number" step="0.01" name="career_profile[expected_salary]"
                                    value="{{ old('career_profile.expected_salary') }}" required
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
                            Create Candidate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        let educationIndex = {{ old('educations') ? count(old('educations')) : 0 }};
        let employmentIndex = {{ old('employments') ? count(old('employments')) : 0 }};

        function addEducation() {
            const html = `
            <div class="education-entry grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Degree*</label>
                    <input type="text" name="educations[${educationIndex}][degree]" required class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-gray-700">
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
