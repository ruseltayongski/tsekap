<?php

namespace App\dengvaxia;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $connection = 'db_dengvaxia';
    protected $table = 'profiles';
    protected $fillable = [
        'unique_id',
        'tsekap_id',
        'list_number',
        'fac_province',
        'fac_muncity',
        'facility_name',
        'lname',
        'fname',
        'mname',
        'sitio',
        'barangay',
        'muncity',
        'province',
        'dob',
        'sex',
        'dose_screened',
        'dose_date_given',
        'dose_age',
        'validation',
        'dose_lot_no',
        'dose_batch_no',
        'dose_expiration',
        'dose_AEFI',
        'remarks',
        'status'
    ];
}
