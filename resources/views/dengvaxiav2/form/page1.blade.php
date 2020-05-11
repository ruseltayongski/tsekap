<div class="row">
    <div class="col-md-6">
        <label class="text-green">GENERAL INFORMATION</label>
    </div>
    <div class="col-md-6">
        <div class="pull-right">
            <b>DENGVAXIA RECIPIENT NUMBER:</b> <input type="text" value="{{ $profile->dengvaxia_recipient_no }}" name="dengvaxia_recipient_no">
        </div>
    </div>
</div>

<table class="table table-hover table-striped">
    <tr>
        <td>
            <b>Individual Vaccination Card</b><br>
            <small><b>Name of Vacinee</b></small><br>
            <small>Last Name</small>
            <input type="text" value="{{ $profile->lname }}" class="form-control" name="lname">
        </td>
        <td>
            <br><br>
            <small>First Name</small>
            <input type="text" value="{{ $profile->fname }}" class="form-control" name="fname">
        </td>
        <td style="width: 10%">
            <br><br>
            <small>MI</small>
            <input type="text" value="{{ $profile->mname }}" class="form-control" name="mname">
        </td>
        <td>
            <br><br>
            <small>Ext</small>
            <select name="suffix" class="form-control chosen-select" id="suffix" style="width: 100%">
                <option value="">Select option</option>
                <option <?php if($profile->suffix=='Jr.') echo 'selected'; ?>>Jr.</option>
                <option <?php if($profile->suffix=='Sr.') echo 'selected'; ?>>Sr.</option>
                <option <?php if($profile->suffix=='I') echo 'selected'; ?>>I</option>
                <option <?php if($profile->suffix=='II') echo 'selected'; ?>>II</option>
                <option <?php if($profile->suffix=='III') echo 'selected'; ?>>III</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <small>Relation to household head</small>
            <select name="head" id="head" class="form-control <?php if($profile->head!='YES') echo 'hide'; ?>">
                <option value="">Select option</option>
                <option <?php if($profile->head=='YES') echo 'selected'; ?> value="YES">YES</option>
                <option <?php if($profile->head=='NO') echo 'selected'; ?> value="NO">NO</option>
            </select>
            <div class="relation <?php if($profile->head=='YES') echo 'hide'; ?>">
                <select name="relation" onchange="changeGender($(this))" id="relation" class="form-control chosen-select">
                    <option value="">Select option</option>
                    <option <?php if($profile->relation=='Son') echo 'selected'; ?>>Son</option>
                    <option <?php if($profile->relation=='Daughter') echo 'selected'; ?>>Daughter</option>
                    <option <?php if($profile->relation=='Wife') echo 'selected'; ?>>Wife</option>
                    <option <?php if($profile->relation=='Husband') echo 'selected'; ?>>Husband</option>
                    <option <?php if($profile->relation=='Father') echo 'selected'; ?>>Father</option>
                    <option <?php if($profile->relation=='Mother') echo 'selected'; ?>>Mother</option>
                    <option <?php if($profile->relation=='Brother') echo 'selected'; ?>>Brother</option>
                    <option <?php if($profile->relation=='Sister') echo 'selected'; ?>>Sister</option>
                    <option <?php if($profile->relation=='Nephew') echo 'selected'; ?>>Nephew</option>
                    <option <?php if($profile->relation=='Niece') echo 'selected'; ?>>Niece</option>
                    <option <?php if($profile->relation=='Grandfather') echo 'selected'; ?>>Grandfather</option>
                    <option <?php if($profile->relation=='Grandmother') echo 'selected'; ?>>Grandmother</option>
                    <option <?php if($profile->relation=='Grandson') echo 'selected'; ?>>Grandson</option>
                    <option <?php if($profile->relation=='Granddaughter') echo 'selected'; ?>>Granddaughter</option>
                    <option <?php if($profile->relation=='Cousin') echo 'selected'; ?>>Cousin</option>
                    <option <?php if($profile->relation=='Relative') echo 'selected'; ?>>Relative</option>
                    <option <?php if($profile->relation=='Daughter in Law') echo 'selected'; ?>>Daughter in Law</option>
                    <option <?php if($profile->relation=='Son in Law') echo 'selected'; ?>>Son in Law</option>
                    <option <?php if($profile->relation=='Sister in Law') echo 'selected'; ?>>Sister in Law</option>
                    <option <?php if($profile->relation=='Brother in Law') echo 'selected'; ?>>Brother in Law</option>
                    <option <?php if($profile->relation=='Father in Law') echo 'selected'; ?>>Father in Law</option>
                    <option <?php if($profile->relation=='Mother in Law') echo 'selected'; ?>>Mother in Law</option>
                    <option <?php if($profile->relation=='partner') echo 'selected'; ?>>Live-in Partner</option>
                    <option <?php if($profile->relation=='Deceased') echo 'selected'; ?>>Deceased</option>
                    <option <?php if($profile->relation=='Others') echo 'selected'; ?>>Others</option>
                </select>
            </div>
        </td>
        <td>
            <small>Respondent</small>
            <input type="text" class="form-control" name="respondent" value="{{ $profile->respondent }}">
        </td>
        <td colspan="3">
            <small>Contact No</small>
            <input type="text" class="form-control" value="{{ $profile->contact_no }}" name="contact_no">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>Address</b></small><br>
            <small>House No. & Street Name</small>
            <input type="text" class="form-control" name="street_name" value="{{ $profile->street_name }}">
        </td>
        <td>
            <br>
            <small>Sitio/Purok</small>
            <input type="text" class="form-control" name="sitio" value="{{ $profile->sitio }}">
        </td>
        <td >
            <br>
            <small>Barangay</small>
            <select name="barangay_id" class="form-control">
                <option value="">Select option</option>
                @foreach($brgy as $row)
                    <option <?php if($profile->barangay_id==$row->id) echo 'selected'; ?> value="{{ $row->id }}">{{ $row->description }}</option>
                @endforeach
            </select>
        </td>
        <td >
            <br>
            <small>Municipality</small>
            <select name="muncity_id" class="form-control">
                <option value="">Select option</option>
                @foreach($muncity as $row)
                    <option <?php if($profile->muncity_id==$row->id) echo 'selected'; ?> value="{{ $row->id }}">{{ $row->description }}</option>
                @endforeach
            </select>
        </td>
        <td >
            <br>
            <small>Province</small>
            <select name="province_id" class="form-control">
                <option value="">Select option</option>
                @foreach($province as $row)
                    <option <?php if($profile->province_id==$row->id) echo 'selected'; ?> value="{{ $row->id }}">{{ $row->description }}</option>
                @endforeach
            </select>
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small>Sex</small><br>
            <input type="radio" <?php if($profile->sex=='Male') echo 'checked'; ?> name="sex" class="sex" value="Male" required style="display:inline;"> Male
            &nbsp;&nbsp;&nbsp;
            <input type="radio" <?php if($profile->sex=='Female') echo 'checked'; ?> name="sex" class="sex" value="Female" required> Female
        </td>
        <td style="width: 10%">
            <small>Age</small>
            <input type="text" name="age" id="age" class="form-control">
        </td>
        <td >
            <small>Religion</small><br>
            <input type="radio" name="religion" value="rc" <?php if($profile->religion=='rc') echo 'checked'; ?>> RC
        </td>
        <td>
            <br>
            <input type="radio" name="religion" value="christian" <?php if($profile->religion=='christian') echo 'checked'; ?>> Christian
        </td>
        <td>
            <br>
            <input type="radio" name="religion" value="inc" <?php if($profile->religion=='inc') echo 'checked'; ?>> INC
        </td>
        <td>
            <br>
            <input type="radio" name="religion" value="islam" <?php if($profile->religion=='islam') echo 'checked'; ?>> Islam
        </td>
        <td>
            <br>
            <input type="radio" name="religion" value="jehovah" <?php if($profile->religion=='jehovah') echo 'checked'; ?>> Jehovah
        </td>
        <td>
            <br>
            <small>Others, specify</small>
            <input type="text" name="religion_others" value="{{ $profile->religion_others }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small>Birthdate</small>
            <input type="date" name="dob" onkeyup="calculateAge()" onkeypress="calculateAge()" onblur="calculateAge()" id="dob" value="{{ $profile->dob }}" class="form-control">
        </td>
        <td>
            <small>Birthplace(Mun/City/Prov)</small>
            <input type="text" name="birth_place" class="form-control" value="{{ $profile->birth_place }}">
        </td>
        <td >
            <small>Yrs. at Current Address</small>
            <input type="text" name="yrs_current_address" class="form-control" value="{{ $profile->yrs_current_address }}">
        </td>
    </tr>
