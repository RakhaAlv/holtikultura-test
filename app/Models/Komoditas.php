<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komoditas extends Model
{
    use HasFactory;

    // Menangani penamaan tabel tak beraturan (plural default: komoditas)
    protected $table = 'komoditas';

    protected $fillable = [
        'kode_komoditas',
        'nama',
    ];

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function realisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class);
    }
}