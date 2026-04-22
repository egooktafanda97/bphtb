@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Master Data
        </div>
        <h2 class="page-title">
            Data Referensi NJOP
        </h2>
    </div>
    <div class="col-auto ms-auto">
        <div class="btn-list">
            <button class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-njop">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                Tambah NJOP
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
                    <th>Kecamatan</th>
                    <th>Kelurahan/Desa</th>
                    <th>NJOP Tanah (/m2)</th>
                    <th>NJOP Bangunan (/m2)</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($njops as $njop)
                <tr>
                    <td>{{ $njop->district->name ?? $njop->kecamatan }}</td>
                    <td>{{ $njop->village->name ?? $njop->kelurahan }}</td>
                    <td>Rp {{ number_format($njop->njop_tanah_per_m2) }}</td>
                    <td>Rp {{ number_format($njop->njop_bangunan_per_m2) }}</td>
                    <td>{{ $njop->tahun }}</td>
                    <td>
                        @if($njop->is_active)
                        <span class="badge bg-green">Aktif</span>
                        @else
                        <span class="badge bg-red">Non-Aktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-white edit-njop" 
                                data-id="{{ $njop->id }}"
                                data-tanah="{{ $njop->njop_tanah_per_m2 }}"
                                data-bangunan="{{ $njop->njop_bangunan_per_m2 }}"
                                data-status="{{ $njop->is_active }}"
                                data-location="{{ ($njop->district->name ?? $njop->kecamatan) . ' - ' . ($njop->village->name ?? $njop->kelurahan) }}"
                                data-bs-toggle="modal" data-bs-target="#modal-njop-edit">
                            Edit
                        </button>
                        <form action="{{ route('njop.destroy', $njop) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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

{{-- Modal NJOP Tambah --}}
<div class="modal modal-blur fade" id="modal-njop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('njop.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Referensi NJOP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <select class="form-select" id="province-select" name="province_code">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->code }}" {{ $province->code == '14' ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Kabupaten / Kota</label>
                                <select class="form-select" id="city-select" name="city_code">
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Kecamatan</label>
                                <select class="form-select" id="district-select" name="district_code">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Kelurahan / Desa</label>
                                <select class="form-select" id="village-select" name="village_code">
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">NJOP Tanah (/m2)</label>
                                <input type="number" class="form-control" name="njop_tanah_per_m2" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">NJOP Bangunan (/m2)</label>
                                <input type="number" class="form-control" name="njop_bangunan_per_m2" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ms-auto">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal NJOP Edit --}}
<div class="modal modal-blur fade" id="modal-njop-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form-njop-edit" action="" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data NJOP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Wilayah</label>
                        <input type="text" class="form-control bg-light" id="edit-location" readonly>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">NJOP Tanah (/m2)</label>
                                <input type="number" class="form-control" name="njop_tanah_per_m2" id="edit-tanah" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">NJOP Bangunan (/m2)</label>
                                <input type="number" class="form-control" name="njop_bangunan_per_m2" id="edit-bangunan" required>
                            </div>
                        </div>
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
    const provinceSelect = document.getElementById('province-select');
    const citySelect = document.getElementById('city-select');
    const districtSelect = document.getElementById('district-select');
    const villageSelect = document.getElementById('village-select');

    async function fetchCities(provinceCode) {
        if (!provinceCode) return;
        const response = await fetch(`/api/address/cities?province_code=${provinceCode}`);
        const cities = await response.json();
        citySelect.innerHTML = '<option value="">Pilih Kota</option>';
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.code;
            option.textContent = city.name;
            if (city.code === '1409') option.selected = true; // Auto-select Kuansing
            citySelect.appendChild(option);
        });
        if (citySelect.value === '1409') fetchDistricts('1409');
    }

    async function fetchDistricts(cityCode) {
        if (!cityCode) return;
        const response = await fetch(`/api/address/districts?city_code=${cityCode}`);
        const districts = await response.json();
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        districts.forEach(district => {
            const option = document.createElement('option');
            option.value = district.code;
            option.textContent = district.name;
            districtSelect.appendChild(option);
        });
    }

    async function fetchVillages(districtCode) {
        if (!districtCode) return;
        const response = await fetch(`/api/address/villages?district_code=${districtCode}`);
        const villages = await response.json();
        villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
        villages.forEach(village => {
            const option = document.createElement('option');
            option.value = village.code;
            option.textContent = village.name;
            villageSelect.appendChild(option);
        });
    }

    provinceSelect.addEventListener('change', e => fetchCities(e.target.value));
    citySelect.addEventListener('change', e => fetchDistricts(e.target.value));
    districtSelect.addEventListener('change', e => fetchVillages(e.target.value));

    // Handle Edit Modal
    const editBtns = document.querySelectorAll('.edit-njop');
    const formEdit = document.getElementById('form-njop-edit');
    const editLocation = document.getElementById('edit-location');
    const editTanah = document.getElementById('edit-tanah');
    const editBangunan = document.getElementById('edit-bangunan');
    const editStatus = document.getElementById('edit-status');

    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const location = this.getAttribute('data-location');
            const tanah = this.getAttribute('data-tanah');
            const bangunan = this.getAttribute('data-bangunan');
            const status = this.getAttribute('data-status');

            formEdit.action = `/njop/${id}`;
            editLocation.value = location;
            editTanah.value = tanah;
            editBangunan.value = bangunan;
            editStatus.value = status;
        });
    });

    // Handle initial load
    if (provinceSelect.value) {
        fetchCities(provinceSelect.value);
    }
});
</script>
@endpush
@endsection
