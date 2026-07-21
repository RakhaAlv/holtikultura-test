<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Direktorat extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
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