</table>
<label class="text-green">LEVEL OF EDUCATION</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="radio" value="elem" name="education" <?php if($profile->education == 'elem' || $profile->education == 'elem_grad') echo 'checked'; ?> > Elementary
        </td>
        <td>
            <input type="radio" value="high" name="education" <?php if($profile->education == 'high' || $profile->education == 'high_grad') echo 'checked'; ?>> High School
        </td>
        <td>
            <input type="radio" value="vocational" name="education" <?php if($profile->education == 'vocational') echo 'checked'; ?>> Vocational
        </td>
        <td>
            <input type="radio" value="unable_provide" name="education" <?php if($profile->education == 'unable_provide') echo 'checked'; ?> > No Completed Schooling
        </td>
    </tr>
</table>
<label class="text-green">PHIC MEMBERSHIP OF PRINCIPAL(PARENTS)</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <small><b>Status</b></small><br>
            <input type="radio" value="member" name="phic_status" <?php if($profile->phic_status == 'member') echo 'checked'; ?>> Member
        </td>
        <td>
            <br>
            <input type="radio" value="dependent" name="phic_status" <?php if($profile->phic_status == 'dependent') echo 'checked'; ?>> Dependent
        </td>
        <td>
            <br>
            <input type="radio" value="non_member" name="phic_status" <?php if($profile->phic_status == 'non_member') echo 'checked'; ?>> Non-Member
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <small><b>Type</b></small><br>
            <input type="radio" value="lifetime" name="phic_type" <?php if($profile->phic_type == 'lifetime') echo 'checked'; ?>> Lifetime<br>
        </td>
        <td width="14%">
            <br>
            <input type="radio" value="sponsored" name="phic_type" <?php if($profile->phic_type == 'sponsored') echo 'checked'; ?>> Sponsored Specify:
        </td>
        <td width="7%">
            <br>
            <input type="radio" value="doh" name="phic_sponsored" <?php if($profile->phic_sponsored == 'doh') echo 'checked'; ?>> DOH
        </td>
        <td width="7%">
            <br>
            <input type="radio" value="plgu" name="phic_sponsored" <?php if($profile->phic_sponsored == 'plgu') echo 'checked'; ?>> PLGU
        </td>
        <td width="7%">
            <br>
            <input type="radio" value="mlgu" name="phic_sponsored" <?php if($profile->phic_sponsored == 'mlgu') echo 'checked'; ?>> MLGU
        </td>
        <td width="7%">
            <br>
            <input type="radio" value="private" name="phic_sponsored" <?php if($profile->phic_sponsored == 'private') echo 'checked'; ?>> Private
        </td>
        <td>
            <br>
            <input type="radio" value="others" name="phic_sponsored" <?php if($profile->phic_sponsored == 'others') echo 'checked'; ?>> Others, specify: <input type="text" name="phic_sponsored_others" value="{{ $profile->phic_sponsored_others }}">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <small><b>Employed</b></small><br>
            <input type="radio" value="government" name="phic_employed" <?php if($profile->phic_employed == 'government') echo 'checked'; ?>> Government
        </td>
        <td>
            <br>
            <input type="radio" value="private" name="phic_employed" <?php if($profile->phic_employed == 'private') echo 'checked'; ?>> Private
        </td>
        <td>
            <br>
            <input type="radio" value="self_employed" name="phic_employed" <?php if($profile->phic_employed == 'self_employed') echo 'checked'; ?>> Self-Employed
        </td>
        <td >
            <small><b>Are you aware of your PHIC benefits?</b></small><br>
            <select name="phic_benefits" class="form-control">
                <option value="">Select option</option>
                <option value="yes" <?php if($profile->phic_benefits == 'yes') echo 'selected'; ?>>Yes</option>
                <option value="no" <?php if($profile->phic_benefits == 'no') echo 'selected'; ?>>No</option>
            </select>
        </td>
        <td>
            <br>
            If yes, specify: <input name="phic_benefits_yes" type="text" value="{{ $profile->phic_benefits_yes }}">
        </td>
    </tr>
