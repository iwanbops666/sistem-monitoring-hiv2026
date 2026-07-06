<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:send-medicine-reminder')->dailyAt('09:35');
Schedule::command('app:send-kontrol-reminder')->weeklyOn(1, '09:00');
Schedule::command('app:send-viral-load-reminder')->dailyAt('08:00');
