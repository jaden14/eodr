<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];


    public function office()
    {
        return $this->belongsTo('App\Office');
    }
}
