<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function bookings()
    {
        return $this->belongsToMany('App\booking');
    }
}
