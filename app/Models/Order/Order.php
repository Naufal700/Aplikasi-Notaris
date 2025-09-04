<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Klien;
use App\Models\Master\JenisAkta;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'orders';

    protected $fillable = [
        'nomor_order',
        'klien_id',
        'jenis_akta_id',
        'tanggal_order',
        'status',
        'biaya',
        'keterangan',
    ];

    // Relasi ke Klien
    public function klien()
    {
        return $this->belongsTo(Klien::class);
    }

    // Relasi ke Jenis Akta
    public function jenisAkta()
    {
        return $this->belongsTo(JenisAkta::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Spatie Activitylog (Versi Baru)
    |--------------------------------------------------------------------------
    */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nomor_order', 'klien_id', 'jenis_akta_id', 'tanggal_order', 'status', 'biaya', 'keterangan'])
            ->useLogName('order')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Order has been {$eventName}");
    }
}
