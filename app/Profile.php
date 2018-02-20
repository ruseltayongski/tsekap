<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $connection = 'mysql';
    protected $table = 'profile';
}
