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
        // 1. Tự động lấy địa chỉ IP thực của máy tính trong mạng WiFi/LAN
        $localIp = request('manual_ip') ?: '127.0.0.1';
        
        if ($localIp === '127.0.0.1') {
            $hostname = gethostname();
            $ips = gethostbynamel($hostname);
            $localIps = [];

            if ($ips) {
                foreach ($ips as $ip) {
                    if (preg_match('/^(192\.168\.|10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.)/', $ip)) {
                        $localIps[] = $ip;
                    }
                }
            }
            
            $localIp = !empty($localIps) ? $localIps[0] : '127.0.0.1';
        }

        // Tạo UUID duy nhất cho phiên quét này
        $qrUuid = \Illuminate\Support\Str::uuid()->toString();
        // Lưu vào cache trong 15 giây (khớp với thời gian refresh trên giao diện)
        \Illuminate\Support\Facades\Cache::put('qr_token_' . $qrUuid, true, now()->addSeconds(20)); // Cho thêm 5s bù trừ độ trễ mạng

        // 2. Tạo đường dẫn quét QR dựa trên IP nội bộ
        $checkinUrl = route('checkin.verify', ['uuid' => $qrUuid], true);
        
        // Lấy port hiện tại nếu có (ví dụ :8000)
        $currentPort = parse_url(url()->current(), PHP_URL_PORT);
        $portSuffix = $currentPort ? ':' . $currentPort : '';

        // Thay thế localhost/127.0.0.1 bằng IP thực + Port
        $checkinUrl = str_replace(['localhost', '127.0.0.1', '::1'], $localIp, $checkinUrl);
        
        // Đảm bảo URL có port nếu đang chạy qua artisan serve
        if ($currentPort && !str_contains($checkinUrl, ':' . $currentPort)) {
            $checkinUrl = str_replace($localIp, $localIp . ':' . $currentPort, $checkinUrl);
        }

        // 3. Kiểm tra Tunnel (nếu có) - Ưu tiên Tunnel nếu muốn dùng qua 4G
        $tunnelFile = base_path('tunnel_url.txt');
        if (file_exists($tunnelFile)) {
            $content = file_get_contents($tunnelFile);
            if (preg_match('/https:\/\/[^\s]+/', $content, $matches)) {
                $checkinUrl = rtrim($matches[0], '/') . '/checkin/verify';
                $localIp = "Internet Tunnel (Public)";
            }
        }

        \Illuminate\Support\Facades\Log::info("QR Checkin URL Generated", [
            'ip' => $localIp,
            'url' => $checkinUrl,
            'port' => $currentPort
        ]);

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
            'email' => 'required|email',
            'uuid' => 'required'
        ]);

        $uuid = $request->uuid;

        // Kiểm tra mã QR còn hiệu lực không
        if (!\Illuminate\Support\Facades\Cache::has('qr_token_' . $uuid)) {
            return response()->json([
                'success' => false,
                'message' => 'Mã QR đã hết hạn hoặc đã được sử dụng. Vui lòng quét mã mới.'
            ], 410); // Gone
        }

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

        // 4. Vô hiệu hóa mã QR ngay lập tức sau khi dùng
        \Illuminate\Support\Facades\Cache::forget('qr_token_' . $uuid);

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
