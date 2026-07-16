<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'target';

    protected $fillable = [
        'tahun', 'kegiatan_id', 'komoditas_id', 'satuan_id',
        'provinsi_id', 'kabupaten_id', 
        'target_output', 'created_by', 'updated_by'
    ];

    // Casting wajib agar PHP membaca kolom year sebagai integer dan output sebagai desimal presisi
    protected $casts = [
        'tahun' => 'integer',
        'target_output' => 'decimal:2',
    ];

    // --- RELASI MASTER ---
    public function kegiatan() { return $this->belongsTo(Kegiatan::class, 'kegiatan_id'); }
    public function komoditas() { return $this->belongsTo(Komoditas::class, 'komoditas_id'); }
    public function satuan() { return $this->belongsTo(Satuan::class, 'satuan_id'); }

    // --- RELASI WILAYAH ---
    public function provinsi() { return $this->belongsTo(Provinsi::class, 'provinsi_id'); }
    public function kabupaten() { return $this->belongsTo(Kabupaten::class, 'kabupaten_id'); }

    // --- RELASI AUDIT ---
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function updater() { return $this->belongsTo(User::class, 'updated_by'); }
}