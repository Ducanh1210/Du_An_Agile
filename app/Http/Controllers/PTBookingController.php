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

        $trainer = Trainer::findOrFail($request->trainer_id);

        return DB::transaction(function () use ($user, $subscription, $trainer, $request, $startTime, $endTime) {
            
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
                ->whereIn('status', ['confirmed', 'completed'])
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
                ->whereIn('status', ['confirmed', 'completed'])
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                          ->where('end_time', '>', $startTime);
                })
                ->exists();

            if ($hasPersonalConflict) {
                return back()->with('error', 'Bạn đã có một lịch tập khác trùng với khung giờ này!');
            }

            // 5. Xác định hình thức thanh toán & Trừ buổi
            $price = 0;
            $paymentStatus = 'free';
            $msg = 'Đặt lịch tập PT thành công! Bạn đã sử dụng 1 buổi tập trong gói.';

            if ($subscription) {
                $subscription->deductPTSession();
            } else {
                $price = $trainer->price_per_session;
                $paymentStatus = 'pending';
                $msg = 'Đăng ký lịch tập thành công! Vì bạn không còn buổi miễn phí, vui lòng thanh toán ' . number_format($price) . 'đ tại quầy để kích hoạt lịch.';
            }

            // 6. Tạo Booking
            Booking::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription?->id,
                'trainer_id' => $request->trainer_id,
                'price' => $price,
                'payment_status' => $paymentStatus,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => $paymentStatus === 'free' ? 'confirmed' : 'pending',
                'booking_type' => 'pt_session',
            ]);

            return back()->with('success', $msg);
        });
    }

    /**
     * Hiển thị trang trung tâm đặt lịch PT (PT Booking Hub)
     */
    public function index(Request $request)
    {
        $selectedTrainerId = $request->query('trainer_id');
        
        $trainers = Trainer::with(['user', 'schedules' => function($q) {
            $q->where('start_time', '>=', now()->startOfDay());
        }])->get()->map(function($trainer) {
            // "LÀM GIÀU" DỮ LIỆU
            $trainer->name = $trainer->user->name;
            $trainer->price = $trainer->price_per_session; 
            $trainer->rating = 4.5 + (rand(0, 5) / 10);
            $trainer->experience = rand(2, 8);
            $trainer->students_count = rand(50, 200);
            $trainer->gender = rand(1, 10) > 5 ? 'male' : 'female';
            $trainer->bio = "Chuyên gia đào tạo với kiến thức sâu rộng về " . $trainer->specialization . ". Từng giúp hàng trăm học viên thay đổi hình thể hoàn toàn.";
            $trainer->certificates = ['National Academy of Sports Medicine (NASM)', 'Certified Strength & Conditioning Specialist (CSCS)'];
            return $trainer;
        });

        // Lấy gói tập hiện tại của User
        $userSubscription = Auth::user()?->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now()->toDateString())
            ->first();

        // Lấy tất cả các buổi PT đã được xác nhận của TẤT CẢ HLV
        $bookings = Booking::whereIn('status', ['confirmed', 'completed'])
            ->where('start_time', '>=', now()->startOfDay())
            ->get(['trainer_id', 'start_time', 'end_time', 'booking_type']);

        $trainerAvailability = [];
        foreach ($trainers as $trainer) {
            $busySlots = [];
            
            // 1. Thêm lịch dạy lớp nhóm (YELLOW - MÀU VÀNG)
            foreach ($trainer->schedules as $sch) {
                $busySlots[] = [
                    'date' => $sch->start_time->format('Y-m-d'),
                    'time' => $sch->start_time->format('H:i'),
                    'reason' => 'Đang dạy lớp nhóm',
                    'type' => 'class' // Yellow
                ];
            }

            // 2. Thêm lịch PT đã có khách (RED - MÀU ĐỎ)
            $trainerBookings = $bookings->where('trainer_id', $trainer->id);
            foreach ($trainerBookings as $bk) {
                $busySlots[] = [
                    'date' => $bk->start_time->format('Y-m-d'),
                    'time' => $bk->start_time->format('H:i'),
                    'reason' => 'Đã có khách đặt',
                    'type' => 'pt' // Red
                ];
            }

            $trainerAvailability[$trainer->id] = $busySlots;
        }

        // Tạo danh sách 14 ngày tới để người dùng chọn
        $dates = [];
        $startDate = \Carbon\Carbon::today();
        for ($i = 0; $i < 14; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dates[] = [
                'full' => $date->toDateString(),
                'day_name' => $date->dayOfWeek === 0 ? 'CN' : ($date->dayOfWeek === 6 ? 'T7' : 'T' . ($date->dayOfWeek + 1)),
                'label' => $date->format('d/m'),
                'date' => $date->format('d'),
                'month' => $date->format('m'),
                'is_today' => $i === 0,
            ];
        }

        return view('client.pt-booking-hub', compact('trainers', 'trainerAvailability', 'selectedTrainerId', 'dates', 'userSubscription'));
    }
}
