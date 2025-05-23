@extends('layouts.admin')

@section('content')
    <main class="w-full px-6 pb-6 pt-24 dark:bg-slate-900 dark:text-white">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Recruitment Dashboard</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track your recruitment pipeline and metrics
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center gap-2">
                    <select id="statusFilter"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-900 dark:text-white dark:border-gray-700 text-sm mr-2">
                        <option value="all">All Statuses</option>
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="filled">Filled</option>
                        <option value="on_hold">On Hold</option>
                        <option value="closed">Closed</option>
                    </select>

                    <button id="refreshBtn"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh Data
                    </button>
                </div>
            </div>
            {{-- <div id="chartData" data-monthly-applications="{{ json_encode($monthlyApplications) }}"
                data-job-status="{{ json_encode($jobStatusDistribution) }}" style="display: none;">
            </div> --}}
            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach (['total_jobs', 'active_applications', 'new_candidates', 'upcoming_deadlines'] as $metric)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 transition-colors hover:bg-gray-50 dark:hover:bg-slate-700 cursor-pointer metric-card"
                        data-metric="{{ $metric }}">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    {{ ucwords(str_replace('_', ' ', $metric)) }}
                                    <span class="ml-1 text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full">Current
                                        Month</span>
                                </p>
                                <h3 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white"
                                    id="metric-{{ $metric }}">
                                    {{ number_format($$metric) }}
                                </h3>
                                @if (isset($metrics_growth[$metric]))
                                    <p id="growth-{{ $metric }}"
                                        class="mt-1 text-sm {{ $metrics_growth[$metric]['absolute'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                        <span class="inline-flex items-center">
                                            @if ($metrics_growth[$metric]['absolute'] >= 0)
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                            @if ($metrics_growth[$metric]['percentage'] !== null)
                                                {{ $metrics_growth[$metric]['percentage'] >= 0 ? '+' : '' }}{{ $metrics_growth[$metric]['percentage'] }}%
                                            @else
                                                {{ $metrics_growth[$metric]['absolute'] >= 0 ? '+' : '' }}{{ $metrics_growth[$metric]['absolute'] }}
                                            @endif
                                            <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">vs. prev
                                                month</span>
                                        </span>
                                    </p>
                                @endif
                            </div>
                            <div class="p-3 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg">
                                @if ($metric === 'total_jobs')
                                    <!-- Briefcase Icon -->
                                    <svg class="w-6 h-6 text-indigo-500 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                @elseif($metric === 'active_applications')
                                    <!-- Document Text Icon -->
                                    <svg class="w-6 h-6 text-indigo-500 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                @elseif($metric === 'new_candidates')
                                    <!-- User Group Icon -->
                                    <svg class="w-6 h-6 text-indigo-500 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                @elseif($metric === 'upcoming_deadlines')
                                    <!-- Calendar Icon -->
                                    <svg class="w-6 h-6 text-indigo-500 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Application Trends</h3>
                        <select id="trendTimeframe"
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-900 dark:text-white dark:border-gray-700 text-sm">
                            <option value="monthly">Monthly</option>
                            <option value="weekly">Weekly</option>
                            <option value="daily">Daily</option>
                        </select>
                    </div>
                    <div class="chart-container" style="height: 400px">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Job Status Distribution</h3>
                        <button id="toggleChartBtn"
                            class="text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                            Toggle Chart Type
                        </button>
                    </div>
                    <div class="chart-container" style="height: 400px">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Data Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Applications -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Applications</h3>
                            <a href="#"
                                class="text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">View All</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Candidate</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Position</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Applied</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($recentApplications as $application)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center dark:bg-gray-600">
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                        {{ substr($application->candidate->name, 0, 2) }}
                                                    </span>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        {{ $application->candidate->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $application->job->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $application->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 text-xs font-medium rounded-full 
                                                    {{ [
                                                        'hired' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                        'withdrawn' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                                    ][$application->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' }}">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recruitment Calendar -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recruitment Calendar</h3>
                        <div class="flex items-center gap-4">
                            <button id="prevBtn" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button id="nextBtn" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="calendar" class="dark:text-white"></div>
                </div>
            </div>
        </div>

        <!-- Modal for metric details -->
        <div id="metricModalContainer"></div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize variable to store calendar instance
            let calendar;

            // Initialize charts
            initializeCharts();

            // Set up event listeners
            document.getElementById('statusFilter').addEventListener('change', function() {
                filterDashboardByStatus(this.value);
            });

            document.getElementById('refreshBtn').addEventListener('click', refreshDashboard);

            document.getElementById('trendTimeframe').addEventListener('change', updateTrendChart);

            document.getElementById('toggleChartBtn').addEventListener('click', toggleChartType);

            // Setup metric cards click handlers
            document.querySelectorAll('.metric-card').forEach(card => {
                card.addEventListener('click', function() {
                    const metric = this.getAttribute('data-metric');
                    showMetricDetails(metric);
                });
            });

            // Set up calendar navigation buttons
            if (document.getElementById('prevBtn')) {
                document.getElementById('prevBtn').addEventListener('click', () => {
                    if (calendar) calendar.prev();
                });
            }

            if (document.getElementById('nextBtn')) {
                document.getElementById('nextBtn').addEventListener('click', () => {
                    if (calendar) calendar.next();
                });
            }

            // Initialize the calendar if FullCalendar is available
            if (typeof FullCalendar !== 'undefined') {
                initializeCalendar();
            } else {
                console.warn('FullCalendar not loaded. Calendar functionality unavailable.');
            }

            // Set up dark mode detection
            setupDarkModeDetection();
        });

        let applicationsChart, statusChart;
        let currentChartType = 'bar';

        function filterDashboardByStatus(status) {
            // Show loading state
            const button = document.getElementById('refreshBtn');
            const originalContent = button.innerHTML;
            button.innerHTML = `
                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Filtering...
            `;

            // Make an AJAX request to filter the dashboard data
            fetch(`/admin/dashboard/filter?status=${status}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update metrics
                    updateDashboardMetrics(data);

                    // Update charts
                    updateChartsWithFilteredData(data);

                    // Reset button state
                    button.innerHTML = originalContent;

                    // Show toast notification
                    showToast(`Dashboard filtered by ${status === 'all' ? 'All Statuses' : status}`);
                })
                .catch(error => {
                    console.error('Error filtering dashboard:', error);
                    button.innerHTML = originalContent;
                    showToast('Error filtering dashboard', 'error');
                });
        }

        function updateDashboardMetrics(data) {
            // Update main metrics
            if (data.total_jobs !== undefined) {
                document.getElementById('metric-total_jobs').textContent = data.total_jobs;
            }

            if (data.active_applications !== undefined) {
                document.getElementById('metric-active_applications').textContent = data.active_applications;
            }

            if (data.new_candidates !== undefined) {
                document.getElementById('metric-new_candidates').textContent = data.new_candidates;
            }

            if (data.upcoming_deadlines !== undefined) {
                document.getElementById('metric-upcoming_deadlines').textContent = data.upcoming_deadlines;
            }

            // Update growth indicators
            if (data.metrics_growth && data.metrics_growth.total_jobs) {
                updateGrowthIndicator('total_jobs', data.metrics_growth.total_jobs);
            }

            if (data.metrics_growth && data.metrics_growth.active_applications) {
                updateGrowthIndicator('active_applications', data.metrics_growth.active_applications);
            }

            if (data.metrics_growth && data.metrics_growth.new_candidates) {
                updateGrowthIndicator('new_candidates', data.metrics_growth.new_candidates);
            }

            if (data.metrics_growth && data.metrics_growth.upcoming_deadlines) {
                updateGrowthIndicator('upcoming_deadlines', data.metrics_growth.upcoming_deadlines);
            }
        }

        function updateGrowthIndicator(metric, growth) {
            const element = document.getElementById(`growth-${metric}`);
            if (!element) return;

            // Update text content
            const valueText = growth.percentage !== null ?
                `${growth.percentage >= 0 ? '+' : ''}${growth.percentage}%` :
                `${growth.absolute >= 0 ? '+' : ''}${growth.absolute}`;

            // Update class based on positive/negative
            element.className = `mt-1 text-sm ${growth.absolute >= 0 ? 'text-green-500' : 'text-red-500'}`;

            // Update inner HTML with appropriate icon and text
            element.innerHTML = `
                <span class="inline-flex items-center">
                    ${growth.absolute >= 0 ? 
                        `<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                </svg>` : 
                        `<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>`
                    }
                    ${valueText}
                    <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">vs. prev month</span>
                </span>
            `;
        }

        function updateChartsWithFilteredData(data) {
            if (!data.jobData) return;

            // Update application trends chart
            if (applicationsChart && data.jobData.monthly_applications) {
                applicationsChart.data.datasets[0].data = Object.values(data.jobData.monthly_applications);
                applicationsChart.update();
            }

            // Update status chart
            if (statusChart && data.jobData.job_status_distribution) {
                statusChart.data.labels = Object.keys(data.jobData.job_status_distribution);
                statusChart.data.datasets[0].data = Object.values(data.jobData.job_status_distribution);
                statusChart.update();
            }

            // Update calendar if needed
            if (typeof calendar !== 'undefined' && calendar) {
                calendar.refetchEvents();
            }
        }

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            calendarEl.style.height = '300px'; // Reduce height
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: false,
                events: {
                    url: '/admin/calendar/events',
                    method: 'GET',
                    failure: function() {
                        showToast('Error loading calendar events', 'error');
                    }
                },
                eventDidMount: function(info) {
                    // Add progress bar to events
                    const progress = info.event.extendedProps.progress || 0;
                    const progressBar = document.createElement('div');
                    progressBar.className = 'absolute bottom-0 left-0 right-0 h-1 bg-gray-200';
                    const progressFill = document.createElement('div');
                    progressFill.className = 'h-full bg-indigo-600';
                    progressFill.style.width = progress + '%';
                    progressBar.appendChild(progressFill);
                    info.el.querySelector('.fc-event-main').appendChild(progressBar);

                    // Add tooltips if tippy is available
                    if (typeof tippy === 'function') {
                        tippy(info.el, {
                            content: info.event.title + " - " + (info.event.extendedProps.client || ''),
                            placement: 'top',
                            arrow: true
                        });
                    }
                },
                dayMaxEvents: 2, // Limit visible events per day
                moreLinkClick: 'popover', // Show popover with all events when clicking "more"
                moreLinkContent: function(arg) {
                    return '+' + arg.num + ' more'; // Custom text for the "more" link
                },
                eventContent: function(arg) {
                    return {
                        html: `
                            <div class="fc-event-main-frame">
                                <div class="fc-event-title-container">
                                    <div class="fc-event-title">${arg.event.title}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-300">
                                        ${arg.event.extendedProps.client || ''}
                                    </div>
                                </div>
                                <div class="fc-event-time">${arg.timeText}</div>
                            </div>
                        `
                    };
                },
                themeSystem: 'bootstrap5',
                eventClassNames: 'dark:bg-gray-700 dark:border-gray-600'
            });

            calendar.render();
        }

        function initializeCharts() {
            // Check if Chart is available
            if (typeof Chart === 'undefined') {
                console.warn('Chart.js not loaded. Chart functionality unavailable.');
                return;
            }

            // Application Trends Chart
            const appsCtx = document.getElementById('applicationsChart');
            if (!appsCtx) return;

            const appsCtxContext = appsCtx.getContext('2d');
            if (!appsCtxContext) return;

            // Get the data from the server or use default values
            let monthlyApplicationsData;
            try {
                monthlyApplicationsData = JSON.parse(document.querySelector('[data-monthly-applications]')?.getAttribute(
                    'data-monthly-applications') || '{}');
            } catch (e) {
                monthlyApplicationsData = {
                    "Jan": 45,
                    "Feb": 52,
                    "Mar": 48,
                    "Apr": 60,
                    "May": 55,
                    "Jun": 65,
                    "Jul": 60,
                    "Aug": 58,
                    "Sep": 70,
                    "Oct": 68,
                    "Nov": 75,
                    "Dec": 73
                };
            }

            applicationsChart = new Chart(appsCtxContext, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Applications',
                        data: Object.values(monthlyApplicationsData),
                        borderColor: 'rgb(79, 70, 229)',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'rgb(79, 70, 229)',
                        pointRadius: 4,
                        pointHoverRadius: 6
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
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(17, 24, 39, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: 'rgba(79, 70, 229, 0.2)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(156, 163, 175, 0.1)'
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

            // Job Status Distribution Chart
            const statusCtx = document.getElementById('statusChart');
            if (!statusCtx) return;

            const statusCtxContext = statusCtx.getContext('2d');
            if (!statusCtxContext) return;

            // Get the data from the server or use default values
            let jobStatusData;
            try {
                jobStatusData = JSON.parse(document.querySelector('[data-job-status]')?.getAttribute(
                    'data-job-status') || '{}');
            } catch (e) {
                jobStatusData = {
                    "Open": 25,
                    "In Progress": 35,
                    "On Hold": 15,
                    "Filled": 20,
                    "Closed": 5
                };
            }

            statusChart = new Chart(statusCtxContext, {
                type: 'bar',
                data: {
                    labels: Object.keys(jobStatusData),
                    datasets: [{
                        label: 'Jobs',
                        data: Object.values(jobStatusData),
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.7)', // Open
                            'rgba(79, 70, 229, 0.7)', // In Progress
                            'rgba(245, 158, 11, 0.7)', // On Hold
                            'rgba(59, 130, 246, 0.7)', // Filled
                            'rgba(107, 114, 128, 0.7)' // Closed
                        ],
                        borderColor: [
                            'rgb(16, 185, 129)',
                            'rgb(79, 70, 229)',
                            'rgb(245, 158, 11)',
                            'rgb(59, 130, 246)',
                            'rgb(107, 114, 128)'
                        ],
                        borderWidth: 1
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
                            backgroundColor: 'rgba(17, 24, 39, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw + ' jobs';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(156, 163, 175, 0.1)'
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
        }

        function updateTrendChart() {
            const timeframe = document.getElementById('trendTimeframe').value;

            // Show loading state
            const chartContainer = document.querySelector('#applicationsChart').parentNode;
            chartContainer.classList.add('opacity-50');

            // Make AJAX request to get new data
            fetch(`/admin/dashboard/trends?timeframe=${timeframe}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!applicationsChart) return;

                    // Update chart labels and data
                    applicationsChart.data.labels = Object.keys(data.trend_data);
                    applicationsChart.data.datasets[0].data = Object.values(data.trend_data);

                    // Update chart
                    applicationsChart.update();

                    // Remove loading state
                    chartContainer.classList.remove('opacity-50');
                })
                .catch(error => {
                    console.error('Error updating trend chart:', error);
                    chartContainer.classList.remove('opacity-50');
                    showToast('Error updating chart', 'error');
                });
        }

        function toggleChartType() {
            if (!statusChart) return;

            // Toggle chart type between bar and pie
            currentChartType = currentChartType === 'bar' ? 'pie' : 'bar';

            // Get current data
            const currentData = statusChart.data;

            // Destroy current chart
            statusChart.destroy();

            // Get context
            const statusCtx = document.getElementById('statusChart');
            if (!statusCtx) return;

            const statusCtxContext = statusCtx.getContext('2d');
            if (!statusCtxContext) return;

            // Create new chart with the same data but different type
            statusChart = new Chart(statusCtxContext, {
                type: currentChartType,
                data: currentData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: currentChartType === 'pie',
                            position: 'right'
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff'
                        }
                    },
                    scales: currentChartType === 'bar' ? {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(156, 163, 175, 0.1)'
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
                    } : undefined
                }
            });
        }

        function refreshDashboard() {
            // Show loading state
            const button = document.getElementById('refreshBtn');
            const originalContent = button.innerHTML;
            button.innerHTML = `
                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Refreshing...
            `;

            // Make AJAX request to refresh dashboard
            fetch('/admin/dashboard/refresh', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update metrics
                    updateDashboardMetrics(data);

                    // Update charts
                    updateChartsWithFilteredData(data);

                    // Refresh calendar if available
                    if (typeof calendar !== 'undefined' && calendar) {
                        calendar.refetchEvents();
                    }

                    // Reset button state
                    button.innerHTML = originalContent;

                    // Show toast notification
                    showToast('Dashboard refreshed successfully');
                })
                .catch(error => {
                    console.error('Error refreshing dashboard:', error);
                    button.innerHTML = originalContent;
                    showToast('Error refreshing dashboard', 'error');
                });
        }

        function showMetricDetails(metric) {
            // Mock metric details data
            const metricDetails = {
                total_jobs: {
                    title: 'Job Openings Details',
                    chart: {
                        type: 'bar',
                        data: {
                            labels: ['Engineering', 'Marketing', 'Sales', 'HR', 'Finance', 'IT', 'Operations'],
                            values: [12, 8, 15, 5, 3, 7, 4]
                        }
                    },
                    stats: [{
                            label: 'Avg. Time to Fill',
                            value: '24 days'
                        },
                        {
                            label: 'Cost per Hire',
                            value: '$3,250'
                        },
                        {
                            label: 'Offer Acceptance Rate',
                            value: '87%'
                        },
                        {
                            label: 'Top Hiring Manager',
                            value: 'Sarah Johnson'
                        }
                    ]
                },
                active_applications: {
                    title: 'Active Applications Details',
                    chart: {
                        type: 'doughnut',
                        data: {
                            labels: ['New', 'Screening', 'Interview', 'Assessment', 'Offer'],
                            values: [25, 35, 20, 15, 5]
                        }
                    },
                    stats: [{
                            label: 'Avg. Time in Stage',
                            value: '5.2 days'
                        },
                        {
                            label: 'Conversion Rate',
                            value: '32%'
                        },
                        {
                            label: 'Most Common Stage',
                            value: 'Screening'
                        },
                        {
                            label: 'Oldest Application',
                            value: '45 days'
                        }
                    ]
                },
                new_candidates: {
                    title: 'New Candidates Details',
                    chart: {
                        type: 'line',
                        data: {
                            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                            values: [12, 19, 15, 22, 18, 8, 5]
                        }
                    },
                    stats: [{
                            label: 'Source Quality',
                            value: '76%'
                        },
                        {
                            label: 'Top Source',
                            value: 'LinkedIn'
                        },
                        {
                            label: 'Average Experience',
                            value: '5.3 years'
                        },
                        {
                            label: 'Gender Ratio',
                            value: '58% M / 42% F'
                        }
                    ]
                },
                upcoming_deadlines: {
                    title: 'Upcoming Deadlines Details',
                    chart: {
                        type: 'bar',
                        data: {
                            labels: ['This Week', 'Next Week', 'In 2 Weeks', 'In 3 Weeks', 'In 4+ Weeks'],
                            values: [8, 12, 6, 3, 1]
                        }
                    },
                    stats: [{
                            label: 'Risk Level',
                            value: 'Medium'
                        },
                        {
                            label: 'Past Due',
                            value: '3'
                        },
                        {
                            label: 'Urgent Positions',
                            value: '5'
                        },
                        {
                            label: 'Avg. Days to Deadline',
                            value: '13.5'
                        }
                    ]
                }
            };

            const details = metricDetails[metric];
            if (!details) return;

            // Create modal HTML
            const modalHtml = `
                <div id="metricModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center p-4 transition-opacity">
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-auto transform transition-all">
                        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">${details.title}</h3>
                            <button id="closeMetricModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="mb-6">
                                        <canvas id="metricDetailChart" height="300"></canvas>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Key Statistics</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        ${details.stats.map(stat => `
                                                                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                                                                        <p class="text-sm text-gray-500 dark:text-gray-400">${stat.label}</p>
                                                                        <p class="text-xl font-bold text-gray-900 dark:text-white">${stat.value}</p>
                                                                    </div>
                                                                `).join('')}
                                    </div>
                                    <div class="mt-6">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recommendations</h4>
                                        <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                                            <li class="flex items-start">
                                                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>Consider optimizing your ${metric.replace('_', ' ')} process to improve efficiency.</span>
                                            </li>
                                            <li class="flex items-start">
                                                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>Review your ${metric.replace('_', ' ')} data weekly to identify trends.</span>
                                            </li>
                                            <li class="flex items-start">
                                                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>Set up automated alerts for critical changes in ${metric.replace('_', ' ')}.</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-slate-700 px-6 py-4 flex justify-end">
                            <button id="closeMetricModalBtn" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none mr-2">
                                Close
                            </button>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none">
                                Export Data
                            </button>
                        </div>
                    </div>
                </div>
            `;

            // Add modal to the page
            const modalContainer = document.getElementById('metricModalContainer');
            modalContainer.innerHTML = modalHtml;

            // Show modal
            setTimeout(() => {
                document.getElementById('metricModal').classList.add('opacity-100');
            }, 10);

            // Initialize chart
            const ctx = document.getElementById('metricDetailChart').getContext('2d');
            new Chart(ctx, {
                type: details.chart.type,
                data: {
                    labels: details.chart.data.labels,
                    datasets: [{
                        label: details.title,
                        data: details.chart.data.values,
                        backgroundColor: [
                            'rgba(79, 70, 229, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(239, 68, 68, 0.7)',
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(107, 114, 128, 0.7)',
                            'rgba(168, 85, 247, 0.7)'
                        ],
                        borderColor: details.chart.type === 'line' ? 'rgb(79, 70, 229)' : [
                            'rgb(79, 70, 229)',
                            'rgb(16, 185, 129)',
                            'rgb(245, 158, 11)',
                            'rgb(239, 68, 68)',
                            'rgb(59, 130, 246)',
                            'rgb(107, 114, 128)',
                            'rgb(168, 85, 247)'
                        ],
                        borderWidth: 1,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: details.chart.type === 'doughnut'
                        }
                    }
                }
            });

            // Set up event listeners for closing the modal
            document.getElementById('closeMetricModal').addEventListener('click', closeMetricModal);
            document.getElementById('closeMetricModalBtn').addEventListener('click', closeMetricModal);
            document.getElementById('metricModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeMetricModal();
                }
            });
        }

        function closeMetricModal() {
            const modal = document.getElementById('metricModal');
            if (!modal) return;

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');

            setTimeout(() => {
                const container = document.getElementById('metricModalContainer');
                if (container) {
                    container.innerHTML = '';
                }
            }, 300);
        }

        function showToast(message, type = 'success') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 transition-transform transform translate-y-0 ${
                type === 'success' ? 'bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                'bg-red-50 text-red-800 dark:bg-red-900/30 dark:text-red-400'
            }`;

            // Add icon based on type
            const icon = type === 'success' ?
                `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>` :
                `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;

            // Set toast content
            toast.innerHTML = `
                ${icon}
                <span>${message}</span>
                <button class="ml-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            // Add to document
            document.body.appendChild(toast);

            // Set up close button
            toast.querySelector('button').addEventListener('click', function() {
                toast.classList.add('translate-y-full', 'opacity-0');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            });

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    toast.classList.add('translate-y-full', 'opacity-0');
                    setTimeout(() => {
                        if (document.body.contains(toast)) {
                            document.body.removeChild(toast);
                        }
                    }, 300);
                }
            }, 3000);
        }

        function setupDarkModeDetection() {
            // Update chart theme when dark mode changes
            const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            const updateChartTheme = (isDarkMode) => {
                Chart.defaults.color = isDarkMode ? '#D1D5DB' : '#6B7280';
                Chart.defaults.borderColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

                // Update existing charts
                if (applicationsChart) {
                    applicationsChart.options.scales.y.grid.color = isDarkMode ? 'rgba(255, 255, 255, 0.1)' :
                        'rgba(0, 0, 0, 0.1)';
                    applicationsChart.update();
                }

                if (statusChart) {
                    if (statusChart.options.scales && statusChart.options.scales.y) {
                        statusChart.options.scales.y.grid.color = isDarkMode ? 'rgba(255, 255, 255, 0.1)' :
                            'rgba(0, 0, 0, 0.1)';
                    }
                    statusChart.update();
                }
            };

            // Initial setup
            updateChartTheme(darkModeMediaQuery.matches);

            // Listen for changes
            darkModeMediaQuery.addEventListener('change', (e) => {
                updateChartTheme(e.matches);
            });

            // Also check for a dark class on the HTML element (for Tailwind Dark Mode toggle)
            const observer = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    if (mutation.attributeName === 'class') {
                        const isDarkMode = document.documentElement.classList.contains('dark');
                        updateChartTheme(isDarkMode);
                    }
                }
            });

            observer.observe(document.documentElement, {
                attributes: true
            });
        }
    </script>
@endsection
