<?php

namespace App\Http\Controllers;

use App\Models\NpoptkpSetting;
use Illuminate\Http\Request;

class NpoptkpController extends Controller
{
    public function index()
    {
        $settings = NpoptkpSetting::latest()->get();

        return view('npoptkp.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_perolehan' => 'required',
            'nilai_npoptkp' => 'required|numeric',
        ]);

        NpoptkpSetting::create([
            ...$validated,
            'tahun' => date('Y'),
            'is_active' => true,
        ]);

        return redirect()->route('npoptkp.index')->with('success', 'Setting NPOPTKP berhasil disimpan.');
    }

    public function update(Request $request, NpoptkpSetting $npoptkp)
    {
        $validated = $request->validate([
            'nilai_npoptkp' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        $npoptkp->update($validated);

        return redirect()->route('npoptkp.index')->with('success', 'Setting NPOPTKP berhasil diperbarui.');
    }

    public function destroy(NpoptkpSetting $npoptkp)
    {
        $npoptkp->delete();

        return redirect()->route('npoptkp.index')->with('success', 'Setting NPOPTKP berhasil dihapus.');
    }
}
