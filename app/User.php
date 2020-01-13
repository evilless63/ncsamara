<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kordy\Ticketit\Models\Ticket;

//class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profiles() {
        return $this->hasMany('App\Profile');
    }

    public function salon() {
        return $this->hasOne('App\Salon');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function statistics() {
        return $this->hasMany('App\Statistic');
    }

}
