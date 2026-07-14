<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $guarded = [];
}