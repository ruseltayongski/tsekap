<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $connection = 'mysql';
    protected $table = 'medication';
}
