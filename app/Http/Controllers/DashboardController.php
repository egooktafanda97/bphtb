<?php

namespace App\Http\Controllers;

use App\Enums\StatusPermohonan;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_permohonan' => Permohonan::count(),
            'permohonan_baru' => Permohonan::where('status', StatusPermohonan::Diajukan)->count(),
            'total_setoran' => Permohonan::whereIn('status', [StatusPermohonan::Disetujui, StatusPermohonan::Selesai])->sum('bphtb_terutang'),
            'permohonan_selesai' => Permohonan::where('status', StatusPermohonan::Selesai)->count(),
        ];

        // Fetch 7-day trend
        $trendDates = collect();
        $trendData = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = Permohonan::whereDate('tanggal_pengajuan', $date)->count();

            $trendDates->push(now()->subDays($i)->format('d M'));
            $trendData->push($count);
        }

        return view('dashboard', compact('metrics', 'trendDates', 'trendData'));
    }
}
