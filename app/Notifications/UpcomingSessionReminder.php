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
        $trainerName = $this->booking->trainer->name ?? 'HLV';
        
        if ($this->booking->booking_type === 'pt_session') {
            $sessionName = "Buổi tập PT {$this->booking->target_area} với HLV {$trainerName}";
        } else {
            $className = $this->booking->schedule->title ?? 'Lớp học';
            $sessionName = "Lớp học {$className} với HLV {$trainerName}";
        }

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
        $trainerName = $this->booking->trainer->name ?? 'HLV';
        if ($this->booking->booking_type === 'pt_session') {
            $sessionDisplay = "PT {$this->booking->target_area} ({$trainerName})";
        } else {
            $className = $this->booking->schedule->title ?? 'Lớp học';
            $sessionDisplay = "Lớp {$className} ({$trainerName})";
        }

        return [
            'type' => 'session_reminder',
            'title' => 'Sắp tới giờ tập!',
            'message' => 'Ca tập "' . $sessionDisplay . '" sẽ bắt đầu lúc ' . $this->booking->start_time->format('H:i') . '. Đừng đến muộn nhé!',
            'booking_id' => $this->booking->id,
            'start_time' => $this->booking->start_time->toDateTimeString(),
        ];
    }
}
