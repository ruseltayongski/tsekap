<small class="text-green">REVIEW OF SYSTEMS: (tick all that apply)</small>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="jaundice" name="review_system[]"> Jaundice
        </td>
        <td>
            <input type="checkbox" value="seizures" name="review_system[]"> Seizures
        </td>
        <td>
            <input type="checkbox" value="murmur" name="review_system[]"> Murmur
        </td>
        <td>
            <input type="checkbox" value="polydypsia" name="review_system[]"> Polydypsia
        </td>
        <td>
            <input type="checkbox" value="joint_pain" name="review_system[]"> Joint pain
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="pallor" name="review_system[]"> Pallor
        </td>
        <td>
            <input type="checkbox" value="easy_fatigability" name="review_system[]"> Easy Fatigability
        </td>
        <td>
            <input type="checkbox" value="breast_pain" name="review_system[]"> Breast pain
        </td>
        <td>
            <input type="checkbox" value="polyuria" name="review_system[]"> Polyuria
        </td>
        <td>
            <input type="checkbox" value="muscle_wasting" name="review_system[]"> Muscle wasting
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="rashes" name="review_system[]"> Rashes
        </td>
        <td>
            <input type="checkbox" value="cough" name="review_system[]"> Cough/Colds
        </td>
        <td>
            <input type="checkbox" value="nausea" name="review_system[]"> Nausea and/or vomiting
        </td>
        <td>
            <input type="checkbox" value="vaginal_bleeding" name="review_system[]"> Vaginal bleeding
        </td>
        <td>
            <input type="checkbox" value="mmuscle_weakness" name="review_system[]"> Muscle weakness
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="headache" name="review_system[]"> Severe/Recurrent Headache
        </td>
        <td>
            <input type="checkbox" value="dyspnea" name="review_system[]"> Dyspnea
        </td>
        <td>
            <input type="checkbox" value="abdominal_pain" name="review_system[]"> Severe/Recurrent abdominal pain
        </td>
        <td>
            <input type="checkbox" value="foul_smelling" name="review_system[]"> Foul Smeling Vaginal
        </td>
        <td>
            <input type="checkbox" value="weight_loss" name="review_system[]"> Weight Loss
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="dizziness" name="review_system[]"> Severe/Recurrent Dizziness
        </td>
        <td>
            <input type="checkbox" value="orthnopnea" name="review_system[]"> Orthnopnea
        </td>
        <td>
            <input type="checkbox" value="recurrent_constipation" name="review_system[]"> Recurrent Constipation
        </td>
        <td>
            <input type="checkbox" value="urethral_discharge" name="review_system[]"> Urethral discharge
        </td>
        <td>
            <input type="checkbox" value="others" name="review_system[]"> Others, Specify:
            <input type="text" name="review_system_others">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="blurring_vision" name="review_system[]"> Blurring of vision
        </td>
        <td>
            <input type="checkbox" value="chest_pain" name="review_system[]"> Chest pain
        </td>
        <td>
            <input type="checkbox" value="diarrhea" name="review_system[]"> Diarrhea
        </td>
        <td colspan="2">
            <input type="checkbox" value="dysuria" name="review_system[]"> Dysuria
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="hearing_loss" name="review_system[]"> Hearing loss
        </td>
        <td>
            <input type="checkbox" value="palpitation" name="review_system[]"> Palpitation
        </td>
        <td>
            <input type="checkbox" value="polyphagia" name="review_system[]"> Polyphagia
        </td>
        <td colspan="2">
            <input type="checkbox" value="leg_pain" name="review_system[]"> Leg pain
        </td>
    </tr>
</table>

