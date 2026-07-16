<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    protected $table = 'komoditas';
    public $timestamps = false; // Atau true jika kamu mengaktifkan timestamps di migration

    protected $fillable = ['kd_kom', 'nama'];

    public function target()
    {
        return $this->hasMany(Target::class, 'komoditas_id');
    }

    public function realisasi()
    {
        return $this->hasMany(Realisasi::class, 'komoditas_id');
    }
}