<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'resident_id',
        'name',
        'nik',
        'email',
        'rt_id',
        'rw_id',
        'role',
        'password',
        'phone',
        'alamat',
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    // Relasi ke RT
    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }

    // Relasi ke RW
    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    // Relasi ke pengajuan surat (applications)
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function resident()
    {
        return $this->hasOne(Resident::class, 'user_id');
    }
}
