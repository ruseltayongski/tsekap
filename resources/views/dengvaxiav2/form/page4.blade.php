<label class="text-green">REVIEW OF SYSTEMS: (tick all that apply)</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="jaundice" name="rev_tick[]" <?php if(isset($review_system['rev_tick_jaundice'])) echo 'checked'; ?>> Jaundice
        </td>
        <td>
            <input type="checkbox" value="seizures" name="rev_tick[]" <?php if(isset($review_system['rev_tick_seizures'])) echo 'checked'; ?>> Seizures
        </td>
        <td>
            <input type="checkbox" value="murmur" name="rev_tick[]" <?php if(isset($review_system['rev_tick_murmur'])) echo 'checked'; ?>> Murmur
        </td>
        <td>
            <input type="checkbox" value="polydypsia" name="rev_tick[]" <?php if(isset($review_system['rev_tick_polydypsia'])) echo 'checked'; ?>> Polydypsia
        </td>
        <td>
            <input type="checkbox" value="joint" name="rev_tick[]" <?php if(isset($review_system['rev_tick_joint'])) echo 'checked'; ?>> Joint pain
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="pallor" name="rev_tick[]" <?php if(isset($review_system['rev_tick_pallor'])) echo 'checked'; ?>> Pallor
        </td>
        <td>
            <input type="checkbox" value="fatigability" name="rev_tick[]" <?php if(isset($review_system['rev_tick_fatigability'])) echo 'checked'; ?>> Easy Fatigability
        </td>
        <td>
            <input type="checkbox" value="breast" name="rev_tick[]" <?php if(isset($review_system['rev_tick_breast'])) echo 'checked'; ?>> Breast pain
        </td>
        <td>
            <input type="checkbox" value="polyuria" name="rev_tick[]" <?php if(isset($review_system['rev_tick_polyuria'])) echo 'checked'; ?>> Polyuria
        </td>
        <td>
            <input type="checkbox" value="muscle" name="rev_tick[]" <?php if(isset($review_system['rev_tick_muscle'])) echo 'checked'; ?>> Muscle wasting
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="rashes" name="rev_tick[]" <?php if(isset($review_system['rev_tick_rashes'])) echo 'checked'; ?>> Rashes
        </td>
        <td>
            <input type="checkbox" value="cough" name="rev_tick[]" <?php if(isset($review_system['rev_tick_cough'])) echo 'checked'; ?>> Cough/Colds
        </td>
        <td>
            <input type="checkbox" value="nausea" name="rev_tick[]" <?php if(isset($review_system['rev_tick_nausea'])) echo 'checked'; ?>> Nausea and/or vomiting
        </td>
        <td>
            <input type="checkbox" value="vaginal" name="rev_tick[]" <?php if(isset($review_system['rev_tick_vaginal'])) echo 'checked'; ?>> Vaginal bleeding
        </td>
        <td>
            <input type="checkbox" value="mmuscle" name="rev_tick[]" <?php if(isset($review_system['rev_tick_mmuscle'])) echo 'checked'; ?>> Muscle weakness
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="headache" name="rev_tick[]" <?php if(isset($review_system['rev_tick_headache'])) echo 'checked'; ?>> Severe/Recurrent Headache
        </td>
        <td>
            <input type="checkbox" value="dyspnea" name="rev_tick[]" <?php if(isset($review_system['rev_tick_dyspnea'])) echo 'checked'; ?>> Dyspnea
        </td>
        <td>
            <input type="checkbox" value="abdominal" name="rev_tick[]" <?php if(isset($review_system['rev_tick_abdominal'])) echo 'checked'; ?>> Severe/Recurrent abdominal pain
        </td>
        <td>
            <input type="checkbox" value="foul" name="rev_tick[]" <?php if(isset($review_system['rev_tick_foul'])) echo 'checked'; ?>> Foul Smeling Vaginal
        </td>
        <td>
            <input type="checkbox" value="weight" name="rev_tick[]" <?php if(isset($review_system['rev_tick_weight'])) echo 'checked'; ?>> Weight Loss
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="dizziness" name="rev_tick[]" <?php if(isset($review_system['rev_tick_dizziness'])) echo 'checked'; ?>> Severe/Recurrent Dizziness
        </td>
        <td>
            <input type="checkbox" value="orthnopnea" name="rev_tick[]" <?php if(isset($review_system['rev_tick_orthnopnea'])) echo 'checked'; ?>> Orthnopnea
        </td>
        <td>
            <input type="checkbox" value="recurrent" name="rev_tick[]" <?php if(isset($review_system['rev_tick_recurrent'])) echo 'checked'; ?>> Recurrent Constipation
        </td>
        <td>
            <input type="checkbox" value="urethral" name="rev_tick[]" <?php if(isset($review_system['rev_tick_urethral'])) echo 'checked'; ?>> Urethral discharge
        </td>
        <td>
            <input type="checkbox" value="others" name="rev_tick[]" <?php if(isset($review_system['rev_tick_others'])) echo 'checked'; ?>> Others, Specify:
            <input type="text" name="rev_others" value="<?php if(isset($review_system['rev_others'])) echo $review_system['rev_others']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="blurring" name="rev_tick[]" <?php if(isset($review_system['rev_tick_blurring'])) echo 'checked'; ?>> Blurring of vision
        </td>
        <td>
            <input type="checkbox" value="chest" name="rev_tick[]" <?php if(isset($review_system['rev_tick_chest'])) echo 'checked'; ?>> Chest pain
        </td>
        <td>
            <input type="checkbox" value="diarrhea" name="rev_tick[]" <?php if(isset($review_system['rev_tick_diarrhea'])) echo 'checked'; ?>> Diarrhea
        </td>
        <td colspan="2">
            <input type="checkbox" value="dysuria" name="rev_tick[]" <?php if(isset($review_system['rev_tick_dysuria'])) echo 'checked'; ?>> Dysuria
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="hearing" name="rev_tick[]" <?php if(isset($review_system['rev_tick_hearing'])) echo 'checked'; ?>> Hearing loss
        </td>
        <td>
            <input type="checkbox" value="palpitation" name="rev_tick[]" <?php if(isset($review_system['rev_tick_palpitation'])) echo 'checked'; ?>> Palpitation
        </td>
        <td>
            <input type="checkbox" value="polyphagia" name="rev_tick[]" <?php if(isset($review_system['rev_tick_polyphagia'])) echo 'checked'; ?>> Polyphagia
        </td>
        <td colspan="2">
            <input type="checkbox" value="leg" name="rev_tick[]" <?php if(isset($review_system['rev_tick_leg'])) echo 'checked'; ?>> Leg pain
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
            <input type="checkbox" value="1" name="per_skin_good" <?php if(isset($review_system['rev_tick_palpitation'])) echo 'checked'; ?> > Good Skin Turgor
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_skin_pailor" <?php if(isset($review_system['rev_tick_palpitation'])) echo 'checked'; ?> > Pailor
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_skin_jaundice" <?php if(isset($review_system['rev_tick_palpitation'])) echo 'checked'; ?> > Jaundice
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_skin_rashes" <?php if(isset($review_system['rev_tick_palpitation'])) echo 'checked'; ?> > Rashes
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="per_skin_lession" <?php if(isset($review_system['rev_tick_palpitation'])) echo 'checked'; ?> > Lesions, Specify:
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
            <input type="checkbox" value="findings" name="heent_tick[]" <?php if(isset($heent['heent_tick_findings'])) echo 'checked'; ?> > No significant findings
        </td>
        <td>
            <br>
            <input type="checkbox" value="cleft" name="heent_tick[]" <?php if(isset($heent['heent_tick_cleft'])) echo 'checked'; ?> > Cleft lip
        </td>
        <td>
            <br>
            <input type="checkbox" value="enlarged" name="heent_tick[]" <?php if(isset($heent['heent_tick_enlarged'])) echo 'checked'; ?> > Enlarged tonsils
        </td>
        <td>
            <br>
            <input type="checkbox" value="yellowish" name="heent_tick[]" <?php if(isset($heent['heent_tick_yellowish'])) echo 'checked'; ?> > Yellowish sclerae
        </td>
        <td>
            <br>
            <input type="checkbox" value="flaring" name="heent_tick[]" <?php if(isset($heent['heent_tick_flaring'])) echo 'checked'; ?> > Alar flaring
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="nasal" name="heent_tick[]" <?php if(isset($heent['heent_tick_nasal'])) echo 'checked'; ?> > Nasal discharge
        </td>
        <td>
            <input type="checkbox" value="cleft" name="heent_tick[]" <?php if(isset($heent['heent_tick_cleft'])) echo 'checked'; ?> > Cleft palate
        </td>
        <td>
            <input type="checkbox" value="enlarged" name="heent_tick[]" <?php if(isset($heent['heent_tick_enlarged'])) echo 'checked'; ?> > Enlarged thyroid
        </td>
        <td>
            <input type="checkbox" value="pale" name="heent_tick[]" <?php if(isset($heent['heent_tick_pale'])) echo 'checked'; ?> > Pale conjunctiva
        </td>
        <td>
            <input type="checkbox" value="ear" name="heent_tick[]" <?php if(isset($heent['heent_tick_ear'])) echo 'checked'; ?> > Ear discharge
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <input type="checkbox" value="visual" name="heent_tick[]" <?php if(isset($heent['heent_tick_visual'])) echo 'checked'; ?> > Visual Activity
            <input type="text" name="heent_visual" value="<?php if(isset($heent['heent_visual'])) echo $heent['heent_visual']; ?>">
        </td>
        <td>
            <input type="checkbox" value="palpable" name="heent_tick[]" <?php if(isset($heent['heent_tick_palpable'])) echo 'checked'; ?> > Palpable mass, Specify site:
            <input type="text" name="heent_palpable" value="<?php if(isset($heent['heent_palpable'])) echo $heent['heent_palpable']; ?>">
        </td>
        <td>
            <input type="checkbox" value="others" name="heent_tick[]" <?php if(isset($heent['heent_tick_others'])) echo 'checked'; ?> > Others, Specify:
            <input type="text" name="heent_others" value="<?php if(isset($heent['heent_others'])) echo $heent['heent_others']; ?>">
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
            <input type="checkbox" value="1" name="chest_retractions" <?php if($profile->chest_retractions) echo 'checked'; ?>> Chest retractions
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
            <input type="checkbox" value="1" name="extre_join" <?php if($profile->extre_join) echo 'checked'; ?>>Joint swelling
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
            <input type="checkbox" value="1" name="extre_enzymes" <?php if($profile->extre_enzymes) echo 'checked'; ?> > Enzymes Based Rapid Diagnostic Test for Dengue,Specify result:
            &nbsp;&nbsp;&nbsp;
            <input type="radio" value="igg_positive" name="extre_enzymes_specify" <?php if($profile->extre_enzymes_specify == 'igg_positive') echo 'checked'; ?>> IgG Positive
            &nbsp;&nbsp;&nbsp;
            <input type="radio" value="igm_positive" name="extre_enzymes_specify" <?php if($profile->extre_enzymes_specify == 'igm_positive') echo 'checked'; ?>>IgM Positive
            &nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="1" name="extre_ns" <?php if($profile->extre_ns) echo 'checked'; ?> >NS1 Test
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="1" name="extre_pcr" <?php if($profile->extre_pcr) echo 'checked'; ?> >PCR
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
                <button class="btn btn-success" type="submit" onclick="loadLoadingModal();" ><i class="fa fa-save"></i> Save</button>
                <a href="{{ asset('deng/pdf') }}" target="_" type="button" class="btn btn-primary btn">
                    <i class="fa fa-file-pdf-o"></i> Generate PDF
                </a>
            </div>
        </td>
    </tr>
</table>