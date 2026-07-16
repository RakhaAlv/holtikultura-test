<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    // Migration roles tidak punya kolom timestamps
    public $timestamps = false;

    protected $fillable = [
        'nama_role',
        'provinsi_id',
        'kabupaten_id',
    ];

    // --- RELASI ---
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }
}