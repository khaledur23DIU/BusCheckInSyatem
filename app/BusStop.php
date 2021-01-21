<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class BusStop extends Model
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guarded = [];

    public function busRoute()
    {
    	return $this->belongsTo('App\BusRoute','bus_route_id');
    }

    public function ticketPriceFromPlaces()
    {
    	return $this->hasMany('App\TicketPricing','from_where','id');
    }

    public function ticketPriceToPlaces()
    {
    	return $this->hasMany('App\TicketPricing','to_where','id');
    }

    public function checkIn()
    {
        return $this->hasMany('App\AssignChecker','bus_stop_id','id');
    }

    public function checkIns()
    {
        return $this->hasMany('App\CheckIn','bus_stop_id');
    }
}
