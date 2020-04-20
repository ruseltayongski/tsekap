<label class="text-green">BRONCHIAL ASTHMA</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="radio" value="diagnosed" name="bro_consultation" <?php if($profile->bro_consultation == 'diagnosed') echo 'checked'; ?>> Diagnosed &nbsp;&nbsp;&nbsp;
            <input type="radio" value="not_diagnosed" name="bro_consultation" <?php if($profile->bro_consultation == 'not_diagnosed') echo 'checked'; ?>> Not Diagnosed
        </td>
        <td>
            <small>No. of attacks per week</small>
            <input type="number" name="bro_no_attack_week" value="{{ $profile->bro_no_attack_week }}">
        </td>
        <td>
            <small>With Medications?</small>
            <input type="radio" name="bro_medication" value="yes" <?php if($profile->bro_medication == 'yes') echo 'checked'; ?>> Yes, specify:
            <input type="text" name="bro_medication_yes" value="{{ $profile->bro_medication_yes }}">
            <input type="radio" name="bro_medication" value="no" <?php if($profile->bro_consultation == 'no') echo 'checked'; ?>> No
        </td>
    </tr>
</table>
<label class="text-green">TUBERCULOSIS</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <small><b>Diagnosed with TB this year?</b></small><br>
            <input type="radio" name="tuberculosis_diagnosed" value="yes"> Yes, form of TB specify:
            <input type="text" name="tuberculosis_diagnosed_yes">
            <input type="radio" name="tuberculosis_diagnosed" value="no"> No
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td colspan="7">
            <small><b>Any of the following? (Tick all that apply)</b></small><br>
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="weight_loss" name="tuberculosis[]"> Weight loss
        </td>
        <td>
            <input type="checkbox" value="fever" name="tuberculosis[]"> Fever
        </td>
        <td>
            <input type="checkbox" value="lost_appetite" name="tuberculosis[]"> Lost of appetite
        </td>
        <td>
            <input type="checkbox" value="cough" name="tuberculosis[]"> Cough > 2 weeks
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="chest_pain" name="tuberculosis[]"> Chest pain
        </td>
        <td>
            <input type="checkbox" value="back_pain" name="tuberculosis[]"> Back pain
        </td>
        <td>
            <input type="checkbox" value="neck_nodes" name="tuberculosis[]"> Neck nodes
        </td>
        <td>
            <input type="checkbox" value="smear_positive" name="tuberculosis[]"> New, smear positive
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="smear_negative" name="tuberculosis[]"> New, smear negative
        </td>
        <td>
            <input type="checkbox" value="relapase" name="tuberculosis[]"> Relapse
        </td>
        <td>
            <input type="checkbox" value="clinically_diagnosed" name="tuberculosis[]"> Clinically diagnosed
        </td>
        <td>
            <input type="checkbox" value="tb_children" name="tuberculosis[]"> TB in children
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <input type="checkbox" value="extrapulmonary" name="tuberculosis[]"> Extrapulmonary, specify:
            <input type="text" name="tuberculosis_extrapulmonary">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <small><b>Labs done:</b></small><br>
            <small>PPD Result</small>
            <input type="text" name="tuberculosis_ppd" class="form-control">
        </td>
        <td>
            <br>
            <small>Sputum Exam Result</small>
            <input type="text" name="tuberculosis_sputum" class="form-control">
        </td>
        <td>
            <br>
            <small>CXR Result</small>
            <input type="text" name="tuberculosis_cxr" class="form-control">
        </td>
        <td>
            <br>
            <small>GenXpert Result</small>
            <input type="text" name="tuberculosis_genxpert" class="form-control">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <small><b>Medications:</b></small><br>
            <input type="checkbox" value="cat1" name="tuberculosis_medication[]"> Cat I
        </td>
        <td>
            <br>
            <input type="checkbox" value="cat2" name="tuberculosis_medication[]"> Cat II
        </td>
        <td>
            <br>
            <input type="checkbox" value="cat3" name="tuberculosis_medication[]"> Cat III
        </td>
        <td>
            <br>
            <input type="checkbox" value="tb_children" name="tuberculosis_medication[]"> TB in children
        </td>
    </tr>
