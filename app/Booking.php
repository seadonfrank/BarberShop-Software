<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    public function services()
    {
        return $this->belongsToMany('App\Service');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
