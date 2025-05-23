<form id="career-profile-form" class="space-y-6">
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 dark:bg-slate-900">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Career Preferences</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-white">Specify your career preferences and expectations.
                </p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="current_industry"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Current
                            Industry</label>
                        <select id="current_industry" name="current_industry"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-slate-900 dark:text-white">
                            <option value="">Select Industry</option>
                            <option value="IT" {{ $careerProfile->current_industry === 'IT' ? 'selected' : '' }}>
                                Information Technology</option>
                            <option value="Finance"
                                {{ $careerProfile->current_industry === 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Healthcare"
                                {{ $careerProfile->current_industry === 'Healthcare' ? 'selected' : '' }}>
                                Healthcare</option>
                            <option value="Education"
                                {{ $careerProfile->current_industry === 'Education' ? 'selected' : '' }}>
                                Education</option>
                            <option value="Manufacturing"
                                {{ $careerProfile->current_industry === 'Manufacturing' ? 'selected' : '' }}>
                                Manufacturing</option>
                            <option value="Retail"
                                {{ $careerProfile->current_industry === 'Retail' ? 'selected' : '' }}>Retail</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="department"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Department</label>
                        <select id="department" name="department"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-slate-900 dark:text-white">
                            <option value="">Select Department</option>
                            <option value="Engineering"
                                {{ $careerProfile->department === 'Engineering' ? 'selected' : '' }}>
                                Engineering</option>
                            <option value="Sales" {{ $careerProfile->department === 'Sales' ? 'selected' : '' }}>Sales
                            </option>
                            <option value="Marketing"
                                {{ $careerProfile->department === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="HR" {{ $careerProfile->department === 'HR' ? 'selected' : '' }}>Human
                                Resources</option>
                            <option value="Finance" {{ $careerProfile->department === 'Finance' ? 'selected' : '' }}>
                                Finance</option>
                            <option value="Operations"
                                {{ $careerProfile->department === 'Operations' ? 'selected' : '' }}>Operations</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="desired_job_type"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Desired Job
                            Type</label>
                        <select id="desired_job_type" name="desired_job_type"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-slate-900 dark:text-white">
                            <option value="">Select Job Type</option>
                            <option value="Permanent"
                                {{ $careerProfile->desired_job_type === 'Permanent' ? 'selected' : '' }}>
                                Permanent</option>
                            <option value="Contract"
                                {{ $careerProfile->desired_job_type === 'Contract' ? 'selected' : '' }}>
                                Contract</option>
                            <option value="Freelance"
                                {{ $careerProfile->desired_job_type === 'Freelance' ? 'selected' : '' }}>
                                Freelance</option>
                            <option value="Internship"
                                {{ $careerProfile->desired_job_type === 'Internship' ? 'selected' : '' }}>
                                Internship</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="desired_employment_type"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Employment
                            Type</label>
                        <select id="desired_employment_type" name="desired_employment_type"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-slate-900 dark:text-white">
                            <option value="">Select Employment Type</option>
                            <option value="Full-time"
                                {{ $careerProfile->desired_employment_type === 'Full-time' ? 'selected' : '' }}>
                                Full-time</option>
                            <option value="Part-time"
                                {{ $careerProfile->desired_employment_type === 'Part-time' ? 'selected' : '' }}>
                                Part-time</option>
                            <option value="Remote"
                                {{ $careerProfile->desired_employment_type === 'Remote' ? 'selected' : '' }}>
                                Remote</option>
                            <option value="Hybrid"
                                {{ $careerProfile->desired_employment_type === 'Hybrid' ? 'selected' : '' }}>
                                Hybrid</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="preferred_shift"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Preferred
                            Shift</label>
                        <select id="preferred_shift" name="preferred_shift"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-slate-900 dark:text-white">
                            <option value="">Select Shift</option>
                            <option value="Day" {{ $careerProfile->preferred_shift === 'Day' ? 'selected' : '' }}>
                                Day
                                Shift</option>
                            <option value="Night" {{ $careerProfile->preferred_shift === 'Night' ? 'selected' : '' }}>
                                Night Shift</option>
                            <option value="Flexible"
                                {{ $careerProfile->preferred_shift === 'Flexible' ? 'selected' : '' }}>Flexible
                            </option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="preferred_work_location"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Preferred
                            Work Location</label>
                        <input type="text" name="preferred_work_location" id="preferred_work_location"
                            value="{{ $careerProfile->preferred_work_location }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white"
                            placeholder="e.g., Noida, Delhi, Remote">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="expected_salary"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Expected Annual
                            Salary</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <!-- <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₹ </span>
                            </div> -->
                            <input type="number" name="expected_salary" id="expected_salary"
                                value="{{ $careerProfile->expected_salary }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white"
                                placeholder="0.00" step="1000">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm dark:text-white">INR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Save Changes
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to show error message below input field
        function showError(field, message) {
            const input = document.getElementById(field);
            if (!input) return;

            // Create error message element if it doesn't exist
            let errorElement = input.nextElementSibling;
            if (!errorElement || !errorElement.classList.contains('error-message')) {
                errorElement = document.createElement('p');
                errorElement.className = 'error-message mt-1 text-sm text-red-600 dark:text-red-400';
                input.parentNode.insertBefore(errorElement, input.nextSibling);
            }

            // Update error message
            errorElement.textContent = message;

            // Add error styling to input
            input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        }

        // Function to clear all error messages
        function clearErrors() {
            // Clear error messages
            document.querySelectorAll('.error-message').forEach(element => {
                element.textContent = '';
            });

            // Remove error styling from inputs
            document.querySelectorAll('input, textarea, select').forEach(input => {
                input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            });
        }

        // Clear errors when input changes
        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('input', () => {
                const errorElement = input.nextElementSibling;
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.textContent = '';
                    input.classList.remove('border-red-500', 'focus:border-red-500',
                        'focus:ring-red-500');
                }
            });
        });

        // Form validation
        function validateForm() {
            let isValid = true;
            const requiredFields = [
                'current_industry', 'department', 'desired_job_type',
                'desired_employment_type', 'preferred_shift',
                'preferred_work_location', 'expected_salary'
            ];

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value) {
                    showError(field, 'This field is required');
                    isValid = false;
                }
            });

            return isValid;
        }

        // Form submission
        $('#career-profile-form').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            clearErrors();

            if (!validateForm()) {
                return;
            }

            const formData = {
                current_industry: $('#current_industry').val(),
                department: $('#department').val(),
                desired_job_type: $('#desired_job_type').val(),
                desired_employment_type: $('#desired_employment_type').val(),
                preferred_shift: $('#preferred_shift').val(),
                preferred_work_location: $('#preferred_work_location').val(),
                expected_salary: $('#expected_salary').val()
            };

            $.ajax({
                url: '{{ route('candidate.profile.update-career-profile') }}',
                type: 'PUT',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(field => {
                            const errorMessage = errors[field][0];
                            showError(field, errorMessage);
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message ||
                            'Failed to update career profile');
                    }
                }
            });
        });
    });
</script>
