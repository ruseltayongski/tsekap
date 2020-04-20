<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaccinationHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'vaccination_history';
    protected $guarded = array();
}
