@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Master Data
        </div>
        <h2 class="page-title">
            Setting NPOPTKP
        </h2>
    </div>
    <div class="col-auto ms-auto">
        <div class="btn-list">
            <button class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-npoptkp">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                Tambah Setting
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>Jenis Perolehan</th>
                    <th>Nilai NPOPTKP</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($settings as $setting)
                <tr>
                    <td>{{ str_replace('_', ' ', ucfirst($setting->jenis_perolehan->value)) }}</td>
                    <td>Rp {{ number_format($setting->nilai_npoptkp) }}</td>
                    <td>{{ $setting->tahun }}</td>
                    <td>
                        @if($setting->is_active)
                        <span class="badge bg-green">Aktif</span>
                        @else
                        <span class="badge bg-red">Non-Aktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-white edit-npoptkp"
                                data-id="{{ $setting->id }}"
                                data-jenis="{{ $setting->jenis_perolehan->value }}"
                                data-jenis-label="{{ str_replace('_', ' ', ucfirst($setting->jenis_perolehan->value)) }}"
                                data-nilai="{{ $setting->nilai_npoptkp }}"
                                data-status="{{ $setting->is_active }}"
                                data-bs-toggle="modal" data-bs-target="#modal-npoptkp-edit">
                            Edit
                        </button>
                        <form action="{{ route('npoptkp.destroy', $setting) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus setting ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal NPOPTKP Tambah --}}
<div class="modal modal-blur fade" id="modal-npoptkp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('npoptkp.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Setting NPOPTKP Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Jenis Perolehan</label>
                                <select class="form-select" name="jenis_perolehan" required>
                                    @foreach(\App\Enums\JenisPerolehan::cases() as $jenis)
                                        <option value="{{ $jenis->value }}">{{ str_replace('_', ' ', ucfirst($jenis->value)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Nilai NPOPTKP (Rp)</label>
                                <input type="number" class="form-control" name="nilai_npoptkp" placeholder="Contoh: 60000000" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Simpan Setting</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal NPOPTKP Edit --}}
<div class="modal modal-blur fade" id="modal-npoptkp-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form-npoptkp-edit" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Setting NPOPTKP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Perolehan</label>
                        <input type="text" class="form-control bg-light" id="edit-jenis-label" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai NPOPTKP (Rp)</label>
                        <input type="number" class="form-control" name="nilai_npoptkp" id="edit-nilai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" id="edit-status" class="form-select">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtns = document.querySelectorAll('.edit-npoptkp');
    const formEdit = document.getElementById('form-npoptkp-edit');
    const editJenisLabel = document.getElementById('edit-jenis-label');
    const editNilai = document.getElementById('edit-nilai');
    const editStatus = document.getElementById('edit-status');

    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const jenisLabel = this.getAttribute('data-jenis-label');
            const nilai = this.getAttribute('data-nilai');
            const status = this.getAttribute('data-status');

            formEdit.action = `/npoptkp/${id}`;
            editJenisLabel.value = jenisLabel;
            editNilai.value = nilai;
            editStatus.value = status;
        });
    });
});
</script>
@endpush
@endsection
