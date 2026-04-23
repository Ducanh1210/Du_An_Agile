<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Booking;
use App\Notifications\DailyScheduleSummaryNotification;
use Carbon\Carbon;

class NotifyDailySchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-daily-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi thông báo tổng hợp lịch tập trong ngày cho người dùng';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();

        $this->info("Bắt đầu quét lịch tập ngày " . $todayStart->format('d/m/Y'));

        // Lấy tất cả user có ít nhất 1 booking confirmed hoặc pending trong ngày hôm nay
        $users = User::whereHas('bookings', function($q) use ($todayStart, $todayEnd) {
            $q->whereIn('status', ['confirmed', 'pending'])
              ->whereBetween('start_time', [$todayStart, $todayEnd]);
        })->get();

        if ($users->isEmpty()) {
            $this->info("Không có người dùng nào có lịch tập hôm nay.");
            return;
        }

        $count = 0;
        foreach ($users as $user) {
            // Lấy danh sách booking trong ngày của user này
            $bookings = Booking::where('user_id', $user->id)
                ->whereIn('status', ['confirmed', 'pending'])
                ->whereBetween('start_time', [$todayStart, $todayEnd])
                ->with(['trainer', 'schedule'])
                ->orderBy('start_time')
                ->get();

            $user->notify(new DailyScheduleSummaryNotification($bookings));
            $count++;
            $this->info("- Đã gửi nhắc lịch cho: {$user->name} ({$bookings->count()} buổi)");
        }

        $this->info("Đã gửi tổng cộng {$count} thông báo nhắc lịch hàng ngày.");
    }
}
