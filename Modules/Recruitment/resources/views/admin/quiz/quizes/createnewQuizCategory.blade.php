@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white p-6 rounded-lg shadow-md dark:bg-slate-900 dark:text-white">
                <h1 class="text-2xl font-bold mb-6">Create New Category</h1>

                <form action="{{ route('admin.quiz.quiz.category.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="quiz_id" value="{{ $id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Category Name</label>
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                        focus:border-indigo-500 focus:ring-indigo-500 
                        dark:bg-slate-800 dark:text-white dark:border-gray-700" required>
                        @error('name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-indigo-700 text-white px-4 py-2 rounded">
                        Save Category
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection