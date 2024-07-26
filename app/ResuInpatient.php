<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuHospitalFacility;
class ResuInpatient extends Model
{
    protected $connection = 'mysql';
    protected $table = 'resuInpatient';

    public function resuHospitalFacility(){
        return $this->belongsTo(ResuHospitalFacility::class, 'id');
    }   
}
