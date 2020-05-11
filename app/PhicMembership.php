<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhicMembership extends Model
{
    protected $connection = 'mysql';
    protected $table = 'phic_membership';
    protected $guarded = array();
}
