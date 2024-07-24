<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuNature_Preadmission;

class Resunature_injury_bodyparts extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resunature_injury_bodyparts';

    public function natureInjuryPreadmission(){
        return $this->hasMany(ResuNature_Preadmission::class, 'preadmission_id');
    }

    
}
