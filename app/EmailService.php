<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class EmailService extends Model
{
    use Notifiable;
    use HasRoles;
    
    protected $guarded = [];
}
