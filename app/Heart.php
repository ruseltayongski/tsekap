<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Heart extends Model
{
    protected $connection = 'mysql';
    protected $table = 'heart';
    protected $guarded = array();
}
