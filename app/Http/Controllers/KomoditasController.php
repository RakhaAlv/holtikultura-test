<?php

namespace App\Http\Controllers;

use App\Models\Komoditas;
use App\Models\Target;
use App\Models\Realisasi;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomoditasController extends Controller
{

    public function show(Komoditas $komoditas, Request $request)
    {
        $tahun = session('tahun') ?? 2025;

        $provinsiId = $request->provinsi;
        $kabupatenId = $request->kabupaten;
        $kecamatanId = $request->kecamatan;

        $isAjax = $request->ajax();

        // ===============================
        // Dropdown filter
        // (tidak dibutuhkan untuk response AJAX yang hanya mengembalikan tabel)
        // ===============================

        if (!$isAjax) {
            $provinsis = Provinsi::orderBy('nama')->get();

            $kabupatens = Kabupaten::query()
                ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
                ->orderBy('nama')
                ->get();

            $kecamatans = Kecamatan::query()
                ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
                ->orderBy('nama')
                ->get();
        }

        // ===============================
        // Summary Cards
        // (tidak dibutuhkan untuk response AJAX)
        // ===============================

        if (!$isAjax) {
            $totalTarget = Target::where('komoditas_id', $komoditas->id)
                ->where('tahun', $tahun)
                ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
                ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
                ->sum('target');

            // Catatan: tabel targets tidak punya kolom kecamatan_id, jadi filter
            // kecamatan hanya berlaku untuk Realisasi, bukan Target.
            $totalRealisasi = Realisasi::where('komoditas_id', $komoditas->id)
                ->where('tahun', $tahun)
                ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
                ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
                ->when($kecamatanId, fn ($q) => $q->where('kecamatan_id', $kecamatanId))
                ->where('status', 'Bantuan Sudah Diterima')
                ->sum('jumlah_output');

            $progress = $totalTarget > 0
                ? round(($totalRealisasi / $totalTarget) * 100, 2)
                : 0;

            // ===============================
            // Chart per provinsi
            // (tidak dibutuhkan untuk response AJAX)
            // ===============================

            $targetProvinsi = Target::select(
                    'provinsi_id',
                    DB::raw('SUM(target) as target')
                )
                ->where('komoditas_id', $komoditas->id)
                ->where('tahun', $tahun)
                ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
                ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
                ->groupBy('provinsi_id')
                ->pluck('target', 'provinsi_id');

            $chartData = Realisasi::select(
                    'provinsi_id',
                    DB::raw('SUM(jumlah_output) as realisasi')
                )
                ->with('provinsi')
                ->where('komoditas_id', $komoditas->id)
                ->where('tahun', $tahun)
                ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
                ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
                ->when($kecamatanId, fn ($q) => $q->where('kecamatan_id', $kecamatanId))
                ->where('status', 'Bantuan Sudah Diterima')
                ->groupBy('provinsi_id')
                ->get()
                ->map(function ($item) use ($targetProvinsi) {

                    return [
                        'provinsi'  => $item->provinsi->nama,
                        'target'    => $targetProvinsi[$item->provinsi_id] ?? 0,
                        'realisasi' => $item->realisasi,
                    ];

                });
        }

        // ===============================
        // Tabel Provinsi -> Kabupaten
        // ===============================

        $targetsGrouped = Target::with(['provinsi', 'kabupaten'])
            ->where('komoditas_id', $komoditas->id)
            ->where('tahun', $tahun)
            ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
            ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
            ->select('provinsi_id', 'kabupaten_id', DB::raw('SUM(target) as target'))
            ->groupBy('provinsi_id', 'kabupaten_id')
            ->get();

        $realisasisGrouped = Realisasi::with(['provinsi', 'kabupaten'])
            ->where('komoditas_id', $komoditas->id)
            ->where('tahun', $tahun)
            ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
            ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
            ->when($kecamatanId, fn ($q) => $q->where('kecamatan_id', $kecamatanId))
            ->where('status', 'Bantuan Sudah Diterima')
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

        uasort($tableData, function ($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });

        foreach ($tableData as &$provData) {
            uasort($provData['kabupatens'], function ($a, $b) {
                return strcmp($a['nama'], $b['nama']);
            });
        }
        unset($provData);

        // ===============================
        // Response AJAX: hanya kembalikan partial tabel
        // ===============================

        if ($isAjax) {
            return view('komoditas.partials.table', compact('tableData'));
        }

        return view('komoditas.show', compact(
            'komoditas',
            'tahun',
            'totalTarget',
            'totalRealisasi',
            'progress',
            'chartData',
            'tableData',
            'provinsis',
            'kabupatens',
            'kecamatans',
            'provinsiId',
            'kabupatenId',
            'kecamatanId'
        ));
    }
}