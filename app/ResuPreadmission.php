<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;
use App\ResuProfileInjury;
use App\ResuNature_Preadmission;
use App\Resuexternal_injury_preAdmission;
use App\ResuTransport;
class ResuPreadmission extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resuPre_admission';

    public function profile(){
        return $this->belongsTo(ResuProfileInjury::class);
    }
    
    public function natureInjuryPreadmissions(){
        return $this->hasMany(ResuNature_Preadmission::class, 'Pre_admission_id');
    }
    
    public function externalPreadmissions(){
        return $this->hasMany(Resuexternal_injury_preAdmission::class, 'Pre_admission_id');
    }

    public function transport(){
        return hasMany(ResuTransport::class, 'Pre_admission_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'POIProvince_id', 'id');
    }
    public function muncity()
    {
        return $this->belongsTo(Muncity::class, 'POImuncity_id', 'id');
    }
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'POIBarangay_id', 'id');
    }
}
