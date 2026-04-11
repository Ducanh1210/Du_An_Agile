<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RescheduleRequestNotification extends Notification
{
    use Queueable;

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Yêu cầu đổi lịch tập - EXTRA FIT+')
                    ->greeting('Chào ' . $notifiable->name . '!')
                    ->line('Huấn luyện viên của bạn vừa gửi yêu cầu thay đổi thời gian buổi tập.')
                    ->line('**Thời gian cũ:** ' . $this->request->original_start_time->format('H:i d/m/Y'))
                    ->line('**Thời gian mới:** ' . $this->request->new_start_time->format('H:i d/m/Y'))
                    ->line('**Lý do:** ' . $this->request->reason)
                    ->action('Xem và Phê duyệt', url('/lich-ca-nhan'))
                    ->line('Nếu bạn không đồng ý, buổi tập vẫn sẽ giữ nguyên thời gian cũ.');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'reschedule_request',
            'title' => 'Yêu cầu đổi lịch tập',
            'message' => 'PT yêu cầu đổi lịch buổi tập sang ' . $this->request->new_start_time->format('H:i d/m/Y'),
            'request_id' => $this->request->id,
        ];
    }
}
