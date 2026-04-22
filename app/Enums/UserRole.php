<?php

namespace App\Enums;

enum UserRole: string
{
    case WajibPajak = 'wajib_pajak';
    case Ppat = 'ppat';
    case Admin = 'admin';
}
