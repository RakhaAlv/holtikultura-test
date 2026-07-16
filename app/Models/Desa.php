<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['id', 'kecamatan_id', 'nama_desa'];

    // --- RELASI KE ATAS ---
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    // --- RELASI TRANSAKSI ---
    public function realisasi()
    {
        return $this->hasMany(Realisasi::class, 'desa_id');
    }
}