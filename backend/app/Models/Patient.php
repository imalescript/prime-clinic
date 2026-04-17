<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cedula', 
        'first_name', 
        'last_name', 
        'birth_date', 
        'gender', 
        'phone', 
        'email', 
        'address', 
        'blood_type', 
        'allergies', 
        'chronic_conditions',
        'user_id'
    ];
    protected $casts = [
        'birth_date' => 'date',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}",
        );
    }
    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => \Carbon\Carbon::parse($this->birth_date)->age,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function surgeries(): HasMany
    {
        return $this->hasMany(Surgery::class);
    }
}