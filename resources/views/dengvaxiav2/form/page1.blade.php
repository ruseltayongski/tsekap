<div class="row">
    <div class="col-md-6">
        <label class="text-green">GENERAL INFORMATION</label>
    </div>
    <div class="col-md-6">
        <div class="pull-right">
            <b>DENGVAXIA RECIPIENT NUMBER:</b> <input type="text" name="recipent_number">
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
            <input type="text" value="{{ $profile->mname }}" class="form-control" name="mi">
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
            <input type="text" class="form-control" name="respondent">
        </td>
        <td colspan="3">
            <small>Contact No</small>
            <input type="text" class="form-control" name="contact_no">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small><b>Address</b></small><br>
            <small>House No. & Street Name</small>
            <input type="text" class="form-control" name="house_and_street">
        </td>
        <td>
            <br>
            <small>Sitio/Purok</small>
            <input type="text" class="form-control" name="purok">
        </td>
        <td >
            <br>
            <small>Barangay</small>
            <select name="barangay" class="form-control">
                @foreach(\App\Barangay::get() as $row)
                    <option value="{{ $row->id }}" <?php if($row->id == $profile->barangay_id)echo 'selected'; ?> >{{ $row->description }}</option>
                @endforeach
            </select>
        </td>
        <td >
            <br>
            <small>Municipality</small>
            <select name="municipality" class="form-control">
                @foreach(\App\Muncity::get() as $row)
                    <option value="{{ $row->id }}" <?php if($row->id == $profile->muncity_id)echo 'selected'; ?> >{{ $row->description }}</option>
                @endforeach
            </select>
        </td>
        <td >
            <br>
            <small>Province</small>
            <select name="province" class="form-control">
                @foreach(\App\Province::get() as $row)
                    <option value="{{ $row->id }}" <?php if($row->id == $profile->province_id)echo 'selected'; ?> >{{ $row->description }}</option>
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
            <input type="radio" name="religion" value="rc"> RC
        </td>
        <td>
            <br>
            <input type="radio" name="religion" value="christian"> Christian
        </td>
        <td>
            <br>
            <input type="radio" name="religion" value="inc"> INC
        </td>
        <td>
            <br>
            <input type="radio" name="religion" value="islam"> Islam
        </td>
        <td>
            <br>
            <input type="radio" name="religion" value="jehovah"> Jehovah
        </td>
        <td>
            <br>
            <small>Others, specify</small>
            <input type="text">
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
            <input type="text" name="birthplace" class="form-control">
        </td>
        <td >
            <small>Yrs. at Current Address</small>
            <input type="text" name="yrs_current_address" class="form-control">
        </td>
    </tr>
</table>
<small class="label bg-green">LEVEL OF EDUCATION</small>
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
<small class="label bg-green" >PHIC MEMBERSHIP OF PRINCIPAL(PARENTS)</small>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <small><b>Status</b></small><br>
            <input type="radio" value="member" name="phic_status"> Member
        </td>
        <td>
            <br>
            <input type="radio" value="dependent" name="phic_status"> Dependent
        </td>
        <td>
            <br>
            <input type="radio" value="non_member" name="phic_status"> Non-Member
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <small><b>Type</b></small><br>
            <input type="radio" value="lifetime" name="phic_type"> Lifetime<br>
        </td>
        <td>
            <br>
            <input type="radio" value="sponsored" name="phic_type"> Sponsored Specify:
        </td>
        <td>
            <br>
            <input type="checkbox" value="doh" name="phic_sponsored[]"> DOH
        </td>
        <td>
            <br>
            <input type="checkbox" value="plgu" name="phic_sponsored[]"> PLGU
        </td>
        <td>
            <br>
            <input type="checkbox" value="mlgu" name="phic_sponsored[]"> MLGU
        </td>
        <td>
            <br>
            <input type="checkbox" value="private" name="phic_sponsored[]"> Private
        </td>
        <td>
            <br>
            <input type="checkbox" value="others" name="phic_sponsored[]"> Others, specify: <input type="text" name="phic_sponsored_others">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <small><b>Employed</b></small><br>
            <input type="radio" value="government" name="phic_employed"> Government
        </td>
        <td>
            <br>
            <input type="radio" value="private" name="phic_employed"> Private
        </td>
        <td>
            <br>
            <input type="radio" value="self_employed" name="phic_employed"> Self-Employed
        </td>
        <td >
            <small><b>Are you aware of your PHIC benefits?</b></small><br>
            <select name="phic_benefits" class="form-control">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </td>
        <td>
            <br>
            If yes, specify: <input name="phic_benefits_yes" type="text">
        </td>
    </tr>
