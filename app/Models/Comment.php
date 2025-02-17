<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'text',
    ];
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function drawings()
    {
        return $this->belongsTo(Drawing::class);
    }
}
