<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';
    protected $primaryKey = 'id';
    public $incrementing = false; // Memberi tahu Laravel bahwa PK bukan auto-increment
    protected $keyType = 'string'; // Memberi tahu Laravel bahwa PK berupa teks/string
    protected $guarded = [];
}