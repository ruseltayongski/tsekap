<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailService extends Model
{
    protected $connection = 'mysql';
    protected $table = 'available_services';
}
