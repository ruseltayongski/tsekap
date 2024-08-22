<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;
use App\Facility;

class ResuReportFacility extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resu_Report_facility';

    protected $fillable = [
        'reportfacility', 'typeOfdru', 'Addressfacility', 'typeofpatient',
    ];

    public function profile(){
        return $this->hasOne(Profile::class, 'id');
    }

    public function facility(){ // search for facility
        return $this->belongsTo(Facility::class, 'facility_id');
    }

}
