<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;">
    <tr>
        <td width="63%"></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[0])) echo $profile->dengvaxia_recipient_no[0] ?></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[1])) echo $profile->dengvaxia_recipient_no[1] ?></div></td>
        <td width="2%"><div class="box"><b>----</b></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[2])) echo $profile->dengvaxia_recipient_no[2] ?></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[3])) echo $profile->dengvaxia_recipient_no[3] ?></div></td>
        <td width="2%"><div class="box"><b>----</b></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[4])) echo $profile->dengvaxia_recipient_no[4] ?></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[5])) echo $profile->dengvaxia_recipient_no[5] ?></div></td>
        <td width="2%"><div class="box"><b>----</b></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[6])) echo $profile->dengvaxia_recipient_no[6] ?></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[6])) echo $profile->dengvaxia_recipient_no[6] ?></div></td>
        <td width="2%"><div class="box"><b>----</b></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[7])) echo $profile->dengvaxia_recipient_no[7] ?></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[8])) echo $profile->dengvaxia_recipient_no[8] ?></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[9])) echo $profile->dengvaxia_recipient_no[9] ?></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[10])) echo $profile->dengvaxia_recipient_no[10] ?></div></td>
        <td width="2%"><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[11])) echo $profile->dengvaxia_recipient_no[11] ?></div></td>
        <td ><div class="box">&nbsp;&nbsp;<?php if(isset($profile->dengvaxia_recipient_no[12])) echo $profile->dengvaxia_recipient_no[12] ?></div></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td>
            <i>GENERAL INFORMATION</i>
        </td>
        <td >
            <i>DENGVAXIA RECIPENT NUMBER:</i>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="160px"></td>
    </tr>
</table>
<table class="table1">
    <tr>
        <td>Individual Vaccination Card:</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;;">
    <tr>
        <td width="12%"></td>
        <td width="27%">{{ $profile->lname }}</td>
        <td width="27%">{{ $profile->fname }}</td>
        <td>{{ $profile->mname }}</td>
        <td>{{ $profile->suffix }}</td>
    </tr>
</table>
<table class="table1" border="0">
    <tr>
        <td width="12%">Name of Vaccinee:</td>
        <td>_________________________________</td>
        <td>_________________________________</td>
        <td>_________________</td>
        <td>_________________</td>
    </tr>
    <tr>
        <td></td>
        <td><i>(Last name)</i></td>
        <td><i>(First name)</i></td>
        <td><i>(Middle Inital)</i></td>
        <td><i>(Extension: Sr,Jr, Etc)</i></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;;">
    <tr>
        <td width="20%"></td>
        <td>{{ $profile->head }}</td>
        <td width="13%"></td>
        <td>{{ $profile->respondent }}</td>
        <td width="12%"></td>
        <td>{{ $profile->contact_no }}</td>
    </tr>
</table>
<table class="table1" border="0">
    <tr>
        <td width="20%">Relationship to Household Head:</td>
        <td>_________________</td>
        <td width="9%">Respondent:</td>
        <td>____________________</td>
        <td width="7%">Contact No</td>
        <td>_________________</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;;">
    <tr>
        <td width="7%"></td>
        <td width="20%">{{ $profile->street_name }}</td>
        <td width="20%">{{ $profile->sitio }}</td>
        <td width="20%">{{ \App\Barangay::find($profile->barangay_id)->description }}</td>
        <td width="20%">{{ \App\Muncity::find($profile->muncity_id)->description }}</td>
        <td width="20%">{{ \App\Province::find($profile->province_id)->description }}</td>
    </tr>
