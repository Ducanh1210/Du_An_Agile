<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\RescheduleRequest;
use App\Models\Membership;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\NewsComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        $memberships = Membership::where('is_active', 1)->take(4)->get();
        // Updated for CMS
        $latestNews = News::where('news_status', 'published')->orderBy('published_at', 'desc')->take(3)->get();
        $featuredNews = News::where('news_status', 'published')->where('is_featured', true)->orderBy('published_at', 'desc')->take(5)->get();
        
        return view("client.trangChu", compact('memberships', 'latestNews', 'featuredNews'));    
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

        $schedules = Schedule::with('trainer.user')
            ->where('status', 'upcoming')
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addDays(30))
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($schedule) {
                return $schedule->start_time->toDateString();
            });

        $trainers = Trainer::with('user')->where('is_available', 1)->get();

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
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(6);
        $categories = NewsCategory::where('is_active', true)->get();
        $featuredNews = News::where('news_status', 'published')->where('is_featured', true)->orderBy('published_at', 'desc')->take(4)->get();
        $tags = NewsTag::all();

        return view("client.tinTuc", compact('news', 'featuredNews', 'categories', 'tags'));
    }

    public function newsDetail($slug){
        $news = News::with(['category', 'author', 'tags', 'approvedComments.user'])
                    ->where('slug', $slug)
                    ->orWhere('id', $slug) // Support legacy ID links
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
        $bookings = Booking::with(['trainer.user', 'schedule', 'rescheduleRequests' => function($q) {
                $q->where('status', 'pending');
            }])
            ->where('user_id', Auth::id())
            ->orderBy('start_time', 'desc')
            ->get();

        return view('client.personal-schedule', compact('bookings'));
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        Auth::user()->unreadNotifications->markAsRead();
        
        return view('client.notifications', compact('notifications'));
    }

    public function respondToReschedule(Request $request, $id)
    {
        $reschedule = RescheduleRequest::findOrFail($id);
        $booking = $reschedule->booking;

        if ($request->action === 'approve') {
            $reschedule->update(['status' => 'approved']);
            $booking->update([
                'start_time' => $reschedule->new_start_time,
                'end_time' => Carbon::parse($reschedule->new_start_time)->addHours(1),
            ]);
            return back()->with('success', 'Đã đồng ý đổi lịch tập thành công!');
        } else {
            $reschedule->update(['status' => 'rejected']);
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
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_approved' => false, // Require approval
        ]);

        return back()->with('success', 'Bình luận của bạn đã được gửi và đang chờ duyệt!');
    }
}
