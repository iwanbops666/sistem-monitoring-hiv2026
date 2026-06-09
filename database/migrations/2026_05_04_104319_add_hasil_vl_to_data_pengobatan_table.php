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
        Schema::table('data_pengobatan', function (Blueprint $table) {
            $table->integer('nilai_viral_load')->nullable()->after('status_viral_load');
            $table->string('keterangan')->nullable()->after('nilai_viral_load');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_pengobatan', function (Blueprint $table) {
            $table->dropColumn(['nilai_viral_load', 'keterangan']);
        });
    }
};
