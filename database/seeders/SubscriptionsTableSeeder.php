<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscriptions')->delete();

        DB::table('subscriptions')->insert([
            [
                'id' => 1, 'user_id' => 2, 'membership_id' => 2, 'trainer_id' => 9, 'start_date' => '2026-04-06', 'end_date' => '2026-05-06',
                'final_price' => 800000.00, 'pt_sessions_left' => 4, 'status' => 'active', 'cancel_reason' => null, 'cancelled_at' => null,
                'frozen_until' => null, 'created_at' => '2026-04-11 02:18:46', 'updated_at' => '2026-04-11 02:18:46'
            ],
            [
                'id' => 5, 'user_id' => 3, 'membership_id' => 5, 'trainer_id' => null, 'start_date' => '2026-04-13', 'end_date' => '2026-06-12',
                'final_price' => 900000.00, 'pt_sessions_left' => 1, 'status' => 'active', 'cancel_reason' => null, 'cancelled_at' => null,
                'frozen_until' => null, 'created_at' => '2026-04-13 06:48:51', 'updated_at' => '2026-04-23 03:02:26'
            ],
            [
                'id' => 10, 'user_id' => 3, 'membership_id' => 1, 'trainer_id' => null, 'start_date' => '2026-04-14', 'end_date' => '2026-05-14',
                'final_price' => 300000.00, 'pt_sessions_left' => 0, 'status' => 'active', 'cancel_reason' => null, 'cancelled_at' => null,
                'frozen_until' => null, 'created_at' => '2026-04-13 20:08:44', 'updated_at' => '2026-04-13 20:09:19'
            ],
            [
                'id' => 11, 'user_id' => 3, 'membership_id' => 1, 'trainer_id' => null, 'start_date' => '2026-04-14', 'end_date' => '2026-05-14',
                'final_price' => 300000.00, 'pt_sessions_left' => 0, 'status' => 'active', 'cancel_reason' => null, 'cancelled_at' => null,
                'frozen_until' => null, 'created_at' => '2026-04-13 20:54:42', 'updated_at' => '2026-04-13 20:55:02'
            ],
            [
                'id' => 13, 'user_id' => 3, 'membership_id' => 3, 'trainer_id' => null, 'start_date' => '2026-04-15', 'end_date' => '2026-05-15',
                'final_price' => 1500000.00, 'pt_sessions_left' => 12, 'status' => 'active', 'cancel_reason' => null, 'cancelled_at' => null,
                'frozen_until' => null, 'created_at' => '2026-04-14 17:44:02', 'updated_at' => '2026-04-14 17:45:28'
            ],
            [
                'id' => 14, 'user_id' => 3, 'membership_id' => 2, 'trainer_id' => null, 'start_date' => '2026-04-15', 'end_date' => '2026-05-15',
                'final_price' => 800000.00, 'pt_sessions_left' => 4, 'status' => 'active', 'cancel_reason' => null, 'cancelled_at' => null,
                'frozen_until' => null, 'created_at' => '2026-04-14 17:48:24', 'updated_at' => '2026-04-14 17:48:40'
            ],
            [
                'id' => 23, 'user_id' => 3, 'membership_id' => 3, 'trainer_id' => null, 'start_date' => '2026-04-15', 'end_date' => '2026-05-15',
                'final_price' => 1500000.00, 'pt_sessions_left' => 12, 'status' => 'active', 'cancel_reason' => null, 'cancelled_at' => null,
                'frozen_until' => null, 'created_at' => '2026-04-14 18:17:48', 'updated_at' => '2026-04-14 18:18:05'
            ],
        ]);
        
        // Including only active/important ones for now. 
        // In a real scenario, we'd include all status 'cancelled' etc. if needed.
    }
}
