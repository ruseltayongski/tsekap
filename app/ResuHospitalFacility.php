<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuInpatient;
use App\ResuErOpdBhsRhu;

class ResuHospitalFacility extends Model
{
    protected $connection = 'mysql';
    protected $table = 'resuHospitalFacility';

    public function resuInpatients(){
        return $this->hasMany(ResuInpatient::class, 'hospitalfacility_id');
    }

    public function resuEropdbhsrhus(){
        return $this->hasMany(ResuErOpdBhsRhu::class, 'hospitalfacility_id');
    }
}
