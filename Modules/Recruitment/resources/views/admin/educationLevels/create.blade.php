@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <h1 class="text-2xl font-bold mb-8">Add Education Level</h1>

                <form id="educationLevels_form" method="POST" action="{{ route('admin.educationLevels.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                            Education Level Name
                        </label>
                        <input id="name" name="name" type="text" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                  focus:border-indigo-500 focus:ring-indigo-500 
                                  dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            placeholder="Enter education level name">
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
                            Create Education Level
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('educationLevels_form');

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
                            toastr.error(errorMsg || 'Failed to create education level');
                        } else {
                            toastr.success(data.message);
                            window.location.href = '/admin/educationLevels';
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
