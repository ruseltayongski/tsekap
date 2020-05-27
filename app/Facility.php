<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $connection = 'doh_referral';
    protected $table = 'facility';
    protected $guarded = array();
}
