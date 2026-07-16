<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    public $timestamps = false;

    protected $fillable = [
        'direktorat_id', // Wajib didaftarkan di fillable
        'kd_program', 
        'nama_program', 
        'kd_rincianoutput', 
        'nama_rincianoutput', 
        'jenis_output'
    ];

    // Relasi balik ke tabel induk (Direktorat)
    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class, 'direktorat_id');
    }

    public function target() { return $this->hasMany(Target::class, 'kegiatan_id'); }
    public function realisasi() { return $this->hasMany(Realisasi::class, 'kegiatan_id'); }
}