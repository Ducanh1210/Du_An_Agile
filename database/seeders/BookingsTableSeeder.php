<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bookings')->delete();

        DB::table('bookings')->insert([
            [
                'id' => 1, 'user_id' => 3, 'subscription_id' => 5, 'booking_type' => 'class', 'target_area' => null, 'schedule_id' => 121, 'trainer_id' => 12,
                'start_time' => '2026-04-17 08:00:00', 'end_time' => '2026-04-17 09:00:00', 'price' => 0.00, 'payment_status' => 'free', 'status' => 'confirmed',
                'created_at' => '2026-04-15 20:58:20', 'updated_at' => '2026-04-15 20:58:20'
            ],
            [
                'id' => 2, 'user_id' => 3, 'subscription_id' => 5, 'booking_type' => 'class', 'target_area' => null, 'schedule_id' => 45, 'trainer_id' => 9,
                'start_time' => '2026-04-16 15:00:00', 'end_time' => '2026-04-16 16:00:00', 'price' => 0.00, 'payment_status' => 'free', 'status' => 'confirmed',
                'created_at' => '2026-04-15 21:02:35', 'updated_at' => '2026-04-15 21:02:35'
            ],
            [
                'id' => 3, 'user_id' => 3, 'subscription_id' => 5, 'booking_type' => 'pt_session', 'target_area' => null, 'schedule_id' => null, 'trainer_id' => 8,
                'start_time' => '2026-04-18 17:00:00', 'end_time' => '2026-04-18 18:00:00', 'price' => 0.00, 'payment_status' => 'free', 'status' => 'confirmed',
                'created_at' => '2026-04-17 18:28:28', 'updated_at' => '2026-04-17 18:28:28'
            ],
            [
                'id' => 4, 'user_id' => 3, 'subscription_id' => 5, 'booking_type' => 'class', 'target_area' => null, 'schedule_id' => 59, 'trainer_id' => 9,
                'start_time' => '2026-04-22 15:00:00', 'end_time' => '2026-04-22 16:00:00', 'price' => 0.00, 'payment_status' => 'free', 'status' => 'confirmed',
                'created_at' => '2026-04-21 16:48:08', 'updated_at' => '2026-04-21 16:48:08'
            ],
            [
                'id' => 5, 'user_id' => 16, 'subscription_id' => null, 'booking_type' => 'pt_session', 'target_area' => 'Toàn thân', 'schedule_id' => null, 'trainer_id' => 6,
                'start_time' => '2026-04-23 18:00:00', 'end_time' => '2026-04-23 19:00:00', 'price' => 500000.00, 'payment_status' => 'pending', 'status' => 'pending',
                'created_at' => '2026-04-23 02:34:47', 'updated_at' => '2026-04-23 02:34:47'
            ],
            [
                'id' => 6, 'user_id' => 3, 'subscription_id' => 5, 'booking_type' => 'pt_session', 'target_area' => 'Cơ lưng', 'schedule_id' => null, 'trainer_id' => 6,
                'start_time' => '2026-04-23 15:00:00', 'end_time' => '2026-04-23 16:00:00', 'price' => 0.00, 'payment_status' => 'free', 'status' => 'confirmed',
                'created_at' => '2026-04-23 03:00:53', 'updated_at' => '2026-04-23 03:00:53'
            ],
            [
                'id' => 7, 'user_id' => 3, 'subscription_id' => 5, 'booking_type' => 'pt_session', 'target_area' => 'Cơ chân', 'schedule_id' => null, 'trainer_id' => 5,
                'start_time' => '2026-04-23 13:00:00', 'end_time' => '2026-04-23 14:00:00', 'price' => 0.00, 'payment_status' => 'free', 'status' => 'confirmed',
                'created_at' => '2026-04-23 03:02:26', 'updated_at' => '2026-04-23 03:02:26'
            ],
        ]);
    }
}
