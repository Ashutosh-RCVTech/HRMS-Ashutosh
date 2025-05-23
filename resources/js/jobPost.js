document.addEventListener('DOMContentLoaded', function () {
    // Get all tab elements
    const tabs = document.querySelectorAll('[data-content]');
    const tabButtons = document.querySelectorAll('.tab-button');

    // Function to safely get element
    function getElement(selector) {
        return document.querySelector(selector);
    }

    // Function to safely add event listener
    function addSafeEventListener(element, event, handler) {
        if (element) {
            element.addEventListener(event, handler);
        }
    }

    // Function to update progress bar and step indicators
    function updateProgressBar(currentTab) {
        const progressBar = document.getElementById('progress-bar');
        const stepIndicators = document.querySelectorAll('.tab-button');
        const totalSteps = stepIndicators.length;
        if (!progressBar || !stepIndicators.length) return;

        // Calculate progress (currentTab is zero-based)
        const progress = (currentTab / (totalSteps - 1)) * 100;
        progressBar.style.width = `${progress}%`;

        // Update step indicators
        stepIndicators.forEach((step, index) => {
            const number = step.querySelector('.rounded-full');
            const text = step.querySelector('.text-sm');
            if (!number || !text) return;
            if (index < currentTab) {
                number.classList.remove('bg-gray-200', 'text-gray-500', 'dark:bg-gray-700', 'dark:text-gray-400');
                number.classList.add('bg-blue-600', 'text-white');
                text.classList.remove('text-gray-500', 'dark:text-gray-400');
                text.classList.add('text-gray-700', 'dark:text-gray-300');
            } else if (index === currentTab) {
                number.classList.remove('bg-gray-200', 'text-gray-500', 'dark:bg-gray-700', 'dark:text-gray-400');
                number.classList.add('bg-blue-600', 'text-white');
                text.classList.remove('text-gray-500', 'dark:text-gray-400');
                text.classList.add('text-gray-700', 'dark:text-gray-300');
            } else {
                number.classList.remove('bg-blue-600', 'text-white');
                number.classList.add('bg-gray-200', 'text-gray-500', 'dark:bg-gray-700', 'dark:text-gray-400');
                text.classList.remove('text-gray-700', 'dark:text-gray-300');
                text.classList.add('text-gray-500', 'dark:text-gray-400');
            }
        });
    }

    // Function to validate a specific tab
    function validateTab(tabIndex) {
        const tab = document.querySelector(`[data-content="${tabIndex + 1}"]`);
        if (!tab) return true;

        const inputs = tab.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        // Clear existing error messages
        tab.querySelectorAll('.error-message').forEach(el => el.remove());

        // Validate inputs
        inputs.forEach(input => {
            if (input && !input.checkValidity()) {
                isValid = false;
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message text-red-500 text-sm dark:text-red-400 font-medium mt-1 block';
                errorMessage.textContent = input.validationMessage || 'This field is required';
                if (input.parentElement) input.parentElement.appendChild(errorMessage);
            }
        });

        return isValid;
    }

    // Function to show the correct tab
    function showTab(tabIndex) {
        if (!tabs.length || tabIndex >= tabs.length) {
            console.warn('Tab elements not found or invalid index');
            return false;
        }

        // Hide all tabs
        tabs.forEach(tab => {
            if (tab) tab.classList.add('hidden');
        });

        // Show the selected tab
        if (tabs[tabIndex]) tabs[tabIndex].classList.remove('hidden');

        // Update progress bar
        updateProgressBar(tabIndex);

        return true;
    }

    // Handle navigation buttons
    document.querySelectorAll('.next-tab').forEach(button => {
        addSafeEventListener(button, 'click', function () {
            const currentTab = document.querySelector('[data-content]:not(.hidden)');
            const currentTabIndex = Array.from(tabs).indexOf(currentTab);
            const nextIndex = parseInt(this.dataset.next || '1') - 1;

            // Validate current tab before moving to next
            if (validateTab(currentTabIndex)) {
                showTab(nextIndex);
            }
        });
    });

    document.querySelectorAll('.back-tab').forEach(button => {
        addSafeEventListener(button, 'click', function () {
            const prevIndex = parseInt(this.dataset.prev || '1') - 1;
            showTab(prevIndex);
        });
    });

    // Make step indicators clickable and allow direct navigation
    tabButtons.forEach(button => {
        addSafeEventListener(button, 'click', function () {
            const tabIndex = parseInt(this.getAttribute('data-tab') || '1') - 1;
            const currentTab = document.querySelector('[data-content]:not(.hidden)');
            const currentTabIndex = Array.from(tabs).indexOf(currentTab);
            // Only validate if moving forward
            if (tabIndex > currentTabIndex) {
                if (validateTab(currentTabIndex)) {
                    showTab(tabIndex);
                }
            } else {
                showTab(tabIndex);
            }
        });
    });

    // Initialize selection buttons
    document.querySelectorAll('[data-selected]').forEach(button => {
        if (!button) return;

        const isSelected = button.getAttribute('data-selected') === 'true';
        const plusSymbol = button.querySelector('.plus-symbol');
        const checkSymbol = button.querySelector('.check-symbol');
        const onclickAttr = button.getAttribute('onclick');
        const hiddenInput = onclickAttr ? document.getElementById(onclickAttr.split("'")[1]) : null;

        if (isSelected) {
            button.classList.remove('bg-gray-400');
            button.classList.add('bg-green-500', 'text-white');
            if (plusSymbol) plusSymbol.style.display = 'none';
            if (checkSymbol) {
                checkSymbol.style.display = 'inline';
                checkSymbol.classList.remove('hidden');
            }
            if (hiddenInput) {
                hiddenInput.value = button.getAttribute('data-id') || 'selected';
            }
        }
    });

    // Toggle selection function
    window.toggleSelection = function (button, inputId) {
        if (!button) return;

        const hiddenInput = document.getElementById(inputId);
        const plusSymbol = button.querySelector('.plus-symbol');
        const checkSymbol = button.querySelector('.check-symbol');
        const isCurrentlySelected = button.classList.contains('bg-green-500');

        if (isCurrentlySelected) {
            button.classList.remove('bg-green-500', 'text-white');
            button.classList.add('bg-gray-400');
            if (plusSymbol) plusSymbol.style.display = 'inline';
            if (checkSymbol) checkSymbol.style.display = 'none';
            if (hiddenInput) hiddenInput.value = '';
            button.setAttribute('data-selected', 'false');
        } else {
            button.classList.remove('bg-gray-400');
            button.classList.add('bg-green-500', 'text-white');
            if (plusSymbol) plusSymbol.style.display = 'none';
            if (checkSymbol) checkSymbol.style.display = 'inline';
            if (hiddenInput) hiddenInput.value = button.getAttribute('data-id') || '';
            button.setAttribute('data-selected', 'true');
        }
    };

    // Form submission handling
    const form = getElement('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            try {
                const selections = {
                    jobTypes: document.querySelectorAll('.job-type-btn[data-selected="true"]'),
                    schedules: document.querySelectorAll('.schedule-btn[data-selected="true"]'),
                    benefits: document.querySelectorAll('.benefit-btn[data-selected="true"]'),
                    locations: document.querySelectorAll('.location-btn[data-selected="true"]')
                };

                const inputs = {
                    jobTypes: getElement('#selectedJobTypes'),
                    schedules: getElement('#selectedSchedules'),
                    benefits: getElement('#selectedBenefits'),
                    locations: getElement('#selectedLocations')
                };

                Object.entries(selections).forEach(([key, elements]) => {
                    const values = Array.from(elements).map(el => el.getAttribute('data-id')).filter(Boolean);
                    if (inputs[key]) {
                        inputs[key].value = values.join(',');
                    }
                });
            } catch (error) {
                console.error('Error collecting selections:', error);
            }
        });
    }

    // AI Description Generator
    const generateButton = getElement('#generate-ai-description');
    let originalContent = '';
    if (generateButton) {
        addSafeEventListener(generateButton, 'click', async function () {
            try {
                // Always get the degree value as a string
                let degreeValue = getElement('#degree')?.value || '';
                console.log('Degree value before sending:', degreeValue); // Debug log
                if (!degreeValue) {
                    toastr.error('Please select a Degree.');
                    return;
                }
                const requiredFields = {
                    title: getElement('#title')?.value,
                    experience: getElement('#experience_required')?.value,
                    degree: degreeValue,
                    educationLevel: getElement('#education_level')?.value,
                    client: getElement('#client')?.value,
                    skills: getElement('#skill-ids')?.value
                };
                const missingFields = Object.entries(requiredFields)
                    .filter(([key, value]) => !value || (key === 'skills' && (!value || value.split(',').length === 0)))
                    .map(([key]) => {
                        switch (key) {
                            case 'title': return 'Job Title';
                            case 'experience': return 'Experience Required';
                            case 'degree': return 'Degree';
                            case 'educationLevel': return 'Education Level';
                            case 'client': return 'Client';
                            case 'skills': return 'Skills';
                            default: return key;
                        }
                    });
                if (missingFields.length > 0) {
                    toastr.error('Please fill in all required fields: ' + missingFields.join(', '));
                    return;
                }

                generateButton.disabled = true;
                originalContent = generateButton.innerHTML;
                generateButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Generating...
                `;

                const csrfToken = getElement('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    throw new Error('CSRF token not found');
                }

                // Debug log payload
                // console.log('Payload:', {
                //     title: requiredFields.title,
                //     client: requiredFields.client,
                //     skills: requiredFields.skills ? requiredFields.skills.split(',') : [],
                //     experience: requiredFields.experience,
                //     degree: requiredFields.degree,
                //     education_level: requiredFields.educationLevel
                // });

                const response = await fetch('/admin/jobs/generateJobDescription', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        title: requiredFields.title,
                        client: requiredFields.client,
                        skills: requiredFields.skills ? requiredFields.skills.split(',') : [],
                        experience: requiredFields.experience,
                        degree: requiredFields.degree,
                        education_level: requiredFields.educationLevel
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.error || 'Failed to generate description');
                }

                const data = await response.json();
                const descriptionTextarea = getElement('#job_description');
                if (descriptionTextarea) {
                    descriptionTextarea.value = data.description;
                    // Trigger input event to update any listeners
                    descriptionTextarea.dispatchEvent(new Event('input'));
                }

                toastr.success('Job description generated successfully!');
            } catch (error) {
                console.error('Error generating description:', error);
                toastr.error(error.message || 'Failed to generate job description');
            } finally {
                // Restore button state
                if (generateButton && originalContent) {
                    generateButton.disabled = false;
                    generateButton.innerHTML = originalContent;
                }
            }
        });
    }

    // Popover functionality
    const descriptionHelpBtn = getElement('#popover-btn');
    const descriptionHelp = getElement('#description-help');

    if (descriptionHelpBtn && descriptionHelp) {
        const togglePopoverVisibility = (show) => {
            if (show) {
                descriptionHelp.classList.remove('invisible', 'opacity-0');
                descriptionHelp.classList.add('visible', 'opacity-100');
            } else {
                descriptionHelp.classList.remove('visible', 'opacity-100');
                descriptionHelp.classList.add('invisible', 'opacity-0');
            }
        };

        addSafeEventListener(descriptionHelpBtn, 'mouseenter', () => togglePopoverVisibility(true));
        addSafeEventListener(descriptionHelpBtn, 'mouseleave', () => togglePopoverVisibility(false));
        addSafeEventListener(descriptionHelp, 'mouseenter', () => togglePopoverVisibility(true));
        addSafeEventListener(descriptionHelp, 'mouseleave', () => togglePopoverVisibility(false));
    }

    // Show the first tab by default
    showTab(0);
});

