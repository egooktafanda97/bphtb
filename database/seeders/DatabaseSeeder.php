<?php

namespace Database\Seeders;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Laravolt\Indonesia\Models\Province;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Admin Bapenda',
            'email' => 'admin@bphtb.test',
        ]);

        // 2. Create PPAT user
        $ppat = User::factory()->ppat()->create([
            'name' => 'Notaris Ahmad',
            'email' => 'ppat@bphtb.test',
        ]);

        // 3. Create Wajib Pajak users
        $wp1 = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@bphtb.test',
        ]);

        $wp2 = User::factory()->create([
            'name' => 'Siti Aminah',
            'email' => 'siti@bphtb.test',
        ]);

        // 4. Seed master data
        if (Province::count() === 0) {
            $this->command->info('Seeding Laravolt Indonesia (this will take a minute)...');
            Artisan::call('laravolt:indonesia:seed');
        }

        $this->call([
            NjopSeeder::class,
            NpoptkpSettingSeeder::class,
        ]);

        // 5. Create sample permohonan in various statuses
        Permohonan::factory()
            ->for($wp1, 'pemohon')
            ->diajukan()
            ->create(['nomor_permohonan' => 'BPHTB/2026/001']);

        Permohonan::factory()
            ->for($wp2, 'pemohon')
            ->for($ppat, 'ppat')
            ->diverifikasi()
            ->create(['nomor_permohonan' => 'BPHTB/2026/002']);

        Permohonan::factory()
            ->for($wp1, 'pemohon')
            ->disetujui()
            ->create(['nomor_permohonan' => 'BPHTB/2026/003']);

        Permohonan::factory()
            ->for($wp2, 'pemohon')
            ->ditolak()
            ->create(['nomor_permohonan' => 'BPHTB/2026/004']);

        Permohonan::factory()
            ->for($wp1, 'pemohon')
            ->create(['nomor_permohonan' => 'BPHTB/2026/005']);
    }
}
