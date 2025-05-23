<?php

namespace Modules\Recruitment\Policies;

use Modules\Recruitment\Models\Notification;
use Modules\Recruitment\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the notification.
     */
    public function view(User $user, Notification $notification): bool
    {
        return $user->id === $notification->user_id;
    }

    /**
     * Determine whether the user can mark the notification as read.
     */
    public function markAsRead(User $user, Notification $notification): bool
    {
        return $user->id === $notification->user_id;
    }

    /**
     * Determine whether the user can delete the notification.
     */
    public function delete(User $user, Notification $notification): bool
    {
        return $user->id === $notification->user_id;
    }

    /**
     * Determine whether the user can mark all notifications as read.
     */
    public function markAllAsRead(User $user): bool
    {
        return true; // Any authenticated user can mark their own notifications as read
    }

    /**
     * Determine whether the user can clear all notifications.
     */
    public function clearAll(User $user): bool
    {
        return true; // Any authenticated user can clear their own notifications
    }
} 