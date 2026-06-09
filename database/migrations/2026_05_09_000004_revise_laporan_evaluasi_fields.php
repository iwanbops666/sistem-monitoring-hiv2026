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
        Schema::table('laporan_evaluasi', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_evaluasi', 'standar_lain')) {
                $table->renameColumn('standar_lain', 'hasil_arv_terakhir');
            }
            $table->integer('jumlah_cd4')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_evaluasi', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_evaluasi', 'hasil_arv_terakhir')) {
                $table->renameColumn('hasil_arv_terakhir', 'standar_lain');
            }
            $table->string('jumlah_cd4')->nullable()->change();
        });
    }
};
