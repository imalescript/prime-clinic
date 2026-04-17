<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surgery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'surgery_type_id',
        'user_id',
        'scheduled_date',
        'execution_date',
        'status',
        'observations'
    ];

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'datetime',
            'execution_date' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(SurgeryType::class, 'surgery_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}