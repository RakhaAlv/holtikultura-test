<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direktorat extends Model
{
    ///// day 2 progress
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

