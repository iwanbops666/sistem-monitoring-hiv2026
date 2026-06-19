<?php
$pasiens = App\Models\Pasien::limit(10)->get(['nama', 'tanggal_awal_pengobatan']);
foreach($pasiens as $p) {
    echo $p->nama . ' : ' . \Carbon\Carbon::parse($p->tanggal_awal_pengobatan)->diffInMonths(now()) . " months\n";
}
