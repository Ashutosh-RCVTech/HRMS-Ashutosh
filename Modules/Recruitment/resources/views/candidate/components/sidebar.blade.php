<div class="w-full lg:w-1/4">
    <div class="bg-gradient-to-br from-primary-500 to-primary-900 text-white rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Get Your best profession with RCVJob</h2>
        {{-- <button class="bg-white text-primary-500 px-4 py-2 rounded-lg hover:bg-gray-100">Learn more</button> --}}
    </div>

    <form method="GET" action="{{ route('candidate.dashboard') }}">
        {{-- <div class="bg-white dark:bg-slate-900 shadow-lg rounded-lg p-4 h-[500px] overflow-y-auto">
            <h3 class="font-bold mb-4 dark:text-white">Filters</h3>

            <!-- Job Type Filter -->
            <div class="filter-section mb-4">
                <div class="filter-header flex items-center justify-between cursor-pointer"
                    onclick="toggleFilter('jobType')">
                    <h4 class="font-medium dark:text-white">Job Type</h4>
                    <svg class="w-4 h-4 transform transition-transform duration-200 dark:text-white" id="jobType-icon"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="filter-content hidden space-y-3 mt-3" id="jobType-content">
                    @foreach ($jobTypes as $jobType)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="filters[job_type][]" value="{{ $jobType->id }}"
                                class="peer hidden filter-checkbox"
                                {{ in_array($jobType->id, request()->input('filters.job_type', [])) ? 'checked' : '' }}>
                            <div
                                class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded
                            peer-checked:border-primary-500 peer-checked:bg-primary-500">
                            </div>
                            <span class="text-gray-700 dark:text-white">{{ $jobType->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Schedule Filter -->
            <div class="filter-section mb-4">
                <div class="filter-header flex items-center justify-between cursor-pointer"
                    onclick="toggleFilter('schedule')">
                    <h4 class="font-medium dark:text-white">Schedule</h4>
                    <svg class="w-4 h-4 transform transition-transform duration-200 dark:text-white" id="schedule-icon"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="filter-content hidden space-y-3 mt-3" id="schedule-content">
                    @foreach ($schedules as $schedule)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="filters[schedule][]" value="{{ $schedule->id }}"
                                class="peer hidden filter-checkbox"
                                {{ in_array($schedule->id, request()->input('filters.schedule', [])) ? 'checked' : '' }}>
                            <div
                                class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded
                            peer-checked:border-primary-500 peer-checked:bg-primary-500">
                            </div>
                            <span class="text-gray-700 dark:text-white">{{ $schedule->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Skill Filter -->
            <div class="filter-section mb-4">
                <div class="filter-header flex items-center justify-between cursor-pointer"
                    onclick="toggleFilter('skills')">
                    <h4 class="font-medium dark:text-white">Skills</h4>
                    <svg class="w-4 h-4 transform transition-transform duration-200 dark:text-white" id="skills-icon"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="filter-content hidden space-y-3 mt-3" id="skills-content">
                    @foreach ($skills as $skill)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="filters[skills][]" value="{{ $skill->id }}"
                                class="peer hidden filter-checkbox"
                                {{ in_array($skill->id, request()->input('filters.skills', [])) ? 'checked' : '' }}>
                            <div
                                class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded
                            peer-checked:border-primary-500 peer-checked:bg-primary-500">
                            </div>
                            <span class="text-gray-700 dark:text-white">{{ $skill->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg mt-4">Apply Filters</button>
        </div> --}}
        <!-- Responsive Filter Panel -->
        <div class="bg-white dark:bg-slate-900 shadow-lg rounded-lg p-4 max-h-[90vh] overflow-y-auto md:max-h-[500px]">
            <h3 class="font-bold mb-4 dark:text-white">Filters</h3>

            <!-- Example Filter Group Template -->
            @foreach ([['label' => 'Job Type', 'items' => $jobTypes, 'key' => 'job_type'], ['label' => 'Schedule', 'items' => $schedules, 'key' => 'schedule'], ['label' => 'Skills', 'items' => $skills, 'key' => 'skills']] as $filter)
                <div class="filter-section mb-4">
                    <!-- Header -->
                    <div class="filter-header flex items-center justify-between cursor-pointer"
                        onclick="toggleFilter('{{ $filter['key'] }}')">
                        <h4 class="font-medium dark:text-white">{{ $filter['label'] }}</h4>
                        <svg class="w-4 h-4 transform transition-transform duration-200 dark:text-white"
                            id="{{ $filter['key'] }}-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="filter-content hidden mt-3 max-h-48 overflow-y-auto pr-1 space-y-3 transition-all duration-300"
                        id="{{ $filter['key'] }}-content">
                        @foreach ($filter['items'] as $item)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="filters[{{ $filter['key'] }}][]"
                                    value="{{ $item->id }}" class="peer hidden filter-checkbox"
                                    {{ in_array($item->id, request()->input("filters.{$filter['key']}", [])) ? 'checked' : '' }}>
                                <div
                                    class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded
                            peer-checked:border-primary-500 peer-checked:bg-primary-500">
                                </div>
                                <span class="text-gray-700 dark:text-white">{{ $item->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg mt-4 w-full">
                Apply Filters
            </button>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        function toggleFilter(sectionId) {
            const content = document.getElementById(`${sectionId}-content`);
            const icon = document.getElementById(`${sectionId}-icon`);

            // Toggle content visibility
            content.classList.toggle('hidden');

            // Rotate icon
            icon.style.transform = content.classList.contains('hidden') ?
                'rotate(0deg)' :
                'rotate(180deg)';
        }

        // Attach click event to filter headers
        document.querySelectorAll('.filter-header').forEach(header => {
            header.addEventListener('click', (e) => {
                const sectionId = e.currentTarget.querySelector('svg').id.replace('-icon', '');
                toggleFilter(sectionId);
            });
        });

        // Open Job Type filter by default
        toggleFilter('jobType');
    });
</script>
