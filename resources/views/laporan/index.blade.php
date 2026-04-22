@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Laporan
        </div>
        <h2 class="page-title">
            Laporan Realisasi BPHTB
        </h2>
    </div>
    <div class="col-auto ms-auto">
        <div class="btn-list">
            <button class="btn btn-primary d-none d-sm-inline-block" onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg>
                Cetak Laporan
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row row-cards mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('laporan.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kecamatan</label>
                            <select name="district_code" class="form-select">
                                <option value="">Semua Kecamatan</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->code }}" {{ $districtCode == $district->code ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row row-cards mb-3">
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-primary text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 12l2 2l4 -4" /><circle cx="12" cy="12" r="9" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ number_format($totalPermohonan) }} Permohonan
                        </div>
                        <div class="text-secondary small">
                            Total Volume Pengajuan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-green text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Rp {{ number_format($totalRevenue) }}
                        </div>
                        <div class="text-secondary small">
                            Total Realisasi Pendapatan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-yellow text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><polyline points="12 7 12 12 15 15" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ number_format($totalPending) }} Pending
                        </div>
                        <div class="text-secondary small">
                            Menunggu Verifikasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rincian Data</h3>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap">
            <thead>
                <tr>
                    <th>Tgl Pengajuan</th>
                    <th>No. Permohonan</th>
                    <th>Wajib Pajak</th>
                    <th>NOP</th>
                    <th>Kecamatan</th>
                    <th class="text-end">Terutang (Rp)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans as $item)
                <tr>
                    <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td>{{ $item->nomor_permohonan }}</td>
                    <td>{{ $item->nama_wajib_pajak }}</td>
                    <td>{{ $item->nop }}</td>
                    <td>{{ $item->district->name }}</td>
                    <td class="text-end font-weight-bold">{{ number_format($item->bphtb_terutang) }}</td>
                    <td>
                        @php
                            $badge = match($item->status->value) {
                                'draft' => 'secondary',
                                'diajukan' => 'orange',
                                'diverifikasi' => 'azure',
                                'disetujui' => 'green',
                                'ditolak' => 'red',
                                'selesai' => 'blue',
                                default => 'gray'
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }} text-uppercase">{{ $item->status->value }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-secondary py-4">Tidak ada data untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($permohonans->hasPages())
    <div class="card-footer d-flex align-items-center">
        <div class="ms-auto">
            {{ $permohonans->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
