<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Realisasi extends Model
{
    protected $table = 'realisasi';

    protected $fillable = [
        'tahun', 'kegiatan_id', 'komoditas_id', 'satuan_id',
        'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'desa_id',
        'kelompok_tani', 'realisasi_output', 'status',
        'created_by', 'updated_by'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'realisasi_output' => 'decimal:2',
    ];

    // --- RELASI MASTER ---
    public function kegiatan() { return $this->belongsTo(Kegiatan::class, 'kegiatan_id'); }
    public function komoditas() { return $this->belongsTo(Komoditas::class, 'komoditas_id'); }
    public function satuan() { return $this->belongsTo(Satuan::class, 'satuan_id'); }

    // --- RELASI WILAYAH ---
    public function provinsi() { return $this->belongsTo(Provinsi::class, 'provinsi_id'); }
    public function kabupaten() { return $this->belongsTo(Kabupaten::class, 'kabupaten_id'); }
    public function kecamatan() { return $this->belongsTo(Kecamatan::class, 'kecamatan_id'); }
    public function desa() { return $this->belongsTo(Desa::class, 'desa_id'); }

    // --- RELASI AUDIT ---
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function updater() { return $this->belongsTo(User::class, 'updated_by'); }
}