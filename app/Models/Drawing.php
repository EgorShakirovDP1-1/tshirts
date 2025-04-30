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

    public function user()
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
        return $this->hasMany(Like::class);
    }

    // Count Likes
    public function getLikesCountAttribute()
    {
        return $this->likes()->where('rating', 1)->count();
    }

    // Count Dislikes
    public function getDislikesCountAttribute()
    {
        return $this->likes()->where('rating', -1)->count();
    }

    // Check if user has liked/disliked
    public function userReaction()
    {
        return $this->likes()->where('user_id', auth()->id())->first();
    }

    public function categories()
    {
        return $this->BelongsToMany(Category::class);
    }
}
