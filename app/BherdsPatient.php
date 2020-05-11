<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BherdsPatient extends Model
{
    protected $connection = 'mysql';
    protected $table = 'bherds_patient';
    protected $guarded = array();
}
