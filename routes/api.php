<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ContentSectionController,
    AnnouncementController,
    MenuItemController,
    PageController,
    ExternalLinkController,
    GuestSubscriberController,
    SettingController,
    UserController,
    SearchController,
    TranslationController,
    ForgotPasswordController
};

/*
|--------------------------------------------------------------------------
| Public Routes (No Auth Required)
|--------------------------------------------------------------------------
*/

// Dashboard stats
Route::get('/dashboard-stats', function () {
    return response()->json([
        'users' => \App\Models\User::count(),
        'announcements' => \App\Models\Announcement::count(),
    ]);
});

// Authentication
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-2fa', [AuthController::class, 'verify2FA']);

// Guest Subscribers
Route::post('/subscribe', [GuestSubscriberController::class, 'subscribe']);
Route::get('/verify-subscription', [GuestSubscriberController::class, 'verify']); // Use GET for link verification
Route::get('/unsubscribe', [GuestSubscriberController::class, 'unsubscribeView']);
Route::post('/unsubscribe', [GuestSubscriberController::class, 'unsubscribe']);

// Public Content
Route::get('/content-sections', [ContentSectionController::class, 'index']);
Route::get('/content-sections/{key}', [ContentSectionController::class, 'show']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
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

    // Session / Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/enable-2fa', [AuthController::class, 'enable2FA']);
    Route::post('/disable-2fa', [AuthController::class, 'disable2FA']);

    // User profile (self-update)
    Route::post('/users/{id}', [UserController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | Admin + Librarian Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,librarian')->group(function () {

        // Users management
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::patch('/users/{id}/toggle-disable', [UserController::class, 'toggleDisable']);

        // Content Sections
        Route::post('/content-sections', [ContentSectionController::class, 'store']);
        Route::put('/content-sections/{id}', [ContentSectionController::class, 'update']);
        Route::delete('/content-sections/{id}', [ContentSectionController::class, 'destroy']);
        Route::post('/content-sections/{id}/restore', [ContentSectionController::class, 'restore']);

        // Announcements
        Route::post('/announcements', [AnnouncementController::class, 'store']);
        Route::put('/announcements/{id}', [AnnouncementController::class, 'update']);
        Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy']);
        Route::post('/announcements/{id}/restore', [AnnouncementController::class, 'restore']);

        // Menu Items
        Route::post('/menu-items', [MenuItemController::class, 'store']);
        Route::put('/menu-items/{id}', [MenuItemController::class, 'update']);
        Route::delete('/menu-items/{id}', [MenuItemController::class, 'destroy']);
        Route::patch('/menu-items/toggle-active/{id}', [MenuItemController::class, 'toggleActive']);
        Route::post('/menu-items/{id}/restore', [MenuItemController::class, 'restore']);
        Route::post('/menu-items/reorder', [MenuItemController::class, 'reorder']);

        // Pages
        Route::post('/pages', [PageController::class, 'store']);
        Route::put('/pages/{id}', [PageController::class, 'update']);
        Route::delete('/pages/{id}', [PageController::class, 'destroy']);
        Route::post('/pages/{id}/restore', [PageController::class, 'restore']);

        // External Links
        Route::post('/external-links', [ExternalLinkController::class, 'store']);
        Route::put('/external-links/{id}', [ExternalLinkController::class, 'update']);
        Route::delete('/external-links/{id}', [ExternalLinkController::class, 'destroy']);
        Route::post('/external-links/{id}/restore', [ExternalLinkController::class, 'restore']);
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::put('/settings/{key}', [SettingController::class, 'update']);
        Route::post('/settings/bulk', [SettingController::class, 'bulkUpdate']);
        Route::get('/subscribers', [GuestSubscriberController::class, 'index']);
    });

    // Translation (Protected)
    Route::post('/translate', [TranslationController::class, 'translate']);
});
