<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpcomingSessionReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $startTime = $this->booking->start_time->format('H:i');
        $date = $this->booking->start_time->format('d/m/Y');
        $sessionName = $this->booking->booking_type === 'class' 
            ? 'Lớp học: ' . $this->booking->schedule->title 
            : 'Ca tập giải huấn: 1-on-1 với HLV ' . $this->booking->trainer->user->name;

        return (new MailMessage)
                    ->subject('Nhắc lịch tập: 30 phút nữa bắt đầu! - EXTRA FIT+')
                    ->greeting('Chào ' . $notifiable->name . '!')
                    ->line('Sẵn sàng chưa? Ca tập của bạn sẽ bắt đầu sau 30 phút nữa.')
                    ->line('**Nội dung:** ' . $sessionName)
                    ->line('**Thời gian:** ' . $startTime . ' ngày ' . $date)
                    ->action('Chỉ đường / Xem lịch', url('/lich-ca-nhan'))
                    ->line('Đừng quên mang theo nước và đồ tập nhé!')
                    ->line('Hẹn gặp bạn tại EXTRA FIT+!');
    }

    public function toArray($notifiable): array
    {
        $sessionName = $this->booking->booking_type === 'class' 
            ? $this->booking->schedule->title 
            : 'Ca tập với HLV ' . $this->booking->trainer->user->name;

        return [
            'type' => 'session_reminder',
            'title' => 'Sắp tới giờ tập!',
            'message' => 'Ca tập "' . $sessionName . '" sẽ bắt đầu lúc ' . $this->booking->start_time->format('H:i') . '. Đừng đến muộn nhé!',
            'booking_id' => $this->booking->id,
            'start_time' => $this->booking->start_time->toDateTimeString(),
        ];
    }
}
