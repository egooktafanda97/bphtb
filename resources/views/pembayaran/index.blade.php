@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Pembayaran
        </div>
        <h2 class="page-title">
            Daftar Pembayaran BPHTB
        </h2>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="text-secondary">
                Daftar permohonan yang telah disetujui dan siap untuk pembayaran.
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>No. Permohonan</th>
                    <th>Wajib Pajak</th>
                    <th>BPHTB Terutang</th>
                    <th>Status</th>
                    <th>SSPD</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans as $item)
                <tr>
                    <td>
                        <a href="{{ route('permohonan.show', $item) }}" class="text-reset" tabindex="-1">
                            {{ $item->nomor_permohonan }}
                        </a>
                    </td>
                    <td>{{ $item->nama_wajib_pajak }}</td>
                    <td>Rp {{ number_format($item->bphtb_terutang) }}</td>
                    <td>
                        @if($item->status == \App\Enums\StatusPermohonan::Selesai)
                            <span class="badge bg-green text-uppercase">Lunas</span>
                        @else
                            <span class="badge bg-warning text-uppercase">Menunggu Pembayaran</span>
                        @endif
                    </td>
                    <td>
                        @if($item->pembayaran)
                            <span class="text-secondary small">{{ $item->pembayaran->nomor_sspd }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-end">
                        @if($item->status == \App\Enums\StatusPermohonan::Disetujui)
                        <button class="btn btn-primary btn-sm btn-bayar" 
                                data-id="{{ $item->id }}"
                                data-nomor="{{ $item->nomor_permohonan }}"
                                data-nama="{{ $item->nama_wajib_pajak }}"
                                data-terutang="{{ number_format($item->bphtb_terutang) }}"
                                data-bs-toggle="modal" data-bs-target="#modal-konfirmasi-pembayaran">
                            Konfirmasi Bayar
                        </button>
                        @elseif($item->status == \App\Enums\StatusPermohonan::Selesai)
                        <a href="{{ route('pembayaran.download', $item) }}" class="btn btn-outline-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                            Cetak SSPD
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-secondary py-4">Tidak ada data pembayaran yang ditemukan.</td>
                </tr>
                @endforelse
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

{{-- Modal Konfirmasi Pembayaran --}}
<div class="modal modal-blur fade" id="modal-konfirmasi-pembayaran" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf
                <input type="hidden" name="permohonan_id" id="payment-permohonan-id">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pembayaran BPHTB</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nomor Permohonan</label>
                        <input type="text" id="payment-nomor" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wajib Pajak</label>
                        <input type="text" id="payment-nama" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Pajak (Terutang)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="payment-terutang" class="form-control bg-light font-weight-bold" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="Bank Transfer">Bank Transfer (BJB/Riau Kepri)</option>
                            <option value="QRIS">QRIS / Pembayaran Digital</option>
                            <option value="Teller Bank">Teller Bank</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Masukkan nomor referensi transaksi jika ada"></textarea>
                    </div>
                    <div class="alert alert-info">
                        Dengan menekan tombol "Konfirmasi", Anda menyatakan bahwa pembayaran telah dilakukan sesuai dengan jumlah terutang.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bayarBtns = document.querySelectorAll('.btn-bayar');
    const paymentIdInput = document.getElementById('payment-permohonan-id');
    const paymentNomorInput = document.getElementById('payment-nomor');
    const paymentNamaInput = document.getElementById('payment-nama');
    const paymentTerutangInput = document.getElementById('payment-terutang');

    bayarBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            paymentIdInput.value = this.getAttribute('data-id');
            paymentNomorInput.value = this.getAttribute('data-nomor');
            paymentNamaInput.value = this.getAttribute('data-nama');
            paymentTerutangInput.value = this.getAttribute('data-terutang');
        });
    });
});
</script>
@endpush
@endsection
