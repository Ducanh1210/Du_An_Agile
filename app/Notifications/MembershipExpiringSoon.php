<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipExpiringSoon extends Notification implements ShouldQueue
{
    use Queueable;

    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $expiryDate = $this->subscription->end_date->format('d/m/Y');
        return (new MailMessage)
                    ->subject('Thông báo: Gói tập của bạn sắp hết hạn - EXTRA FIT+')
                    ->greeting('Chào ' . $notifiable->name . '!')
                    ->line('Gói tập "' . $this->subscription->membership->name . '" của bạn sẽ hết hạn vào ngày ' . $expiryDate . ' (trong 3 ngày tới).')
                    ->line('Vui lòng gia hạn để không bị gián đoạn quá trình tập luyện của bạn.')
                    ->action('Gia hạn ngay', url('/goi-dang-ky'))
                    ->line('Nếu bạn đã gia hạn trước đó, vui lòng bỏ qua thông báo này.')
                    ->line('Cảm ơn bạn đã đồng hành cùng EXTRA FIT+!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'membership_expiring',
            'title' => 'Gói tập sắp hết hạn',
            'message' => 'Gói tập "' . $this->subscription->membership->name . '" của bạn sẽ hết hạn vào ngày ' . $this->subscription->end_date->format('d/m/Y') . '. Hãy gia hạn ngay!',
            'subscription_id' => $this->subscription->id,
            'expiry_date' => $this->subscription->end_date->toDateString(),
        ];
    }
}
