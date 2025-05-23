<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\JobOpeningRepository;
use Modules\Recruitment\Repositories\JobApplicationRepository;
use Modules\Recruitment\Repositories\CandidateRepository;

class DashboardService
{
    protected $jobOpeningRepository;
    protected $jobApplicationRepository;
    protected $candidateRepository;

    public function __construct(
        JobOpeningRepository $jobOpeningRepository,
        JobApplicationRepository $jobApplicationRepository,
        CandidateRepository $candidateRepository
    ) {
        $this->jobOpeningRepository = $jobOpeningRepository;
        $this->jobApplicationRepository = $jobApplicationRepository;
        $this->candidateRepository = $candidateRepository;
    }

    // Constants for maintainability
    const STATUSES = ['Open', 'In Progress', 'Filled', 'On Hold', 'Closed'];
    const METRIC_GROWTH_DECIMALS = 1;
    const DEFAULT_PERCENTAGE = null;


    // Add to your DashboardService class
    public function getFilteredDashboardData($status = 'all')
    {
        // Get base dashboard data
        $data = $this->getDashboardData();

        // If not filtering, return all data
        if ($status === 'all') {
            return $data;
        }

        // Filter job openings by status
        $filteredJobs = $this->jobOpeningRepository->filterByStatus($status);

        // Update job counts and related metrics
        $data['total_jobs'] = $filteredJobs->count();

        // Filter applications related to the filtered jobs
        $jobIds = $filteredJobs->pluck('id')->toArray();
        $filteredApplications = $this->jobApplicationRepository->filterByJobIds($jobIds);
        $data['active_applications'] = $filteredApplications->where('status', '!=', 'withdrawn')->count();

        // Update job status distribution
        $data['jobData']['job_status_distribution'] = $this->jobOpeningRepository->getJobStatusDistribution($status);

        // Update monthly applications
        $data['jobData']['monthly_applications'] = $this->jobApplicationRepository->getMonthlyApplications($jobIds);

        return $data;
    }


    public function getDashboardData()
    {
        // Current metrics
        $total_jobs = $this->jobOpeningRepository->all()->count();
        $active_applications = $this->jobApplicationRepository->activeApplications()->count();
        $new_candidates = $this->candidateRepository->newCandidates()->count();
        $upcoming_deadlines = $this->jobOpeningRepository->upcomingDeadlines()->count();

        // Previous month metrics
        $prevTotal_jobs = $this->jobOpeningRepository->countLastMonth();
        $prevActive_applications = $this->jobApplicationRepository->countActiveLastMonth();
        $prevNew_candidates = $this->candidateRepository->countNewCandidatesLastMonth();
        $prevUpcoming_deadlines = $this->jobOpeningRepository->countUpcomingDeadlinesLastMonth();

        // Calculate growth metrics
        $metrics_growth = [
            'total_jobs' => $this->calculateGrowth($total_jobs, $prevTotal_jobs),
            'active_applications' => $this->calculateGrowth($active_applications, $prevActive_applications),
            'new_candidates' => $this->calculateGrowth($new_candidates, $prevNew_candidates),
            'upcoming_deadlines' => $this->calculateGrowth($upcoming_deadlines, $prevUpcoming_deadlines),
        ];


        // Ensure all job statuses are represented in distribution data
        $jobStatusDistribution = $this->jobOpeningRepository->getJobStatusDistribution();

        // Make sure all standard statuses exist, even if zero
        $allStatuses = ['Open', 'In Progress', 'Filled', 'On Hold', 'Closed'];
        foreach ($allStatuses as $status) {
            if (!isset($jobStatusDistribution[$status])) {
                $jobStatusDistribution[$status] = 0;
            }
        }
        return [
            'metrics' => [
                'total_jobs' => $total_jobs,
                'active_applications' => $active_applications,
                'new_candidates' => $new_candidates,
                'upcoming_deadlines' => $upcoming_deadlines,
            ],
            // Core metrics
            'total_jobs' => $total_jobs,
            'active_applications' => $active_applications,
            'new_candidates' => $new_candidates,
            'upcoming_deadlines' => $upcoming_deadlines,
            'metrics_growth' => $metrics_growth,

            // Data collections
            'upcomingDeadlines' => $this->jobOpeningRepository->getUpcomingDeadlinesList(5),
            'recentApplications' => $this->jobApplicationRepository->getRecentApplications(10),
            'jobData' => [
                'monthly_applications' => $this->jobApplicationRepository->getMonthlyApplications(),
                'job_status_distribution' => $jobStatusDistribution
            ],
            // Add time period information for clarity
            'currentPeriod' => date('F Y'),
            'previousPeriod' => date('F Y', strtotime('-1 month')),

            // Colors for UI
            'colors' => [
                'total_jobs' => 'blue',
                'active_applications' => 'green',
                'new_candidates' => 'primary',
                'upcoming_deadlines' => 'green'
            ]
        ];
    }

