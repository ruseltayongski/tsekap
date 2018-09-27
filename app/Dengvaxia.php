<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dengvaxia extends Model
{
    protected $connection = 'dengvaxia';
    protected $table = 'dengvaxia_profiles';
    protected $guarded = array();
}