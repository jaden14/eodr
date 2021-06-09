<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $guarded = [];

    public function member()
    {
        return $this->hasMany('App\Member');
    }

    public function meeting()
    {
        return $this->hasMany('App\Meeting');
    }
}
