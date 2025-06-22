<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\UserController as UserController;
use App\Http\Controllers\Account\SiteController as SiteController;
use App\Http\Controllers\Account\StatsController as StatsController;
use App\Http\Controllers\Account\ReportController as ReportController;
use App\Http\Controllers\Account\EventController as EventController;
use App\Http\Controllers\Account\HealthController as HealthController;
use App\Http\Controllers\LogoutController as LogoutController;

Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('account', [SiteController::class, 'index'])->name('user');

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('admin');

Route::prefix('account')->group(function () {

    // Dashboard
    Route::get('dashboard', [CoreController::class, 'dashboard'])->name('dashboard');

    // Accounts
    Route::resource('accounts', AccountController::class)->parameters(['accounts' => 'id']);

    // Stats
    Route::get('sites/{code}/page-stats/{hash}', [StatsController::class, 'page_stats'])->name('site.page_stats')->where(['hash' => '[a-zA-Z0-9]+']);
    Route::get('sites/{code}/pages', [StatsController::class, 'pages'])->name('site.pages')->where(['code' => '[a-zA-Z0-9]+']);
    Route::get('sites/{code}/visitors', [StatsController::class, 'visitors'])->name('site.visitors')->where(['code' => '[a-zA-Z0-9]+']);
    Route::get('sites/{code}/reports', [ReportController::class, 'index'])->name('site.reports')->where(['code' => '[a-zA-Z0-9]+']);
    //Route::get('sites/{code}/live', Live::class)->name('site.live')->where(['code' => '[a-zA-Z0-9]+']);
    Route::get('sites/{code}', [StatsController::class, 'index'])->name('site.show')->where(['code' => '[a-zA-Z0-9]+']);

    // Sites
    Route::get('sites/{code}/config', [SiteController::class, 'config'])->name('site.config')->where(['code' => '[a-zA-Z0-9]+']);
    Route::put('sites/{code}', [SiteController::class, 'update'])->name('site.update')->where(['code' => '[a-zA-Z0-9]+']);
    Route::delete('sites/{code}', [SiteController::class, 'destroy'])->name('site.delete')->where(['code' => '[a-zA-Z0-9]+']);
    Route::get('sites', [SiteController::class, 'index'])->name('sites.index');
    Route::post('sites', [SiteController::class, 'store'])->name('sites.store');

    // Events
    Route::get('sites/{code}/events', [EventController::class, 'index'])->name('site.events')->where(['code' => '[a-zA-Z0-9]+']);
    Route::get('sites/{code}/events/manage', [EventController::class, 'manage'])->name('site.events.manage')->where(['code' => '[a-zA-Z0-9]+']);
    Route::get('sites/{code}/events/{event_code}', [EventController::class, 'show'])->name('site.event.show')->where(['code' => '[a-zA-Z0-9]+', 'event_code' => '[a-zA-Z0-9]+']);
    Route::get('sites/{code}/events/{event_code}/config', [EventController::class, 'config'])->name('site.event.config')->where(['code' => '[a-zA-Z0-9]+', 'event_code' => '[a-zA-Z0-9]+']);
    Route::post('sites/{code}/events', [EventController::class, 'store'])->where(['code' => '[a-zA-Z0-9]+']);
    Route::put('sites/{code}/events/{event_code}', [EventController::class, 'update'])->name('site.event.update')->where(['code' => '[a-zA-Z0-9]+', 'event_code' => '[a-zA-Z0-9]+']);
    Route::delete('sites/{code}/events/{event_code}', [EventController::class, 'destroy'])->name('site.event.delete')->where(['code' => '[a-zA-Z0-9]+', 'event_code' => '[a-zA-Z0-9]+']);

    // Health
    Route::get('sites/{code}/status-check', [HealthController::class, 'status_checker'])->name('site.status_checker')->where(['code' => '[a-zA-Z0-9]+']);
    Route::get('sites/{code}/error-pages', [HealthController::class, 'error_pages'])->name('site.error_pages')->where(['code' => '[a-zA-Z0-9]+']);

    // Subscription
    Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription');
    Route::post('subscription/store',  [SubscriptionController::class, 'store'])->name('subscription.store');

    //Route::get('/subscription/checkout',  [SubscriptionController::class, 'checkout'])->name('subscription.checkout');

    Route::post('subscription/cancel',  [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('subscription/resume',  [SubscriptionController::class, 'resume'])->name('subscription.resume');

    // Invoices
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('invoice/download/{invoice}',  [InvoiceController::class, 'download'])->name('invoice.download')->where(['invoice' => '[0-9a-zA-Z_]+']);

    // profile
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('profile', [UserController::class, 'update_profile']);
    Route::delete('profile/delete-avatar', [UserController::class, 'delete_avatar'])->name('profile.delete_avatar');

    // security
    Route::get('security', [UserController::class, 'security'])->name('security');
    Route::post('security', [UserController::class, 'update_security']);

    // Profile
    Route::get('profile', [CoreController::class, 'profile'])->name('profile');
    Route::post('profile', [CoreController::class, 'profile_update']);
    Route::delete('profile/delete-avatar', [CoreController::class, 'profile_delete_avatar'])->name('profile.delete_avatar');
});
