<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Bus extends Model
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guarded = [];

    public function busInRoute()
    {
    	return $this->hasOne('App\BusesInRoute','bus_id','id');
    }

    public function dailyIncomes()
    {
    	return $this->hasMany('App\DailyIncomeEntry','bus_id');
    }

    public function checkIns()
    {
        return $this->hasMany('App\CheckIn','bus_id');
    }

}
