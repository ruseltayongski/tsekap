<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuSafetyTransport;
class ResuTransport extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'Resutransport';

    public function Allsafety(){
        return $this->hasMany(ResuSafetyTransport::class, 'Transport_safety_id', 'id');
    }
}
