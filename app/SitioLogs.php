<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SitioLogs extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sitio_logs';
    protected $primaryKey = 'sitio_logs_id';
    protected $guarded = array();
}
