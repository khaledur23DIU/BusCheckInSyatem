<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class BusesInRoute extends Model
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $guarded = [];

    public function bus()
    {
        return $this->belongsTo('App\Bus','bus_id','id');
    }

    public function busRoute()
    {
        return $this->belongsTo('App\BusRoute','bus_route_id','id');
    }
}
