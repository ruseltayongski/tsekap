<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BhertPatient extends Model
{
    protected $connection = 'mysql';
    protected $table = 'bhert_patient';
    protected $guarded = array();
}
