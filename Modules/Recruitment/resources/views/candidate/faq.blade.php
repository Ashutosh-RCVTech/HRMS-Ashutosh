@extends('recruitment::candidate.layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="container mx-auto">
            <!-- FAQ Header -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-primary-600 mb-2 dark:text-white">Frequently Asked Questions</h1>
                <p class="text-gray-600 dark:text-white">Find answers to the most common questions about our recruitment
                    platform</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-8">
                <div class="relative">
                    <input type="text" id="faqSearch"
                        class="w-full py-3 px-4 pr-12 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-900 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
                        placeholder="Search for questions...">
                    <div class="absolute right-3 top-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- FAQ Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @foreach ($faqs as $index => $category)
                    <button
                        class="faq-category bg-white dark:bg-slate-900 shadow-md rounded-lg py-4 text-center transition-all hover:shadow-lg hover:bg-gray-500  dark:hover:bg-darkblack-500 {{ $index === 0 ? 'border-primary-500 border' : 'border border-transparent' }}"
                        data-category="{{ $loop->index }}">
                        <h3 class="text-lg font-medium text-primary-600 dark:text-white">{{ $category['category'] }}</h3>
                        <p class="text-sm text-gray-500 dark:text-white">{{ count($category['questions']) }} questions</p>
                    </button>
                @endforeach
            </div>

            <!-- FAQ Accordions -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-md">
                @foreach ($faqs as $index => $category)
                    <div class="faq-content {{ $index !== 0 ? 'hidden' : '' }}" data-category="{{ $loop->index }}">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-2xl font-semibold text-primary-600 dark:text-white">{{ $category['category'] }}
                            </h2>
                            <p class="text-gray-600 dark:text-white mt-2">Find answers related to
                                {{ strtolower($category['category']) }}</p>
                        </div>

                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($category['questions'] as $faq)
                                <div class="faq-item">
                                    <button
                                        class="faq-question w-full flex justify-between items-center p-6 focus:outline-none">
                                        <h3 class="text-lg font-medium text-gray-800 dark:text-white text-left">
                                            {{ $faq['question'] }}</h3>
                                        <svg class="faq-icon w-5 h-5 text-primary-500 transition-transform" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="faq-answer hidden px-6 pb-6">
                                        <div class="prose prose-sm max-w-none text-gray-600 dark:text-white">
                                            <p>{{ $faq['answer'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Still have questions section -->
            <div class="mt-12 bg-primary-50 dark:bg-slate-900 rounded-xl p-8 text-center">
                <h2 class="text-2xl font-bold text-primary-600 dark:text-white mb-4">Still have questions?</h2>
                <p class="text-gray-600 dark:text-white mb-6">Can't find the answer you're looking for? Please reach out
                    to our support team.</p>
                <a href="#"
                    class="inline-block bg-primary-500 hover:bg-primary-600 text-white py-3 px-6 rounded-lg font-medium transition-colors">
                    Contact Support
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Accordion functionality
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(question => {
                question.addEventListener('click', () => {
                    const answer = question.nextElementSibling;
                    const icon = question.querySelector('.faq-icon');

                    // Toggle current answer
                    answer.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Category tabs functionality
            const categoryButtons = document.querySelectorAll('.faq-category');
            const faqContents = document.querySelectorAll('.faq-content');

            // categoryButtons.forEach(button => {
            //     button.addEventListener('click', () => {
            //         const categoryIndex = button.getAttribute('data-category');

            //         // Update active category styling
            //         categoryButtons.forEach(btn => {
            //             btn.classList.remove('border-primary-500', 'border');
            //             btn.classList.add('border-transparent');
            //         });
            //         button.classList.remove('border-transparent');
            //         button.classList.add('border-primary-500', 'border');

            //         // Show selected category content and hide others
            //         faqContents.forEach(content => {
            //             if (content.getAttribute('data-category') === categoryIndex) {
            //                 content.classList.remove('hidden');
            //             } else {
            //                 content.classList.add('hidden');
            //             }
            //         });

            //         // Reset search
            //         document.getElementById('faqSearch').value = '';
            //         resetSearch();
            //     });
            // });


            categoryButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const categoryIndex = button.getAttribute('data-category');

                    // Update active category styling
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('border-primary-500', 'border');
                        btn.classList.add('border-transparent');
                    });
                    button.classList.remove('border-transparent');
                    button.classList.add('border-primary-500', 'border');

                    // Show selected category content and hide others
                    faqContents.forEach(content => {
                        if (content.getAttribute('data-category') === categoryIndex) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });

                    // Reset search input but do NOT call resetSearch()
                    document.getElementById('faqSearch').value = '';
                    // Instead, manually reset the FAQ items in the selected category
                    const activeContent = document.querySelector(
                        `.faq-content[data-category="${categoryIndex}"]`);
                    const activeItems = activeContent.querySelectorAll('.faq-item');
                    activeItems.forEach(item => {
                        item.classList.remove('hidden');
                        // Reset highlighting and answers if necessary
                        const questionElement = item.querySelector('.faq-question h3');
                        const answerElement = item.querySelector('.faq-answer p');
                        questionElement.innerHTML = questionElement.textContent;
                        answerElement.innerHTML = answerElement.textContent;
                        const answer = item.querySelector('.faq-answer');
                        const icon = item.querySelector('.faq-icon');
                        answer.classList.add('hidden');
                        icon.classList.remove('rotate-180');
                    });

                    // Hide no results message
                    noResultsMessage.classList.add('hidden');
                });
            });

            // Search functionality
            const searchInput = document.getElementById('faqSearch');
            const faqItems = document.querySelectorAll('.faq-item');
            const noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('p-6', 'text-center', 'text-gray-500', 'dark:text-white', 'hidden');
            noResultsMessage.id = 'noResultsMessage';
            noResultsMessage.innerHTML = 'No matching questions found. Please try a different search term.';
            document.querySelector('.faq-content').parentNode.appendChild(noResultsMessage);

            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase().trim();

                if (searchTerm === '') {
                    resetSearch();
                    return;
                }

                // Show all categories for searching across everything
                faqContents.forEach(content => {
                    content.classList.remove('hidden');
                });

                // Reset active category styling
                categoryButtons.forEach(btn => {
                    btn.classList.remove('border-primary-500', 'border');
                    btn.classList.add('border-transparent');
                });

                let matchFound = false;

                // Search through all FAQ items
                faqItems.forEach(item => {
                    const question = item.querySelector('.faq-question h3').textContent
                        .toLowerCase();
                    const answer = item.querySelector('.faq-answer p').textContent.toLowerCase();

                    if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                        item.classList.remove('hidden');
                        highlightText(item, searchTerm);
                        matchFound = true;

                        // Expand matching items
                        const answer = item.querySelector('.faq-answer');
                        const icon = item.querySelector('.faq-icon');
                        answer.classList.remove('hidden');
                        icon.classList.add('rotate-180');
                    } else {
                        item.classList.add('hidden');
                    }
                });

                // Show/hide no results message
                if (!matchFound) {
                    noResultsMessage.classList.remove('hidden');
                } else {
                    noResultsMessage.classList.add('hidden');
                }
            });

            // function resetSearch() {
            //     // Reset all FAQ items to be visible
            //     faqItems.forEach(item => {
            //         item.classList.remove('hidden');

            //         // Reset highlighting
            //         const questionElement = item.querySelector('.faq-question h3');
            //         const answerElement = item.querySelector('.faq-answer p');

            //         questionElement.innerHTML = questionElement.textContent;
            //         answerElement.innerHTML = answerElement.textContent;

            //         // Close all answers
            //         const answer = item.querySelector('.faq-answer');
            //         const icon = item.querySelector('.faq-icon');
            //         answer.classList.add('hidden');
            //         icon.classList.remove('rotate-180');
            //     });

            //     // Show only the first category
            //     faqContents.forEach((content, index) => {
            //         if (index === 0) {
            //             content.classList.remove('hidden');
            //         } else {
            //             content.classList.add('hidden');
            //         }
            //     });

            //     // Hide no results message
            //     noResultsMessage.classList.add('hidden');
            // }

            function resetSearch() {
                // Reset all FAQ items to be visible
                faqItems.forEach(item => {
                    item.classList.remove('hidden');

                    // Reset highlighting
                    const questionElement = item.querySelector('.faq-question h3');
                    const answerElement = item.querySelector('.faq-answer p');

                    questionElement.innerHTML = questionElement.textContent;
                    answerElement.innerHTML = answerElement.textContent;

                    // Close all answers
                    const answer = item.querySelector('.faq-answer');
                    const icon = item.querySelector('.faq-icon');
                    answer.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                });

                // Hide no results message
                noResultsMessage.classList.add('hidden');
            }


            function highlightText(item, searchTerm) {
                const questionElement = item.querySelector('.faq-question h3');
                const answerElement = item.querySelector('.faq-answer p');

                const questionText = questionElement.textContent;
                const answerText = answerElement.textContent;

                const highlightedQuestion = questionText.replace(
                    new RegExp(searchTerm, 'gi'),
                    match => `<span class="bg-yellow-200 dark:bg-yellow-700">${match}</span>`
                );

                const highlightedAnswer = answerText.replace(
                    new RegExp(searchTerm, 'gi'),
                    match => `<span class="bg-yellow-200 dark:bg-yellow-700">${match}</span>`
                );

                questionElement.innerHTML = highlightedQuestion;
                answerElement.innerHTML = highlightedAnswer;
            }
        });
    </script>
@endsection
