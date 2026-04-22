<?php

namespace App\Http\Controllers;

use App\Enums\StatusPembayaran;
use App\Enums\StatusPermohonan;
use App\Enums\UserRole;
use App\Models\Pembayaran;
use App\Models\Permohonan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Permohonan::with(['pembayaran', 'village', 'district'])
            ->whereIn('status', [
                StatusPermohonan::Disetujui,
                StatusPermohonan::Selesai,
            ]);

        if ($user->role === UserRole::Ppat) {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('ppat_id', $user->id);
            });
        } elseif ($user->role === UserRole::WajibPajak) {
            $query->where('user_id', $user->id);
        }

        $permohonans = $query->latest()->paginate(10);

        return view('pembayaran.index', compact('permohonans'));
    }

    public function downloadSspd(Permohonan $permohonan)
    {
        if ($permohonan->status !== StatusPermohonan::Selesai) {
            return back()->with('error', 'SSPD belum tersedia. Silakan lakukan pembayaran terlebih dahulu.');
        }

        $permohonan->load(['pembayaran', 'village', 'district', 'city', 'province']);

        $pdf = Pdf::loadView('pembayaran.sspd_pdf', compact('permohonan'));

        return $pdf->download('SSPD-'.$permohonan->nomor_permohonan.'.pdf');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'permohonan_id' => 'required|exists:permohonan,id',
            'metode_pembayaran' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $permohonan = Permohonan::findOrFail($validated['permohonan_id']);

        // Prevent double payment
        if ($permohonan->pembayaran()->exists()) {
            return back()->with('error', 'Pembayaran untuk permohonan ini sudah dilakukan.');
        }

        $pembayaran = Pembayaran::create([
            'permohonan_id' => $permohonan->id,
            'nomor_sspd' => 'SSPD/'.date('Y').'/'.Str::upper(Str::random(8)),
            'tanggal_bayar' => now(),
            'jumlah_bayar' => $permohonan->bphtb_terutang,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status' => StatusPembayaran::Lunas,
            'keterangan' => $validated['keterangan'] ?? 'Pembayaran via '.$validated['metode_pembayaran'],
            'created_by' => auth()->id() ?? 1,
        ]);

        // Update Permohonan Status
        $permohonan->update([
            'status' => StatusPermohonan::Selesai,
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi. SSPD kini dapat diunduh.');
    }
}
