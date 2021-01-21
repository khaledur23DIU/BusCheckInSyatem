<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class BusRoute extends Model
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guarded = [];

    public function busStops()
    {
    	return $this->hasMany('App\BusStop','bus_route_id','id');
    }

    public function ticketPrices()
    {
    	return $this->hasMany('App\TicketPricing','bus_route_id','id');
    }

    public function busInRoute()
    {
        return $this->hasMany('App\BusesInRoute','bus_route_id','id');
    }
}
