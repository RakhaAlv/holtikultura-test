<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Constant Lookup untuk menghindari Magic Numbers di codebase
    public const SUPER_ADMIN = 1;
    public const ADMIN_DIREKTORAT = 2;
    public const USER = 3;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}