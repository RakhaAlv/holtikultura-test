<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use App\Models\Target;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Komoditas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const STATUS_DITERIMA = 'Bantuan Sudah Diterima';

    private const ICON_MAP = [
        'Bawang Putih' => 'Bawang-Putih-Card.svg',
        'Bawang Merah' => 'Bawang-Merah-Card.svg',
        'Cabai'        => 'Cabai-Card.svg',
        'Durian'       => 'Durian-Card.svg',
        'P2B'          => 'P2B-Card.svg',
    ];

    public function index()
    {
        if (request()->filled('tahun')) {
            session(['tahun' => request('tahun')]);
        }

        $tahun       = session('tahun') ?? date('Y');
        $provinsiId  = request('provinsi');
        $kabupatenId = request('kabupaten');

        $provinsis  = Provinsi::orderBy('nama')->get();
        $kabupatens = Kabupaten::when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
            ->orderBy('nama')
            ->get();

        [$rows, $realisasiTable, $targets] = $this->buildRekap($tahun, $provinsiId, $kabupatenId);

        $chartData = $realisasiTable->map(fn ($item) => [
            'komoditas' => $item->komoditas->nama,
            'target'    => $targets[$item->komoditas_id] ?? 0,
            'realisasi' => $item->total_realisasi,
        ]);

        $summary = $this->buildSummary($tahun, $provinsiId, $kabupatenId, $targets);

        $mapData = $this->buildMapData($tahun, $provinsiId, null);

        $komoditas = Komoditas::whereHas('targets', fn ($q) => $q->where('tahun', $tahun))
            ->orderBy('nama')
            ->get();

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

    public function mapData()
    {
        $tahun       = session('tahun') ?? date('Y');
        $komoditasId = request('komoditas');
        $provinsiId  = request('provinsi');

        $mapData = $this->buildMapData($tahun, $provinsiId, $komoditasId);

        return response()->json($mapData);
    }

    public function getKabupaten(Request $request)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $request->provinsi)
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($kabupaten);
    }

    public function getKecamatan(Request $request)
    {
        $kecamatan = Kecamatan::where('kabupaten_id', $request->kabupaten)
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($kecamatan);
    }

    public function getDesa(Request $request)
    {
        $desa = Desa::where('kecamatan_id', $request->kecamatan)
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($desa);
    }

    public function filterTable(Request $request)
    {
        $tahun       = session('tahun') ?? date('Y');
        $provinsiId  = $request->provinsi;
        $kabupatenId = $request->kabupaten;

        [$rows] = $this->buildRekap($tahun, $provinsiId, $kabupatenId);

        return view('dashboard.partials.recap-table', compact('rows'));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // Progress = (Realisasi / Target) × 100. $roundUpToFull membulatkan otomatis
    // ke 100% jika realisasi >= target atau selisihnya sangat kecil (khusus summary card).
    private function calcProgress($realisasi, $target, bool $roundUpToFull = false): float
    {
        if ($target <= 0) {
            return 0;
        }

        if ($roundUpToFull && ($realisasi >= $target || abs($realisasi - $target) < 0.01)) {
            return 100;
        }

        return round($realisasi / $target * 100, 2);
    }

    // Query SUM(target) dari tabel targets, dikelompokkan sesuai $groupBy
    private function sumTarget(string $tahun, array $groupBy, $provinsiId = null, $kabupatenId = null, $komoditasId = null)
    {
        return Target::select(array_merge($groupBy, [DB::raw('SUM(target) as total_target')]))
            ->where('tahun', $tahun)
            ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
            ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
            ->when($komoditasId, fn ($q) => $q->where('komoditas_id', $komoditasId))
            ->groupBy($groupBy)
            ->get();
    }

    // Query SUM(jumlah_output) dari tabel realisasi, dikelompokkan sesuai $groupBy
    private function sumRealisasi(
        string $tahun,
        array $groupBy,
        $provinsiId = null,
        $kabupatenId = null,
        $komoditasId = null,
        array $with = [],
        bool $onlyDiterima = true
    ) {
        return Realisasi::select(array_merge($groupBy, [DB::raw('SUM(jumlah_output) as total_realisasi')]))
            ->when($with, fn ($q) => $q->with($with))
            ->where('tahun', $tahun)
            ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
            ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
            ->when($komoditasId, fn ($q) => $q->where('komoditas_id', $komoditasId))
            ->when($onlyDiterima, fn ($q) => $q->where('status', self::STATUS_DITERIMA))
            ->groupBy($groupBy)
            ->get();
    }

    /**
     * Membangun rekap tabel Komoditas -> Provinsi -> Kabupaten beserta progress-nya.
     * Dipakai bersama oleh index() dan filterTable() (sebelumnya logic ini terduplikasi ~150 baris di masing-masing).
     *
     * @return array{0: \Illuminate\Support\Collection, 1: \Illuminate\Support\Collection, 2: \Illuminate\Support\Collection}
     *         [$rows, $realisasiTable, $targets]
     */
    private function buildRekap(string $tahun, $provinsiId, $kabupatenId): array
    {
        $targets = $this->sumTarget($tahun, ['komoditas_id'], $provinsiId, $kabupatenId)
            ->pluck('total_target', 'komoditas_id');

        $realisasiTable = $this->sumRealisasi($tahun, ['komoditas_id'], $provinsiId, $kabupatenId, null, ['komoditas']);

        // Catatan: provinsiRows sengaja tidak difilter kabupatenId (mengikuti perilaku asli)
        $provinsiRows = $this->sumRealisasi($tahun, ['komoditas_id', 'provinsi_id'], $provinsiId, null, null, ['komoditas', 'provinsi']);

        $provinsiTargets = $this->sumTarget($tahun, ['komoditas_id', 'provinsi_id'], $provinsiId, $kabupatenId)
            ->keyBy(fn ($item) => $item->komoditas_id . '-' . $item->provinsi_id);

        $kabupatenRows = $this->sumRealisasi($tahun, ['komoditas_id', 'provinsi_id', 'kabupaten_id'], $provinsiId, $kabupatenId, null, ['provinsi', 'kabupaten']);

        $kabupatenTargets = $this->sumTarget($tahun, ['komoditas_id', 'provinsi_id', 'kabupaten_id'], $provinsiId, $kabupatenId)
            ->keyBy(fn ($item) => $item->komoditas_id . '-' . $item->provinsi_id . '-' . $item->kabupaten_id);

        $rows = $realisasiTable->map(function ($item) use ($targets, $provinsiRows, $provinsiTargets, $kabupatenRows, $kabupatenTargets) {
            $target = $targets[$item->komoditas_id] ?? 0;

            $provinsi = $provinsiRows
                ->where('komoditas_id', $item->komoditas_id)
                ->map(function ($p) use ($provinsiTargets, $kabupatenRows, $kabupatenTargets) {
                    $key = $p->komoditas_id . '-' . $p->provinsi_id;
                    $target = $provinsiTargets[$key]->total_target ?? 0;

                    $kabupaten = $kabupatenRows
                        ->where('komoditas_id', $p->komoditas_id)
                        ->where('provinsi_id', $p->provinsi_id)
                        ->map(function ($k) use ($kabupatenTargets) {
                            $key = $k->komoditas_id . '-' . $k->provinsi_id . '-' . $k->kabupaten_id;
                            $target = $kabupatenTargets[$key]->total_target ?? 0;

                            return [
                                'kabupaten' => $k->kabupaten->nama,
                                'target'    => $target,
                                'realisasi' => $k->total_realisasi,
                                'progress'  => $this->calcProgress($k->total_realisasi, $target),
                            ];
                        })
                        ->values();

                    return [
                        'provinsi'  => $p->provinsi->nama,
                        'target'    => $target,
                        'realisasi' => $p->total_realisasi,
                        'progress'  => $this->calcProgress($p->total_realisasi, $target),
                        'kabupaten' => $kabupaten,
                    ];
                })
                ->values();

            return [
                'komoditas_id' => $item->komoditas_id,
                'komoditas'    => $item->komoditas->nama,
                'target'       => $target,
                'realisasi'    => $item->total_realisasi,
                'progress'     => $this->calcProgress($item->total_realisasi, $target),
                'provinsi'     => $provinsi,
            ];
        });

        return [$rows, $realisasiTable, $targets];
    }

    // Data untuk summary card (dibatasi komoditas tertentu, progress dibulatkan otomatis ke 100%)
    private function buildSummary(string $tahun, $provinsiId, $kabupatenId, $targets)
    {
        return Realisasi::select('komoditas_id', DB::raw('SUM(jumlah_output) as total_realisasi'))
            ->where('tahun', $tahun)
            ->when($provinsiId, fn ($q) => $q->where('provinsi_id', $provinsiId))
            ->when($kabupatenId, fn ($q) => $q->where('kabupaten_id', $kabupatenId))
            ->whereHas('komoditas', fn ($q) => $q->whereIn('nama', array_keys(self::ICON_MAP)))
            ->where('status', self::STATUS_DITERIMA)
            ->with('komoditas')
            ->groupBy('komoditas_id')
            ->get()
            ->map(function ($item) use ($targets) {
                $nama   = $item->komoditas->nama;
                $target = $targets[$item->komoditas_id] ?? 0;
                $satuan = $nama === 'P2B' ? ' Kelompok' : ' Ha';

                return [
                    'name'      => $nama,
                    'icon'      => self::ICON_MAP[$nama] ?? 'default.svg',
                    'target'    => number_format($target, 0, ',', '.') . $satuan,
                    'realisasi' => number_format($item->total_realisasi, 0, ',', '.') . $satuan,
                    'progress'  => $this->calcProgress($item->total_realisasi, $target, roundUpToFull: true),
                ];
            });
    }

    // Data progress per provinsi untuk peta Indonesia
    private function buildMapData(string $tahun, $provinsiId, $komoditasId)
    {
        $mapTargets = $this->sumTarget($tahun, ['provinsi_id'], $provinsiId, null, $komoditasId)
            ->pluck('total_target', 'provinsi_id');

        return $this->sumRealisasi($tahun, ['provinsi_id'], $provinsiId, null, $komoditasId, ['provinsi'])
            ->map(function ($item) use ($mapTargets) {
                $target = $mapTargets[$item->provinsi_id] ?? 0;

                return [
                    'name'  => $item->provinsi->nama,
                    'value' => $this->calcProgress($item->total_realisasi, $target),
                ];
            });
    }
}