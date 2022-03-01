<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Immunization extends Model
{
    protected $connection = 'mysql';
    protected $table = 'immu_stat';
    protected $guarded = array();
}
