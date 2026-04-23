<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailyScheduleSummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $bookings;

    /**
     * Create a new notification instance.
     */
    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        \Illuminate\Support\Facades\Log::info("Đang gửi email nhắc lịch hàng ngày tới: " . $notifiable->email);
        $count = $this->bookings->count();
        $mail = (new MailMessage)
                    ->subject("🔥 Lịch tập hôm nay của bạn có {$count} buổi - EXTRA FIT+")
                    ->greeting("Chào {$notifiable->name},")
                    ->line("Sẵn sàng cho một ngày bùng nổ năng lượng! Hôm nay bạn có {$count} buổi tập đã được lên lịch.");

        foreach ($this->bookings as $index => $booking) {
            $time = $booking->start_time->format('H:i');
            $trainerName = $booking->trainer->name ?? 'HLV';
            
            if ($booking->booking_type === 'pt_session') {
                $content = "Tập PT **{$booking->target_area}** với HLV **{$trainerName}**";
            } else {
                $className = $booking->schedule->title ?? 'Lớp học';
                $content = "Lớp học **{$className}** với HLV **{$trainerName}**";
            }
            
            $mail->line(($index + 1) . ". **{$time}**: {$content}");
        }

        return $mail->action('Xem lịch cá nhân', url('/lich-ca-nhan'))
                    ->line('Đừng quên ăn uống đầy đủ và mang theo đồ tập nhé. Hẹn sớm gặp bạn!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $count = $this->bookings->count();
        $first = $this->bookings->first();
        $time = $first->start_time->format('H:i');
        
        return [
            'type' => 'daily_summary',
            'title' => "Lịch tập hôm nay ({$count} buổi)",
            'message' => "Hôm nay bạn có {$count} buổi tập. Buổi đầu tiên bắt đầu lúc {$time}. Chúc bạn tập luyện hiệu quả!",
            'count' => $count,
        ];
    }
}
