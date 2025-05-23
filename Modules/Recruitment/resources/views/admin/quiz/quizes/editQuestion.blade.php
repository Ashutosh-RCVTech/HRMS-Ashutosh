@extends('layouts.admin')

@section('content')
<main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-md dark:bg-slate-800 dark:text-white">
            <h1 class="text-2xl font-bold mb-6">Edit Question</h1>
            
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md dark:bg-red-900 dark:text-red-100">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.quiz.quiz.category.question.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="question_id" value="{{ $question->id }}">
                
                <!-- Question Textarea -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2 dark:text-gray-300">Question</label>
                    <textarea name="question" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500" 
                        rows="5" required>{{ old('question', $question->question) }}</textarea>
                </div>
                
                <!-- Options Section -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2 dark:text-gray-300">Options</label>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($question->options as $index => $option)
                            <div class="flex items-center gap-4">
                                <!-- Option Text Input -->
                                <input type="text" name="options[]" value="{{ old("options.$index", $option->option) }}" 
                                    class="flex-1 px-4 py-2 border rounded-lg transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 {{ $option->ans_status ? 'bg-green-100 dark:bg-green-900' : '' }}" 
                                    required id="option-{{ $index }}">
                                
                                <!-- Radio Button for Correct Answer -->
                                <input type="radio" name="correct_option" value="{{ $index }}" 
                                    class="hidden peer" id="radio-{{ $index }}" {{ $option->ans_status ? 'checked' : '' }} required>
                                
                                <!-- Custom Radio Button Styling -->
                                <label for="radio-{{ $index }}" 
                                    class="flex-shrink-0 w-6 h-6 border-2 border-gray-400 rounded-full flex items-center justify-center cursor-pointer transition-colors
                                           peer-checked:border-blue-500 peer-checked:bg-blue-500 dark:peer-checked:border-blue-400 dark:peer-checked:bg-blue-400">
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-800">
                        Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle radio button changes to highlight correct answer
        document.querySelectorAll("input[type='radio'][name='correct_option']").forEach(radio => {
            radio.addEventListener('change', function () {
                // Remove all highlight classes
                document.querySelectorAll("input[type='text'][name='options[]']").forEach(input => {
                    input.classList.remove('bg-green-100', 'dark:bg-green-900');
                });
                
                // Add highlight to selected option
                document.getElementById(`option-${this.value}`).classList.add('bg-green-100', 'dark:bg-green-900');
            });
        });

        // Initialize highlighting for pre-selected correct answer
        const checkedRadio = document.querySelector("input[type='radio'][name='correct_option']:checked");
        if (checkedRadio) {
            document.getElementById(`option-${checkedRadio.value}`).classList.add('bg-green-100', 'dark:bg-green-900');
        }
    });
</script>
@endsection