<div class="page_break"></div>
<table class="table1" border="0">
    <tr>
        <td>
            <b>BRONCHIAL ASTHMA</b>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="32px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px"> <!-- BRONCHIAL row 1 -->
    <tr>
        <td width="0.2%"></td>
        <td width="29%"><?php if($profile->bro_consultation == 'diagnosed') echo '<span>&#10004;</span>'; ?></td>
        <td width="33%"><?php echo $profile->bro_no_attack_week ?></td>
        <td width="9%"><?php if($profile->bro_medication == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php echo $profile->bro_medication_yes; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td width="15%">Diagnosed</td>
        <td width="30%">No. of attacks per week:</td>
        <td width="15%">With medications?</td>
        <td width="2%"><div class="box"></div></td>
        <td>Yes, specify: _______________________________________</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px"> <!-- BRONCHIAL row 2 -->
    <tr>
        <td width="0.2%"></td>
        <td width="62%"><?php if($profile->bro_consultation == 'not_diagnosed') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if($profile->bro_medication == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td width="60%">No Diagnosed</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="0">
    <tr>
        <td>
            <b>TUBERCULOSIS</b>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="130px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px"> <!-- TUBERCULOSIS row 1 -->
    <tr>
        <td width="16.3%"></td>
        <td width="19%"><?php if(isset($tuberculosis_tick['tb_tick_weight'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="27%"><?php if(isset($tuberculosis_tick['tb_tick_chest'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="16.5%"><?php if($profile->tb_ppd) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php echo $profile->tb_result_ppd; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 13px"> <!-- TUBERCULOSIS row 2 -->
    <tr>
        <td width="16.3%"></td>
        <td width="19%"><?php if(isset($tuberculosis_tick['tb_tick_fever'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="27%"><?php if(isset($tuberculosis_tick['tb_tick_back'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="16.5%"><?php if($profile->tb_sputum_exam) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php echo $profile->tb_result_eputum_exam; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 33px"> <!-- TUBERCULOSIS row 3 -->
    <tr>
        <td width="16.3%"></td>
        <td width="19%"><?php if(isset($tuberculosis_tick['tb_tick_lost'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="27%"><?php if(isset($tuberculosis_tick['tb_tick_neck'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="16.5%"><?php if($profile->tb_cxr) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php echo $profile->tb_result_cxr; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 53px"> <!-- TUBERCULOSIS row 4 -->
    <tr>
        <td width="16.3%"></td>
        <td width="46%"><?php if(isset($tuberculosis_tick['tb_tick_cough'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="16.5%"><?php if($profile->tb_genxpert) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php echo $profile->tb_result_genxpert; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 71px"> <!-- TUBERCULOSIS row 5 -->
    <tr>
        <td width="19.8%"></td>
        <td width="7%"><?php if($profile->tb_diagnosed == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td width="8.6%"><?php if($profile->tb_diagnosed == 'no') echo '<span>&#10004;</span>'; ?></td>
        <td width="20%"><?php if(isset($tuberculosis_tick['tb_tick_smearpositive'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="14.5%"><?php if(isset($tuberculosis_tick['tb_tick_extrapulmonary'])) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if(isset($tuberculosis_tick['tb_tick_specify_extrapulmonary'])) echo $tuberculosis_tick['tb_tick_specify_extrapulmonary']; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 90px"> <!-- TUBERCULOSIS row 6 -->
    <tr>
        <td width="11%"></td>
        <td width="24.4%"><?php echo $profile->tb_diagnosed_yes; ?></td>
        <td width="20%"><?php if(isset($tuberculosis_tick['tb_tick_smearengative'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="27%"><?php if(isset($tuberculosis_tick['tb_tick_clinically'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="7%"><?php if($profile->tb_cat1) echo '<span>&#10004;</span>'; ?></td>
        <td><?php if($profile->tb_cat2) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 109px"> <!-- TUBERCULOSIS row 7 -->
    <tr>
        <td width="35.4%"></td>
        <td width="20%"><?php if(isset($tuberculosis_tick['tb_tick_relapase'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="27%"><?php if(isset($tuberculosis_tick['tb_tick_children'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="7%"><?php if($profile->tb_cat3) echo '<span>&#10004;</span>'; ?></td>
        <td><?php if($profile->tb_cat4) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="16%">&nbsp;&nbsp;Any of the following?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="17%">Weight Loss</td>
        <td width="2%"><div class="box"></div></td>
        <td width="18%">Chest Pain</td>
        <td width="7%">Labs Done:</td>
        <td width="2%"><div class="box"></div></td>
        <td>PPD</td>
        <td>Result: ________________________________</td>
    </tr>
    <tr>
        <td ><i>&nbsp;&nbsp;(Tick all that apply.)</i></td>
        <td ><div class="box"></div></td>
        <td >Fever</td>
        <td ><div class="box"></div></td>
        <td >Back Pain</td>
        <td ></td>
        <td ><div class="box"></div></td>
        <td>Sputum Exam</td>
        <td>Result: ________________________________</td>
    </tr>
    <tr>
        <td ></td>
        <td ><div class="box"></div></td>
        <td >Loss of appetite</td>
        <td ><div class="box"></div></td>
        <td >Neck nodes</td>
        <td ></td>
        <td ><div class="box"></div></td>
        <td>CXR</td>
        <td>Result: ________________________________</td>
    </tr>
    <tr>
        <td ></td>
        <td ><div class="box"></div></td>
        <td >Cough > 2 weeks</td>
        <td ></td>
        <td ></td>
        <td ></td>
        <td ><div class="box"></div></td>
        <td>GenXpert</td>
        <td>Result: ________________________________</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td>&nbsp;&nbsp;Diagnosed with TB this year?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Yes</td>
        <td width="2%"><div class="box"></div></td>
        <td width="6.5%">No</td>
        <td width="2%"><div class="box"></div></td>
        <td>New, smear positive</td>
        <td width="2%"><div class="box"></div></td>
        <td>Extrapulmonary, specify:</td>
        <td>Medications:</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="35.1%"><div style="margin-left: 3%;">If Yes, form of TB: ________________________________</div></td>
        <td width="2%"><div class="box"></div></td>
        <td width="18%">New, smear negative</td>
        <td width="2%"><div class="box"></div></td>
        <td width="25%">Clinically diagnosed</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Cat I</td>
        <td width="2%"><div class="box"></div></td>
        <td>Cat II</td>
    </tr>
    <tr>
        <td ></td>
        <td width="2%"><div class="box"></div></td>
        <td width="18%">Relapse</td>
        <td width="2%"><div class="box"></div></td>
        <td width="25%">TB in Children</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Cat III</td>
        <td width="2%"><div class="box"></div></td>
        <td>TB in children</td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;margin-top: 5px">
    <tr>
        <td height="153px"></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0" style="margin-top: 5px">
    <tr>
        <td>&nbsp;&nbsp;<b>Disability</b></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px"> <!-- DISABILITY ROW 1 -->
    <tr>
        <td width="0.3%"></td>
        <td ><?php if(isset($disability['dis_tick_psychological'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0" style="position:absolute;"> <!-- DISABILITY ROW 1 give description -->
    <tr>
        <td width="55%"></td>
        <td>@if(isset($profile->dis_give_description)){!! "<b style='font-size:8pt;'><u>".$profile->dis_give_description."</u></b>" !!}@endif</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 14px"> <!-- DISABILITY ROW 2 -->
    <tr>
        <td width="0.3%"></td>
        <td ><?php if(isset($disability['dis_tick_learning'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 34px"> <!-- DISABILITY ROW 3 -->
    <tr>
        <td width="0.3%"></td>
        <td ><?php if(isset($disability['dis_tick_mental'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 54px"> <!-- DISABILITY ROW 4 -->
    <tr>
        <td width="0.3%"></td>
        <td width="33%"><?php if(isset($disability['dis_tick_visual'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="22%"><?php if($profile->dis_with_assistive == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td width="8%"><?php if($profile->dis_with_assistive == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td width="21%"><?php echo $profile->dis_with_assistive_yes ?></td>
        <td ><?php if($profile->dis_with_assistive == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 73px"> <!-- DISABILITY ROW 5 -->
    <tr>
        <td width="0.3%"></td>
        <td width="33%"><?php if(isset($disability['dis_tick_hearing'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="22%"><?php if($profile->dis_need_assistive == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td width="8%"><?php if($profile->dis_need_assistive == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td width="21%"><?php echo $profile->dis_need_assistive_yes; ?></td>
        <td ><?php if($profile->dis_need_assistive == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 93px"> <!-- DISABILITY ROW 5 -->
    <tr>
        <td width="0.3%"></td>
        <td ><?php if(isset($disability['dis_tick_speech'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 113px"> <!-- DISABILITY ROW 5 -->
    <tr>
        <td width="0.3%"></td>
        <td ><?php if(isset($disability['dis_tick_musculo'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellpadding="0" >
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td width="33%">Psychosocial and Behavioral Conditions</td>
        <td width="20%">Give description of disability:</td>
        <td>@if(!isset($profile->dis_give_description)){{ '_____________________________________________________________' }}@endif</td>
    </tr>
    <tr>
        <td ><div class="box"></div></td>
        <td >Learning or Intellectual Disability</td>
        <td ></td>
        <td>@if(!isset($profile->dis_give_description)){{ '_____________________________________________________________' }}@endif</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box" style="margin-left: 1px"></div></td>
        <td>Mental Conditions</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box" style="margin-left: 1px"></div></td>
        <td width="31%">Visual or Seeing Impairement</td>
        <td width="2%"><div class="box"></div></td>
        <td width="20%">With assistive device/s?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="27%">Yes,specify:______________________________</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
    <tr>
        <td><div class="box" style="margin-left: 1px"></div></td>
        <td>Hearing Impairement</td>
        <td><div class="box"></div></td>
        <td>Need for assistive device/s?</td>
        <td><div class="box"></div></td>
        <td>Yes,specify:______________________________</td>
        <td><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box" style="margin-left: 1px"></div></td>
        <td>Speech Impairement</td>
    </tr>
    <tr>
        <td><div class="box" style="margin-left: 1px;"></div></td>
        <td>Musculo-Skeletal or Injury Impairements</td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;margin-top: 5px">
    <tr>
        <td height="95px" width="50%"></td>
        <td height="95px" width="50%"></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
        <td width="50%">&nbsp;&nbsp;<b>Injury</b></td>
        <td width="50%">&nbsp;&nbsp;MEDICATIONS (List all current medicines and food supplement being taken):</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px"> <!-- INJURY ROW 1 -->
    <tr>
        <td width="0.3%"></td>
        <td ><?php if($profile->inj_vehicular) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0" style="position:absolute;margin-top: 5px"> <!-- INJURY ROW 1 MEDICATION-->
    <tr>
        <td width="52%"></td>
        <td>@if(isset($profile->inj_medications)){!! "<b style='font-size:7pt;'><u>".$profile->inj_medications."</u></b>" !!}@endif</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 13px"> <!-- INJURY ROW 2 -->
    <tr>
        <td width="0.3%"></td>
        <td ><?php if($profile->inj_burns) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 33px">
    <tr>
        <td width="0.3%"></td>
        <td><?php if($profile->inj_drowning) echo '<span>&#10004;</span>'; ?></td> <!-- INJURY ROW 3 -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 53px"> <!-- INJURY ROW 4 -->
    <tr>
        <td width="0.3%"></td>
        <td><?php if($profile->inj_fall) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box" style="margin-left: 1px"></div></td>
        <td width="51%">Vehicular Accident/Traffic-Related Injuries</td>
        <td>@if(!isset($profile->inj_medications)){{ '__________________________________________________________________' }}@endif</td>
    </tr>
    <tr>
        <td ><div class="box" style="margin-left: 1px"></div></td>
        <td >Burns</td>
        <td>@if(!isset($profile->inj_medications)){{ '__________________________________________________________________' }}@endif</td>
    </tr>
    <tr>
        <td ><div class="box" style="margin-left: 1px"></div></td>
        <td >Drowning</td>
        <td>@if(!isset($profile->inj_medications)){{ '__________________________________________________________________' }}@endif</td>
    </tr>
    <tr>
        <td ><div class="box" style="margin-left: 1px"></div></td>
        <td >Fall</td>
        <td>@if(!isset($profile->inj_medications)){{ '__________________________________________________________________' }}@endif</td>
    </tr>
</table>
<table class="table1" border="0" style="margin-top: 5px;">
    <tr>
        <td>
            <b>HOSPITALIZATION HISTORY</b> <i>(List all past and current hospitalization/s.)</i>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="17px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px">
    <tr>
        <td width="25.3%"></td>
        <td width="7%"><?php if(isset($medical_history['mh_tick_allergy'])) echo '<span>&#10004;</span>'; ?></td>
        <td><?php if(isset($medical_history['mh_tick_allergy'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="25%">&nbsp;&nbsp;Where you previously hospitalized</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Yes</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0">
    <tr>
        <td width="27%"><center>Reason/Diagnosis</center></td>
        <td width="15%"><center>Date Hospitalized</center></td>
        <td><center>Place Hospitalized</center></td>
        <td width="15%"><center>PhilHealth used? Y/N</center></td>
        <td><center>Cost/s not covered by PhilHealth?</center></td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="margin-top: -1px">
    @if(count($hospitalization_history) >= 1)
        <?php $hospitalization_count = 0; ?>
        @foreach($hospitalization_history as $row)
            <?php $hospitalization_count++; ?>
            <tbody id="fetch_data">
                <tr>
                    <td width="3%;">&nbsp;&nbsp;&nbsp;{{ $hospitalization_count }}</td>
                    <td width="24%"><div style="margin-left: 2%">{{ $row->hos_reason }}</div></td>
                    <td width="15%"><div style="margin-left: 2%">{{ $row->hos_date }}</div></td>
                    <td width="21.7%"><div style="margin-left: 2%">{{ $row->hos_place }}</div></td>
                    <td width="15%"><div style="margin-left: 2%">{{ $row->hos_phic }}</div></td>
                    <td><div style="margin-left: 2%">{{ $row->hos_cost }}</div></td>
                </tr>
            </tbody>
        @endforeach
    @else
        @for($i=1;$i<=5;$i++)
            <tr>
                <td width="3%;">&nbsp;&nbsp;&nbsp;{{ $i }}</td>
                <td width="24%"></td>
                <td width="15%"></td>
                <td width="21.7%"></td>
                <td width="15%"></td>
                <td></td>
            </tr>
        @endfor
    @endif
    <tr>
        <td colspan="6">&nbsp;&nbsp;<i>(Please use another sheef if needed.)</i></td>
    </tr>
</table>
<table class="table1" border="0" >
    <tr>
        <td>
            <b>PAST SURGICAL HISTORY</b> <i>(List all operations, both minor and major, underwent by the vaccinee.)</i>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="72px"></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    @if(count($past_surgical_history))
        @foreach($past_surgical_history as $row)
            <tr>
                <td width="78%">Operation: <b style="font-size: 7pt;margin-left: 5px;">{{ $row->sur_operation }}</b></td>
                <td>Date:</td>
                <td width="2%"><div class="box"><b style="margin-left: 3px">{{ date("m",strtotime($row->sur_date))[0] }}</b></div></td>
                <td width="2%"><div class="box"><b style="margin-left: 3px">{{ date("m",strtotime($row->sur_date))[1] }}</b></div></td>
                <td>&nbsp;/</td>
                <td width="2%"><div class="box"><b style="margin-left: 3px">{{ date("d",strtotime($row->sur_date))[0] }}</b></div></td>
                <td width="2%"><div class="box"><b style="margin-left: 3px">{{ date("d",strtotime($row->sur_date))[1] }}</b></div></td>
                <td>&nbsp;/</td>
                <td width="2%"><div class="box"><b style="margin-left: 3px">{{ date("Y",strtotime($row->sur_date))[0] }}</b></div></td>
                <td width="2%"><div class="box"><b style="margin-left: 3px">{{ date("Y",strtotime($row->sur_date))[1] }}</b></div></td>
                <td width="2%"><div class="box"><b style="margin-left: 3px">{{ date("Y",strtotime($row->sur_date))[2] }}</b></div></td>
                <td width="2%"><div class="box"><b style="margin-left: 3px">{{ date("Y",strtotime($row->sur_date))[3] }}</b></div></td>
            </tr>
        @endforeach
    @else
        @foreach(range(1,4) as $index)
        <tr>
            <td width="78%">Operation:</td>
            <td>Date:</td>
            <td width="2%"><div class="box"></div></td>
            <td width="2%"><div class="box"></div></td>
            <td>&nbsp;/</td>
            <td width="2%"><div class="box"></div></td>
            <td width="2%"><div class="box"></div></td>
            <td>&nbsp;/</td>
            <td width="2%"><div class="box"></div></td>
            <td width="2%"><div class="box"></div></td>
            <td width="2%"><div class="box"></div></td>
            <td width="2%"><div class="box"></div></td>
        </tr>
        @endforeach
    @endif
</table>


<div class="footer">
    <div class="page_number">Page </div>
</div>