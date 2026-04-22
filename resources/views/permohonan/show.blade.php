@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Detail Permohonan
        </div>
        <h2 class="page-title">
            {{ $permohonan->nomor_permohonan }}
        </h2>
    </div>
    <div class="col-auto ms-auto">
        <div class="btn-list">
            <a href="{{ route('permohonan.index') }}" class="btn btn-white">
                Kembali
            </a>
            @if(in_array($permohonan->status->value, ['draft', 'diajukan']))
            <a href="{{ route('permohonan.edit', $permohonan) }}" class="btn btn-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                Edit
            </a>
            @endif
            @if(auth()->user()->role === \App\Enums\UserRole::Admin && $permohonan->status == \App\Enums\StatusPermohonan::Diajukan)
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-verifikasi">
                Verifikasi & Setujui
            </button>
            @endif
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row row-cards">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Informasi Objek Pajak</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">NOP</div>
                        <div class="datagrid-content">{{ $permohonan->nop }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Jenis Perolehan</div>
                        <div class="datagrid-content text-capitalize">{{ str_replace('_', ' ', $permohonan->jenis_perolehan->value) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Luas Tanah</div>
                        <div class="datagrid-content">{{ number_format($permohonan->luas_tanah) }} m<sup>2</sup></div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Luas Bangunan</div>
                        <div class="datagrid-content">{{ number_format($permohonan->luas_bangunan) }} m<sup>2</sup></div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Alamat Objek</div>
                        <div class="datagrid-content">
                            {{ $permohonan->letak_tanah_alamat }}<br>
                            {{ $permohonan->village->name }}, {{ $permohonan->district->name }}<br>
                            {{ $permohonan->city->name }}, {{ $permohonan->province->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Data Wajib Pajak (Pembeli)</h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid datagrid-v">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Nama</div>
                                <div class="datagrid-content font-weight-bold">{{ $permohonan->nama_wajib_pajak }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">NIK</div>
                                <div class="datagrid-content">{{ $permohonan->nik_wajib_pajak }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Alamat</div>
                                <div class="datagrid-content text-wrap">{{ $permohonan->alamat_wajib_pajak }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Data Penjual</h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid datagrid-v">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Nama</div>
                                <div class="datagrid-content font-weight-bold">{{ $permohonan->nama_penjual }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">NIK</div>
                                <div class="datagrid-content">{{ $permohonan->nik_penjual ?? '-' }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Alamat</div>
                                <div class="datagrid-content text-wrap">{{ $permohonan->alamat_penjual ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Dokumen Lampiran</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Nama Dokumen</th>
                            <th>Tipe</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permohonan->dokumens as $dok)
                        <tr>
                            <td>{{ $dok->nama_file }}</td>
                            <td class="text-secondary text-uppercase">{{ $dok->jenis_dokumen }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $dok->path) }}" target="_blank" class="btn btn-sm btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-secondary">Tidak ada dokumen lampiran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3 bg-primary-lt">
            <div class="card-body">
                <div class="datagrid datagrid-v">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Status Permohonan</div>
                        <div class="datagrid-content">
                            @php
                                $badge = match($permohonan->status->value) {
                                    'draft' => 'secondary',
                                    'diajukan' => 'orange',
                                    'diverifikasi' => 'azure',
                                    'disetujui' => 'green',
                                    'ditolak' => 'red',
                                    'selesai' => 'blue',
                                    default => 'gray'
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }} text-uppercase">{{ $permohonan->status->value }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Perhitungan BPHTB</h3>
            </div>
            <div class="card-body">
                <div class="datagrid datagrid-v">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Harga Transaksi / Nilai Pasar</div>
                        <div class="datagrid-content h3 mb-2">Rp {{ number_format($permohonan->harga_transaksi) }}</div>
                    </div>
                    <hr class="my-2">
                    <div class="datagrid-item">
                        <div class="datagrid-title">NJOP Tanah /m²</div>
                        <div class="datagrid-content">Rp {{ number_format($permohonan->njop_tanah_per_m2) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Total NJOP Tanah ({{ number_format($permohonan->luas_tanah) }} m² × Rp {{ number_format($permohonan->njop_tanah_per_m2) }})</div>
                        <div class="datagrid-content">Rp {{ number_format($permohonan->total_njop_tanah) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">NJOP Bangunan /m²</div>
                        <div class="datagrid-content">Rp {{ number_format($permohonan->njop_bangunan_per_m2) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Total NJOP Bangunan ({{ number_format($permohonan->luas_bangunan) }} m² × Rp {{ number_format($permohonan->njop_bangunan_per_m2) }})</div>
                        <div class="datagrid-content">Rp {{ number_format($permohonan->total_njop_bangunan) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Total NJOP (Bumi & Bangunan)</div>
                        <div class="datagrid-content h3 mb-2">Rp {{ number_format($permohonan->total_njop) }}</div>
                    </div>
                    <hr class="my-2">
                    <div class="datagrid-item">
                        <div class="datagrid-title">NPOP (Nilai Perolehan Objek Pajak)</div>
                        <div class="datagrid-content font-weight-bold">Rp {{ number_format($permohonan->npop) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">NPOPTKP (Pengurang)</div>
                        <div class="datagrid-content text-danger">- Rp {{ number_format($permohonan->npoptkp) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">NPOP Kena Pajak</div>
                        <div class="datagrid-content font-weight-bold">Rp {{ number_format($permohonan->npop_kena_pajak) }}</div>
                    </div>
                    <hr class="my-2">
                    <div class="datagrid-item">
                        <div class="datagrid-title">BPHTB Terutang (5%)</div>
                        <div class="datagrid-content h2 text-primary font-weight-bold">Rp {{ number_format($permohonan->bphtb_terutang) }}</div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-secondary small">
                @if($permohonan->njop_tanah_per_m2 == 0 && $permohonan->njop_bangunan_per_m2 == 0)
                <span class="text-warning">⚠ Data NJOP belum tersedia untuk kelurahan ini. Perhitungan menggunakan NJOP = 0.</span>
                @else
                * Perhitungan dilakukan secara otomatis berdasarkan data NJOP wilayah.
                @endif
            </div>
        </div>

        @if($permohonan->no_akta)
        <div class="card bg-azure-lt">
            <div class="card-header">
                <h3 class="card-title">Data Akta / Notaris</h3>
            </div>
            <div class="card-body">
                <div class="datagrid datagrid-v">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Nomor Akta</div>
                        <div class="datagrid-content">{{ $permohonan->no_akta }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Tanggal Akta</div>
                        <div class="datagrid-content">{{ $permohonan->tanggal_akta->format('d/m/Y') }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">PPAT/Notaris</div>
                        <div class="datagrid-content">{{ $permohonan->nama_ppat_akta }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@if(auth()->user()->role === \App\Enums\UserRole::Admin && $permohonan->status == \App\Enums\StatusPermohonan::Diajukan)
<div class="modal modal-blur fade" id="modal-verifikasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.verifikasi.verify', $permohonan) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Permohonan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hasil Verifikasi</label>
                        <select name="status" class="form-select">
                            <option value="disetujui">Setujui (Terbitkan Tagihan/SSPD)</option>
                            <option value="ditolak">Tolak / Butuh Perbaikan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan verifikasi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
