<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessfulNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $membership = $this->payment->subscription->membership;
        $amount = number_format($this->payment->amount) . 'đ';
        
        return (new MailMessage)
                    ->subject('Thanh toán thành công - EXTRA FIT+')
                    ->greeting('Chào ' . $notifiable->name . '!')
                    ->line("Giao dịch thanh toán của bạn đã hoàn tất thành công. Gói tập của bạn hiện đã được kích hoạt.")
                    ->line("**Thông tin giao dịch:**")
                    ->line("- Gói tập: " . $membership->name)
                    ->line("- Số tiền: {$amount}")
                    ->line("- Mã hóa đơn: " . $this->payment->invoice_code)
                    ->line("- Ngày kích hoạt: " . $this->payment->subscription->start_date->format('d/m/Y'))
                    ->line("- Ngày hết hạn: " . $this->payment->subscription->end_date->format('d/m/Y'))
                    ->action('Xem gói tập của tôi', url('/goi-dang-ky'))
                    ->line('Cảm ơn bạn đã đồng hành cùng EXTRA FIT+!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'payment_success',
            'title' => 'Thanh toán thành công',
            'message' => 'Gói tập ' . $this->payment->subscription->membership->name . ' đã được kích hoạt thành công.',
            'payment_id' => $this->payment->id,
            'invoice_code' => $this->payment->invoice_code,
        ];
    }
}
