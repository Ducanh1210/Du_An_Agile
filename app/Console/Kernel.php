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
