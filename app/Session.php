<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sessions';
}
