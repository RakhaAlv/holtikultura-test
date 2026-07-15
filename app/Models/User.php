<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'direktorat_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
//// day 2 progress
     public function direktorat()
    {
        return $this->belongsTo(Direktorat::class);
    }
}

