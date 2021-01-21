<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class TicketPricing extends Model
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guarded = [];

    public function busRoute()
    {
    	return $this->belongsTo('App\BusRoute','bus_route_id');
    }

    public function fromWhere()
    {
    	return $this->belongsTo('App\BusStop','from_where');
    }

    public function toWhere()
    {
    	return $this->belongsTo('App\BusStop','to_where');
    }
}
