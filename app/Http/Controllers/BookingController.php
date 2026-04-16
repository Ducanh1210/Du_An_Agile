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
     * Xử lý đặt chỗ cho Hội viên (Member Booking)
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $user = Auth::user();

        return \Illuminate\Support\Facades\DB::transaction(function () use ($user, $request) {
            // 1. Khóa bản ghi Schedule để tránh race condition (Overbooking)
            $schedule = Schedule::where('id', $request->schedule_id)->lockForUpdate()->firstOrFail();

            // 2. Kiểm tra súc chứa
            if ($schedule->isFull()) {
                return back()->with('error', 'Lớp học này đã hết chỗ!');
            }

            // 3. Kiểm tra đã đặt lịch này chưa (Unique booking)
            $exists = Booking::where('user_id', $user->id)
                ->where('schedule_id', $schedule->id)
                ->where('status', 'confirmed')
                ->exists();

            if ($exists) {
                return back()->with('error', 'Bạn đã đăng ký lớp học này rồi!');
            }

            // 4. Kiểm tra trùng lịch (Conflict check)
            // (startA < endB) && (endA > startB)
            $hasConflict = Booking::where('user_id', $user->id)
                ->where('status', 'confirmed')
                ->where(function ($query) use ($schedule) {
                    $query->where('start_time', '<', $schedule->end_time)
                        ->where('end_time', '>', $schedule->start_time);
                })
                ->exists();

            if ($hasConflict) {
                return back()->with('error', 'Bạn đã có một lịch tập khác trùng với khung giờ này!');
            }

            // 5. Kiểm tra Gói tập (Membership)
            $subscription = $user->activeSubscription();
            if (!$subscription) {
                return back()->with('error', 'Bạn không có gói tập đang hoạt động!');
            }

            if ($schedule->start_time < $subscription->start_date || $schedule->start_time > $subscription->end_date) {
                return back()->with('error', 'Gói tập của bạn không có hiệu lực vào ngày này!');
            }

            // 6. Thực hiện Đặt chỗ
            Booking::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'schedule_id' => $schedule->id,
                'trainer_id' => $schedule->trainer_id,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'status' => 'confirmed',
                'booking_type' => 'class',
            ]);

            $schedule->increment('current_enrolled');

            return back()->with('success', 'Đặt chỗ thành công! Hẹn gặp bạn tại phòng tập.');
        });
    }



    /**
     * Hủy lịch tập (Cancellation Window: 2 hours)
     */
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'confirmed')
            ->firstOrFail();

        // Kiểm tra điều kiện 2 giờ
        if (now()->diffInHours($booking->start_time, false) < 2) {
            return back()->with('error', 'Bạn chỉ có thể hủy lịch trước giờ tập ít nhất 2 tiếng.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);
            $booking->schedule->decrement('current_enrolled');
        });

        return back()->with('success', 'Đã hủy lịch tập thành công.');
    }
}
