<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'title',
        'content',
        'author',
        'published_at',
        'image_path',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
