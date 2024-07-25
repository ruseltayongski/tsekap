<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuTransport;
class ResuSafetyTransport extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'ResuSafetyTransport';
    
    public function resuTransport(){
        return $this->belongsTo(ResuTransport::class);
    }
}
