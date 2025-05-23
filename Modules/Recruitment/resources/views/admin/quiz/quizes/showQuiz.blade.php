@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white p-6 rounded-lg shadow-md dark:bg-slate-900 dark:text-white">
                <div class="flex justify-between items-center gap-4">
                    <h1 class="text-3xl font-bold mb-6">{{ $quiz->name }}</h1>
                    <div class="flex gap-4 items-center">
                        <h4>Score: {{ $quiz->marks }}</h4>
                        <h4>Time: {{ $quiz->duration }} mins</h4>
                    </div>
                </div>

                <div class="flex mt-2 justify-end">
                    <a href="{{ route('admin.quiz.quiz.category.create', $quiz->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-900 text-white rounded">
                        Add New Category
                    </a>
                </div>

                <div class="space-y-4 mt-4">
                    @foreach ($quiz->categories as $category)
                        <!-- Category Section -->
                        <div class="category border rounded-lg ">
                            <div
                                class="flex justify-between items-center bg-gray-200 dark:bg-slate-600 px-3 p-2 rounded-lg">
                                <span class="text-lg font-bold">{{ $category->name }}</span>

                                <div class="flex gap-4 py-1">


                                    <label for="toggle{{ $category->id }}"
                                        class="relative flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle{{ $category->id }}" class="sr-only"
                                            {{ $category->active_status ? 'checked' : '' }}
                                            onclick="confirmStatusChange({{ $category->id }}, '{{ $category->active_status ? 'Deactivate' : 'Activate' }}')">

                                        <div
                                            class="w-12 h-6 bg-green-500 rounded-full transition duration-300
                                                                                                                                                                                                                                                                                                                                                {{ $category->active_status ? 'bg-green-500' : 'bg-red-500' }}">
                                        </div>

                                        <div
                                            class="absolute left-1 top-1 mt-1 w-4 h-4 bg-white rounded-full shadow-md transition 
                                                                                                                                                                                                                                                                                                                                                {{ $category->active_status ? 'translate-x-6' : '' }}">
                                        </div>
                                    </label>


                                    <a href="{{ route('admin.quiz.quiz.category.edit', $category->id) }}"
                                        class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>Edit</a>


                                    <button class="category-btn  px-3 py-1 rounded-lg">
                                        <span class="toggle-icon">🔽</span>
                                    </button>
                                </div>
                            </div>

                            <div class="category-content space-y-2 py-2 hidden">

                                <div class="flex mb-4 mx-2 justify-start">
                                    <a href="javascript:void(0);"
                                        onclick="openQuestionModal({{ $quiz->id }},{{ $category->id }})"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded">
                                        Add New Question
                                    </a>
                                </div>


                                @foreach ($category->questions as $question)
                                    <div class="question border-l-4 border-blue-500 px-4 my-2">
                                        <div
                                            class="flex justify-between items-center bg-gray-100 dark:bg-slate-500 px-4 rounded-lg">
                                            <span class="font-semibold">{{ $question->question_text }}</span>

                                            <div class="flex gap-2 py-1">
                                                <a href="javascript:void(0);"
                                                    class="edit-btn inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded"
                                                    data-quiz-id="{{ $quiz->id }}"
                                                    data-category-id="{{ $category->id }}"
                                                    data-question-id="{{ $question->id }}"
                                                    data-question="{{ htmlspecialchars($question->question_text, ENT_QUOTES, 'UTF-8') }}"
                                                    data-options='@json($question->options)'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    Edit
                                                </a>


                                                <button class="question-btn  px-3 py-1 ">
                                                    <span class="toggle-icon">▶</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="question-content my-2 p-4 space-y-1 hidden">
                                            @foreach ($question->options as $option)
                                                <div class="flex items-center space-x-2">
                                                    <span
                                                        class="px-2 py-1 border rounded-lg w-[80%] {{ $option->is_correct == 1 ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                                                        {{ $option->option_text }}
                                                    </span>
                                                    @if ($option->is_correct == 1)
                                                        <span class="text-green-500">✅ Correct</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black  bg-opacity-50 hidden">
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg">
            <div
                class="flex px-6 py-3 bg-gray-200 dark:bg-slate-800 gap-4 rounded-lg text-lg font-semibold items-center justify-between">
                <h2 id="modalTitle" class="">Confirm Status Change</h2>
            </div>

            <p id="confirmText" class="mb-4 px-6 py-1"></p>
            <div class="flex justify-end gap-4 px-6 pt-2 pb-4">
                <button onclick="closeModal()" class="px-4 py-1 bg-gray-500 text-white rounded">Cancel</button>
                <form id="statusForm" method="POST" class="px-0 py-0 m-0">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="category_id" id="categoryId">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Confirm</button>
                </form>
            </div>
        </div>
    </div>


    <div id="questionModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-slate-900  rounded-lg shadow-lg w-[90%] md:w-[700px]">

            <div
                class="flex p-6 bg-gray-200 dark:bg-slate-800 gap-4 rounded-lg text-lg font-semibold items-center justify-between">
                <h2 id="modalQuestionTitle" class=""></h2>
                <button type="button" onclick="closeQuestionModal()" class="text-4xl">&times;</button>
            </div>
            <form id="questionForm" class="px-6 py-3" method="POST">
                @csrf
                <input type="hidden" name="question_id" id="questionId">
                <input type="hidden" name="category_id" id="selectedCategoryId">
                <input type="hidden" name="quiz_id" id="selectedQuizId">

                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Question</label>
                <input type="text" id="questionInput" name="question"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                    focus:border-indigo-500 focus:ring-indigo-500 
                                    dark:bg-slate-800 dark:text-white dark:border-gray-700"
                    required>


                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Options</label>

                <div class="error-correct"></div>
                <div class="grid grid-cols-1 gap-2">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center gap-2">
                            <input type="text" name="options[]"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                            focus:border-indigo-500 focus:ring-indigo-500 
                                                            dark:bg-slate-800 dark:text-white dark:border-gray-700 optionInput"
                                required>


                            <input type="hidden" name="correct_option[]" value="false" class="correctStatus">


                            <button type="button" class="correctBtn px-3 py-2 rounded w-[180px] bg-gray-300 text-black">
                                Mark Correct
                            </button>
                        </div>
                    @endfor
                </div>



                <div class="flex justify-end gap-4 mt-4">

                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-indigo-900 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll(".category-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let content = this.closest(".category").querySelector(".category-content");
                    let icon = this.querySelector(".toggle-icon");

                    if (content.classList.contains("hidden")) {
                        content.classList.remove("hidden");
                        icon.textContent = "🔼";
                    } else {
                        content.classList.add("hidden");
                        icon.textContent = "🔽";
                    }
                });
            });


            document.querySelectorAll(".question-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let content = this.closest(".question").querySelector(".question-content");
                    let icon = this.querySelector(".toggle-icon");

                    if (content.classList.contains("hidden")) {
                        content.classList.remove("hidden");
                        icon.textContent = "▼";
                    } else {
                        content.classList.add("hidden");
                        icon.textContent = "▶";
                    }
                });
            });



            document.querySelectorAll(".edit-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    let quizId = this.dataset.quizId;
                    let categoryId = this.dataset.categoryId;
                    let questionId = this.dataset.questionId;
                    let question = this.dataset.question;
                    let options = JSON.parse(this.dataset.options);
                    openQuestionModal(quizId, categoryId, questionId, question, options);
                });
            });

            document.querySelectorAll(".correctBtn").forEach((button, index) => {
                button.addEventListener("click", function() {
                    let allButtons = document.querySelectorAll(".correctBtn");
                    let allInputs = document.querySelectorAll(".correctStatus");

                    // Reset all buttons
                    allButtons.forEach(btn => {
                        btn.classList.remove("bg-green-500", "text-white");
                        btn.classList.add("bg-gray-300", "text-black");
                        btn.textContent = "Mark Correct";
                    });

                    // Reset all hidden inputs
                    allInputs.forEach(input => input.value = "false");

                    // Mark the clicked button as correct
                    this.classList.remove("bg-gray-300", "text-black");
                    this.classList.add("bg-green-500", "text-white");
                    this.textContent = "Correct";

                    // Update hidden input value
                    allInputs[index].value = "true";
                });
            });

        });

        function confirmStatusChange(categoryId, action) {
            document.getElementById("confirmText").innerText = `Are you sure you want to ${action} this category?`;
            document.getElementById("categoryId").value = categoryId;
            document.getElementById("statusForm").action = `/admin/quiz/quiz/category/${categoryId}/updatestatus`;
            document.getElementById("confirmModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("confirmModal").classList.add("hidden");
        }



        function openQuestionModal(quizId, categoryId, questionId = null, questionText = "", options = []) {


            document.getElementById("questionModal").classList.remove("hidden");
            document.getElementById("selectedCategoryId").value = categoryId;
            document.getElementById("selectedQuizId").value = quizId;


            document.getElementById("questionId").value = questionId ?? "";
            document.querySelector("#modalQuestionTitle").textContent = questionId ? "Edit Question" : "Add New Question";
            document.getElementById("questionInput").value = questionText;



            let optionInputs = document.querySelectorAll(".optionInput");
            let correctButtons = document.querySelectorAll(".correctBtn");
            let correctInputs = document.querySelectorAll(".correctStatus");


            for (let i = 0; i < optionInputs.length; i++) {

                optionInputs[i].value = options[i]?.option_text || "";
                let isCorrect = options[i]?.is_correct || false;
                correctInputs[i].value = isCorrect ? "true" : "false";
                if (isCorrect) {
                    correctButtons[i].classList.add("bg-green-500", "text-white");
                    correctButtons[i].classList.remove("bg-gray-300", "text-black");
                    correctButtons[i].textContent = "Correct";
                } else {
                    correctButtons[i].classList.add("bg-gray-300", "text-black");
                    correctButtons[i].classList.remove("bg-green-500", "text-white");
                    correctButtons[i].textContent = "Mark Correct";
                }
            }


            document.getElementById("questionForm").action = questionId ?
                `/admin/quiz/quiz/category/question/update` :
                `/admin/quiz/quiz/category/question/store`;
        }

        function closeQuestionModal() {
            document.getElementById("questionModal").classList.add("hidden");
        }




        document.getElementById("questionForm").addEventListener("submit", function(event) {
            event.preventDefault();
            document.querySelectorAll(".error-message").forEach(el => el.remove());
            let correctOptions = document.querySelectorAll(".correctStatus");
            let optionInputs = document.querySelectorAll(".optionInput");


            let values = [];

            for (let option of optionInputs) {
                let value = option.value.trim();
                if (value !== "") {
                    if (values.includes(value)) {
                        toastr.error('Failed to create Question');
                        document.querySelector(".error-correct").insertAdjacentHTML("beforeBegin",
                            `<p class="error-message text-red-500">All options must be Unique</p>`);
                        return;
                    }
                    values.push(value);
                }
            }

            let atLeastOneCorrect = Array.from(correctOptions).some(option => option.value === "true");


            if (!atLeastOneCorrect) {
                toastr.error('Failed to create Question');
                document.querySelector(".error-correct").insertAdjacentHTML("beforeBegin",
                    `<p class="error-message text-red-500">Please Mark atleast one correct Answer </p>`);
                return;
            }

            let formData = new FormData(this);

            fetch(this.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        toastr.error('Failed to create Quiz');
                    } else {
                        toastr.success(data.success);
                        closeQuestionModal();
                        location.reload();
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    </script>
@endsection





<script></script>
