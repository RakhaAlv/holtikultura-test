<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabupaten extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = ['id', 'provinsi_id', 'nama'];

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kecamatans(): HasMany
    {
        return $this->hasMany(Kecamatan::class);
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