    /**
     * Calculate percentage growth between current and previous values
     */
    protected function calculateGrowth($current, $previous)
    {
        $absolute_change = $current - $previous;

        // Calculate percentage only when it makes mathematical sense
        if ($previous > 0) {
            $percentage_change = round(($absolute_change / $previous) * 100, 1);
        } else {
            $percentage_change = null; // Indicate that percentage isn't meaningful here
        }

        return [
            'absolute' => $absolute_change,
            'percentage' => $percentage_change
        ];
    }

    public function exportMetricData($metric)
    {
        $data = $this->getDashboardData();

        $allowedMetrics = ['total_jobs', 'active_applications', 'new_candidates', 'upcoming_deadlines'];
        if (!in_array($metric, $allowedMetrics)) {
            throw new \InvalidArgumentException('Invalid metric type');
        }

        $filename = "{$metric}_export_" . date('Ymd_His') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->stream(
            function () use ($metric, $data) {
                $file = fopen('php://output', 'w');

                // Header
                fputcsv($file, [str_replace('_', ' ', ucfirst($metric)) . ' Data Export']);

                // Metric data
                fputcsv($file, ['Current Value', 'Growth Absolute', 'Growth Percentage']);
                fputcsv($file, [
                    $data[$metric],
                    $data['metrics_growth'][$metric]['absolute'],
                    $data['metrics_growth'][$metric]['percentage'] ?? 'N/A'
                ]);

                // Related data
                fputcsv($file, []);
                fputcsv($file, ['Additional Metric Data']);
                foreach ($data['jobData'] as $key => $value) {
                    if (is_array($value)) {
                        fputcsv($file, [ucfirst(str_replace('_', ' ', $key))]);
                        foreach ($value as $k => $v) {
                            fputcsv($file, [$k, $v]);
                        }
                    }
                }

                fclose($file);
            },
            200,
            $headers
        );
    }


    public function getTrendData($timeframe = 'monthly')
    {
        $validTimeframes = ['daily', 'weekly', 'monthly'];

        if (!in_array($timeframe, $validTimeframes)) {
            throw new \InvalidArgumentException('Invalid timeframe specified');
        }

        return [
            'trend_data' => $this->jobApplicationRepository->getApplicationTrends($timeframe),
            'timeframe' => $timeframe,
            'labels' => $this->generateTrendLabels($timeframe)
        ];
    }

    private function generateTrendLabels($timeframe)
    {
        $now = now();

        return match ($timeframe) {
            'daily' => $this->generateDailyLabels($now),
            'weekly' => $this->generateWeeklyLabels($now),
            'monthly' => $this->generateMonthlyLabels($now),
        };
    }

    private function generateDailyLabels($now)
    {
        return collect(range(6, 0))->map(function ($days) use ($now) {
            return $now->copy()->subDays($days)->format('D M j');
        })->toArray();
    }

    private function generateWeeklyLabels($now)
    {
        return collect(range(3, 0))->map(function ($weeks) use ($now) {
            return 'Week ' . $now->copy()->subWeeks($weeks)->week;
        })->toArray();
    }

    private function generateMonthlyLabels($now)
    {
        return collect(range(11, 0))->map(function ($months) use ($now) {
            return $now->copy()->subMonths($months)->format('M Y');
        })->toArray();
    }
}
