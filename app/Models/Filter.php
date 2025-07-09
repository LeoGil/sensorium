<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Policies\FilterPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(FilterPolicy::class)]
class Filter extends Model
{
    protected $fillable = [
        'brand',
        'name',
        'user_id',
        'quantity',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brewingMethods()
    {
        return $this->belongsToMany(BrewingMethod::class, 'brewing_method_filters');
    }
}
