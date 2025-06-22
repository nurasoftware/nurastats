<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AnalyticsController as AnalyticsController;

Route::post('analytic-event', [AnalyticsController::class, 'analytic'])->name('event.analytic');
Route::post('time-event', [AnalyticsController::class, 'time_event'])->name('event.time');
Route::post('track-event', [AnalyticsController::class, 'track_event'])->name('event.track');
