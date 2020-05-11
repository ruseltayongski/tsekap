<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abdomen extends Model
{
    protected $connection = 'mysql';
    protected $table = 'abdomen';
    protected $guarded = array();
}
