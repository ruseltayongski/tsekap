<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuNature_Preadmission;

class ResuNatureInjury extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resu_natureInjury';
    
    public function preadmission(){
        return $this->belongsTo(ResuPreadmission::class, 'Pre_admission_id');
    }
    public function natureInjuryPreadmissions(){
        return $this->hasMany(ResuNature_Preadmission::class, 'id');
    }
    // In NatureInjury model
    public function bodyParts()
    {
        return $this->hasMany(Resunature_injury_bodyparts::class, 'nature_injury_id');
    }

}
