<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Province;
use App\Muncity;
use App\Barangay;
use App\ResuReportFacility;
use App\ResuPreadmission;
use App\ResuInpatient;
use App\ResuErOpdBhsRhu;

class Profile extends Model
{
    protected $connection = 'mysql';
    protected $table = 'profile';
    protected $guarded = array();

    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function muncity(){
        return $this->belongsTo(Muncity::class, 'muncity_id');
    }

    public function barangay(){
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function reportfacility(){
        return $this->belongsTo(ResuReportFacility::class, 'report_facilityId');
    }

    public function preadmission(){
        return $this->hasOne(ResuPreadmission::class);
    }

    public function resuInpatient(){
        return $this->hasOne(ResuInpatient::class, 'profile_id');
    }

    public function resuEropdbhsrhu(){
        return $this->hasOne(ResuErOpdBhsRhu::class, 'profile_id');
    }
}
