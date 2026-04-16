<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ResetPasswordFinalRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\ResetPasswordOTP;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // BƯỚC 1: Gửi mã OTP về Email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
        ]);

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp, 
                'created_at' => Carbon::now()
            ]
        );

        try {
            Mail::to($request->email)->send(new ResetPasswordOTP($otp));

            return redirect()->route('otp.verify.form', ['email' => $request->email])
                           ->with('success', 'Mã OTP đã được gửi!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Không thể gửi mail, vui lòng kiểm tra lại cấu hình!']);
        }
    }

    // BƯỚC 2: Xác thực mã OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.digits' => 'Mã OTP phải có đúng 6 chữ số.',
        ]);

        $resetRequest = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$resetRequest) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác.']);
        }

        if (Carbon::parse($resetRequest->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('password.request')->withErrors(['email' => 'Mã OTP đã hết hạn.']);
        }

        return redirect()->route('password.reset.final', [
            'email' => $request->email,
            'otp' => $request->otp
        ]);
    }

    // BƯỚC 3: Đặt lại mật khẩu mới
    public function resetPassword(ResetPasswordFinalRequest $request)
    {
        $resetRequest = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$resetRequest) {
            return redirect()->route('password.request')->withErrors(['email' => 'Yêu cầu không hợp lệ.']);
        }

        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return redirect()->route('login')->with('status', 'Mật khẩu đã được cập nhật thành công!');
        }

        return back()->withErrors(['email' => 'Có lỗi xảy ra, vui lòng thử lại.']);
    }
}
