<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHealthFacility extends Model
{

    protected $fillable = [
        'user_id', 'facility_id', 'user_designation', 'assigned_at'
    ];

    public $timestamps = false;
}
