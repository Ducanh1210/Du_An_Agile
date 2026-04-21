<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\LeaveRequest;

class LeaveRequestResolvedNotification extends Notification
{
    use Queueable;

    public $leaveRequest;

    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $statusStr = $this->leaveRequest->status === 'approved' ? 'ĐƯỢC DUYỆT' : 'BỊ TỪ CHỐI';
        $itemDate = $this->leaveRequest->item ? $this->leaveRequest->item->start_time->format('H:i d/m/Y') : 'Không rõ';
        $msg = "Đơn xin nghỉ ca dạy lúc {$itemDate} của bạn đã {$statusStr}.";
        if ($this->leaveRequest->status === 'rejected' && $this->leaveRequest->admin_note) {
             $msg .= " Lý do: " . $this->leaveRequest->admin_note;
        }

        return [
            'type' => 'leave_request_resolved',
            'title' => "Kết quả duyệt đơn xin nghỉ",
            'message' => $msg,
            'request_id' => $this->leaveRequest->id,
        ];
    }
}
