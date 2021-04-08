<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $guarded = [];

    public function committe()
    {
        return $this->belongsTo('App\Committee');
    }
}