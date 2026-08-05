<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardUpdateState extends Model
{
    protected $fillable = [
        'last_realisasi_change_at',
    ];

    protected function casts(): array
    {
        return [
            'last_realisasi_change_at' => 'datetime',
        ];
    }
}
