<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';

    // ID diisi manual dengan Kode BPS, bukan auto-increment
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['id', 'nama_prov'];

    // --- RELASI KE BAWAH ---
    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_id');
    }

    // --- RELASI TRANSAKSI ---
    public function target()
    {
        return $this->hasMany(Target::class, 'provinsi_id');
    }

    public function realisasi()
    {
        return $this->hasMany(Realisasi::class, 'provinsi_id');
    }
}