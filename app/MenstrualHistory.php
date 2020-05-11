<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenstrualHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'menstrual_history';
    protected $guarded = array();
}
