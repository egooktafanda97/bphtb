<?php

namespace Database\Seeders;

use App\Models\Njop;
use Illuminate\Database\Seeder;

class NjopSeeder extends Seeder
{
    /**
     * Seed NJOP data for Kabupaten Kuantan Singingi.
     */
    public function run(): void
    {
        $data = [
            ['province_code' => '14', 'city_code' => '1409', 'district_code' => '140901', 'village_code' => '1409011012', 'kecamatan' => 'KUANTAN MUDIK', 'kelurahan' => 'PASAR LUBUK JAMBI', 'njop_tanah_per_m2' => 150000, 'njop_bangunan_per_m2' => 350000],
            ['province_code' => '14', 'city_code' => '1409', 'district_code' => '140901', 'village_code' => '1409012004', 'kecamatan' => 'KUANTAN MUDIK', 'kelurahan' => 'AIR BULUH', 'njop_tanah_per_m2' => 150000, 'njop_bangunan_per_m2' => 350000],
            ['province_code' => '14', 'city_code' => '1409', 'district_code' => '140901', 'village_code' => '1409012005', 'kecamatan' => 'KUANTAN MUDIK', 'kelurahan' => 'PANTAI', 'njop_tanah_per_m2' => 120000, 'njop_bangunan_per_m2' => 300000],
            ['province_code' => '14', 'city_code' => '1409', 'district_code' => '140901', 'village_code' => '1409012007', 'kecamatan' => 'KUANTAN MUDIK', 'kelurahan' => 'LUBUK RAMO', 'njop_tanah_per_m2' => 130000, 'njop_bangunan_per_m2' => 320000],
            ['province_code' => '14', 'city_code' => '1409', 'district_code' => '140901', 'village_code' => '1409012008', 'kecamatan' => 'KUANTAN MUDIK', 'kelurahan' => 'SEBERANG CENGAR', 'njop_tanah_per_m2' => 140000, 'njop_bangunan_per_m2' => 340000],
        ];

        foreach ($data as $item) {
            Njop::create([
                ...$item,
                'tahun' => date('Y'),
                'is_active' => true,
            ]);
        }
    }
}
