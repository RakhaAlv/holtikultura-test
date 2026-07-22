<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use Illuminate\Support\Facades\DB;
// day 6 progress, dashboard controller
class DashboardController extends Controller
{
    public function index()
    {
        $tahun = date('Y');

        // Mapping icon komoditas
        $icons = [
            'Bawang Putih' => 'Bawang-Putih-Card.svg',
            'Bawang Merah' => 'Bawang-Merah-Card.svg',
            'Cabai'        => 'Cabai-Card.svg',
            'Durian'       => 'Durian-Card.svg',
        ];

        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARD
        |--------------------------------------------------------------------------
        */

        $summary = Realisasi::select(
                'komoditas_id',
                DB::raw('SUM(jumlah_output) as realisasi')
            )
            ->with('komoditas')
            ->whereHas('komoditas', function ($query) {
                $query->where('nama', '!=', 'P2B');
            })
            ->where('tahun', $tahun)
            ->groupBy('komoditas_id')
            ->get()
            ->map(function ($item) use ($icons) {

                return [
                    'name'       => $item->komoditas->nama,
                    'icon'       => $icons[$item->komoditas->nama] ?? 'default.png',
                    'target'     => '-',
                    'realisasi'  => number_format($item->realisasi, 0, ',', '.') . ' Ha',
                    'progress'   => 0,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | REKAP TABLE
        |--------------------------------------------------------------------------
        */

        $rows = Realisasi::select(
                'komoditas_id',
                DB::raw('SUM(jumlah_output) as realisasi')
            )
            ->with('komoditas')
            ->whereHas('komoditas', function ($query) {
                $query->where('nama', '!=', 'P2B');
            })
            ->where('tahun', $tahun)
            ->groupBy('komoditas_id')
            ->get()
            ->map(function ($item) {

                return [
                    'komoditas'  => $item->komoditas->nama,
                    'wilayah'    => 'Nasional',
                    'target'     => '-',
                    'realisasi'  => number_format($item->realisasi, 0, ',', '.') . ' Ha',
                    'persentase' => '0%',
                ];
            });

        return view('dashboard.index', compact('summary', 'rows'));
    }
}