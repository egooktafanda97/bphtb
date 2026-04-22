<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SSPD - {{ $permohonan->nomor_permohonan }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 0; padding: 0; }
        .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header h2 { margin: 5px 0; font-size: 14px; }
        .content-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .content-table th, .content-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .content-table th { background-color: #f5f5f5; width: 30%; }
        .section-title { background-color: #eee; font-weight: bold; padding: 5px; margin-top: 10px; border: 1px solid #ccc; }
        .footer { margin-top: 30px; }
        .signature-table { width: 100%; }
        .signature-table td { width: 50%; text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .border-none { border: none !important; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pemerintah Kabupaten Kuantan Singingi</h1>
        <h2>Badan Pendapatan Daerah</h2>
        <p>Surat Setoran Pajak Daerah (SSPD) - BPHTB</p>
    </div>

    <table class="content-table">
        <tr>
            <th>Nomor SSPD</th>
            <td class="font-bold">{{ $permohonan->pembayaran->nomor_sspd }}</td>
        </tr>
        <tr>
            <th>Nomor Permohonan</th>
            <td>{{ $permohonan->nomor_permohonan }}</td>
        </tr>
        <tr>
            <th>Tanggal Bayar</th>
            <td>{{ $permohonan->pembayaran->tanggal_bayar->format('d/m/Y') }}</td>
        </tr>
    </table>

    <div class="section-title">A. DATA WAJIB PAJAK</div>
    <table class="content-table">
        <tr>
            <th>Nama Wajib Pajak</th>
            <td>{{ $permohonan->nama_wajib_pajak }}</td>
        </tr>
        <tr>
            <th>NIK</th>
            <td>{{ $permohonan->nik_wajib_pajak }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $permohonan->alamat_wajib_pajak }}</td>
        </tr>
    </table>

    <div class="section-title">B. DATA OBJEK PAJAK</div>
    <table class="content-table">
        <tr>
            <th>NOP</th>
            <td>{{ $permohonan->nop }}</td>
        </tr>
        <tr>
            <th>Letak Tanah / Alamat</th>
            <td>{{ $permohonan->letak_tanah_alamat }}</td>
        </tr>
        <tr>
            <th>Kelurahan / Desa</th>
            <td>{{ $permohonan->village->name }}</td>
        </tr>
        <tr>
            <th>Kecamatan</th>
            <td>{{ $permohonan->district->name }}</td>
        </tr>
        <tr>
            <th>Luas Tanah / Bangunan</th>
            <td>{{ number_format($permohonan->luas_tanah) }} m2 / {{ number_format($permohonan->luas_bangunan) }} m2</td>
        </tr>
    </table>

    <div class="section-title">C. PERHITUNGAN BPHTB</div>
    <table class="content-table">
        <tr>
            <th>Harga Transaksi / Nilai Pasar</th>
            <td class="text-right">Rp {{ number_format($permohonan->harga_transaksi) }}</td>
        </tr>
        <tr>
            <th>NPOP (Nilai Perolehan Objek Pajak)</th>
            <td class="text-right">Rp {{ number_format($permohonan->npop) }}</td>
        </tr>
        <tr>
            <th>NPOPTKP (Pengurang)</th>
            <td class="text-right">Rp {{ number_format($permohonan->npoptkp) }}</td>
        </tr>
        <tr>
            <th>NPOP Kena Pajak</th>
            <td class="text-right">Rp {{ number_format($permohonan->npop_kena_pajak) }}</td>
        </tr>
        <tr class="font-bold">
            <th>BPHTB Terutang (5%)</th>
            <td class="text-right">Rp {{ number_format($permohonan->bphtb_terutang) }}</td>
        </tr>
    </table>

    <div class="section-title">D. STATUS PEMBAYARAN</div>
    <table class="content-table">
        <tr>
            <th>Metode Pembayaran</th>
            <td>{{ $permohonan->pembayaran->metode_pembayaran }}</td>
        </tr>
        <tr>
            <th>Jumlah Dibayar</th>
            <td class="font-bold">Rp {{ number_format($permohonan->pembayaran->jumlah_bayar) }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td style="color: green; font-weight: bold;">LUNAS</td>
        </tr>
    </table>

    <div class="footer">
        <table class="signature-table">
            <tr>
                <td>
                    <p>Wajib Pajak / Penyetor</p>
                    <br><br><br>
                    <p>( {{ $permohonan->nama_wajib_pajak }} )</p>
                </td>
                <td>
                    <p>Teluk Kuantan, {{ now()->translatedFormat('d F Y') }}</p>
                    <p>Petugas Penerima,</p>
                    <br><br><br>
                    <p>( ........................................ )</p>
                </td>
            </tr>
        </table>
        <div style="text-align: center; margin-top: 20px; font-size: 10px; color: #666;">
            Dokumen ini dicetak otomatis melalui Sistem E-BPHTB Kabupaten Kuantan Singingi.<br>
            ID Transaksi: {{ $permohonan->pembayaran->id }} | Hash: {{ md5($permohonan->pembayaran->nomor_sspd) }}
        </div>
    </div>
</body>
</html>
