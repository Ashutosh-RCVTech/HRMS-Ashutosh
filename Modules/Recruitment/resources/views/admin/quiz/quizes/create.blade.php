@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Add New Quiz</h1>
                </div>

                <form id="quizForm" action="{{ route('admin.quiz.quizes.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Quiz Name</label>
                        <input type="text" name="name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                    focus:border-indigo-500 focus:ring-indigo-500 
                                                    dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Total marks</label>
                        <input type="number" name="score"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                    focus:border-indigo-500 focus:ring-indigo-500 
                                                    dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Passing marks (in %
                            )</label>
                        <input type="number" name="passing_marks"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                    focus:border-indigo-500 focus:ring-indigo-500 
                                                    dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Duration (mins)</label>
                        <input type="number" name="duration"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                    focus:border-indigo-500 focus:ring-indigo-500 
                                                    dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            required>
                    </div>

                    {{-- <div class="mb-4">
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
                    </div> --}}

                    <h2 class="block text-lg font-bold text-gray-700 mb-2 dark:text-white ">Quiz Categories</h2>
                    <div id="quizCategories"></div>

                    <button type="button" onclick="addCategory()"
                        class=" inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent 
                                                                    rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                                                    hover:bg-blue-700 active:bg-blue-900 focus:outline-none 
                                                                    focus:border-blue-900 focus:ring ring-blue-300 
                                                                    disabled:opacity-25 transition ease-in-out duration-150 mt-4">+
                        Add
                        Category</button>

                    <br>
                    <button type="submit"
                        class=" inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                                                                                        rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                                                                        hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none 
                                                                                        focus:border-indigo-900 focus:ring ring-indigo-300 
                                                                                        disabled:opacity-25 transition ease-in-out duration-150 mt-8">Save
                        Quiz</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        let categoryCount = 0;
        let courseId = @json($id);
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById("schedule_date").setAttribute("min", today);
        });

        function addCategory() {
            categoryCount++;
            let categoryHtml = `
                                                                    <div class="category-section mb-4 p-4 border rounded-lg" id="category-${categoryCount}">
                                                                        <div class=" mb-4 p-4 border rounded-lg bg-gray-600 dark:bg-slate-600 ">
                                                                                                                                                <label class="block text-sm font-medium  mb-2 text-white">Category Name</label>
                                                                                                                                                <input type="text" name="categories[${categoryCount}][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                        focus:border-indigo-500 focus:ring-indigo-500 
                                                        dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                                                                                                                                                </div>
                                                                        <h3 class="block text-lg font-bold text-gray-700 mb-2 dark:text-white">MCQ Questions</h3>
                                                                        <div id="questions-${categoryCount}"></div>
                                                                         <button type="button" onclick="addQuestion(${categoryCount})" class=" inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent 
                                                                                                                                                        rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                                                                                                                                        hover:bg-blue-700 active:bg-blue-900 focus:outline-none 
                                                                                                                                                        focus:border-blue-900 focus:ring ring-blue-300 
                                                                                                                                                        disabled:opacity-25 transition ease-in-out duration-150 mt-4">+ Add Question</button>
                                                                       <div class="flex justify-end">
                                                                                                                                                    <button type="button" onclick="removeCategory(${categoryCount})" class="mt-4 inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">Remove Category</button>
                                                                                                                                                    </div>
                                                                    </div>`;
            document.getElementById("quizCategories").insertAdjacentHTML('beforeend', categoryHtml);
        }

        function removeCategory(catIndex) {
            document.getElementById(`category-${catIndex}`).remove();
        }

        function addQuestion(catIndex) {
            let questionCount = document.querySelectorAll(`#questions-${catIndex} .question-section`).length;
            let questionHtml = `
                                                                    <div class="question-section mb-4 p-4 border rounded-lg" id="question-${catIndex}-${questionCount}">

                                                                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Question-${questionCount + 1}</label>
                                                                        <textarea name="categories[${catIndex}][questions][${questionCount}][question]" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                                            focus:border-indigo-500 focus:ring-indigo-500 
                                                                            dark:bg-slate-800 dark:text-white dark:border-gray-700" 
                                                                            rows="1 " required></textarea>
                                                                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white mt-4">Options</label>
                                                                        <div class="grid grid-cols-1 gap-2">
                                        ${['opt1', 'opt2', 'opt3', 'opt4'].map((opt, index) => `
                                                                                                                        <div class="flex items-center justify-between gap-2">
                                                                                                                            <input type="text" name="categories[${catIndex}][questions][${questionCount}][${opt}]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                            focus:border-indigo-500 focus:ring-indigo-500 
                                                            dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                                                                                                                            <button type="button" class="ans-btn px-2 py-2 border rounded w-[200px] bg-gray-300   text-black" 
                                                                                                                                onclick="toggleAnswer(this, '${catIndex}', '${questionCount}', '${opt}')">
                                                                                                                                Mark Correct
                                                                                                                            </button>
                                                                                                                            <input type="hidden" name="categories[${catIndex}][questions][${questionCount}][${opt}_ans_status]" value="false">
                                                                                                                        </div>
                                                                                                                    `).join('')}

                                                                        </div>
                                                                       <div class="flex justify-end">
                                                                                                                    <button type="button" onclick="removeQuestion(${catIndex}, ${questionCount})" class="mt-4 inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-800 transition ease-in-out duration-150">Remove Question</button>
                                                                                                                    </div>
                                                                    </div>`;
            document.getElementById(`questions-${catIndex}`).insertAdjacentHTML('beforeend', questionHtml);
        }

        function removeQuestion(catIndex, qIndex) {
            document.getElementById(`question-${catIndex}-${qIndex}`).remove();
        }

        // function toggleAnswer(btn, catIndex, qIndex, opt) {
        // console.log(opt)
        //     let hiddenInput = btn.nextElementSibling;
        //     if (hiddenInput.value === "false") {
        //         hiddenInput.value = "true";
        //         btn.classList.add("bg-green-500", "text-white");
        //         btn.innerText = "Correct";
        //     } else {
        //         hiddenInput.value = "false";
        //         btn.classList.remove("bg-green-500", "text-white");
        //         btn.innerText = "Mark Correct";
        //     }
        // }


        function toggleAnswer(btn, catIndex, qIndex, opt) {

            let questionSection = document.getElementById(`question-${catIndex}-${qIndex}`);


            let allButtons = questionSection.querySelectorAll('.ans-btn');
            let allHiddenInputs = questionSection.querySelectorAll('input[type="hidden"]');

            allButtons.forEach(button => {
                button.classList.remove("bg-green-500", "text-white");
                button.classList.add("bg-gray-300", "text-black");
                button.innerText = "Mark Correct";
            });

            allHiddenInputs.forEach(input => {
                input.value = "false";
            });


            let hiddenInput = btn.nextElementSibling;
            hiddenInput.value = "true";
            btn.classList.remove("bg-gray-300", "text-black");
            btn.classList.add("bg-green-500", "text-white");
            btn.innerText = "Correct";
        }


        document.getElementById("quizForm").addEventListener("submit", function(event) {
            event.preventDefault();
            document.querySelectorAll(".error-message").forEach(el => el.remove());
            document.querySelectorAll(".border-red-500").forEach(el => el.classList.remove("border-red-500"));
            let categories = document.querySelectorAll(".category-section");
            if (categories.length === 0) {
                toastr.error("A quiz must have at least one category.");
                document.getElementById("quizCategories").insertAdjacentHTML("beforeBegin",
                    `<p class="error-message text-red-500">A Quiz Must have atleast one category</p>`);
                return;
            }

            let valid = true;

            categories.forEach(category => {
                let categoryId = category.id.split("-")[1];
                document.querySelector(`#category-${categoryId}`).classList.remove("border-red-500");
                let questions = document.querySelectorAll(`#questions-${categoryId} .question-section`);

                if (questions.length === 0) {
                    toastr.error(`Category must have at least one question.`);
                    let catSection = document.querySelector(`#category-${categoryId}`)
                    catSection.classList.add("border-red-500");
                    catSection.insertAdjacentHTML("beforeBegin",
                        `<p class="error-message text-red-500">A Category Must have atleast one Question</p>`
                        );
                    valid = false;
                }
            });

            if (!valid) return;
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
                    console.log(data);
                    if (data.error) {
                        highlightErrors(data.error);
                        toastr.error('Failed to create Quiz');
                    } else {
                        toastr.success(data.success);

                        window.location.href = `/admin/quiz/courses/${courseId}/quizes`
                    }
                })
                .catch(error => console.log("Error:", error));
        });

        function highlightErrors(errors) {
            document.querySelectorAll(".border-red-500").forEach(el => el.classList.remove("border-red-500"));
            for (const key in errors) {
                let parts = key.match(/\d+/g);
                if (parts) {
                    if (parts.length === 1) {
                        document.querySelector(`#category-${parts[0]}`).classList.add("border-red-500");
                    } // category error 
                    else if (parts.length === 2) {
                        let questionEl = document.querySelector(`#question-${parts[0]}-${parts[1]}`);
                        questionEl.classList.add("border-red-500");
                        questionEl.insertAdjacentHTML("beforeBegin",
                            `<p class="error-message text-red-500">${errors[key]} </p>`);
                    }
                }
            }
        }
    </script>
@endsection
