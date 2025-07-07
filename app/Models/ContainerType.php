<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ContainerType extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'capacity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
