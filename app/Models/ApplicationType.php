<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'requirements', 'deskripsi', 'file_template'];

    protected $casts = [
        'requirements' => 'array',
    ];

    public function applicationapproval()
    {
        return $this->hasMany(ApplicationApproval::class, 'application_type_id');
    }

    // public function requirements()
    // {
    //     return $this->hasMany(Requirement::class, 'application_type_id');
    // }

}
