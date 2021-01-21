<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class CheckIn extends Model
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guarded = [];

    public function checkInPassenger()
    {
    	return $this->hasOne('App\CheckInPassenger','checkIn_id');
    }

    public function checker()
    {
    	return $this->belongsTo('App\User','checker_id');
    }

    public function bus()
    {
    	return $this->belongsTo('App\Bus','bus_id');
    }

    public function busStop()
    {
    	return $this->belongsTo('App\BusStop','bus_stop_id');
    }
}
