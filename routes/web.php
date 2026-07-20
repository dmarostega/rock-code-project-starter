<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\GrowthEventController;
use App\Http\Controllers\MediaAssetController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeoController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::post('/growth/events', [GrowthEventController::class, 'store'])->middleware('throttle:120,1')->name('growth.events.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthPageController::class, 'login'])->name('login');
    Route::get('/register', [AuthPageController::class, 'register'])->name('register');
    Route::get('/forgot-password', [AuthPageController::class, 'forgotPassword'])->name('password.request');
    Route::get('/reset-password/{token}', [AuthPageController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/media', [MediaAssetController::class, 'store'])->name('media.store');
    Route::delete('/media/{mediaAsset}', [MediaAssetController::class, 'destroy'])->name('media.destroy');
});

Route::get('/admin', AdminDashboardController::class)
    ->middleware(['auth', EnsureUserIsAdmin::class])
    ->name('admin.dashboard');
