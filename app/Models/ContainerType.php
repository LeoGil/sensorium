<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Policies\ContainerTypePolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(ContainerTypePolicy::class)]
class ContainerType extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'capacity',
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
