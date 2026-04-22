<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'phone',
        'address',
        'npwp',
        'no_sk_ppat',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function permohonansSebagaiPemohon(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'user_id');
    }

    public function permohonansSebagaiPpat(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'ppat_id');
    }

    public function permohonansSebagaiVerifier(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'verified_by');
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'uploaded_by');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'created_by');
    }

    public function verifikasiLogs(): HasMany
    {
        return $this->hasMany(VerifikasiLog::class);
    }
}
