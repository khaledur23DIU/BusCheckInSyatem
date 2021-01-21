<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class CheckInPassenger extends Model
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guarded = [];

    public function checkIn()
    {
    	return $this->belongsTo('App\CheckIn','checkIn_id');
    }

    public function checkInIncome()
    {
    	return $this->hasOne('App\CheckInIncome','checkInPass_id');
    }
}
