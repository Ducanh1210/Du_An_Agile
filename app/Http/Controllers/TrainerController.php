<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Booking;
use App\Models\HealthMetric;
use App\Models\SessionReport;
use App\Models\RescheduleRequest;
use App\Models\User;
use App\Notifications\SessionReportNotification;
use App\Notifications\RescheduleRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrainerController extends Controller
{
    /**
     * Dashboard Trainer: Hiển thị nhiệm vụ hôm nay (Today's Mission)
     */
    public function dashboard()
    {
        $trainer = Trainer::where('user_id', Auth::id())->firstOrFail();
        
        // Lấy các buổi tập hôm nay
        $todayBookings = Booking::with('user')
            ->where('trainer_id', $trainer->id)
            ->whereDate('start_time', Carbon::today())
            ->orderBy('start_time')
            ->get();

        $stats = [
            'today_count' => $todayBookings->count(),
            'pending_reschedules' => RescheduleRequest::whereHas('booking', function($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })->where('status', 'pending')->count(),
            'total_students' => User::whereHas('bookings', function($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })->distinct()->count(),
        ];

        return view('trainer.dashboard', compact('todayBookings', 'stats'));
    }

    /**
     * Danh sách học viên đang phụ trách
     */
    public function students()
    {
        $trainer = Trainer::where('user_id', Auth::id())->firstOrFail();
        
        $students = User::whereHas('bookings', function($query) use ($trainer) {
            $query->where('trainer_id', $trainer->id);
        })->distinct()->get();

        return view('trainer.students', compact('students'));
    }

    /**
     * Chi tiết học viên và Biểu đồ tiến độ
     */
    public function studentDetail($id)
    {
        $student = User::with(['healthMetrics' => function($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($id);

        // Chuẩn bị dữ liệu cho Chart.js (30 bản ghi gần nhất)
        $metrics = $student->healthMetrics->take(-30);
        $chartData = [
            'labels' => $metrics->map(fn($m) => $m->created_at->format('d/m'))->toArray(),
            'weight' => $metrics->pluck('weight')->toArray(),
            'bmi' => $metrics->pluck('bmi')->toArray(),
        ];

        return view('trainer.student-detail', compact('student', 'chartData'));
    }

    /**
     * Check-in nhanh 1-touch
     */
    public function checkIn($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'completed']);

        // Gửi thông báo đơn giản (Logic thông báo sẽ hoàn thiện sau)
        return back()->with('success', 'Đã check-in buổi tập thành công!');
    }

    /**
     * Cập nhật chỉ số sức khỏe & Tự động tính BMI
     */
    public function updateMetrics(Request $request, $id)
    {
        $request->validate([
            'weight' => 'required|numeric|min:20|max:300',
            'fat_percent' => 'nullable|numeric|min:1|max:70',
        ]);

        $student = User::findOrFail($id);
        $trainer = Trainer::where('user_id', Auth::id())->firstOrFail();
        
        // Tự động tính BMI nếu có chiều cao
        $bmi = 0;
        if ($student->height > 0) {
            $heightInMeters = $student->height / 100;
            $bmi = $request->weight / ($heightInMeters * $heightInMeters);
        }

        HealthMetric::create([
            'user_id' => $id,
            'trainer_id' => $trainer->id,
            'weight' => $request->weight,
            'bmi' => round($bmi, 2),
            'fat_percent' => $request->fat_percent,
            'recorded_by' => 'trainer'
        ]);

        return back()->with('success', 'Đã cập nhật chỉ số sức khỏe và BMI!');
    }

    /**
     * Gửi báo cáo buổi tập & Ghi chú
     */
    public function submitReport(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string',
            'effort_rating' => 'required|integer|min:1|max:10',
            'session_intensity' => 'required|string',
        ]);

        $booking = Booking::findOrFail($id);
        $trainer = Trainer::where('user_id', Auth::id())->firstOrFail();

        $report = SessionReport::create([
            'booking_id' => $booking->id,
            'trainer_id' => $trainer->id,
            'user_id' => $booking->user_id,
            'notes' => $request->notes,
            'effort_rating' => $request->effort_rating,
            'session_intensity' => $request->session_intensity,
        ]);

        $booking->update(['status' => 'completed']);

        // Gửi thông báo cho học viên
        $booking->user->notify(new SessionReportNotification($report));

        return redirect()->route('trainer.dashboard')->with('success', 'Báo cáo buổi tập đã được gửi và thông báo tới học viên!');
    }

    /**
     * Yêu cầu đổi lịch tập
     */
    public function requestReschedule(Request $request, $id)
    {
        $request->validate([
            'new_start_time' => 'required|date|after:now',
            'reason' => 'required|string',
        ]);

        $booking = Booking::findOrFail($id);
        
        $reschedule = RescheduleRequest::create([
            'booking_id' => $booking->id,
            'requested_by' => Auth::id(),
            'original_start_time' => $booking->start_time,
            'new_start_time' => $request->new_start_time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Gửi thông báo cho học viên
        $booking->user->notify(new RescheduleRequestNotification($reschedule));

        return back()->with('success', 'Yêu cầu đổi lịch đã được gửi tới học viên!');
    }
}
