<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileInteractionController;
use Illuminate\Support\Facades\Route;

// Public / guest-accessible pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

// Authenticated but any status (for pending users)
Route::middleware('auth')->group(function () {
    Route::get('/pending', [PageController::class, 'pending'])->name('pending');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('users/{user}/approve', [UserManagementController::class, 'approve'])->name('users.approve');
    Route::delete('users/{user}/reject', [UserManagementController::class, 'reject'])->name('users.reject');
    Route::patch('users/{user}/block', [UserManagementController::class, 'block'])->name('users.block');
    Route::patch('users/{user}/unblock', [UserManagementController::class, 'unblock'])->name('users.unblock');
    Route::delete('users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    Route::resource('announcements', AdminAnnouncementController::class)->except(['show']);

    Route::get('events/{event}/attendees', [AdminEventController::class, 'attendees'])->name('events.attendees');
    Route::patch('events/{event}/archive', [AdminEventController::class, 'archive'])->name('events.archive');
    Route::patch('events/{event}/unarchive', [AdminEventController::class, 'unarchive'])->name('events.unarchive');
    Route::resource('events', AdminEventController::class)->except(['show']);
});

// Approved alumni routes
Route::middleware(['auth', 'approved', 'role:alumni'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/directory', [DirectoryController::class, 'index'])->name('directory.index');
    Route::get('/directory/{user}', [DirectoryController::class, 'show'])->name('directory.show');

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/my-rsvps', [EventController::class, 'myRsvps'])->name('events.my-rsvps');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/rsvp', [EventController::class, 'rsvp'])->name('events.rsvp');
    Route::delete('/events/{event}/rsvp', [EventController::class, 'cancelRsvp'])->name('events.rsvp.cancel');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');

    Route::post('/profiles/{user}/like', [ProfileInteractionController::class, 'toggleLike'])->name('profiles.like');
    Route::post('/profiles/{user}/bookmark', [ProfileInteractionController::class, 'toggleBookmark'])->name('profiles.bookmark');
    Route::post('/profiles/{user}/poke', [ProfileInteractionController::class, 'poke'])->name('profiles.poke');
    Route::get('/bookmarks', [ProfileInteractionController::class, 'bookmarks'])->name('profiles.bookmarks');
    Route::get('/likes', [ProfileInteractionController::class, 'likes'])->name('profiles.likes');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

require __DIR__.'/auth.php';
