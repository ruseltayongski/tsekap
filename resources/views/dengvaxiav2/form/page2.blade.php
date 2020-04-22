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
            <input type="radio" name="tb_diagnosed" value="yes" <?php if($profile->tb_diagnosed == 'yes') echo 'checked'; ?>> Yes, form of TB specify:
            <input type="text" name="tb_diagnosed_yes" value="{{ $profile->tb_diagnosed_yes }}">
            <input type="radio" name="tb_diagnosed" value="no" <?php if($profile->tb_diagnosed == 'no') echo 'checked'; ?>> No
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
            <input type="checkbox" value="weight" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_weight'])) echo 'checked'; ?>> Weight loss
        </td>
        <td>
            <input type="checkbox" value="fever" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_fever'])) echo 'checked'; ?>> Fever
        </td>
        <td>
            <input type="checkbox" value="lost" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_lost'])) echo 'checked'; ?>> Lost of appetite
        </td>
        <td>
            <input type="checkbox" value="cough" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_cough'])) echo 'checked'; ?>> Cough > 2 weeks
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="chest" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_chest'])) echo 'checked'; ?>> Chest pain
        </td>
        <td>
            <input type="checkbox" value="back" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_back'])) echo 'checked'; ?>> Back pain
        </td>
        <td>
            <input type="checkbox" value="neck" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_neck'])) echo 'checked'; ?>> Neck nodes
        </td>
        <td>
            <input type="checkbox" value="smearpositive" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_smearpositive'])) echo 'checked'; ?>> New, smear positive
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="smearengative" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_smearengative'])) echo 'checked'; ?>> New, smear negative
        </td>
        <td>
            <input type="checkbox" value="relapase" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_relapase'])) echo 'checked'; ?>> Relapse
        </td>
        <td>
            <input type="checkbox" value="clinically" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_clinically'])) echo 'checked'; ?>> Clinically diagnosed
        </td>
        <td>
            <input type="checkbox" value="children" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_children'])) echo 'checked'; ?>> TB in children
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <input type="checkbox" value="extrapulmonary" name="tb_tick[]" <?php if(isset($tuberculosis_tick['tb_tick_extrapulmonary'])) echo 'checked'; ?>> Extrapulmonary, specify:
            <input type="text" name="tb_tick_specify_extrapulmonary" value="<?php if(isset($tuberculosis_tick['tb_tick_specify_extrapulmonary'])) echo $tuberculosis_tick['tb_tick_specify_extrapulmonary']; ?>">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <small><b>Labs done:</b></small><br>
            <input type="checkbox" value="1" name="tb_ppd" <?php if($profile->tb_ppd) echo 'checked'; ?>>
            <small>PPD Result</small>
            <input type="text" name="tb_result_ppd" class="form-control" value="{{ $profile->tb_result_ppd }}">
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="tb_sputum_exam" <?php if($profile->tb_ppd) echo 'checked'; ?>>
            <small>Sputum Exam Result</small>
            <input type="text" name="tb_result_eputum_exam" class="form-control" value="{{ $profile->tb_result_eputum_exam }}">
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="tb_cxr" <?php if($profile->tb_ppd) echo 'checked'; ?>>
            <small>CXR Result</small>
            <input type="text" name="tb_result_cxr" class="form-control" value="{{ $profile->tb_result_cxr }}">
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="tb_genxpert" <?php if($profile->tb_ppd) echo 'checked'; ?>>
            <small>GenXpert Result</small>
            <input type="text" name="tb_result_genxpert" class="form-control" value="{{ $profile->tb_result_genxpert }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <small><b>Medications:</b></small><br>
            <input type="checkbox" value="1" name="tb_cat1" <?php if($profile->tb_cat1) echo 'checked'; ?>> Cat I
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="tb_cat2" <?php if($profile->tb_cat2) echo 'checked'; ?>> Cat II
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="tb_cat3" <?php if($profile->tb_cat3) echo 'checked'; ?>> Cat III
        </td>
        <td>
            <br>
            <input type="checkbox" value="1" name="tb_cat4" <?php if($profile->tb_cat4) echo 'checked'; ?>> TB in children
        </td>
    </tr>
</table>

