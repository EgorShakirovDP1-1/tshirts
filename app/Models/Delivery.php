<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'drawing_id',
        'user_id',
        'parcel_machine_id',
        'total_price',
        'status',
    ];

    public function drawing()
    {
        return $this->belongsTo(Drawing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parcelMachine()
    {
        return $this->belongsTo(ParcelMachine::class);
    }
}
