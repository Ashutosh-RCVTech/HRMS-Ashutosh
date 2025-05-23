@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">


            <div class="container mx-auto px-4 py-8">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">

                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-bold">Result</h1>

                        <div class="flex space-x-4">

                            <a href="{{ route('admin.quiz.quizes.show.results', ['quizId' => request()->segment(5), 'status' => 1]) }}"
                                class="px-4 py-2 rounded-lg font-semibold transition 
                                                                                                                              {{ request()->segment(6) == 1 ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-300 hover:bg-gray-400 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300' }}">
                                View Passed Candidates
                            </a>


                            <a href="{{ route('admin.quiz.quizes.show.results', ['quizId' => request()->segment(5), 'status' => 0]) }}"
                                class="px-4 py-2 rounded-lg font-semibold transition 
                                                                                                                              {{ request()->segment(6) == 0 ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-gray-300 hover:bg-gray-400 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300' }}">
                                View Failed Candidates
                            </a>
                        </div>
                    </div>

                    <div class="flex  justify-between items-center mb-8">
                        <div>
                            <h1 class="text-xl"> {{ request()->segment(6) == 0 ? 'Failed Candidate' : 'Pass Candidate' }}
                            </h1>

                            <a href="{{ route('admin.quiz.quizes.show.results.export', [
                                'quizId' => request()->segment(5),
                                'status' => request()->segment(6),
                                'page' => request()->get('page'),
                                'perPage' => request()->get('perPage'),
                            ]) }}"
                                class="inline-flex items-center w-[150px] text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-red-200 active:bg-blue-800 transition ease-in-out duration-150 mb-4">
                                Export to PDF
                            </a>
                        </div>
                        <div class="mb-4 flex items-center gap-2">
                            <label for="perPage" class="text-sm font-semibold">Show</label>
                            <select id="perPageSelector"
                                class="px-3 py-2 rounded-lg border-gray-300 dark:bg-slate-700 dark:text-white dark:border-gray-600">
                                <option value="15" selected disabled>Select per page</option>
                                @foreach ([20, 50, 100] as $size)
                                    <option value="{{ $size }}"
                                        {{ request()->get('perPage', 15) == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                    </div>
                    <!-- Quizes Table -->
                    <div class="overflow-x-auto max-h-[700px] overflow-y-auto border rounded-lg">
                        <table
                            class="w-full border-collapse bg-white shadow-lg rounded-lg dark:bg-slate-800 dark:text-white">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Name</th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Score</th>



                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-gray-700">
                                @forelse ($examAttempts as $examAttempt)
                                    {{-- {{ dd($examAttempt) }} --}}
                                    <tr class="hover:bg-gray-400 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $loop->iteration }}
                                        </td>


                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                            {{ $examAttempt->candidate->candidateInfo->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                            {{ $examAttempt->candidate->candidateInfo->email ?? 'N/A' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                            {{ $examAttempt->score }} %
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button data-quiz-id="{{ $examAttempt->quiz_id }}"
                                                    data-candidate-id="{{ $examAttempt->mcq_test_candidate_id }}"
                                                    class="show-result-btn inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    Show Result
                                                </button>


                                                <a href="{{ route('candidate.mcq.activities', $examAttempt->mcq_test_candidate_id) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center px-3 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:outline-none focus:border-orange-700 focus:ring focus:ring-orange-200 active:bg-orange-800 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    Check Activity Logs
                                                </a>


                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                            No Result found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class=" p-4">
                            {{ $examAttempts->links() }}
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



    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
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


        document.getElementById('perPageSelector').addEventListener('change', function() {
            const perPage = this.value;

            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            url.searchParams.set('page', 1);


            window.location.href = url.toString();
        });
    </script>
@endsection
