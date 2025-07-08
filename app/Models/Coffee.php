<?php

namespace App\Models;

use App\Policies\CoffeePolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(CoffeePolicy::class)]
class Coffee extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'sensory',
        'farm',
        'variety',
        'region',
        'altitude',
        'producer',
        'processing_method',
        'roaster',
        'brand_id',
        'image',
        'roast_level_id',
        'score',
    ];

    protected $appends = ['image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function roastLevel()
    {
        return $this->belongsTo(RoastLevel::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
