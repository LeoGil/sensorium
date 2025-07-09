<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrewingMethodFilter extends Model
{
    protected $fillable = [
        'brewing_method_id',
        'filter_id',
    ];

    public function brewingMethod()
    {
        return $this->belongsTo(BrewingMethod::class);
    }

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}
