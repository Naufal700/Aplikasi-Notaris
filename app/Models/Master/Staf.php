<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // supaya bisa login
use Illuminate\Notifications\Notifiable;

class Staf extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'staf';

    protected $fillable = [
        'nama',
        'jabatan',
        'email',
        'telepon',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    // Mutator untuk hash password otomatis
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