</table>

<label class="text-green">DISABILITY</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="psychological" name="disability[]"> Psychosocial and Behavioral Conditions
        </td>
        <td>
            <input type="checkbox" value="learning" name="disability[]"> Learning or Intellectual Disability
        </td>
        <td>
            <input type="checkbox" value="mental_condition" name="disability[]"> Mental Conditions
        </td>
        <td>
            <input type="checkbox" value="visual" name="disability[]"> Visual or Seeing Impairment
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="hearing" name="disability[]"> Hearing Impairment
        </td>
        <td>
            <input type="checkbox" value="speech_impairment" name="disability[]"> Speech Impairment
        </td>
        <td>
            <input type="checkbox" value="musculo" name="disability[]"> Musculo-Skeletal or Injury Impairments
        </td>
        <td></td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td colspan="2">
            <small>Give description of disability:</small>
            <textarea name="disability_description" cols="30" rows="5" class="form-control"></textarea>
        </td>
    </tr>
    <tr>
        <td>
            <small>With assistive device/s?</small>
            <input type="radio" name="disability_with_assistive" value="yes"> Yes <input type="radio" name="disability_with_assistive" value="no"> Yes, specify:
            <input type="text" name="disability_with_assistive_yes">
        </td>
        <td>
            <small>Need for assistive device/s?</small>
            <input type="radio" name="disability_need_assistive" value="yes"> Yes <input type="radio" name="disability_need_assistive" value="no"> Yes, specify:
            <input type="text" name="disability_need_assistive_yes">
        </td>
    </tr>
</table>
<label class="text-green">INJURY</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="vehicular" name="injury[]"> Vehicular Accident/Traffic-Related Injuries
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" value="burns" name="injury[]"> Burns
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" value="drowning" name="injury[]">  Drowning
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" value="fall" name="injury[]"> Fall
        </td>
    </tr>
    <tr>
        <td>
            <small>Medications(List all current medicines and food supplement being taken):</small>
            <textarea name="injury_medication" cols="30" rows="5" class="form-control"></textarea>
        </td>
    </tr>
</table>

<label class="text-green">HOSPITALIZATION HISTORY</label>
<table class="table table-hover table-striped">
    <tr>
        <td style="width: 20%;">
            <small>Were you previously hospitalized?</small> &nbsp;&nbsp;
            <input type="radio" value="yes" name="hospitalization_prev"> Yes&nbsp;&nbsp; <input type="radio" value="no" name="hospitalization_prev"> No
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td></td>
        <td>Reason/Diagnosis</td>
        <td>Date Hospitalized</td>
        <td>Place Hospitalized</td>
        <td>PhilHealth used? Y/N</td>
        <td>Cost/s not covered by PhilHealth?</td>
    </tr>
    <tr>
        <td><b>1</b></td>
        <td><input type="text" name="hospitalization_reason[]" class="form-control"></td>
        <td><input type="date" name="hospitalization_date[]" class="form-control"></td>
        <td><input type="text" name="hospitalization_place[]" class="form-control"></td>
        <td><input type="text" name="hospitalization_phic[]" class="form-control"></td>
        <td><input type="text" name="hospitalization_cost[]" class="form-control"></td>
    </tr>
    <tbody id="hospital_history_row">

    </tbody>
    <tr>
        <td colspan="7">
            <a href="#" class="pull-right" onclick="addHospitalHistory()"><i class="fa fa-plus"></i> Add row</a>
        </td>
    </tr>
</table>
<label class="text-green">PAST SURGICAL HISTORY</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <small>Operation</small>
            <input type="text" name="past_surgical_operation[]" class="form-control" >
        </td>
        <td>
            <small>Date</small>
            <input type="date" name="past_surgical_date[]" class="form-control" >
        </td>
    </tr>
    <tbody id="past_surgical_row">

    </tbody>
    <tr>
        <td colspan="2">
            <a href="#" class="pull-right" onclick="addPastSurgicalHistory()"><i class="fa fa-plus"></i> Add row</a>
        </td>
    </tr>
</table>