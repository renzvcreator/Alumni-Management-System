<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // Feed the navigation bar its unread badges and recent notifications.
        View::composer('layouts.navigation', function ($view) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();

            if (! $user) {
                return;
            }

            $view->with([
                'navUnreadCount' => $user->unreadNotifications()->count(),
                'navUnreadMessages' => Message::where('recipient_id', $user->id)
                    ->whereNull('read_at')
                    ->count(),
                'navRecentNotifications' => $user->appNotifications()->limit(8)->get(),
            ]);
        });
    }
}
