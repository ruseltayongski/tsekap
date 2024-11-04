<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;
use App\Province;
use App\Muncity;
use App\Barangay;

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
        return $this->belongsTo(Muncity::class, 'muncity_id');
    }

    public function barangay(){
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_updated_at', 'id');
    }   
}
