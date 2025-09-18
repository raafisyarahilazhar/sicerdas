<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RW extends Model
{
    use HasFactory;

    protected $table = 'rws';
    protected $fillable = ['nomor_rw', 'nama_ketua'];

    public function rts()
    {
        return $this->hasMany(RT::class, 'rw_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'rw_id');
    }
}