<label class="text-green">PERTINENT PHYSICAL EXAMINATION</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <small><b>General Status:</b></small><br>
            <input type="checkbox" value="1" name="per_orriented_time" <?php if($profile->per_orriented_time) echo 'checked'; ?>> Oriented to Time, Place, and Date
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_conscious" <?php if($profile->per_conscious) echo 'checked'; ?>> Conscious
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_ambulatory" <?php if($profile->per_ambulatory) echo 'checked'; ?>> Ambulatory
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_others" <?php if($profile->per_others) echo 'checked'; ?>> Others, Specify:
            <input type="text" name="per_others_specify" value="{{ $profile->per_others_specify }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>Vital Signs:</b></small><br>
            <small>BP</small>
            <input type="text" name="per_bp" value="{{ $profile->per_bp }}" class="form-control">
        </td>
        <td>
            <br>
            <small>HR / min</small>
            <input type="text" name="per_hr" value="{{ $profile->per_hr }}" class="form-control">
        </td>
        <td>
            <br>
            <small>RR / min</small>
            <input type="text" name="per_rr" value="{{ $profile->per_rr }}" class="form-control">
        </td>
        <td>
            <br>
            <small>Temp (Degree Celsius)</small>
            <input type="text" name="per_temp" value="{{ $profile->per_temp }}" class="form-control">
        </td>
        <td>
            <br>
            <small>Blood type</small>
            <input type="text" name="per_blood_type" value="{{ $profile->per_blood_type }}" class="form-control">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small>Weight(kg)</small>
            <input type="text" name="per_weight" value="{{ $profile->per_weight }}" class="form-control">
        </td>
        <td>
            <small>Height(m)</small>
            <input type="text" name="per_height" value="{{ $profile->per_height }}" class="form-control">
        </td>
        <td>
            <small>BMI</small>
            <input type="text" name="per_waist" value="{{ $profile->per_waist }}" class="form-control">
        </td>
        <td>
            <small>Waist(cm)</small>
            <input type="text" name="per_waist" value="{{ $profile->per_waist }}" class="form-control">
        </td>
        <td>
            <small>Hip(cm)</small>
            <input type="text" name="per_hip" value="{{ $profile->per_hip }}" class="form-control">
        </td>
        <td>
            <small>W/H Ratio</small>
            <input type="text" name="per_ratio" value="{{ $profile->per_ratio }}" class="form-control">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>SKIN:</b></small><br>
            <input type="checkbox" value="1" name="per_skin_good" <?php if($profile->per_skin_good) echo 'checked'; ?> > Good Skin Turgor
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_skin_pailor" <?php if($profile->per_skin_pailor) echo 'checked'; ?> > Pailor
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_skin_jaundice" <?php if($profile->per_skin_jaundice) echo 'checked'; ?>> Jaundice
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_skin_rashes" <?php if($profile->per_skin_rashes) echo 'checked'; ?>> Rashes
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_skin_lession" <?php if($profile->per_skin_lession) echo 'checked'; ?>> Lesions, Specify:
            <input type="text" name="per_skin_lession_specify" value="{{ $profile->per_lession_specify }}">
        </td>
        <td>
            <br>
            Others
            <input type="text" name="per_skin_others" value="{{ $profile->per_skin_others }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>HEENT:</b></small><br>
            <input type="checkbox" value="no_significant_findings" name="hent[]"> No significant findings
        </td>
        <td>
            <br>
            <input type="checkbox" value="visual_activity" name="hent[]"> Visual Activity
            <input type="text" name="hent_visual">
        </td>
        <td>
            <br>
            <input type="checkbox" value="cleft_lip" name="hent[]"> Cleft lip
        </td>
        <td>
            <br>
            <input type="checkbox" value="enlarged_tonsils" name="hent[]"> Enlarged tonsils
        </td>
        <td>
            <br>
            <input type="checkbox" value="others" name="hent[]"> Others, Specify:
            <input type="text" name="hent_others">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <input type="checkbox" value="yellowish_sclerae" name="hent[]"> Yellowish sclerae
        </td>
        <td>
            <input type="checkbox" value="alr_flaring" name="hent[]"> Alar flaring
        </td>
        <td>
            <input type="checkbox" value="cleft_palate" name="hent[]"> Cleft palate
        </td>
        <td>
            <input type="checkbox" value="enlarged_thyroid" name="hent[]"> Enlarged thyroid
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="pale_conjunctiva" name="hent[]"> Pale conjunctiva
        </td>
        <td>
            <input type="checkbox" value="nasal_discharge" name="hent[]"> Nasal discharge
        </td>
        <td>
            <input type="checkbox" value="ear_discharge" name="hent[]"> Ear discharge
        </td>
        <td>
            <input type="checkbox" value="palpable_mass" name="hent[]"> Palpable mass, Specify site:
            <input type="text" name="hent_palpable">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>CHEST AND LUNGS:</b></small><br>
            <input type="checkbox" value="1" name="chest_no_findings" <?php if($profile->chest_no_findings) echo 'checked'; ?>> No significant findings
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="chest_crackles" <?php if($profile->chest_crackles) echo 'checked'; ?>> Crackles/Rales/Harsh breath sounds
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="chest_breast" <?php if($profile->chest_breast) echo 'checked'; ?>> Breast mass/discharge
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="1" name="chest_retraction" <?php if($profile->chest_retraction) echo 'checked'; ?>> Chest retractions
        </td>
        <td>
            <input type="checkbox" value="1" name="chest_wheezes" <?php if($profile->chest_wheezes) echo 'checked'; ?>> Wheezes
        </td>
        <td>
            <input type="checkbox" value="1" name="chest_others" <?php if($profile->chest_others) echo 'checked'; ?>> Others, specify:
            <input type="text" name="chest_others_specify" value="{{ $profile->chest_others_specify }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>HEART:</b></small><br>
            <input type="checkbox" value="1" name="heart_no_findings" <?php if($profile->heart_no_findings) echo 'checked'; ?>> No Significant findings
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="heart_pulse" <?php if($profile->heart_pulse) echo 'checked'; ?>> Irregular pulse
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="heart_cyanosis" <?php if($profile->heart_cyanosis) echo 'checked'; ?>> Cyanosis (lips,nails)
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="heart_murmur" <?php if($profile->heart_murmur) echo 'checked'; ?>> Murmur, Specify:
            <input type="text" name="heart_murmur_specify" value="{{ $profile->heart_murmur_specify }}">
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="heart_others" <?php if($profile->heart_others) echo 'checked'; ?>> Others, Specify:
            <input type="text" name="heart_others_specify" value="{{ $profile->heart_others_specify }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>ABDOMEN:</b></small><br>
            <input type="checkbox" value="1" name="abd_no_findings" <?php if($profile->abd_no_findings) echo 'checked'; ?>> No Significant findings
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="abd_tenderness" <?php if($profile->abd_tenderness) echo 'checked'; ?>> Tenderness
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="abd_palpable" <?php if($profile->abd_palpable) echo 'checked'; ?>> Palpable mass, specify site:
            <input type="text" name="abd_palpable_specify" value="{{ $profile->abd_palpable_specify }}">
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="abd_others" <?php if($profile->abd_others) echo 'checked'; ?>> Others, Specify:
            <input type="text" name="abd_others_specify" value="{{ $profile->abd_others_specify }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>EXTREMITIES:</b></small><br>
            <input type="checkbox" value="1" name="extre_abnormal" <?php if($profile->extre_abnormal) echo 'checked'; ?>> Abnormal gailt
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="extre_edema" <?php if($profile->extre_edema) echo 'checked'; ?>> Edema
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="extre_joint" <?php if($profile->extre_joint) echo 'checked'; ?>>Joint swelling
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="extre_deformity" <?php if($profile->extre_deformity) echo 'checked'; ?>> Gross deformity, describe
            <input type="text" name="extre_deformity_describe" value="{{ $profile->extre_deformity_describe }}">
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="extre_others" <?php if($profile->extre_others) echo 'checked'; ?>> Others, specify
            <input type="text" name="extre_others_specify" value="{{ $profile->extre_others_specify }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <input type="checkbox" value="enzymes" name="extremities[]"> Enzymes Based Rapid Diagnostic Test for Dengue,Specify result:
            &nbsp;&nbsp;&nbsp;
            <input type="radio" value="igg_positive" name="extremites_result"> IgG Positive
            &nbsp;&nbsp;&nbsp;
            <input type="radio" value="igm_positive" name="extremites_result">IgM Positive
            &nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="ns1_test" name="extremities[]">NS1 Test
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="pcr" name="extremities[]">PCR
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>SUMMARY OF FINDINGS AND ISSUES</b></small>
        </td>
        <td>
            <small><b>REFERRED TO</b></small>
        </td>
        <td>
            <small><b>OTHER ACTION TAKEN</b></small>
        </td>
    </tr>
    <tr>
        <td>
            <textarea name="extremities_summary" class="form-control" cols="30" rows="10"></textarea>
        </td>
        <td>
            <textarea name="extremities_referred" class="form-control" cols="30" rows="10"></textarea>
        </td>
        <td>
            <textarea name="extremities_other" class="form-control" cols="30" rows="10"></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="pull-right">
                <a href="{{ asset('user/population') }}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Save</button>
                <a href="{{ asset('deng/pdf') }}" target="_" type="button" class="btn btn-primary btn">
                    <i class="fa fa-file-pdf-o"></i> Generate PDF
                </a>
            </div>
        </td>
    </tr>
</table>