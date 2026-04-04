<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipController;
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
});

// User Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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