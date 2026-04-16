<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\RescheduleRequest;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    //
    public function index(){
        $memberships = Membership::where('is_active', 1)->take(4)->get();
        return view("client.trangChu", compact('memberships'));    
    }

    public function memberships()
    {
        $memberships = Membership::where('is_active', 1)->get();
        return view("client.goiTap", compact('memberships'));
    }

    public function trainers()
    {
        $trainers = Trainer::with('user')->where('is_available', 1)->get();
        return view("client.huanLuyenVien", compact('trainers'));
    }

    public function trainerDetail($id)
    {
        $trainer = Trainer::with(['user', 'schedules' => function($q) {
            $q->where('start_time', '>=', now())->orderBy('start_time');
        }])->findOrFail($id);
        
        return view("client.trainer-detail", compact('trainer'));
    }

    public function schedule(Request $request)
    {
        // 1. Tạo danh sách 30 ngày kể từ hôm nay
        $dates = [];
        $startDate = Carbon::today();
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dates[] = [
                'full' => $date->toDateString(),
                'day_name' => $date->dayOfWeek === 0 ? 'CN' : 'Thứ ' . ($date->dayOfWeek + 1),
                'label' => $date->format('d/m'),
                'is_today' => $i === 0,
                'index' => $i
            ];
        }

        // 2. Lấy toàn bộ lịch trong vòng 30 ngày tới (Tính từ thời điểm hiện tại trở đi)
        $schedules = Schedule::with('trainer.user')
            ->where('status', 'upcoming')
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addDays(30))
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($schedule) {
                return $schedule->start_time->toDateString();
            });

        // 3. Lấy danh sách HLV để đặt PT nhanh
        $trainers = Trainer::with('user')->where('is_available', 1)->get();

        return view("client.lichLop", compact('schedules', 'dates', 'trainers'));
    }

    public function contact(){
        return view("client.lienHe");
    }

    public function news(){
        return view("client.tinTuc");
    }

    public function newsDetail($id){
        return view("client.tinTucChiTiet");
    }

    /**
     * Lịch cá nhân của học viên
     */
    public function personalSchedule()
    {
        $bookings = Booking::with(['trainer.user', 'schedule', 'rescheduleRequests' => function($q) {
                $q->where('status', 'pending');
            }])
            ->where('user_id', Auth::id())
            ->orderBy('start_time', 'desc')
            ->get();

        return view('client.personal-schedule', compact('bookings'));
    }

    /**
     * Trung tâm thông báo
     */
    public function notifications()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        Auth::user()->unreadNotifications->markAsRead();
        
        return view('client.notifications', compact('notifications'));
    }

    /**
     * Phản hồi yêu cầu đổi lịch (Đồng ý/Từ chối)
     */
    public function respondToReschedule(Request $request, $id)
    {
        $reschedule = RescheduleRequest::findOrFail($id);
        $booking = $reschedule->booking;

        if ($request->action === 'approve') {
            $reschedule->update(['status' => 'approved']);
            $booking->update([
                'start_time' => $reschedule->new_start_time,
                'end_time' => Carbon::parse($reschedule->new_start_time)->addHours(1), // Giả định buổi tập 1h
            ]);
            return back()->with('success', 'Đã đồng ý đổi lịch tập thành công!');
        } else {
            $reschedule->update(['status' => 'rejected']);
            return back()->with('success', 'Đã từ chối yêu cầu đổi lịch.');
        }
    }
}
