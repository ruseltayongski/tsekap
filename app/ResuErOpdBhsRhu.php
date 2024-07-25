<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuHospitalFacility;

class ResuErOpdBhsRhu extends Model
{
    protected $connection = 'mysql';
    protected $table = 'resuErOpdBhsRhu';

    public function resuHospitalFacility(){
        return $this->belongsTo(ResuHospitalFacility::class, 'id');
    }
}
