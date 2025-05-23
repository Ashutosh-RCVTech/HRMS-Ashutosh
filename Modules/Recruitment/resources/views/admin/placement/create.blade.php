@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <h1 class="text-2xl font-bold mb-8">Add Placement Drive</h1>

                <form method="POST" action="{{ route('admin.placement.store') }}" id="form_submit">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                            Name
                        </label>
                        <input id="name" name="name" type="text" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                                           focus:border-indigo-500 focus:ring-indigo-500 
                                                                           dark:bg-slate-800 dark:text-white dark:border-gray-700" placeholder="Enter Drive Name">
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                                           focus:border-indigo-500 focus:ring-indigo-500 
                                                                           dark:bg-slate-800 dark:text-white dark:border-gray-700" placeholder="Enter Drive description"></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="openings" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                            No. of Openings
                        </label>
                        <input id="openings" name="openings" type="number" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                                           focus:border-indigo-500 focus:ring-indigo-500 
                                                                           dark:bg-slate-800 dark:text-white dark:border-gray-700" placeholder="Enter no. of openings">
                    </div>


                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2 dark:bg-slate-900 dark:text-white"
                            for="education_level">Education Level</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-slate-900 dark:text-white"
                            name="education_level" id="education_level">
                            @foreach ($educationLevels as $level)
                                <option value="{{ $level->id }}">
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('education_level')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="relative mb-6">
                        <label for="college_search" class="block text-sm font-bold mb-2 text-gray-700 dark:text-white">
                            Select College <span class="text-red-500">*</span>
                        </label>
                        <div id="selected_colleges" class="flex flex-wrap gap-2 mb-1"></div>
                        <p id="college_error" class="text-red-500 text-sm mb-1"></p>
                        <div class="relative">
                            <input type="text" id="college_search"
                                class="w-full border rounded px-3 py-2 shadow focus:outline-none dark:bg-slate-900 dark:text-white"
                                placeholder="Search for a college..." autocomplete="off">
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
                    </div>


                    <div class="relative mb-6">
                        <label for="skill_search" class="block text-sm font-bold mb-2 text-gray-700 dark:text-white">
                            Select Skills <span class="text-red-500">*</span>
                        </label>
                        <div id="selected_skills" class="flex flex-wrap gap-2 mb-1"></div>
                        <p id="skill_error" class="text-red-500 text-sm mb-1"></p>
                        <div class="relative">
                            <input type="text" id="skill_search"
                                class="w-full border rounded px-3 py-2 shadow focus:outline-none dark:bg-slate-900 dark:text-white"
                                placeholder="Search for a skill..." autocomplete="off">
                            <div id="skill_dropdown"
                                class="hidden absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 shadow rounded max-h-60 overflow-auto">
                                <div class="py-1">
                                    <div id="skill_list" class="divide-y divide-gray-100 dark:divide-gray-600"></div>
                                    <div id="skill_loading_more"
                                        class="hidden px-4 py-2 text-center text-gray-500 dark:text-gray-300">
                                        Loading more...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="relative mb-6">
                        <label for="degree_search" class="block text-sm font-bold mb-2 text-gray-700 dark:text-white">
                            Select Degree <span class="text-red-500">*</span>
                        </label>

                        <!-- Selected Tags -->
                        <div id="selected_degrees" class="flex flex-wrap gap-2 mb-1"></div>
                        <p id="degree_error" class="text-red-500 text-sm mb-1"></p>
                        <div class="relative">
                            <input type="text" id="degree_search"
                                class="w-full border rounded px-3 py-2 shadow focus:outline-none dark:bg-slate-900 dark:text-white"
                                placeholder="Search for a degree..." autocomplete="off">

                            <!-- Dropdown -->
                            <div id="degree_dropdown"
                                class="hidden absolute z-10 mt-1 w-full bg-white dark:bg-slate-800 shadow rounded max-h-60 overflow-auto">
                                <div class="py-1">
                                    <div id="degree_list" class="divide-y divide-gray-100 dark:divide-gray-600"></div>
                                    <div id="degree_loading_more"
                                        class="hidden px-4 py-2 text-center text-gray-500 dark:text-gray-300">Loading
                                        more...</div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mt-8">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                                                                           rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                                                           hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none 
                                                                           focus:border-indigo-900 focus:ring ring-indigo-300 
                                                                           disabled:opacity-25 transition ease-in-out duration-150">
                            Create Drive
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>


    {{-- College Search --}}
    <script>
        const collegeSearch = document.getElementById('college_search');
        const collegeDropdown = document.getElementById('college_dropdown');
        const collegeList = document.getElementById('college_list');
        const loadingMoreColleges = document.getElementById('college_loading_more');
        const selectedCollegesContainer = document.getElementById('selected_colleges');

        let collegePage = 1;
        let isCollegeLoading = false;
        let hasMoreColleges = true;
        let collegeSearchTimeout;
        const selectedColleges = new Map();

        collegeSearch.addEventListener('focus', () => collegeDropdown.classList.remove('hidden'));

        document.addEventListener('click', (e) => {
            if (!collegeSearch.contains(e.target) && !collegeDropdown.contains(e.target)) {
                collegeDropdown.classList.add('hidden');
            }
        });

        collegeSearch.addEventListener('input', (e) => {
            clearTimeout(collegeSearchTimeout);
            collegeSearchTimeout = setTimeout(() => {
                collegePage = 1;
                loadColleges(e.target.value);
            }, 300);
        });
        console.log(selectedColleges)

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

            if (selectedColleges.has(id)) {
                selectedColleges.delete(id);
            } else {
                if (selectedColleges.size >= 10) {
                    document.querySelector('#college_error').textContent = "You can select up to 10 colleges.";
                    return;
                }
                document.querySelector('#college_error').textContent = "";
                selectedColleges.set(id, name);
            }

            updateSelectedColleges();
        });

        function makeCollegeOption(college) {
            const wrapper = document.createElement('div');
            wrapper.className = 'college-option flex items-center px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 cursor-pointer';
            wrapper.dataset.id = college.id;
            wrapper.dataset.name = college.name;
            wrapper.innerHTML = `
                <input type="checkbox" class="mr-2" disabled ${selectedColleges.has(String(college.id)) ? 'checked' : ''}/>
                <span class="text-gray-700 dark:text-white">${college.name}</span>
            `;
            return wrapper;
        }

        function updateSelectedColleges() {
            selectedCollegesContainer.innerHTML = '';

            selectedColleges.forEach((name, id) => {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-indigo-100 dark:bg-slate-700 text-indigo-700 dark:text-white text-sm rounded px-2 py-1';
                tag.innerHTML = `<span>${name}</span>
                    <button type="button" class="ml-2 remove-college text-lg" data-id="${id}">&times;</button>`;
                selectedCollegesContainer.appendChild(tag);

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'college_id[]';
                hiddenInput.value = id;
                selectedCollegesContainer.appendChild(hiddenInput);
            });

            collegeSearch.value = '';
            loadColleges();
        }

        selectedCollegesContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-college')) {
                const id = e.target.dataset.id;
                selectedColleges.delete(id);
                updateSelectedColleges();
            }
        });

        async function loadColleges(searchTerm = '') {
            isCollegeLoading = true;
            hasMoreColleges = true;
            try {
                const res = await fetch(`{{ route('admin.placement.search.college') }}?search=${encodeURIComponent(searchTerm)}&page=1`);
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
                const res = await fetch(`{{ route('admin.placement.search.college') }}?search=${encodeURIComponent(term)}&page=${collegePage + 1}`);
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
            if (selectedColleges.size === 0) {
                e.preventDefault();
                document.querySelector('#college_error').textContent = "Please select at least one college.";
            }
        });

    </script>


    {{-- degree --}}
    <script>
        const degreeSearch = document.getElementById('degree_search');
        const degreeDropdown = document.getElementById('degree_dropdown');
        const degreeList = document.getElementById('degree_list');
        const loadingMoreDegrees = document.getElementById('degree_loading_more');
        const selectedContainer = document.getElementById('selected_degrees');

        let degreePage = 1;
        let isDegreeLoading = false;
        let hasMoreDegrees = true;
        let degreeSearchTimeout;
        const selectedDegrees = new Map();

        degreeSearch.addEventListener('focus', () => {
            degreeDropdown.classList.remove('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!degreeSearch.contains(e.target) && !degreeDropdown.contains(e.target)) {
                degreeDropdown.classList.add('hidden');
            }
        });

        degreeSearch.addEventListener('input', (e) => {
            clearTimeout(degreeSearchTimeout);
            degreeSearchTimeout = setTimeout(() => {
                degreePage = 1;
                loadDegrees(e.target.value);
            }, 300);
        });

        degreeDropdown.addEventListener('scroll', () => {
            const { scrollTop, scrollHeight, clientHeight } = degreeDropdown;
            if (scrollHeight - scrollTop <= clientHeight + 50 && !isDegreeLoading && hasMoreDegrees) {
                loadMoreDegrees();
            }
        });

        degreeList.addEventListener('click', (e) => {
            const option = e.target.closest('.degree-option');
            if (!option) return;

            const id = option.dataset.id;
            const name = option.dataset.name;

            if (selectedDegrees.has(id)) {
                selectedDegrees.delete(id);
            } else {
                if (selectedDegrees.size >= 10) {
                    document.querySelector('#degree_error').textContent = "You can select up to 10 degrees."
                    // alert("You can select up to 10 degrees.");
                    return;
                }
                document.querySelector('#degree_error').textContent = ""
                selectedDegrees.set(id, name);
            }

            updateSelectedDegrees();
        });

        function makeDegreeOption(degree) {
            const wrapper = document.createElement('div');
            wrapper.className = 'degree-option flex items-center px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 cursor-pointer';
            wrapper.dataset.id = degree.id;
            wrapper.dataset.name = degree.name;
            wrapper.innerHTML = `
                    <input type="checkbox" class="mr-2" disabled ${selectedDegrees.has(String(degree.id)) ? 'checked' : ''}/>
                    <span class="text-gray-700 dark:text-white">${degree.name}</span>
                `;
            return wrapper;
        }

        function updateSelectedDegrees() {
            selectedContainer.innerHTML = '';

            selectedDegrees.forEach((name, id) => {
                // Tag
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-indigo-100 dark:bg-slate-700 text-indigo-700 dark:text-white text-sm rounded px-2 py-1';
                tag.innerHTML = `
                        <span>${name}</span>
                        <button type="button" class="ml-2 remove-degree text-lg" data-id="${id}">&times;</button>
                    `;
                selectedContainer.appendChild(tag);

                // Hidden input
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'degree_id[]';
                hiddenInput.value = id;
                selectedContainer.appendChild(hiddenInput);
            });

            degreeSearch.value = '';
            loadDegrees(); // re-render dropdown with updated checkbox state
        }

        selectedContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-degree')) {
                const id = e.target.dataset.id;
                selectedDegrees.delete(id);
                updateSelectedDegrees();
            }
        });

        async function loadDegrees(searchTerm = '') {
            isDegreeLoading = true;
            hasMoreDegrees = true;
            try {
                const res = await fetch(`{{ route('admin.placement.search.degree') }}?search=${encodeURIComponent(searchTerm)}&page=1`);
                const data = await res.json();

                degreeList.innerHTML = '';
                if (data.data.length) {
                    data.data.forEach(degree => degreeList.appendChild(makeDegreeOption(degree)));
                } else {
                    degreeList.innerHTML = '<div class="px-4 py-2 text-gray-500 dark:text-gray-300">No degree found</div>';
                }

                degreePage = 1;
                hasMoreDegrees = !!data.next_page_url;
                loadingMoreDegrees.classList.toggle('hidden', !hasMoreDegrees);
            } catch (err) {
                console.error(err);
                hasMoreDegrees = false;
            }
            isDegreeLoading = false;
        }

        async function loadMoreDegrees() {
            if (isDegreeLoading || !hasMoreDegrees) return;
            isDegreeLoading = true;
            loadingMoreDegrees.classList.remove('hidden');

            try {
                const term = degreeSearch.value;
                const res = await fetch(`{{ route('admin.placement.search.degree') }}?search=${encodeURIComponent(term)}&page=${degreePage + 1}`);
                const data = await res.json();

                if (data.data.length) {
                    data.data.forEach(degree => degreeList.appendChild(makeDegreeOption(degree)));
                    degreePage++;
                    hasMoreDegrees = !!data.next_page_url;
                } else {
                    hasMoreDegrees = false;
                }
                loadingMoreDegrees.classList.toggle('hidden', !hasMoreDegrees);
            } catch (err) {
                console.error(err);
                hasMoreDegrees = false;
                loadingMoreDegrees.classList.add('hidden');
            }

            isDegreeLoading = false;
        }

        // On page load
        loadDegrees();

        // Optional: Validation before form submit
        document.querySelector('#form_submit').addEventListener('submit', function (e) {
            if (selectedDegrees.size === 0) {
                e.preventDefault();
                document.querySelector('#degree_error').textContent = "Please select atleast one degree."
            }
        });
    </script>

    {{-- skills --}}
    <script>
        const skillSearch = document.getElementById('skill_search');
        const skillDropdown = document.getElementById('skill_dropdown');
        const skillList = document.getElementById('skill_list');
        const loadingMoreSkills = document.getElementById('skill_loading_more');
        const selectedSkillsContainer = document.getElementById('selected_skills');

        let skillPage = 1;
        let isSkillLoading = false;
        let hasMoreSkills = true;
        let skillSearchTimeout;
        const selectedSkills = new Map();

        skillSearch.addEventListener('focus', () => skillDropdown.classList.remove('hidden'));

        document.addEventListener('click', (e) => {
            if (!skillSearch.contains(e.target) && !skillDropdown.contains(e.target)) {
                skillDropdown.classList.add('hidden');
            }
        });

        skillSearch.addEventListener('input', (e) => {
            clearTimeout(skillSearchTimeout);
            skillSearchTimeout = setTimeout(() => {
                skillPage = 1;
                loadSkills(e.target.value);
            }, 300);
        });

        skillDropdown.addEventListener('scroll', () => {
            const { scrollTop, scrollHeight, clientHeight } = skillDropdown;
            if (scrollHeight - scrollTop <= clientHeight + 50 && !isSkillLoading && hasMoreSkills) {
                loadMoreSkills();
            }
        });

        skillList.addEventListener('click', (e) => {
            const option = e.target.closest('.skill-option');
            if (!option) return;

            const id = option.dataset.id;
            const name = option.dataset.name;

            if (selectedSkills.has(id)) {
                selectedSkills.delete(id);
            } else {
                if (selectedSkills.size >= 10) {
                    document.querySelector('#skill_error').textContent = "You can select up to 10 skills.";
                    return;
                }
                document.querySelector('#skill_error').textContent = "";
                selectedSkills.set(id, name);
            }

            updateSelectedSkills();
        });

        function makeSkillOption(skill) {
            const wrapper = document.createElement('div');
            wrapper.className = 'skill-option flex items-center px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 cursor-pointer';
            wrapper.dataset.id = skill.id;
            wrapper.dataset.name = skill.name;
            wrapper.innerHTML = `
                <input type="checkbox" class="mr-2" disabled ${selectedSkills.has(String(skill.id)) ? 'checked' : ''}/>
                <span class="text-gray-700 dark:text-white">${skill.name}</span>
            `;
            return wrapper;
        }

        function updateSelectedSkills() {
            selectedSkillsContainer.innerHTML = '';

            selectedSkills.forEach((name, id) => {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-indigo-100 dark:bg-slate-700 text-indigo-700 dark:text-white text-sm rounded px-2 py-1';
                tag.innerHTML = `<span>${name}</span>
                    <button type="button" class="ml-2 remove-skill text-lg" data-id="${id}">&times;</button>`;
                selectedSkillsContainer.appendChild(tag);

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'skill_id[]';
                hiddenInput.value = id;
                selectedSkillsContainer.appendChild(hiddenInput);
            });

            skillSearch.value = '';
            loadSkills();
        }

        selectedSkillsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-skill')) {
                const id = e.target.dataset.id;
                selectedSkills.delete(id);
                updateSelectedSkills();
            }
        });

        async function loadSkills(searchTerm = '') {
            isSkillLoading = true;
            hasMoreSkills = true;
            try {
                const res = await fetch(`{{ route('admin.placement.search.skills') }}?search=${encodeURIComponent(searchTerm)}&page=1`);
                const data = await res.json();

                skillList.innerHTML = '';
                if (data.data.length) {
                    data.data.forEach(skill => skillList.appendChild(makeSkillOption(skill)));
                } else {
                    skillList.innerHTML = '<div class="px-4 py-2 text-gray-500 dark:text-gray-300">No skill found</div>';
                }

                skillPage = 1;
                hasMoreSkills = !!data.next_page_url;
                loadingMoreSkills.classList.toggle('hidden', !hasMoreSkills);
            } catch (err) {
                console.error(err);
                hasMoreSkills = false;
            }
            isSkillLoading = false;
        }

        async function loadMoreSkills() {
            if (isSkillLoading || !hasMoreSkills) return;
            isSkillLoading = true;
            loadingMoreSkills.classList.remove('hidden');

            try {
                const term = skillSearch.value;
                const res = await fetch(`{{ route('admin.placement.search.skills') }}?search=${encodeURIComponent(term)}&page=${skillPage + 1}`);
                const data = await res.json();

                if (data.data.length) {
                    data.data.forEach(skill => skillList.appendChild(makeSkillOption(skill)));
                    skillPage++;
                    hasMoreSkills = !!data.next_page_url;
                } else {
                    hasMoreSkills = false;
                }
                loadingMoreSkills.classList.toggle('hidden', !hasMoreSkills);
            } catch (err) {
                console.error(err);
                hasMoreSkills = false;
                loadingMoreSkills.classList.add('hidden');
            }

            isSkillLoading = false;
        }
        loadSkills();

        document.querySelector('#form_submit').addEventListener('submit', function (e) {
            if (selectedSkills.size === 0) {
                e.preventDefault();
                document.querySelector('#skill_error').textContent = "Please select at least one skill.";
            }
        });

    </script>





@endsection