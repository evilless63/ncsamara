<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $guarded = ['services', 'appearance', 'hair', 'item_images', 'profile_balance'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function services() {
        return $this->belongsToMany('App\Service');
    }

    public function appearances() {
        return $this->belongsToMany('App\Appearance');
    }

    public function hairs() {
        return $this->belongsToMany('App\Hair');
    }

    public function images() {
        return $this->HasMany('App\Image');
    }

    public function rates() {
        return $this->belongsToMany('App\Rate');
    }
}
