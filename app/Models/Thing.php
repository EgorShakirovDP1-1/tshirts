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
    public function materials()
    {
        return $this->belongsTo(Material::class);
    }
    public function drawing()
    {
        return $this->belongsTo(Drawing::class);

    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
