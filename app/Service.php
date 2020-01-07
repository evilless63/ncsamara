<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $guarded = [];

    public function profiles() {
        return $this->belongsToMany('App\Profile');
    }

    public function parent()
    {
        return $this->belongsTo('App\Service', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Service', 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}
