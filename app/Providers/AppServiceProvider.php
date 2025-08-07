<?php

namespace App\Providers;

use App\Models\Follow;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user_id = Auth::id();
            
            $pendingCount = Follow::where('following_id', $user_id)
                ->where('status', Follow::STATUS_PENDING)
                ->count();

            $followRequests = Follow::where('following_id', $user_id)
                ->where('status', Follow::STATUS_PENDING)
                ->get();

            $messageNotificationCount = Message::where('receiver_id', $user_id)
                ->where('is_read', false)
                ->count();

            $compact = [
                'pendingCount' => $pendingCount,
                'followRequests' => $followRequests,
                'messageNotificationCount' => $messageNotificationCount
            ];
            $view->with($compact);
        });
    }
}
