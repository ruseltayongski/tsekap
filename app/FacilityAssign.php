<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityAssign extends Model
{
    protected $connection = 'doh_referral';
    protected $table = 'facility_assignment';
    protected $fillable = [
        'user_id',
        'facility_id',
        'specialization',
        'schedule',
        'fee',
        'contact',
        'email'
    ];
}
