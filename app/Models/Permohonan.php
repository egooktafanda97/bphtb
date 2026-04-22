<?php

namespace App\Models;

use App\Enums\JenisPerolehan;
use App\Enums\StatusPermohonan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';

    protected $fillable = [
        'nomor_permohonan',
        'user_id',
        'ppat_id',
        'verified_by',
        'jenis_perolehan',
        'status',
        'nop',
        'letak_tanah_alamat',
        'kelurahan',
        'kecamatan',
        'province_code',
        'city_code',
        'district_code',
        'village_code',
        'luas_tanah',
        'luas_bangunan',
        'njop_tanah_per_m2',
        'njop_bangunan_per_m2',
        'total_njop_tanah',
        'total_njop_bangunan',
        'total_njop',
        'harga_transaksi',
        'npop',
        'npoptkp',
        'npop_kena_pajak',
        'bphtb_terutang',
        'nama_wajib_pajak',
        'nik_wajib_pajak',
        'alamat_wajib_pajak',
        'nama_penjual',
        'nik_penjual',
        'alamat_penjual',
        'no_akta',
        'tanggal_akta',
        'nama_ppat_akta',
        'tanggal_pengajuan',
        'tanggal_verifikasi',
        'catatan_verifikasi',
    ];

    protected function casts(): array
    {
        return [
            'jenis_perolehan' => JenisPerolehan::class,
            'status' => StatusPermohonan::class,
            'luas_tanah' => 'decimal:2',
            'luas_bangunan' => 'decimal:2',
            'njop_tanah_per_m2' => 'decimal:2',
            'njop_bangunan_per_m2' => 'decimal:2',
            'total_njop_tanah' => 'decimal:2',
            'total_njop_bangunan' => 'decimal:2',
            'total_njop' => 'decimal:2',
            'harga_transaksi' => 'decimal:2',
            'npop' => 'decimal:2',
            'npoptkp' => 'decimal:2',
            'npop_kena_pajak' => 'decimal:2',
            'bphtb_terutang' => 'decimal:2',
            'tanggal_akta' => 'date',
            'tanggal_pengajuan' => 'date',
            'tanggal_verifikasi' => 'date',
        ];
    }

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ppat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ppat_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class)->latestOfMany();
    }

    public function verifikasiLogs(): HasMany
    {
        return $this->hasMany(VerifikasiLog::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_code', 'code');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'village_code', 'code');
    }
}
