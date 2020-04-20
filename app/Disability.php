<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    protected $connection = 'mysql';
    protected $table = 'disability';
    protected $guarded = array();
}
