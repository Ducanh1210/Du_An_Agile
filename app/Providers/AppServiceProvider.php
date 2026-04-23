<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tự động chạy scheduler khi ở môi trường local để gửi mail/thông báo mà không cần chạy lệnh thủ công
        if (app()->environment('local')) {
            try {
                Artisan::call('schedule:run');
            } catch (\Exception $e) {
                // Bỏ qua nếu có lỗi để không làm sập trang web
            }
        }
    }
}
