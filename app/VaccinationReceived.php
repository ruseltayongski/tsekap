<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaccinationReceived extends Model
{
    protected $connection = 'mysql';
    protected $table = 'vaccination_received';
    protected $guarded = array();
}
