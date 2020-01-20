<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $guarded = ['rate'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function rates() {
        return $this->belongsToMany('App\Rate');
    }
}
