<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalizationHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'hospitalization_history';
    protected $guarded = array();
}
