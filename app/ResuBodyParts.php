<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Resunature_injury_bodyparts;
use App\ResuNature_Preadmission;

class ResuBodyParts extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'body_parts';

    public function bodyPart() { 
        return $this->belongsTo(Resunature_injury_bodyparts::class, 'id');
    }
}