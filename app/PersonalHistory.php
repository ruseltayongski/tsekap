<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'personal_history';
    protected $guarded = array();
}
