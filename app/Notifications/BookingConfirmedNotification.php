<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification implements ShouldQueue
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
        $date = $this->booking->start_time->format('H:i d/m/Y');
        $trainerName = $this->booking->trainer->name ?? 'N/A';
        
        if ($this->booking->booking_type === 'pt_session') {
            $type = "Personal Training ({$this->booking->target_area})";
            $detail = "Buổi tập PT chuyên sâu về **{$this->booking->target_area}** với HLV **{$trainerName}**.";
        } else {
            $className = $this->booking->schedule->title ?? 'Lớp học';
            $type = "Lớp học: {$className}";
            $detail = "Buổi tập lớp **{$className}** với HLV **{$trainerName}**.";
        }
        
        return (new MailMessage)
                    ->subject("Xác nhận: {$type} - EXTRA FIT+")
                    ->greeting('Chào ' . $notifiable->name . '!')
                    ->line("Chúc mừng! Lịch tập của bạn đã được xác nhận thành công.")
                    ->line("**Chi tiết buổi tập:**")
                    ->line("- Nội dung: {$detail}")
                    ->line("- Thời gian: {$date}")
                    ->action('Xem lịch tập cá nhân', url('/lich-ca-nhan'))
                    ->line('Đừng quên mang theo nước và đồ tập. Hẹn gặp bạn!');
    }

    public function toArray($notifiable): array
    {
        if ($this->booking->booking_type === 'pt_session') {
            $title = "Đặt lịch PT thành công";
            $message = "Buổi tập {$this->booking->target_area} lúc " . $this->booking->start_time->format('H:i d/m') . " đã sẵn sàng.";
        } else {
            $className = $this->booking->schedule->title ?? 'Lớp học';
            $title = "Đặt lịch lớp thành công";
            $message = "Lớp {$className} lúc " . $this->booking->start_time->format('H:i d/m') . " đã được xác nhận.";
        }

        return [
            'type' => 'booking_confirmed',
            'title' => $title,
            'message' => $message,
            'booking_id' => $this->booking->id,
        ];
    }
}
