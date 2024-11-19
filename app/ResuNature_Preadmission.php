<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuPreadmission;
use App\ResuNatureInjury ;
use App\Resunature_injury_bodyparts;
use App\ResuBodyParts;

class ResuNature_Preadmission extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resuNature_injury_Preadmission';

    public function preadmission(){
        return $this->belongsTo(ResuPreadmission::class, 'id');
    }

    public function natureInjury(){
        return $this->belongsTo(ResuNatureInjury::class, 'natureInjury_id');
    }
    
    public function bodyParts()
    {
        return $this->hasMany(Resunature_injury_bodyparts::class, 'nature_injury_id', 'natureInjury_id'); 
    }

    
}
