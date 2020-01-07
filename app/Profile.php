<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

//    protected $fillable = ['
//    user_id,
//    name,
//    phone,
//    about,
//    address,
//    address_x,
//    address_y,
//    working_hours,
//    boobs,
//    age,
//    weight,
//    height,
//    one_hour,
//    two_hour,
//    all_night,
//    is_published,
//    apartments,
//    check_out,
//    verified'];

   protected $guarded = ['services, appearance'];

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
}
