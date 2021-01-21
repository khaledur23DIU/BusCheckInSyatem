<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class AssignChecker extends Model
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guarded = [];

    public function checker()
    {
        return $this->belongsTo('App\User','checker_id','id');
    }

    public function checkingPlace()
    {
        return $this->belongsTo('App\BusStop','bus_stop_id','id');
    }
}
