<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Target;
use App\Models\Realisasi;
use App\Models\Komoditas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapDataController extends Controller
{
    public function index(Request $request)
    {
        $provinsiId = $request->provinsi;
        $kabupatenId = $request->kabupaten;

        $provinsis = Provinsi::orderBy('nama')->get();

        $kabupatens = Kabupaten::query()
            ->when($provinsiId, function ($query) use ($provinsiId) {
                $query->where('provinsi_id', $provinsiId);
            })
            ->orderBy('nama')
            ->get();

        return view('rekapdata.rekap-data', [
            'provinsis'   => $provinsis,
            'kabupatens'  => $kabupatens,
            'provinsiId'  => $provinsiId,
            'kabupatenId' => $kabupatenId,
        ]);
    }

    public function getKabupaten(Request $request)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $request->provinsi)
            ->orderBy('nama')
            ->get([
                'id',
                'nama'
            ]);

        return response()->json($kabupaten);
    }
}