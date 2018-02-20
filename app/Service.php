<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $connection = 'mysql';
    protected $table = 'services';
}
