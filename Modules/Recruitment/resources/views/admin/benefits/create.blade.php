@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900 dark:text-white">
                <h1 class="text-2xl font-bold mb-8">Add Benefit</h1>

                <form method="POST" id="benefit_form" action="{{ route('admin.benefits.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">
                            Benefit Name
                        </label>
                        <input id="name" name="name" type="text" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                      focus:border-indigo-500 focus:ring-indigo-500 
                                      dark:bg-slate-800 dark:text-white dark:border-gray-700"
                            placeholder="Enter benefit name">
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
                            Create Benefit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $("#benefit_form").submit(function(e) {
                e.preventDefault();
                let form = $(this)[0];
                let data = new FormData(form);

                $.ajax({
                    url: "{{ route('admin.benefits.store') }}",
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.errors) {
                            var errorMsg = '';
                            $.each(response.errors, function(field, errors) {
                                $.each(errors, function(index, error) {
                                    errorMsg += error + '<br>';
                                });
                            });
                            toastr.error(errorMsg || 'Failed to create Benefit');
                        } else {
                            toastr.success(response.message);
                            // Redirect after successful submission to listing
                            window.location.href = '/admin/benefits';
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + error);
                        console.log(xhr
                            .responseText); // This will help debug server-side errors
                    }
                });
            });
        });
    </script>
@endsection
