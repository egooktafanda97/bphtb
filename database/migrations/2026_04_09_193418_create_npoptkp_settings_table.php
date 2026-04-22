<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('npoptkp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_perolehan');
            $table->decimal('nilai_npoptkp', 15, 2);
            $table->year('tahun');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['jenis_perolehan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('npoptkp_settings');
    }
};
