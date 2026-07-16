<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direktorat extends Model
{
    protected $table = 'direktorat';

    // Matikan timestamp jika tabel ini tidak memiliki created_at/updated_at di migration
    public $timestamps = false;

    protected $fillable = ['nama_direktorat'];

    // Relasi ke User
    public function users()
    {
        return $this->hasMany(User::class, 'direktorat_id');
    }
}