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
        Schema::table('risk_form', function (Blueprint $table) {
            
            // # ----------- AR Columns ---------------- #
            // ar_chest_pain
            if (Schema::hasColumn('risk_form', 'ar_chestpain')) {
                $table->renameColumn('ar_chestpain', 'ar_chest_pain');
            }

            // ar_difficulty_breathing
            if (Schema::hasColumn('risk_form', 'ar_diffBreath')) {
                $table->renameColumn('ar_diffBreath', 'ar_difficulty_breathing');
            }
            
            // ar_loss_of_consciousness
            if (Schema::hasColumn('risk_form', 'ar_lossOfConsciousness')) {
                $table->renameColumn('ar_lossOfConsciousness', 'ar_loss_of_consciousness');
            }

            // ar_slurred_speech
            if (Schema::hasColumn('risk_form', 'ar_slurredSpeech')) {
                $table->renameColumn('ar_slurredSpeech', 'ar_slurred_speech');
            }

            // ar_facial_asymmetry
            if (Schema::hasColumn('risk_form', 'ar_facialAsymmetry')) {
                $table->renameColumn('ar_facial_asmmetry', 'ar_facial_asymmetry');
            }

            // ar_weakness_numbness
            if (Schema::hasColumn('risk_form', 'ar_weaknessNumbness')) {
                $table->renameColumn('ar_weaknessNumbness', 'ar_weakness_numbness');
            }

            // ar_disoriented
            if (Schema::hasColumn('risk_form', 'ar_disoriented')) {
                $table->renameColumn('ar_disoriented', 'ar_disoriented');
            }

            // ar_chest_retractions
            if (Schema::hasColumn('risk_form', 'ar_chestRetraction')) {
                $table->renameColumn('ar_chest_retractions', 'ar_chest_retractions');
            }

            // ar_seizure_convulsion
            if (Schema::hasColumn('risk_form', 'ar_seizureConvulsion')) {
                $table->renameColumn('ar_seizureConvulsion', 'ar_seizure_convulsion');
            }

            // ar_act_self_harm_suicide
            if (Schema::hasColumn('risk_form', 'ar_actSeflHarmSuicide')) {
                $table->renameColumn('ar_actSelfHarmSuicide', 'ar_act_self_harm_suicide');
            }

            // ar_agitated_behavior 
            if (Schema::hasColumn('risk_form', 'ar_agitatedBehaivior')) {
                $table->renameColumn('ar_agitatedBehaivior', 'ar_agitated_behavior');
            }
            
            // ar_eye_injury 
            if (Schema::hasColumn('risk_form', 'ar_eyeInjury')) {
                $table->renameColumn('ar_eyeInjury','ar_eye_injury');
            }

            // ar_severe_injuries 
            if (Schema::hasColumn('risk_form', 'ar_severeInjuries')) {
                $table->renameColumn('ar_severeInjuries', 'ar_severe_injuries');
            }

            // ar_refer_physician_name
            if (Schema::hasColumn('risk_form', 'ar_refer_physicianName')) {
                $table->renameColumn('ar_refer_physicianName', 'ar_refer_physician_name');
            }

            // ar_refer_reason
            if (Schema::hasColumn('risk_form', 'ar_refer_reason')) {
                $table->renameColumn('ar_refer_reason', 'ar_refer_reason');
            }

            // ar_refer_facility
            if (Schema::hasColumn('risk_form', 'ar_refer_facility')) {
                $table->renameColumn('ar_refer_facility', 'ar_refer_facility');
            }
            // # ----------- End AR Columns ---------------- #

            // # ----------- PMH Columns ---------------- #
            // pmh_hypertension
            if (Schema::hasColumn('risk_form', 'pmh_hypertension')) {
                $table->renameColumn('pmh_hypertension', 'pmh_hypertension');
            }

            // pmh_heart_disease
            if (Schema::hasColumn('risk_form', 'pmh_heartDisease')) {
                $table->renameColumn('pmh_heartDisease', 'pmh_heart_disease');
            }           

            // pmh_diabetes 
            if (Schema::hasColumn('risk_form', 'pmh_diabetes')) {
                $table->renameColumn('pmh_diabetes', 'pmh_diabetes');
            }

            // pmh_specify_diabetes 
            if (Schema::hasColumn('risk_form', 'pmh_specifyDiabetes')) {
                $table->renameColumn('pmh_specifyDiabetes', 'pmh_specify_diabetes');
            }

            // pmh_cancer 
            if (Schema::hasColumn('risk_form', 'pmh_cancer')) {
                $table->renameColumn('pmh_cancer', 'pmh_cancer');
            }

            // pmh_specify_cancer 
            if (Schema::hasColumn('risk_form', 'pmh_specify_cancer')) {
                $table->renameColumn('pmh_specify_cancer', 'pmh_specify_cancer');
            }           

            // pmh_copd 
            if (Schema::hasColumn('risk_form', 'pmh_COPD')) {
                $table->renameColumn('pmh_COPD', 'pmh_copd');
            }

            // pmh_asthma 
            if (Schema::hasColumn('risk_form', 'pmh_asthma')) {
                $table->renameColumn('pmh_asthma', 'pmh_asthma');
            }           

            // pmh_allergies
            if (Schema::hasColumn('risk_form', 'pmh_allergies')) {
                $table->renameColumn('pmh_allergies', 'pmh_allergies');
            }

            // pmh_specify_allergies 
            if (Schema::hasColumn('risk_form', 'pmh_specify_allergies')) {
                $table->renameColumn('pmh_specify_allergies', 'pmh_specify_allergies');
            }           
            
            // pmh_mn_and_s_disorder 
            if (Schema::hasColumn('risk_form', 'pmh_MNandSDisorder')) {
                $table->renameColumn('pmh_MNandSDisorder', 'pmh_mn_and_s_disorder');
            }

            // pmh_specify_mn_and_s_disorder 
            if (Schema::hasColumn('risk_form', 'pmh_specify_MNandSDisorder')) {
                $table->renameColumn('pmh_specify_MNandSDisorder', 'pmh_specify_mn_and_s_disorder');
            }           

            //  pmh_vision_problems
            if (Schema::hasColumn('risk_form', 'pmh_visionProblems')) {
                $table->renameColumn('pmh_visionProblems', 'pmh_vision_problems');
            }

            // pmh_previous_surgical
            if (Schema::hasColumn('risk_form', 'pmh_previous_Surgical')) {
                $table->renameColumn('pmh_previous_Surgical', 'pmh_previous_surgical');
            }           

            // pmh_specify_previous_surgical 
            if (Schema::hasColumn('risk_form', 'pmh_specify_previous_Surgical')) {
                $table->renameColumn('pmh_specify_previous_Surgical', 'pmh_specify_previous_surgical');
            }

            // pmh_thyroid_disorders 
            if (Schema::hasColumn('risk_form', 'pmh_thyroidDisorders')) {
                $table->renameColumn('pmh_thyroidDisorders', 'pmh_thyroid_disorders');
            }           

            // pmh_kidney_disorders 
            if (Schema::hasColumn('risk_form', 'pmh_kidneyDisorders')) {
                $table->renameColumn('pmh_kidneyDisorders', 'pmh_kidney_disorders');
            }
            # ----------- End PMH Columns ---------------- #

            // # ----------- FMH Columns ---------------- #
            // fmh_hypertension
            if (Schema::hasColumn('risk_form', 'fm_hypertension')) {
                $table->renameColumn('fm_hypertension', 'fmh_hypertension');
            }           

            //  fmh_side_hypertension
            if (Schema::hasColumn('risk_form', 'fm_sideHypertension')) {
                $table->renameColumn('fm_sideHypertension', 'fm_side_hypertension');
            }

            // fmh_stroke 
            if (Schema::hasColumn('risk_form', 'fm_stroke')) {
                $table->renameColumn('fm_stroke', 'fmh_stroke');
            }           

            // fmh_side_stroke 
            if (Schema::hasColumn('risk_form', 'fm_sideStroke')) {
                $table->renameColumn('fm_sideStroke', 'fmh_side_stroke');
            }

            // fmh_heart_disease 
            if (Schema::hasColumn('risk_form', 'fm_heartDisease')) {
                $table->renameColumn('fm_heartDisease', 'fmh_heart_disease');
            }           

            // fmh_side_heart_disease 
            if (Schema::hasColumn('risk_form', 'fm_sideHeartDisease')) {
                $table->renameColumn('fm_sideHeartDisease', 'fmh_side_heart_disease');
            }           

            // fmh_diabetes_mellitus
            if (Schema::hasColumn('risk_form', 'fm_diabetesMel')) {
                $table->renameColumn('fm_diabetesMel', 'fmh_diabetes_mellitus');
            }

            // fmh_side_diabetes_mellitus 
            if (Schema::hasColumn('risk_form', 'fm_sideDiabetesMellitus')) {
                $table->renameColumn('fm_sideDiabetesMellitus', 'fmh_side_diabetes_mellitus');
            }           

            // fmh_asthma
            if (Schema::hasColumn('risk_form', 'fm_asthma')) {
                $table->renameColumn('fm_asthma', 'fmh_asthma');
            }

            // fmh_side_asthma 
            if (Schema::hasColumn('risk_form', 'fm_sideAsthma')) {
                $table->renameColumn('fm_sideAsthma', 'fmh_side_asthma');
            }
            
            // fmh_cancer
            if (Schema::hasColumn('risk_form', 'fm_cancer')) {
                $table->renameColumn('fm_cancer', 'fmh_cancer');
            }

            // fmh_side_cancer
            if (Schema::hasColumn('risk_form', 'fm_sideCancer')) {
                $table->renameColumn('fm_sideCancer', 'fmh_side_cancer');
            } 

            // fmh_kidney_disease 
            if (Schema::hasColumn('risk_form', 'fm_kidneyDisease')) {
                $table->renameColumn('fm_kidneyDisease', 'fmh_kidney_disease');
            }

            // fmh_side_kidney_disease 
            if (Schema::hasColumn('risk_form', 'fm_sideKidneyDisease')) {
                $table->renameColumn('fm_sideKidneyDisease', 'fmh_side_kidney_disease');
            }
            
            // fmh_first_degree_relative 
            if (Schema::hasColumn('risk_form', 'fm_firstDegreRelative')) {
                $table->renameColumn('fm_firstDegreRelative', 'fmh_first_degree_relative');
            }

            // fmh_side_coronary_disease 
            if (Schema::hasColumn('risk_form', 'fm_sideCoronaryDisease')) {
                $table->renameColumn('fm_sideCoronaryDisease', 'fmh_side_coronary_disease');
            }           

            // fmh_having_tuberculosis_5_years
            if (Schema::hasColumn('risk_form', 'fm_havingTB5Years')) {
                $table->renameColumn('fm_havingTB5Years', 'fmh_having_tuberculosis_5_years');
            } 

            // fmh_side_tuberculosis 
            if (Schema::hasColumn('risk_form', 'fm_sideTuberculosis')) {
                $table->renameColumn('fm_sideTuberculosis', 'fmh_side_tuberculosis');
            }

            // fmh_mn_and_s_disorder 
            if (Schema::hasColumn('risk_form', 'fm_MNandSDisorder')) {
                $table->renameColumn('fm_MNandSDisorder', 'fmh_mn_and_s_disorder');
            }
            
            // fmh_side_disorder 
            if (Schema::hasColumn('risk_form', 'fm_sideDisorder')) {
                $table->renameColumn('fm_sideDisorder', 'fmh_side_disorder');
            }

            // fmh_copd
            if (Schema::hasColumn('risk_form', 'fm_COPD')) {
                $table->renameColumn('fm_COPD', 'fmh_copd');
            }           

            // fmh_side_copd 
            if (Schema::hasColumn('risk_form', 'fm_sideCOPD')) {
                $table->renameColumn('fm_sideCOPD', 'fmh_side_copd');
            }
            // # ----------- End FMH Columns ---------------- #

            # ----------- RF Columns ---------------- #
            // rf_tobacco_use 
            if (Schema::hasColumn('risk_form', 'rf_tobaccoUse')) {
                $table->renameColumn('rf_tobaccoUse', 'rf_tobacco_use');
            }            

            // rf_alcohol_intake 
            if (Schema::hasColumn('risk_form', 'rf_alcoholIntake')) {
                $table->renameColumn('rf_alcoholIntake', 'rf_alcohol_intake');
            }

            // rf_alcohol_binge_drinker 
            if (Schema::hasColumn('risk_form', 'rf_alcoholBingeDrinker')) {
                $table->renameColumn('rf_alcoholBingeDrinker', 'rf_alcohol_binge_drinker');
            }           

            // rf_physical_activity 
            if (Schema::hasColumn('risk_form', 'rf_physicalActivity')) {
                $table->renameColumn('rf_physicalActivity', 'rf_physical_activity');
            }           

            // rf_nutrition_dietary 
            if (Schema::hasColumn('risk_form', 'rf_nutritionDietary')) {
                $table->renameColumn('rf_nutritionDietary', 'rf_nutrition_dietary');
            }   
            
            // rf_weight 
            if (Schema::hasColumn('risk_form', 'rf_weight')) {
                $table->renameColumn('rf_weight', 'rf_weight');
            }            

            // rf_height 
            if (Schema::hasColumn('risk_form', 'rf_height')) {
                $table->renameColumn('rf_height', 'rf_height');
            }

            // rf_body_mass 
            if (Schema::hasColumn('risk_form', 'rf_bodyMass')) {
                $table->renameColumn('rf_body_mass', 'rf_body_mass');
            }           

            // rf_waist_circumference 
            if (Schema::hasColumn('risk_form', 'rf_waistCircum')) {
                $table->renameColumn('rf_waistCircum', 'rf_waist_circumference');
            }           
            // # ----------- End RF Columns ---------------- #
            
            // # ----------- RS Columns ---------------- #
            // rs_systolic_t1 
            if (Schema::hasColumn('risk_form', 'rs_systolic_t1')) {
                $table->renameColumn('rs_systolic_t1', 'rs_systolic_t1');
            }   
           
            // rs_diastolic_t1 
            if (Schema::hasColumn('risk_form', 'rs_diastolic_t1')) {
                $table->renameColumn('rs_diastolic_t1', 'rs_diastolic_t1');
            }           

            // rs_systolic_t2 
            if (Schema::hasColumn('risk_form', 'rs_systolic_t2')) {
                $table->renameColumn('rs_systolic_t2', 'rs_systolic_t2');
            }   
            
            // rs_diastolic_t2 
            if (Schema::hasColumn('risk_form', 'rs_diastolic_t2')) {
                $table->renameColumn('rs_diastolic_t2', 'rs_diastolic_t2');
            }            

            // rs_blood_sugar_fbs 
            if (Schema::hasColumn('risk_form', 'rs_bloodSugar_fbs')) {
                $table->renameColumn('rs_bloodSugar_fbs', 'rs_blood_sugar_fbs');
            }

            // rs_blood_sugar_rbs 
            if (Schema::hasColumn('risk_form', 'rs_bloodSugar_rbs')) {
                $table->renameColumn('rs_bloodSugar_rbs', 'rs_blood_sugar_rbs');
            }           

            // rs_blood_sugar_date_taken 
            if (Schema::hasColumn('risk_form', 'rs_bloodSugar_date_taken')) {
                $table->renameColumn('rs_bloodSugar_date_taken', 'rs_blood_sugar_date_taken');
            }           

            // rs_blood_sugar_symptoms 
            if (Schema::hasColumn('risk_form', 'rs_bloodSugar_symptoms')) {
                $table->renameColumn('rs_bloodSugar_symptoms', 'rs_blood_sugar_symptoms');
            }   
            
            // rs_lipid_cholesterol 
            if (Schema::hasColumn('risk_form', 'rs_lipid_cholesterol')) {
                $table->renameColumn('rs_lipid_cholesterol', 'rs_lipid_cholesterol');
            }   
            
            // rs_lipid_hdl 
            if (Schema::hasColumn('risk_form', 'rs_lipid_hdl')) {
                $table->renameColumn('rs_lipid_hdl', 'rs_lipid_hdl');
            }            

            // rs_lipid_ldl 
            if (Schema::hasColumn('risk_form', 'rs_lipid_ldl')) {
                $table->renameColumn('rs_lipid_ldl', 'rs_lipid_ldl');
            }

            // rs_lipid_vldl 
            if (Schema::hasColumn('risk_form', 'rs_lipid_vldl')) {
                $table->renameColumn('rs_lipid_vldl', 'rs_lipid_vldl');
            }           

            // rs_lipid_triglyceride 
            if (Schema::hasColumn('risk_form', 'rs_lipid_triglyceride')) {
                $table->renameColumn('rs_lipid_triglyceride', 'rs_lipid_triglyceride');
            }           

            // rs_lipid_date_taken
            if (Schema::hasColumn('risk_form', 'rs_lipid_date_taken')) {
                $table->renameColumn('rs_lipid_date_taken', 'rs_lipid_date_taken');
            }
            
            // rs_urine_protein 
            if (Schema::hasColumn('risk_form', 'rs_urine_protein')){
                $table->renameColumn('rs_urine_protein', 'rs_urine_protein');
            }   
            
            // rs_urine_protein_date_taken 
            if (Schema::hasColumn('risk_form', 'rs_urine_protein_date_taken')) {
                $table->renameColumn('rs_urine_protein_date_taken', 'rs_urine_protein_date_taken');
            }   
            
            // rs_urine_ketones 
            if (Schema::hasColumn('risk_form', 'rs_urine_ketones')) {
                $table->renameColumn('rs_urine_ketones', 'rs_urine_ketones');
            }            

            // rs_urine_ketones_date_taken 
            if (Schema::hasColumn('risk_form', 'rs_urine_ketones_date_taken')) {
                $table->renameColumn('rs_urine_ketones_date_taken', 'rs_urine_ketones_date_taken');
            }

            // rs_chronic_respiratory_disease 
            if (Schema::hasColumn('risk_form', 'rs_Chronic_Respiratory_Disease')) {
                $table->renameColumn('rs_Chronic_Respiratory_Disease', 'rs_chronic_respiratory_disease');
            }           

            // rs_if_yes_any_symptoms
            if (Schema::hasColumn('risk_form', 'rs_if_yes_any_symptoms')) {
                $table->renameColumn('rs_if_yes_any_symptoms', 'rs_if_yes_any_symptoms');
            }           
            
            // # ----------- End RS Columns ---------------- #            

            // # ----------- MNGM Columns ---------------- #
            // mngm_med_hypertension 
            if (Schema::hasColumn('risk_form', 'mngm_med_hypertension')) {
                $table->renameColumn('mngm_med_hypertension', 'mngm_med_hypertension');
            }
            
            // mngm_med_hypertension_specify 
            if (Schema::hasColumn('risk_form', 'mngm_med_hypertension_specify')) {
                $table->renameColumn('mngm_med_hypertension_specify', 'mnmg_med_hypertension_specify');
            }
           
            // mngm_med_diabetes 
            if (Schema::hasColumn('risk_form', 'mngm_med_diabetes')) {
                $table->renameColumn('mngm_med_diabetes', 'mngm_med_diabetes');
            } 
            
            // mngm_med_diabetes_options 
            if (Schema::hasColumn('risk_form', 'mngm_med_diabetes_options')) {
                $table->renameColumn('mngm_med_diabetes_options', 'mnmg_med_diabetes_options');
            }           

            // mnmg_med_diabetes_specify 
            if (Schema::hasColumn('risk_form', 'mngm_med_diabetes_specify')) {
                $table->renameColumn('mngm_med_diabetes_specify', 'mnmg_med_diabetes_specify');
            } 
          
            // mngm_date_follow_up 
            if (Schema::hasColumn('risk_form', 'mngm_date_follow_up')) {
                $table->renameColumn('mngm_date_follow_up', 'mngm_date_follow_up');
            }
           
            // mngm_remarks
            if (Schema::hasColumn('risk_form', 'mngm_remarks')) {
                $table->renameColumn('mngm_remarks', 'mngm_remarks');
            } 
           
            // # ----------- End MNGM Columns ---------------- #
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            //
        });
    }
}
