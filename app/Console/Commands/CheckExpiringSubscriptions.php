<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\MembershipExpiringSoon;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckExpiringSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra và gửi thông báo cho các gói tập sắp hết hạn trong 3 ngày tới';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = Carbon::today()->addDays(3);
        
        $this->info("Đang kiểm tra các gói tập hết hạn vào ngày: " . $targetDate->format('d/m/Y'));

        $subscriptions = Subscription::where('end_date', $targetDate->toDateString())
            ->where('status', 'active')
            ->with('user', 'membership')
            ->get();

        if ($subscriptions->isEmpty()) {
            $this->info("Không tìm thấy gói tập nào sắp hết hạn.");
            return;
        }

        $count = 0;
        foreach ($subscriptions as $subscription) {
            $subscription->user->notify(new MembershipExpiringSoon($subscription));
            $count++;
        }

        $this->info("Đã gửi thông báo cho {$count} hội viên.");
    }
}
