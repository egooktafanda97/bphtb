<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update NJOP table: replace string kecamatan/kelurahan with codes
        Schema::table('njop', function (Blueprint $table) {
            $table->dropUnique(['kecamatan', 'kelurahan', 'tahun']);

            $table->char('province_code', 2)->nullable()->after('id');
            $table->char('city_code', 4)->nullable()->after('province_code');
            $table->char('district_code', 7)->nullable()->after('city_code');
            $table->char('village_code', 10)->nullable()->after('district_code');

            $table->unique(['village_code', 'tahun']);
        });

        // Update Permohonan table: add address code columns
        Schema::table('permohonan', function (Blueprint $table) {
            $table->char('province_code', 2)->nullable()->after('kecamatan');
            $table->char('city_code', 4)->nullable()->after('province_code');
            $table->char('district_code', 7)->nullable()->after('city_code');
            $table->char('village_code', 10)->nullable()->after('district_code');
        });
    }

    public function down(): void
    {
        Schema::table('njop', function (Blueprint $table) {
            $table->dropUnique(['village_code', 'tahun']);
            $table->dropColumn(['province_code', 'city_code', 'district_code', 'village_code']);
            $table->unique(['kecamatan', 'kelurahan', 'tahun']);
        });

        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn(['province_code', 'city_code', 'district_code', 'village_code']);
        });
    }
};
