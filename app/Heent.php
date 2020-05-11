<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Heent extends Model
{
    protected $connection = 'mysql';
    protected $table = 'heent';
    protected $guarded = array();
}
