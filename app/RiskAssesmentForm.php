<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskAssesmentForm extends Model
{
    protected $connection = 'mysql';
    protected $table = 'risk_form';
    protected $primaryKey = 'id';
    protected $guarded = array();
}
