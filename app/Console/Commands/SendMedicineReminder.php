<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pasien;
use App\Notifications\MedicineReminderNotification;

class SendMedicineReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-medicine-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send medicine reminder notification to active patients via WebPush';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to send medicine reminders...');

        // Ambil pasien yang statusnya hidup dan mungkin punya user login
        $pasiens = Pasien::with('user')->where('status_pasien', 'Hidup')->get();
        $count = 0;

        foreach ($pasiens as $pasien) {
            // Kita hanya kirim jika pasien terhubung ke User dan user tsb memiliki endpoint Push Subscription
            if ($pasien->user && $pasien->user->pushSubscriptions()->exists()) {
                $pasien->user->notify(new MedicineReminderNotification());
                $count++;
            }
        }

        $this->info("Successfully sent reminder to $count patients.");
    }
}
