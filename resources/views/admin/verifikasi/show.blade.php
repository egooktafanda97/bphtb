@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Verifikasi
        </div>
        <h2 class="page-title">
            Detail Permohonan #{{ $permohonan->nomor_permohonan }}
        </h2>
    </div>
</div>
@endsection

@section('content')
<div class="row row-cards">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Data Objek Pajak & Transaksi</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">NOP</div>
                        <div class="datagrid-content">{{ $permohonan->nop }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Jenis Perolehan</div>
                        <div class="datagrid-content">{{ str_replace('_', ' ', ucfirst($permohonan->jenis_perolehan->value)) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Lokasi</div>
                        <div class="datagrid-content">
                            {{ $permohonan->letak_tanah_alamat }}<br>
                            {{ $permohonan->village->name }}, {{ $permohonan->district->name }}
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Luas Tanah / Bangunan</div>
                        <div class="datagrid-content">{{ $permohonan->luas_tanah }} m2 / {{ $permohonan->luas_bangunan }} m2</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Harga Transaksi</div>
                        <div class="datagrid-content">Rp {{ number_format($permohonan->harga_transaksi) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Total NJOP</div>
                        <div class="datagrid-content">Rp {{ number_format($permohonan->total_njop) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">NPOPTKP</div>
                        <div class="datagrid-content">Rp {{ number_format($permohonan->npoptkp) }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">BPHTB Terutang</div>
                        <div class="datagrid-content">
                            <strong class="text-primary h3">Rp {{ number_format($permohonan->bphtb_terutang) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Dokumen Pendukung</h3>
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
                        @foreach($permohonan->dokumens as $doc)
                        <tr>
                            <td>{{ $doc->nama_file }}</td>
                            <td><span class="badge bg-azure">{{ strtoupper($doc->tipe) }}</span></td>
                            <td>
                                <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="btn btn-sm btn-ghost-primary">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <form action="{{ route('admin.verifikasi.verify', $permohonan) }}" method="POST" class="card">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Aksi Verifikasi</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Keputusan</label>
                    <select class="form-select" name="status" required>
                        <option value="diverifikasi">Diverifikasi (Proses Lanjut)</option>
                        <option value="disetujui">Disetujui (Siap Bayar)</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan Verifikator</label>
                    <textarea class="form-control" name="catatan" rows="4" placeholder="Alasan penolakan atau catatan tambahan..."></textarea>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary w-100">Simpan Keputusan</button>
            </div>
        </form>

        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Data Wajib Pajak</h3>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Nama:</strong> {{ $permohonan->nama_wajib_pajak }}
                </div>
                <div class="mb-2">
                    <strong>NIK:</strong> {{ $permohonan->nik_wajib_pajak }}
                </div>
                <div class="mb-2">
                    <strong>Alamat:</strong><br>
                    {{ $permohonan->alamat_wajib_pajak }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
