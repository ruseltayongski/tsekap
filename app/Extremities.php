<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extremities extends Model
{
    protected $connection = 'mysql';
    protected $table = 'extremities';
    protected $guarded = array();
}
