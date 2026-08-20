<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Target;
use App\Models\Realisasi;

class RekapDataController extends Controller
{
    public function index(Request $request)
    {
        $tahun = session('tahun') ?? 2025;

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

    /**
     * Lazy-load baris Kecamatan untuk satu Kabupaten (dipanggil via AJAX
     * saat baris Kabupaten di tabel pivot pertama kali di-expand).
     *
     * Catatan: tabel `targets` tidak punya kolom kecamatan_id, jadi di level
     * ini hanya nilai Realisasi yang bisa dihitung. Target & Progress
     * ditampilkan '-' di view.
     */
    public function getKecamatanRows(Request $request)
    {
        $tahun = $request->tahun ?? session('tahun') ?? 2025;
        $kabupatenId = $request->kabupaten_id;
        $komoditasIds = [1, 2, 3, 5, 7];

        $kecamatans = Kecamatan::where('kabupaten_id', $kabupatenId)
            ->orderBy('nama')
            ->get();

        $realisasis = Realisasi::select(
                'kecamatan_id',
                'komoditas_id',
                DB::raw('SUM(jumlah_output) as total_realisasi')
            )
            ->where('tahun', $tahun)
            ->where('kabupaten_id', $kabupatenId)
            ->whereIn('komoditas_id', $komoditasIds)
            ->groupBy('kecamatan_id', 'komoditas_id')
            ->get()
            ->groupBy('kecamatan_id');

        $rows = $kecamatans->map(function ($kec) use ($realisasis, $komoditasIds) {

            $komoditasData = [];

            foreach ($komoditasIds as $komId) {
                $realisasiItem = $realisasis->get($kec->id)?->firstWhere('komoditas_id', $komId);

                $komoditasData[$komId] = [
                    'realisasi' => $realisasiItem ? (float) $realisasiItem->total_realisasi : 0,
                ];
            }

            return [
                'id'        => $kec->id,
                'nama'      => $kec->nama,
                'komoditas' => $komoditasData,
            ];
        });

        return view('rekapdata.partials.kecamatan-rows', [
            'kecamatans'  => $rows,
            'kabupatenId' => $kabupatenId,
            'tahun'       => $tahun,
        ]);
    }

    /**
     * Lazy-load baris Desa untuk satu Kecamatan (dipanggil via AJAX
     * saat baris Kecamatan di tabel pivot pertama kali di-expand).
     */
    public function getDesaRows(Request $request)
    {
        $tahun = $request->tahun ?? session('tahun') ?? 2025;
        $kecamatanId = $request->kecamatan_id;
        $komoditasIds = [1, 2, 3, 5, 7];

        $desas = Desa::where('kecamatan_id', $kecamatanId)
            ->orderBy('nama')
            ->get();

        $realisasis = Realisasi::select(
                'desa_id',
                'komoditas_id',
                DB::raw('SUM(jumlah_output) as total_realisasi')
            )
            ->where('tahun', $tahun)
            ->where('kecamatan_id', $kecamatanId)
            ->whereIn('komoditas_id', $komoditasIds)
            ->groupBy('desa_id', 'komoditas_id')
            ->get()
            ->groupBy('desa_id');

        $rows = $desas->map(function ($desa) use ($realisasis, $komoditasIds) {

            $komoditasData = [];

            foreach ($komoditasIds as $komId) {
                $realisasiItem = $realisasis->get($desa->id)?->firstWhere('komoditas_id', $komId);

                $komoditasData[$komId] = [
                    'realisasi' => $realisasiItem ? (float) $realisasiItem->total_realisasi : 0,
                ];
            }

            return [
                'id'        => $desa->id,
                'nama'      => $desa->nama,
                'komoditas' => $komoditasData,
            ];
        });

        return view('rekapdata.partials.desa-rows', [
            'desas'       => $rows,
            'kecamatanId' => $kecamatanId,
        ]);
    }
}