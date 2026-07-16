<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['id', 'provinsi_id', 'nama_kab'];

    // --- RELASI KE ATAS ---
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    // --- RELASI KE BAWAH ---
    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_id');
    }

    // --- RELASI TRANSAKSI ---
    public function target()
    {
        return $this->hasMany(Target::class, 'kabupaten_id');
    }

    public function realisasi()
    {
        return $this->hasMany(Realisasi::class, 'kabupaten_id');
    }
}