</table>

<label class="text-green">FAMILY HISTORY(Among mother, father, and siblings. Tick all that apply)</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="allergy" name="family_history[]"> Allergy, specify:
            <input type="text" name="family_history_allergy">
        </td>
        <td>
            <input type="checkbox" value="epilepsy" name="family_history[]"> Epilepsy/Seizure Disorder, specify:
            <input type="text" name="family_history_epilepsy">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="heart_disease" name="family_history[]"> Heart Disease &/ or Hearth Attack, specify:
            <input type="text" name="family_history_heart">
        </td>
        <td>
            <input type="checkbox" value="cancer" name="family_history[]"> Cancer, specify organ:
            <input type="text" name="family_history_cancer">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="immune_deficiency" name="family_history[]"> Immune Deficiency Disease, specify:
            <input type="text" name="family_history_immune">
        </td>
        <td colspan="3">
            <input type="checkbox" value="kidney_disease" name="family_history[]"> Kidney Disease, specify:
            <input type="text" name="family_history_kidney">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px;">
    <tr>
        <td>
            <input type="checkbox" value="mental_health_condition" name="family_history[]"> Mental Health Condition
        </td>
        <td>
            <input type="checkbox" value="asthma" name="family_history[]"> Asthma
        </td>
        <td>
            <input type="checkbox" value="thyroid_disease" name="family_history[]"> Thyroid Disease
        </td>
        <td>
            <input type="checkbox" value="tuberculosis" name="family_history[]"> Tuberculosis
        </td>
    </tr>
</table>
<small class="label bg-green" >MEDICAL HISTORY OF VACCINEE(Tick all past and present health conditions of the vaccinee.)</small>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="allergy" name="medical_history[]"> Allergy, specify:
            <input type="text" name="medical_history_allergy">
        </td>
        <td>
            <input type="checkbox" value="epilepsy" name="medical_history[]"> Epilepsy/Seizure Disorder, specify:
            <input type="text" name="medical_history_epilepsy">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="kidney_disease" name="medical_history[]"> Kidney Disease, specify:
            <input type="text" name="medical_history_kidney">
        </td>
        <td>
            <input type="checkbox" value="immune_deficiency" name="medical_history[]"> Immune Deficiency Disease, specify:
            <input type="text" name="medical_history_immune">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="hepatitis" name="medical_history[]"> Hepatitis, specify
            <input type="text" name="medical_history_hepatitis">
        </td>
        <td>
            <input type="checkbox" value="heart_disease" name="medical_history[]"> Heart Disease, specify:
            <input type="text" name="medical_history_heart">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="poisoning" name="medical_history[]"> Poisoning, specify:
            <input type="text" name="medical_history_poisoning">
        </td>
        <td>
            <input type="checkbox" value="sti" name="medical_history[]"> STIs, specify:
            <input type="text" name="medical_history_sti">
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="thyroid_disease" name="medical_history[]"> Thyroid Disease, specify:
            <input type="text" name="medical_history_thyroid">
        </td>
        <td>
            <input type="checkbox" value="cancer" name="medical_history[]"> Cancer, specify organ:
            <input type="text" name="medical_history_cancer">
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <input type="checkbox" value="asthma" name="medical_history[]"> Asthma (Fill-up Brochial Asthma Section)
        </td>
        <td>
            <input type="checkbox" value="tuberculosis" name="medical_history[]"> Tuberculosis(If yes, fill-up Tuberculosis Section)
        </td>
        <td>
            <input type="checkbox" value="peptic_ulcer" name="medical_history[]"> Peptic Ulcer Disease
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="diabetes" name="medical_history[]"> Diabetes mellitus (Fill-up Diabetes Mellitus Section)
        </td>
        <td>
            <input type="checkbox" value="urinary" name="medical_history[]"> Urinary Tract Infections
        </td>
        <td>
            <input type="checkbox" value="malaria" name="medical_history[]"> Malaria
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="pneumonia" name="medical_history[]"> Pneumonia
        </td>
        <td colspan="2">
            <input type="checkbox" value="others" name="medical_history_check"> Others, specify:
            <input type="text" name="medical_history_others">
        </td>
    </tr>
</table>