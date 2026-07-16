<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';
    public $timestamps = false;

    protected $fillable = ['nama_satuan'];

    public function target()
    {
        return $this->hasMany(Target::class, 'satuan_id');
    }

    public function realisasi()
    {
        return $this->hasMany(Realisasi::class, 'satuan_id');
    }
}