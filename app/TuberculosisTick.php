<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TuberculosisTick extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tuberculosis_tick';
    protected $guarded = array();
}
