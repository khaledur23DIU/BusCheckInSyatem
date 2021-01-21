<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class DailyIncomeEntry extends Model
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'check_in_ids' => 'array',
        'check_in_places' => 'array',
    ];


    public function bus()
    {
    	return $this->belongsTo('App\Bus','bus_id');
    }
}
