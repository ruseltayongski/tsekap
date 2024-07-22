<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;

class ResuReportFacility extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'resu_Report_facility';

    public function profile(){
        return $this->hasOne(Profile::class, 'id');
    }
}
