<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Xử lý đăng ký lịch tập (Booking Eligibility Logic)
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $user = Auth::user();
        $schedule = Schedule::findOrFail($request->schedule_id);
        
        // 1. Kiểm tra xem đã đặt lịch này chưa
        $exists = Booking::where('user_id', $user->id)
            ->where('schedule_id', $schedule->id)
            ->where('status', '!=', 'cancelled')
            ->exists();
            
        if ($exists) {
            return back()->with('error', 'Bạn đã đăng ký lịch tập này rồi!');
        }

        // 2. Kiểm tra súc chứa (Capacity)
        if ($schedule->current_enrolled >= $schedule->capacity) {
            return back()->with('error', 'Lớp học này đã hết chỗ!');
        }

        // 3. Kiểm tra Gói tập (Eligibility)
        $subscription = $user->activeSubscription();

        if (!$subscription) {
            return back()->with('error', 'Bạn không có gói tập nào đang hoạt động. Vui lòng đăng ký gói mới!');
        }

        // Kiểm tra ngày tập có nằm trong hạn gói tập không
        $bookingDate = Carbon::parse($schedule->start_time)->toDateString();
        if ($bookingDate < $subscription->start_date->toDateString() || $bookingDate > $subscription->end_date->toDateString()) {
            return back()->with('error', 'Ngày tập này nằm ngoài thời hạn gói tập của bạn (Hạn đến: ' . $subscription->end_date->format('d/m/Y') . ')');
        }

        // Kiểm tra số buổi PT (nếu gói có giới hạn PT)
        if ($subscription->membership->allow_pt == 1) {
            if ($subscription->pt_sessions_left <= 0) {
                return back()->with('error', 'Bạn đã hết số buổi tập PT trong gói này!');
            }
        }

        // 4. Tiến hành Đặt lịch
        \Illuminate\Support\Facades\DB::transaction(function () use ($user, $schedule, $subscription) {
            // Tạo Booking
            Booking::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'schedule_id' => $schedule->id,
                'trainer_id' => $schedule->trainer_id,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'status' => 'confirmed',
                'booking_type' => $schedule->category == 'pt_session' ? 'pt' : 'class',
            ]);

            // Cập nhật Schedule
            $schedule->increment('current_enrolled');

            // Trừ số buổi trong Subscription (nếu có)
            if ($subscription->membership->allow_pt == 1) {
                $subscription->decrement('pt_sessions_left');
            }
        });

        return back()->with('success', 'Đăng ký lịch tập thành công! Hãy kiểm tra trong Lịch cá nhân.');
    }
}
