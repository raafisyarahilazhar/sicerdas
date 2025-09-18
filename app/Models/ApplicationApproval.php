<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationApproval extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'aplication_type_id', 'status', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicationype()
    {
        return $this->belongsTo(ApplicationType::class, 'aplication_type_id');
    }

    public function applicationapproval()
    {
        return $this->hasMany(Application::class, 'apllication_id');
    }
}
