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
    public function table()
{
    $targets = Target::with([
        'kegiatan',
        'komoditas',
        'provinsi',
        'kabupaten',
        'satuan',
        'direktorat'
    ])->latest()->paginate(10);

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
  
}
