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
            $table->string('status_kunjungan')->default('Active')->after('status_pasien');
        });

        // Initial Sync
        $pasiens = \App\Models\Pasien::all();
        foreach ($pasiens as $pasien) {
            $pasien->update([
                'status_kunjungan' => $pasien->display_status // This will use the accessor logic to set initial value
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('status_kunjungan');
        });
    }
};
