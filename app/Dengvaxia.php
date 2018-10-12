<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dengvaxia extends Model
{
    protected $connection = 'dengvaxia_dummy';
    protected $table = 'dengvaxia_profiles';
    protected $guarded = array();
}