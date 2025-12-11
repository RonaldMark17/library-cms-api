<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentSectionController;
use App\Http\Controllers\StaffMemberController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ExternalLinkController;
use App\Http\Controllers\GuestSubscriberController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Dashboard stats
Route::get('/dashboard-stats', function () {
    return response()->json([
        'users' => \App\Models\User::count(),
        'announcements' => \App\Models\Announcement::count(),
        'staff' => \App\Models\StaffMember::count(),
    ]);
});

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-2fa', [AuthController::class, 'verify2FA']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

// Guest subscribers
Route::post('/subscribe', [GuestSubscriberController::class, 'subscribe']);
Route::post('/verify-subscription', [GuestSubscriberController::class, 'verify']);
Route::post('/unsubscribe', [GuestSubscriberController::class, 'unsubscribe']);

// Protected translator
Route::post('/translate', [TranslationController::class, 'translate'])
    ->middleware('auth:sanctum');

// Public content
Route::get('/content-sections', [ContentSectionController::class, 'index']);
Route::get('/content-sections/{key}', [ContentSectionController::class, 'show']);

Route::get('/staff-members', [StaffMemberController::class, 'index']);
Route::get('/staff-members/{id}', [StaffMemberController::class, 'show']);

Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/announcements/{id}', [AnnouncementController::class, 'show']);

Route::get('/menu-items', [MenuItemController::class, 'index']);

Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);

Route::get('/external-links', [ExternalLinkController::class, 'index']);

Route::get('/settings', [SettingController::class, 'index']);

Route::get('/search', [SearchController::class, 'search']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Auth/session
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/enable-2fa', [AuthController::class, 'enable2FA']);
    Route::post('/disable-2fa', [AuthController::class, 'disable2FA']);

    /*
    |--------------------------------------------------------------------------
    | Admin + Librarian routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,librarian')->group(function () {

        // Content sections
        Route::post('/content-sections', [ContentSectionController::class, 'store']);
        Route::put('/content-sections/{id}', [ContentSectionController::class, 'update']);
        Route::delete('/content-sections/{id}', [ContentSectionController::class, 'destroy']);
        Route::post('/content-sections/{id}/restore', [ContentSectionController::class, 'restore']);

        // Staff members
        Route::post('/staff-members', [StaffMemberController::class, 'store']);
        Route::put('/staff-members/{id}', [StaffMemberController::class, 'update']);
        Route::delete('/staff-members/{id}', [StaffMemberController::class, 'destroy']);
        Route::post('/staff-members/{id}/restore', [StaffMemberController::class, 'restore']);

        // Announcements
        Route::post('/announcements', [AnnouncementController::class, 'store']);
        Route::put('/announcements/{id}', [AnnouncementController::class, 'update']);
        Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy']);
        Route::post('/announcements/{id}/restore', [AnnouncementController::class, 'restore']);

        // Menu items
        Route::post('/menu-items', [MenuItemController::class, 'store']);
        Route::put('/menu-items/{id}', [MenuItemController::class, 'update']);
        Route::delete('/menu-items/{id}', [MenuItemController::class, 'destroy']);
        Route::post('/menu-items/{id}/restore', [MenuItemController::class, 'restore']);
        Route::post('/menu-items/reorder', [MenuItemController::class, 'reorder']);

        // Pages
        Route::post('/pages', [PageController::class, 'store']);
        Route::put('/pages/{id}', [PageController::class, 'update']);
        Route::delete('/pages/{id}', [PageController::class, 'destroy']);
        Route::post('/pages/{id}/restore', [PageController::class, 'restore']);

        // External links
        Route::post('/external-links', [ExternalLinkController::class, 'store']);
        Route::put('/external-links/{id}', [ExternalLinkController::class, 'update']);
        Route::delete('/external-links/{id}', [ExternalLinkController::class, 'destroy']);
        Route::post('/external-links/{id}/restore', [ExternalLinkController::class, 'restore']);

        /*
        |--------------------------------------------------------------------------
        | Users – Admin + Librarian (full management except delete)
        |--------------------------------------------------------------------------
        */
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::patch('/users/{id}/toggle-disable', [UserController::class, 'toggleDisable']);
    });

    /*
    |--------------------------------------------------------------------------
    | Admin-only routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::put('/settings/{key}', [SettingController::class, 'update']);
        Route::post('/settings/bulk', [SettingController::class, 'bulkUpdate']);
        Route::get('/subscribers', [GuestSubscriberController::class, 'index']);
    });
});
