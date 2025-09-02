<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAkta extends Model
{
    use HasFactory;

    protected $table = 'jenis_akta';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
