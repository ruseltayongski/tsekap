<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntegrationPatient extends Model
{
    protected $connection = 'mysql';
    protected $table = 'integration_patient';
    protected $guarded = array();
}
