<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $guarded = [];

    public function profiles() {
        return $this->belongsToMany('App\Profile');
    }
}
