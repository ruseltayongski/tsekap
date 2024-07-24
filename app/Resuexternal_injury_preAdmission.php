<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuPreadmission;

class Resuexternal_injury_preAdmission extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resuxternal_injury_preAdmission';

    public function preadmission(){
        return $this->belongsTo(ResuPreadmission::class, 'id');
    }
}
