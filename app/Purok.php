<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purok extends Model
{
    protected $connection = 'mysql';
    protected $table = 'purok';
    protected $primaryKey = 'purok_id';
    protected $guarded = array();
}
