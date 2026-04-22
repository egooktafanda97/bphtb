<?php

namespace App\Enums;

enum JenisDokumen: string
{
    case Ktp = 'ktp';
    case Npwp = 'npwp';
    case AktaJualBeli = 'akta_jual_beli';
    case Sertifikat = 'sertifikat';
    case SpptPbb = 'sppt_pbb';
    case BuktiBayarPbb = 'bukti_bayar_pbb';
    case SuratKuasa = 'surat_kuasa';
    case Lainnya = 'lainnya';
}
