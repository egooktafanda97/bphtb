<?php

namespace Database\Seeders;

use App\Enums\JenisPerolehan;
use App\Models\NpoptkpSetting;
use Illuminate\Database\Seeder;

class NpoptkpSettingSeeder extends Seeder
{
    /**
     * Seed NPOPTKP settings per jenis perolehan.
     */
    public function run(): void
    {
        $data = [
            ['jenis_perolehan' => JenisPerolehan::JualBeli, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::TukarMenukar, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::Hibah, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::HibahWasiat, 'nilai_npoptkp' => 300000000],
            ['jenis_perolehan' => JenisPerolehan::Waris, 'nilai_npoptkp' => 300000000],
            ['jenis_perolehan' => JenisPerolehan::PemasukanPerseroan, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::PemisahanHak, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::Lelang, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::PelaksanaanPutusan, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::Penggabungan, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::Peleburan, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::Pemekaran, 'nilai_npoptkp' => 60000000],
            ['jenis_perolehan' => JenisPerolehan::HadiahUndian, 'nilai_npoptkp' => 60000000],
        ];

        foreach ($data as $item) {
            NpoptkpSetting::create([
                ...$item,
                'tahun' => date('Y'),
                'is_active' => true,
            ]);
        }
    }
}
