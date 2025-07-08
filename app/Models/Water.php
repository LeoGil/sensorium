<?php

namespace App\Models;

use App\Policies\WaterPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(WaterPolicy::class)]
class Water extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'chlorine',
        'calcium',
        'magnesium',
        'total_dissolved_solids',
        'hardness',
        'bicarbonate',
        'alkalinity',
        'ph',
        'sodium',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optionally, accessors for calculated fields
    public function getHardnessAttribute($value)
    {
        if ($value !== null) return $value;
        return ($this->calcium * 2.5) + ($this->magnesium * 4.2);
    }

    public function getAlkalinityAttribute($value)
    {
        if ($value !== null) return $value;
        return $this->bicarbonate * 0.8;
    }
} 