<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provinsi extends Model
{
    use HasFactory;

    // Primary Key menggunakan Kode BPS (Non-Incrementing)
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = ['id', 'nama'];

    public function kabupatens(): HasMany
    {
        return $this->hasMany(Kabupaten::class);
    }

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function realisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class);
    }
}