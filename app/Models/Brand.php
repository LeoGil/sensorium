<?php

namespace App\Models;

use App\Policies\BrandPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(BrandPolicy::class)]
class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'url',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
