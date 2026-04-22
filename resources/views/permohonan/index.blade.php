@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Permohonan
        </div>
        <h2 class="page-title">
            Daftar Permohonan BPHTB
        </h2>
    </div>
    <div class="col-auto ms-auto">
        <div class="btn-list">
            <a href="{{ route('permohonan.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                Tambah Permohonan
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body border-bottom py-3">
        <form action="{{ route('permohonan.index') }}" method="GET" class="d-flex">
            <div class="text-secondary">
                Filter Status:
                <div class="mx-2 d-inline-block">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        @foreach(\App\Enums\StatusPermohonan::cases() as $s)
                            <option value="{{ $s->value }}" {{ request('status') == $s->value ? 'selected' : '' }}>{{ ucfirst($s->value) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="ms-auto text-secondary">
                Search:
                <div class="ms-2 d-inline-block">
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="NOP / Nama WP...">
                </div>
                <button type="submit" class="btn btn-sm btn-primary ms-2">Cari</button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>No. Permohonan</th>
                    <th>Tanggal</th>
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
                                'draft' => 'secondary',
                                'diajukan' => 'orange',
                                'diverifikasi' => 'azure',
                                'disetujui' => 'green',
                                'ditolak' => 'red',
                                'selesai' => 'blue',
                                default => 'gray'
                            };
                        @endphp
                        <span class="status-dot bg-{{ $badge }} d-none d-sm-inline-block"></span>
                        {{ ucfirst($item->status->value) }}
                    </td>
                    <td class="text-end">
                        <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('permohonan.show', $item) }}">Detail</a>
                                @if(in_array($item->status->value, ['draft', 'diajukan']))
                                <a class="dropdown-item" href="{{ route('permohonan.edit', $item) }}">Edit</a>
                                @endif
                                @if($item->status->value == 'disetujui' || $item->status->value == 'selesai')
                                <a class="dropdown-item" href="#">Cetak SSPD</a>
                                @endif
                                @if(in_array($item->status->value, ['draft', 'diajukan']))
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('permohonan.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">Showing <span>{{ $permohonans->firstItem() }}</span> to <span>{{ $permohonans->lastItem() }}</span> of <span>{{ $permohonans->total() }}</span> entries</p>
        <div class="ms-auto">
            {{ $permohonans->links() }}
        </div>
    </div>
</div>
@endsection
