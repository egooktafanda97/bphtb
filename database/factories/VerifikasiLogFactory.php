<?php

namespace Database\Factories;

use App\Enums\AksiVerifikasi;
use App\Models\Permohonan;
use App\Models\User;
use App\Models\VerifikasiLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VerifikasiLog>
 */
class VerifikasiLogFactory extends Factory
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
            'user_id' => User::factory()->admin(),
            'aksi' => fake()->randomElement(AksiVerifikasi::cases()),
            'catatan' => fake()->optional()->sentence(),
        ];
    }
}
