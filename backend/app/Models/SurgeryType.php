<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurgeryType extends Model

{
    use HasFactory;

    protected $fillable = ['name', 'description', 'estimated_duration'];

    public function surgeries(): HasMany
    {
        return $this->hasMany(Surgery::class);
    }
}