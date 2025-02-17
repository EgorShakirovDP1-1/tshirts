<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    protected $fillable = [
        'path_to_drawing',
        'name',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function thing()
    {
        return $this->hasMany(Thing::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Likes::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
