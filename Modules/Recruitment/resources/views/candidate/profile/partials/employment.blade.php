<div class="space-y-6">
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 dark:bg-slate-900">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Employment History</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-white">Add your work experience details.</p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div id="employment-list" class="space-y-4">
                    @foreach ($employments as $employment)
                        <div class="employment-entry border rounded-md p-4">
                            <input type="hidden" name="id" value="{{ $employment->id }}">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-white">Company</label>
                                    <input type="text" name="company" value="{{ $employment->company }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-white">Position</label>
                                    <input type="text" name="position" value="{{ $employment->position }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Start
                                        Date</label>
                                    <input type="date" name="start_date"
                                        value="{{ $employment->start_date?->format('Y-m-d') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="current"
                                            {{ $employment->current ? 'checked' : '' }}
                                            class="current-job h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300
                                    rounded dark:bg-slate-900 dark:text-white">
                                        <label class="ml-2 block text-sm text-gray-700 dark:text-white">Current
                                            Job</label>
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-3 end-date-field"
                                    {{ $employment->current ? 'style=display:none' : '' }}>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-white">End
                                        Date</label>
                                    <input type="date" name="end_date"
                                        value="{{ $employment->end_date?->format('Y-m-d') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                                </div>

                                <div class="col-span-6">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>
                                    <textarea name="description" rows="3"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">{{ $employment->description }}</textarea>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="button"
                                    class="remove-employment text-sm text-red-600 hover:text-red-500">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="button" id="add-employment"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add Employment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="button" id="save-employment"
            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Save Changes
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add new employment entry
        $('#add-employment').on('click', function() {
            const template = `
            <div class="employment-entry border rounded-md p-4 dark:bg-slate-900">
                <input type="hidden" name="id" value="">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Company</label>
                        <input type="text" name="company" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-white dark:bg-slate-900">
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Position</label>
                        <input type="text" name="position" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-white dark:bg-slate-900">
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Start Date</label>
                        <input type="date" name="start_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-white dark:bg-slate-900">
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <div class="flex items-center">
                            <input type="checkbox" name="current" class="current-job h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700 dark:text-white">Current Job</label>
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-3 end-date-field">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">End Date</label>
                        <input type="date" name="end_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-white dark:bg-slate-900">
                    </div>
                    <div class="col-span-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white dark:bg-slate-900">Description</label>
                        <textarea name="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900"></textarea>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" class="remove-employment text-sm text-red-600 hover:text-red-500">Remove</button>
                </div>
            </div>
        `;
            $('#employment-list').append(template);
        });

        // Handle current job checkbox
        $(document).on('change', '.current-job', function() {
            const endDateField = $(this).closest('.employment-entry').find('.end-date-field');
            const endDateInput = endDateField.find('input');

            if ($(this).is(':checked')) {
                endDateField.hide();
                endDateInput.val('');
                // Clear any existing error messages for end_date
                endDateField.find('.error-message').remove();
                endDateInput.removeClass('border-red-500 focus:border-red-500 focus:ring-red-500');
            } else {
                endDateField.show();
            }
        });

        // Remove employment entry
        $(document).on('click', '.remove-employment', function() {
            $(this).closest('.employment-entry').remove();
        });

        // Function to show error message below input field
        function showError(field, message, index = null) {
            let input;
            if (index !== null) {
                // For array-based fields, find the input within the specific entry
                input = $(`.employment-entry:eq(${index}) [name="${field}"]`)[0];
            } else {
                input = document.getElementById(field);
            }

            if (!input) return;

            // Create error message element if it doesn't exist
            let errorElement = $(input).next('.error-message');
            if (errorElement.length === 0) {
                errorElement = $('<p>').addClass('error-message mt-1 text-sm text-red-600 dark:text-red-400');
                $(input).after(errorElement);
            }

            // Update error message with user-friendly text
            const fieldLabels = {
                'company': 'Company',
                'position': 'Position',
                'start_date': 'Start Date',
                'end_date': 'End Date',
                'description': 'Description'
            };

            // Replace the field name with a user-friendly label
            let friendlyMessage = message;
            Object.keys(fieldLabels).forEach(key => {
                friendlyMessage = friendlyMessage.replace(key, fieldLabels[key]);
            });

            // Remove array indices from the message
            friendlyMessage = friendlyMessage.replace(/\[\d+\]/, '');
            friendlyMessage = friendlyMessage.replace(/\.\d+\./, ' ');

            // Special handling for end_date validation when current is false
            if (field === 'end_date' && message.includes('current is false')) {
                friendlyMessage = 'Please enter an End Date or mark this as Current Job';
            }

            errorElement.text(friendlyMessage);

            // Add error styling to input
            $(input).addClass('border-red-500 focus:border-red-500 focus:ring-red-500');

            // If it's an end_date error, show the end date field
            if (field === 'end_date') {
                $(input).closest('.employment-entry').find('.end-date-field').show();
            }
        }

        // Function to clear all error messages
        function clearErrors() {
            // Clear error messages
            $('.error-message').remove();

            // Remove error styling from inputs
            $('input, textarea').removeClass('border-red-500 focus:border-red-500 focus:ring-red-500');
        }

        // Clear errors when input changes
        $(document).on('input', 'input, textarea', function() {
            const errorElement = $(this).next('.error-message');
            if (errorElement.length > 0) {
                errorElement.remove();
                $(this).removeClass('border-red-500 focus:border-red-500 focus:ring-red-500');
            }
        });

        // Save employment details
        $('#save-employment').on('click', function() {
            // Clear previous errors
            clearErrors();

            const employments = [];
            $('.employment-entry').each(function() {
                employments.push({
                    id: $(this).find('[name="id"]').val() || null,
                    company: $(this).find('[name="company"]').val(),
                    position: $(this).find('[name="position"]').val(),
                    start_date: $(this).find('[name="start_date"]').val(),
                    end_date: $(this).find('[name="end_date"]').val() || null,
                    current: $(this).find('[name="current"]').is(':checked'),
                    description: $(this).find('[name="description"]').val()
                });
            });

            $.ajax({
                url: '{{ route('candidate.profile.update-employment') }}',
                type: 'PUT',
                data: JSON.stringify({
                    employments
                }),
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
                            // Handle array-based errors (e.g., "employments.0.company")
                            if (field.includes('.')) {
                                const [arrayName, index, fieldName] = field.split(
                                    '.');
                                const errorMessage = errors[field][0];
                                showError(fieldName, errorMessage, parseInt(index));
                            } else {
                                // Handle non-array errors
                                const errorMessage = errors[field][0];
                                showError(field, errorMessage);
                            }
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message ||
                            'Failed to update employment details');
                    }
                }
            });
        });
    });
</script>
