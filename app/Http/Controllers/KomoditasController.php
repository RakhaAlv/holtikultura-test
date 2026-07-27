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
        $tahun = request('tahun', date('Y'));

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
   
        return view('komoditas.show', compact(
                'komoditas',
                'tahun',
                'totalTarget',
                'totalRealisasi',
                'progress',
                'chartData'
            ));
    }
}