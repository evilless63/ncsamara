<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appearance extends Model
{
    protected $guarded = [];

    public function profiles() {
        return $this->belongsToMany('App\Profile');
    }
}
