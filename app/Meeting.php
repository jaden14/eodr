<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $guarded = [];

    public function committee()
    {
        return $this->belongsTo('App\Committee');
    }
}
