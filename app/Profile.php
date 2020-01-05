<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

//    protected $fillable = ['
//    name,
//    phone,
//    about,
//    address,
//    address_x,
//    address_y,
//    working_hours,
//    is_published,
//    apartments,
//    check_out,
//    verified'];

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
