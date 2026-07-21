<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Satuan extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function realisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class);
    }
}