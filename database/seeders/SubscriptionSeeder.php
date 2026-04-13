<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Booking;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        // User ID 2 = client@gmail.com

        // 1. Active Gym package
        $sub1 = Subscription::create([
            'user_id' => 2,
            'membership_id' => 1, // first membership
            'trainer_id' => null,
            'start_date' => now()->subDays(15),
            'end_date' => now()->addDays(15),
            'final_price' => 500000,
            'pt_sessions_left' => 0,
            'status' => 'active',
        ]);

        // 2. Active Yoga + PT package
        $sub2 = Subscription::create([
            'user_id' => 2,
            'membership_id' => 2, // second membership (if exists, fallback to 1)
            'trainer_id' => 1,
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(50),
            'final_price' => 1200000,
            'pt_sessions_left' => 8,
            'status' => 'active',
        ]);

        // 3. Expired package
        Subscription::create([
            'user_id' => 2,
            'membership_id' => 1,
            'trainer_id' => null,
            'start_date' => now()->subDays(60),
            'end_date' => now()->subDays(5),
            'final_price' => 500000,
            'pt_sessions_left' => 0,
            'status' => 'expired',
        ]);

        // 4. Cancelled package
        Subscription::create([
            'user_id' => 2,
            'membership_id' => 1,
            'trainer_id' => null,
            'start_date' => now()->subDays(90),
            'end_date' => now()->subDays(30),
            'final_price' => 500000,
            'pt_sessions_left' => 0,
            'status' => 'cancelled',
            'cancel_reason' => 'Bận công việc, không có thời gian tập',
            'cancelled_at' => now()->subDays(45),
        ]);

        // Bookings for calendar
        $bookingData = [
            // This week
            ['subscription_id' => $sub1->id, 'booking_type' => 'class', 'schedule_id' => 1, 'days_offset' => 0],
            ['subscription_id' => $sub1->id, 'booking_type' => 'class', 'schedule_id' => 2, 'days_offset' => 2],
            ['subscription_id' => $sub2->id, 'booking_type' => 'pt_session', 'trainer_id' => 1, 'days_offset' => 1],
            ['subscription_id' => $sub2->id, 'booking_type' => 'pt_session', 'trainer_id' => 1, 'days_offset' => 3],
            // Next week
            ['subscription_id' => $sub1->id, 'booking_type' => 'class', 'schedule_id' => 1, 'days_offset' => 5],
            ['subscription_id' => $sub2->id, 'booking_type' => 'pt_session', 'trainer_id' => 1, 'days_offset' => 6],
            ['subscription_id' => $sub1->id, 'booking_type' => 'class', 'schedule_id' => 3, 'days_offset' => 8],
            // Past (completed)
            ['subscription_id' => $sub1->id, 'booking_type' => 'class', 'schedule_id' => 1, 'days_offset' => -3, 'status' => 'completed'],
            ['subscription_id' => $sub2->id, 'booking_type' => 'pt_session', 'trainer_id' => 1, 'days_offset' => -5, 'status' => 'completed'],
        ];

        foreach ($bookingData as $data) {
            $startTime = Carbon::now()->addDays($data['days_offset'])->setTime(
                $data['booking_type'] === 'class' ? 8 : 15, 0
            );

            Booking::create([
                'user_id' => 2,
                'subscription_id' => $data['subscription_id'],
                'booking_type' => $data['booking_type'],
                'schedule_id' => $data['schedule_id'] ?? null,
                'trainer_id' => $data['trainer_id'] ?? null,
                'start_time' => $startTime,
                'end_time' => $startTime->copy()->addMinutes(60),
                'status' => $data['status'] ?? 'confirmed',
            ]);
        }
    }
}
