<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameRiskFromColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_form_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('risk_profile_id', 255)->nullable()->default(null);
            $table->string('ar_chestpain', 8)->nullable()->default(null);
            $table->string('ar_diffBreath', 8)->nullable()->default(null);
            $table->string('ar_lossOfConsciousness', 8)->nullable()->default(null);
            $table->string('ar_slurredSpeech', 8)->nullable()->default(null);
            $table->string('ar_facialAsymmetry', 8)->nullable()->default(null);
            $table->string('ar_weaknessNumbness', 8)->nullable()->default(null);
            $table->string('ar_disoriented', 8)->nullable()->default(null);
            $table->string('ar_chestRetraction', 8)->nullable()->default(null);
            $table->string('ar_seizureConvulsion', 8)->nullable()->default(null);
            $table->string('ar_actSelfHarmSuicide', 8)->nullable()->default(null);
            $table->string('ar_agitatedBehavior', 8)->nullable()->default(null);
            $table->string('ar_eyeInjury',8)->nullable()->default(null);
            $table->string('ar_severeInjuries', 8)->nullable()->default(null);
            $table->string('ar_refer_physicianName', 255)->nullable()->default(null);
            $table->string('ar_refer_reason', 255)->nullable()->default(null);
            $table->string('ar_refer_facility', 255)->nullable()->default(null);
            $table->string('pmh_hypertension', 8)->nullable()->default(null);
            $table->string('pmh_heartDisease', 8)->nullable()->default(null);
            $table->string('pmh_diabetes', 8)->nullable()->default(null);
            $table->string('pmh_specify_diabetes', 255)->nullable()->default(null);
            $table->string('pmh_cancer', 8)->nullable()->default(null);
            $table->string('pmh_specify_cancer', 255)->nullable()->default(null);
            $table->string('pmh_copd', 8)->nullable()->default(null);
            $table->string('pmh_asthma', 8)->nullable()->default(null);
            $table->string('pmh_allergies', 8)->nullable()->default(null);
            $table->string('pmh_specify_allergies', 255)->nullable()->default(null);
            $table->string('pmh_MNandSDisorder', 8)->nullable()->default(null);
            $table->string('pmh_specify_MNandSdDisorder', 255)->nullable()->default(null);
            $table->string('pmh_visionProblems', 8)->nullable()->default(null);
            $table->string('pmh_previous_Surgical', 8)->nullable()->default(null);
            $table->string('pmh_specify_previous_Surgical', 255)->nullable()->default(null);
            $table->string('pmh_thyroidDisorders', 8)->nullable()->default(null);
            $table->string('pmh_kidneyDisorders', 8)->nullable()->default(null);
            $table->string('fm_hypertension', 8)->nullable()->default(null);
            $table->string('fm_sideHypertension', 255)->nullable()->default(null);
            $table->string('fm_stroke', 255)->nullable()->default(null);
            $table->string('fm_sideStroke', 255)->nullable()->default(null);
            $table->string('fm_heartDisease', 255)->nullable()->default(null);
            $table->string('fm_sideHeartDisease', 255)->nullable()->default(null);
            $table->string('fm_diabetesMel', 255)->nullable()->default(null);
            $table->string('fmh_sideDiabetesMellitus', 255)->nullable()->default(null);
            $table->string('fmh_asthma', 255)->nullable()->default(null);
            $table->string('fmh_sideAsthma', 255)->nullable()->default(null);
            $table->string('fmh_cancer', 255)->nullable()->default(null);
            $table->string('fmh_sideCancer', 255)->nullable()->default(null);
            $table->string('fmh_kidneyDisease', 255)->nullable()->default(null);
            $table->string('fmh_sideKidneyDisease', 255)->nullable()->default(null);
            $table->string('fmh_firstdegreRelative', 255)->nullable()->default(null);
            $table->string('fmh_sideCoronaryDisease', 255)->nullable()->default(null);
            $table->string('fmh_havingTB5years', 255)->nullable()->default(null);
            $table->string('fmh_sideTuberculosis', 255)->nullable()->default(null);
            $table->string('fmh_MNandSDisorder', 255)->nullable()->default(null);
            $table->string('fm_sideDisorders', 255)->nullable()->default(null);
            $table->string('fmh_COPD', 255)->nullable()->default(null);
            $table->string('fmh_sideCOPD', 255)->nullable()->default(null);
            $table->string('rf_tobbacoUse', 255)->nullable()->default(null);
            $table->string('rf_alcoholIntake', 255)->nullable()->default(null);
            $table->string('rf_alcoholBingeDrinker', 255)->nullable()->default(null);
            $table->string('rf_physicalActivity', 255)->nullable()->default(null);
            $table->string('rf_nutritionDietary', 255)->nullable()->default(null);
            $table->float('rf_weight', 8, 2)->nullable()->default(null);
            $table->float('rf_height', 8, 2)->nullable()->default(null);
            $table->float('rf_bodyMass', 8, 2)->nullable()->default(null);
            $table->float('rf_waistCircum', 8, 2)->nullable()->default(null);
            $table->float('rs_systolic_t1', 8, 2)->nullable()->default(null);
            $table->float('rs_diastolic_t1', 8, 2)->nullable()->default(null);
            $table->float('rs_systolic_t2', 8, 2)->nullable()->default(null);
            $table->float('rs_diastolic_t2', 8, 2)->nullable()->default(null);
            $table->float('rs_bloodSugar_fbs', 8, 2)->nullable()->default(null);
            $table->float('rs_bloodSugar_rbs', 8, 2)->nullable()->default(null);
            $table->date('rs_bloodSugar_date_taken')->nullable()->default(null);
            $table->string('rs_bloodSugar_symptoms', 255)->nullable()->default(null);
            $table->float('rs_lipid_cholesterol', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_hdl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_ldl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_vldl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_triglyceride', 8, 2)->nullable()->default(null);
            $table->date('rs_lipid_date_taken')->nullable()->default(null);
            $table->float('rs_urine_protein', 8, 2)->nullable()->default(null);
            $table->date('rs_urine_protein_date_taken')->nullable()->default(null);
            $table->float('rs_urine_ketones', 8, 2)->nullable()->default(null);
            $table->date('rs_urine_ketones_date_taken')->nullable()->default(null);
            $table->string('rs_Chronic_Respiratory_Disease', 255)->nullable()->default(null);
            $table->string('rs_if_yes_any_symptoms', 255)->nullable()->default(null);
            $table->string('mngm_med_hypertension', 255)->nullable()->default(null);
            $table->string('mngm_med_hypertension_specify', 255)->nullable()->default(null);
            $table->string('mngm_med_diabetes', 255)->nullable()->default(null);
            $table->string('mngm_med_diabetes_options', 255)->nullable()->default(null);
            $table->string('mngm_med_diabetes_specify', 255)->nullable()->default(null);
            $table->date('mngm_date_follow_up')->nullable()->default(null);
            $table->text('mngm_remarks')->nullable()->default(null);
            $table->timestamps();
        });

        DB::statement('insert into risk_form_temp select * from risk_form');

        Schema::dropIfExists('risk_form');

        Schema::create('risk_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('risk_profile_id', 255)->nullable()->default(null);
            $table->string('ar_chest_pain', 8)->nullable()->default(null);
            $table->string('ar_difficulty_breathing', 8)->nullable()->default(null);
            $table->string('ar_loss_of_consciousness', 8)->nullable()->default(null);
            $table->string('ar_slurred_speech', 8)->nullable()->default(null);
            $table->string('ar_facial_asymmetry', 8)->nullable()->default(null);
            $table->string('ar_weakness_numbness', 8)->nullable()->default(null);
            $table->string('ar_disoriented', 8)->nullable()->default(null);
            $table->string('ar_chest_retractions', 8)->nullable()->default(null);
            $table->string('ar_seizure_convulsion', 8)->nullable()->default(null);
            $table->string('ar_act_self_harm_suicide', 8)->nullable()->default(null);
            $table->string('ar_agitated_behavior', 8)->nullable()->default(null);
            $table->string('ar_eye_injury',8)->nullable()->default(null);
            $table->string('ar_severe_injuries', 8)->nullable()->default(null);
            $table->string('ar_refer_physician_name', 255)->nullable()->default(null);
            $table->string('ar_refer_reason', 255)->nullable()->default(null);
            $table->string('ar_refer_facility', 255)->nullable()->default(null);
            $table->string('pmh_hypertension', 8)->nullable()->default(null);
            $table->string('pmh_heart_disease', 8)->nullable()->default(null);
            $table->string('pmh_diabetes', 8)->nullable()->default(null);
            $table->string('pmh_specify_diabetes', 255)->nullable()->default(null);
            $table->string('pmh_cancer', 8)->nullable()->default(null);
            $table->string('pmh_specify_cancer', 255)->nullable()->default(null);
            $table->string('pmh_copd', 8)->nullable()->default(null);
            $table->string('pmh_asthma', 8)->nullable()->default(null);
            $table->string('pmh_allergies', 8)->nullable()->default(null);
            $table->string('pmh_specify_allergies', 255)->nullable()->default(null);
            $table->string('pmh_mn_and_s_disorder', 8)->nullable()->default(null);
            $table->string('pmh_specify_mn_and_s_disorder', 255)->nullable()->default(null);
            $table->string('pmh_vision_problems', 8)->nullable()->default(null);
            $table->string('pmh_previous_surgical', 8)->nullable()->default(null);
            $table->string('pmh_specify_previous_surgical', 255)->nullable()->default(null);
            $table->string('pmh_thyroid_disorders', 8)->nullable()->default(null);
            $table->string('pmh_kidney_disorders', 8)->nullable()->default(null);
            $table->string('fmh_hypertension', 8)->nullable()->default(null);
            $table->string('fmh_side_hypertension', 255)->nullable()->default(null);
            $table->string('fmh_stroke', 255)->nullable()->default(null);
            $table->string('fmh_side_stroke', 255)->nullable()->default(null);
            $table->string('fmh_heart_disease', 255)->nullable()->default(null);
            $table->string('fmh_side_heart_disease', 255)->nullable()->default(null);
            $table->string('fmh_diabetes_mellitus', 255)->nullable()->default(null);
            $table->string('fmh_side_diabetes_mellitus', 255)->nullable()->default(null);
            $table->string('fmh_asthma', 255)->nullable()->default(null);
            $table->string('fmh_side_asthma', 255)->nullable()->default(null);
            $table->string('fmh_cancer', 255)->nullable()->default(null);
            $table->string('fmh_side_cancer', 255)->nullable()->default(null);
            $table->string('fmh_kidney_disease', 255)->nullable()->default(null);
            $table->string('fmh_side_kidney_disease', 255)->nullable()->default(null);
            $table->string('fmh_first_degree_relative', 255)->nullable()->default(null);
            $table->string('fmh_side_coronary_disease', 255)->nullable()->default(null);
            $table->string('fmh_having_tuberculosis_5_years', 255)->nullable()->default(null);
            $table->string('fmh_side_tuberculosis', 255)->nullable()->default(null);
            $table->string('fmh_mn_and_s_disorder', 255)->nullable()->default(null);
            $table->string('fm_side_disorders', 255)->nullable()->default(null);
            $table->string('fmh_copd', 255)->nullable()->default(null);
            $table->string('fmh_side_copd', 255)->nullable()->default(null);
            $table->string('rf_tobbaco_use', 255)->nullable()->default(null);
            $table->string('rf_alcohol_intake', 255)->nullable()->default(null);
            $table->string('rf_alcohol_binge_drinker', 255)->nullable()->default(null);
            $table->string('rf_physical_activity', 255)->nullable()->default(null);
            $table->string('rf_nutrition_dietary', 255)->nullable()->default(null);
            $table->float('rf_weight', 8, 2)->nullable()->default(null);
            $table->float('rf_height', 8, 2)->nullable()->default(null);
            $table->float('rf_body_mass', 8, 2)->nullable()->default(null);
            $table->float('rf_waist_circumference', 8, 2)->nullable()->default(null);
            $table->float('rs_systolic_t1', 8, 2)->nullable()->default(null);
            $table->float('rs_diastolic_t1', 8, 2)->nullable()->default(null);
            $table->float('rs_systolic_t2', 8, 2)->nullable()->default(null);
            $table->float('rs_diastolic_t2', 8, 2)->nullable()->default(null);
            $table->float('rs_blood_sugar_fbs', 8, 2)->nullable()->default(null);
            $table->float('rs_blood_sugar_rbs', 8, 2)->nullable()->default(null);
            $table->date('rs_blood_sugar_date_taken')->nullable()->default(null);
            $table->string('rs_blood_sugar_symptoms', 255)->nullable()->default(null);
            $table->float('rs_lipid_cholesterol', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_hdl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_ldl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_vldl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_triglyceride', 8, 2)->nullable()->default(null);
            $table->date('rs_lipid_date_taken')->nullable()->default(null);
            $table->float('rs_urine_protein', 8, 2)->nullable()->default(null);
            $table->date('rs_urine_protein_date_taken')->nullable()->default(null);
            $table->float('rs_urine_ketones', 8, 2)->nullable()->default(null);
            $table->date('rs_urine_ketones_date_taken')->nullable()->default(null);
            $table->string('rs_chronic_respiratory_disease', 255)->nullable()->default(null);
            $table->string('rs_if_yes_any_symptoms', 255)->nullable()->default(null);
            $table->string('mngm_med_hypertension', 8)->nullable()->default(null);
            $table->string('mngm_med_hypertension_specify', 255)->nullable()->default(null);
            $table->string('mngm_med_diabetes', 8)->nullable()->default(null);
            $table->string('mngm_med_diabetes_options', 50)->nullable()->default(null);
            $table->string('mngm_med_diabetes_specify', 255)->nullable()->default(null);
            $table->date('mngm_date_follow_up')->nullable()->default(null);
            $table->text('mngm_remarks')->nullable()->default(null);
            $table->timestamps();
        });

        DB::statement('INSERT INTO risk_form SELECT * FROM risk_form_temp');

        Schema::dropIfExists('risk_form_temp');
    }

    public function down()
    {
        Schema::create('risk_form_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('risk_profile_id', 255)->nullable()->default(null);
            $table->string('ar_chest_pain', 8)->nullable()->default(null);
            $table->string('ar_difficulty_breathing', 8)->nullable()->default(null);
            $table->string('ar_loss_of_consciousness', 8)->nullable()->default(null);
            $table->string('ar_slurred_speech', 8)->nullable()->default(null);
            $table->string('ar_facial_asymmetry', 8)->nullable()->default(null);
            $table->string('ar_weakness_numbness', 8)->nullable()->default(null);
            $table->string('ar_disoriented', 8)->nullable()->default(null);
            $table->string('ar_chest_retractions', 8)->nullable()->default(null);
            $table->string('ar_seizure_convulsion', 8)->nullable()->default(null);
            $table->string('ar_act_self_harm_suicide', 8)->nullable()->default(null);
            $table->string('ar_agitated_behavior', 8)->nullable()->default(null);
            $table->string('ar_eye_injury',8)->nullable()->default(null);
            $table->string('ar_severe_injuries', 8)->nullable()->default(null);
            $table->string('ar_refer_physician_name', 255)->nullable()->default(null);
            $table->string('ar_refer_reason', 255)->nullable()->default(null);
            $table->string('ar_refer_facility', 255)->nullable()->default(null);
            $table->string('pmh_hypertension', 8)->nullable()->default(null);
            $table->string('pmh_heart_disease', 8)->nullable()->default(null);
            $table->string('pmh_diabetes', 8)->nullable()->default(null);
            $table->string('pmh_specify_diabetes', 255)->nullable()->default(null);
            $table->string('pmh_cancer', 8)->nullable()->default(null);
            $table->string('pmh_specify_cancer', 255)->nullable()->default(null);
            $table->string('pmh_copd', 8)->nullable()->default(null);
            $table->string('pmh_asthma', 8)->nullable()->default(null);
            $table->string('pmh_allergies', 8)->nullable()->default(null);
            $table->string('pmh_specify_allergies', 255)->nullable()->default(null);
            $table->string('pmh_mn_and_s_disorder', 8)->nullable()->default(null);
            $table->string('pmh_specify_mn_and_s_disorder', 255)->nullable()->default(null);
            $table->string('pmh_vision_problems', 8)->nullable()->default(null);
            $table->string('pmh_previous_surgical', 8)->nullable()->default(null);
            $table->string('pmh_specify_previous_surgical', 255)->nullable()->default(null);
            $table->string('pmh_thyroid_disorders', 8)->nullable()->default(null);
            $table->string('pmh_kidney_disorders', 8)->nullable()->default(null);
            $table->string('fmh_hypertension', 8)->nullable()->default(null);
            $table->string('fmh_side_hypertension', 255)->nullable()->default(null);
            $table->string('fmh_stroke', 255)->nullable()->default(null);
            $table->string('fmh_side_stroke', 255)->nullable()->default(null);
            $table->string('fmh_heart_disease', 255)->nullable()->default(null);
            $table->string('fmh_side_heart_disease', 255)->nullable()->default(null);
            $table->string('fmh_diabetes_mellitus', 255)->nullable()->default(null);
            $table->string('fmh_side_diabetes_mellitus', 255)->nullable()->default(null);
            $table->string('fmh_asthma', 255)->nullable()->default(null);
            $table->string('fmh_side_asthma', 255)->nullable()->default(null);
            $table->string('fmh_cancer', 255)->nullable()->default(null);
            $table->string('fmh_side_cancer', 255)->nullable()->default(null);
            $table->string('fmh_kidney_disease', 255)->nullable()->default(null);
            $table->string('fmh_side_kidney_disease', 255)->nullable()->default(null);
            $table->string('fmh_first_degree_relative', 255)->nullable()->default(null);
            $table->string('fmh_side_coronary_disease', 255)->nullable()->default(null);
            $table->string('fmh_having_tuberculosis_5_years', 255)->nullable()->default(null);
            $table->string('fmh_side_tuberculosis', 255)->nullable()->default(null);
            $table->string('fmh_mn_and_s_disorder', 255)->nullable()->default(null);
            $table->string('fm_side_disorders', 255)->nullable()->default(null);
            $table->string('fmh_copd', 255)->nullable()->default(null);
            $table->string('fmh_side_copd', 255)->nullable()->default(null);
            $table->string('rf_tobbaco_use', 255)->nullable()->default(null);
            $table->string('rf_alcohol_intake', 255)->nullable()->default(null);
            $table->string('rf_alcohol_binge_drinker', 255)->nullable()->default(null);
            $table->string('rf_physical_activity', 255)->nullable()->default(null);
            $table->string('rf_nutrition_dietary', 255)->nullable()->default(null);
            $table->float('rf_weight', 8, 2)->nullable()->default(null);
            $table->float('rf_height', 8, 2)->nullable()->default(null);
            $table->float('rf_body_mass', 8, 2)->nullable()->default(null);
            $table->float('rf_waist_circumference', 8, 2)->nullable()->default(null);
            $table->float('rs_systolic_t1', 8, 2)->nullable()->default(null);
            $table->float('rs_diastolic_t1', 8, 2)->nullable()->default(null);
            $table->float('rs_systolic_t2', 8, 2)->nullable()->default(null);
            $table->float('rs_diastolic_t2', 8, 2)->nullable()->default(null);
            $table->float('rs_blood_sugar_fbs', 8, 2)->nullable()->default(null);
            $table->float('rs_blood_sugar_rbs', 8, 2)->nullable()->default(null);
            $table->date('rs_blood_sugar_date_taken')->nullable()->default(null);
            $table->string('rs_blood_sugar_symptoms', 255)->nullable()->default(null);
            $table->float('rs_lipid_cholesterol', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_hdl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_ldl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_vldl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_triglyceride', 8, 2)->nullable()->default(null);
            $table->date('rs_lipid_date_taken')->nullable()->default(null);
            $table->float('rs_urine_protein', 8, 2)->nullable()->default(null);
            $table->date('rs_urine_protein_date_taken')->nullable()->default(null);
            $table->float('rs_urine_ketones', 8, 2)->nullable()->default(null);
            $table->date('rs_urine_ketones_date_taken')->nullable()->default(null);
            $table->string('rs_chronic_respiratory_disease', 255)->nullable()->default(null);
            $table->string('rs_if_yes_any_symptoms', 255)->nullable()->default(null);
            $table->string('mngm_med_hypertension', 8)->nullable()->default(null);
            $table->string('mngm_med_hypertension_specify', 255)->nullable()->default(null);
            $table->string('mngm_med_diabetes', 8)->nullable()->default(null);
            $table->string('mngm_med_diabetes_options', 50)->nullable()->default(null);
            $table->string('mngm_med_diabetes_specify', 255)->nullable()->default(null);
            $table->date('mngm_date_follow_up')->nullable()->default(null);
            $table->text('mngm_remarks')->nullable()->default(null);
            $table->timestamps();
        });

        DB::statement("
        INSERT INTO risk_form_temp (
            id,
            risk_profile_id,
            ar_chest_pain,
            ar_difficulty_breathing,
            ar_loss_of_consciousness,
            ar_slurred_speech,
            ar_facial_asymmetry,
            ar_weakness_numbness,
            ar_disoriented,
            ar_chest_retractions,
            ar_seizure_convulsion,
            ar_act_self_harm_suicide,
            ar_agitated_behavior,
            ar_eye_injury,
            ar_severe_injuries,
            ar_refer_physician_name,
            ar_refer_reason,
            ar_refer_facility,
            pmh_hypertension,
            pmh_heart_disease,
            pmh_diabetes,
            pmh_specify_diabetes,
            pmh_cancer,
            pmh_specify_cancer,
            pmh_copd,
            pmh_asthma,
            pmh_allergies,
            pmh_specify_allergies,
            pmh_mn_and_s_disorder,
            pmh_specify_mn_and_s_disorder,
            pmh_vision_problems,
            pmh_previous_surgical,
            pmh_specify_previous_surgical,
            pmh_thyroid_disorders,
            pmh_kidney_disorders,
            fmh_hypertension,
            fmh_side_hypertension,
            fmh_stroke,
            fmh_side_stroke,
            fmh_heart_disease,
            fmh_side_heart_disease,
            fmh_diabetes_mellitus,
            fmh_side_diabetes_mellitus,
            fmh_asthma,
            fmh_side_asthma,
            fmh_cancer,
            fmh_side_cancer,
            fmh_kidney_disease,
            fmh_side_kidney_disease,
            fmh_first_degree_relative,
            fmh_side_coronary_disease,
            fmh_having_tuberculosis_5_years,
            fmh_side_tuberculosis,
            fmh_mn_and_s_disorder,
            fm_side_disorders,
            fmh_copd,
            fmh_side_copd,
            rf_tobbaco_use,
            rf_alcohol_intake,
            rf_alcohol_binge_drinker,
            rf_physical_activity,
            rf_nutrition_dietary,
            rf_weight,
            rf_height,
            rf_body_mass,
            rf_waist_circumference,
            rs_systolic_t1,
            rs_diastolic_t1,
            rs_systolic_t2,
            rs_diastolic_t2,
            rs_blood_sugar_fbs,
            rs_blood_sugar_rbs,
            rs_blood_sugar_date_taken,
            rs_blood_sugar_symptoms,
            rs_lipid_cholesterol,
            rs_lipid_hdl,
            rs_lipid_ldl,
            rs_lipid_vldl,
            rs_lipid_triglyceride,
            rs_lipid_date_taken,
            rs_urine_protein,
            rs_urine_protein_date_taken,
            rs_urine_ketones,
            rs_urine_ketones_date_taken,
            rs_chronic_respiratory_disease,
            rs_if_yes_any_symptoms,
            mngm_med_hypertension,
            mngm_med_hypertension_specify,
            mngm_med_diabetes,
            mngm_med_diabetes_options,
            mngm_med_diabetes_specify,
            mngm_date_follow_up,
            mngm_remarks,
            created_at,
            updated_at
        )
        SELECT
            id,
            risk_profile_id,
            ar_chest_pain,
            ar_difficulty_breathing,
            ar_loss_of_consciousness,
            ar_slurred_speech,
            ar_facial_asymmetry,
            ar_weakness_numbness,
            ar_disoriented,
            ar_chest_retractions,
            ar_seizure_convulsion,
            ar_act_self_harm_suicide,
            ar_agitated_behavior,
            ar_eye_injury,
            ar_severe_injuries,
            ar_refer_physician_name,
            ar_refer_reason,
            ar_refer_facility,
            pmh_hypertension,
            pmh_heart_disease,
            pmh_diabetes,
            pmh_specify_diabetes,
            pmh_cancer,
            pmh_specify_cancer,
            pmh_copd,
            pmh_asthma,
            pmh_allergies,
            pmh_specify_allergies,
            pmh_mn_and_s_disorder,
            pmh_specify_mn_and_s_disorder,
            pmh_vision_problems,
            pmh_previous_surgical,
            pmh_specify_previous_surgical,
            pmh_thyroid_disorders,
            pmh_kidney_disorders,
            fmh_hypertension,
            null AS fmh_side_hypertension,
            fmh_stroke,
            null AS fmh_side_stroke,
            fmh_heart_disease,
            null AS fmh_side_heart_disease,
            fmh_diabetes_mellitus,
            null AS fmh_side_diabetes_mellitus,
            fmh_asthma,
            null AS fmh_side_asthma,
            fmh_cancer,
            null AS fmh_side_cancer,
            fmh_kidney_disease,
            null AS fmh_side_kidney_disease,
            fmh_first_degree_relative,
            null AS fmh_side_coronary_disease,
            fmh_having_tuberculosis_5_years,
            null AS fmh_side_tuberculosis,
            fmh_mn_and_s_disorder,
            null AS fm_side_disorders,
            fmh_copd,
            null AS fmh_side_copd,
            rf_tobbaco_use,
            rf_alcohol_intake,
            rf_alcohol_binge_drinker,
            rf_physical_activity,
            rf_nutrition_dietary,
            rf_weight,
            rf_height,
            rf_body_mass,
            rf_waist_circumference,
            rs_systolic_t1,
            rs_diastolic_t1,
            rs_systolic_t2,
            rs_diastolic_t2,
            rs_blood_sugar_fbs,
            rs_blood_sugar_rbs,
            rs_blood_sugar_date_taken,
            rs_blood_sugar_symptoms,
            rs_lipid_cholesterol,
            rs_lipid_hdl,
            rs_lipid_ldl,
            rs_lipid_vldl,
            rs_lipid_triglyceride,
            rs_lipid_date_taken,
            rs_urine_protein,
            rs_urine_protein_date_taken,
            rs_urine_ketones,
            rs_urine_ketones_date_taken,
            rs_chronic_respiratory_disease,
            rs_if_yes_any_symptoms,
            mngm_med_hypertension,
            mngm_med_hypertension_specify,
            mngm_med_diabetes,
            mngm_med_diabetes_options,
            mngm_med_diabetes_specify,
            mngm_date_follow_up,
            mngm_remarks,
            created_at,
            updated_at

        FROM risk_form
    ");

        Schema::dropIfExists('risk_form');

        Schema::create('risk_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('risk_profile_id', 255)->nullable()->default(null);
            $table->string('ar_chestpain', 8)->nullable()->default(null);
            $table->string('ar_diffBreath', 8)->nullable()->default(null);
            $table->string('ar_lossOfConsciousness', 8)->nullable()->default(null);
            $table->string('ar_slurredSpeech', 8)->nullable()->default(null);
            $table->string('ar_facialAsymmetry', 8)->nullable()->default(null);
            $table->string('ar_weaknessNumbness', 8)->nullable()->default(null);
            $table->string('ar_disoriented', 8)->nullable()->default(null);
            $table->string('ar_chestRetraction', 8)->nullable()->default(null);
            $table->string('ar_seizureConvulsion', 8)->nullable()->default(null);
            $table->string('ar_actSelfHarmSuicide', 8)->nullable()->default(null);
            $table->string('ar_agitatedBehavior', 8)->nullable()->default(null);
            $table->string('ar_eyeInjury',8)->nullable()->default(null);
            $table->string('ar_severeInjuries', 8)->nullable()->default(null);
            $table->string('ar_refer_physicianName', 255)->nullable()->default(null);
            $table->string('ar_refer_reason', 255)->nullable()->default(null);
            $table->string('ar_refer_facility', 255)->nullable()->default(null);
            $table->string('pmh_hypertension', 8)->nullable()->default(null);
            $table->string('pmh_heartDisease', 8)->nullable()->default(null);
            $table->string('pmh_diabetes', 8)->nullable()->default(null);
            $table->string('pmh_specify_diabetes', 255)->nullable()->default(null);
            $table->string('pmh_cancer', 8)->nullable()->default(null);
            $table->string('pmh_specify_cancer', 255)->nullable()->default(null);
            $table->string('pmh_copd', 8)->nullable()->default(null);
            $table->string('pmh_asthma', 8)->nullable()->default(null);
            $table->string('pmh_allergies', 8)->nullable()->default(null);
            $table->string('pmh_specify_allergies', 255)->nullable()->default(null);
            $table->string('pmh_MNandSDisorder', 8)->nullable()->default(null);
            $table->string('pmh_specify_MNandSdDisorder', 255)->nullable()->default(null);
            $table->string('pmh_visionProblems', 8)->nullable()->default(null);
            $table->string('pmh_previous_Surgical', 8)->nullable()->default(null);
            $table->string('pmh_specify_previous_Surgical', 255)->nullable()->default(null);
            $table->string('pmh_thyroidDisorders', 8)->nullable()->default(null);
            $table->string('pmh_kidneyDisorders', 8)->nullable()->default(null);
            $table->string('fm_hypertension', 8)->nullable()->default(null);
            $table->string('fm_sideHypertension', 255)->nullable()->default(null);
            $table->string('fm_stroke', 255)->nullable()->default(null);
            $table->string('fm_sideStroke', 255)->nullable()->default(null);
            $table->string('fm_heartDisease', 255)->nullable()->default(null);
            $table->string('fm_sideHeartDisease', 255)->nullable()->default(null);
            $table->string('fm_diabetesMel', 255)->nullable()->default(null);
            $table->string('fmh_sideDiabetesMellitus', 255)->nullable()->default(null);
            $table->string('fmh_asthma', 255)->nullable()->default(null);
            $table->string('fmh_sideAsthma', 255)->nullable()->default(null);
            $table->string('fmh_cancer', 255)->nullable()->default(null);
            $table->string('fmh_sideCancer', 255)->nullable()->default(null);
            $table->string('fmh_kidneyDisease', 255)->nullable()->default(null);
            $table->string('fmh_sideKidneyDisease', 255)->nullable()->default(null);
            $table->string('fmh_firstdegreRelative', 255)->nullable()->default(null);
            $table->string('fmh_sideCoronaryDisease', 255)->nullable()->default(null);
            $table->string('fmh_havingTB5years', 255)->nullable()->default(null);
            $table->string('fmh_sideTuberculosis', 255)->nullable()->default(null);
            $table->string('fmh_MNandSDisorder', 255)->nullable()->default(null);
            $table->string('fm_sideDisorders', 255)->nullable()->default(null);
            $table->string('fmh_COPD', 255)->nullable()->default(null);
            $table->string('fmh_sideCOPD', 255)->nullable()->default(null);
            $table->string('rf_tobbacoUse', 255)->nullable()->default(null);
            $table->string('rf_alcoholIntake', 255)->nullable()->default(null);
            $table->string('rf_alcoholBingeDrinker', 255)->nullable()->default(null);
            $table->string('rf_physicalActivity', 255)->nullable()->default(null);
            $table->string('rf_nutritionDietary', 255)->nullable()->default(null);
            $table->float('rf_weight', 8, 2)->nullable()->default(null);
            $table->float('rf_height', 8, 2)->nullable()->default(null);
            $table->float('rf_bodyMass', 8, 2)->nullable()->default(null);
            $table->float('rf_waistCircum', 8, 2)->nullable()->default(null);
            $table->float('rs_systolic_t1', 8, 2)->nullable()->default(null);
            $table->float('rs_diastolic_t1', 8, 2)->nullable()->default(null);
            $table->float('rs_systolic_t2', 8, 2)->nullable()->default(null);
            $table->float('rs_diastolic_t2', 8, 2)->nullable()->default(null);
            $table->float('rs_bloodSugar_fbs', 8, 2)->nullable()->default(null);
            $table->float('rs_bloodSugar_rbs', 8, 2)->nullable()->default(null);
            $table->date('rs_bloodSugar_date_taken')->nullable()->default(null);
            $table->string('rs_bloodSugar_symptoms', 255)->nullable()->default(null);
            $table->float('rs_lipid_cholesterol', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_hdl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_ldl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_vldl', 8, 2)->nullable()->default(null);
            $table->float('rs_lipid_triglyceride', 8, 2)->nullable()->default(null);
            $table->date('rs_lipid_date_taken')->nullable()->default(null);
            $table->float('rs_urine_protein', 8, 2)->nullable()->default(null);
            $table->date('rs_urine_protein_date_taken')->nullable()->default(null);
            $table->float('rs_urine_ketones', 8, 2)->nullable()->default(null);
            $table->date('rs_urine_ketones_date_taken')->nullable()->default(null);
            $table->string('rs_Chronic_Respiratory_Disease', 255)->nullable()->default(null);
            $table->string('rs_if_yes_any_symptoms', 255)->nullable()->default(null);
            $table->string('mngm_med_hypertension', 255)->nullable()->default(null);
            $table->string('mngm_med_hypertension_specify', 255)->nullable()->default(null);
            $table->string('mngm_med_diabetes', 255)->nullable()->default(null);
            $table->string('mngm_med_diabetes_options', 255)->nullable()->default(null);
            $table->string('mngm_med_diabetes_specify', 255)->nullable()->default(null);
            $table->date('mngm_date_follow_up')->nullable()->default(null);
            $table->text('mngm_remarks')->nullable()->default(null);
            $table->timestamps();
        });

        DB::statement('INSERT INTO risk_form SELECT * FROM risk_form_temp');

        Schema::dropIfExists('risk_form_temp');
    }
}
