<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Recruitment\Entities\Notification;
use Modules\Recruitment\Policies\NotificationPolicy;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        return response()->json($notifications);
    }

    /**
     * Get unread notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function unread()
    {
        $notifications = auth()->user()->unreadNotifications()->latest()->paginate(10);
        return response()->json($notifications);
    }

    /**
     * Mark a notification as read.
     *
     * @param  \Modules\Recruitment\Entities\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Notification $notification)
    {
        $this->authorize('markAsRead', $notification);
        
        $notification->markAsRead();
        return response()->json(['message' => 'Notification marked as read']);
    }

    /**
     * Mark multiple notifications as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markMultipleAsRead(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        $notifications = Notification::whereIn('id', $request->notification_ids)->get();
        
        foreach ($notifications as $notification) {
            $this->authorize('markAsRead', $notification);
            $notification->markAsRead();
        }

        return response()->json(['message' => 'Notifications marked as read']);
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'All notifications marked as read']);
    }

    /**
     * Remove the specified notification.
     *
     * @param  \Modules\Recruitment\Entities\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);
        
        $notification->delete();
        return response()->json(['message' => 'Notification deleted successfully']);
    }

    /**
     * Remove multiple notifications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id'
        ]);

        $notifications = Notification::whereIn('id', $request->notification_ids)->get();
        
        foreach ($notifications as $notification) {
            $this->authorize('delete', $notification);
            $notification->delete();
        }

        return response()->json(['message' => 'Notifications deleted successfully']);
    }

    /**
     * Clear all notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        return response()->json(['message' => 'All notifications cleared']);
    }
} 