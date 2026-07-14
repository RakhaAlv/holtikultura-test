<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $guarded = [];
}