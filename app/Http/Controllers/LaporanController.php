<?php

namespace App\Http\Controllers;

use App\Enums\StatusPermohonan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\District;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $districtCode = $request->input('district_code');

        $query = Permohonan::with(['district', 'village', 'pemohon'])
            ->whereBetween('tanggal_pengajuan', [$startDate, $endDate]);

        if ($districtCode) {
            $query->where('district_code', $districtCode);
        }

        // Summary metrics
        $totalPermohonan = (clone $query)->count();
        $totalRevenue = (clone $query)->where('status', StatusPermohonan::Selesai)->sum('bphtb_terutang');
        $totalPending = (clone $query)->whereIn('status', [StatusPermohonan::Diajukan, StatusPermohonan::Diverifikasi])->count();

        $printPermohonans = (clone $query)
            ->orderBy('tanggal_pengajuan')
            ->orderBy('nomor_permohonan')
            ->get();

        $permohonans = $query->latest()->paginate(20);
        $districts = District::where('city_code', '1409')->orderBy('name')->get(); // Kuansing

        return view('laporan.index', compact(
            'permohonans',
            'printPermohonans',
            'districts',
            'totalPermohonan',
            'totalRevenue',
            'totalPending',
            'startDate',
            'endDate',
            'districtCode'
        ));
    }
}
