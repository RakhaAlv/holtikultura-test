<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use Illuminate\Support\Facades\DB;
// day 7 progress tujuan: Progress = (Realisasi / Target) × 100
use App\Models\Target;
// day 7 progress model provinsi dan kabupaten untuk filter data
use App\Models\Provinsi;
use App\Models\Kabupaten;

class DashboardController extends Controller
{
    public function index()
    {
        // Tahun yang dipilih dari dropdown
        $tahun = request('tahun', 2025);
    
        $provinsiId = request('provinsi');
        $kabupatenId = request('kabupaten');
        // day 7 progress, Ambil semua provinsi untuk mengisi dropdown.
        $provinsis = Provinsi::orderBy('nama')->get();

        $kabupatens = Kabupaten::query();

            if ($provinsiId) {
            $kabupatens->where('provinsi_id', $provinsiId);
        }
            $kabupatens = $kabupatens
                ->orderBy('nama')
                ->get();

        // diambil dari tabel targets
        $targets = Target::select(
            'komoditas_id',
                DB::raw('SUM(target) as total_target')
                )
                ->where('tahun', $tahun)
                ->when($provinsiId, function ($q) use ($provinsiId) {
                    $q->where('provinsi_id', $provinsiId);
                })
                ->when($kabupatenId, function ($q) use ($kabupatenId) {
                    $q->where('kabupaten_id', $kabupatenId);
                })
                ->groupBy('komoditas_id')
                ->pluck('total_target', 'komoditas_id');

                    

        /*
        |--------------------------------------------------------------------------
        | Summary Card
        |--------------------------------------------------------------------------
        */

        $summary = Realisasi::select(
                'komoditas_id',
                DB::raw('SUM(jumlah_output) as total_realisasi')
            )
            ->where('tahun', $tahun)
            ->when($provinsiId, function ($q) use ($provinsiId) {
                $q->where('provinsi_id', $provinsiId);
            })
            ->when($kabupatenId, function ($q) use ($kabupatenId) {
                $q->where('kabupaten_id', $kabupatenId);
            })
            ->whereHas('komoditas', function ($query) {
                $query->whereIn('nama', [
                    'Bawang Putih',
                    'Bawang Merah',
                    'Cabai',
                    'Durian',
                ]);
            })
            ->with('komoditas')
            ->groupBy('komoditas_id')
            ->get()
            ->map(function ($item) use ($targets) {
                
            // day 7 progress, Hitung progress berdasarkan rumus: Progress = (Realisasi / Target) × 100
        $target = $targets[$item->komoditas_id] ?? 0;

        $progress = 0;

            if ($target > 0) {
                $progress = round(($item->total_realisasi / $target) * 100, 2);
            }
            return [
                'name' => $item->komoditas->nama,
                    
                // sementara icon masih hardcode
                'icon' => match ($item->komoditas->nama) {
                    'Bawang Putih' => 'Bawang-Putih-Card.svg',
                    'Bawang Merah' => 'Bawang-Merah-Card.svg',
                    'Cabai' => 'Cabai-Card.svg',
                    'Durian' => 'Durian-Card.svg',
                    default => 'default.svg',
                },

                'target' => number_format(
                    $target,
                    0,
                    ',',
                    '.'
                ) . ' Ha',
               
                'realisasi' => number_format(
                    $item->total_realisasi,
                    0,
                    ',',
                    '.'
                ) . ' Ha',

                'progress' => $progress,
            ];
        });
        $realisasiTable = Realisasi::select(
                'komoditas_id',
                DB::raw('SUM(jumlah_output) as total_realisasi')
            )
            ->where('tahun', $tahun)
            ->when($provinsiId, function ($q) use ($provinsiId) {
                $q->where('provinsi_id', $provinsiId);
            })
            ->when($kabupatenId, function ($q) use ($kabupatenId) {
                $q->where('kabupaten_id', $kabupatenId);
            })
            ->with('komoditas')
            ->groupBy('komoditas_id')
            ->get();
        

        //day 7 progress, query provinsi dan kabupaten untuk filter data
        $provinsiRows = Realisasi::select(
            'komoditas_id',
            'provinsi_id',
            DB::raw('SUM(jumlah_output) as total_realisasi')
            )
            ->where('tahun', $tahun)
            ->when($provinsiId, function ($q) use ($provinsiId) {
                $q->where('provinsi_id', $provinsiId);
            })
            ->with([
                'komoditas',
                'provinsi'
            ])
            ->groupBy(
                'komoditas_id',
                'provinsi_id'
            )
            ->get();
        
        $provinsiTargets = Target::select(
        'komoditas_id',
        'provinsi_id',
        DB::raw('SUM(target) as total_target')
    )
    ->where('tahun', $tahun)
    ->when($provinsiId, function ($q) use ($provinsiId) {
        $q->where('provinsi_id', $provinsiId);
    })
    ->when($kabupatenId, function ($q) use ($kabupatenId) {
        $q->where('kabupaten_id', $kabupatenId);
    })
    ->groupBy(
        'komoditas_id',
        'provinsi_id'
    )
    ->get()
    ->keyBy(function ($item) {
        return $item->komoditas_id . '-' . $item->provinsi_id;
    });

    
        /*
        |--------------------------------------------------------------------------
        | Rekap Table
        |--------------------------------------------------------------------------
        | 
        */
        $rows = $realisasiTable->map(function ($item) use (
            $targets,
            $provinsiRows,
            $provinsiTargets
        ) { 

        $target = $targets[$item->komoditas_id] ?? 0;

        $progress = $target > 0
            ? round($item->total_realisasi / $target * 100, 2): 0;

        // Ambil semua provinsi untuk komoditas ini
        $provinsi = $provinsiRows
            ->where('komoditas_id', $item->komoditas_id)
            ->map(function ($p) use ($provinsiTargets) {

        $key = $p->komoditas_id.'-'.$p->provinsi_id;

        $target = $provinsiTargets[$key]->total_target ?? 0;

        $progress = $target > 0
            ? round($p->total_realisasi / $target * 100,2)
            : 0;

        return [
            'provinsi'  => $p->provinsi->nama,
            'target'    => $target,
            'realisasi' => $p->total_realisasi,
            'progress'  => $progress,
        ];

    })
    ->values();

        return [
            'komoditas_id' => $item->komoditas_id,
            'komoditas'    => $item->komoditas->nama,
            'target'       => $target,
            'realisasi'    => $item->total_realisasi,
            'progress'     => $progress,
            'provinsi'     => $provinsi,
        ];

    });
        
        

        $kabupatenTargets = Target::select(
            'komoditas_id',
            'kabupaten_id',
        DB::raw('SUM(target) as total_target')
            )
            ->where('tahun', $tahun)
            ->when($provinsiId, function ($q) use ($provinsiId) {
                $q->where('provinsi_id', $provinsiId);
            })
            ->when($kabupatenId, function ($q) use ($kabupatenId) {
                $q->where('kabupaten_id', $kabupatenId);
            })
            ->groupBy(
                'komoditas_id',
                'kabupaten_id'
        )
            ->get()
            ->keyBy(function ($item) {
            return $item->komoditas_id.'-'.$item->kabupaten_id;
        });

        
        
        

        $provinsiRows = $provinsiRows->map(function ($item) use ($provinsiTargets) {
            
            $key = $item->komoditas_id . '-' . $item->provinsi_id;

            $target = $provinsiTargets[$key]->total_target ?? 0;

            $progress = 0;

            if ($target > 0) {
                $progress = round(
                ($item->total_realisasi / $target) * 100,2);
            }

            return [
                'komoditas_id' => $item->komoditas_id,
                'provinsi_id'  => $item->provinsi_id,

                'komoditas' => $item->komoditas->nama,
                'provinsi'  => $item->provinsi->nama,

                'target' => $target,
                'realisasi' => $item->total_realisasi,
                'progress' => $progress,
            ];
        });

        $kabupatenRows = Realisasi::select(
        'komoditas_id',
        'provinsi_id',
        'kabupaten_id',
        DB::raw('SUM(jumlah_output) as total_realisasi')
    )
        ->where('tahun', $tahun)
        ->when($provinsiId, function ($q) use ($provinsiId) {
            $q->where('provinsi_id', $provinsiId);
        })
        ->when($kabupatenId, function ($q) use ($kabupatenId) {
            $q->where('kabupaten_id', $kabupatenId);
        })
        ->with([
            'komoditas',
            'provinsi',
            'kabupaten'
        ])
        ->groupBy(
            'komoditas_id',
            'provinsi_id',
            'kabupaten_id'
        )
        ->get();

        $kabupatenRows = $kabupatenRows->map(function ($item) use ($kabupatenTargets) {

        $key = $item->komoditas_id.'-'.$item->kabupaten_id;

        $target = $kabupatenTargets[$key]->total_target ?? 0;

        $progress = 0;

        if ($target > 0) {
            $progress = round(
                ($item->total_realisasi / $target) * 100,2);
    }

    return [

        'komoditas_id' => $item->komoditas_id,

        'provinsi_id' => $item->provinsi_id,

        'kabupaten_id' => $item->kabupaten_id,

        'komoditas' => $item->komoditas->nama,

        'provinsi' => $item->provinsi->nama,

        'kabupaten' => $item->kabupaten->nama,

        'target' => $target,

        'realisasi' => $item->total_realisasi,

        'progress' => $progress,

    ];
});

        return view('dashboard.index', compact(
            'summary',
            'rows',
            'provinsiRows',
            'kabupatenRows',
            'tahun',
            'provinsis',
            'kabupatens',
            'provinsiId',
            'kabupatenId'
        ));
    }
}