<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NutritionStatus extends Model
{
    protected $connection = 'mysql';
    protected $table = 'nutri_stat';
    protected $guarded = array();
}
