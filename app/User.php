<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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

    public function accomplishment()
    {
        return $this->hasMany('App\Accomplishment');
    }

    public function accomplishments()
    {
        return $this->belongsTo('App\Accomplishment');
    }

    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    public function office()
    {
        return $this->belongsTo('App\Office');
    }

    public function journal()
    {
        return $this->hasMany('App\Journal');
    }

    public function member()
    {
        return $this->hasMany('App\Member');
    }

    public function output()
    {
        return $this->hasMany('App\Output');
    }
}
