<div class="space-y-6">
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 dark:bg-slate-900">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Education Details</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-white">Your latest educational qualification is shown below.</p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                @php
                    // Get the latest education if exists; otherwise null.
                    $latestEducation = $educations->last();
                @endphp
                <div id="education-list" class="space-y-4">
                    <div class="education-entry border rounded-md p-4">
                        <!-- hidden id (if exists) -->
                        <input type="hidden" name="id" value="{{ $latestEducation ? $latestEducation->id : '' }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Degree
                                </label>
                                <input type="text" name="degree" 
                                    value="{{ $latestEducation ? $latestEducation->degree : '' }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                            </div>

                            <!-- College selection field remains unchanged -->
                            <div class="relative col-span-6 sm:col-span-3">
                                <label for="college_search" class="block text-sm font-bold mb-2 text-gray-700 dark:text-white">
                                    Select College  <span class="text-red-500">*</span>
                                </label>
                                <input type="hidden" name="college_id" id="selected_college_id" value="{{ $latestEducation ? $latestEducation->college_id : '' }}">
                                <input type="hidden" name="college_unique_id" id="selected_college_unique_id" value="{{ $latestEducation ? $latestEducation->college_unique_id : '' }}">
                                <p id="college_error" class="text-red-500 text-sm mb-1"></p>
                                <div class="relative">
                                    <input type="text" id="college_search"
                                        class="w-full border rounded px-3 py-2 shadow focus:outline-none dark:bg-slate-900 dark:text-white"
                                        placeholder="Search for a college..." autocomplete="off"
                                        value="{{ $latestEducation ? $latestEducation->institution : '' }}"
                                        {{ $latestEducation ? 'readonly' : '' }}>
                                    <div id="college_dropdown"
                                        class="hidden absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 shadow rounded max-h-60 overflow-auto">
                                        <div class="py-1">
                                            <div id="college_list" class="divide-y divide-gray-100 dark:divide-gray-600"></div>
                                            <div id="college_loading_more"
                                                class="hidden px-4 py-2 text-center text-gray-500 dark:text-gray-300">
                                                Loading more...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Always render the Other (Add new college) button and input below the search box -->
                                <div class="mt-2">
                                    <button type="button" id="other_college_option"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                        Other (Add new college)
                                    </button>
                                    <div id="other_college_input_wrapper" class="hidden mt-2">
                                        <input type="text" id="other_college_input"
                                            class="w-full border rounded px-3 py-2 shadow focus:outline-none dark:bg-slate-900 dark:text-white"
                                            placeholder="Enter new college name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">Year</label>
                                <input type="number" name="year" 
                                    value="{{ $latestEducation ? $latestEducation->year : '' }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">Grade</label>
                                <input type="text" name="grade"
                                    value="{{ $latestEducation ? $latestEducation->grade : '' }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                            </div>
                        </div>
                        <!-- Remove the Remove button, since we always want one form -->
                    </div>
                </div>
                <!-- Hide the Add Education button by not rendering it (or set display:none) -->
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="button" id="save-education"
            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Save Changes
        </button>
    </div>
</div>

<!--
  Note: The JavaScript for the "add-education" and "remove-education" actions can be left unchanged.
  They won't be triggered if the Add button is not visible and there is no Remove button rendered.
  This way, you don't need to change your controller classes.
