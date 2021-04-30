<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    protected $guarded = [];

    public function target()
    {
        return $this->belongsTo('App\Target');
    }

    public function accomplishment()
    {
        return $this->belongsTo('App\Accomplishment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
