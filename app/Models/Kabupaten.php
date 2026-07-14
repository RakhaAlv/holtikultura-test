<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $guarded = [];
}