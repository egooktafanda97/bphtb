<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusPermohonan;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\VerifikasiLog;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $permohonans = Permohonan::whereIn('status', [StatusPermohonan::Diajukan, StatusPermohonan::Diverifikasi])
            ->latest()
            ->get();

        return view('admin.verifikasi.index', compact('permohonans'));
    }

    public function show(Permohonan $permohonan)
    {
        $permohonan->load(['dokumens', 'district', 'village', 'pemohon']);

        return view('admin.verifikasi.show', compact('permohonan'));
    }

    public function verify(Request $request, Permohonan $permohonan)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak,diverifikasi',
            'catatan' => 'nullable|string',
        ]);

        $oldStatus = $permohonan->status;
        $newStatus = StatusPermohonan::from($validated['status']);

        $permohonan->update([
            'status' => $newStatus,
            'catatan_verifikasi' => $validated['catatan'],
            'tanggal_verifikasi' => now(),
            'verified_by' => auth()->id() ?? 1,
        ]);

        VerifikasiLog::create([
            'permohonan_id' => $permohonan->id,
            'user_id' => auth()->id() ?? 1,
            'aksi' => $newStatus->value,
            'catatan' => $validated['catatan'],
        ]);

        return redirect()->route('admin.verifikasi.index')
            ->with('success', 'Status permohonan #'.$permohonan->nomor_permohonan.' berhasil diperbarui.');
    }
}
