@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white p-6 rounded-lg shadow-md dark:bg-slate-900 dark:text-white">
                <h1 class="text-2xl font-bold mb-6">Add New Question</h1>

                <form action="{{ route('admin.quiz.quiz.category.question.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $categoryId }}">
                    <input type="hidden" name="quiz_id" value="{{ $quizId }}">

                    <label class="block text-sm font-medium">Question</label>
                    <input type="text" name="question" class="w-full px-4 py-2 border rounded-lg mb-4" required>

                    <label class="block text-sm font-medium">Options</label>
                    {{-- <div class="grid grid-cols-1 gap-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center gap-2">
                            <input type="text" name="options[]" class="w-full px-4 py-2 border rounded-lg" required>
                            <input type="radio" name="correct_option" value="{{ $i }}" required>
                        </div>
                    @endfor
                </div> --}}

                    <div class="grid grid-cols-1 gap-2">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="flex items-center gap-2">
                                <input type="text" name="options[]"
                                    class="w-full px-4 py-2 border rounded-lg transition-all duration-200" required
                                    id="option-{{ $i }}">
                                <input type="radio" name="correct_option" value="{{ $i }}" class="hidden peer"
                                    id="radio-{{ $i }}">
                                <label for="radio-{{ $i }}"
                                    class="w-6 h-6 border-2 border-gray-400 rounded-full flex items-center justify-center cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-500"></label>
                            </div>
                        @endfor
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save Question</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll("input[type='radio'][name='correct_option']").forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll("input[type='text']").forEach(input => input.classList
                    .remove('bg-green-200'));
                document.getElementById(`option-${this.value}`).classList.add('bg-green-200');
            });
        });
    });
</script>
