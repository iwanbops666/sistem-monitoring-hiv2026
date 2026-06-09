<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['layouts.app', 'layouts.pasien', 'layouts.keluarga', 'petugas.dashboard', 'pasien.dashboard', 'keluarga.dashboard'], function ($view) {
            if (Auth::check()) {
                $notifications = Notifikasi::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->latest()
                    ->get();
                $view->with('global_notifications', $notifications);
            }
        });
    }
}
