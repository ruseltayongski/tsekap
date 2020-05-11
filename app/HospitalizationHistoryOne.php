<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalizationHistoryOne extends Model
{
    protected $connection = 'mysql';
    protected $table = 'hospitalization_history_one';
    protected $guarded = array();
}
