<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
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
            'role_id' => 'integer',
            'direktorat_id' => 'integer',
        ];
    }

    // Default Eager Loading untuk mencegah N+1 saat memanggil auth()->user()
    protected $with = ['role', 'direktorat'];

    // Relasi
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function direktorat(): BelongsTo
    {
        return $this->belongsTo(Direktorat::class);
    }

    public function realisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class, 'created_by');
    }

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class, 'created_by');
    }

    // Helper Methods RBAC (Pencegahan IDOR/Salah Ketik Logika Hak Akses)
    public function isSuperAdmin(): bool
    {
        return $this->role_id === Role::SUPER_ADMIN;
    }

    public function isAdminDirektorat(): bool
    {
        return $this->role_id === Role::ADMIN_DIREKTORAT;
    }

    public function isUser(): bool
    {
        return $this->role_id === Role::USER;
    }
}