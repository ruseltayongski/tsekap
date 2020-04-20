<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherProcedure extends Model
{
    protected $connection = 'mysql';
    protected $table = 'other_procedure';
    protected $guarded = array();
}
