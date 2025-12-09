<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestSubscriberController;

Route::get('/verify-subscription', [GuestSubscriberController::class, 'verify'])
     ->name('verify.subscription');

