<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function target()
    {
        return $this->belongsTo('App\Target');
    }

    public function output()
    {
        return $this->hasMany('App\Output');
    }
}
