<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResuTransport;
class ResuSafety extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'ResuSafety';

    public function safetyname() {
        return $this->hasMany(ResuTransport::class, 'safety');
    }
}
