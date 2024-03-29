<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = ['mime_type'];

    public function profile() {
        $this->belongsTo('App\Profile');
    }
}
