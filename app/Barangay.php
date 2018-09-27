<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $connection = 'mysql';
    protected $table = 'barangay';
    protected $fillable = [
        'dengvaxia_link'
    ];
}
