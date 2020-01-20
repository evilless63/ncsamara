<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{

    protected $guarded = [];

    public function profiles() {
        return $this->belongsToMany('App\Profile');
    }

    public function salons() {
        return $this->belongsToMany('App\Salon');
    }
}