<label class="text-green">DISABILITY</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="psychological" name="dis_tick[]" <?php if(isset($disability['dis_tick_psychological'])) echo 'checked'; ?>> Psychosocial and Behavioral Conditions
        </td>
        <td>
            <input type="checkbox" value="learning" name="dis_tick[]" <?php if(isset($disability['dis_tick_learning'])) echo 'checked'; ?>> Learning or Intellectual Disability
        </td>
        <td>
            <input type="checkbox" value="mental" name="dis_tick[]" <?php if(isset($disability['dis_tick_mental'])) echo 'checked'; ?>> Mental Conditions
        </td>
        <td>
            <input type="checkbox" value="visual" name="dis_tick[]" <?php if(isset($disability['dis_tick_visual'])) echo 'checked'; ?>> Visual or Seeing Impairment
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="hearing" name="dis_tick[]" <?php if(isset($disability['dis_tick_hearing'])) echo 'checked'; ?>> Hearing Impairment
        </td>
        <td>
            <input type="checkbox" value="speech" name="dis_tick[]" <?php if(isset($disability['dis_tick_speech'])) echo 'checked'; ?>> Speech Impairment
        </td>
        <td>
            <input type="checkbox" value="musculo" name="dis_tick[]" <?php if(isset($disability['dis_tick_musculo'])) echo 'checked'; ?>> Musculo-Skeletal or Injury Impairments
        </td>
        <td></td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td colspan="2">
            <small>Give description of disability:</small>
            <textarea name="dis_give_description" cols="30" rows="5" class="form-control">{{ $profile->dis_give_description }}</textarea>
        </td>
    </tr>
    <tr>
        <td>
            <small>With assistive device/s?</small>
            <input type="radio" name="dis_with_assistive" value="yes" <?php if($profile->dis_with_assistive == 'yes') echo 'checked'; ?>> No <input type="radio" name="dis_with_assistive" value="no" <?php if($profile->dis_with_assistive == 'no') echo 'checked'; ?>> Yes, specify:
            <input type="text" name="dis_with_assistive_yes" value="{{ $profile->dis_with_assistive_yes }}">
        </td>
        <td>
            <small>Need for assistive device/s?</small>
            <input type="radio" name="dis_need_assistive" value="yes" <?php if($profile->dis_need_assistive == 'yes') echo 'checked'; ?>> No <input type="radio" name="dis_need_assistive" value="no" <?php if($profile->dis_need_assistive == 'no') echo 'checked'; ?>> Yes, specify:
            <input type="text" name="dis_need_assistive_yes" value="{{ $profile->dis_need_assistive_yes }}">
        </td>
    </tr>
</table>
<label class="text-green">INJURY</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="1" name="inj_vehicular" <?php if($profile->inj_vehicular) echo 'checked'; ?>> Vehicular Accident/Traffic-Related Injuries
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" value="1" name="inj_burns" <?php if($profile->inj_burns) echo 'checked'; ?>> Burns
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" value="1" name="inj_drowning" <?php if($profile->inj_drowning) echo 'checked'; ?>>  Drowning
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" value="1" name="inj_fall" <?php if($profile->inj_fall) echo 'checked'; ?>> Fall
        </td>
    </tr>
    <tr>
        <td>
            <small>Medications(List all current medicines and food supplement being taken):</small>
            <textarea name="inj_medications" cols="30" rows="5" class="form-control">{{ $profile->inj_medications }}</textarea>
        </td>
    </tr>
</table>

<label class="text-green">HOSPITALIZATION HISTORY</label>
<table class="table table-hover table-striped">
    <tr>
        <td style="width: 20%;">
            <small>Were you previously hospitalized?</small> &nbsp;&nbsp;
            <input type="radio" value="yes" name="hos_hospitalized" <?php if($profile->hos_hospitalized == 'yes') echo 'checked'; ?>> Yes&nbsp;&nbsp; <input type="radio" value="no" name="hospitalization_prev" <?php if($profile->hos_hospitalized == 'no') echo 'checked'; ?>> No
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
        <td></td>
    </tr>
    @if(count($hospitalization_history) >= 1)
        <?php $host_count = Session::get('host_count'); ?>
        @foreach($hospitalization_history as $row)
            <tr>
                <td><b>{{ $host_count }}</b></td>
                <td><input type="text" name="hos_reason[]" class="form-control" value="{{ $row->hos_reason }}"></td>
                <td><input type="date" name="hos_date[]" class="form-control" value="{{ $row->hos_date }}"></td>
                <td><input type="text" name="hos_place[]" class="form-control" value="{{ $row->hos_place }}"></td>
                <td><input type="text" name="hos_phic[]" class="form-control" value="{{ $row->hos_phic }}"></td>
                <td><input type="text" name="hos_cost[]" class="form-control" value="{{ $row->hos_cost }}"></td>
                <td><i class='fa fa-trash-o text-red hos_row' style='cursor: pointer;' onclick='removeHospitalHistory($(this))'></i></td>
            </tr>
            <?php $host_count++; ?>
        @endforeach
        <?php Session::put('host_count',$host_count); ?>
    @else
        <tr>
            <td><b>{{ $host_count }}</b></td>
            <td><input type="text" name="hos_reason[]" class="form-control"></td>
            <td><input type="date" name="hos_date[]" class="form-control"></td>
            <td><input type="text" name="hos_place[]" class="form-control"></td>
            <td><input type="text" name="hos_phic[]" class="form-control"></td>
            <td><input type="text" name="hos_cost[]" class="form-control"></td>
            <td><i class='fa fa-trash-o text-red hos_row' style='cursor: pointer;' onclick='removeHospitalHistory($(this))'></i></td>
        </tr>
    @endif
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
            <input type="text" name="sur_operation[]" class="form-control" >
        </td>
        <td>
            <small>Date</small>
            <input type="date" name="sur_date[]" class="form-control" >
        </td>
        <td width="2%">
            <br>
            <i class='fa fa-trash-o text-red' style='cursor: pointer;' onclick='removePastSurgicalHistory($(this))'></i>
        </td>
    </tr>
    <tbody id="past_surgical_row">

    </tbody>
    <tr>
        <td colspan="3">
            <a href="#" class="pull-right" onclick="addPastSurgicalHistory()"><i class="fa fa-plus"></i> Add row</a>
        </td>
    </tr>
</table>