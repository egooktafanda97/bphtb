<?php

namespace App\Http\Controllers;

use App\Services\BphtbService;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function __construct(protected BphtbService $bphtbService) {}

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'jenis_perolehan' => 'required',
            'village_code' => 'required',
            'luas_tanah' => 'required|numeric',
            'luas_bangunan' => 'required|numeric',
            'harga_transaksi' => 'required|numeric',
        ]);

        $result = $this->bphtbService->calculate(
            $validated['jenis_perolehan'],
            $validated['village_code'],
            (float) $validated['luas_tanah'],
            (float) $validated['luas_bangunan'],
            (float) $validated['harga_transaksi']
        );

        return response()->json($result);
    }
}
