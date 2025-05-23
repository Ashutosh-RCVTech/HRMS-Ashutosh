<div class="bg-white dark:bg-slate-900 shadow-lg rounded-lg p-4 mb-6">
    <form id="searchForm" method="GET" action="{{ route('candidate.dashboard') }}">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

            <!-- Search Field -->
            <div class="flex-1 relative">
                <div class="bg-gray-100 dark:bg-slate-900 dark:text-white rounded-lg p-2 w-full flex items-center">
                    <div class="bg-gray-300 dark:bg-darkblack-700 text-black dark:text-white rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search role..."
                        class="bg-transparent dark:text-white rounded-lg mx-2 p-2 w-full focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <!-- Work Location -->
            <div class="flex-1 relative">
                <div class="bg-gray-100 dark:bg-slate-900 dark:text-white rounded-lg p-2 w-full flex items-center">
                    <div class="bg-gray-300 dark:bg-darkblack-700 text-black dark:text-white rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2C8.13 2 5 5.13 5 8.5c0 4.5 7 11 7 11s7-6.5 7-11c0-3.37-3.13-6.5-7-6.5zM12 11c-1.74 0-3-1.26-3-2.5S10.26 6 12 6s3 1.26 3 2.5S13.74 11 12 11z" />
                        </svg>
                    </div>
                    <select name="filters[work_location]"
                        class="bg-transparent dark:text-white rounded-lg mx-2 p-2 w-full dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Work location</option>

                        @foreach ($locations as $location)
                            <option value="{{ $location }}"
                                {{ request('filters.work_location') == $location ? 'selected' : '' }}>
                                {{ $location }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            <!-- Experience Required -->
            <div class="flex-1 relative">
                <div class="bg-gray-100 dark:bg-slate-900 dark:text-white rounded-lg p-2 w-full flex items-center">
                    <div class="bg-gray-300 dark:bg-darkblack-700 text-black dark:text-white rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3h8v4M3 7h18v14H3V7z" />
                        </svg>
                    </div>
                    <select name="filters[experience_required]"
                        class="bg-transparent dark:text-white rounded-lg mx-2 p-2 w-full dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Experience</option>
                        @foreach ($experiences as $experience)
                            <option value="{{ $experience }}"
                                {{ request('filters.experience_required') == $experience ? 'selected' : '' }}>
                                {{ $experience }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            <!-- Salary Range -->
            <div class="flex-1 relative">
                <div class="bg-gray-100 dark:bg-slate-900 dark:text-white rounded-lg p-2 w-full flex items-center">
                    <div class="bg-gray-300 dark:bg-darkblack-700 text-black dark:text-white rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="mx-2 w-full">
                        <div id="salary-slider"
                            class="w-full h-2 bg-gray-300 dark:bg-darkblack-700 rounded-full mt-2 mb-4"></div>
                        <div class="flex justify-between text-sm">
                            <span>₹<span id="display-min-salary">0</span></span>
                            <span>₹<span id="display-max-salary">20000000</span> LPA</span>
                        </div>
                        <input type="hidden" id="minSalary" name="filters[min_salary]"
                            value="{{ request('filters.min_salary', '') }}">
                        <input type="hidden" id="maxSalary" name="filters[max_salary]"
                            value="{{ request('filters.max_salary', '') }}">
                    </div>
                </div>
            </div>

            <!-- Apply/Reset Buttons -->
            <div class="flex-1 relative flex items-center space-x-2">
                <button type="submit"
                    class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg flex-grow">
                    Apply Filters
                </button>
                <button type="button" id="resetFilters"
                    class="bg-gray-300 hover:bg-gray-400 dark:bg-darkblack-700 dark:hover:bg-darkblack-600 dark:text-white py-2 px-4 rounded-lg">
                    Reset
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.querySelector('input[name="search"]');
        const selectInputs = document.querySelectorAll('select');
        const minSalaryInput = document.getElementById("minSalary");
        const maxSalaryInput = document.getElementById("maxSalary");
        const displayMinSalary = document.getElementById("display-min-salary");
        const displayMaxSalary = document.getElementById("display-max-salary");
        const resetButton = document.getElementById("resetFilters");

        // Default salary range values
        //Updatred the constant value of min....
        const DEFAULT_MIN_SALARY = 0;
        const DEFAULT_MAX_SALARY = 20000000;

        // Set initial values if not provided in request
        if (!minSalaryInput.value) minSalaryInput.value = DEFAULT_MIN_SALARY;
        if (!maxSalaryInput.value) maxSalaryInput.value = DEFAULT_MAX_SALARY;

        // Update display values
        displayMinSalary.textContent = parseInt(minSalaryInput.value).toLocaleString();
        displayMaxSalary.textContent = parseInt(maxSalaryInput.value).toLocaleString();

        // Initialize slider (using a simple implementation here)
        const sliderElement = document.getElementById('salary-slider');

        // Create a simple interactive salary slider with HTML/CSS (can be replaced with a proper slider library)
        let isDragging = false;
        let activeHandle = null;
        const minHandle = document.createElement('div');
        minHandle.className = 'absolute w-4 h-4 bg-primary-500 rounded-full -mt-1 cursor-pointer';
        minHandle.style.left = '0%';

        const maxHandle = document.createElement('div');
        maxHandle.className = 'absolute w-4 h-4 bg-primary-500 rounded-full -mt-1 cursor-pointer';
        maxHandle.style.left = '100%';

        const sliderTrack = document.createElement('div');
        sliderTrack.className = 'absolute h-2 bg-primary-300 rounded-full';
        sliderTrack.style.left = '0%';
        sliderTrack.style.width = '100%';

        sliderElement.style.position = 'relative';
        sliderElement.appendChild(sliderTrack);
        sliderElement.appendChild(minHandle);
        sliderElement.appendChild(maxHandle);

        // Calculate handle positions based on current values
        function updateHandlePositions() {
            const min = parseInt(minSalaryInput.value);
            const max = parseInt(maxSalaryInput.value);
            const range = DEFAULT_MAX_SALARY - DEFAULT_MIN_SALARY;

            const minPos = ((min - DEFAULT_MIN_SALARY) / range) * 100;
            const maxPos = ((max - DEFAULT_MIN_SALARY) / range) * 100;

            minHandle.style.left = `${minPos}%`;
            maxHandle.style.left = `${maxPos}%`;

            sliderTrack.style.left = `${minPos}%`;
            sliderTrack.style.width = `${maxPos - minPos}%`;
        }

        updateHandlePositions();

        // Handle slider drag events
        minHandle.addEventListener('mousedown', (e) => {
            isDragging = true;
            activeHandle = 'min';
            e.preventDefault();
        });

        maxHandle.addEventListener('mousedown', (e) => {
            isDragging = true;
            activeHandle = 'max';
            e.preventDefault();
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;

            const rect = sliderElement.getBoundingClientRect();
            const pos = (e.clientX - rect.left) / rect.width;
            const range = DEFAULT_MAX_SALARY - DEFAULT_MIN_SALARY;
            let value = Math.round(DEFAULT_MIN_SALARY + (pos * range));

            // Constrain values
            value = Math.max(DEFAULT_MIN_SALARY, Math.min(DEFAULT_MAX_SALARY, value));

            if (activeHandle === 'min') {
                // Ensure min doesn't exceed max
                value = Math.min(value, parseInt(maxSalaryInput.value) - 10000);
                minSalaryInput.value = value;
                displayMinSalary.textContent = value.toLocaleString();
            } else {
                // Ensure max doesn't go below min
                value = Math.max(value, parseInt(minSalaryInput.value) + 10000);
                maxSalaryInput.value = value;
                displayMaxSalary.textContent = value.toLocaleString();
            }

            updateHandlePositions();
        });

        document.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
                debounceSubmit();
            }
        });

        // Debounce function
        let debounceTimer;
        const debounceSubmit = () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchForm.submit();
            }, 800); // Increased debounce time for better user experience
        };

        // Search Input
        if (searchInput) {
            searchInput.addEventListener('input', debounceSubmit);
        }

        // Select Inputs
        selectInputs.forEach(select => {
            select.addEventListener('change', () => {
                searchForm.submit();
            });
        });

        // Reset button functionality
        resetButton.addEventListener('click', () => {
            // Clear search input
            if (searchInput) searchInput.value = '';

            // Reset all select elements
            selectInputs.forEach(select => {
                select.selectedIndex = 0;
            });

            // Reset salary range to defaults
            minSalaryInput.value = DEFAULT_MIN_SALARY;
            maxSalaryInput.value = DEFAULT_MAX_SALARY;
            displayMinSalary.textContent = DEFAULT_MIN_SALARY.toLocaleString();
            displayMaxSalary.textContent = DEFAULT_MAX_SALARY.toLocaleString();

            updateHandlePositions();

            // Submit the form
            searchForm.submit();
        });
    });
</script>   