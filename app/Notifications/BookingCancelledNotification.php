<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelledNotification extends Notification
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
        return (new MailMessage)
                    ->subject('Thông báo Hủy ca tập - EXTRA FIT+')
                    ->greeting('Chào ' . $notifiable->name . '!')
                    ->line("Chúng tôi vô cùng xin lỗi, ca tập (PT Session) của bạn lúc {$date} đã bị HỦY do Huấn luyện viên có việc đột xuất xin nghỉ.")
                    ->line('Bạn sẽ không bị trừ lượt cho buổi tập này. Vui lòng liên hệ lễ tân hoặc đặt lại ca tập mới trên hệ thống.')
                    ->action('Tra cứu thông tin', url('/'))
                    ->line('Cảm ơn bạn đã thông cảm!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'booking_cancelled',
            'title' => 'Ca tập bị hủy',
            'message' => 'Ca tập lúc ' . $this->booking->start_time->format('H:i d/m/Y') . ' đã bị hủy do HLV xin nghỉ đột xuất.',
            'booking_id' => $this->booking->id,
        ];
    }
}
