<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_permohonan')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('ppat_id')->nullable()->constrained('users');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->string('jenis_perolehan');
            $table->string('status')->default('draft');

            // Objek Pajak
            $table->string('nop', 30)->nullable();
            $table->text('letak_tanah_alamat');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->decimal('luas_tanah', 12, 2);
            $table->decimal('luas_bangunan', 12, 2)->default(0);

            // Nilai Pajak
            $table->decimal('njop_tanah_per_m2', 15, 2)->default(0);
            $table->decimal('njop_bangunan_per_m2', 15, 2)->default(0);
            $table->decimal('total_njop_tanah', 15, 2)->default(0);
            $table->decimal('total_njop_bangunan', 15, 2)->default(0);
            $table->decimal('total_njop', 15, 2)->default(0);
            $table->decimal('npop', 15, 2)->default(0);
            $table->decimal('npoptkp', 15, 2)->default(0);
            $table->decimal('npop_kena_pajak', 15, 2)->default(0);
            $table->decimal('bphtb_terutang', 15, 2)->default(0);

            // Pihak Pembeli (Wajib Pajak)
            $table->string('nama_wajib_pajak');
            $table->string('nik_wajib_pajak', 16);
            $table->text('alamat_wajib_pajak');

            // Pihak Penjual
            $table->string('nama_penjual');
            $table->string('nik_penjual', 16)->nullable();
            $table->text('alamat_penjual')->nullable();

            // Akta
            $table->string('no_akta')->nullable();
            $table->date('tanggal_akta')->nullable();
            $table->string('nama_ppat_akta')->nullable();

            // Meta
            $table->date('tanggal_pengajuan')->nullable();
            $table->date('tanggal_verifikasi')->nullable();
            $table->text('catatan_verifikasi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};
