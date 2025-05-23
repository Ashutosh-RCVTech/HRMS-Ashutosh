<form id="basic-details-form" class="space-y-6" enctype="multipart/form-data">
    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 dark:bg-slate-900">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Personal Information</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-white">Update your basic profile information.</p>

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-white">Full
                            Name</label>
                        <input type="text" name="name" id="name" value="{{ $candidate->name }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="location"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Location</label>
                        <input type="text" name="location" id="location" value="{{ $basicDetail->location }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-white">Mobile
                            Number</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <div class="relative flex-shrink-0">
                                <div id="country-code-selector" class="country-code-selector"
                                    aria-label="Select country code">
                                    <div class="selected-country" role="button" tabindex="0" aria-haspopup="listbox">
                                        <span class="flag">🇮🇳</span>
                                        <span class="dial-code">+91</span>
                                    </div>
                                    <div class="country-list" role="listbox">
                                        <div class="search-box">
                                            <input type="text" placeholder="Search country..." class="country-search"
                                                aria-label="Search countries">
                                        </div>
                                        <div class="countries">
                                            <!-- Countries will be populated by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="tel" name="mobile" id="mobile"
                                value="{{ $basicDetail->mobile ? preg_replace('/^\+?\d+\s*/', '', $basicDetail->mobile) : '' }}"
                                data-stored-value="{{ $basicDetail->mobile ?? '' }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white ml-2"
                                placeholder="12345 67890" aria-label="Mobile number">
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter your mobile number without the
                            country code</p>
                    </div>

                    <div class="col-span-6">
                        <label for="resume_headline"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Resume
                            Headline</label>
                        <input type="text" name="resume_headline" id="resume_headline"
                            value="{{ $basicDetail->resume_headline }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">
                    </div>

                    <div class="col-span-6">
                        <label for="key_skills" class="block text-sm font-medium text-gray-700 dark:text-white">Key
                            Skills</label>
                        <input type="text" name="key_skills" id="key_skills"
                            value="{{ implode(', ', $basicDetail->key_skills ?? []) }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white"
                            placeholder="Enter skills separated by commas">
                    </div>

                    <div class="col-span-6">
                        <label for="it_skills" class="block text-sm font-medium text-gray-700 dark:text-white">IT
                            Skills</label>
                        <input type="text" name="it_skills" id="it_skills"
                            value="{{ implode(', ', $basicDetail->it_skills ?? []) }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white"
                            placeholder="Enter IT skills separated by commas">
                    </div>

                    <div class="col-span-6">
                        <label for="profile_summary"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Profile
                            Summary</label>
                        <textarea name="profile_summary" id="profile_summary" rows="4"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-900 dark:text-white">{{ $basicDetail->profile_summary }}</textarea>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="profile_image"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Profile Image </label>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*"
                            class="mt-1 block w-full dark:text-white">
                        @if ($basicDetail->profile_image_path)
                            <img src="{{ Storage::url($basicDetail->profile_image_path) }}" alt="Profile"
                                class="mt-2 h-20 w-20 rounded-full">
                        @endif
                    </div>

                    {{-- <div class="col-span-6 sm:col-span-3">
                        <label for="resume" class="block text-sm font-medium text-gray-700 dark:text-white">Resume
                            (required)</label>
                        <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx"
                            class="mt-1 block w-full dark:text-white">
                        @if ($basicDetail->resume_path)
                            <a href="{{ Storage::url($basicDetail->resume_path) }}" target="_blank"
                                class="mt-2 text-sm text-indigo-600 hover:text-indigo-500 dark:text-white">View Current
                                Resume</a>
                        @endif
                    </div> --}}
                    <div class="col-span-6 sm:col-span-3">
                        <label for="resume" class="block text-sm font-medium text-gray-700 dark:text-white">Resume
                            (required)</label>
                        <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx"
                            class="mt-1 block w-full dark:text-white" onchange="validateResumeSize(this)">
                        @if ($basicDetail->resume_path)
                            <a href="{{ Storage::url($basicDetail->resume_path) }}" target="_blank"
                                class="mt-2 text-sm text-indigo-600 hover:text-indigo-500 dark:text-white">View Current
                                Resume</a>
                        @endif
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
        // Country list with multiple countries
        const countries = [{
                name: 'India',
                code: 'IN',
                dialCode: '+91',
                flag: '🇮🇳'
            },
            {
                name: 'United States',
                code: 'US',
                dialCode: '+1',
                flag: '🇺🇸'
            },
            {
                name: 'United Kingdom',
                code: 'GB',
                dialCode: '+44',
                flag: '🇬🇧'
            },
            {
                name: 'Canada',
                code: 'CA',
                dialCode: '+1',
                flag: '🇨🇦'
            },
            {
                name: 'Australia',
                code: 'AU',
                dialCode: '+61',
                flag: '🇦🇺'
            },
            {
                name: 'Afghanistan',
                code: 'AF',
                dialCode: '+93',
                flag: '🇦🇫'
            },
            {
                name: 'Albania',
                code: 'AL',
                dialCode: '+355',
                flag: '🇦🇱'
            },
            {
                name: 'Algeria',
                code: 'DZ',
                dialCode: '+213',
                flag: '🇩🇿'
            },
            {
                name: 'Argentina',
                code: 'AR',
                dialCode: '+54',
                flag: '🇦🇷'
            },
            {
                name: 'Bangladesh',
                code: 'BD',
                dialCode: '+880',
                flag: '🇧🇩'
            },
            {
                name: 'Brazil',
                code: 'BR',
                dialCode: '+55',
                flag: '🇧🇷'
            },
            {
                name: 'China',
                code: 'CN',
                dialCode: '+86',
                flag: '🇨🇳'
            },
            {
                name: 'Egypt',
                code: 'EG',
                dialCode: '+20',
                flag: '🇪🇬'
            },
            {
                name: 'France',
                code: 'FR',
                dialCode: '+33',
                flag: '🇫🇷'
            },
            {
                name: 'Germany',
                code: 'DE',
                dialCode: '+49',
                flag: '🇩🇪'
            },
            {
                name: 'Indonesia',
                code: 'ID',
                dialCode: '+62',
                flag: '🇮🇩'
            },
            {
                name: 'Iran',
                code: 'IR',
                dialCode: '+98',
                flag: '🇮🇷'
            },
            {
                name: 'Ireland',
                code: 'IE',
                dialCode: '+353',
                flag: '🇮🇪'
            },
            {
                name: 'Italy',
                code: 'IT',
                dialCode: '+39',
                flag: '🇮🇹'
            },
            {
                name: 'Japan',
                code: 'JP',
                dialCode: '+81',
                flag: '🇯🇵'
            },
            {
                name: 'Malaysia',
                code: 'MY',
                dialCode: '+60',
                flag: '🇲🇾'
            },
            {
                name: 'Mexico',
                code: 'MX',
                dialCode: '+52',
                flag: '🇲🇽'
            },
            {
                name: 'Netherlands',
                code: 'NL',
                dialCode: '+31',
                flag: '🇳🇱'
            },
            {
                name: 'New Zealand',
                code: 'NZ',
                dialCode: '+64',
                flag: '🇳🇿'
            },
            {
                name: 'Pakistan',
                code: 'PK',
                dialCode: '+92',
                flag: '🇵🇰'
            },
            {
                name: 'Philippines',
                code: 'PH',
                dialCode: '+63',
                flag: '🇵🇭'
            },
            {
                name: 'Russia',
                code: 'RU',
                dialCode: '+7',
                flag: '🇷🇺'
            },
            {
                name: 'Saudi Arabia',
                code: 'SA',
                dialCode: '+966',
                flag: '🇸🇦'
            },
            {
                name: 'Singapore',
                code: 'SG',
                dialCode: '+65',
                flag: '🇸🇬'
            },
            {
                name: 'South Africa',
                code: 'ZA',
                dialCode: '+27',
                flag: '🇿🇦'
            },
            {
                name: 'South Korea',
                code: 'KR',
                dialCode: '+82',
                flag: '🇰🇷'
            },
            {
                name: 'Spain',
                code: 'ES',
                dialCode: '+34',
                flag: '🇪🇸'
            },
            {
                name: 'Sweden',
                code: 'SE',
                dialCode: '+46',
                flag: '🇸🇪'
            },
            {
                name: 'Switzerland',
                code: 'CH',
                dialCode: '+41',
                flag: '🇨🇭'
            },
            {
                name: 'Thailand',
                code: 'TH',
                dialCode: '+66',
                flag: '🇹🇭'
            },
            {
                name: 'Turkey',
                code: 'TR',
                dialCode: '+90',
                flag: '🇹🇷'
            },
            {
                name: 'United Arab Emirates',
                code: 'AE',
                dialCode: '+971',
                flag: '🇦🇪'
            },
            {
                name: 'Vietnam',
                code: 'VN',
                dialCode: '+84',
                flag: '🇻🇳'
            },
        ];

        // Initialize country code selector first
        initCountryCodeSelector();

        // Then handle mobile number population
        const mobileInput = document.getElementById('mobile');
        if (mobileInput) {
            const storedMobile = mobileInput.dataset.storedValue;
            // console.log('Stored mobile value:', storedMobile);

            if (storedMobile) {
                try {
                    // Create a pattern that matches any of our country codes
                    const countryCodePattern = new RegExp('^\\+?(' + countries.map(c => c.dialCode.replace('+',
                        '')).join('|') + ')');
                    const countryCodeMatch = storedMobile.match(countryCodePattern);

                    if (countryCodeMatch) {
                        const countryCode = '+' + countryCodeMatch[1];
                        // console.log('Extracted country code:', countryCode);

                        // Find matching country
                        const country = countries.find(c => c.dialCode === countryCode);

                        if (country) {
                            const selected = document.querySelector('#country-code-selector .selected-country');
                            if (selected) {
                                selected.querySelector('.flag').textContent = country.flag;
                                selected.querySelector('.dial-code').textContent = country.dialCode;
                            }
                        }

                        // Set the mobile number value (without country code)
                        const numberWithoutCode = storedMobile.substring(countryCode.length).trim();
                        // console.log('Number without code:', numberWithoutCode);
                        mobileInput.value = numberWithoutCode;
                    }
                } catch (error) {
                    console.error('Error setting initial mobile number:', error);
                }
            }

            // Format phone number as user types
            mobileInput.addEventListener('input', function(e) {
                // Get selected country code
                const countryCode = document.querySelector('#country-code-selector .dial-code')
                    .textContent;
                const input = e.target;
                let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters

                // Format based on country code
                if (countryCode === '+1') {
                    // US/Canada: (XXX) XXX-XXXX
                    if (value.length > 0) {
                        value = value.substring(0, 10); // Limit to 10 digits
                        if (value.length > 6) {
                            value =
                                `(${value.substring(0, 3)}) ${value.substring(3, 6)}-${value.substring(6)}`;
                        } else if (value.length > 3) {
                            value = `(${value.substring(0, 3)}) ${value.substring(3)}`;
                        } else if (value.length > 0) {
                            value = `(${value}`;
                        }
                    }
                } else if (countryCode === '+44') {
                    // UK: XXXX XXXXXX
                    if (value.length > 0) {
                        value = value.substring(0, 11); // Limit to 11 digits
                        if (value.length > 4) {
                            value = `${value.substring(0, 4)} ${value.substring(4)}`;
                        }
                    }
                } else if (countryCode === '+91') {
                    // India: XXXXX XXXXX
                    if (value.length > 0) {
                        value = value.substring(0, 10); // Limit to 10 digits
                        if (value.length > 5) {
                            value = `${value.substring(0, 5)} ${value.substring(5)}`;
                        }
                    }
                } else {
                    // Generic formatting with spaces every 4 digits
                    if (value.length > 0) {
                        // Fix: Handle the case when value length is not divisible by 4
                        value = value.replace(/(.{4})/g, '$1 ').trim();
                    }
                }

                input.value = value;
            });
        }

        // Function to show error message below input field
        // function showError(field, message) {
        //     const input = document.getElementById(field);
        //     if (!input) return;

        //     // Create error message element if it doesn't exist
        //     let errorElement = input.nextElementSibling;
        //     if (!errorElement || !errorElement.classList.contains('error-message')) {
        //         errorElement = document.createElement('p');
        //         errorElement.className = 'error-message mt-1 text-sm text-red-600 dark:text-red-400';
        //         input.parentNode.insertBefore(errorElement, input.nextSibling);
        //     }

        //     // Update error message
        //     errorElement.textContent = message;

        //     // Add error styling to input
        //     input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        // }

        // // Function to clear all error messages
        // function clearErrors() {
        //     // Clear error messages
        //     document.querySelectorAll('.error-message').forEach(element => {
        //         element.textContent = '';
        //     });

        //     // Remove error styling from inputs
        //     document.querySelectorAll('input, textarea').forEach(input => {
        //         input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        //     });
        // }

        function validateResumeSize(input) {
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            clearErrors('resume');

            if (input.files && input.files[0]) {
                const fileSize = input.files[0].size;
                if (fileSize > maxSize) {
                    const sizeInMB = (fileSize / (1024 * 1024)).toFixed(2);
                    showError('resume', `File size (${sizeInMB}MB) exceeds the 5MB limit.`);
                    input.value = ''; // Clear the selected file
                    return false;
                }
            }
            return true;
        }

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

        // Function to clear error message for a specific field
        function clearErrors(field) {
            const input = document.getElementById(field);
            if (!input) return;

            // Clear error message
            let errorElement = input.nextElementSibling;
            if (errorElement && errorElement.classList.contains('error-message')) {
                errorElement.textContent = '';
            }

            // Remove error styling from input
            input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        }

        // Clear errors when input changes
        document.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', () => {
                const errorElement = input.nextElementSibling;
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.textContent = '';
                    input.classList.remove('border-red-500', 'focus:border-red-500',
                        'focus:ring-red-500');
                }
            });
        });

        // Update form submission
        const form = document.getElementById('basic-details-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                clearErrors();

                const countryCode = document.querySelector('#country-code-selector .dial-code')
                    .textContent;
                const mobileNumber = document.getElementById('mobile').value;

                // Remove any existing spaces or special characters from the mobile number
                const cleanMobileNumber = mobileNumber.replace(/\s+/g, '').replace(/[^\d]/g, '');
                const fullMobileNumber = countryCode + cleanMobileNumber;

                // Validation based on country code
                let isValid = true;
                let errorMessage = '';

                // Example validation for common countries
                if (countryCode === '+91' && cleanMobileNumber.length !== 10) {
                    isValid = false;
                    showError('mobile', "Please enter a valid 10-digit Indian mobile number");
                } else if (countryCode === '+1' && cleanMobileNumber.length !== 10) {
                    isValid = false;
                    showError('mobile', "Please enter a valid 10-digit US/Canada mobile number");
                } else if (countryCode === '+44' && (cleanMobileNumber.length < 10 || cleanMobileNumber
                        .length > 11)) {
                    isValid = false;
                    showError('mobile', "Please enter a valid UK mobile number (10-11 digits)");
                } else if (cleanMobileNumber.length < 5) {
                    isValid = false;
                    showError('mobile', "Please enter a valid mobile number");
                }

                // Remove this early return so backend validation always runs
                // if (!isValid) {
                //     return;
                // }

                // Create FormData and proceed with AJAX...
                let formData = new FormData(this);
                formData.set('mobile', fullMobileNumber);

                // Handle skills arrays
                const keySkills = formData.get('key_skills').split(',').map(skill => skill.trim())
                    .filter(Boolean);
                const itSkills = formData.get('it_skills').split(',').map(skill => skill.trim()).filter(
                    Boolean);

                // Remove original entries
                formData.delete('key_skills');
                formData.delete('it_skills');

                // Add skills as arrays
                keySkills.forEach(skill => {
                    formData.append('key_skills[]', skill);
                });

                itSkills.forEach(skill => {
                    formData.append('it_skills[]', skill);
                });

                // Submit form via AJAX
                $.ajax({
                    url: form.getAttribute('action') ||
                        '{{ route('candidate.profile.update-basic-details') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);

                            // If profile image is updated, refresh the image display
                            if (formData.has('profile_image') && formData.get(
                                    'profile_image').size > 0) {
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }
                        } else {
                            toastr.error(response.message || 'Failed to update details');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            // Show all errors at once
                            Object.keys(errors).forEach(field => {
                                const errorMessage = errors[field][0];
                                showError(field, errorMessage);
                            });
                            // Scroll to first error
                            const firstError = document.querySelector('.error-message');
                            if (firstError) {
                                window.scrollTo({
                                    top: firstError.getBoundingClientRect().top +
                                        window.scrollY - 100,
                                    behavior: 'smooth'
                                });
                            }
                        } else {
                            // General error
                            toastr.error(xhr.responseJSON?.message ||
                                'Something went wrong. Please try again.');
                        }
                    }
                });
            });
        }

        // Define the initCountryCodeSelector function
        function initCountryCodeSelector() {
            const selector = document.getElementById('country-code-selector');
            if (!selector) {
                console.error('Country code selector not found in the DOM');
                return;
            }

            const selected = selector.querySelector('.selected-country');
            if (!selected) {
                console.error('Selected country element not found');
                return;
            }

            const countryList = selector.querySelector('.country-list');
            if (!countryList) {
                console.error('Country list element not found');
                return;
            }

            const countriesContainer = selector.querySelector('.countries');
            if (!countriesContainer) {
                console.error('Countries container not found');
                return;
            }

            const searchInput = selector.querySelector('.country-search');
            if (!searchInput) {
                console.error('Country search input not found');
                return;
            }

            // Clear and populate countries
            countriesContainer.innerHTML = '';
            countries.sort((a, b) => a.name.localeCompare(b.name)).forEach(country => {
                const div = document.createElement('div');
                div.className = 'country-item';
                div.innerHTML = `
                <span class="flag">${country.flag}</span>
                <span class="name">${country.name}</span>
                <span class="dial-code">${country.dialCode}</span>
            `;
                div.dataset.code = country.code;
                div.dataset.dialCode = country.dialCode;
                div.dataset.flag = country.flag;
                countriesContainer.appendChild(div);
            });

            // Toggle country list
            selected.addEventListener('click', (e) => {
                e.stopPropagation();
                countryList.classList.toggle('show');
                if (countryList.classList.contains('show')) {
                    searchInput.focus();
                    searchInput.value = '';
                    // Reset search results
                    const items = countriesContainer.querySelectorAll('.country-item');
                    items.forEach(item => item.style.display = 'flex');
                }
            });

            // Handle country selection
            countriesContainer.addEventListener('click', (e) => {
                const countryItem = e.target.closest('.country-item');
                if (countryItem) {
                    selected.querySelector('.flag').textContent = countryItem.dataset.flag;
                    selected.querySelector('.dial-code').textContent = countryItem.dataset.dialCode;
                    countryList.classList.remove('show');

                    // Trigger change event for form validation
                    const event = new Event('countrychange');
                    selector.dispatchEvent(event);
                }
            });

            // Search functionality
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const items = countriesContainer.querySelectorAll('.country-item');
                items.forEach(item => {
                    const name = item.querySelector('.name').textContent.toLowerCase();
                    const dialCode = item.querySelector('.dial-code').textContent.toLowerCase();
                    item.style.display = name.includes(searchTerm) || dialCode.includes(
                        searchTerm) ? 'flex' : 'none';
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', () => {
                countryList.classList.remove('show');
            });

            // Prevent propagation for search input
            searchInput.addEventListener('click', (e) => {
                e.stopPropagation();
            });

            // Log successful initialization
            // console.log('Country code selector initialized successfully');
        }
    });
</script>
