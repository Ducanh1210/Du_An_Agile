<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\LeaveRequest;

class LeaveRequestCreatedNotification extends Notification
{
    use Queueable;

    public $leaveRequest;

    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function via($notifiable): array
    {
        return ['database']; // Gửi qua database channel để hiện trên biểu tượng chuông Admin
    }

    public function toArray($notifiable): array
    {
        $trainerName = $this->leaveRequest->trainer->user->name ?? 'HLV';
        $itemDate = $this->leaveRequest->item ? $this->leaveRequest->item->start_time->format('H:i d/m/Y') : 'Không rõ';
        return [
            'type' => 'leave_request_created',
            'title' => 'Đơn xin nghỉ dạy mới',
            'message' => "HLV {$trainerName} vừa nộp đơn xin nghỉ ca dạy lúc {$itemDate}.",
            'request_id' => $this->leaveRequest->id,
        ];
    }
}
