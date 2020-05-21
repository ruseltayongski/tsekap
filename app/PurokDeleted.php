<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurokDeleted extends Model
{
    protected $connection = 'mysql';
    protected $table = 'purok_deleted';
    protected $primaryKey = 'purok_id';
    protected $guarded = array();
}
