<?php

namespace App\Services;

use App\Models\Njop;
use App\Models\NpoptkpSetting;

class BphtbService
{
    /**
     * Calculate BPHTB based on input parameters.
     */
    public function calculate(
        string $jenisPerolehan,
        string $villageCode,
        float $luasTanah,
        float $luasBangunan,
        float $hargaTransaksi,
        ?int $tahun = null
    ): array {
        $tahun = $tahun ?? (int) date('Y');

        // 1. Get NJOP reference for the village
        $njopRef = Njop::where('village_code', $villageCode)
            ->where('is_active', true)
            ->where('tahun', $tahun)
            ->first();

        $njopTanahPerM2 = $njopRef ? (float) $njopRef->njop_tanah_per_m2 : 0;
        $njopBangunanPerM2 = $njopRef ? (float) $njopRef->njop_bangunan_per_m2 : 0;

        // 2. Calculate Total NJOP
        $totalNjopTanah = $luasTanah * $njopTanahPerM2;
        $totalNjopBangunan = $luasBangunan * $njopBangunanPerM2;
        $totalNjop = $totalNjopTanah + $totalNjopBangunan;

        // 3. Determine NPOP (the higher of NJOP or Market Price)
        $npop = max($totalNjop, $hargaTransaksi);

        // 4. Get NPOPTKP setting
        $npoptkpSetting = NpoptkpSetting::where('jenis_perolehan', $jenisPerolehan)
            ->where('is_active', true)
            ->where('tahun', $tahun)
            ->first();

        $npoptkp = $npoptkpSetting ? (float) $npoptkpSetting->nilai_npoptkp : 60000000;

        // 5. Calculate NPOP Kena Pajak
        $npopKenaPajak = max(0, $npop - $npoptkp);

        // 6. Calculate BPHTB Terutang (5%)
        $bphtbTerutang = $npopKenaPajak * 0.05;

        return [
            'total_njop_tanah' => $totalNjopTanah,
            'total_njop_bangunan' => $totalNjopBangunan,
            'total_njop' => $totalNjop,
            'npop' => $npop,
            'npoptkp' => $npoptkp,
            'npop_kena_pajak' => $npopKenaPajak,
            'bphtb_terutang' => $bphtbTerutang,
            'njop_tanah_per_m2' => $njopTanahPerM2,
            'njop_bangunan_per_m2' => $njopBangunanPerM2,
        ];
    }
}
