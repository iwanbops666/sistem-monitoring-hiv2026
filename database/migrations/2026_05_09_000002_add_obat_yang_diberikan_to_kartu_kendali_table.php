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
        Schema::table('kartu_kendali', function (Blueprint $table) {
            $table->text('obat_yang_diberikan')->nullable()->after('rencana_tanggal_kunjungan_selanjutnya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kartu_kendali', function (Blueprint $table) {
            $table->dropColumn('obat_yang_diberikan');
        });
    }
};
