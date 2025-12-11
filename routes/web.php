<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestSubscriberController;

Route::get('/verify-subscription', [GuestSubscriberController::class, 'verify'])
     ->name('verify.subscription');

Route::get('/unsubscribe', [GuestSubscriberController::class, 'unsubscribeView'])->name('unsubscribe.view');