<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionReportNotification extends Notification
{
    use Queueable;

    public $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Báo cáo buổi tập - EXTRA FIT+')
                    ->greeting('Chào ' . $notifiable->name . '!')
                    ->line('Buổi tập của bạn vừa kết thúc thành công.')
                    ->line('**Nhận xét từ PT:** ' . $this->report->notes)
                    ->line('**Đánh giá nỗ lực:** ' . $this->report->effort_rating . '/10')
                    ->line('**Cường độ:** ' . $this->report->session_intensity)
                    ->action('Xem chi tiết tiến độ', url('/lich-ca-nhan'))
                    ->line('Cảm ơn bạn đã tập luyện cùng chúng tôi!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'session_report',
            'title' => 'Báo cáo buổi tập mới',
            'message' => 'PT vừa gửi báo cáo và nhận xét cho buổi tập của bạn.',
            'booking_id' => $this->report->booking_id,
        ];
    }
}
