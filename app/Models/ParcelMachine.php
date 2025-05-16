<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelMachine extends Model
{
   public function drawings()
   {
       return $this->hasMany(Drawing::class);
   }
}
