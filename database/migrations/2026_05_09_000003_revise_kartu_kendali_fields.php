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
            if (!Schema::hasColumn('kartu_kendali', 'rejimen_arv')) {
                $table->string('rejimen_arv')->nullable()->after('id_petugas');
            }
            if (!Schema::hasColumn('kartu_kendali', 'jumlah_arv_tersisa')) {
                $table->integer('jumlah_arv_tersisa')->nullable()->after('rejimen_arv');
            }
            
            $table->integer('jumlah_inh_yang_tersisa')->nullable()->change();
            $table->integer('jumlah_inh_yang_diberikan_untuk_bulan_berikutnya')->nullable()->change();
            
            if (Schema::hasColumn('kartu_kendali', 'rejimen_dan_jumlah_obat_arv_yang_tersisa')) {
                $table->dropColumn('rejimen_dan_jumlah_obat_arv_yang_tersisa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kartu_kendali', function (Blueprint $table) {
            if (!Schema::hasColumn('kartu_kendali', 'rejimen_dan_jumlah_obat_arv_yang_tersisa')) {
                $table->text('rejimen_dan_jumlah_obat_arv_yang_tersisa')->nullable();
            }
            $table->dropColumn(['rejimen_arv', 'jumlah_arv_tersisa']);
            $table->text('jumlah_inh_yang_tersisa')->nullable()->change();
            $table->text('jumlah_inh_yang_diberikan_untuk_bulan_berikutnya')->nullable()->change();
        });
    }
};