-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function clearErrors() {
            // Clear error messages
            $('.error-message').remove();

            // Remove error styling from inputs
            $('input').removeClass('border-red-500 focus:border-red-500 focus:ring-red-500');
        }
        // We are not initializing the add-education listener since the button is not rendered.
        
        // The save-education logic remains the same.
        $('#save-education').on('click', function() {
            // Clear previous errors (existing JS method)
            clearErrors();

            // Gather data from the single education form
            let educationEntry = $('.education-entry').first();
            let educationData = {
                id: educationEntry.find('[name="id"]').val() || null,
                degree: educationEntry.find('[name="degree"]').val(),
                year: educationEntry.find('[name="year"]').val(),
                grade: educationEntry.find('[name="grade"]').val(),
                institution: selectedCollegeInput.value,
                college_id: selectedCollegeUniqueId.value
            };

            $.ajax({
                url: '{{ route('candidate.profile.update-education') }}',
                type: 'PUT',
                data: JSON.stringify({
                    educations: [educationData] // submit as an array for consistency with controller logic
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
                            if (field.includes('.')) {
                                const [arrayName, index, fieldName] = field.split('.');
                                const errorMessage = errors[field][0];
                                showError(fieldName, errorMessage, parseInt(index));
                            } else {
                                const errorMessage = errors[field][0];
                                showError(field, errorMessage);
                            }
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message || 'Failed to update education details');
                    }
                }
            });
        });

        const otherCollegeOption = document.getElementById('other_college_option');
        const otherCollegeInputWrapper = document.getElementById('other_college_input_wrapper');
        const otherCollegeInput = document.getElementById('other_college_input');
        const selectedCollegeInput = document.getElementById('selected_college_id');
        const selectedCollegeUniqueId = document.getElementById('selected_college_unique_id');
        const collegeDropdown = document.getElementById('college_dropdown');
        const collegeSearch = document.getElementById('college_search');
        const clearBtn = document.querySelector('.clear-btn'); // update selector if needed

        // Robust null-safe dropdown/input close logic
        document.addEventListener('click', (e) => {
            if (
                (!collegeSearch || !collegeSearch.contains(e.target)) &&
                (!collegeDropdown || !collegeDropdown.contains(e.target)) &&
                (!otherWrapper || !otherWrapper.contains(e.target))
            ) {
                if (collegeDropdown) collegeDropdown.classList.add('hidden');
                if (otherWrapper) otherWrapper.classList.add('hidden');
            }
        });
        // Close dropdown/input on tab change (adjust selector for your tabs if needed)
        document.querySelectorAll('[data-toggle="tab"], .tab-link').forEach(tab => {
            tab.addEventListener('click', () => {
                if (collegeDropdown) collegeDropdown.classList.add('hidden');
                if (otherWrapper) otherWrapper.classList.add('hidden');
            });
        });
        // Show/hide Other input logic
        if (otherCollegeOption && otherCollegeInputWrapper && otherCollegeInput) {
            otherCollegeOption.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (collegeDropdown) collegeDropdown.classList.add('hidden');
                if (collegeSearch) {
                    collegeSearch.value = '';
                    collegeSearch.setAttribute('readonly', true);
                }
                if (selectedCollegeInput) selectedCollegeInput.value = '';
                if (selectedCollegeUniqueId) selectedCollegeUniqueId.value = '';
                otherCollegeInputWrapper.classList.remove('hidden');
                otherCollegeInput.focus();
                if (clearBtn) clearBtn.classList.remove('hidden');
            });
            otherCollegeInput.addEventListener('input', function() {
                if (selectedCollegeInput) selectedCollegeInput.value = otherCollegeInput.value;
                if (selectedCollegeUniqueId) selectedCollegeUniqueId.value = '';
            });
            otherCollegeInput.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>

