@extends('layouts.app')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            Permohonan
        </div>
        <h2 class="page-title">
            Edit Permohonan {{ $permohonan->nomor_permohonan }}
        </h2>
    </div>
</div>
@endsection

@section('content')
<div class="row row-cards">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    </div>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>
                    </div>
                    <div>
                        Terdapat kesalahan pada input Anda. Silakan periksa kembali.
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif
    </div>
    <div class="col-lg-8">
        <form action="{{ route('permohonan.update', $permohonan) }}" method="POST" enctype="multipart/form-data" class="card">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h3 class="card-header-title">Edit Formulir Pengajuan</h3>
            </div>
            <div class="card-body">
                <div class="row row-cards">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label required">Jenis Perolehan Hak</label>
                            <select class="form-select @error('jenis_perolehan_hak') is-invalid @enderror" id="jenis-perolehan" name="jenis_perolehan_hak">
                                @foreach(\App\Enums\JenisPerolehan::cases() as $jenis)
                                    <option value="{{ $jenis->value }}" {{ (old('jenis_perolehan_hak', $permohonan->jenis_perolehan->value) == $jenis->value) ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($jenis->value)) }}</option>
                                @endforeach
                            </select>
                            @error('jenis_perolehan_hak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="hr-text">Data Objek Pajak</div>

                    <div class="col-sm-6 col-md-4">
                        <div class="mb-3">
                            <label class="form-label required">NOP</label>
                            <input type="text" class="form-control @error('nop') is-invalid @enderror" name="nop" placeholder="14.02..." value="{{ old('nop', $permohonan->nop) }}">
                            @error('nop') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <div class="mb-3">
                            <label class="form-label required">Letak Tanah / Alamat</label>
                            <input type="text" class="form-control @error('letak_tanah_alamat') is-invalid @enderror" name="letak_tanah_alamat" placeholder="Alamat lengkap objek pajak" value="{{ old('letak_tanah_alamat', $permohonan->letak_tanah_alamat) }}">
                            @error('letak_tanah_alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3">
                            <label class="form-label required">Provinsi</label>
                            <select class="form-select" id="province-select" name="province_code">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->code }}" {{ old('province_code', $permohonan->province_code) == $province->code ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3">
                            <label class="form-label required">Kabupaten / Kota</label>
                            <select class="form-select" id="city-select" name="city_code">
                                <option value="">Pilih Kota</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3">
                            <label class="form-label required">Kecamatan</label>
                            <select class="form-select" id="district-select" name="district_code">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3">
                            <label class="form-label required">Kelurahan / Desa</label>
                            <select class="form-select" id="village-select" name="village_code">
                                <option value="">Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Luas Tanah (m2)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="luas-tanah" name="luas_tanah" value="{{ old('luas_tanah', $permohonan->luas_tanah) }}">
                                <span class="input-group-text">m2</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Luas Bangunan (m2)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="luas-bangunan" name="luas_bangunan" value="{{ old('luas_bangunan', $permohonan->luas_bangunan) }}">
                                <span class="input-group-text">m2</span>
                            </div>
                        </div>
                    </div>

                    <div class="hr-text">Data Transaksi</div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label required">Harga Transaksi / Nilai Pasar (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="harga-transaksi" name="harga_transaksi" placeholder="0" value="{{ old('harga_transaksi', $permohonan->harga_transaksi) }}">
                            </div>
                        </div>
                    </div>

                    <div class="hr-text">Data Wajib Pajak</div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" class="form-control" name="nama_wajib_pajak" value="{{ old('nama_wajib_pajak', $permohonan->nama_wajib_pajak) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">NIK</label>
                            <input type="text" class="form-control" name="nik_wajib_pajak" value="{{ old('nik_wajib_pajak', $permohonan->nik_wajib_pajak) }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label required">Alamat Domisili</label>
                            <textarea class="form-control @error('alamat_wajib_pajak') is-invalid @enderror" name="alamat_wajib_pajak" rows="2" required>{{ old('alamat_wajib_pajak', $permohonan->alamat_wajib_pajak) }}</textarea>
                            @error('alamat_wajib_pajak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="hr-text">Data Penjual</div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Nama Penjual</label>
                            <input type="text" class="form-control @error('nama_penjual') is-invalid @enderror" name="nama_penjual" value="{{ old('nama_penjual', $permohonan->nama_penjual) }}" required>
                            @error('nama_penjual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NIK Penjual</label>
                            <input type="text" class="form-control @error('nik_penjual') is-invalid @enderror" name="nik_penjual" value="{{ old('nik_penjual', $permohonan->nik_penjual) }}">
                            @error('nik_penjual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Alamat Penjual</label>
                            <textarea class="form-control @error('alamat_penjual') is-invalid @enderror" name="alamat_penjual" rows="2">{{ old('alamat_penjual', $permohonan->alamat_penjual) }}</textarea>
                            @error('alamat_penjual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="hr-text">Upload Dokumen (Opsional — kosongkan jika tidak berubah)</div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Fotokopi KTP (.pdf, .jpg)</label>
                            <input type="file" class="form-control" name="ktp">
                            @if($permohonan->dokumens->where('jenis_dokumen.value', 'ktp')->first())
                                <small class="text-muted">File saat ini: {{ $permohonan->dokumens->where('jenis_dokumen.value', 'ktp')->first()->nama_file }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Fotokopi SPPT PBB Terakhir</label>
                            <input type="file" class="form-control" name="sppt_pbb">
                            @if($permohonan->dokumens->where('jenis_dokumen.value', 'sppt_pbb')->first())
                                <small class="text-muted">File saat ini: {{ $permohonan->dokumens->where('jenis_dokumen.value', 'sppt_pbb')->first()->nama_file }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Bukti Lunas PBB</label>
                            <input type="file" class="form-control" name="bukti_lunas_pbb">
                            @if($permohonan->dokumens->where('jenis_dokumen.value', 'bukti_bayar_pbb')->first())
                                <small class="text-muted">File saat ini: {{ $permohonan->dokumens->where('jenis_dokumen.value', 'bukti_bayar_pbb')->first()->nama_file }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Fotokopi Sertifikat</label>
                            <input type="file" class="form-control" name="sertifikat">
                            @if($permohonan->dokumens->where('jenis_dokumen.value', 'sertifikat')->first())
                                <small class="text-muted">File saat ini: {{ $permohonan->dokumens->where('jenis_dokumen.value', 'sertifikat')->first()->nama_file }}</small>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">No. Akta / Pendaftar</label>
                            <input type="text" class="form-control @error('no_akta') is-invalid @enderror" name="no_akta" value="{{ old('no_akta', $permohonan->no_akta) }}">
                            @error('no_akta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Akta</label>
                            <input type="date" class="form-control @error('tanggal_akta') is-invalid @enderror" name="tanggal_akta" value="{{ old('tanggal_akta', $permohonan->tanggal_akta?->format('Y-m-d')) }}">
                            @error('tanggal_akta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nama PPAT Akta</label>
                            <input type="text" class="form-control @error('nama_ppat_akta') is-invalid @enderror" name="nama_ppat_akta" value="{{ old('nama_ppat_akta', $permohonan->nama_ppat_akta) }}">
                            @error('nama_ppat_akta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('permohonan.show', $permohonan) }}" class="btn btn-link link-secondary me-2">Batal</a>
                <button type="submit" name="action" value="draft" class="btn btn-secondary me-2">Simpan sebagai Draft</button>
                <button type="submit" name="action" value="submit" class="btn btn-primary">Ajukan Permohonan</button>
            </div>
        </form>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Simulasi Perhitungan</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-label">Total NJOP</div>
                    <div class="h2" id="summary-total-njop">Rp {{ number_format($permohonan->total_njop) }}</div>
                </div>
                <div class="mb-3">
                    <div class="form-label">NPOPTKP</div>
                    <div class="h2 text-secondary" id="summary-npoptkp">Rp {{ number_format($permohonan->npoptkp) }}</div>
                </div>
                <div class="mb-3">
                    <div class="form-label">BPHTB Terutang</div>
                    <div class="h1 text-primary" id="summary-bphtb-terutang">Rp {{ number_format($permohonan->bphtb_terutang) }}</div>
                </div>
            </div>
            <div class="card-footer small text-secondary">
                * Perhitungan akan direcalculate saat disimpan.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province-select');
    const citySelect = document.getElementById('city-select');
    const districtSelect = document.getElementById('district-select');
    const villageSelect = document.getElementById('village-select');

    // Pre-selected values from existing data
    const preselectedCity = "{{ old('city_code', $permohonan->city_code) }}";
    const preselectedDistrict = "{{ old('district_code', $permohonan->district_code) }}";
    const preselectedVillage = "{{ old('village_code', $permohonan->village_code) }}";

    function clearSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
    }

    async function fetchCities(provinceCode, selectedValue) {
        if (!provinceCode) return;
        try {
            const response = await fetch(`/api/address/cities?province_code=${provinceCode}`);
            const cities = await response.json();
            clearSelect(citySelect, 'Pilih Kota');
            clearSelect(districtSelect, 'Pilih Kecamatan');
            clearSelect(villageSelect, 'Pilih Kelurahan');
            cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.code;
                option.textContent = city.name;
                if (city.code === selectedValue) option.selected = true;
                citySelect.appendChild(option);
            });
            if (citySelect.value) fetchDistricts(citySelect.value, preselectedDistrict);
        } catch (error) {
            console.error('Error fetching cities:', error);
        }
    }

    async function fetchDistricts(cityCode, selectedValue) {
        if (!cityCode) return;
        try {
            const response = await fetch(`/api/address/districts?city_code=${cityCode}`);
            const districts = await response.json();
            clearSelect(districtSelect, 'Pilih Kecamatan');
            clearSelect(villageSelect, 'Pilih Kelurahan');
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.code;
                option.textContent = district.name;
                if (district.code === selectedValue) option.selected = true;
                districtSelect.appendChild(option);
            });
            if (districtSelect.value) fetchVillages(districtSelect.value, preselectedVillage);
        } catch (error) {
            console.error('Error fetching districts:', error);
        }
    }

    async function fetchVillages(districtCode, selectedValue) {
        if (!districtCode) return;
        try {
            const response = await fetch(`/api/address/villages?district_code=${districtCode}`);
            const villages = await response.json();
            clearSelect(villageSelect, 'Pilih Kelurahan');
            villages.forEach(village => {
                const option = document.createElement('option');
                option.value = village.code;
                option.textContent = village.name;
                if (village.code === selectedValue) option.selected = true;
                villageSelect.appendChild(option);
            });
            if (villageSelect.value) performCalculation();
        } catch (error) {
            console.error('Error fetching villages:', error);
        }
    }

    provinceSelect.addEventListener('change', e => fetchCities(e.target.value, ''));
    citySelect.addEventListener('change', e => fetchDistricts(e.target.value, ''));
    districtSelect.addEventListener('change', e => fetchVillages(e.target.value, ''));
    villageSelect.addEventListener('change', performCalculation);

    // Real-time Calculation Logic
    const jenisPerolehanSelect = document.getElementById('jenis-perolehan');
    const luasTanahInput = document.getElementById('luas-tanah');
    const luasBangunanInput = document.getElementById('luas-bangunan');
    const hargaTransaksiInput = document.getElementById('harga-transaksi');

    const summaryTotalNjop = document.getElementById('summary-total-njop');
    const summaryNpoptkp = document.getElementById('summary-npoptkp');
    const summaryBphtbTerutang = document.getElementById('summary-bphtb-terutang');

    async function performCalculation() {
        if (!villageSelect.value) return;
        const params = new URLSearchParams({
            jenis_perolehan: jenisPerolehanSelect.value,
            village_code: villageSelect.value,
            luas_tanah: luasTanahInput.value || 0,
            luas_bangunan: luasBangunanInput.value || 0,
            harga_transaksi: hargaTransaksiInput.value || 0
        });
        try {
            const response = await fetch(`/api/calculate?${params.toString()}`);
            const result = await response.json();
            if (response.ok) {
                summaryTotalNjop.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(result.total_njop)}`;
                summaryNpoptkp.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(result.npoptkp)}`;
                summaryBphtbTerutang.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(result.bphtb_terutang)}`;
            }
        } catch (error) {
            console.error('Calculation error:', error);
        }
    }

    [jenisPerolehanSelect, luasTanahInput, luasBangunanInput, hargaTransaksiInput].forEach(el => {
        el.addEventListener('change', performCalculation);
        el.addEventListener('input', performCalculation);
    });

    // Initial load: cascade the address dropdowns
    if (provinceSelect.value) {
        fetchCities(provinceSelect.value, preselectedCity);
    }
});
</script>
@endpush
