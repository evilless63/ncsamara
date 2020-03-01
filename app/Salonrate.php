<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salonrate extends Model
{
    public function salons() {
        return $this->belongsToMany('App\Salon');
    }
}
