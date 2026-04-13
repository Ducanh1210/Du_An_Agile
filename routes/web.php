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

// Dashboard & Admin Management
Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');

    Route::controller(MembershipController::class)
        ->name('memberships.')
        ->prefix('memberships/')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

    Route::controller(\App\Http\Controllers\AdminUserController::class)
        ->name('users.')
        ->prefix('users/')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

    Route::controller(\App\Http\Controllers\EquipmentController::class)
        ->name('equipments.')
        ->prefix('equipments/')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
});

// User Profile Routes (Breeze default)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Client Profile, Subscription & Calendar Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/ho-so', [ClientProfileController::class, 'profile'])->name('client.profile');
    Route::put('/ho-so', [ClientProfileController::class, 'updateProfile'])->name('client.profile.update');
    Route::put('/ho-so/doi-mat-khau', [ClientProfileController::class, 'updatePassword'])->name('client.profile.password');
    Route::get('/goi-dang-ky', [ClientProfileController::class, 'subscriptions'])->name('client.subscriptions');
    Route::post('/goi-dang-ky/{id}/gia-han', [ClientProfileController::class, 'renewSubscription'])->name('client.subscription.renew');
    Route::post('/goi-dang-ky/{id}/dong-bang', [ClientProfileController::class, 'freezeSubscription'])->name('client.subscription.freeze');
    Route::post('/goi-dang-ky/{id}/huy', [ClientProfileController::class, 'cancelSubscription'])->name('client.subscription.cancel');
    Route::get('/lich-ca-nhan', [ClientProfileController::class, 'calendar'])->name('client.calendar');
});

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