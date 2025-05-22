<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelMachine extends Model
{
    protected $fillable = [
        'name',
        
        'delivery_price',
        'latitude',
        'longitude',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }


  
}
