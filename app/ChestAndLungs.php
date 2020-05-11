<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChestAndLungs extends Model
{
    protected $connection = 'mysql';
    protected $table = 'chest_and_lungs';
    protected $guarded = array();
}
