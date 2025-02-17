<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material',
    ];
    public function thing()
    {
        return $this->hasMany(Thing::class);
    }
}