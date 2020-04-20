<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dewormed extends Model
{
    protected $connection = 'mysql';
    protected $table = 'dewormed';
    protected $guarded = array();
}
