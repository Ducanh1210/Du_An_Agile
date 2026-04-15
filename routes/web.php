<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lien-he', [HomeController::class, 'contact'])->name('contact');
Route::get('/tin-tuc', [HomeController::class, 'news'])->name('news');  
Route::get('/tin-tuc/{id}', [HomeController::class, 'newsDetail'])->name('news.detail');
Route::get('/huan-luyen-vien', [HomeController::class, 'trainers'])->name('trainers');
Route::get('/lich-lop', [HomeController::class, 'schedule'])->name('schedule');
Route::get('/goi-tap', [HomeController::class, 'memberships'])->name('client.memberships');

// Dashboard Redirect Logic
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->role === 'trainer') {
        return redirect()->route('trainer.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// Dashboard & Admin Management
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');

    // Quản lý Gói tập
    Route::prefix('memberships')->name('memberships.')->group(function () {
        Route::get('/', [\App\Http\Controllers\MembershipController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\MembershipController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\MembershipController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\MembershipController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [\App\Http\Controllers\MembershipController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [\App\Http\Controllers\MembershipController::class, 'delete'])->name('delete');
    });

    Route::controller(\App\Http\Controllers\AdminUserController::class)
        ->name('users.')
        ->prefix('users')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::patch('/toggle-status/{id}', 'toggleStatus')->name('toggleStatus');
        });

    Route::controller(\App\Http\Controllers\EquipmentController::class)
        ->name('equipments.')
        ->prefix('equipments')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

    // Quản lý Lịch lớp (Tách file riêng)
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'schedules'])->name('index');
        Route::get('/create', [\App\Http\Controllers\AdminController::class, 'createSchedule'])->name('create');
        Route::post('/store', [\App\Http\Controllers\AdminController::class, 'storeSchedule'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\AdminController::class, 'editSchedule'])->name('edit');
        Route::put('/update/{id}', [\App\Http\Controllers\AdminController::class, 'updateSchedule'])->name('update');
        Route::delete('/delete/{id}', [\App\Http\Controllers\AdminController::class, 'deleteSchedule'])->name('delete');
    });
});

// Trainer Portal Routes
Route::middleware(['auth', 'trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\TrainerController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [\App\Http\Controllers\TrainerController::class, 'students'])->name('students');
    Route::get('/students/{id}', [\App\Http\Controllers\TrainerController::class, 'studentDetail'])->name('student.detail');
    
    // Actions
    Route::post('/bookings/{id}/check-in', [\App\Http\Controllers\TrainerController::class, 'checkIn'])->name('booking.checkin');
    Route::post('/students/{id}/metrics', [\App\Http\Controllers\TrainerController::class, 'updateMetrics'])->name('student.metrics');
    Route::post('/bookings/{id}/report', [\App\Http\Controllers\TrainerController::class, 'submitReport'])->name('booking.report');
    Route::post('/bookings/{id}/reschedule', [\App\Http\Controllers\TrainerController::class, 'requestReschedule'])->name('booking.reschedule');
});

// User Profile Routes (Breeze default)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Personal Schedule & Booking Logic
    Route::get('/lich-ca-nhan', [\App\Http\Controllers\HomeController::class, 'personalSchedule'])->name('personal.schedule');
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/thong-bao', [\App\Http\Controllers\HomeController::class, 'notifications'])->name('notifications.index');
    Route::post('/reschedule/{id}/respond', [\App\Http\Controllers\HomeController::class, 'respondToReschedule'])->name('reschedule.respond');
});

// Client Profile, Subscription & Calendar Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/ho-so', [ClientProfileController::class, 'profile'])->name('client.profile');
    Route::put('/ho-so', [ClientProfileController::class, 'updateProfile'])->name('client.profile.update');
    Route::put('/ho-so/doi-mat-khau', [ClientProfileController::class, 'updatePassword'])->name('client.profile.password');
    Route::get('/goi-dang-ky', [ClientProfileController::class, 'subscriptions'])->name('client.subscriptions');
    Route::post('/goi-dang-ky/{id}/gia-han', [ClientProfileController::class, 'renewSubscription'])->name('client.subscription.renew');
    Route::post('/goi-dang-ky/{id}/huy', [ClientProfileController::class, 'cancelSubscription'])->name('client.subscription.cancel');
    Route::get('/lich-ca-nhan', [ClientProfileController::class, 'calendar'])->name('client.calendar');

    // VNPay Payment Routes (Checkout & initiate payment require auth)
    Route::get('/thanh-toan', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/thanh-toan/vnpay', [\App\Http\Controllers\PaymentController::class, 'createPayment'])->name('payment.vnpay');
});

// VNPay Callback - MUST be public (cross-site redirect from VNPay can drop session cookies)
Route::get('/thanh-toan/callback', [\App\Http\Controllers\PaymentController::class, 'vnpayReturn'])->name('payment.callback');

// Password Reset OTP Routes
Route::controller(PasswordResetController::class)->group(function () {
    Route::post('/otp/send', 'sendOtp')->name('otp.send');
    Route::get('/otp/verify', function (\Illuminate\Http\Request $request) {
        return view('auth.verify-otp', ['email' => $request->email]); 
    })->name('otp.verify.form');
    Route::post('/otp/verify', 'verifyOtp')->name('otp.verify.process');
    Route::get('/password/reset/final', function (\Illuminate\Http\Request $request) {
        return view('auth.reset-password-final', [
            'email' => $request->email,
            'otp' => $request->otp
        ]); 
    })->name('password.reset.final');
    Route::post('/password/reset/final', 'resetPassword')->name('password.update.final');
});

require __DIR__.'/auth.php';

?>