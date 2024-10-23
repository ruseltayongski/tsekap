<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuSafety;
use App\ResuPreadmission;
class ResuTransport extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'Resutransport';

    public function preadmission(){
        return $this->belongsTo(ResuPreadmission::class, 'Pre_admission_id');
    }

   
    public function safetyRecord() {
        return $this->belongsTo(ResuSafety::class, 'safety');
    }
}
