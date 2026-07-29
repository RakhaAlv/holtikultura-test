<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;

class ManagementRealisasiController extends Controller
{
    public function table()
    {
        $realisasi = Realisasi::with([
            'kegiatan',
            'komoditas',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'desa',
            'satuan'
        ])->paginate(10);

        return view(
            'datamanagement.realisasi.table',
            compact('realisasi')
        );
    }
}