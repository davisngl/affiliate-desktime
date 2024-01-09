<?php

use App\Http\Controllers\AffiliateCodeController;
use App\Http\Controllers\AffiliateCodeStatisticsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/dashboard', 'dashboard')
    ->middleware('auth')
    ->name('dashboard.index');

Route::get('/referral/{affiliate:code}', AffiliateCodeController::class)
    ->middleware('guest')
    ->name('affiliate-code.show');

Route::get('/referral-statistics/{affiliate:code}', AffiliateCodeStatisticsController::class)
    ->name('affiliate-code-statistics.show');

require __DIR__.'/auth.php';
