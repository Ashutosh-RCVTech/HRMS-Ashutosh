@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-800 dark:border-gray-700 rounded-lg shadow">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Exam Monitoring</h1>
                    <div class="flex items-center gap-4">
                        <input type="text" id="search"
                            class="px-4 py-2 border rounded-lg dark:bg-slate-700 dark:border-gray-600"
                            placeholder="Search candidates...">
                        <button id="refresh-btn"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Refresh
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <!-- Total Candidates -->
                    <div class="bg-white dark:bg-slate-700 p-4 rounded-lg shadow border dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">Total Candidates</p>
                                <h3 id="total-candidates" class="text-2xl font-bold">0</h3>
                            </div>
                            <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div class="bg-white dark:bg-slate-700 p-4 rounded-lg shadow border dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">In Progress</p>
                                <h3 id="in-progress" class="text-2xl font-bold">0</h3>
                            </div>
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div class="bg-white dark:bg-slate-700 p-4 rounded-lg shadow border dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">Completed</p>
                                <h3 id="completed" class="text-2xl font-bold">0</h3>
                            </div>
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Expired/Disqualified -->
                    <div class="bg-white dark:bg-slate-700 p-4 rounded-lg shadow border dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-300">Expired/Disqualified</p>
                                <h3 id="expired-disqualified" class="text-2xl font-bold">0</h3>
                            </div>
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Monitoring Table -->
                <div class="overflow-x-auto border rounded-lg dark:border-gray-600">
                    <table class="w-full border-collapse bg-white shadow-lg dark:bg-slate-800">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Candidate</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    IP Address</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Start Time</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Time Spent</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Score</th>
                            </tr>
                        </thead>
                        <tbody id="attempts-container"
                            class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-gray-700">
                            <!-- Data will be loaded here -->
                            <tr id="loading-row" class="hidden">
                                <td colspan="6" class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center">
                                        <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let currentPage = 1;
            let lastPage = 1;
            let isLoading = false;
            let searchTimeout;
            let pollInterval;

            const loadingElement = document.getElementById('loading-row');
            const container = document.getElementById('attempts-container');
            const refreshBtn = document.getElementById('refresh-btn');

            const throttle = (fn, delay) => {
                let lastCall = 0;
                return function(...args) {
                    const now = new Date().getTime();
                    if (now - lastCall < delay) return;
                    lastCall = now;
                    return fn(...args);
                }
            };

            const formatDateTime = (dateString) => {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            };

            const formatTimeSpent = (seconds) => {
                if (!seconds) return '-';
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                return `${hours}h ${minutes}m`;
            };

            const getStatusBadge = (status) => {
                const statusText = status.replace('_', ' ');
                const statusClasses = {
                    in_progress: 'bg-in-progress',
                    completed: 'bg-completed',
                    expired: 'bg-expired',
                    disqualified: 'bg-disqualified'
                };
                return `<span class="status-badge ${statusClasses[status]}">${statusText}</span>`;
            };

            const createAttemptRow = (attempt) => {
                const candidateUser = attempt.candidate?.candidate_user;
                return `
            <tr data-attempt-id="${attempt.id}" class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">

                        <img src="${candidateUser?.basic_detail?.profile_image_path || '{{ asset('images/avatar/profile.png') }}'}" 
                             class="candidate-avatar" 
                             alt="${candidateUser?.name}">
                        <div class="ml-3">
                            <div class="font-medium text-gray-900">${candidateUser?.name || 'N/A'}</div>
                            <div class="text-gray-500 text-sm">${attempt.candidate?.email}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">${getStatusBadge(attempt.status)}</td>
                <td class="px-6 py-4">${attempt.ip_address || '-'}</td>
                <td class="px-6 py-4">${attempt.created_at_human}</td>
             
                <td class="px-6 py-4">${formatTimeSpent(attempt.time_spent)}</td>
                <td class="px-6 py-4 font-semibold">${attempt.score || '-'}</td>
            </tr>
        `;
            };

            const loadAttempts = async (reset = false) => {
                console.log("sldsld");
                if (isLoading) return;
                isLoading = true;

                if (reset) {
                    currentPage = 1;
                    container.innerHTML = '';
                    loadingElement.classList.remove('hidden');
                }

                try {
                    const params = new URLSearchParams({
                        page: currentPage,
                        search: document.getElementById('search').value,
                        // status: document.getElementById('status-filter').value
                    });

                    const response = await fetch(`{{ route('admin.quiz.monitoring.attempts') }}?${params}`);
                    const data = await response.json();

                    if (reset) container.innerHTML = '';

                    data.attempts.forEach(attempt => {

                        console.log(attempt);


                        const existing = container.querySelector(
                            `tr[data-attempt-id="${attempt.id}"]`);
                        if (!existing) {
                            container.insertAdjacentHTML('beforeend', createAttemptRow(attempt));
                        }
                    });

                    lastPage = data.last_page;
                    currentPage++;
                    await updateStats();
                } catch (error) {
                    console.error('Error loading attempts:', error);
                } finally {
                    isLoading = false;
                    loadingElement.classList.add('hidden');
                }
            };

            const updateStats = async () => {
                try {
                    const response = await fetch('{{ route('admin.quiz.monitoring.stats') }}');
                    const stats = await response.json();

                    document.getElementById('total-candidates').textContent = stats.total;
                    document.getElementById('in-progress').textContent = stats.in_progress;
                    document.getElementById('completed').textContent = stats.completed;
                    document.getElementById('expired-disqualified').textContent =
                        parseInt(stats.expired) + parseInt(stats.disqualified);
                } catch (error) {
                    console.error('Error updating stats:', error);
                }
            };

            const manualRefresh = () => {
                currentPage = 1;
                lastPage = 1;
                loadAttempts(true);
            };

            const startPolling = () => {
                pollInterval = setInterval(() => {
                    if (!document.hidden) manualRefresh();
                }, 30000);
            };

            // Event Listeners
            document.getElementById('search').addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(manualRefresh, 500);
            });

            // document.getElementById('status-filter').addEventListener('change', manualRefresh());
            refreshBtn.addEventListener('click', manualRefresh());

            window.addEventListener('scroll', throttle(() => {
                const {
                    scrollTop,
                    scrollHeight,
                    clientHeight
                } = document.documentElement;
                if (scrollTop + clientHeight >= scrollHeight - 100 && currentPage <= lastPage) {
                    loadAttempts();
                }
            }, 200));

            // Initial Load
            manualRefresh();
            // startPolling();

            // document.addEventListener('visibilitychange', () => {
            //     if (document.hidden) {
            //         clearInterval(pollInterval);
            //     } else {
            //         startPolling();
            //     }
            // });
        });
    </script>

    <style>
        .candidate-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            display: inline-block;
        }

        .bg-in-progress {
            background-color: #fde047;
            color: #854d0e;
        }

        .bg-completed {
            background-color: #86efac;
            color: #166534;
        }

        .bg-expired {
            background-color: #fca5a5;
            color: #991b1b;
        }

        .bg-disqualified {
            background-color: #d1d5db;
            color: #374151;
        }
    </style>
@endsection