</table>

<label class="text-green">FAMILY HISTORY(Among mother, father, and siblings. Tick all that apply)</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="allergy" name="fh_tick[]" <?php if(isset($family_history['fh_tick_allergy'])) echo 'checked'; ?>> Allergy, specify:
            <input type="text" name="fh_specify_allergy" value="<?php if(isset($family_history['fh_specify_allergy'])) echo $family_history['fh_specify_allergy']; ?>">
        </td>
        <td>
            <input type="checkbox" value="epilepsy" name="fh_tick[]" <?php if(isset($family_history['fh_tick_epilepsy'])) echo 'checked'; ?>> Epilepsy/Seizure Disorder, specify:
            <input type="text" name="fh_specify_epilepsy" value="<?php if(isset($family_history['fh_specify_epilepsy'])) echo $family_history['fh_specify_epilepsy']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="heart" name="fh_tick[]" <?php if(isset($family_history['fh_tick_heart'])) echo 'checked'; ?>> Heart Disease &/ or Hearth Attack, specify:
            <input type="text" name="fh_specify_heart" value="<?php if(isset($family_history['fh_specify_heart'])) echo $family_history['fh_specify_heart']; ?>">
        </td>
        <td>
            <input type="checkbox" value="cancer" name="fh_tick[]" <?php if(isset($family_history['fh_tick_cancer'])) echo 'checked'; ?>> Cancer, specify organ:
            <input type="text" name="fh_specify_cancer" value="<?php if(isset($family_history['fh_specify_cancer'])) echo $family_history['fh_specify_cancer']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="immune" name="fh_tick[]" <?php if(isset($family_history['fh_tick_immune'])) echo 'checked'; ?>> Immune Deficiency Disease, specify:
            <input type="text" name="fh_specify_immune" value="<?php if(isset($family_history['fh_specify_immune'])) echo $family_history['fh_specify_immune']; ?>">
        </td>
        <td >
            <input type="checkbox" value="kidney" name="fh_tick[]" <?php if(isset($family_history['fh_tick_kidney'])) echo 'checked'; ?>> Kidney Disease, specify:
            <input type="text" name="fh_specify_kidney" value="<?php if(isset($family_history['fh_specify_kidney'])) echo $family_history['fh_specify_kidney']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="mental" name="fh_tick[]" <?php if(isset($family_history['fh_tick_mental'])) echo 'checked'; ?>> Mental Health Condition
        </td>
        <td>
            <input type="checkbox" value="asthma" name="fh_tick[]" <?php if(isset($family_history['fh_tick_asthma'])) echo 'checked'; ?>> Asthma
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="thyroid" name="fh_tick[]" <?php if(isset($family_history['fh_tick_thyroid'])) echo 'checked'; ?>> Thyroid Disease
        </td>
        <td>
            <input type="checkbox" value="tuberculosis" name="fh_tick[]" <?php if(isset($family_history['fh_tick_tuberculosis'])) echo 'checked'; ?>> Tuberculosis
        </td>
    </tr>
