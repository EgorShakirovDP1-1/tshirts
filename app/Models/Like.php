<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'drawing_id',
        'user_id',
        'rating',

    ];
    public function drawing()
{
    return $this->hasMany(Drawing::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}