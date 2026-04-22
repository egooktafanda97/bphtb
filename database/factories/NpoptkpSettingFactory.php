<?php

namespace Database\Factories;

use App\Enums\JenisPerolehan;
use App\Models\NpoptkpSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NpoptkpSetting>
 */
class NpoptkpSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenis_perolehan' => fake()->randomElement(JenisPerolehan::cases()),
            'nilai_npoptkp' => 60000000,
            'tahun' => date('Y'),
            'is_active' => true,
        ];
    }
}
