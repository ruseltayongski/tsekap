<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRiskForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_form', function (Blueprint $table) {
          
            // Asses Redflag
            $table->increments('id'); // Auto-incrementing primary key
            $table->string('unique_id',255)->nullable();
            $table->string('ar_diffBreath', 8)->nullable();
            $table->string('ar_lossOfConsciousness', 8)->nullable();
            $table->string('ar_slurredSpeech', 8)->nullable();
            $table->string('ar_facialAsymmetry', 8)->nullable();
            $table->string('ar_disoriented', 8)->nullable();
            $table->string('ar_chestRetraction', 8)->nullable();
            $table->string('ar_seizureConvulsion', 8)->nullable();
            $table->string('ar_actSelfHarmSuicide', 8)->nullable();
            $table->string('ar_agitatedBehaivior', 8)->nullable();
            $table->string('ar_eyeInjury', 8)->nullable();
            $table->string('ar_severeInjuries', 8)->nullable();

            //referral
            $table->string('ar_refer_physicianName', 100)->nullable();
            $table->string('ar_refer_reason', 100)->nullable();
            $table->string('ar_refer_facility', 100)->nullable();

            // Past Medical History (pmh_)
            $table->string('pmh_hypertension', 5)->nullable();
            $table->string('pmh_heartDisease', 5)->nullable();
            $table->string('pmh_diabetes', 5)->nullable();
            $table->string('pmh_specify_diabetes', 100)->nullable();
            $table->string('pmh_cancer', 5)->nullable();
            $table->string('pmh_specify_cancer', 100)->nullable();
            $table->string('pmh_COPD', 5)->nullable();
            $table->string('pmh_asthma', 5)->nullable();
            $table->string('pmh_allergies', 5)->nullable();
            $table->string('pmh_specify_allergies', 100)->nullable();
            $table->string('pmh_MNandSDisorder', 5)->nullable();
            $table->string('pmh_specify_MNandSDisorder', 100)->nullable();
            $table->string('pmh_visionProblems', 5)->nullable();
            $table->string('pmh_previous_Surgical', 5)->nullable();
            $table->string('pmh_thyroidDisorders', 5)->nullable();
            $table->string('pmh_kidneyDisorders', 5)->nullable();

            // Family Medical History (fm_)
            $table->string('fm_hypertension', 5)->nullable();
            $table->string('fm_stroke', 5)->nullable();
            $table->string('fm_heartDisease', 5)->nullable();
            $table->string('fm_diabetesMel', 5)->nullable();
            $table->string('fm_asthma', 5)->nullable();
            $table->string('fm_cancer', 5)->nullable();
            $table->string('fm_kidneyDisease', 5)->nullable();
            $table->string('fm_firstDegreRelative', 5)->nullable();
            $table->string('fm_havingTB5years', 5)->nullable();
            $table->string('fm_MNandSDisorder', 5)->nullable();
            $table->string('fm_COPD', 5)->nullable();

            // Risk Factors (rf_)
            $table->string('rf_tobbacoUse', 5)->nullable();
            $table->string('rf_alcoholIntake', 5)->nullable();
            $table->string('rf_alcoholBingeDrinker', 5)->nullable();
            $table->string('rf_physicalActivity', 5)->nullable();
            $table->string('rf_nutritionDietary', 5)->nullable();
            $table->float('rf_weight')->nullable();
            $table->float('rf_height')->nullable();
            $table->float('rf_bodyMass')->nullable();
            $table->float('rf_waistCircum')->nullable();
            $table->float('rf_bloodPressure')->nullable();

            // Recent Screenings (rs_)
            $table->float('rs_bloodSugar_fbs')->nullable();
            $table->float('rs_bloodSugar_rbs')->nullable();
            $table->date('rs_bloodSugar_date_taken')->nullable();
            $table->string('rs_bloodSugar_symptoms', 100)->nullable();
            $table->float('rs_lipid_cholesterol')->nullable();
            $table->float('rs_lipid_hdl')->nullable();
            $table->float('rs_lipid_ldl')->nullable();
            $table->float('rs_lipid_vldl')->nullable();
            $table->float('rs_lipid_triglyceride')->nullable();
            $table->date('rs_lipid_date_taken')->nullable();
            $table->string('rs_urine_protein', 5)->nullable();
            $table->date('rs_urine_protein_date_taken')->nullable();
            $table->string('rs_urine_ketones', 5)->nullable();
            $table->date('rs_urine_ketones_date_taken')->nullable();
            $table->string('rs_respiratory', 5)->nullable();

            // Management (mngm_)
            $table->string('mngm_med_hypertension', 5)->nullable();
            $table->string('mngm_med_hypertension_specify', 100)->nullable();
            $table->string('mngm_med_diabetes', 5)->nullable();
            $table->string('mngm_med_diabetes_specify', 100)->nullable();
            $table->date('mngm_date_follow_up')->nullable();
            $table->text('mngm_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_form');
    }
}
