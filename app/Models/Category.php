<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_name',
        'category_description',
        'drawing_id',
    ];
    public function drawings()
    {
        return $this->BelongsToMany(Drawing::class);
    }
}
