<?php

namespace App\Models;

use App\Enums\JenisPerolehan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NpoptkpSetting extends Model
{
    use HasFactory;

    protected $table = 'npoptkp_settings';

    protected $fillable = [
        'jenis_perolehan',
        'nilai_npoptkp',
        'tahun',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'jenis_perolehan' => JenisPerolehan::class,
            'is_active' => 'boolean',
            'nilai_npoptkp' => 'decimal:2',
        ];
    }
}