</table>
<table class="table1" border="0">
    <tr>
        <td width="7%">Address:</td>
        <td width="20%">___________________________</td>
        <td width="20%">___________________________</td>
        <td width="20%">___________________________</td>
        <td width="20%">___________________________</td>
        <td width="20%">___________________________</td>
    </tr>
    <tr>
        <td></td>
        <td><i>(House No. & Street Name)</i></td>
        <td><i>(Sitio/Purok)</i></td>
        <td><i>(Barangay)</i></td>
        <td><i>(Municipality/City)</i></td>
        <td><i>(Province)</i></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px;">
    <tr>
        <td width="8.3%"></td>
        <td width="5%"><?php if($profile->sex=='Male') echo '<span>&#10004;</span>'; ?></td> <!-- MALE -->
        <td width="15%"><?php if($profile->sex=='Female') echo '<span>&#10004;</span>'; ?></td> <!-- FEMALE -->
        <td width="18%"><?php if(isset($profile->dob)) echo \App\Http\Controllers\ParameterCtrl::getAge($profile->dob) ?></td> <!-- AGE -->
        <td width="5%"><?php if($profile->religion=='rc') echo '<span>&#10004;</span>'; ?></td> <!-- RC -->
        <td width="7%"><?php if($profile->religion=='christian') echo '<span>&#10004;</span>'; ?></td> <!-- CHRISTIAN -->
        <td width="5%"><?php if($profile->religion=='inc') echo '<span>&#10004;</span>'; ?></td> <!-- INC -->
        <td width="6%"><?php if($profile->religion=='islam') echo '<span>&#10004;</span>'; ?></td> <!-- ISLAM -->
        <td width="20%"><?php if($profile->religion=='jehovah') echo '<span>&#10004;</span>'; ?></td> <!-- JEHOVAH -->
        <td >{{ $profile->religion_others }}</td> <!-- OTHER RELIGION -->
    </tr>
</table>
<table class="table1" border="0">
    <tr>
        <td >Sex:</td>
        <td width="2%"><div class="box"></div></td>
        <td width="3%">Male</td>
        <td width="2%"><div class="box"></div></td>
        <td>Female</td>
        <td width="3%">Age:</td>
        <td>__________ y/o</td>
        <td width="7%">Religion: </td>
        <td width="2%"><div class="box"></div></td>
        <td width="3%">RC</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Christian</td>
        <td width="2%"><div class="box"></div></td>
        <td width="3%">INC</td>
        <td width="2%"><div class="box"></div></td>
        <td width="4%">Islam</td>
        <td width="2%"><div class="box"></div></td>
        <td >Jehovah</td>
        <td>Others, specify:________________</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;">
    <tr>
        <td width="15.5%"></td>
        <td width="38%">{{ date('m/d/Y',strtotime($profile->dob)) }}</td>
        <td width="37%">{{ $profile->birth_place }}</td>
        <td >{{ $profile->yrs_current_address }}</td>
    </tr>
</table>
<table class="table1" border="0">
    <tr>
        <td width="15%">Birthdate (mm/dd/yyyy):</td>
        <td>_________________________________</td>
        <td width="15%">Birthplace (Mun/City/Prov)</td>
        <td>_________________________________</td>
        <td width="14%">Yrs. at Current Address:</td>
        <td>_____________</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0" style="margin-top: 5px;">
    <tr>
        <td colspan="6">
            <i>LEVEL OF EDUCATION:</i>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="20px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px">
    <tr>
        <td width="0.5%"></td>
        <td width="25.5%"><?php if($profile->education == 'elem') echo '<span>&#10004;</span>'; ?></td> <!-- elementary -->
        <td width="23.5%"><?php if($profile->education == 'high') echo '<span>&#10004;</span>'; ?></td> <!-- high school -->
        <td width="25.2%"><?php if($profile->education == 'vocational') echo '<span>&#10004;</span>'; ?></td> <!-- vacational -->
        <td><?php if($profile->education == 'unable_provide') echo '<span>&#10004;</span>'; ?></td> <!-- no completed schooling -->
    </tr>
</table>
<table class="table1" border="0">
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td > Elementary</td>
        <td width="2%"><div class="box"></div></td>
        <td > High School</td>
        <td width="2%"><div class="box"></div></td>
        <td > Vocational</td>
        <td width="2%"><div class="box"></div></td>
        <td  > No Completed Schooling</td>
    </tr>
