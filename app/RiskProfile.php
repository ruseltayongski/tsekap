<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;
use App\Province;
use App\Muncity;
use App\Barangay;
use App\RiskFormAssesment;

class RiskProfile extends Model
{
    protected $connection = 'mysql';
    protected $table = 'risk_profile';
    protected $guarded = array();

    // Relationships
    public function profileId()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function muncity()
    {
        return $this->belongsTo(Muncity::class, 'municipal_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id_updated', 'id');
    }

    public function riskForm()
    {
        return $this->hasOne(RiskFormAssesment::class, 'risk_profile_id', 'id');
    }

    // Attributes
    protected $fillable = [
        'id',
        'profile_id',
        'lname',
        'fname',
        'mname',
        'suffix',
        'sex',
        'dob',
        'age',
        'civil_status',
        'religion',
        'other_religion',
        'contact',
        'province_id',
        'municipal_id',
        'barangay_id',
        'street',
        'purok',
        'sitio',
        'phic_id',
        'pwd_id',
        'citizenship',
        'other_citizenship',
        'indigenous_person',
        'employment_status',
        'facility_id_updated',
        'created_at',
        'updated_at',
    ];
}
