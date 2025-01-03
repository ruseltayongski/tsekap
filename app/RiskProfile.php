<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;
use App\Province;
use App\Muncity;
use App\Barangay;
use App\RiskFormAssesment;

class RiskProfile extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'risk_profile';
    protected $guarded = array();

    public function profileId(){
        return $this->belongsTo(Profile::class, "profile_id");
    }

    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function muncity(){
        return $this->belongsTo(Muncity::class, 'municipal_id');
    }

    public function barangay(){
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id_updated', 'id');
    }   
    public function riskForm()
    {
        return $this->hasOne(RiskFormAssesment::class, 'risk_profile_id', 'id');
    }
}