</table>
<table class="table1" border="0" style="margin-top: 0px;">
    <tr>
        <td colspan="4">
            <i>PHIC MEMBERSHIP OF PRINCIPAL (PARENTS):</i>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="75px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px">
    <tr>
        <td width="19.3%"></td>
        <td width="30.5%"><?php if($profile->phic_type == 'lifetime') echo '<span>&#10004;</span>'; ?></td> <!-- lifetime -->
        <td><?php if(isset($profile->phic_employed)) echo '<span>&#10004;</span>'; ?></td> <!-- employed -->
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="15%">&nbsp;&nbsp;Status</td>
        <td width="4%">Type:</td>
        <td width="2%"><div class="box"></div></td>
        <td width="28.5%"> Lifetime</td>
        <td width="2%"><div class="box"></div></td>
        <td> Employed</td>
        <td>Are you aware of your PHIC benefits?</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px">
    <tr>
        <td width="0.3%"></td>
        <td width="19%"><?php if($profile->phic_status == 'member') echo '<span>&#10004;</span>'; ?></td> <!-- member -->
        <td width="32%"><?php if($profile->phic_type == 'sponsored') echo '<span>&#10004;</span>'; ?></td> <!-- sponsored -->
        <td width="26%"><?php if($profile->phic_employed == 'government') echo '<span>&#10004;</span>'; ?></td> <!-- government -->
        <td width="7%"><?php if($profile->phic_benefits == 'yes') echo '<span>&#10004;</span>'; ?></td> <!-- yes -->
        <td><?php if($profile->phic_benefits == 'no') echo '<span>&#10004;</span>'; ?></td> <!-- no -->
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td width="17%">Member</td>
        <td width="2%"><div class="box"></div></td>
        <td width="30%">Sponsored</td>
        <td width="2%"><div class="box"></div></td>
        <td width="24%">Government</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Yes</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px">
    <tr>
        <td width="0.3%"></td>
        <td width="20.5%"><?php if($profile->phic_status == 'dependent') echo '<span>&#10004;</span>'; ?></td> <!-- dependent -->
        <td width="7.5%"><?php if($profile->phic_sponsored == 'doh') echo '<span>&#10004;</span>'; ?></td> <!-- doh -->
        <td width="7.5%"><?php if($profile->phic_sponsored == 'plgu') echo '<span>&#10004;</span>'; ?></td> <!-- plgu -->
        <td width="7.5%"><?php if($profile->phic_sponsored == 'mlgu') echo '<span>&#10004;</span>'; ?></td> <!-- mlgu -->
        <td width="8%"><?php if($profile->phic_sponsored == 'private') echo '<span>&#10004;</span>'; ?></td> <!-- private -->
        <td ><?php if($profile->phic_employed == 'private') echo '<span>&#10004;</span>'; ?></td> <!-- private -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 0px">
    <tr>
        <td width="85%"></td>
        <td>{{ $profile->phic_benefits_yes }}</td> <!-- yes specify -->
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td width="18.5%">Dependent</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5.5%">DOH</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5.5%">PLGU</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5.5%">MLGU</td>
        <td width="2%"><div class="box"></div></td>
        <td width="6%">Private</td>
        <td width="2%"><div class="box"></div></td>
        <td width="24%">Private</td>
        <td>If yes, specify:  _______________</td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px">
    <tr>
        <td width="0.2%"></td>
        <td width="20.5%"><?php if($profile->phic_status == 'non_member') echo '<span>&#10004;</span>'; ?></td> <!-- non member -->
        <td width="30.5%"><?php if($profile->phic_sponsored == 'others') echo '<span>&#10004;</span>'; ?></td> <!-- others -->
        <td ><?php /*if($profile->phic_employed == 'self_employed')*/ echo '<span>&#10004;</span>'; ?></td> <!-- self employed -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 0px">
    <tr>
        <td width="31%"></td>
        <td >{{ $profile->phic_sponsored_others }}</td> <!-- others specify -->
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td width="18.5%">Non-Member</td>
        <td width="2%"><div class="box"></div></td>
        <td width="28.5%">Others,specify: __________________</td>
        <td width="2%"><div class="box"></div></td>
        <td >Self-Employed</td>
    </tr>
