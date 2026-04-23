<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifications')->delete();

        DB::table('notifications')->insert([
            [
                'id' => '0fc374f2-b6c0-405c-aada-55ce098f2df7', 'type' => 'App\Notifications\DailyScheduleSummaryNotification',
                'notifiable_type' => 'App\Models\User', 'notifiable_id' => 3,
                'data' => '{"type":"daily_summary","title":"Lịch tập hôm nay (1 buổi)","message":"Hôm nay bạn có 1 buổi tập. Buổi đầu tiên bắt đầu lúc 15:00. Chúc bạn tập luyện hiệu quả!","count":1}',
                'read_at' => '2026-04-22 12:57:46', 'created_at' => '2026-04-22 12:55:01', 'updated_at' => '2026-04-22 12:57:46'
            ],
            // ... adding a few more if needed
        ]);
    }
}
