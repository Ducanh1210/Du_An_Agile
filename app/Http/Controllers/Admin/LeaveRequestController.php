<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Booking;
use App\Notifications\BookingCancelledNotification;
use App\Notifications\LeaveRequestResolvedNotification;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $requests = LeaveRequest::with(['trainer.user', 'item', 'resolver'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(15);
        return view('admin.leave_requests.index', compact('requests'));
    }

    public function resolve(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'required_if:status,rejected|nullable|string',
        ]);

        $leaveReq = LeaveRequest::findOrFail($id);
        
        if ($leaveReq->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý!');
        }

        $leaveReq->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'resolved_by' => Auth::id()
        ]);

        if ($request->status === 'approved') {
             if ($leaveReq->item_type === 'App\Models\Booking') {
                 // Đánh dấu hủy ca PT
                 $leaveReq->item->update(['status' => 'cancelled']);
                 
                 // Gửi thông báo tới người tập
                 if ($leaveReq->item->user) {
                     $leaveReq->item->user->notify(new BookingCancelledNotification($leaveReq->item));
                 }
             } elseif ($leaveReq->item_type === 'App\Models\Schedule') {
                 // Logic để xử lý thay người dạy cho lớp hoặc xoá lịch lớp
             }
        }

        // Gửi thông báo cho HLV kết quả phê duyệt
        if ($leaveReq->trainer && $leaveReq->trainer->user) {
            $leaveReq->trainer->user->notify(new LeaveRequestResolvedNotification($leaveReq));
        }

        return back()->with('success', 'Đã xử lý yêu cầu xin nghỉ thành công!');
    }
}
