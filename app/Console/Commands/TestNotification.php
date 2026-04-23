<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\BookingConfirmedNotification;
use App\Models\Booking;

class TestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi một thông báo test tới email chỉ định';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Không tìm thấy người dùng với email: {$email}");
            return;
        }

        $this->info("Đang tạo booking giả để test...");
        
        // Tìm một booking bất kỳ hoặc tạo mới
        $booking = Booking::with('trainer')->first();
        
        if (!$booking) {
            $this->error("Hệ thống chưa có booking nào để lấy dữ liệu mẫu.");
            return;
        }

        $this->info("Đang gửi thông báo tới {$user->name}...");
        
        try {
            $user->notify(new BookingConfirmedNotification($booking));
            $this->info("Đã gửi thông báo thành công (Database & Mail).");
            $this->info("Vui lòng kiểm tra Inbox hoặc bảng notifications trong Database.");
        } catch (\Exception $e) {
            $this->error("Lỗi khi gửi thông báo: " . $e->getMessage());
        }
    }
}
