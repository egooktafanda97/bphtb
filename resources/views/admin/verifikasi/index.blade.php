@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Admin
        </div>
        <h2 class="page-title">
            Verifikasi Permohonan BPHTB
        </h2>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>No. Permohonan</th>
                    <th>Tgl Pengajuan</th>
                    <th>Wajib Pajak</th>
                    <th>NOP</th>
                    <th>BPHTB Terutang</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permohonans as $item)
                <tr>
                    <td><span class="text-secondary">{{ $item->nomor_permohonan }}</span></td>
                    <td>{{ $item->tanggal_pengajuan->format('d M Y') }}</td>
                    <td>{{ $item->nama_wajib_pajak }}</td>
                    <td>{{ $item->nop }}</td>
                    <td>Rp {{ number_format($item->bphtb_terutang) }}</td>
                    <td>
                        @php
                            $badge = match($item->status->value) {
                                'diajukan' => 'orange',
                                'diverifikasi' => 'azure',
                                default => 'gray'
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ ucfirst($item->status->value) }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.verifikasi.show', $item) }}" class="btn btn-sm btn-primary">
                            Verifikasi
                        </a>
                    </td>
                </tr>
                @endforeach
                @if($permohonans->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">Tidak ada permohonan yang perlu diverifikasi.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
