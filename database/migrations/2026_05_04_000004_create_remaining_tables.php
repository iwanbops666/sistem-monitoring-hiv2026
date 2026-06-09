<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kartu_kendali', function (Blueprint $table) {
            $table->id('id_kartu_kendali');
            $table->foreignId('id_pasien')->constrained('pasien', 'user_id')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('petugas', 'user_id')->onDelete('cascade');
            $table->date('tanggal_kunjungan')->nullable();
            $table->date('rencana_tanggal_kunjungan_selanjutnya')->nullable();
            $table->text('rejimen_dan_jumlah_obat_arv_yang_tersisa')->nullable();
            $table->text('jumlah_inh_yang_tersisa')->nullable();
            $table->text('jumlah_inh_yang_diberikan_untuk_bulan_berikutnya')->nullable();
            $table->text('efek_samping_dan_lab_profilaksis')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('laporan_evaluasi', function (Blueprint $table) {
            $table->id('id_laporan_evaluasi');
            $table->foreignId('id_pasien')->constrained('pasien', 'user_id')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('petugas', 'user_id')->onDelete('cascade');
            $table->string('kunjungan')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('standar_klinis')->nullable();
            $table->text('standar_lain')->nullable();
            $table->text('status_fungsional')->nullable();
            $table->string('jumlah_cd4')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('data_pengobatan', function (Blueprint $table) {
            $table->id('id_pengobatan');
            $table->foreignId('id_pasien')->constrained('pasien', 'user_id')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('petugas', 'user_id')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->string('status_viral_load')->nullable();
            $table->timestamps();
        });

        Schema::create('registrasi_pasien', function (Blueprint $table) {
            $table->id('id_registrasi');
            $table->foreignId('id_petugas')->constrained('petugas', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('data_pasien', function (Blueprint $table) {
            $table->id('id_data_pasien');
            $table->foreignId('id_pasien')->constrained('pasien', 'user_id')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('petugas', 'user_id')->onDelete('cascade');
            $table->timestamp('akses_dibuat_pada')->useCurrent();
            $table->timestamps();
        });

        Schema::create('kepatuhan_pengobatan', function (Blueprint $table) {
            $table->id('id_kepatuhan');
            $table->foreignId('id_pasien')->constrained('pasien', 'user_id')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('petugas', 'user_id')->onDelete('cascade');
            $table->timestamp('akses_dibuat_pada')->useCurrent();
            $table->date('tanggal_kunjungan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_petugas')->constrained('petugas', 'user_id')->onDelete('cascade');
            $table->string('jenis_laporan')->nullable();
            $table->string('periode')->nullable();
            $table->date('dari_tanggal')->nullable();
            $table->date('sampai_tanggal')->nullable();
            $table->timestamps();
        });

        Schema::create('kontak', function (Blueprint $table) {
            $table->id('id_kontak');
            $table->string('nama');
            $table->string('email');
            $table->string('no_telpon')->nullable();
            $table->text('alamat')->nullable();
            $table->text('pesan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_kendali');
        Schema::dropIfExists('laporan_evaluasi');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('data_pengobatan');
        Schema::dropIfExists('registrasi_pasien');
        Schema::dropIfExists('data_pasien');
        Schema::dropIfExists('kepatuhan_pengobatan');
        Schema::dropIfExists('laporan');
        Schema::dropIfExists('kontak');
    }
};
