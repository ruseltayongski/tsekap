<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuPreadmission;
use App\ResuNatureInjury ;
class ResuNature_Preadmission extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resuNature_injury_Preadmission';
   
    public function preadmission(){
        return $this->belongsTo(ResuPreadmission::class, 'id');
    }

    //accessing natureInjury
    public function natureInjury(){
        return $this->belongsTo(ResuNatureInjury::class, 'natureInjury_id');
    }
}
