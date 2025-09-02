<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'klien';

    protected $fillable = [
        'nama',
        'alamat',
        'email',
        'telepon',
        'npwp',
        'jenis_klien',
        'keterangan',
    ];
}
