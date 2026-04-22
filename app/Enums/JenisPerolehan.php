<?php

namespace App\Enums;

enum JenisPerolehan: string
{
    case JualBeli = 'jual_beli';
    case TukarMenukar = 'tukar_menukar';
    case Hibah = 'hibah';
    case HibahWasiat = 'hibah_wasiat';
    case Waris = 'waris';
    case PemasukanPerseroan = 'pemasukan_perseroan';
    case PemisahanHak = 'pemisahan_hak';
    case Lelang = 'lelang';
    case PelaksanaanPutusan = 'pelaksanaan_putusan';
    case Penggabungan = 'penggabungan';
    case Peleburan = 'peleburan';
    case Pemekaran = 'pemekaran';
    case HadiahUndian = 'hadiah_undian';
}
