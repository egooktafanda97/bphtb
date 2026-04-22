<?php

namespace App\Models;

use App\Enums\AksiVerifikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiLog extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_logs';

    protected $fillable = [
        'permohonan_id',
        'user_id',
        'aksi',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'aksi' => AksiVerifikasi::class,
        ];
    }

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
