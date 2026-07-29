<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Target;
use App\Models\Realisasi;

class RekapDataController extends Controller
{
    public function index(Request $request)
    {
        $tahun = session('tahun', 2025);

        $provinsiId = $request->provinsi;
        $kabupatenId = $request->kabupaten;

        if (empty($provinsiId) && !empty($kabupatenId)) {
            $provinsiId = Kabupaten::find($kabupatenId)?->provinsi_id;
        }

        // ===============================
        // Dropdown
        // ===============================

        $provinsis = Provinsi::orderBy('nama')->get();

        $kabupatens = Kabupaten::query()
            ->when($provinsiId, function ($q) use ($provinsiId) {
                $q->where('provinsi_id', $provinsiId);
            })
            ->orderBy('nama')
            ->get();

        // 5 target komoditas
        $komoditasIds = [1, 2, 3, 5, 7];

        // Fetch filter provinsi
        $filteredProvinsisQuery = Provinsi::orderBy('nama');
        if ($provinsiId) {
            $filteredProvinsisQuery->where('id', $provinsiId);
        }
        if ($kabupatenId) {
            $filteredProvinsisQuery->whereHas('kabupatens', function ($q) use ($kabupatenId) {
                $q->where('id', $kabupatenId);
            });
        }
        $filteredProvinsis = $filteredProvinsisQuery->get();

        // Fetch filter kabupaten
        $filteredKabupatensQuery = Kabupaten::orderBy('nama');
        if ($provinsiId) {
            $filteredKabupatensQuery->where('provinsi_id', $provinsiId);
        }
        if ($kabupatenId) {
            $filteredKabupatensQuery->where('id', $kabupatenId);
        }
        $filteredKabupatens = $filteredKabupatensQuery->get()->groupBy('provinsi_id');

        // Fetch target di grouping dengan provinsi dan komoditas
        $provinsiTargets = Target::select(
                'provinsi_id',
                'komoditas_id',
                DB::raw('SUM(target) as total_target')
            )
            ->where('tahun', $tahun)
            ->whereIn('komoditas_id', $komoditasIds)
            ->groupBy('provinsi_id', 'komoditas_id')
            ->get()
            ->groupBy('provinsi_id');

        // Fetch realisasi di grouping dengan provinsi dan komoditas
        $provinsiRealisasis = Realisasi::select(
                'provinsi_id',
                'komoditas_id',
                DB::raw('SUM(jumlah_output) as total_realisasi')
            )
            ->where('tahun', $tahun)
            ->whereIn('komoditas_id', $komoditasIds)
            ->groupBy('provinsi_id', 'komoditas_id')
            ->get()
            ->groupBy('provinsi_id');

        // Fetch targets di grouping dengan kabupaten dan komoditas
        $kabupatenTargets = Target::select(
                'kabupaten_id',
                'komoditas_id',
                DB::raw('SUM(target) as total_target')
            )
            ->where('tahun', $tahun)
            ->whereIn('komoditas_id', $komoditasIds)
            ->groupBy('kabupaten_id', 'komoditas_id')
            ->get()
            ->groupBy('kabupaten_id');

        // Fetch realisasi di grouping dengan kabupaten dan komoditas
        $kabupatenRealisasis = Realisasi::select(
                'kabupaten_id',
                'komoditas_id',
                DB::raw('SUM(jumlah_output) as total_realisasi')
            )
            ->where('tahun', $tahun)
            ->whereIn('komoditas_id', $komoditasIds)
            ->groupBy('kabupaten_id', 'komoditas_id')
            ->get()
            ->groupBy('kabupaten_id');

        // struktur datany
        $wilayahRows = $filteredProvinsis->map(function ($prov) use (
            $filteredKabupatens,
            $provinsiTargets,
            $provinsiRealisasis,
            $kabupatenTargets,
            $kabupatenRealisasis,
            $komoditasIds
        ) {
            $provId = $prov->id;
            $provKomoditas = [];

            foreach ($komoditasIds as $komId) {
                $target = 0;
                if (isset($provinsiTargets[$provId])) {
                    $targetItem = $provinsiTargets[$provId]->firstWhere('komoditas_id', $komId);
                    if ($targetItem) {
                        $target = (float) $targetItem->total_target;
                    }
                }

                $realisasi = 0;
                if (isset($provinsiRealisasis[$provId])) {
                    $realisasiItem = $provinsiRealisasis[$provId]->firstWhere('komoditas_id', $komId);
                    if ($realisasiItem) {
                        $realisasi = (float) $realisasiItem->total_realisasi;
                    }
                }

                $progress = $target > 0 ? round(($realisasi / $target) * 100, 2) : 0;

                $provKomoditas[$komId] = [
                    'target' => $target,
                    'realisasi' => $realisasi,
                    'progress' => $progress,
                ];
            }

            $kabList = $filteredKabupatens->get($provId, collect())->map(function ($kab) use (
                $kabupatenTargets,
                $kabupatenRealisasis,
                $komoditasIds
            ) {
                $kabId = $kab->id;
                $kabKomoditas = [];

                foreach ($komoditasIds as $komId) {
                    $target = 0;
                    if (isset($kabupatenTargets[$kabId])) {
                        $targetItem = $kabupatenTargets[$kabId]->firstWhere('komoditas_id', $komId);
                        if ($targetItem) {
                            $target = (float) $targetItem->total_target;
                        }
                    }

                    $realisasi = 0;
                    if (isset($kabupatenRealisasis[$kabId])) {
                        $realisasiItem = $kabupatenRealisasis[$kabId]->firstWhere('komoditas_id', $komId);
                        if ($realisasiItem) {
                            $realisasi = (float) $realisasiItem->total_realisasi;
                        }
                    }

                    $progress = $target > 0 ? round(($realisasi / $target) * 100, 2) : 0;

                    $kabKomoditas[$komId] = [
                        'target' => $target,
                        'realisasi' => $realisasi,
                        'progress' => $progress,
                    ];
                }

                return [
                    'id' => $kabId,
                    'nama' => $kab->nama,
                    'komoditas' => $kabKomoditas,
                ];
            });

            return [
                'id' => $provId,
                'nama' => $prov->nama,
                'komoditas' => $provKomoditas,
                'kabupatens' => $kabList,
            ];
        });

        return view('rekapdata.rekap-data', compact(
            'provinsis',
            'kabupatens',
            'provinsiId',
            'kabupatenId',
            'wilayahRows'
        ));
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