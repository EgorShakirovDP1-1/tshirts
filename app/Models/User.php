<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
class User extends Authenticatable implements FilamentUser
{
    use Notifiable;
    // ...
 
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->email, [
            'egorsha2005@gmail.com', // Add allowed emails here
            
        ]);
    }
    //relations

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function getImageURL()
    {
        if ($this->avatar) {
            return url('storage/'.$this->avatar);
        }

        return url('/images/default-profile.png');
    }


    public function drawing()
    {
        return $this->hasMany(Drawing::class);
    }
    
    public function things()
    {
        return $this->hasMany(Thing::class);
    }
    // End of relations


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
        'avatar',
        'address',
        'phone',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
