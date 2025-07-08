<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Policies\GrinderPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(GrinderPolicy::class)]
class Grinder extends Model
{
    protected $fillable = [
        'brand',
        'name',
        'user_id',
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