<?php

namespace App\Http\Controllers;

use App\Models\Njop;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;

class NjopController extends Controller
{
    public function index()
    {
        $njops = Njop::with(['province', 'city', 'district', 'village'])->latest()->get();
        $provinces = Province::orderBy('name')->get();

        return view('njop.index', compact('njops', 'provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'province_code' => 'required',
            'city_code' => 'required',
            'district_code' => 'required',
            'village_code' => 'required',
            'njop_tanah_per_m2' => 'required|numeric',
            'njop_bangunan_per_m2' => 'required|numeric',
        ]);

        Njop::create([
            ...$validated,
            'tahun' => date('Y'),
            'is_active' => true,
        ]);

        return redirect()->route('njop.index')->with('success', 'Data NJOP berhasil disimpan.');
    }

    public function update(Request $request, Njop $njop)
    {
        $validated = $request->validate([
            'njop_tanah_per_m2' => 'required|numeric',
            'njop_bangunan_per_m2' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        $njop->update($validated);

        return redirect()->route('njop.index')->with('success', 'Data NJOP berhasil diperbarui.');
    }

    public function destroy(Njop $njop)
    {
        $njop->delete();

        return redirect()->route('njop.index')->with('success', 'Data NJOP berhasil dihapus.');
    }
}
