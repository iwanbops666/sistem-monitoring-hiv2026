<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pasiens = App\Models\Pasien::with(['dataPengobatan', 'laporanEvaluasi'])->get();
foreach($pasiens as $p) {
    echo $p->nama . ' | ' . $p->viral_load_status . "\n";
}
