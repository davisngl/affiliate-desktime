<?php

use App\Http\Controllers\AffiliateCodeController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/referral/{affiliate:code}', AffiliateCodeController::class)
    ->middleware('guest')
    ->name('affiliate-code');

require __DIR__.'/auth.php';
