<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\JobOpeningRepository;

class CalendarService
{
    protected $jobOpeningRepository;

    public function __construct(JobOpeningRepository $jobOpeningRepository)
    {
        $this->jobOpeningRepository = $jobOpeningRepository;
    }

    public function getCalendarEvents($start, $end)
    {
        return $this->jobOpeningRepository->getDeadlinesBetween($start, $end)
            ->map(callback: function ($job) {
                return [
                    'title' => $job->title,
                    'start' => $job->application_deadline->format('Y-m-d'),
                    'end' => $job->application_deadline->format('Y-m-d'),
                    'extendedProps' => [
                        'client' => $job->client,
                        'progress' => $this->calculateProgress($job->application_deadline)
                    ]
                ];
            });
    }

    private function calculateProgress($deadline)
    {
        $progress = 100 - ($deadline->diffInDays(now()) / 30) * 100;
        return max(min($progress, 100), 0);
    }

    public function getJobDeadlineEvents()
    {
        $jobOpenings = $this->jobOpeningRepository->upcomingDeadlines();

        return $jobOpenings->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->title,
                'start' => $job->deadline_date,
                'client' => $job->department ?? 'N/A',
                'url' => route('admin.recruitment.jobs.show', $job->id),
                'backgroundColor' => $this->getStatusColor($job->status),
                'borderColor' => 'transparent',
                'progress' => $job->progress ?? 0
            ];
        });
    }

    private function getStatusColor($status)
    {
        $colors = [
            'Open' => '#3B82F6',
            'In Progress' => '#8B5CF6',
            'Filled' => '#10B981',
            'On Hold' => '#F59E0B',
            'Closed' => '#6B7280'
        ];

        return $colors[$status] ?? '#3B82F6';
    }
}
