<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDokumen extends Model
{
    use HasFactory;

    protected $table = 'template_dokumen';

    protected $fillable = [
        'nama_template',
        'file_path',
        'jenis_akta_id',
    ];

    // Relasi ke jenis_akta
    public function jenisAkta()
    {
        return $this->belongsTo(JenisAkta::class, 'jenis_akta_id');
    }
}
