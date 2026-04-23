<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Notifications\UpcomingSessionReminder;
use Illuminate\Console\Command;
use Carbon\Carbon;

class RemindUpcomingSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi thông báo nhắc lịch tập trước 30 phút';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Khoảng thời gian để quét: 30 phút nữa (quét trong phạm vi +- 5 phút để tránh sót)
        $now = Carbon::now();
        $startTime = $now->copy()->addMinutes(25);
        $endTime = $now->copy()->addMinutes(35);

        $this->info("Đang kiểm tra các ca tập bắt đầu từ " . $startTime->format('H:i') . " đến " . $endTime->format('H:i'));

        $bookings = Booking::whereBetween('start_time', [
                $startTime->toDateTimeString(), 
                $endTime->toDateTimeString()
            ])
            ->where('status', 'confirmed') // Chỉ nhắc các ca đã xác nhận
            ->with('user', 'trainer.user', 'schedule')
            ->get();

        if ($bookings->isEmpty()) {
            $this->info("Không có ca tập nào sắp diễn ra trong 30 phút tới.");
            return;
        }

        $count = 0;
        foreach ($bookings as $booking) {
            $booking->user->notify(new UpcomingSessionReminder($booking));
            $count++;
        }

        $this->info("Đã gửi nhắc hẹn cho {$count} người dùng.");
    }
}