</table>
<table class="table1" border="0" style="margin-top: 5px;">
    <tr>
        <td>
            <i>FAMILY HISTORY (Among mother, father, and siblings, Tick all that apply:)</i>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="82px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px">
    <tr>
        <td width="0.2%"></td>
        <td width="11%"><?php if(isset($family_history['fh_tick_allergy'])) echo '<span>&#10004;</span>'; ?></td> <!-- allergy -->
        <td width="25.5%"><?php if(isset($family_history['fh_specify_allergy'])) echo $family_history['fh_specify_allergy']; ?></td> <!-- fh allergy specify -->
        <td width="20%"><?php if(isset($family_history['fh_specify_allergy'])) echo '<span>&#10004;</span>'; ?></td> <!-- epilepsy -->
        <td width="20.7%"><?php if(isset($family_history['fh_specify_epilepsy'])) echo $family_history['fh_specify_epilepsy']; ?></td> <!-- fh epilepsy specify -->
        <td ><?php if(isset($family_history['fh_tick_mental'])) echo '<span>&#10004;</span>'; ?></td> <!-- mental health -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 13px">
    <tr>
        <td width="0.2%"></td>
        <td width="11%"><?php if(isset($family_history['fh_tick_asthma'])) echo '<span>&#10004;</span>'; ?></td> <!-- fh Asthma -->
        <td width="25.5%"></td>
        <td width="40.7%"><?php if(isset($family_history['fh_tick_heart'])) echo '<span>&#10004;</span>'; ?></td> <!-- fh Heart -->
        <td ><?php if(isset($family_history['fh_tick_thyroid'])) echo '<span>&#10004;</span>'; ?></td> <!-- fh Thyroid -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 19px;width: 77%">
    <tr>
        <td width="66%"></td>
        <td width="20%"><?php if(isset($family_history['fh_specify_heart'])) echo '<u>'.$family_history['fh_specify_heart'].'</u>'; ?>"</td> <!-- fh heart disease specify -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 32px">
    <tr>
        <td width="0.2%"></td>
        <td width="13%"><?php if(isset($family_history['fh_tick_cancer'])) echo '<span>&#10004;</span>'; ?></td> <!--fh cancer -->
        <td width="25.5%"><?php if(isset($family_history['fh_specify_cancer'])) echo $family_history['fh_specify_cancer']; ?></td> <!--fh cancer specify-->
        <td width="20%"></td>
        <td width="18.7%"></td>
        <td ><?php if(isset($family_history['fh_tick_tuberculosis'])) echo '<span>&#10004;</span>'; ?></td> <!--fh tuberculosis -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 52px">
    <tr>
        <td width="0.2%"></td>
        <td width="36.5%"><?php if(isset($family_history['fh_tick_immune'])) echo '<span>&#10004;</span>'; ?></td> <!-- fh immune -->
        <td ><?php if(isset($family_history['fh_tick_kidney'])) echo '<span>&#10004;</span>'; ?></td>  <!-- fh kidney -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 56px;width: 36%">
    <tr>
        <td width="13.5%"></td>
        <td width="10%"><?php if(isset($family_history['fh_specify_immune'])) echo '<u>'.$family_history['fh_specify_immune'].'</u>'; ?></td> <!-- fh immune specify-->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 56px">
    <tr>
        <td width="52%"></td>
        <td ><?php if(isset($family_history['fh_specify_kidney'])) echo $family_history['fh_specify_kidney']; ?></td> <!-- fh kidney specify-->
    </tr>
</table>

