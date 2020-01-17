<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];

    public function profiles() {
        return $this->belongsToMany('App\Profile');
    }
}
