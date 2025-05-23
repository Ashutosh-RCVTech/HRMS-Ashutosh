@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white rounded-xl shadow-lg">
                <h1 class="text-2xl font-bold mb-8">Add Job Type</h1>

                <form id="jobType_form" method="POST" action="{{ route('admin.jobTypes.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                            Job Type Name
                        </label>
                        <input id="name" name="name" type="text" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                  focus:border-indigo-500 focus:ring-indigo-500 
                                  dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            placeholder="Enter job type name">
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-8">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                                   rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                   hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none 
                                   focus:border-indigo-900 focus:ring ring-indigo-300 
                                   disabled:opacity-25 transition ease-in-out duration-150">
                            Create Job Type
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jobType_form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.errors) {
                            let errorMsg = Object.values(data.errors).flat().join('<br>');
                            toastr.error(errorMsg || 'Failed to create job type');
                        } else {
                            toastr.success(data.message);
                            window.location.href = '/admin/jobTypes';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred. Please try again.');
                    });
            });
        });
    </script>
@endsection
