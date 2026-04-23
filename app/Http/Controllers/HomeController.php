<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Membership;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        $memberships = Membership::where('is_active', 1)->take(4)->get();
        // Updated for CMS
        $latestNews = News::where('news_status', 'published')->orderBy('published_at', 'desc')->take(3)->get();
        $featuredNews = News::where('news_status', 'published')->orderBy('views', 'desc')->take(5)->get();
        
        return view("client.trangChu", compact('memberships', 'latestNews', 'featuredNews'));    
    }

    public function memberships()
    {
        $memberships = Membership::where('is_active', 1)->get();
        return view("client.goiTap", compact('memberships'));
    }

    public function trainers()
    {
        $trainers = User::where('role', 'trainer')->where('is_available', 1)->get();
        return view("client.huanLuyenVien", compact('trainers'));
    }

    public function trainerDetail($id)
    {
        $trainer = User::where('role', 'trainer')
            ->with(['trainerSchedules' => function($q) {
                $q->where('start_time', '>=', now())->orderBy('start_time');
            }])->findOrFail($id);

        // Lấy danh sách bận từ PT Bookings (trainerBookings)
        $bookedSlots = Booking::where('trainer_id', $id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->where('start_time', '>=', now())
            ->get(['start_time', 'end_time'])
            ->map(function($booking) {
                return [
                    'date' => $booking->start_time->format('Y-m-d'),
                    'time' => $booking->start_time->format('H:i'),
                ];
            })->toArray();

        // Thêm lịch dạy lớp tập thể vào danh sách bận
        foreach ($trainer->trainerSchedules as $schedule) {
            $bookedSlots[] = [
                'date' => $schedule->start_time->format('Y-m-d'),
                'time' => $schedule->start_time->format('H:i'),
            ];
        }
        
        return view("client.trainer-detail", compact('trainer', 'bookedSlots'));
    }

    public function schedule(Request $request)
    {
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

        $schedules = Schedule::with('trainer')
            ->where('status', 'upcoming')
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addDays(30))
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($schedule) {
                return $schedule->start_time->toDateString();
            });

        $trainers = User::where('role', 'trainer')->where('is_available', 1)->get();

        return view("client.lichLop", compact('schedules', 'dates', 'trainers'));
    }

    public function contact(){
        return view("client.lienHe");
    }

    public function news(Request $request){
        $query = News::with(['category', 'author'])->where('news_status', 'published');

        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->tag) {
            $query->where('tags_list', 'like', '%' . $request->tag . '%');
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(6);
        $categories = NewsCategory::where('is_active', true)->get();
        $featuredNews = News::where('news_status', 'published')->where('is_featured', true)->orderBy('published_at', 'desc')->take(4)->get();
        
        // Trích xuất các tag độc nhất từ tất cả bài viết để hiển thị ở sidebar
        $tags = News::whereNotNull('tags_list')
                    ->pluck('tags_list')
                    ->flatMap(fn($t) => array_map('trim', explode(',', $t)))
                    ->unique()
                    ->values();

        return view("client.tinTuc", compact('news', 'featuredNews', 'categories', 'tags'));
    }

    public function newsDetail($slug){
        $news = News::with(['category', 'author', 'approvedComments.user'])
                    ->where('slug', $slug)
                    ->orWhere('id', $slug)
                    ->firstOrFail();

        // Increment views
        $news->increment('views');

        $recentNews = News::where('news_status', 'published')->where('id', '!=', $news->id)->orderBy('published_at', 'desc')->take(4)->get();
        $relatedNews = News::where('news_status', 'published')
                           ->where('category_id', $news->category_id)
                           ->where('id', '!=', $news->id)
                           ->take(3)->get();

        return view("client.tinTucChiTiet", compact('news', 'recentNews', 'relatedNews'));
    }

    public function personalSchedule()
    {
        $user = Auth::user();
        $bookings = Booking::with(['trainer', 'schedule'])
            ->where('user_id', $user->id)
            ->orderBy('start_time', 'desc')
            ->get();

        $activeSubscription = $user->subscriptions()
            ->with('membership')
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->first();

        return view('client.personal-schedule', compact('bookings', 'activeSubscription'));
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        Auth::user()->unreadNotifications->markAsRead();
        
        return view('client.notifications', compact('notifications'));
    }

    /**
     * Phản hồi yêu cầu đổi lịch (Duyệt trực tiếp trên Booking)
     */
    public function respondToReschedule(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($request->action === 'approve') {
            $booking->update([
                'reschedule_status' => 'approved',
                'start_time' => $booking->reschedule_at, // Chuyển reschedule_at thành start_time
                'end_time' => Carbon::parse($booking->reschedule_at)->addHours(1),
            ]);
            return back()->with('success', 'Đã đồng ý đổi lịch tập thành công!');
        } else {
            $booking->update(['reschedule_status' => 'rejected']);
            return back()->with('success', 'Đã từ chối yêu cầu đổi lịch.');
        }
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        NewsComment::create([
            'news_id' => $id,
            'user_id' => Auth::user()->id,
            'content' => $request->input('content'),
            'is_approved' => false,
        ]);

        return back()->with('success', 'Bình luận của bạn đã được gửi và đang chờ duyệt!');
    }
}
