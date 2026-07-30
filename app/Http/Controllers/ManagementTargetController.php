<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Direktorat;
use App\Models\Kegiatan;
use App\Models\Komoditas;
use App\Models\Provinsi;
use App\Models\Kabupaten;  
use App\Models\Satuan;
use App\Models\Target;




class ManagementTargetController extends Controller
{
    public function table(Request $request)
{
    $query = Target::with([
        'kegiatan',
        'komoditas',
        'provinsi',
        'kabupaten',
        'satuan',
        'direktorat'
    ]);

    // Pencarian bebas (kegiatan, komoditas, provinsi, kabupaten)
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->whereHas('kegiatan', fn ($q2) => $q2->where('nama_kegiatan', 'like', "%{$search}%"))
              ->orWhereHas('komoditas', fn ($q2) => $q2->where('nama', 'like', "%{$search}%"))
              ->orWhereHas('provinsi', fn ($q2) => $q2->where('nama', 'like', "%{$search}%"))
              ->orWhereHas('kabupaten', fn ($q2) => $q2->where('nama', 'like', "%{$search}%"));
        });
    }

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
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

    if ($request->filled('direktorat_id')) {
        $query->where('direktorat_id', $request->direktorat_id);
    }

    $targets = $query->latest()->paginate(10)->withQueryString();

    return view('datamanagement.target.table', [
        'targets'      => $targets,
        'direktorats'  => Direktorat::orderBy('nama')->get(),
        'kegiatans'    => Kegiatan::orderBy('nama_kegiatan')->get(),
        'komoditas'    => Komoditas::orderBy('nama')->get(),
        'provinsis'    => Provinsi::orderBy('nama')->get(),
        'kabupatens'   => Kabupaten::orderBy('nama')->get(),
        'satuans'      => Satuan::orderBy('nama')->get(),
    ]);
}



    public function store(Request $request)
{
    $request->validate([
        'tahun'         => 'required',
        'kegiatan_id'   => 'required',
        'komoditas_id'  => 'required',
        'provinsi_id'   => 'required',
        'kabupaten_id'  => 'required',
        'satuan_id'     => 'required',
        'target'        => 'required|numeric',
    ]);

    // Khusus Super Admin wajib memilih direktorat
    if (auth()->user()->isSuperAdmin()) {
        $request->validate([
            'direktorat_id' => 'required|exists:direktorats,id',
        ]);

        $direktoratId = $request->direktorat_id;
    } else {
        // Admin Direktorat otomatis memakai direktorat miliknya
        $direktoratId = auth()->user()->direktorat_id;
    }

    Target::create([

        'direktorat_id' => $direktoratId,

        'kegiatan_id'   => $request->kegiatan_id,

        'komoditas_id'  => $request->komoditas_id,

        'provinsi_id'   => $request->provinsi_id,

        'kabupaten_id'  => $request->kabupaten_id,

        'tahun'         => $request->tahun,

        'target'        => $request->target,

        'satuan_id'     => $request->satuan_id,

        'created_by'    => auth()->id(),

    ]);

    return redirect()
        ->back()
        ->with('success', 'Target berhasil ditambahkan.');
}

public function show(Target $target)
{
    return response()->json($target);
}

public function update(Request $request, Target $target)
{
    $request->validate([
        'tahun'         => 'required',
        'kegiatan_id'   => 'required',
        'komoditas_id'  => 'required',
        'provinsi_id'   => 'required',
        'kabupaten_id'  => 'required',
        'satuan_id'     => 'required',
        'target'        => 'required|numeric',
    ]);

    // Khusus Super Admin wajib memilih direktorat
    if (auth()->user()->isSuperAdmin()) {
        $request->validate([
            'direktorat_id' => 'required|exists:direktorats,id',
        ]);

        $direktoratId = $request->direktorat_id;
    } else {
        // Admin Direktorat otomatis memakai direktorat miliknya
        $direktoratId = auth()->user()->direktorat_id;
    }

    $target->update([

        'direktorat_id' => $direktoratId,

        'kegiatan_id'   => $request->kegiatan_id,

        'komoditas_id'  => $request->komoditas_id,

        'provinsi_id'   => $request->provinsi_id,

        'kabupaten_id'  => $request->kabupaten_id,

        'tahun'         => $request->tahun,

        'target'        => $request->target,

        'satuan_id'     => $request->satuan_id,

    ]);

    return redirect()
        ->back()
        ->with('success', 'Target berhasil diperbarui.');
}

public function destroy(Target $target)
{
    $target->delete();

    return response()->json([
        'success' => true,
        'message' => 'Target berhasil dihapus.',
    ]);
}

}