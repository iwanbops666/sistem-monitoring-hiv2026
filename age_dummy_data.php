<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pasien;
use Carbon\Carbon;

// 1. Set 2 patients as LTFU (> 2 months)
$ltfuPasiens = Pasien::where('status_pasien', '!=', 'Meninggal')->take(2)->get();
foreach ($ltfuPasiens as $p) {
    $oldDate = Carbon::now()->subMonths(3);
    $p->update([
        'tanggal_kunjungan_terakhir' => $oldDate->format('Y-m-d'),
        'status_kunjungan' => 'LTFU',
        'created_at' => $oldDate->subDays(10)
    ]);
    echo "Set {$p->nama} as LTFU\n";
}

// 2. Set 2 patients as Inactive (> 7 days)
$inactivePasiens = Pasien::where('status_pasien', '!=', 'Meninggal')
    ->whereNotIn('user_id', $ltfuPasiens->pluck('user_id'))
    ->take(2)->get();

foreach ($inactivePasiens as $p) {
    $oldDate = Carbon::now()->subDays(10);
    $p->update([
        'tanggal_kunjungan_terakhir' => $oldDate->format('Y-m-d'),
        'status_kunjungan' => 'Inactive',
        'created_at' => $oldDate->subDays(10)
    ]);
    echo "Set {$p->nama} as Inactive\n";
}

echo "Done aging dummy data.\n";
