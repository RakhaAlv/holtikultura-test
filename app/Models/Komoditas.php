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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return \Illuminate\Support\Str::slug($this->nama);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where(function ($query) use ($value) {
            $query->whereRaw("LOWER(REPLACE(nama, ' ', '-')) = ?", [$value])
                  ->orWhereRaw("LOWER(REPLACE(kode_komoditas, ' ', '-')) = ?", [$value]);
        })->firstOrFail();
    }
}