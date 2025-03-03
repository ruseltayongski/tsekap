<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuPreadmission;
use App\ResuTransport;
use App\ResuExternalInjury;
class Resuexternal_injury_preAdmission extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resuxternal_injury_preAdmission';

    public function preadmission(){
        return $this->belongsTo(ResuPreadmission::class, 'id');
    }

    public function transport(){
        return $this->hasMany(ResuTransport::class, 'Pre_admission_id', 'Pre_admission_id');
    }
    public function externalInjury()
    {
        return $this->belongsTo(ResuExternalInjury::class, 'externalinjury_id');
    }

}
