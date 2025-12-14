<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use GuzzleHttp\Middleware;

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/account-settings/account', function () {
    return view('pages.account-settings.account');
})->middleware('auth')->name('account.settings.account');

Route::get('/account-settings/notifications', function () {
    return view('pages.account-settings.notifications');
})->middleware('auth')->name('account.settings.notifications');

Route::get('/account-settings/connections', function () {
    return view('pages.account-settings.connections');
})->middleware('auth')->name('account.settings.connections');

Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('auth.login.submit');

    Route::get('register', [RegisterController::class, 'showForm'])->name('auth.register');
    Route::post('register', [RegisterController::class, 'register'])->name('auth.register.submit');

    Route::get('forgot-password', [ForgotPasswordController::class, 'showForm'])->name('auth.forgotpass');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('auth.forgotpass.submit');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});
