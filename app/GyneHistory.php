<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GyneHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'gyne_history';
    protected $guarded = array();
}
