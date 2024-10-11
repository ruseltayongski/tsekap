<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuNature_Preadmission;
use App\ResuPreadmission;
use App\ResuBodyParts;

class Resunature_injury_bodyparts extends Model
{
    //
    protected $connection = 'mysql';    
    protected $table = 'resunature_injury_bodyparts';

    public function natureInjuryPreadmission() {
        return $this->belongsTo(ResuNature_Preadmission::class, 'natureInjury_id'); // Correct foreign key
    }
    public function bodyPart()
    {
        return $this->belongsTo(ResuBodyParts::class, 'bodyparts_id'); // Foreign key
    }

    public function preadmission(){
        return $this->belongsTo(ResuPreadmission::class, 'preadmission_id');
    }
}
