<?php

namespace Database\Factories;

use App\Models\Njop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Njop>
 */
class NjopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kecamatan' => fake()->city(),
            'kelurahan' => fake()->streetName(),
            'njop_tanah_per_m2' => fake()->numberBetween(50000, 500000),
            'njop_bangunan_per_m2' => fake()->numberBetween(200000, 800000),
            'tahun' => date('Y'),
            'is_active' => true,
        ];
    }
}
