@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 dark:bg-slate-800 dark:text-white rounded-xl shadow-md mb-6 p-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-3">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $placement->name }}</h1>
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                            {{ $placement->status
        ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
        : 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400' }}">
                                {{   $placement->status ? 'Open' : 'Close'}}
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-300">

                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $placement->created_at->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="md:flex md:gap-8 flex-col w-full md:flex-row">


                

                <!-- First Column (60%) -->

                <div class="md:w-[66%] space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md max-h-[700px] p-6">
                        <!-- Header Section -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white border-b md:border-none pb-2 md:pb-0 dark:border-gray-700">
                                Student Details
                            </h2>
                
                            <div class="flex gap-4 items-center">
                            <a href="javascript:location.reload()"
                            class="inline-flex items-center w-[150px] text-center text-center mt-3 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-red-200 active:bg-blue-800 transition ease-in-out duration-150 mb-4">
                            Refresh Page
                         </a>


                            <div class="flex  flex-wrap text-sm text-gray-700 dark:text-gray-200 divide-x divide-gray-300 dark:divide-gray-600 border rounded-md overflow-hidden">
                               
                                    <p class="p-2"><strong>Total Candidates:</strong> {{ $collegeCandidates->count() }}</p>
                               
                                <p class="p-2"><strong>Attempted:</strong> {{ $collegeCandidates->filter(fn($c) => $c->candidateInfo->mcqTests->first()?->examAttempts->contains('status', 'completed'))->count() }}</p>

<p class="p-2"><strong>Attempting:</strong> {{ $collegeCandidates->filter(fn($c) => $c->candidateInfo->mcqTests->isNotEmpty() && !$c->candidateInfo->mcqTests->first()?->examAttempts->contains('status', 'completed'))->count() }}</p>

<p class="p-2"><strong>Not Attempted:</strong> {{ $collegeCandidates->filter(fn($c) => $c->candidateInfo->mcqTests->isEmpty())->count() }}</p>

                            </div>

                        </div>
                        </div>

                       <!-- Existing Name and Attempt Status filters -->
<div class="flex flex-col md:flex-row gap-4 mt-4 mb-4">
    <input type="text" id="search-name" placeholder="Search by Name" class="p-2 border rounded-md w-full md:w-1/3 dark:bg-slate-700 dark:text-white">
    
    <select id="filter-status" class="p-2 border rounded-md w-full md:w-1/3 dark:bg-slate-700 dark:text-white">
        <option value="">All Status</option>
        <option value="attempted">Attempted</option>
        <option value="attempting">Attempting</option>
        <option value="not attempted">Not Attempted</option>
    </select>
    
    <!-- New Passed/Failed filter -->
    <select id="filter-result" class="p-2 border rounded-md w-full md:w-1/3 dark:bg-slate-700 dark:text-white">
        <option value="">All Results</option>
        <option value="passed">Passed</option>
        <option value="failed">Failed</option>
    </select>
</div>


<a href="{{ route('admin.placement.drive.quizes.show.results.export', [
                               
                                'placementId' => $placement->id,
                                'placementCollegeId' => $placementCollegId,
                            ]) }}"
                                class="inline-flex items-center w-[150px] text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-red-200 active:bg-blue-800 transition ease-in-out duration-150 mb-4">
                                Export to PDF
                            </a>
                
                        <!-- Table Section -->
                        <div class="mt-6 overflow-x-auto rounded-lg border max-h-[400px] dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-100 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Name</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Email</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Attempt Status</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Result Status</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y  divide-gray-100 dark:divide-gray-700">
                                    @forelse ($collegeCandidates as $candidate)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $candidate->candidateInfo->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $candidate->candidateInfo->email ?? 'N/A' }}
                                            </td>
                                          

                                            <td class="px-4 py-3">
                                                @php
                                                    $hasMcq = $candidate->candidateInfo->mcqTests->isNotEmpty();
                                                    $hasCompleted = $candidate->candidateInfo->mcqTests->first()?->examAttempts->contains('status', 'completed');
                                                @endphp
                                            
                                                @if($hasMcq && $hasCompleted)
                                                    <span class="status-tag text-green-600 dark:text-green-400 font-medium">Attempted</span>
                                                @elseif($hasMcq)
                                                    <span class="status-tag text-yellow-600 dark:text-yellow-400 font-medium">Attempting</span>
                                                @else
                                                    <span class="status-tag text-red-600 dark:text-red-400 font-medium">Not Attempted</span>
                                                @endif
                                            </td>
                                            @php $attemptResults = $candidate->candidateInfo->mcqTests->first()?->examAttempts->first(); @endphp
                                          

                                            <td>
                                                @if ($attemptResults && $hasCompleted)
                                                    @php
                                                        $isPassed = $attemptResults->score >= $passingPercentage;
                                                        $resultClass = $isPassed ? 'bg-green-600 rounded-xl p-1 px-2 font-semibold' : 'bg-red-600 rounded-xl p-1 px-2 font-semibold';
                                                    @endphp
                                                    <span class="{{ $resultClass }}">
                                                        {{ $isPassed ? 'Passed' : 'Failed' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-500">—</span>
                                                @endif
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                @if($hasCompleted)
                                                @php $test = $candidate->candidateInfo->mcqTests->first(); @endphp
                                                    <button 
                                                        data-quiz-id="{{ $test->quiz_id }}"
                                                        data-candidate-id="{{ $test->id }}"
                                                        class="show-result-btn inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                                    >
                                                        Show Result
                                                    </button>
                                                @else
                                                    <span class="text-sm text-gray-400 dark:text-gray-500">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 px-4 py-6 text-sm">
                                                No candidates found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                
                       
                       
                    </div>
                </div>


                <div class="md:w-[30%] space-y-4">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md p-4">
                    
                        <h1 class="text-2xl font-bold mb-8">Quiz Details</h1>
                        <form method="POST"
                    action="{{ $quizSchedule ? route('admin.placement.quiz.schedule.update', $quizSchedule->id) : route('admin.placement.schedule.quiz.store') }}">
                  @csrf
                  @if($quizSchedule)
                      @method('PUT')
                  @endif
              
                  <input type="hidden" name="placement_id" value="{{ $placementId }}">
                  <input type="hidden" name="placement_college_id" value="{{ $placementCollegId }}">
              
                  <!-- Course -->
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Select Course</label>
                    <select name="course_id" id="course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                         focus:border-indigo-500 focus:ring-indigo-500 
                         dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                         <option value="">-- Select Course --</option>
                         @foreach($quizCourses as $course)
                             <option value="{{ $course->id }}"
                                 {{ (old('course_id', optional($quizSchedule)->course_id) == $course->id) ? 'selected' : '' }}>
                                 {{ $course->name }}
                             </option>
                         @endforeach
                    </select>
                </div>


                 
              
                  <!-- Quiz -->
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Select Quiz</label>
                    <select name="quiz_id" id="quiz_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                         focus:border-indigo-500 focus:ring-indigo-500 
                         dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                         <option value="">-- Select Quiz --</option>
                      @foreach($quizzes as $quiz)

                      
                          <option value="{{ $quiz->id }}"
                              {{ (old('quiz_id', optional($quizSchedule)->quiz_id) == $quiz->id) ? 'selected' : '' }}>
                              {{ $quiz->name }}
                          </option>
                      @endforeach
                    </select>
                </div>
                 
              

                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Schedule Date</label>
                    <input type="date" name="schedule_date" value="{{ old('schedule_date', optional($quizSchedule)->schedule_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                focus:border-indigo-500 focus:ring-indigo-500 
                                                dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                </div>
                 
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Schedule Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time', optional($quizSchedule)->start_time) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                        focus:border-indigo-500 focus:ring-indigo-500 
                                                        dark:bg-slate-800 dark:text-white dark:border-gray-700"
                        required>
                </div>
                    <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Timezone</label>
                    <select name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                             focus:border-indigo-500 focus:ring-indigo-500 
                                             dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                                             <option value="">Select Timezone</option>
                                             @foreach(['Asia/Kolkata', 'America/New_York', 'America/Chicago', 'America/Denver', 'America/Los_Angeles', 'Europe/London', 'Europe/Berlin'] as $tz)
                                                 <option value="{{ $tz }}"
                                                     {{ (old('timezone', optional($quizSchedule)->timezone) == $tz) ? 'selected' : '' }}>
                                                     {{ $tz }}
                                                 </option>
                                             @endforeach

                    </select>
                </div>
                 
              
                  <button type="submit"  class="mt-8 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                  rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                  hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none 
                  focus:border-indigo-900 focus:ring ring-indigo-300 
                  disabled:opacity-25 transition ease-in-out duration-150">
                      {{ $quizSchedule ? 'Update Schedule' : 'Schedule Quiz' }}
                  </button>
                        </form>
              
                    </div>
                    
                </div>

                
            </div>
        </div>
        </div>
    </main>


    <div id="resultModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-black rounded-lg shadow-lg w-full max-w-6xl h-[90vh] overflow-y-auto relative">
            <button onclick="closeModal()"
                class="absolute top-3 right-6 text-black dark:text-white text-4xl">&times;</button>
            <div id="resultModalContent" class="">
                <!-- Result content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        document.getElementById('course_id').addEventListener('change', function () {
            const courseId = this.value;
            const quizDropdown = document.getElementById('quiz_id');
            quizDropdown.innerHTML = '<option value="">Loading...</option>';
    
            if (!courseId) {
                quizDropdown.innerHTML = '<option value="">-- Select Quiz --</option>';
                return;
            }
    
            fetch(`{{ url('admin/placement/fetch-quizzes-by-course') }}/${courseId}`)
                .then(response => response.json())
                .then(data => {
                    quizDropdown.innerHTML = '<option value="">-- Select Quiz --</option>';
                    data.forEach(quiz => {
                        const option = document.createElement('option');
                        option.value = quiz.id;
                        option.textContent = quiz.name;
                        quizDropdown.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching quizzes:', error);
                    quizDropdown.innerHTML = '<option value="">-- Select Quiz --</option>';
                });
        });
    
        // Show result in modal
        function closeModal() {
            document.getElementById('resultModal').classList.add('hidden');
            document.getElementById('resultModalContent').innerHTML = '';
        }


        document.querySelectorAll('.show-result-btn').forEach(button => {

            button.addEventListener('click', function() {
                const quizId = this.getAttribute('data-quiz-id');
                const candidateId = this.getAttribute('data-candidate-id');

                fetch(`/candidate/mcq/exam-mcq-user-result/${quizId}/${candidateId}?ajax=true`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('resultModalContent').innerHTML = html;
                        document.getElementById('resultModal').classList.remove('hidden');
                    })
                    .catch(error => {
                        alert('Error loading result');
                        console.error(error);
                    });
            });
        });
       
    </script>



    
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const nameInput = document.getElementById('search-name');
        const statusFilter = document.getElementById('filter-status');
        const resultFilter = document.getElementById('filter-result');
    
        function filterTable() {
            // Retrieve filter values and normalize to lowercase
            const searchName = nameInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            const resultValue = resultFilter.value.toLowerCase();
            
            // Re-select the table rows each time
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                // Get the name text from the first cell and normalize
                const nameCell = row.querySelector('td:nth-child(1)');
                const name = nameCell ? nameCell.textContent.toLowerCase() : "";
                
                // Get the status text from the .status-tag span and normalize
                const statusCell = row.querySelector('.status-tag');
                const status = statusCell ? statusCell.textContent.trim().toLowerCase() : "";
                
                // Get the result status text from the 4th cell (Result Status column) and normalize
                const resultCell = row.querySelector('td:nth-child(4)');
                const result = resultCell ? resultCell.textContent.trim().toLowerCase() : "";
    
                // Determine if the row matches each filter
                const matchesName = !searchName || name.includes(searchName);
                const matchesStatus = !statusValue || status === statusValue;
                const matchesResult = !resultValue || result === resultValue;
                
                // Show or hide the row based on the combined filter criteria
                row.style.display = (matchesName && matchesStatus && matchesResult) ? '' : 'none';
            });
        }
        
        // Listen for changes on all the filter inputs
        nameInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
        resultFilter.addEventListener('change', filterTable);
    });
    </script>
    

@endsection




