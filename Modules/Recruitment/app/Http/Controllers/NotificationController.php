<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Models\Notification;
use Modules\Recruitment\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get all notifications for the authenticated user
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationService->getAllNotifications(Auth::user());
        
        if ($request->wantsJson()) {
            return response()->json([
                'notifications' => $notifications,
                'unread_count' => $notifications->whereNull('read_at')->count()
            ]);
        }

        return view('recruitment::notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications for the authenticated user
     */
    public function unread(Request $request)
    {
        $notifications = $this->notificationService->getUnreadNotifications(Auth::user());
        
        if ($request->wantsJson()) {
            return response()->json([
                'notifications' => $notifications,
                'count' => $notifications->count()
            ]);
        }

        return view('recruitment::notifications.unread', compact('notifications'));
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Notification $notification)
    {
        $this->authorize('markAsRead', $notification);
        
        $this->notificationService->markAsRead($notification);
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark multiple notifications as read
     */
    public function markMultipleAsRead(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        $this->notificationService->markMultipleAsRead($request->notification_ids);
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read for the authenticated user
     */
    public function markAllAsRead()
    {
        $notificationIds = Auth::user()->notifications()
            ->unread()
            ->pluck('id')
            ->toArray();

        $this->notificationService->markMultipleAsRead($notificationIds);
        
        return response()->json(['success' => true]);
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);
        
        $notification->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Delete multiple notifications
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        Notification::whereIn('id', $request->notification_ids)
            ->where('user_id', Auth::id())
            ->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Clear all notifications for the authenticated user
     */
    public function clearAll()
    {
        Auth::user()->notifications()->delete();
        
        return response()->json(['success' => true]);
    }
} 