<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    protected $fillable = [
        'user_id',
        'path_to_img',
        'material_id',
        'drawing_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function drawing()
    {
        return $this->belongsTo(Drawing::class);
    }
}