<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="1.5%"><div class="box"></div></td>
        <td width="25%">Allergy, specify: ______________________________________</td>
        <td width="1.5%"><div class="box"></div></td>
        <td width="28%">Epilepsy/Seizure Disorder, specify: _______________________________</td>
        <td width="1.5%"><div class="box"></div></td>
        <td width="15%">Mental Health Condition</td>
    </tr>
    <tr>
        <td><div class="box"></div></td>
        <td>Asthma</td>
        <td ><div class="box"></div></td>
        <td>Heart Disease &/or Heart Attack, specify: @if(!isset($family_history['fh_specify_heart'])){{ '__________________________' }}@endif</td>
        <td><div class="box"></div></td>
        <td>Thyroid Disease</td>
    </tr>
    <tr>
        <td><div class="box"></div></td>
        <td>Cancer, specify organ: ________________________________</td>
        <td></td>
        <td></td>
        <td ><div class="box"></div></td>
        <td>Tuberculosis</td>
    </tr>
    <tr>
        <td ><div class="box"></div></td>
        <td>Immune Deficiency Disease, specify: @if(!isset($family_history['fh_specify_immune'])){{ '_____________________' }}@endif</td>
        <td ><div class="box"></div></td>
        <td>Kidney Disease, specify: _______________________________________</td>
        <td ></td>
        <td></td>
    </tr>
