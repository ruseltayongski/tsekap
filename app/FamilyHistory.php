<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'family_history';
    protected $guarded = array();
}
