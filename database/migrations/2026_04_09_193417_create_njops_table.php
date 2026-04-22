<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('njop', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->decimal('njop_tanah_per_m2', 15, 2)->default(0);
            $table->decimal('njop_bangunan_per_m2', 15, 2)->default(0);
            $table->year('tahun');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['kecamatan', 'kelurahan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('njop');
    }
};
