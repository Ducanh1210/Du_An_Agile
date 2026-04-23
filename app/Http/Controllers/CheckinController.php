<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    /**
     * Giao diện Trạm điểm danh dành cho nhân viên
     */
    public function index()
    {
        // 1. Mặc định lấy IP Wifi nội bộ
        $hostname = gethostname();
        $ips = gethostbynamel($hostname);
        $localIp = '127.0.0.1';
        if ($ips) {
            foreach ($ips as $ip) {
                if (str_starts_with($ip, '192.168.1.')) {
                    $localIp = $ip;
                    break;
                }
            }
        }

        $checkinUrl = route('checkin.verify', [], true);

        // 2. Tự động kiểm tra xem có Đường hầm công khai (Localtunnel) không
        $tunnelFile = base_path('tunnel_url.txt');
        if (file_exists($tunnelFile)) {
            $content = file_get_contents($tunnelFile);
            // Tìm URL dạng https://...loca.lt
            if (preg_match('/https:\/\/[^\s]+/', $content, $matches)) {
                $checkinUrl = rtrim($matches[0], '/');
                $checkinUrl .= '/checkin/verify';
                $localIp = "Internet Tunnel (Public)";
            } else {
                $checkinUrl = str_replace(['localhost', '127.0.0.1', '192.168.137.1'], $localIp, $checkinUrl);
            }
        } else {
            $checkinUrl = str_replace(['localhost', '127.0.0.1', '192.168.137.1'], $localIp, $checkinUrl);
        }

        return view('staff.checkin_station', compact('checkinUrl', 'localIp'));
    }

    /**
     * Giao diện nhập Email xác thực dành cho khách hàng
     */
    public function showVerifyForm()
    {
        return view('checkin.verify');
    }

    /**
     * Xử lý xác thực Email và Gói tập
     */
    public function processVerify(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // 1. Tìm User
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email không tồn tại trong hệ thống.'
            ], 404);
        }

        // 2. Kiểm tra gói tập active
        $subscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>=', now()->toDateString())
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có gói tập nào đang hoạt động hoặc gói đã hết hạn.'
            ], 403);
        }

        // 3. Lưu lịch sử điểm danh
        DB::table('checkins')->insert([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'qr_token' => bin2hex(random_bytes(16)),
            'expires_at' => now()->addMinutes(1),
            'checked_in_at' => now(),
            'status' => 'used',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Điểm danh thành công! Chào mừng ' . $user->name,
            'user' => [
                'name' => $user->name,
                'avatar' => $user->avatar_url ?? '/images/default-avatar.png'
            ]
        ]);
    }

    /**
     * Lấy danh sách điểm danh gần nhất (API cho trang Staff)
     */
    public function getRecentCheckins()
    {
        $recent = DB::table('checkins')
            ->join('users', 'checkins.user_id', '=', 'users.id')
            ->select('users.name', 'users.avatar_url', 'checkins.checked_in_at')
            ->orderByDesc('checkins.checked_in_at')
            ->limit(5)
            ->get();

        return response()->json($recent);
    }
}
