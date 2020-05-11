<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PastSurgicalHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'past_surgical_history';
    protected $guarded = array();
}
