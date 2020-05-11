<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Injury extends Model
{
    protected $connection = 'mysql';
    protected $table = 'injury';
    protected $guarded = array();
}
