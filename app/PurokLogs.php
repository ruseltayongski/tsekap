<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurokLogs extends Model
{
    protected $connection = 'mysql';
    protected $table = 'purok_logs';
    protected $primaryKey = 'purok_logs_id';
    protected $guarded = array();
}
