<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PertinentExamination extends Model
{
    protected $connection = 'mysql';
    protected $table = 'pertinent_examination';
    protected $guarded = array();
}
