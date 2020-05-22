<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sitio';
    protected $primaryKey = 'sitio_id';
    protected $guarded = array();
}
