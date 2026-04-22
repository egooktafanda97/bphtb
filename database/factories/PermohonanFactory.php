<?php

namespace Database\Factories;

use App\Enums\JenisPerolehan;
use App\Enums\StatusPermohonan;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permohonan>
 */
class PermohonanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $luasTanah = fake()->numberBetween(100, 2000);
        $luasBangunan = fake()->numberBetween(0, 500);
        $njopTanahPerM2 = fake()->numberBetween(100000, 500000);
        $njopBangunanPerM2 = fake()->numberBetween(200000, 800000);
        $totalNjopTanah = $luasTanah * $njopTanahPerM2;
        $totalNjopBangunan = $luasBangunan * $njopBangunanPerM2;
        $totalNjop = $totalNjopTanah + $totalNjopBangunan;
        $npop = $totalNjop;
        $npoptkp = 60000000;
        $npopKenaPajak = max(0, $npop - $npoptkp);
        $bphtbTerutang = $npopKenaPajak * 0.05;

        return [
            'nomor_permohonan' => 'BPHTB/'.date('Y').'/'.fake()->unique()->numerify('###'),
            'user_id' => User::factory(),
            'ppat_id' => null,
            'verified_by' => null,
            'jenis_perolehan' => fake()->randomElement(JenisPerolehan::cases()),
            'status' => StatusPermohonan::Draft,
            'nop' => fake()->numerify('14.02.###.###.###-####.#'),
            'letak_tanah_alamat' => fake()->address(),
            'kelurahan' => 'PASAR LUBUK JAMBI',
            'kecamatan' => 'KUANTAN MUDIK',
            'province_code' => '14',
            'city_code' => '1409',
            'district_code' => '140901',
            'village_code' => '1409011012',
            'luas_tanah' => $luasTanah,
            'luas_bangunan' => $luasBangunan,
            'njop_tanah_per_m2' => $njopTanahPerM2,
            'njop_bangunan_per_m2' => $njopBangunanPerM2,
            'total_njop_tanah' => $totalNjopTanah,
            'total_njop_bangunan' => $totalNjopBangunan,
            'total_njop' => $totalNjop,
            'npop' => $npop,
            'npoptkp' => $npoptkp,
            'npop_kena_pajak' => $npopKenaPajak,
            'bphtb_terutang' => $bphtbTerutang,
            'nama_wajib_pajak' => fake()->name(),
            'nik_wajib_pajak' => fake()->numerify('################'),
            'alamat_wajib_pajak' => fake()->address(),
            'nama_penjual' => fake()->name(),
            'nik_penjual' => fake()->numerify('################'),
            'alamat_penjual' => fake()->address(),
            'tanggal_pengajuan' => now(),
        ];
    }

    /**
     * Set the permohonan as submitted.
     */
    public function diajukan(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StatusPermohonan::Diajukan,
            'tanggal_pengajuan' => now(),
        ]);
    }

    /**
     * Set the permohonan as verified.
     */
    public function diverifikasi(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StatusPermohonan::Diverifikasi,
            'tanggal_pengajuan' => now()->subDays(3),
            'tanggal_verifikasi' => now(),
            'verified_by' => User::factory()->admin(),
        ]);
    }

    /**
     * Set the permohonan as approved.
     */
    public function disetujui(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StatusPermohonan::Disetujui,
            'tanggal_pengajuan' => now()->subDays(5),
            'tanggal_verifikasi' => now()->subDay(),
            'verified_by' => User::factory()->admin(),
        ]);
    }

    /**
     * Set the permohonan as rejected.
     */
    public function ditolak(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StatusPermohonan::Ditolak,
            'tanggal_pengajuan' => now()->subDays(5),
            'tanggal_verifikasi' => now()->subDay(),
            'verified_by' => User::factory()->admin(),
            'catatan_verifikasi' => 'Dokumen tidak lengkap, mohon lengkapi.',
        ]);
    }
}
