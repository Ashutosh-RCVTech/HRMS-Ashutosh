{{-- @extends('recruitment::college.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Top Search Bar -->
        <div class="mb-4">
            <input type="text" id="search-input" class="border p-2 w-full rounded dark:bg-slate-900 dark:text-white"
                placeholder="Search placements..." />
            <!-- <button id="search-button" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                Search
            </button> -->
        </div>
        <!-- Cards Container -->
        <div id="placement-cards-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Cards will be appended here -->
        </div>
    </div>

    <!-- Loader element -->
    <div id="loader" class="text-center py-4 hidden dark:text-white">
        Loading...
    </div>


    <!-- Confirmation Modal -->
    <div id="accept-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Confirm Acceptance</h3>
            <p>Are you sure you want to accept <span id="placement-name" class="font-medium"></span>?</p>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeModal()" class="px-4 py-2 border rounded-md hover:bg-gray-50">Cancel</button>
                <button onclick="confirmAccept()"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Confirm Rejection</h3>
            <p>Are you sure you want to reject <span id="reject-placement-name" class="font-medium"></span>?</p>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeRejectModal()" class="px-4 py-2 border rounded-md hover:bg-gray-50">Cancel</button>
                <button onclick="confirmReject()"
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Confirm</button>
            </div>
        </div>
    </div>
    @php
        // Generate base URL using the route name
        $placementUrl = route('college.placement.list', ['collegeId' => auth()->guard('college')->user()->id]);
    @endphp

    <script>
        const baseUrl = @json($placementUrl);
        let page = 1;
        let hasMore = true;
        let loading = false;
        let currentSearch = '';
        let abortController = null;

        const PlacementContainer = document.getElementById('placement-cards-container');
        const loader = document.getElementById('loader');
        const searchInput = document.getElementById('search-input');

        function createCard(item) {
            const card = document.createElement('div');

            card.setAttribute('data-placement-card-id', item.id);

            card.className = `p-4 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl ${
        item.college_acceptance === 1 ? 'bg-green-50 border-l-4 border-green-500' :
        item.college_acceptance === 2 ? 'bg-red-50 border-l-4 border-red-500' :
        'bg-gray-50 border-l-4 border-gray-300'
    }`;

            const statusText = item.college_acceptance === 1 ? 'Accepted' :
                item.college_acceptance === 2 ? 'Rejected' : 'Pending';

            const showDecisionButtons = item.college_acceptance !== 1 && item.college_acceptance !== 2;

            card.innerHTML = `
        <div class="h-full flex flex-col justify-between space-y-3">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-semibold text-gray-800 truncate">${item.name}</h3>
                    <span class="text-sm ${
                        item.college_acceptance === 1 ? 'text-green-600' :
                        item.college_acceptance === 2 ? 'text-red-600' : 
                        'text-gray-500'
                    }">
                        ${statusText}
                    </span>
                </div>
                ${item.description ? `
                        <p class="text-sm text-gray-600 line-clamp-3 mb-3">${item.description}</p>
                    ` : ''}
            </div>
            
            <div class="flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center space-x-1">
                    <!-- Optional metadata here -->
                </div>
                <div class="flex gap-2">
                    ${showDecisionButtons ? `
                            <button onclick="handleAcceptClick(event)" 
                                data-placement-id="${item.id}"
                                data-placement-name="${item.name}"
                                class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-md text-sm 
                                    transition-colors duration-200">
                                Accept
                            </button>
                            <button onclick="handleRejectClick(event)" 
                                data-placement-id="${item.id}"
                                data-placement-name="${item.name}"
                                class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm 
                                    transition-colors duration-200">
                                Reject
                            </button>
                        ` : ''}
                    <button onclick="handleAssignClick(event)" 
                        data-placement-id="${item.id}"
                        class="px-3 py-1 bg-purple-500 hover:bg-purple-600 text-white rounded-md text-sm 
                            transition-colors duration-200">
                        Assign
                    </button>
                    <button onclick="handleViewDeatilsClick(event)" 
                        data-placement-detail-id="${item.id}"
                        class="px-3 py-1 bg-purple-500 hover:bg-purple-600 text-white rounded-md text-sm 
                            transition-colors duration-200">
                        View Details
                    </button>
                </div>
            </div>
        </div>
    `;

            return card;
        }
 --}}

@extends('recruitment::college.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Top Search Bar -->
        <div class="mb-6 flex justify-end">
            <div class="w-full max-w-md relative">
                <input type="text" id="search-input"
                    class="w-full pl-4 pr-10 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-900 text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-purple-500 focus:outline-none transition duration-300"
                    placeholder="Search placements..." />
                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400 dark:text-gray-500 pointer-events-none"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M15 11a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>


        <!-- Cards Container -->
        {{-- <div id="placement-cards-container"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Cards will be appended here -->
    </div> --}}
        <div class="h-[75vh] overflow-y-auto pr-2">
            <div id="placement-cards-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Cards will be appended here -->
            </div>
        </div>

    </div>

    <!-- Loader -->
    <div id="loader" class="text-center py-6 text-gray-600 dark:text-gray-300 hidden">
        Loading...
    </div>

    <!-- Accept Modal -->
    <div id="accept-modal"
        class="fixed inset-0 bg-black/50 hidden flex items-center justify-center p-4 z-50 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 rounded-lg p-6 max-w-md w-full shadow-lg">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Confirm Acceptance</h3>
            <p class="text-gray-700 dark:text-gray-300">Are you sure you want to accept <span id="placement-name"
                    class="font-medium"></span>?</p>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeModal()"
                    class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-slate-700 dark:border-slate-600 dark:text-white">
                    Cancel
                </button>
                <button onclick="confirmAccept()"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal"
        class="fixed inset-0 bg-black/50 hidden flex items-center justify-center p-4 z-50 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 rounded-lg p-6 max-w-md w-full shadow-lg">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Confirm Rejection</h3>
            <p class="text-gray-700 dark:text-gray-300">Are you sure you want to reject <span id="reject-placement-name"
                    class="font-medium"></span>?</p>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeRejectModal()"
                    class="px-4 py-2 border rounded-md hover:bg-gray-100 dark:hover:bg-slate-700 dark:border-slate-600 dark:text-white">
                    Cancel
                </button>
                <button onclick="confirmReject()"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    @php
        $placementUrl = route('college.placement.list', ['collegeId' => auth()->guard('college')->user()->id]);
    @endphp

    <script>
        const baseUrl = @json($placementUrl);
        let page = 1;
        let hasMore = true;
        let loading = false;
        let currentSearch = '';
        let abortController = null;

        const PlacementContainer = document.getElementById('placement-cards-container');
        const loader = document.getElementById('loader');
        const searchInput = document.getElementById('search-input');

        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function createCard(item) {
            const card = document.createElement('div');
            card.setAttribute('data-placement-card-id', item.id);
            card.setAttribute('data-placement-status', item.college_acceptance); // for dynamic updates

            const status = item.college_acceptance;
            const statusMap = {
                1: {
                    text: 'Accepted',
                    textColor: 'text-green-600 dark:text-green-400',
                    cardBg: 'bg-green-50 dark:bg-green-900/20 border-green-500 dark:border-green-400'
                },
                2: {
                    text: 'Rejected',
                    textColor: 'text-red-600 dark:text-red-400',
                    cardBg: 'bg-red-50 dark:bg-red-900/20 border-red-500 dark:border-red-400'
                },
                0: {
                    text: 'Pending',
                    textColor: 'text-gray-600 dark:text-gray-300',
                    cardBg: 'bg-gray-50 dark:bg-slate-800 border-gray-300 dark:border-slate-600'
                }
            };
            const current = statusMap[status] || statusMap[0];

            card.className =
                `p-5 rounded-xl border-l-4 shadow-sm hover:shadow-md transition-all duration-300 ${current.cardBg}`;

            card.innerHTML = `
        <div class="flex flex-col h-full justify-between space-y-4">
            <div class="flex justify-between items-start">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">${item.name}</h3>
                <span class="text-sm font-medium ${current.textColor}">
                    ${current.text}
                </span>
            </div>

            ${item.description ? `<p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-3">${item.description}</p>` : ''}

            <div class="flex flex-nowrap gap-x-2 justify-end pt-3 border-t dark:border-slate-700 overflow-x-auto" id="button-container-${item.id}">
                ${
                    status === 0
                        ? `
                                <button onclick="handleAcceptClick(event)"
                                    data-placement-id="${item.id}"
                                    data-placement-name="${item.name}"
                                    class="px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-md transition whitespace-nowrap">
                                    Accept
                                </button>
                                <button onclick="handleRejectClick(event)"
                                    data-placement-id="${item.id}"
                                    data-placement-name="${item.name}"
                                    class="px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition whitespace-nowrap">
                                    Reject
                                </button>
                                <button onclick="handleViewDeatilsClick(event)"
                                    data-placement-detail-id="${item.id}"
                                    class="px-2 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition whitespace-nowrap">
                                    View Details
                                </button>
                            `
                        : `
                                <button onclick="handleAssignClick(event)"
                                    data-placement-id="${item.id}"
                                    class="px-2 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition whitespace-nowrap">
                                    Assign
                                </button>
                                <button onclick="handleViewDeatilsClick(event)"
                                    data-placement-detail-id="${item.id}"
                                    class="px-2 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition whitespace-nowrap">
                                    View Details
                                </button>
                            `
                }
            </div>
        </div>
    `;

            return card;
        }

        // Debounce function
        function debounce(func, delay) {
            let timeoutId;
            return (...args) => {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Abort ongoing request
        function abortOngoingRequest() {
            if (abortController) {
                abortController.abort();
                abortController = null;
            }
        }

        async function loadData() {
            if (loading || !hasMore) return;

            abortOngoingRequest();
            loading = true;
            loader.classList.remove('hidden');
            abortController = new AbortController();

            try {
                const url = new URL(baseUrl);
                url.searchParams.set('search', currentSearch);
                url.searchParams.set('page', page);

                const res = await fetch(url, {
                    signal: abortController.signal
                });

                if (!res.ok) throw new Error('Network response was not ok');

                const json = await res.json();

                // Reset container if it's a new search
                if (page === 1) {
                    PlacementContainer.innerHTML = '';
                }

                json.data.forEach(item => PlacementContainer.appendChild(createCard(item)));

                hasMore = !!json.next_page_url;
                page = hasMore ? page + 1 : page;
            } catch (err) {
                if (err.name !== 'AbortError') {
                    console.error("Error fetching data", err);
                }
            } finally {
                loader.classList.add('hidden');
                loading = false;
                abortController = null;
            }
        }

        // Handle search input with debouncing
        const handleSearch = debounce(() => {
            const newSearch = searchInput.value.trim();

            // Only reload if search actually changed
            if (newSearch !== currentSearch) {
                page = 1;
                hasMore = true;
                currentSearch = newSearch;
                loadData();
            }
        }, 300);

        // Event listeners
        searchInput.addEventListener('input', handleSearch);

        // Infinite scroll
        window.addEventListener('scroll', () => {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200) {
                loadData();
            }
        });

        // Initial load
        loadData();





        let selectedPlacementId = null;

        function handleAcceptClick(event) {
            const card = event.target.closest('[data-placement-card-id]');
            selectedPlacementId = card.dataset.placementCardId;
            const placementName = card.querySelector('h3').textContent;

            document.getElementById('placement-name').textContent = placementName;
            document.getElementById('accept-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('accept-modal').classList.add('hidden');
            selectedPlacementId = null;
        }

        async function confirmAccept() {
            if (!selectedPlacementId) return;

            try {
                const response = await fetch(`/college/placement/${selectedPlacementId}/accept`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Failed to update status');
                }

                // Update UI
                const card = document.querySelector(`[data-placement-card-id="${selectedPlacementId}"]`);

                if (card) {
                    // Update status text
                    const statusSpan = card.querySelector('span');
                    statusSpan.textContent = 'Accepted';
                    statusSpan.className = 'text-sm text-green-600';

                    // Update card styling
                    card.className = card.className
                        .replace('bg-gray-50', 'bg-green-50')
                        .replace('border-gray-300', 'border-green-500')
                        .replace('bg-red-50', 'bg-green-50')
                        .replace('border-red-500', 'border-green-500');

                    // Disable buttons
                    const acceptBtn = card.querySelector('[onclick*="handleAcceptClick"]');
                    const rejectBtn = card.querySelector('[onclick*="handleRejectClick"]');
                    acceptBtn.disabled = true;
                    rejectBtn.disabled = true;
                    acceptBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    rejectBtn.classList.add('opacity-50', 'cursor-not-allowed');

                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'An unexpected error occurred');
            } finally {
                closeModal();
            }
        }

        let selectedRejectId = null;

        function handleRejectClick(event) {
            const card = event.target.closest('[data-placement-card-id]');
            selectedRejectId = card.dataset.placementCardId;
            const placementName = card.querySelector('h3').textContent;

            document.getElementById('reject-placement-name').textContent = placementName;
            document.getElementById('reject-modal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
            selectedRejectId = null;
        }

        async function confirmReject() {
            if (!selectedRejectId) return;

            try {
                const response = await fetch(`/college/placement/${selectedRejectId}/reject`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Failed to update status');
                }

                // Update UI
                const card = document.querySelector(`[data-placement-card-id="${selectedRejectId}"]`);

                if (card) {
                    const statusSpan = card.querySelector('span');
                    statusSpan.textContent = 'Rejected';
                    statusSpan.className = 'text-sm text-red-600';

                    card.className = card.className
                        .replace('bg-gray-50', 'bg-red-50')
                        .replace('border-gray-300', 'border-red-500')
                        .replace('bg-green-50', 'bg-red-50')
                        .replace('border-green-500', 'border-red-500');

                    // Disable buttons
                    const acceptBtn = card.querySelector('[onclick*="handleAcceptClick"]');
                    const rejectBtn = card.querySelector('[onclick*="handleRejectClick"]');
                    acceptBtn.disabled = true;
                    rejectBtn.disabled = true;
                    acceptBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    rejectBtn.classList.add('opacity-50', 'cursor-not-allowed');

                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Failed to reject placement');
            } finally {
                closeRejectModal();
            }
        }


        function handleAssignClick(event) {
            const placementId = event.target.dataset.placementId;
            const assignRoute = @json(route('college.candidate.placement.assigned', ['placement' => 'PLACEHOLDER']));
            window.location.href = assignRoute.replace('PLACEHOLDER', placementId);
        }


        function handleViewDeatilsClick(event) {
            const placementId = event.target.dataset.placementDetailId;
            const assignRoute = @json(route('college.candidate.placement.detail', ['placementid' => 'PLACEHOLDER']));
            window.location.href = assignRoute.replace('PLACEHOLDER', placementId);
            console.log(placementId);

        }
    </script>
@endsection
