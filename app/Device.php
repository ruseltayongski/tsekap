<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $connection = 'mysql';
    protected $table = 'profile_device';
}
