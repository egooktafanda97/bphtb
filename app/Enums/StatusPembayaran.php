<?php

namespace App\Enums;

enum StatusPembayaran: string
{
    case Pending = 'pending';
    case Lunas = 'lunas';
    case Batal = 'batal';
}
