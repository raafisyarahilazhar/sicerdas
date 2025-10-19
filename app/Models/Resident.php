<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','nik','name','birth_date','gender','phone','rw_id','rt_id','address','kk_number',
        'education_level','occupation','religion','marital_status','income_bracket',
        'disability_status','blood_type','citizenship','lat','lng',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'disability_status'=>'boolean',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
    ];

    // Relasi ke RW
    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    // Relasi ke RT
    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }

    // Relasi ke Application
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAgeAttribute()
    {
        return $this->birth_date? $this->birth_date->age : null;
    }
}
