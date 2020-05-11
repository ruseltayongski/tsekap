<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TuberculosisLabs extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tuberculosis_labs';
    protected $guarded = array();
}
