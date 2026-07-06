<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Pasien;
use App\Notifications\ViralLoadReminderNotification;
use Carbon\Carbon;

#[Signature('app:send-viral-load-reminder')]
#[Description('Send viral load test reminder to patients and family based on 6 months and annual intervals')]
class SendViralLoadReminder extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to send Viral Load reminders...');
        
        $pasiens = Pasien::with(['user', 'keluarga.user'])->where('status_pasien', 'Hidup')->get();
        $count = 0;
        
        $today = now()->format('Y-m-d');
        
        foreach ($pasiens as $pasien) {
            // Find start date of ART
            $mulaiArt = $pasien->laporanEvaluasi()->where('kunjungan', 'Saat Mulai ART')->orderBy('tanggal', 'asc')->first();
            
            if ($mulaiArt) {
                $start = Carbon::parse($mulaiArt->tanggal);
                
                // Calculate target dates (6 months, 12 months, 24 months, etc.)
                $targetDates = [
                    $start->copy()->addMonths(6)->format('Y-m-d'),
                    $start->copy()->addMonths(12)->format('Y-m-d'),
                ];
                for ($i = 2; $i <= 20; $i++) {
                    $targetDates[] = $start->copy()->addMonths($i * 12)->format('Y-m-d');
                }
                
                if (in_array($today, $targetDates)) {
                    // Send to Pasien
                    if ($pasien->user && $pasien->user->pushSubscriptions()->exists()) {
                        $pasien->user->notify(new ViralLoadReminderNotification());
                    }
                    
                    // Send to Keluarga (PMO)
                    if ($pasien->keluarga && $pasien->keluarga->user && $pasien->keluarga->user->pushSubscriptions()->exists()) {
                        $pasien->keluarga->user->notify(new ViralLoadReminderNotification());
                    }
                    
                    $count++;
                }
            }
        }
        
        $this->info("Successfully sent Viral Load reminder for {$count} patients.");
    }
}
