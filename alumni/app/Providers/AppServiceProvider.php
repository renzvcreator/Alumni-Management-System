<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            $user = auth()->user();
            if ($user) {
                $unread = $user->unreadNotifications()->count();
                $recent = $user->appNotifications()->take(6)->get();
                $unreadMessages = \App\Models\Message::where('recipient_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
                $view->with('navUnreadCount', $unread);
                $view->with('navRecentNotifications', $recent);
                $view->with('navUnreadMessages', $unreadMessages);
            } else {
                $view->with('navUnreadCount', 0);
                $view->with('navRecentNotifications', collect());
                $view->with('navUnreadMessages', 0);
            }
        });
    }
}
