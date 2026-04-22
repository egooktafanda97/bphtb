<?php

namespace Database\Factories;

use App\Enums\JenisDokumen;
use App\Models\Dokumen;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dokumen>
 */
class DokumenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = fake()->randomElement(JenisDokumen::cases());

        return [
            'permohonan_id' => Permohonan::factory(),
            'jenis_dokumen' => $jenis,
            'nama_file' => $jenis->value.'_'.fake()->numerify('###').'.pdf',
            'path' => 'dokumen/'.date('Y/m').'/'.fake()->uuid().'.pdf',
            'mime_type' => 'application/pdf',
            'ukuran' => fake()->numberBetween(100000, 5000000),
            'uploaded_by' => User::factory(),
        ];
    }
}
