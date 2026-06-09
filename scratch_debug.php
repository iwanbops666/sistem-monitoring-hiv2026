<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pasien;
use App\Models\KartuKendali;

echo "Total Pasien: " . Pasien::count() . "\n";
echo "Active: " . Pasien::get()->filter(fn($p) => $p->display_status == 'Active')->count() . "\n";
echo "Inactive: " . Pasien::get()->filter(fn($p) => $p->display_status == 'Inactive')->count() . "\n";
echo "LTFU: " . Pasien::get()->filter(fn($p) => $p->display_status == 'LTFU')->count() . "\n";

$p = Pasien::where('status_pasien', '!=', 'Meninggal')->first();
if ($p) {
    echo "Sample Pasien: " . $p->nama . "\n";
    echo "Created At: " . $p->created_at . "\n";
    echo "Last Visit: " . ($p->tanggal_kunjungan_terakhir ?? 'NULL') . "\n";
    echo "Status: " . $p->display_status . "\n";
}
