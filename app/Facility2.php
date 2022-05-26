<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility2 extends Model
{
    protected $connection = 'mysql';
    protected $table = 'facility_add_info';
    protected $fillable = [
        'service_cap',
        'phic_status',
        'sched_day_from', 'sched_day_to',
        'sched_time_from', 'sched_time_to'.
        'sched_notes',
        'transport'
    ];
}
