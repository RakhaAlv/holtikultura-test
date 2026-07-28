<?php

namespace App\Http\Controllers;

use App\Models\Komoditas;
use App\Models\Target;
use App\Models\Realisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomoditasController extends Controller
{
    
    public function show(Komoditas $komoditas)
    {
        $tahun = session('tahun', 2025);

        $totalTarget = Target::where('komoditas_id', $komoditas->id)
            ->where('tahun', $tahun)
            ->sum('target');

        $totalRealisasi = Realisasi::where('komoditas_id', $komoditas->id)
            ->where('tahun', $tahun)
            ->sum('jumlah_output');

        $progress = $totalTarget > 0
            ? round(($totalRealisasi / $totalTarget) * 100, 2)
            : 0;
        
        $targetProvinsi = Target::select(
            'provinsi_id',
            DB::raw('SUM(target) as target')
            )
            ->where('komoditas_id', $komoditas->id)
            ->where('tahun', $tahun)
            ->groupBy('provinsi_id')
            ->pluck('target','provinsi_id');
        
        $chartData = Realisasi::select(
        'provinsi_id',
        DB::raw('SUM(jumlah_output) as realisasi')
    )
    ->with('provinsi')
    ->where('komoditas_id',$komoditas->id)
    ->where('tahun',$tahun)
    ->groupBy('provinsi_id')
    ->get()
    ->map(function($item) use ($targetProvinsi){

        return [

            'provinsi'=>$item->provinsi->nama,

            'target'=>$targetProvinsi[$item->provinsi_id] ?? 0,

            'realisasi'=>$item->realisasi

        ];

    });

        // agar tabel provinsi muncul maka harus ada data provinsi dan kabupaten 
        $targetsGrouped = Target::with(['provinsi', 'kabupaten'])
            ->where('komoditas_id', $komoditas->id)
            ->where('tahun', $tahun)
            ->select('provinsi_id', 'kabupaten_id', DB::raw('SUM(target) as target'))
            ->groupBy('provinsi_id', 'kabupaten_id')
            ->get();

        // agar realisasi muncul maka harus ada data di tabel realisasi
        $realisasisGrouped = Realisasi::with(['provinsi', 'kabupaten'])
            ->where('komoditas_id', $komoditas->id)
            ->where('tahun', $tahun)
            ->select('provinsi_id', 'kabupaten_id', DB::raw('SUM(jumlah_output) as realisasi'))
            ->groupBy('provinsi_id', 'kabupaten_id')
            ->get();

        $tableData = [];

        
        foreach ($targetsGrouped as $t) {
            $provId = $t->provinsi_id;
            $kabId = $t->kabupaten_id;
            
            if ($provId === null || $kabId === null) continue;

            if (!isset($tableData[$provId])) {
                $tableData[$provId] = [
                    'nama' => $t->provinsi->nama ?? 'Unknown',
                    'target' => 0,
                    'realisasi' => 0,
                    'kabupatens' => []
                ];
            }
            
            $tableData[$provId]['kabupatens'][$kabId] = [
                'nama' => $t->kabupaten->nama ?? 'Unknown',
                'target' => $t->target,
                'realisasi' => 0,
            ];
        }

        // grouping realisasi 
        foreach ($realisasisGrouped as $r) {
            $provId = $r->provinsi_id;
            $kabId = $r->kabupaten_id;
            
            if ($provId === null || $kabId === null) continue;

            if (!isset($tableData[$provId])) {
                $tableData[$provId] = [
                    'nama' => $r->provinsi->nama ?? 'Unknown',
                    'target' => 0,
                    'realisasi' => 0,
                    'kabupatens' => []
                ];
            }
            
            if (!isset($tableData[$provId]['kabupatens'][$kabId])) {
                $tableData[$provId]['kabupatens'][$kabId] = [
                    'nama' => $r->kabupaten->nama ?? 'Unknown',
                    'target' => 0,
                    'realisasi' => 0,
                ];
            }
            
            $tableData[$provId]['kabupatens'][$kabId]['realisasi'] = $r->realisasi;
        }

        // menghitung sum 
        foreach ($tableData as $provId => &$provData) {
            $provTargetSum = 0;
            $provRealisasiSum = 0;
            
            foreach ($provData['kabupatens'] as $kabId => &$kabData) {
                $provTargetSum += $kabData['target'];
                $provRealisasiSum += $kabData['realisasi'];
                
                $kabData['progress'] = $kabData['target'] > 0
                    ? round(($kabData['realisasi'] / $kabData['target']) * 100, 2)
                    : 0;
            }
            
            $provData['target'] = $provTargetSum;
            $provData['realisasi'] = $provRealisasiSum;
            $provData['progress'] = $provTargetSum > 0
                ? round(($provRealisasiSum / $provTargetSum) * 100, 2)
                : 0;
        }
        unset($provData);

        // Sort provinsi berdasarkan nama
        uasort($tableData, function($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });

        // Sort kabupatens berdasarkan nama
        foreach ($tableData as &$provData) {
            uasort($provData['kabupatens'], function($a, $b) {
                return strcmp($a['nama'], $b['nama']);
            });
        }
        unset($provData);
   
        return view('komoditas.show', compact(
                'komoditas',
                'tahun',
                'totalTarget',
                'totalRealisasi',
                'progress',
                'chartData',
                'tableData'
            ));
    }
}