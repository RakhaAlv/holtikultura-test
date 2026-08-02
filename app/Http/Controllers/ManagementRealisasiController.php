<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use App\Models\Direktorat;
use App\Models\Kegiatan;
use App\Models\Komoditas;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ManagementRealisasiController extends Controller
{
    public function table(Request $request)
    {
        $query = Realisasi::with([
            'kegiatan',
            'komoditas',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'desa',
            'satuan',
            'direktorat',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_kelompok', 'like', "%{$search}%")
                  ->orWhereHas('kegiatan', fn ($q2) => $q2->where('nama_kegiatan', 'like', "%{$search}%"))
                  ->orWhereHas('komoditas', fn ($q2) => $q2->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('provinsi', fn ($q2) => $q2->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('kabupaten', fn ($q2) => $q2->where('nama', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('kegiatan_id')) {
            $query->where('kegiatan_id', $request->kegiatan_id);
        }

        if ($request->filled('komoditas_id')) {
            $query->where('komoditas_id', $request->komoditas_id);
        }

        if ($request->filled('provinsi_id')) {
            $query->where('provinsi_id', $request->provinsi_id);
        }

        if ($request->filled('kabupaten_id')) {
            $query->where('kabupaten_id', $request->kabupaten_id);
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('direktorat_id')) {
            $query->where('direktorat_id', $request->direktorat_id);
        }

        $realisasi = $query->latest()->paginate(10)->withQueryString();

        return view('datamanagement.realisasi.table', [
            'realisasi'    => $realisasi,
            'direktorats'  => Direktorat::orderBy('nama')->get(),
            'kegiatans'    => Kegiatan::orderBy('nama_kegiatan')->get(),
            'komoditas'    => Komoditas::orderBy('nama')->get(),
            'provinsis'    => Provinsi::orderBy('nama')->get(),
            'kabupatens'   => Kabupaten::orderBy('nama')->get(),
            'kecamatans'   => Kecamatan::orderBy('nama')->get(),
            'satuans'      => Satuan::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $data['direktorat_id'] = $this->resolveDirektoratId($request);
        $data['created_by']    = auth()->id();

        Realisasi::create($data);

        return redirect()
            ->back()
            ->with('success', 'Realisasi berhasil ditambahkan.');
    }

    public function show(Realisasi $realisasi)
    {
        return response()->json($realisasi);
    }

    public function update(Request $request, Realisasi $realisasi)
    {
        $data = $this->validated($request);

        $data['direktorat_id'] = $this->resolveDirektoratId($request);

        $realisasi->update($data);

        return redirect()
            ->back()
            ->with('success', 'Realisasi berhasil diperbarui.');
    }

    public function destroy(Realisasi $realisasi)
    {
        $realisasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Realisasi berhasil dihapus.',
        ]);
    }

    private function validated(Request $request): array
    {
        $request->validate([
            'tahun'          => 'required|integer',
            'kegiatan_id'    => 'required',
            'komoditas_id'   => 'required',
            'nama_kelompok'  => 'required|string|max:255',
            'provinsi_id'    => 'required',
            'kabupaten_id'   => 'required',
            'kecamatan_id'   => 'required',
            'desa_id'        => 'required',
            'satuan_id'      => 'required',
            'jumlah_output'  => 'required|numeric',
            'anggaran'       => 'nullable|numeric',
            'status'         => 'required|in:Bantuan Sudah Diterima,Bantuan Belum Diterima',
        ]);

        return $request->only([
            'tahun',
            'kegiatan_id',
            'komoditas_id',
            'nama_kelompok',
            'provinsi_id',
            'kabupaten_id',
            'kecamatan_id',
            'desa_id',
            'satuan_id',
            'jumlah_output',
            'anggaran',
            'status',
        ]);
    }

    private function resolveDirektoratId(Request $request): int
    {
        if (auth()->user()->isSuperAdmin()) {
            $request->validate([
                'direktorat_id' => 'required|exists:direktorats,id',
            ]);

            return $request->direktorat_id;
        }

        return auth()->user()->direktorat_id;
    }
}