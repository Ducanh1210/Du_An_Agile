<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Booking;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ClientProfileController extends Controller
{
    /**
     * Hồ sơ cá nhân
     */
    public function profile()
    {
        $user = Auth::user();
        $activeSubscriptions = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();
        $totalBookings = Booking::where('user_id', $user->id)->count();

        return view('client.hoSo', compact('user', 'activeSubscriptions', 'totalBookings'));
    }

    /**
     * Cập nhật hồ sơ
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? $user->phone;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = '/storage/' . $path;
        }

        $user->save();

        return redirect()->route('client.profile')
            ->with('success', 'Cập nhật hồ sơ thành công!');
    }

    /**
     * Đổi mật khẩu
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('client.profile')
            ->with('success', 'Đổi mật khẩu thành công!');
    }

    /**
     * Danh sách gói đã đăng ký
     */
    public function subscriptions()
    {
        $user = Auth::user();
        $subscriptions = Subscription::with(['membership', 'trainer.user'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('client.goiDangKy', compact('subscriptions'));
    }

    /**
     * Gia hạn gói
     */
    public function renewSubscription($id)
    {
        $subscription = Subscription::where('user_id', Auth::id())->findOrFail($id);

        if ($subscription->status !== 'expired') {
            return back()->with('error', 'Chỉ có thể gia hạn gói đã hết hạn.');
        }

        $daysToAdd = $subscription->membership->duration_days ?? 30;

        if ($subscription->end_date->isPast()) {
            $subscription->start_date = now();
            $subscription->end_date = now()->addDays($daysToAdd);
        } else {
            $subscription->end_date = $subscription->end_date->addDays($daysToAdd);
        }

        $subscription->status = 'active';
        $subscription->save();

        return back()->with('success', 'Gia hạn gói thành công! Thêm ' . $daysToAdd . ' ngày.');
    }

    /**
     * Hủy gói (chỉ cho phép gói chờ thanh toán)
     */
    public function cancelSubscription(Request $request, $id)
    {
        $subscription = Subscription::where('user_id', Auth::id())->findOrFail($id);

        if ($subscription->status !== 'pending_payment') {
            return back()->with('error', 'Chỉ có thể hủy gói đang chờ thanh toán.');
        }

        $subscription->status = 'cancelled';
        $subscription->cancel_reason = $request->input('cancel_reason', 'Người dùng tự hủy');
        $subscription->cancelled_at = now();
        $subscription->save();

        // Hủy các payment pending liên quan
        $subscription->payments()->where('status', 'pending')->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Đã hủy đăng ký thành công.');
    }

    /**
     * Lịch cá nhân
     */
    public function calendar()
    {
        $user = Auth::user();
        $bookings = Booking::with(['schedule.trainer.user', 'trainer.user', 'subscription.membership'])
            ->where('user_id', $user->id)
            ->where('start_time', '>=', now()->startOfMonth())
            ->where('start_time', '<=', now()->endOfMonth()->addMonth())
            ->orderBy('start_time')
            ->get();

        $upcomingBookings = Booking::with(['schedule.trainer.user', 'trainer.user', 'subscription.membership'])
            ->where('user_id', $user->id)
            ->where('start_time', '>=', now())
            ->where('status', 'confirmed')
            ->orderBy('start_time')
            ->limit(10)
            ->get();

        return view('client.lichCaNhan', compact('bookings', 'upcomingBookings'));
    }
}