<!-- The existing college search code remains unchanged -->
<script>
    const collegeSearch = document.getElementById('college_search');
    collegeSearch.value="{{ $latestEducation ? $latestEducation->institution : '' }}";
    const collegeDropdown = document.getElementById('college_dropdown');
    const collegeList = document.getElementById('college_list');
    const loadingMoreColleges = document.getElementById('college_loading_more');
    const selectedCollegeInput = document.getElementById('selected_college_id');
    const selectedCollegeUniqueId = document.getElementById('selected_college_unique_id');
    const collegeError = document.getElementById('college_error');

    let collegePage = 1;
    let isCollegeLoading = false;
    let hasMoreColleges = true;
    let collegeSearchTimeout;
    let collegeSelected = false;

    // Clear button setup
    const clearBtn = document.createElement('button');
    clearBtn.innerHTML = '&times;';
    clearBtn.type = 'button';
    clearBtn.className = 'absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white font-bold text-xl hover:text-red-600 focus:outline-none hidden';
    clearBtn.addEventListener('click', clearCollegeSelection);
    collegeSearch.parentNode.appendChild(clearBtn);

    collegeSearch.addEventListener('focus', () => {
        if (!collegeSelected) {
            loadColleges(collegeSearch.value);
            collegeDropdown.classList.remove('hidden');
        }
    });

    document.addEventListener('click', (e) => {
        // Don't close if clicking inside the "other college" input or its wrapper
        if (
            !collegeSearch.contains(e.target) &&
            !collegeDropdown.contains(e.target) &&
            !document.getElementById('other_college_input_wrapper').contains(e.target)
        ) {
            collegeDropdown.classList.add('hidden');
        }
    });


    function showError(field, message, index = null) {
            let input;
            if (index !== null) {
                // For array-based fields, find the input within the specific entry
                input = $(`.education-entry:eq(${index}) [name="${field}"]`)[0];
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
                'degree': 'Degree',
                'institution': 'Institution',
                'year': 'Year',
                'grade': 'Grade'
            };

            // Replace the field name with a user-friendly label
            let friendlyMessage = message;
            Object.keys(fieldLabels).forEach(key => {
                friendlyMessage = friendlyMessage.replace(key, fieldLabels[key]);
            });

            // Remove array indices from the message
            friendlyMessage = friendlyMessage.replace(/\[\d+\]/, '');
            friendlyMessage = friendlyMessage.replace(/\.\d+\./, ' ');

            errorElement.text(friendlyMessage);

            // Add error styling to input
            $(input).addClass('border-red-500 focus:border-red-500 focus:ring-red-500');
        }



    collegeSearch.addEventListener('input', (e) => {
        if (collegeSelected) return;
        collegeDropdown.classList.remove('hidden');
        clearTimeout(collegeSearchTimeout);
        collegeSearchTimeout = setTimeout(() => {
            collegePage = 1;
            loadColleges(e.target.value);
        }, 300);
    });

    collegeDropdown.addEventListener('scroll', () => {
        const { scrollTop, scrollHeight, clientHeight } = collegeDropdown;
        if (scrollHeight - scrollTop <= clientHeight + 50 && !isCollegeLoading && hasMoreColleges) {
            loadMoreColleges();
        }
    });

    collegeList.addEventListener('click', (e) => {
        const option = e.target.closest('.college-option');
        if (!option) return;
        const id = option.dataset.id;
        const name = option.dataset.name;
        selectedCollegeInput.value = name;
        selectedCollegeUniqueId.value = id;
        collegeSearch.value = name;
        collegeSearch.setAttribute('readonly', true);
        collegeSelected = true;
        clearBtn.classList.remove('hidden');
        collegeDropdown.classList.add('hidden');
        collegeError.textContent = "";
    });

    function clearCollegeSelection() {
        selectedCollegeInput.value = '';
        selectedCollegeUniqueId.value = "";
        collegeSearch.value = '';
        collegeSearch.removeAttribute('readonly');
        collegeSelected = false;
        clearBtn.classList.add('hidden');
        loadColleges();
        collegeDropdown.classList.remove('hidden');
        collegeSearch.focus();
    }

    function makeCollegeOption(college) {
        const wrapper = document.createElement('div');
        wrapper.className = 'college-option flex items-center px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 cursor-pointer';
        wrapper.dataset.id = college.id;
        wrapper.dataset.name = college.name;
        wrapper.innerHTML = `<span class="text-gray-700 dark:text-white">${college.name}</span>`;
        return wrapper;
    }

    async function loadColleges(searchTerm = '') {
        isCollegeLoading = true;
        hasMoreColleges = true;
        try {
            const res = await fetch(`{{ route('candidate.profile.search.college') }}?search=${encodeURIComponent(searchTerm)}&page=1`);
            const data = await res.json();
            collegeList.innerHTML = '';
            if (data.data.length) {
                data.data.forEach(college => collegeList.appendChild(makeCollegeOption(college)));
            } else {
                collegeList.innerHTML = '<div class="px-4 py-2 text-gray-500 dark:text-gray-300">No college found</div>';
            }
            collegePage = 1;
            hasMoreColleges = !!data.next_page_url;
            loadingMoreColleges.classList.toggle('hidden', !hasMoreColleges);
        } catch (err) {
            console.error(err);
            hasMoreColleges = false;
        }
        isCollegeLoading = false;
    }

    async function loadMoreColleges() {
        if (isCollegeLoading || !hasMoreColleges) return;
        isCollegeLoading = true;
        loadingMoreColleges.classList.remove('hidden');
        try {
            const term = collegeSearch.value;
            const res = await fetch(`{{ route('candidate.profile.search.college') }}?search=${encodeURIComponent(term)}&page=${collegePage + 1}`);
            const data = await res.json();
            if (data.data.length) {
                data.data.forEach(college => collegeList.appendChild(makeCollegeOption(college)));
                collegePage++;
                hasMoreColleges = !!data.next_page_url;
            } else {
                hasMoreColleges = false;
            }
            loadingMoreColleges.classList.toggle('hidden', !hasMoreColleges);
        } catch (err) {
            console.error(err);
            hasMoreColleges = false;
            loadingMoreColleges.classList.add('hidden');
        }
        isCollegeLoading = false;
    }

    loadColleges();

    document.querySelector('#form_submit').addEventListener('submit', function (e) {
        if (!selectedCollegeInput.value) {
            e.preventDefault();
            collegeError.textContent = "Please select a college.";
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const collegeSelects = document.querySelectorAll('.college-select');
    collegeSelects.forEach(select => {
        select.addEventListener('change', function() {
            const newCollegeInput = this.parentElement.querySelector('.new-college-input');
            if (this.value === 'other') {
                newCollegeInput.classList.remove('hidden');
                newCollegeInput.setAttribute('required', 'required');
            } else {
                newCollegeInput.classList.add('hidden');
                newCollegeInput.removeAttribute('required');
            }
        });
    });
});
</script>

