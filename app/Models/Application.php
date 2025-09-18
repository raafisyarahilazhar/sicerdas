<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'application_type_id',
        'form_data',
        'status',
        'ref_number',
        'qr_token',
        'pdf_path',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            if (empty($application->ref_number)) {
                $latestId = self::max('id') + 1;
                $application->ref_number = 'DESA-' . now()->format('Ymd') . '-' . str_pad($latestId, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Relasi ke Resident (pemohon)
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    // Relasi ke Jenis Surat
    public function applicationType()
    {
        return $this->belongsTo(ApplicationType::class);
    }

    // Relasi ke Approval
    public function approvals()
    {
        return $this->hasMany(ApplicationApproval::class);
    }
}
