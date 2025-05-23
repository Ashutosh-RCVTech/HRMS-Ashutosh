<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Models\Notification;
use Modules\Recruitment\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * Create a new notification
     */
    public function create(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Create multiple notifications for multiple users
     */
    public function createForUsers(array $userIds, array $data): Collection
    {
        $notifications = collect();
        
        foreach ($userIds as $userId) {
            $notification = $this->create(array_merge($data, ['user_id' => $userId]));
            $notifications->push($notification);
        }

        return $notifications;
    }

    /**
     * Create a job application notification
     */
    public function createJobApplicationNotification(User $user, array $jobData): Notification
    {
        return $this->create([
            'user_id' => $user->id,
            'type' => Notification::TYPE_JOB_APPLICATION,
            'title' => 'New Job Application',
            'message' => "A new application has been received for {$jobData['title']}",
            'data' => $jobData,
            'action_url' => route('recruitment.job-applications.show', $jobData['id']),
            'priority' => Notification::PRIORITY_MEDIUM
        ]);
    }

    /**
     * Create an interview scheduled notification
     */
    public function createInterviewNotification(User $user, array $interviewData): Notification
    {
        return $this->create([
            'user_id' => $user->id,
            'type' => Notification::TYPE_INTERVIEW_SCHEDULED,
            'title' => 'Interview Scheduled',
            'message' => "An interview has been scheduled for {$interviewData['position']}",
            'data' => $interviewData,
            'action_url' => route('recruitment.interviews.show', $interviewData['id']),
            'priority' => Notification::PRIORITY_HIGH
        ]);
    }

    /**
     * Create an assessment assigned notification
     */
    public function createAssessmentNotification(User $user, array $assessmentData): Notification
    {
        return $this->create([
            'user_id' => $user->id,
            'type' => Notification::TYPE_ASSESSMENT_ASSIGNED,
            'title' => 'New Assessment Assigned',
            'message' => "A new assessment has been assigned to you: {$assessmentData['title']}",
            'data' => $assessmentData,
            'action_url' => route('recruitment.assessments.show', $assessmentData['id']),
            'priority' => Notification::PRIORITY_HIGH
        ]);
    }

    /**
     * Create an assessment result notification
     */
    public function createAssessmentResultNotification(User $user, array $resultData): Notification
    {
        return $this->create([
            'user_id' => $user->id,
            'type' => Notification::TYPE_ASSESSMENT_RESULT,
            'title' => 'Assessment Result Available',
            'message' => "Your assessment result for {$resultData['title']} is now available",
            'data' => $resultData,
            'action_url' => route('recruitment.assessments.results', $resultData['id']),
            'priority' => Notification::PRIORITY_MEDIUM
        ]);
    }

    /**
     * Create a placement update notification
     */
    public function createPlacementNotification(User $user, array $placementData): Notification
    {
        return $this->create([
            'user_id' => $user->id,
            'type' => Notification::TYPE_PLACEMENT_UPDATE,
            'title' => 'Placement Update',
            'message' => "There's an update regarding your placement: {$placementData['title']}",
            'data' => $placementData,
            'action_url' => route('recruitment.placements.show', $placementData['id']),
            'priority' => Notification::PRIORITY_HIGH
        ]);
    }

    /**
     * Create a system alert notification
     */
    public function createSystemAlertNotification(User $user, array $alertData): Notification
    {
        return $this->create([
            'user_id' => $user->id,
            'type' => Notification::TYPE_SYSTEM_ALERT,
            'title' => $alertData['title'],
            'message' => $alertData['message'],
            'data' => $alertData,
            'action_url' => $alertData['action_url'] ?? null,
            'priority' => $alertData['priority'] ?? Notification::PRIORITY_MEDIUM
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Notification $notification): void
    {
        $notification->markAsRead();
    }

    /**
     * Mark multiple notifications as read
     */
    public function markMultipleAsRead(array $notificationIds): void
    {
        Notification::whereIn('id', $notificationIds)->update(['read_at' => now()]);
    }

    /**
     * Get unread notifications for a user
     */
    public function getUnreadNotifications(User $user): Collection
    {
        return $user->notifications()
            ->unread()
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get all notifications for a user
     */
    public function getAllNotifications(User $user): Collection
    {
        return $user->notifications()
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Delete expired notifications
     */
    public function deleteExpiredNotifications(): void
    {
        Notification::expired()->delete();
    }
} 