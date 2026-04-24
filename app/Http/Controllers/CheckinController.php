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
        // 1. Sử dụng Token Cố định để làm QR vĩnh viễn (Có thể in ra)
        $qrUuid = 'permanent-checkin-token';
        // Lưu vào cache vĩnh viễn
        \Illuminate\Support\Facades\Cache::forever('qr_token_' . $qrUuid, true);

        $currentHost = request()->getHost();
        $isLocalHost = in_array($currentHost, ['localhost', '127.0.0.1', '::1']);

        // 2. Xác định Base URL (Ưu tiên Tunnel động để tránh sửa .env liên tục)
        $baseUrl = null;
        $method = "UNKNOWN";
        $tunnelFile = base_path('tunnel_url.txt');

        // Thử đọc từ file tunnel_url.txt (Do script tự động cập nhật)
        if (file_exists($tunnelFile)) {
            $content = trim(file_get_contents($tunnelFile));
            if (preg_match('/https:\/\/[^\s]+/', $content, $matches)) {
                $baseUrl = rtrim($matches[0], '/');
                $method = "TUNNEL_FILE";
            }
        }

        // Nếu không có file, thử lấy từ .env
        if (!$baseUrl && env('PUBLIC_CHECKIN_URL')) {
            $baseUrl = rtrim(env('PUBLIC_CHECKIN_URL'), '/');
            $method = "ENV_CONFIG";
        }

        // Nếu vẫn không có, lấy từ request hiện tại
        if (!$baseUrl) {
            $baseUrl = request()->getSchemeAndHttpHost();
            $method = "REQUEST_HOST";
        }

        // 3. Xử lý fallback cho Local IP (Chỉ khi đang ở localhost và không có Public URL)
        $localIp = $currentHost;
        if ($isLocalHost && $method === "REQUEST_HOST") {
            $hostname = gethostname();
            $ips = gethostbynamel($hostname);
            if ($ips) {
                foreach ($ips as $ip) {
                    if (preg_match('/^(192\.168\.|10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.)/', $ip)) {
                        $localIp = $ip;
                        $baseUrl = str_replace($currentHost, $ip, $baseUrl);
                        $method = "LOCAL_IP_FALLBACK";
                        break;
                    }
                }
            }
        }

        // 4. Tạo URL cuối cùng
        $checkinUrl = $baseUrl . '/checkin/verify?uuid=' . $qrUuid;

        \Illuminate\Support\Facades\Log::info("QR Checkin Generated", [
            'method' => $method,
            'url' => $checkinUrl,
            'staff_host' => $currentHost
        ]);

        return view('staff.checkin_station', compact('checkinUrl', 'localIp', 'method'));
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

        // 4. KHÔNG vô hiệu hóa mã QR (Để mã này có thể in ra và dùng vĩnh viễn)
        // \Illuminate\Support\Facades\Cache::forget('qr_token_' . $uuid);

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
