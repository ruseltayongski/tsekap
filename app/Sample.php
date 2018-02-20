<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'users';
}
