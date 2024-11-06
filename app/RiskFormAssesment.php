<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\RiskProfile;

class RiskFormAssesment extends Model
{
    protected $connection = 'mysql';
    protected $table = 'risk_form';
    protected $guarded = array();
    protected $fillable = [
        'ar_chestpain',
        'ar_diffBreath',
        'ar_lossOfConsciousness',
        'ar_slurredSpeech',
        'ar_facialAsymmetry',
        'ar_weaknessNumbness',
        'ar_disoriented',
        'ar_chestRetractions',
        'ar_seizuresConvulsion',
        'ar_actSelfHarmSuicide',
        'ar_agitatedBehaivior',
        'ar_eyeInjury',
        'ar_severeInjuries',
        // other fields...
    ];
    


    public function risk_profile_Id(){
        return $this->belongsTo(RiskProfile::class, "id");
    }
}
