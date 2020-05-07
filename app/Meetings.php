<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meetings extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\User', 'host_id');
    }
}
