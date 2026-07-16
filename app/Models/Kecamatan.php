<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['id', 'kabupaten_id', 'nama_kec'];

    // --- RELASI KE ATAS ---
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    // --- RELASI KE BAWAH ---
    public function desa()
    {
        return $this->hasMany(Desa::class, 'kecamatan_id');
    }

    // --- RELASI TRANSAKSI ---
    public function realisasi()
    {
        return $this->hasMany(Realisasi::class, 'kecamatan_id');
    }
}