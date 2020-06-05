<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfilePending extends Model
{
    protected $connection = 'mysql';
    protected $table = 'profile_pending';
    protected $guarded = array();
}
