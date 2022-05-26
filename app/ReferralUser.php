<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ReferralUser extends Authenticatable
{
    protected $connection = 'doh_referral';
    protected $table = 'users';
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'username',
        'password',
        'level',
        'facility_id',
        'department_id',
        'muncity',
        'province',
        'designation',
        'status',
        'email',
        'contact'
    ];
}
