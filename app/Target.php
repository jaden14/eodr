<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $guarded = [];


    public function output()
    {
        return $this->belongsTo('App\Output');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function accomplishment()
    {
        return $this->hasMany('App\Accomplishment');
    }

}
