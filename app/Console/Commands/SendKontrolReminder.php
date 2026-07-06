<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:send-kontrol-reminder')]
#[Description('Send control (H-7) reminder notification to patients')]
class SendKontrolReminder extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to send weekly kontrol reminders...');

        $pasiens = \App\Models\Pasien::with('user')->where('status_pasien', 'Hidup')->get();
            
        $count = 0;

        foreach ($pasiens as $pasien) {
            // Only send if patient has a linked User and has a push subscription
            if ($pasien->user && $pasien->user->pushSubscriptions()->exists()) {
                $pasien->user->notify(new \App\Notifications\KontrolReminderNotification());
                $count++;
            }
        }

        $this->info("Successfully sent weekly kontrol reminder to {$count} patients.");
    }
}
