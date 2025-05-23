@extends('recruitment::candidate.layouts.app')

@section('content')
    @include('recruitment::candidate.components.search-filters')

    <div class="flex flex-col lg:flex-row gap-6">
        @include('recruitment::candidate.components.sidebar')
        @include('recruitment::candidate.components.job-listing')
    </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize jobs with proper filter and display
            function initializeJobListings() {
                const jobListings = document.getElementById('jobListings');
                jobListings.innerHTML = '';

                jobs.forEach(job => {
                    const jobCard = `
                <div class="bg-white dark:bg-slate-900 shadow-lg rounded-lg p-4 hover:shadow-xl transition-shadow duration-200">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 dark:text-white">${job.date}</span>
                        <button class="text-gray-400 hover:text-primary-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <img src="${job.logo}" class="w-8 h-8 rounded" alt="${job.company} logo" />
                        <span class="dark:text-white">${job.company}</span>
                    </div>
                    <h3 class="font-bold mb-2 dark:text-white">${job.title}</h3>
                    <div class="flex flex-wrap gap-2 mb-4">
                        ${job.tags.map(tag => `
                                                        <span class="bg-gray-100 dark:bg-slate-900 dark:text-white rounded-full px-3 py-1 text-sm">${tag}</span>
                                                    `).join('')}
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-bold text-primary-500">₹${job.rate}/hr</div>
                            <div class="text-gray-500 dark:text-white text-sm">${job.location}</div>
                        </div>
                        <button class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">Details</button>
                    </div>
                </div>
            `;
                    jobListings.insertAdjacentHTML('beforeend', jobCard);
                });

                // Apply initial filters after job cards are created
                filterJobs();
                filterBySalary(salaryRange.value);
            }

            // Filter functionality
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', filterJobs);
            });

            function filterJobs() {
                const selectedFilters = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.parentElement.textContent.trim().toLowerCase());

                const jobCards = document.querySelectorAll('#jobListings > div');
                jobCards.forEach(card => {
                    const tags = Array.from(card.querySelectorAll('.flex-wrap span'))
                        .map(span => span.textContent.toLowerCase());

                    const shouldShow = selectedFilters.length === 0 ||
                        selectedFilters.some(filter => tags.includes(filter));
                    card.style.display = shouldShow ? 'block' : 'none';
                });
            }

            // Sort functionality
            const sortSelect = document.querySelector('select:last-of-type');
            sortSelect.addEventListener('change', sortJobs);

            function sortJobs() {
                const jobCards = Array.from(document.querySelectorAll('#jobListings > div'));
                const sortType = sortSelect.value.toLowerCase();

                jobCards.sort((a, b) => {
                    if (sortType === 'last updated') {
                        const dateA = new Date(a.querySelector('.text-gray-500').textContent);
                        const dateB = new Date(b.querySelector('.text-gray-500').textContent);
                        return dateB - dateA;
                    }
                    return 0;
                });

                const jobListings = document.getElementById('jobListings');
                jobCards.forEach(card => jobListings.appendChild(card));
            }

            // Bookmark functionality
            document.addEventListener('click', (e) => {
                const bookmarkBtn = e.target.closest('.text-gray-400');
                if (bookmarkBtn) {
                    bookmarkBtn.classList.toggle('text-primary-500');
                }
            });
        });
    </script>
@endsection
