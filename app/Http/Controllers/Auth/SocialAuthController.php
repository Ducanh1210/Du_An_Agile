<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
    /**
     * Redirect to social provider (Google, Facebook, etc.)
     * This is a stub — configure Socialite in config/services.php to enable.
     */
    public function redirectToProvider($provider)
    {
        // Guard: only allow supported providers
        $supported = ['google', 'facebook'];

        if (!in_array($provider, $supported)) {
            return redirect()->route('login')
                ->with('error', 'Nhà cung cấp đăng nhập không được hỗ trợ: ' . $provider);
        }

        if (!class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            Log::warning('SocialAuthController: Laravel Socialite is not installed.');
            return redirect()->route('login')
                ->with('error', 'Tính năng đăng nhập mạng xã hội chưa được cấu hình.');
        }

        return \Laravel\Socialite\Facades\Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from social provider.
     */
    public function handleProviderCallback($provider)
    {
        if (!class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            return redirect()->route('login')
                ->with('error', 'Tính năng đăng nhập mạng xã hội chưa được cấu hình.');
        }

        try {
            $socialUser = \Laravel\Socialite\Facades\Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error('Social login failed: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Đăng nhập thất bại. Vui lòng thử lại.');
        }

        // Find or create user
        $user = \App\Models\User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name'              => $socialUser->getName(),
                'password'          => bcrypt(\Illuminate\Support\Str::random(16)),
                'email_verified_at' => now(),
            ]
        );

        auth()->login($user, true);

        return redirect()->intended('/');
    }
}
