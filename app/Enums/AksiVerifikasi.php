<?php

namespace App\Enums;

enum AksiVerifikasi: string
{
    case Diajukan = 'diajukan';
    case Diverifikasi = 'diverifikasi';
    case Disetujui = 'disetujui';
    case Ditolak = 'ditolak';
    case Revisi = 'revisi';
}
