<?php

namespace Database\Factories;

use App\Enums\StatusPembayaran;
use App\Models\Pembayaran;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pembayaran>
 */
class PembayaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'permohonan_id' => Permohonan::factory(),
            'nomor_sspd' => 'SSPD/'.date('Y').'/'.fake()->unique()->numerify('####'),
            'tanggal_bayar' => now(),
            'jumlah_bayar' => fake()->numberBetween(500000, 20000000),
            'metode_pembayaran' => 'simulasi',
            'status' => StatusPembayaran::Pending,
            'keterangan' => null,
            'created_by' => User::factory()->admin(),
        ];
    }

    /**
     * Mark payment as completed.
     */
    public function lunas(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StatusPembayaran::Lunas,
        ]);
    }
}
