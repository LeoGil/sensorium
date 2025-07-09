<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Policies\BrewingMethodPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(BrewingMethodPolicy::class)]
class BrewingMethod extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'image',
    ];

    protected $appends = ['image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
