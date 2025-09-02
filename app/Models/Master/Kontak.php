<?php

namespace App\Models\Master;

use App\Models\Master\Klien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontak';

    protected $fillable = [
        'nama',
        'perusahaan',
        'jabatan',
        'telepon',
        'email',
        'klien_id',
    ];

    // Relasi ke Klien
    public function klien()
    {
        return $this->belongsTo(Klien::class, 'klien_id');
    }
}
