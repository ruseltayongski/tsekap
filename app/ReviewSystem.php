<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewSystem extends Model
{
    protected $connection = 'mysql';
    protected $table = 'review_system';
    protected $guarded = array();
}
