<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PTBookingController extends Controller
{
    /**
     * Xử lý đặt chỗ PT 1-kèm-1
     */
    public function store(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string', // Định dạng HH:mm
        ]);

        $user = Auth::user();
        $startTime = Carbon::parse($request->date . ' ' . $request->time_slot);
        $endTime = $startTime->copy()->addHour(); // Mỗi buổi mặc định 1h

        // 1. Kiểm tra Gói tập & Buổi PT còn lại
        $subscription = $user->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', $startTime->toDateString())
            ->where('pt_sessions_left', '>', 0)
            ->first();

        if (!$subscription) {
            return back()->with('error', 'Bạn không có gói tập kèm PT hoặc đã hết số buổi PT khả dụng!');
        }

        return DB::transaction(function () use ($user, $subscription, $request, $startTime, $endTime) {
            
            // 2. Kiểm tra xung đột với Lịch Lớp (Class Schedule) của HLV
            $hasClassNameConflict = Schedule::where('trainer_id', $request->trainer_id)
                ->where('status', 'upcoming')
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                          ->where('end_time', '>', $startTime);
                })
                ->exists();

            if ($hasClassNameConflict) {
                return back()->with('error', 'HLV đã có lịch dạy lớp tập thể vào khung giờ này. Vui lòng chọn giờ khác.');
            }

            // 3. Kiểm tra xung đột với các buổi tập PT khác của HLV
            $hasPTConflict = Booking::where('trainer_id', $request->trainer_id)
                ->where('status', 'confirmed')
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                          ->where('end_time', '>', $startTime);
                })
                ->exists();

            if ($hasPTConflict) {
                return back()->with('error', 'HLV đã có lịch tập 1-kèm-1 khác vào khung giờ này.');
            }

            // 4. Kiểm tra lịch cá nhân của bản thân User (Chống trùng giờ cá nhân)
            $hasPersonalConflict = Booking::where('user_id', $user->id)
                ->where('status', 'confirmed')
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                          ->where('end_time', '>', $startTime);
                })
                ->exists();

            if ($hasPersonalConflict) {
                return back()->with('error', 'Bạn đã có một lịch tập khác trùng với khung giờ này!');
            }

            // 5. Trừ buổi PT
            $subscription->deductPTSession();

            // 6. Tạo Booking
            Booking::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'trainer_id' => $request->trainer_id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'confirmed',
                'booking_type' => 'pt_session',
            ]);

            return back()->with('success', 'Đặt lịch tập PT thành công! HLV sẽ sớm liên hệ với bạn.');
        });
    }
}
