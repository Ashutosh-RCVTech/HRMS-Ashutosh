@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <h1 class="text-2xl font-bold mb-8">Edit Quiz Course</h1>

                <form method="POST" id="quiz_course_form">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="course_id" value="{{ $course->id }}">

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                            Course Name
                        </label>
                        <input id="name" name="name" type="text" required value="{{ $course->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                   focus:border-indigo-500 focus:ring-indigo-500 
                                   dark:bg-slate-800 dark:text-white dark:border-gray-700" placeholder="Enter course name">
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                   focus:border-indigo-500 focus:ring-indigo-500 
                                   dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            placeholder="Enter course description">{{ $course->description }}</textarea>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                                   rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                   hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none 
                                   focus:border-indigo-900 focus:ring ring-indigo-300 
                                   disabled:opacity-25 transition ease-in-out duration-150">
                            Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#quiz_course_form").submit(function (e) {
                e.preventDefault();
                let form = $(this)[0];
                let data = new FormData(form);
                let courseId = $("#course_id").val();

                $.ajax({
                    url: "/admin/quiz/courses/" + courseId,
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    headers: { "X-HTTP-Method-Override": "PUT" },
                    success: function (response) {
                        if (response.errors) {
                            var errorMsg = '';
                            $.each(response.errors, function (field, errors) {
                                $.each(errors, function (index, error) {
                                    errorMsg += error + '<br>';
                                });
                            });
                            toastr.error(errorMsg || 'Failed to update course');
                        } else {
                            toastr.success(response.message);
                            window.location.href = '/admin/quiz/courses';
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error('An error occurred: ' + error);
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection