<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Nhắc gói tập sắp hết hạn vào 8 giờ sáng hàng ngày
        $schedule->command('app:check-subscriptions')->dailyAt('08:00');

        // Nhắc lịch tập sắp diễn ra mỗi 10 phút
        $schedule->command('app:remind-sessions')->everyTenMinutes();

        // Thông báo tổng hợp lịch tập hôm nay vào 7:00 sáng
        $schedule->command('app:notify-daily-schedule')->dailyAt('07:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
