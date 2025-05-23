@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <h1 class="text-2xl font-bold mb-8">Add new College</h1>

                <form method="POST" action="{{ route('admin.placement.store.college') }}" id="form_submit">
                    @csrf

                   
                    <input type="hidden" name="placement_id" value={{ $id }} id="placement_id">
                    <div class="relative mb-6">
                        <label for="college_search" class="block text-sm font-bold mb-2 text-gray-700 dark:text-white">
                            Select College <span class="text-red-500">*</span>
                        </label>
                        
                        <input type="hidden" name="college_id" id="selected_college_id">
                        <p id="college_error" class="text-red-500 text-sm mb-1"></p>
                    
                        <div class="relative">
                            <input type="text" id="college_search"
                                class="w-full border rounded px-3 py-2 shadow focus:outline-none dark:bg-slate-900 dark:text-white"
                                placeholder="Search for a college..." autocomplete="off" readonly>
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

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Schedule Date</label>
                        <input type="date" name="schedule_date" id="schedule_date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                            focus:border-indigo-500 focus:ring-indigo-500 
                                            dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Schedule Time</label>
                        <input type="time" name="start_time"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                    focus:border-indigo-500 focus:ring-indigo-500 
                                                    dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Timezone</label>
                        <select name="timezone"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                         focus:border-indigo-500 focus:ring-indigo-500 
                                         dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                            <option value="">Select a Timezone</option>
                            <option value="Asia/Kolkata">India (IST)</option>
                            <option value="America/New_York">USA (EST)</option>
                            <option value="America/Chicago">USA (CST)</option>
                            <option value="America/Denver">USA (MST)</option>
                            <option value="America/Los_Angeles">USA (PST)</option>
                            <option value="Europe/London">Europe (GMT/BST)</option>
                            <option value="Europe/Berlin">Europe (CET)</option>

                        </select>
                    </div>
                    

                    <div class="mt-8">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                                                                           rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                                                           hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none 
                                                                           focus:border-indigo-900 focus:ring ring-indigo-300 
                                                                           disabled:opacity-25 transition ease-in-out duration-150">
                            Add College
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>


    <script>
        const collegeSearch = document.getElementById('college_search');
        const collegeDropdown = document.getElementById('college_dropdown');
        const collegeList = document.getElementById('college_list');
        const loadingMoreColleges = document.getElementById('college_loading_more');
        const selectedCollegeInput = document.getElementById('selected_college_id');
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
    
        // Open dropdown when focusing the input
        collegeSearch.addEventListener('focus', () => {
            if (!collegeSelected) {
                loadColleges(collegeSearch.value);
                collegeDropdown.classList.remove('hidden');
            }
        });
    
        // Close dropdown if clicked outside
        document.addEventListener('click', (e) => {
            if (!collegeSearch.contains(e.target) && !collegeDropdown.contains(e.target)) {
                collegeDropdown.classList.add('hidden');
            }
        });
    
        // Search as user types
        collegeSearch.addEventListener('input', (e) => {
            if (collegeSelected) return;
    
            collegeDropdown.classList.remove('hidden'); // Show dropdown while typing
    
            clearTimeout(collegeSearchTimeout);
            collegeSearchTimeout = setTimeout(() => {
                collegePage = 1;
                loadColleges(e.target.value);
            }, 300);
        });
    
        // Infinite scroll handling
        collegeDropdown.addEventListener('scroll', () => {
            const { scrollTop, scrollHeight, clientHeight } = collegeDropdown;
            if (scrollHeight - scrollTop <= clientHeight + 50 && !isCollegeLoading && hasMoreColleges) {
                loadMoreColleges();
            }
        });
    
        // Handle selection
        collegeList.addEventListener('click', (e) => {
            const option = e.target.closest('.college-option');
            if (!option) return;
    
            const id = option.dataset.id;
            const name = option.dataset.name;
    
            selectedCollegeInput.value = id;
            collegeSearch.value = name;
            collegeSearch.setAttribute('readonly', true);
            collegeSelected = true;
            clearBtn.classList.remove('hidden');
            collegeDropdown.classList.add('hidden');
            collegeError.textContent = "";
        });
    
        // Clear selection
        function clearCollegeSelection() {
            selectedCollegeInput.value = '';
            collegeSearch.value = '';
            collegeSearch.removeAttribute('readonly');
            collegeSelected = false;
            clearBtn.classList.add('hidden');
    
            loadColleges(); // reload default list
            collegeDropdown.classList.remove('hidden'); // reopen dropdown
            collegeSearch.focus(); // re-focus so input/search works
        }
    
        // Generate dropdown option
        function makeCollegeOption(college) {
            const wrapper = document.createElement('div');
            wrapper.className = 'college-option flex items-center px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 cursor-pointer';
            wrapper.dataset.id = college.id;
            wrapper.dataset.name = college.name;
            wrapper.innerHTML = `<span class="text-gray-700 dark:text-white">${college.name}</span>`;
            return wrapper;
        }
    
        // Load colleges for search term
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
    
        // Load more colleges for infinite scroll
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
    
        // Initial load
        loadColleges();
    
        // Form submit validation
        document.querySelector('#form_submit').addEventListener('submit', function (e) {
            if (!selectedCollegeInput.value) {
                e.preventDefault();
                collegeError.textContent = "Please select a college.";
            }
        });
    </script>
    
    







@endsection