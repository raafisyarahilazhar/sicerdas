<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RT extends Model
{
    use HasFactory;

    protected $table = 'rts';
    protected $fillable = ['nomor_rt', 'nama_ketua', 'rw_id'];

    public function rw()
    {
        return $this->belongsTo(RW::class, 'rw_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'rt_id');
    }
}
