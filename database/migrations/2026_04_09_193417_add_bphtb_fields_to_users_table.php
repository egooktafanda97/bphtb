<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('wajib_pajak')->after('password');
            $table->string('nik', 16)->nullable()->after('role');
            $table->string('phone', 20)->nullable()->after('nik');
            $table->text('address')->nullable()->after('phone');
            $table->string('npwp', 25)->nullable()->after('address');
            $table->string('no_sk_ppat')->nullable()->after('npwp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nik', 'phone', 'address', 'npwp', 'no_sk_ppat']);
        });
    }
};
