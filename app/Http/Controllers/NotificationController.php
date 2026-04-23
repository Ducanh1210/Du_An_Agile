<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lấy danh sách 10 thông báo mới nhất
     */
    public function getRecent()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->take(10)->get()->map(function ($notif) {
            return [
                'id' => $notif->id,
                'type' => $notif->data['type'] ?? 'general',
                'title' => $notif->data['title'] ?? 'Thông báo mới',
                'message' => $notif->data['message'] ?? '',
                'read_at' => $notif->read_at,
                'created_at' => $notif->created_at->diffForHumans(),
                'link' => $this->getLink($notif->data['type'] ?? ''),
            ];
        });

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->unreadNotifications->count()
        ]);
    }

    /**
     * Đánh dấu một thông báo là đã đọc
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Đánh dấu tất cả là đã đọc
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    private function getLink($type)
    {
        return match($type) {
            'membership_expiring' => url('/goi-dang-ky'),
            'session_reminder', 'reschedule_request', 'session_report' => url('/lich-ca-nhan'),
            default => url('/ho-so'),
        };
    }
}
