<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use Illuminate\Support\Facades\DB;
// day 7 progress tujuan: Progress = (Realisasi / Target) × 100
use App\Models\Target;
// day 7 progress model provinsi dan kabupaten untuk filter data
use App\Models\Provinsi;
use App\Models\Kabupaten;
// day 9 progress, komoditas 
use App\Models\Komoditas;

class DashboardController extends Controller
{
    public function index()
    {
        // Tahun yang dipilih dari dropdown
        $tahun = request('tahun', date('Y'));

        
    
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

            $chartData = $realisasiTable->map(function ($item) use ($targets) {

    return [

        'komoditas' => $item->komoditas->nama,

        'target' => $targets[$item->komoditas_id] ?? 0,

        'realisasi' => $item->total_realisasi,

    ];

});
        

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
                'provinsi',
                'kabupaten',
            ])
            ->groupBy(
                'komoditas_id',
                'provinsi_id',
                'kabupaten_id'
        )
            ->get();
        
        
        $kabupatenTargets = Target::select(
            'komoditas_id',
            'provinsi_id',
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
                'provinsi_id',
                'kabupaten_id'
            )
            ->get()
            ->keyBy(function ($item) {
            return
                $item->komoditas_id.'-'.
                $item->provinsi_id.'-'.
                $item->kabupaten_id;
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
            $provinsiTargets,
            $kabupatenRows,
            $kabupatenTargets
        ) { 

        $target = $targets[$item->komoditas_id] ?? 0;

        $progress = $target > 0
            ? round($item->total_realisasi / $target * 100, 2): 0;

        // Ambil semua provinsi untuk komoditas ini
        $provinsi = $provinsiRows
            ->where('komoditas_id', $item->komoditas_id)
            ->map(function ($p) use (
                $provinsiTargets,
                $kabupatenRows,
                $kabupatenTargets
            ) {

        $key = $p->komoditas_id.'-'.$p->provinsi_id;

        $target = $provinsiTargets[$key]->total_target ?? 0;

        $progress = $target > 0
            ? round($p->total_realisasi / $target * 100,2)
            : 0;

        
        $kabupaten = $kabupatenRows
            ->where('komoditas_id', $p->komoditas_id)
            ->where('provinsi_id', $p->provinsi_id)
            ->map(function ($k) use ($kabupatenTargets) {

        $key =
            $k->komoditas_id.'-'.
            $k->provinsi_id.'-'.
            $k->kabupaten_id;

        $target =
            $kabupatenTargets[$key]->total_target ?? 0;

        $progress = $target > 0
            ? round($k->total_realisasi / $target * 100,2)
            : 0;

        return [

            'kabupaten' => $k->kabupaten->nama,

            'target' => $target,

            'realisasi' => $k->total_realisasi,

            'progress' => $progress,

        ];

        })
             ->values();

            return [
                'provinsi'  => $p->provinsi->nama,
                'target'    => $target,
                'realisasi' => $p->total_realisasi,
                'progress'  => $progress,
                'kabupaten' => $kabupaten,
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
        
    /*
|--------------------------------------------------------------------------
| Data Peta Indonesia
|--------------------------------------------------------------------------
*/

        $mapTargets = Target::select(
        'provinsi_id',
        DB::raw('SUM(target) as total_target')
    )
        ->where('tahun', $tahun)

        

        ->when($provinsiId, function ($q) use ($provinsiId) {
            $q->where('provinsi_id', $provinsiId);
        })
        ->groupBy('provinsi_id')
        ->pluck('total_target', 'provinsi_id');

        $mapData = Realisasi::select(
            'provinsi_id',
            DB::raw('SUM(jumlah_output) as total_realisasi')
            )
            ->with('provinsi')
            ->where('tahun', $tahun)

            
            ->when($provinsiId, function ($q) use ($provinsiId) {
                $q->where('provinsi_id', $provinsiId);
            })
            
            ->groupBy('provinsi_id')
            ->get()
            ->map(function ($item) use ($mapTargets) {

            $target = $mapTargets[$item->provinsi_id] ?? 0;

$progress = $target > 0
    ? round(($item->total_realisasi / $target) * 100, 2)
    : 0;

return [

    'name' => $item->provinsi->nama,

    'value' => $progress,

];

    });
    // day 9 progress, komoditas
    $komoditas = Komoditas::whereHas('targets', function ($q) use ($tahun) {
    $q->where('tahun', $tahun);
    })
        ->orderBy('nama')
        ->get();
    // day 8 progress, menghapus provinsi rows dan kabupaten rows
        return view('dashboard.index', compact(
            'summary',
            'rows',
            'chartData',
            'tahun',
            'komoditas',
            'provinsis',
            'kabupatens',
            'provinsiId',
            'kabupatenId',
            'mapData'
        ));
    }

    // day 9 progress, implementasi AJAX di peta
    public function mapData()
{
    $tahun = request('tahun', date('Y'));

    $komoditasId = request('komoditas');

    $provinsiId = request('provinsi');

    $mapTargets = Target::select(
            'provinsi_id',
            DB::raw('SUM(target) as total_target')
        )
        ->where('tahun', $tahun)

        ->when($komoditasId, function ($q) use ($komoditasId) {
            $q->where('komoditas_id', $komoditasId);
        })

        ->when($provinsiId, function ($q) use ($provinsiId) {
            $q->where('provinsi_id', $provinsiId);
        })

        ->groupBy('provinsi_id')
        ->pluck('total_target', 'provinsi_id');


    $mapData = Realisasi::select(
            'provinsi_id',
            DB::raw('SUM(jumlah_output) as total_realisasi')
        )
        ->with('provinsi')

        ->where('tahun', $tahun)

        ->when($komoditasId, function ($q) use ($komoditasId) {
            $q->where('komoditas_id', $komoditasId);
        })

        ->when($provinsiId, function ($q) use ($provinsiId) {
            $q->where('provinsi_id', $provinsiId);
        })

        ->groupBy('provinsi_id')
        ->get()
        ->map(function ($item) use ($mapTargets) {

            $target = $mapTargets[$item->provinsi_id] ?? 0;

            $komoditasId = request('komoditas');

            $progress = $target > 0
                ? round(($item->total_realisasi / $target) * 100, 2)
                : 0;

            return [
                'name'  => $item->provinsi->nama,
                'value' => $progress,
            ];
        });

    return response()->json($mapData);
}
}      