<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $guarded = ['rate', 'salonrate'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function salonrates() {
        return $this->belongsToMany('App\Salonrate');
    }
}
