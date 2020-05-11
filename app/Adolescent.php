<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adolescent extends Model
{
    protected $connection = 'mysql';
    protected $table = 'adolescent';
    protected $guarded = array();
}
