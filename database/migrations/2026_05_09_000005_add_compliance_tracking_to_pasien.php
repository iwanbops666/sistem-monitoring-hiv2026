<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            // Add columns to track compliance more effectively in DB
            $table->date('tanggal_kunjungan_terakhir')->nullable()->after('status_pasien');
            $table->date('rencana_kunjungan_berikutnya')->nullable()->after('tanggal_kunjungan_terakhir');
        });

        // Backfill data
        $pasiens = DB::table('pasien')->get();
        foreach ($pasiens as $pasien) {
            $lastKartu = DB::table('kartu_kendali')
                ->where('id_pasien', $pasien->user_id)
                ->orderBy('tanggal_kunjungan', 'desc')
                ->first();

            if ($lastKartu) {
                DB::table('pasien')->where('user_id', $pasien->user_id)->update([
                    'tanggal_kunjungan_terakhir' => $lastKartu->tanggal_kunjungan,
                    'rencana_kunjungan_berikutnya' => $lastKartu->rencana_tanggal_kunjungan_selanjutnya,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn(['tanggal_kunjungan_terakhir', 'rencana_kunjungan_berikutnya']);
        });
    }
};