</table>
<table class="table1" border="0" style="margin-top: 10px;">
    <tr>
        <td>
            <i>MEDICAL HISTORY OF VACCINEE (Tick all past and present health condition of the vaccinee.)</i>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;">
    <tr>
        <td height="145px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px">
    <tr>
        <td width="0.2%"></td>
        <td width="10%"><?php if(isset($medical_history['mh_tick_allergy'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh allergy -->
        <td width="23%"><?php if(isset($medical_history['mh_specify_allergy'])) echo $medical_history['mh_specify_allergy']; ?></td> <!-- mh allergy specify -->
        <td width="20%"><?php if(isset($medical_history['mh_tick_malaria'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh malaria -->
        <td width="13%"></td>
        <td width="14%"><?php if(isset($medical_history['mh_tick_heart'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh heart -->
        <td ><?php if(isset($medical_history['mh_specify_heart'])) echo $medical_history['mh_specify_heart']; ?></td> <!-- mh heart specify -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 13px">
    <tr>
        <td width="0.2%"></td>
        <td width="10%"><?php if(isset($medical_history['mh_tick_asthma'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh asthma -->
        <td width="23%"></td>
        <td width="20%"><?php if(isset($medical_history['mh_tick_pneumonia'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh pneumonia-->
        <td width="13%"></td>
        <td width="12%"><?php if(isset($medical_history['mh_tick_poisoning'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh poisoning -->
        <td ><?php if(isset($medical_history['mh_specify_poisoning'])) echo $medical_history['mh_specify_poisoning']; ?></td> <!-- mh specify -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 32px">
    <tr>
        <td width="0.2%"></td>
        <td width="10%"><?php if(isset($medical_history['mh_tick_tuberculosis'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh Tuberculosis -->
        <td width="23%"></td>
        <td width="20%"><?php if(isset($medical_history['mh_tick_epilepsy'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh epilepsy -->
        <td width="13%"><?php if(isset($medical_history['mh_specify_epilepsy'])) echo $medical_history['mh_specify_epilepsy']; ?></td> <!-- mh epilepsy specify -->
        <td width="9%"><?php if(isset($medical_history['mh_tick_sti'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh sti -->
        <td ><?php if(isset($medical_history['mh_specify_sti'])) echo $medical_history['mh_specify_sti']; ?></td> <!-- mh sti specify-->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 52px">
    <tr>
        <td width="0.2%"></td>
        <td width="33%"><?php if(isset($medical_history['mh_tick_peptic'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh Peptic -->
        <td width="15%"><?php if(isset($medical_history['mh_tick_kidney'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh kidney -->
        <td width="18%"><?php if(isset($medical_history['mh_specify_kidney'])) echo $medical_history['mh_specify_kidney']; ?></td> <!-- mh kidney specify -->
        <td width="11%"><?php if(isset($medical_history['mh_tick_thyroid'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh thyroid -->
        <td ><?php if(isset($medical_history['mh_specify_thyroid'])) echo $medical_history['mh_specify_thyroid']; ?></td> <!-- mh thyroid specify -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 72px">
    <tr>
        <td width="0.2%"></td>
        <td width="33%"><?php if(isset($medical_history['mh_tick_diabetes'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh Diabetes -->
        <td width="20%"><?php if(isset($medical_history['mh_tick_immune'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh immune -->
        <td width="13%"><?php if(isset($medical_history['mh_specify_immune'])) echo $medical_history['mh_specify_immune']; ?></td> <!-- mh immune specify -->
        <td width="13%"><?php if(isset($medical_history['mh_tick_cancer'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh cancer -->
        <td ><?php if(isset($medical_history['mh_specify_cancer'])) echo $medical_history['mh_specify_cancer']; ?></td> <!-- mh cancer specify -->
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 90px">
    <tr>
        <td width="0.2%"></td>
        <td width="33%"><?php if(isset($medical_history['mh_tick_urinary'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh urinary -->
        <td width="11%"><?php if(isset($medical_history['mh_tick_hepatitis'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh hepatitis -->
        <td width="22%"><?php if(isset($medical_history['mh_specify_hepatitis'])) echo $medical_history['mh_specify_hepatitis']; ?></td> <!-- mh hepatitis specify -->
        <td width="11%"><?php if(isset($medical_history['mh_tick_others'])) echo '<span>&#10004;</span>'; ?></td> <!-- mh other -->
        <td ><?php if(isset($medical_history['mh_specify_others'])) echo $medical_history['mh_specify_others']; ?></td> <!-- mh other specify -->
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td width="31%">Allergy, specify: _________________________________</td>
        <td width="2%"><div class="box"></div></td>
        <td width="31%">Malaria</td>
        <td width="2%"><div class="box"></div></td>
        <td>Heart, Disease, specify: ___________________________</td>
    </tr>
    <tr>
        <td><div class="box"></div></td>
        <td>Asthma (Fill-up Bronchial Asthma Section)</td>
        <td><div class="box"></div></td>
        <td>Pneumonia</td>
        <td><div class="box"></div></td>
        <td>Poisoning, specify: _______________________________</td>
    </tr>
    <tr>
        <td><div class="box"></div></td>
        <td>Tuberculosis (if yes, fill-up Tuberculosis Section)</td>
        <td><div class="box"></div></td>
        <td>Epilepsy/Seizure Disorder, specify: ___________________</td>
        <td><div class="box"></div></td>
        <td>STIs, specify: ___________________________________</td>
    </tr>
    <tr>
        <td colspan="6">.</td>
    </tr>
    <tr>
        <td><div class="box"></div></td>
        <td>Peptic Ulcer Disease</td>
        <td><div class="box"></div></td>
        <td>Kidney Disease, specify: ___________________________</td>
        <td><div class="box"></div></td>
        <td>Thyroid Fisease: _________________________________</td>
    </tr>
    <tr>
        <td colspan="6">.</td>
    </tr>
    <tr>
        <td><div class="box"></div></td>
        <td>Diabetes mellitus (Fill-up Diabetes Mellitus Section)</td>
        <td><div class="box"></div></td>
        <td>Immune Deficiency Disease, specify: __________________</td>
        <td><div class="box"></div></td>
        <td>Cancer, specify organ: ____________________________</td>
    </tr>
    <tr>
        <td><div class="box"></div></td>
        <td>Urinary Tract Infections</td>
        <td><div class="box"></div></td>
        <td>Hepatitis, specify: _________________________________</td>
        <td><div class="box"></div></td>
        <td>Others, specify: __________________________________</td>
    </tr>
</table>
<div class="footer">
    <div class="page_number">Page </div>
</div>