<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

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

    // Cegah N+1 Query Problem saat cek otorisasi (role sering diakses di middleware/Blade)
    protected $with = ['role'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI ---
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class, 'direktorat_id');
    }

    // --- LOGIKA RBAC (sesuai RoleSeeder aktual) ---
    public function isSuperAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isAdminDirektorat(): bool
    {
        return $this->role_id === 2;
    }

    public function isUser(): bool
    {
        return $this->role_id === 3;
    }
}