</table>
<label class="text-green">MEDICAL HISTORY OF VACCINEE(Tick all past and present health conditions of the vaccinee.)</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="allergy" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_allergy'])) echo 'checked'; ?>> Allergy, specify:
            <input type="text" name="mh_specify_allergy" value="<?php if(isset($medical_history['mh_specify_allergy'])) echo $medical_history['mh_specify_allergy']; ?>">
        </td>
        <td>
            <input type="checkbox" value="epilepsy" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_epilepsy'])) echo 'checked'; ?>> Epilepsy/Seizure Disorder, specify:
            <input type="text" name="mh_specify_epilepsy" value="<?php if(isset($medical_history['mh_specify_epilepsy'])) echo $medical_history['mh_specify_epilepsy']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="kidney" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_kidney'])) echo 'checked'; ?>> Kidney Disease, specify:
            <input type="text" name="mh_specify_kidney" value="<?php if(isset($medical_history['mh_specify_kidney'])) echo $medical_history['mh_specify_kidney']; ?>">
        </td>
        <td>
            <input type="checkbox" value="immune" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_immune'])) echo 'checked'; ?>> Immune Deficiency Disease, specify:
            <input type="text" name="mh_specify_immune" value="<?php if(isset($medical_history['mh_specify_immune'])) echo $medical_history['mh_specify_immune']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="hepatitis" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_hepatitis'])) echo 'checked'; ?>> Hepatitis, specify
            <input type="text" name="mh_specify_hepatitis" value="<?php if(isset($medical_history['mh_specify_hepatitis'])) echo $medical_history['mh_specify_hepatitis']; ?>">
        </td>
        <td>
            <input type="checkbox" value="heart" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_heart'])) echo 'checked'; ?>> Heart Disease, specify:
            <input type="text" name="mh_specify_heart" value="<?php if(isset($medical_history['mh_specify_heart'])) echo $medical_history['mh_specify_heart']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="poisoning" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_poisoning'])) echo 'checked'; ?>> Poisoning, specify:
            <input type="text" name="mh_specify_poisoning" value="<?php if(isset($medical_history['mh_specify_poisoning'])) echo $medical_history['mh_specify_poisoning']; ?>">
        </td>
        <td>
            <input type="checkbox" value="sti" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_sti'])) echo 'checked'; ?>> STIs, specify:
            <input type="text" name="mh_specify_sti" value="<?php if(isset($medical_history['mh_specify_sti'])) echo $medical_history['mh_specify_sti']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="thyroid" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_thyroid'])) echo 'checked'; ?>> Thyroid Disease, specify:
            <input type="text" name="mh_specify_thyroid" value="<?php if(isset($medical_history['mh_specify_thyroid'])) echo $medical_history['mh_specify_thyroid']; ?>">
        </td>
        <td>
            <input type="checkbox" value="cancer" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_cancer'])) echo 'checked'; ?>> Cancer, specify organ:
            <input type="text" name="mh_specify_cancer" value="<?php if(isset($medical_history['mh_specify_cancer'])) echo $medical_history['mh_specify_cancer']; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="asthma" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_asthma'])) echo 'checked'; ?>> Asthma (Fill-up Brochial Asthma Section)
        </td>
        <td>
            <input type="checkbox" value="tuberculosis" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_tuberculosis'])) echo 'checked'; ?>> Tuberculosis(If yes, fill-up Tuberculosis Section)
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="peptic" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_peptic'])) echo 'checked'; ?>> Peptic Ulcer Disease
        </td>
        <td>
            <input type="checkbox" value="diabetes" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_diabetes'])) echo 'checked'; ?>> Diabetes mellitus (Fill-up Diabetes Mellitus Section)
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="urinary" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_urinary'])) echo 'checked'; ?>> Urinary Tract Infections
        </td>
        <td>
            <input type="checkbox" value="malaria" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_malaria'])) echo 'checked'; ?>> Malaria
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="pneumonia" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_pneumonia'])) echo 'checked'; ?>> Pneumonia
        </td>
        <td colspan="2">
            <input type="checkbox" value="others" name="mh_tick[]" <?php if(isset($medical_history['mh_tick_others'])) echo 'checked'; ?>> Others, specify:
            <input type="text" name="mh_specify_others" value="<?php if(isset($medical_history['mh_specify_others'])) echo $medical_history['mh_specify_others']; ?>">
        </td>
    </tr>
</table>
