    @extends('recruitment::college.layouts.app')

    @section('title', 'College Dashboard')

    @section('content')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div
            class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:bg-gradient-to-r dark:from-slate-800 dark:to-slate-900 min-h-screen pb-12">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-800 dark:to-indigo-900 shadow-lg">
                <div class="container mx-auto px-4 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">{{ $college->name }}
                            </h1>
                            <p class="text-blue-100 dark:text-blue-200 mt-1">Welcome back portal</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex items-center space-x-3">

                            <button id="refreshDashboard"
                                class="bg-white dark:bg-slate-700 dark:text-gray-200 text-indigo-700 dark:hover:bg-slate-600 hover:bg-blue-50 font-medium px-4 py-2 rounded-lg transition-all duration-200 shadow-sm flex items-center">
                                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="container mx-auto px-4 mt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Placements -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="bg-blue-500 dark:bg-blue-600 rounded-full p-3">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="font-semibold text-gray-600 dark:text-gray-300 text-sm uppercase">Total
                                        Placements</h2>
                                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                                        {{ $placements->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900 px-6 py-2">
                            <div class="text-sm text-blue-600 dark:text-blue-300">
                                <span
                                    class="font-medium">{{ number_format($placements->count() > 0 ? ($acceptedPlacements / $placements->count()) * 100 : 0, 1) }}%</span>
                                acceptance rate
                            </div>
                        </div>
                    </div>

                    <!-- Pending Placements -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="bg-yellow-500 dark:bg-yellow-600 rounded-full p-3">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="font-semibold text-gray-600 dark:text-gray-300 text-sm uppercase">Pending
                                    </h2>
                                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $pendingPlacements }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900 px-6 py-2">
                            <div class="text-sm text-yellow-600 dark:text-yellow-300">
                                <span class="font-medium">Action required</span>
                            </div>
                        </div>
                    </div>

                    <!-- Accepted Placements -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="bg-green-500 dark:bg-green-600 rounded-full p-3">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="font-semibold text-gray-600 dark:text-gray-300 text-sm uppercase">Accepted
                                    </h2>
                                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $acceptedPlacements }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 px-6 py-2">
                            <div class="text-sm text-green-600 dark:text-green-300">
                                <span class="font-medium">{{ $candidatePlacements->count() }}</span> candidates enrolled
                            </div>
                        </div>
                    </div>

                    <!-- Rejected Placements -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="bg-red-500 dark:bg-red-600 rounded-full p-3">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="font-semibold text-gray-600 dark:text-gray-300 text-sm uppercase">Rejected
                                    </h2>
                                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $rejectedPlacements }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900 px-6 py-2">
                            <div class="text-sm text-red-600 dark:text-red-300">
                                <span
                                    class="font-medium">{{ number_format($placements->count() > 0 ? ($rejectedPlacements / $placements->count()) * 100 : 0, 1) }}%</span>
                                rejection rate
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables Section -->
            <div class="container mx-auto px-4 mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Monthly Placements Chart -->
                {{-- <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-md lg:col-span-1">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Monthly Placement Statistics</h2>
                    <div class="h-64">
                        <canvas id="monthlyStats"></canvas>
                    </div>
                </div> --}}

                <!-- Pending Placements Table -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-md lg:col-span-3">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pending Placement Drives</h2>
                        <span   
                            class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $pendingPlacements }}
                            pending</span>
                    </div>

                    @if ($pendingPlacements > 0)
                        <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                            <table class="min-w-full bg-white dark:bg-slate-800">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach ($placements->where('college_acceptance', null) as $placement)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                            {{-- <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $placement->placement_id }}</td> --}}
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $placement->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                    Pending
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <button
                                                        class="accept-btn bg-green-100 dark:bg-green-900 hover:bg-green-200 dark:hover:bg-green-800 text-green-800 dark:text-green-300 px-3 py-1 rounded-md text-sm transition-colors duration-200"
                                                        data-placement-id="{{ $placement->placement_id }}">
                                                        Accept
                                                    </button>
                                                    <button
                                                        class="reject-btn bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 text-red-800 dark:text-red-300 px-3 py-1 rounded-md text-sm transition-colors duration-200"
                                                        data-placement-id="{{ $placement->placement_id }}">
                                                        Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">No pending placements
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You've handled all placement requests.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Candidate Placements -->
            {{-- <div class="container mx-auto px-4 mt-8">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Recent Candidate Placements</h2>
                        <span
                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $candidatePlacements->count() }}
                            total</span>
                    </div>

                    @if ($candidatePlacements->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-slate-800">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Candidate ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Placement ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach ($candidatePlacements->take(5) as $candidatePlacement)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $candidatePlacement->college_candidate_id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $candidatePlacement->placement_id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $candidatePlacement->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    Active
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($candidatePlacements->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('college.placements.index') }}"
                                    class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">
                                    View all {{ $candidatePlacements->count() }} candidate placements
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">No candidate placements</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start by accepting placement requests.</p>
                        </div>
                    @endif
                </div>
            </div> --}}

            <!-- Toast Notification -->
            <div id="toast"
                class="fixed top-10 right-4 flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 dark:text-gray-300 bg-white dark:bg-slate-800 rounded-lg shadow hidden transform transition-all duration-300 ease-in-out"
                role="alert">
                <div id="toast-icon" class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 rounded-lg">
                </div>
                <div id="toast-message" class="ml-3 text-sm font-normal"></div>
                <button type="button"
                    class="ml-auto -mx-1.5 -my-1.5 bg-white dark:bg-slate-800 text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-gray-200 rounded-lg focus:ring-2 focus:ring-gray-300 dark:focus:ring-slate-600 p-1.5 inline-flex h-8 w-8"
                    onclick="hideToast()">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Monthly Placements Chart
                initMonthlyStatsChart();

                //Presist theme
                if (localStorage.getItem('theme') === 'dark' ||
                    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }

                // Event listeners for accept/reject buttons
                // document.querySelectorAll('.accept-btn').forEach(button => {
                //     button.addEventListener('click', function() {
                //         const placementId = this.getAttribute('data-placement-id');
                //         updatePlacementAcceptance(placementId, true);
                //     });
                // });

                // document.querySelectorAll('.reject-btn').forEach(button => {
                //     button.addEventListener('click', function() {
                //         const placementId = this.getAttribute('data-placement-id');
                //         updatePlacementAcceptance(placementId, false);
                //     });
                // });

                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('accept-btn')) {
                        const placementId = e.target.getAttribute('data-placement-id');
                        updatePlacementAcceptance(placementId, true);
                    }

                    if (e.target.classList.contains('reject-btn')) {
                        const placementId = e.target.getAttribute('data-placement-id');
                        rejectPlacement(placementId); // Use new function
                    }
                });

                // Refresh Dashboard Button
                document.getElementById('refreshDashboard').addEventListener('click', function() {
                    showToast('Refreshing dashboard...', 'info');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                });
            });

            // Monthly Placements Chart Initialization
            function initMonthlyStatsChart() {
                fetch('{{ route('college.dashboard.stats') }}')
                    .then(response => response.json())
                    .then(data => {
                        const ctx = document.getElementById('monthlyStats').getContext('2d');

                        const months = Object.keys(data.monthlyStats);
                        const counts = Object.values(data.monthlyStats);

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: 'Placements',
                                    data: counts,
                                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                                    borderColor: 'rgba(79, 70, 229, 1)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                                    pointRadius: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                        padding: 10,
                                        cornerRadius: 6
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            drawBorder: false
                                        },
                                        ticks: {
                                            precision: 0
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching stats:', error);
                        // showToast('Failed to load statistics', 'error');
                    });
            }

            // Update Placement Acceptance Status
            // function updatePlacementAcceptance(placementId, acceptance) {
            //     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            //     fetch(`{{ url('recruitment/college/placement') }}/${placementId}/acceptance`, {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': csrfToken
            //             },
            //             body: JSON.stringify({
            //                 acceptance: acceptance
            //             })
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             if (data.success) {
            //                 showToast(data.message, acceptance ? 'success' : 'warning');
            //                 setTimeout(() => {
            //                     window.location.reload();
            //                 }, 1500);
            //             } else {
            //                 showToast('Failed to update placement status', 'error');
            //             }
            //         })
            //         .catch(error => {
            //             console.error('Error:', error);
            //             showToast('An error occurred', 'error');
            //         });
            // }
            function updatePlacementAcceptance(placementId, acceptance) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const endpoint = `college/placement/${placementId}/acceptance`;

                console.log('Attempting to update placement:', {
                    placementId,
                    acceptance,
                    endpoint,
                    csrfToken: csrfToken ? 'Exists' : 'Missing!'
                });

                fetch(`/college/placement/${placementId}/acceptance`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            acceptance: acceptance
                        })
                    })
                    .then(response => {
                        console.log('Raw response:', response);

                        if (!response.ok) {
                            // Get the response text even if status is not OK
                            return response.text().then(text => {
                                throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            showToast(data.message, acceptance ? 'success' : 'warning');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Failed to update placement status', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Full error details:', error);
                        let errorMessage = 'An error occurred while updating status';

                        // Try to extract more specific error message
                        if (error.message.includes('Failed to fetch')) {
                            errorMessage = 'Network error - could not reach server';
                        } else if (error.message) {
                            errorMessage = error.message;
                        }

                        showToast(errorMessage, 'error');
                    });
            }

            function rejectPlacement(placementId) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const endpoint = `/college/placement/${placementId}/reject`;

                console.log('Attempting to reject placement:', {
                    placementId,
                    endpoint,
                    csrfToken: csrfToken ? 'Exists' : 'Missing!'
                });

                fetch(endpoint, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            acceptance: false // explicitly sending false to indicate rejection
                        })
                    })
                    .then(response => {
                        console.log('Raw response:', response);

                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            showToast(data.message || 'Placement rejected successfully', 'warning');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Failed to reject placement', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Full error details:', error);
                        let errorMessage = 'An error occurred while rejecting placement';

                        if (error.message.includes('Failed to fetch')) {
                            errorMessage = 'Network error - could not reach server';
                        } else if (error.message) {
                            errorMessage = error.message;
                        }

                        showToast(errorMessage, 'error');
                    });
            }


            // Toast Notification Handler
            function showToast(message, type = 'info') {
                const toast = document.getElementById('toast');
                const toastMessage = document.getElementById('toast-message');
                const toastIcon = document.getElementById('toast-icon');

                toastMessage.textContent = message;

                switch (type) {
                    case 'success':
                        toastIcon.className =
                            'inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-500 bg-green-100 rounded-lg';
                        toastIcon.innerHTML =
                            '<svg class="w-5=5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                        break;
                    case 'error':
                        toastIcon.className =
                            'inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-red-500 bg-red-100 rounded-lg';
                        toastIcon.innerHTML =
                            '<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
                        break;
                    case 'warning':
                        toastIcon.className =
                            'inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-orange-500 bg-orange-100 rounded-lg';
                        toastIcon.innerHTML =
                            '<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>';
                        break;
                    case 'info':
                    default:
                        toastIcon.className =
                            'inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-blue-500 bg-blue-100 rounded-lg';
                        toastIcon.innerHTML =
                            '<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                }

                toast.classList.remove('hidden');
                toast.classList.add('flex');

                setTimeout(hideToast, 5000);
            }

            // Hide Toast Notification
            function hideToast() {
                const toast = document.getElementById('toast');
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }
        </script>
    @endsection
