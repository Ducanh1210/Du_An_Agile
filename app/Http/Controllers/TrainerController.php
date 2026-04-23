<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\HealthMetric;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Notifications\SessionReportNotification;
use App\Notifications\LeaveRequestCreatedNotification;
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
        $trainer = Auth::user(); // Lấy trực tiếp từ User model
        
        // Lấy các buổi tập hôm nay
        $todayBookings = Booking::with('user')
            ->where('trainer_id', $trainer->id)
            ->whereDate('start_time', Carbon::today())
            ->orderBy('start_time')
            ->get();

        $stats = [
            'today_count' => $todayBookings->count(),
            'pending_reschedules' => Booking::where('trainer_id', $trainer->id)
                ->where('reschedule_status', 'pending')->count(),
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
        $trainer = Auth::user();
        
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
        $trainer = Auth::user();
        
        // Tự động tính BMI nếu có chiều cao
        $bmi = 0;
        if ($student->height > 0) {
            $heightInMeters = $student->height / 100;
            $bmi = $request->weight / ($heightInMeters * $heightInMeters);
        }

        HealthMetric::create([
            'user_id' => $id,
            'trainer_id' => $trainer->id, // trainer_id giờ là user_id của HLV
            'weight' => $request->weight,
            'bmi' => round($bmi, 2),
            'fat_percent' => $request->fat_percent,
            'recorded_by' => 'trainer'
        ]);

        return back()->with('success', 'Đã cập nhật chỉ số sức khỏe và BMI!');
    }

    /**
     * Gửi báo cáo buổi tập & Ghi chú (Gộp trực tiếp vào Booking)
     */
    public function submitReport(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string',
            'effort_rating' => 'required|integer|min:1|max:10',
            'session_intensity' => 'required|string',
        ]);

        $booking = Booking::findOrFail($id);
        
        // Cập nhật thông tin báo cáo trực tiếp vào bảng bookings
        $booking->update([
            'report_content' => $request->notes,
            'effort_rating' => $request->effort_rating,
            'session_intensity' => $request->session_intensity,
            'status' => 'completed'
        ]);

        // Gửi thông báo cho học viên
        $booking->user->notify(new SessionReportNotification($booking));

        return redirect()->route('trainer.dashboard')->with('success', 'Báo cáo buổi tập đã được gửi và thông báo tới học viên!');
    }

    /**
     * Lịch dạy của HLV (PT & Group Classes)
     */
    public function schedule()
    {
        $trainer = Auth::user();
        
        // Lịch PT (Bookings) sử dụng quan hệ mới
        $bookings = $trainer->trainerBookings()
            ->with('user')
            ->where('start_time', '>=', Carbon::today())
            ->orderBy('start_time')
            ->get()->map(function ($item) {
                $item->is_pt = true;
                return $item;
            });

        // Lịch Lớp Nhóm (Schedules) sử dụng quan hệ mới
        $classes = $trainer->trainerSchedules()
            ->where('start_time', '>=', Carbon::today())
            ->orderBy('start_time')
            ->get()->map(function ($item) {
                $item->is_pt = false;
                return $item;
            });

        $allSchedules = $bookings->concat($classes)->sortBy('start_time');

        // Lấy danh sách đơn xin nghỉ
        $leaveRequests = LeaveRequest::where('trainer_id', $trainer->id)->get();

        return view('trainer.schedule', compact('allSchedules', 'leaveRequests', 'trainer'));
    }

    /**
     * Xin nghỉ dạy (Theo ca)
     */
    public function submitLeaveRequest(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'item_type' => 'required|string',
            'reason' => 'required|string|min:5',
        ]);

        $trainer = Auth::user();

        // Check xem đã xin nghỉ chưa
        $exists = LeaveRequest::where('item_id', $request->item_id)
            ->where('item_type', $request->item_type)
            ->exists();
            
        if ($exists) {
            return back()->with('error', 'Bạn đã nộp đơn xin nghỉ cho ca dạy này rồi!');
        }

        $leaveReq = LeaveRequest::create([
            'trainer_id' => $trainer->id,
            'item_type' => $request->item_type,
            'item_id' => $request->item_id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Gửi thông báo cho Admin & Staff
        $adminsAndStaff = User::whereIn('role', ['admin', 'staff'])->get();
        \Illuminate\Support\Facades\Notification::send($adminsAndStaff, new LeaveRequestCreatedNotification($leaveReq));

        return back()->with('success', 'Đã nộp đơn xin nghỉ dạy thành công. Vui lòng chờ duyệt!');
    }

    public function profile()
    {
        $trainer = Auth::user();
        return view('trainer.profile', compact('trainer'));
    }

    public function updateProfile(Request $request)
    {
        $trainer = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'price_per_session' => 'nullable|numeric|min:0',
        ]);

        $trainer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'price_per_session' => $request->price_per_session,
            'is_available' => $request->has('is_available'),
        ]);

        return back()->with('success', 'Hồ sơ cá nhân đã được cập nhật thành công!');
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'new_start_time' => 'required|date|after:now',
            'reason' => 'required|string|min:5',
        ]);

        $booking = Booking::findOrFail($id);
        
        $booking->update([
            'reschedule_time' => $request->new_start_time,
            'reschedule_reason' => $request->reason,
            'reschedule_status' => 'pending'
        ]);

        return back()->with('success', 'Yêu cầu dời lịch đã được gửi tới học viên!');
    }
}
