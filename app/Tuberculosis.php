<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tuberculosis extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tuberculosis';
    protected $guarded = array();
}
