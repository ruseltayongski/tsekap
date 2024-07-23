<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuNature_Preadmission;

class ResuNatureInjury extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resu_natureInjury';

    public function natureInjuryPreadmissions(){
        return $this->hasMany(ResuNature_Preadmission::class, 'id');
    }
}
