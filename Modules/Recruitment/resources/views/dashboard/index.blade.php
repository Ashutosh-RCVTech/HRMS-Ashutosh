@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- Left Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            @include('recruitment::dashboard.partials.quick-stats')
            @include('recruitment::dashboard.partials.upcoming-deadlines')
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-8">
            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($metrics as $metric)
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-blue-500">
                    <h3 class="text-gray-500 text-sm font-medium">{{ $metric['title'] }}</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $metric['value'] }}</p>
                    @isset($metric['trend'])
                    <div class="mt-2 flex items-center text-sm {{ $metric['trend']['color'] }}">
                        {{ $metric['trend']['value'] }}
                        {{-- @if($metric['trend']['direction'] === 'up')
                        <x-icons.arrow-up class="w-4 h-4 ml-1" />
                        @else
                        <x-icons.arrow-down class="w-4 h-4 ml-1" />
                        @endif --}}
                    </div>
                    @endisset
                </div>
                @endforeach
            </div>

            <!-- Main Chart -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Job Openings Trend</h3>
                <div class="h-96">
                    <canvas id="jobOpeningsChart"></canvas>
                </div>
            </div>

            <!-- Additional Visualizations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Application Status Distribution</h3>
                    <div class="h-64">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Candidate Sources</h3>
                    <div class="h-64">
                        <canvas id="sourceDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Main Job Openings Chart
        new Chart(document.getElementById('jobOpeningsChart'), {
            type: 'line',
            data: {
                labels: @json(array_column($jobOpeningsData, 'label')),
                datasets: [{
                    label: 'Job Openings',
                    data: @json(array_column($jobOpeningsData, 'count')),
                    borderColor: '#3B82F6',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: createGradient('#3B82F620'),
                }]
            },
            options: chartOptions()
        });

        // Application Status Chart
        new Chart(document.getElementById('statusDistributionChart'), {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($applicationStatuses)),
                datasets: [{
                    data: @json(array_values($applicationStatuses)),
                    backgroundColor: ['#3B82F6', '#10B981', '#EF4444', '#F59E0B'],
                }]
            },
            options: {
                ...chartOptions(),
                cutout: '70%',
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });

        // Helper functions
        function createGradient(color) {
            const ctx = document.createElement('canvas').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, color);
            gradient.addColorStop(1, '#0000');
            return gradient;
        }

        function chartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#1F2937',
                        titleFont: { size: 14 },
                        bodyFont: { size: 14 },
                        padding: 12,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F3F4F6' },
                        ticks: { color: '#6B7280' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6B7280' }
                    }
                }
            };
        }

        // Resize observer for better responsive behavior
        new ResizeObserver(entries => {
            entries.forEach(entry => {
                const chartCanvas = entry.target.querySelector('canvas');
                if(chartCanvas && chartCanvas.chart) {
                    chartCanvas.chart.resize();
                }
            });
        }).observe(document.getElementById('jobOpeningsChart').parentElement);
    });
</script>
@endpush
@endsection
