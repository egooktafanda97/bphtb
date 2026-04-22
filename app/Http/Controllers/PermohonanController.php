<?php

namespace App\Http\Controllers;

use App\Enums\StatusPermohonan;
use App\Enums\UserRole;
use App\Models\Dokumen;
use App\Models\Permohonan;
use App\Services\BphtbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class PermohonanController extends Controller
{
    public function __construct(protected BphtbService $bphtbService) {}

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Permohonan::with(['village', 'pemohon', 'ppat'])->latest();

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nop', 'like', "%{$search}%")
                    ->orWhere('nama_wajib_pajak', 'like', "%{$search}%")
                    ->orWhere('nomor_permohonan', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($user->role === UserRole::Ppat) {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('ppat_id', $user->id);
            });
        } elseif ($user->role === UserRole::WajibPajak) {
            $query->where('user_id', $user->id);
        }
        // Admin sees all

        $permohonans = $query->paginate(10);

        return view('permohonan.index', compact('permohonans'));
    }

    public function show(Permohonan $permohonan)
    {
        $permohonan->load(['village', 'district', 'city', 'province', 'pemohon', 'ppat', 'dokumens']);

        return view('permohonan.show', compact('permohonan'));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get();

        return view('permohonan.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_perolehan_hak' => 'required',
            'nop' => 'required',
            'letak_tanah_alamat' => 'required',
            'province_code' => 'required',
            'city_code' => 'required',
            'district_code' => 'required',
            'village_code' => 'required',
            'luas_tanah' => 'required|numeric',
            'luas_bangunan' => 'required|numeric',
            'harga_transaksi' => 'required|numeric',
            'nama_wajib_pajak' => 'required',
            'nik_wajib_pajak' => 'required',
            'alamat_wajib_pajak' => 'required',
            'nama_penjual' => 'required',
            'nik_penjual' => 'nullable',
            'alamat_penjual' => 'nullable',
            'no_akta' => 'nullable',
            'tanggal_akta' => 'nullable|date',
            'nama_ppat_akta' => 'nullable',
            'ktp' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'sppt_pbb' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'bukti_lunas_pbb' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'sertifikat' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // 1. Calculate final values using Service
        $calcData = $this->bphtbService->calculate(
            $validated['jenis_perolehan_hak'],
            $validated['village_code'],
            (float) $validated['luas_tanah'],
            (float) $validated['luas_bangunan'],
            (float) $validated['harga_transaksi']
        );

        // 2. Determine Status
        $status = $request->action === 'draft' ? StatusPermohonan::Draft : StatusPermohonan::Diajukan;

        // 3. Get Location Names for redundancy/cache
        $village = Village::where('code', $validated['village_code'])->first();
        $district = District::where('code', $validated['district_code'])->first();

        // 4. Create Permohonan
        $permohonan = Permohonan::create([
            'nomor_permohonan' => 'BPHTB/'.date('Y').'/'.Str::upper(Str::random(6)),
            'user_id' => auth()->id() ?? 1,
            'status' => $status,
            'jenis_perolehan' => $validated['jenis_perolehan_hak'],
            'nop' => $validated['nop'],
            'letak_tanah_alamat' => $validated['letak_tanah_alamat'],
            'kelurahan' => $village?->name,
            'kecamatan' => $district?->name,
            'province_code' => $validated['province_code'],
            'city_code' => $validated['city_code'],
            'district_code' => $validated['district_code'],
            'village_code' => $validated['village_code'],
            'luas_tanah' => $validated['luas_tanah'],
            'luas_bangunan' => $validated['luas_bangunan'],
            'njop_tanah_per_m2' => $calcData['njop_tanah_per_m2'],
            'njop_bangunan_per_m2' => $calcData['njop_bangunan_per_m2'],
            'total_njop_tanah' => $calcData['total_njop_tanah'],
            'total_njop_bangunan' => $calcData['total_njop_bangunan'],
            'total_njop' => $calcData['total_njop'],
            'npop' => $calcData['npop'],
            'npoptkp' => $calcData['npoptkp'],
            'npop_kena_pajak' => $calcData['npop_kena_pajak'],
            'bphtb_terutang' => $calcData['bphtb_terutang'],
            'nama_wajib_pajak' => $validated['nama_wajib_pajak'],
            'nik_wajib_pajak' => $validated['nik_wajib_pajak'],
            'alamat_wajib_pajak' => $validated['alamat_wajib_pajak'],
            'nama_penjual' => $validated['nama_penjual'],
            'nik_penjual' => $validated['nik_penjual'],
            'alamat_penjual' => $validated['alamat_penjual'],
            'no_akta' => $validated['no_akta'],
            'tanggal_akta' => $validated['tanggal_akta'],
            'nama_ppat_akta' => $validated['nama_ppat_akta'],
            'harga_transaksi' => $validated['harga_transaksi'],
            'tanggal_pengajuan' => now(),
        ]);

        // 5. Handle File Uploads
        $fileTypeMapping = [
            'ktp' => 'ktp',
            'sppt_pbb' => 'sppt_pbb',
            'bukti_lunas_pbb' => 'bukti_bayar_pbb',
            'sertifikat' => 'sertifikat',
        ];

        foreach ($fileTypeMapping as $formField => $dokumenType) {
            if ($request->hasFile($formField)) {
                $file = $request->file($formField);
                $path = $file->store('documents', 'public');
                Dokumen::create([
                    'permohonan_id' => $permohonan->id,
                    'uploaded_by' => auth()->id() ?? 1,
                    'nama_file' => $file->getClientOriginalName(),
                    'path' => $path,
                    'jenis_dokumen' => $dokumenType,
                    'mime_type' => $file->getClientMimeType(),
                    'ukuran' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('permohonan.index')->with('success', 'Permohonan berhasil diajukan.');
    }

    public function edit(Permohonan $permohonan)
    {
        $user = auth()->user();

        if ($user->role !== UserRole::Admin && $permohonan->user_id !== $user->id) {
            abort(403);
        }

        if (! in_array($permohonan->status, [StatusPermohonan::Draft, StatusPermohonan::Diajukan])) {
            return back()->with('error', 'Hanya permohonan berstatus Draft atau Diajukan yang dapat diedit.');
        }

        $permohonan->load(['dokumens', 'village', 'district', 'city', 'province']);
        $provinces = Province::orderBy('name')->get();

        return view('permohonan.edit', compact('permohonan', 'provinces'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $user = auth()->user();

        if ($user->role !== UserRole::Admin && $permohonan->user_id !== $user->id) {
            abort(403);
        }

        if (! in_array($permohonan->status, [StatusPermohonan::Draft, StatusPermohonan::Diajukan])) {
            return back()->with('error', 'Hanya permohonan berstatus Draft atau Diajukan yang dapat diedit.');
        }

        $validated = $request->validate([
            'jenis_perolehan_hak' => 'required',
            'nop' => 'required',
            'letak_tanah_alamat' => 'required',
            'province_code' => 'required',
            'city_code' => 'required',
            'district_code' => 'required',
            'village_code' => 'required',
            'luas_tanah' => 'required|numeric',
            'luas_bangunan' => 'required|numeric',
            'harga_transaksi' => 'required|numeric',
            'nama_wajib_pajak' => 'required',
            'nik_wajib_pajak' => 'required',
            'alamat_wajib_pajak' => 'required',
            'nama_penjual' => 'required',
            'nik_penjual' => 'nullable',
            'alamat_penjual' => 'nullable',
            'no_akta' => 'nullable',
            'tanggal_akta' => 'nullable|date',
            'nama_ppat_akta' => 'nullable',
            'ktp' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'sppt_pbb' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'bukti_lunas_pbb' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // 1. Recalculate BPHTB
        $calcData = $this->bphtbService->calculate(
            $validated['jenis_perolehan_hak'],
            $validated['village_code'],
            (float) $validated['luas_tanah'],
            (float) $validated['luas_bangunan'],
            (float) $validated['harga_transaksi']
        );

        // 2. Determine Status
        $status = $request->action === 'draft' ? StatusPermohonan::Draft : StatusPermohonan::Diajukan;

        // 3. Get Location Names
        $village = Village::where('code', $validated['village_code'])->first();
        $district = District::where('code', $validated['district_code'])->first();

        // 4. Update Permohonan
        $permohonan->update([
            'status' => $status,
            'jenis_perolehan' => $validated['jenis_perolehan_hak'],
            'nop' => $validated['nop'],
            'letak_tanah_alamat' => $validated['letak_tanah_alamat'],
            'kelurahan' => $village?->name,
            'kecamatan' => $district?->name,
            'province_code' => $validated['province_code'],
            'city_code' => $validated['city_code'],
            'district_code' => $validated['district_code'],
            'village_code' => $validated['village_code'],
            'luas_tanah' => $validated['luas_tanah'],
            'luas_bangunan' => $validated['luas_bangunan'],
            'njop_tanah_per_m2' => $calcData['njop_tanah_per_m2'],
            'njop_bangunan_per_m2' => $calcData['njop_bangunan_per_m2'],
            'total_njop_tanah' => $calcData['total_njop_tanah'],
            'total_njop_bangunan' => $calcData['total_njop_bangunan'],
            'total_njop' => $calcData['total_njop'],
            'npop' => $calcData['npop'],
            'npoptkp' => $calcData['npoptkp'],
            'npop_kena_pajak' => $calcData['npop_kena_pajak'],
            'bphtb_terutang' => $calcData['bphtb_terutang'],
            'nama_wajib_pajak' => $validated['nama_wajib_pajak'],
            'nik_wajib_pajak' => $validated['nik_wajib_pajak'],
            'alamat_wajib_pajak' => $validated['alamat_wajib_pajak'],
            'nama_penjual' => $validated['nama_penjual'],
            'nik_penjual' => $validated['nik_penjual'],
            'alamat_penjual' => $validated['alamat_penjual'],
            'no_akta' => $validated['no_akta'],
            'tanggal_akta' => $validated['tanggal_akta'],
            'nama_ppat_akta' => $validated['nama_ppat_akta'],
            'harga_transaksi' => $validated['harga_transaksi'],
        ]);

        // 5. Handle optional file re-uploads
        $fileTypeMapping = [
            'ktp' => 'ktp',
            'sppt_pbb' => 'sppt_pbb',
            'bukti_lunas_pbb' => 'bukti_bayar_pbb',
            'sertifikat' => 'sertifikat',
        ];

        foreach ($fileTypeMapping as $formField => $dokumenType) {
            if ($request->hasFile($formField)) {
                $file = $request->file($formField);
                $path = $file->store('documents', 'public');

                // Delete old document of same type
                $oldDoc = $permohonan->dokumens()->where('jenis_dokumen', $dokumenType)->first();
                if ($oldDoc) {
                    Storage::disk('public')->delete($oldDoc->path);
                    $oldDoc->update([
                        'nama_file' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'ukuran' => $file->getSize(),
                    ]);
                } else {
                    Dokumen::create([
                        'permohonan_id' => $permohonan->id,
                        'uploaded_by' => auth()->id(),
                        'nama_file' => $file->getClientOriginalName(),
                        'path' => $path,
                        'jenis_dokumen' => $dokumenType,
                        'mime_type' => $file->getClientMimeType(),
                        'ukuran' => $file->getSize(),
                    ]);
                }
            }
        }

        return redirect()->route('permohonan.show', $permohonan)->with('success', 'Permohonan berhasil diperbarui.');
    }

    public function destroy(Permohonan $permohonan)
    {
        $user = auth()->user();

        // 1. Authorization Check
        if ($user->role !== UserRole::Admin && $permohonan->user_id !== $user->id) {
            return back()->with('error', 'Anda tidak memiliki hak untuk menghapus permohonan ini.');
        }

        // 2. Status Check
        if (! in_array($permohonan->status, [StatusPermohonan::Draft, StatusPermohonan::Diajukan])) {
            return back()->with('error', 'Hanya permohonan dengan status Draft atau Diajukan yang dapat dihapus.');
        }

        // 3. Delete related files from storage if needed
        foreach ($permohonan->dokumens as $dokumen) {
            if (Storage::disk('public')->exists($dokumen->path)) {
                Storage::disk('public')->delete($dokumen->path);
            }
        }

        // 4. Delete Permohonan (Related records will be deleted by Cascade On Delete if defined)
        $permohonan->delete();

        return redirect()->route('permohonan.index')->with('success', 'Permohonan berhasil dihapus.');
    }
}
