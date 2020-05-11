<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'medical_history';
    protected $guarded = array();
}
