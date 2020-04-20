<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralInformation extends Model
{
    protected $connection = 'mysql';
    protected $table = 'general_information';
    protected $guarded = array();

}
