<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salonrate extends Model
{
    protected $guarded = [];
    
    public function salons() {
        return $this->belongsToMany('App\Salon');
    }
}
