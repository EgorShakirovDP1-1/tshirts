<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'drawing_id',
        'user_id',
        'text',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function drawings()
    {
        return $this->belongsTo(Drawing::class);
    }
}
