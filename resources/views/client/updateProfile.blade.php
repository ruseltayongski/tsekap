<?php
use App\Barangay;
use App\FamilyProfile;
use App\Profile;
use App\UserBrgy;

$brgy = Barangay::where('muncity_id',Auth::user()->muncity);

if(Auth::user()->user_priv==2){
    $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
    $brgy = $brgy->where(function($q) use ($tmpBrgy){
        foreach($tmpBrgy as $tmp){
            $q->orwhere('id',$tmp->barangay_id);
        }
    });
    if(count($tmpBrgy)==0){
        $brgy = $brgy->where('id',0);
    }
}
$brgy = $brgy->orderBy('description','asc')
        ->get();
?>
@extends('client')
@section('content')
    <style>
        .table tr td:first-child {
            background: #f5f5f5;
            text-align: right;
            vertical-align: middle;
            font-weight: bold;
            padding: 3px;
            width:30%;
        }
        .table tr td {
            border:1px solid #bbb !important;
        }
        .help-block {
            font-weight:bold;
        }
        .btn {
            margin: 5px 0;
        }

    </style>

    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">
                <i class="fa fa-user"></i>
                Profile Details
            </h2>
            <div class="page-divider"></div>
            <form method="POST" class="form-horizontal form-submit" id="form-submit" action="{{ asset('user/population/update') }}">
                {{ csrf_field() }}
                <table class="table table-bordered table-hover" border="1">
                    <input type="hidden" name="currentID" value="{{ $info->profile_id }}" />
                    <input type="hidden" name="unique_id" value="{{ $info->unique_id }}" />
                    <tr>
                        <td>Family Profile ID :</td>
                        <input type="hidden" name="familyName" value="{{ $info->familyID }}" />
                        <td><input type="text" value="{{ $info->familyID }}" class="form-control" readonly /> </td>
                    </tr>
                    <tr>
                        <td>PhilHealth ID :<br/> <small class="text-info"><em>(If applicable)</em></small></td>
                        <td><input type="text" value="{{ $info->phicID }}" name="phicID" class="form-control" value="" /></td>
                    </tr>
                    <tr>
                        <td>NHTS ID :<br/> <small class="text-info"><em>(If applicable)</em></small></td>
                        <td><input type="text" value="{{ $info->nhtsID }}" name="nhtsID" class="form-control" value="" /></td>
                    </tr>
                    <tr class="has-group">
                        <td>Family Head? :</td>
                        <td>
                            <select name="head" id="head" class="form-control required" style="width: 100%" required>
                                <option value="">Select...</option>
                                <option <?php if($info->head=='YES') echo 'selected'; ?> value="YES">YES</option>
                                <option <?php if($info->head=='NO') echo 'selected'; ?> value="NO">NO</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="relation <?php if($info->head=='YES') echo 'hide'; ?> has-group" >
                        <td>Relation to Head :</td>
                        <td>
                            <select name="relation" onchange="changeGender($(this))" id="relation" class="form-control chosen-select" style="width: 100%">
                                <option value="">Select...</option>
                                <option <?php if($info->relation=='Son') echo 'selected'; ?>>Son</option>
                                <option <?php if($info->relation=='Daughter') echo 'selected'; ?>>Daughter</option>
                                <option <?php if($info->relation=='Wife') echo 'selected'; ?>>Wife</option>
                                <option <?php if($info->relation=='Husband') echo 'selected'; ?>>Husband</option>
                                <option <?php if($info->relation=='Father') echo 'selected'; ?>>Father</option>
                                <option <?php if($info->relation=='Mother') echo 'selected'; ?>>Mother</option>
                                <option <?php if($info->relation=='Brother') echo 'selected'; ?>>Brother</option>
                                <option <?php if($info->relation=='Sister') echo 'selected'; ?>>Sister</option>
                                <option <?php if($info->relation=='Nephew') echo 'selected'; ?>>Nephew</option>
                                <option <?php if($info->relation=='Niece') echo 'selected'; ?>>Niece</option>
                                <option <?php if($info->relation=='Grandfather') echo 'selected'; ?>>Grandfather</option>
                                <option <?php if($info->relation=='Grandmother') echo 'selected'; ?>>Grandmother</option>
                                <option <?php if($info->relation=='Grandson') echo 'selected'; ?>>Grandson</option>
                                <option <?php if($info->relation=='Granddaughter') echo 'selected'; ?>>Granddaughter</option>
                                <option <?php if($info->relation=='Cousin') echo 'selected'; ?>>Cousin</option>
                                <option <?php if($info->relation=='Relative') echo 'selected'; ?>>Relative</option>
                                <option <?php if($info->relation=='Daughter in Law') echo 'selected'; ?>>Daughter in Law</option>
                                <option <?php if($info->relation=='Son in Law') echo 'selected'; ?>>Son in Law</option>
                                <option <?php if($info->relation=='Sister in Law') echo 'selected'; ?>>Sister in Law</option>
                                <option <?php if($info->relation=='Brother in Law') echo 'selected'; ?>>Brother in Law</option>
                                <option <?php if($info->relation=='Father in Law') echo 'selected'; ?>>Father in Law</option>
                                <option <?php if($info->relation=='Mother in Law') echo 'selected'; ?>>Mother in Law</option>
                                <option <?php if($info->relation=='partner') echo 'selected'; ?>>Live-in Partner</option>
                                <option <?php if($info->relation=='Deceased') echo 'selected'; ?>>Deceased</option>
                                <option <?php if($info->relation=='Others') echo 'selected'; ?>>Others</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>First Name :</td>
                        <td><input type="text" name="fname" value="{{ $info->fname }}" class="form-control" required /> </td>
                    </tr>
                    <tr>
                        <td>Middle Name :</td>
                        <td><input type="text" name="mname" value="{{$info->mname }}" class="form-control" /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Last Name :</td>
                        <td><input type="text" name="lname" value="{{$info->lname}}" class="form-control" required /> </td>
                    </tr>
                    <tr>
                        <td>Suffix :</td>
                        <td>
                            <select name="suffix" class="form-control chosen-select" id="suffix" style="width: 100%">
                                <option value="">Select...</option>
                                <option <?php if($info->suffix=='Jr.') echo 'selected'; ?>>Jr.</option>
                                <option <?php if($info->suffix=='Sr.') echo 'selected'; ?>>Sr.</option>
                                <option <?php if($info->suffix=='I') echo 'selected'; ?>>I</option>
                                <option <?php if($info->suffix=='II') echo 'selected'; ?>>II</option>
                                <option <?php if($info->suffix=='III') echo 'selected'; ?>>III</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Contact Number :</td>
                        <td><input type="text" name="contact" class="form-control" value="{{ $info->contact }}"/> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Birth Date :</td>
                        <td><input type="date" name="dob" onkeyup="calculateAge()" onkeypress="calculateAge()" onblur="calculateAge()" id="dob" class="form-control" value="{{ $info->dob }}" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Birth Place :</td>
                        <td><input type="text" name="birth_place" class="form-control" value="{{ $info->birth_place }}" required /> </td>
                    </tr>
                    <tr>
                        <td>Sex :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input onclick="calculateAge()" type="radio" <?php if($info->sex=='Male') echo 'checked'; ?> name="sex" class="sex" value="Male" required style="display:inline;"> Male</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input onclick="calculateAge()" type="radio" <?php if($info->sex=='Female') echo 'checked'; ?> name="sex" class="sex" value="Female" required> Female</label>
                            <span class="span"></span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Height <i>(cm)</i>:</td>
                        <td>
                            <span><input type="number" name="height" class="form-control" value="{{ $info->height }}" style="width: 30%" /></span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Weight <i>(kg)</i>:</td>
                        <td>
                            <span><input type="number" name="weight" class="form-control" value="{{ $info->weight }}" style="width: 30%" /></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Civil Status :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->civil_status=='Single') echo 'checked'; ?> name="civil_status" class="civil_status" value="Single" style="display:inline;"> Single</label> &emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->civil_status=='Married') echo 'checked'; ?> name="civil_status" class="civil_status" value="Married" > Married</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->civil_status=='Divorced') echo 'checked'; ?> name="civil_status" class="civil_status" value="Divorced" > Divorced</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->civil_status=='Separated') echo 'checked'; ?> name="civil_status" class="civil_status" value="Separated" > Separated</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->civil_status=='Widowed') echo 'checked'; ?> name="civil_status" class="civil_status" value="Widowed" > Widowed</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->civil_status=='Annulled') echo 'checked'; ?> name="civil_status" class="civil_status" value="Annulled" > Annulled</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Religion Status : <br><br><br><br></td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->religion=='RC') echo 'checked'; ?> name="religion" class="religion" value="RC" style="display:inline;"> RC</label> &emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->religion=='Christian') echo 'checked'; ?> name="religion" class="religion" value="Christian" > Christian</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->religion=='INC') echo 'checked'; ?> name="religion" class="religion" value="INC" > INC</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->religion=='Islam') echo 'checked'; ?> name="religion" class="religion" value="Islam" > Islam</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->religion=='Jehovah') echo 'checked'; ?> name="religion" class="religion" value="Jehovah" > Jehovah</label><br/>
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->religion=='other') echo 'checked'; ?> name="religion" class="religion" value="other" > Others: <i>(specify)</i></label><br/>
                            <span class="other_religion"><?php if($info->religion=='other') echo "<input type='text' style='width:50%;' name='other_religion' value='$info->other_religion' class='form-control'/>";?> </span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Barangay :</td>
                        <td>
                            <select name="barangay" class="form-control chosen-select" required id="suffix" style="width: 100%">
                                <option value="">Select...</option>
                                @foreach($brgy as $row)
                                <option <?php if($info->barangay_id==$row->id) echo 'selected'; ?> value="{{ $row->id }}">{{ $row->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <?php $validBrgy = \App\Http\Controllers\UserCtrl::validateBrgy();?>
                    @if($validBrgy)
                    <tr class="head">
                        <td>Monthly Family Income :</td>
                        <td>
                            <select name="income" class="form-control chosen-select" id="income" style="width: 100%">
                                <option value="">Select...</option>
                                <option value="1" {{ ($info->income==1) ? 'selected':null }}>Less than 7,890</option>
                                <option value="2" {{ ($info->income==2) ? 'selected':null }}>Between 7,890 to 15,780</option>
                                <option value="3" {{ ($info->income==3) ? 'selected':null }}>Between 15,780 to 31,560</option>
                                <option value="4" {{ ($info->income==4) ? 'selected':null }}>Between 31,560 to 78,900</option>
                                <option value="5" {{ ($info->income==5) ? 'selected':null }}>Between 78,900 to 118,350</option>
                                <option value="6" {{ ($info->income==6) ? 'selected':null }}>Between 118,350 to 157,800</option>
                                <option value="7" {{ ($info->income==7) ? 'selected':null }}>At least 157,800</option>
                                <option value="8" {{ ($info->income==8) ? 'selected':null }}>Unable to provide</option>
                            </select>
                        </td>
                    </tr>
                    <?php
                    $age = \App\Http\Controllers\ParameterCtrl::getAge($info->dob);
                    $class = 'hide';
                    if($age>13 && $age<50){
                        $class = '';
                    }
                    ?>
                    <tr class="head">
                        <td>Safe Water Supply :</td>
                        <td>
                            <input type="hidden" name="water" id="water" value="{{ $info->water }}"  />
                            <div class="form-inline">
                                <input type="text" id="water2" class="form-control" readonly value="{{ ($info->water!=0) ? 'Level '.$info->water : 'Not set' }}" data-toggle="modal" data-target="#waterLvl" />
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#waterLvl">Select...</button>
                            </div>

                        </td>
                    </tr>
                    <tr class="head">
                        <td>Sanitary Toilet :</td>
                        <td>
                            <select name="toilet" class="form-control chosen-select" id="toilet" style="width: 100%">
                                <option value="">Select...</option>
                                <option value="non" {{ ($info->toilet=='non') ? 'selected':null }}>None</option>
                                <option value="comm" {{ ($info->toilet=='comm') ? 'selected':null }}>Communal</option>
                                <option value="indi" {{ ($info->toilet=='indi') ? 'selected':null }}>Individual Household</option>
                            </select>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Educational Attainment :</td>
                        <td>
                            <select name="education" class="form-control chosen-select" id="education" style="width: 100%">
                                <option value="">Select...</option>
                                <option value="non" {{ ($info->education=='non') ? 'selected':null }}>No Education</option>
                                <option value="elem" {{ ($info->education=='elem') ? 'selected':null }}>Elementary Level</option>
                                <option value="elem_grad" {{ ($info->education=='elem_grad') ? 'selected':null }}>Elementary Graduate</option>
                                <option value="high" {{ ($info->education=='high') ? 'selected':null }}>High School Level</option>
                                <option value="high_grad" {{ ($info->education=='high_grad') ? 'selected':null }}>High School Graduate</option>
                                <option value="college" {{ ($info->education=='college') ? 'selected':null }}>College Level</option>
                                <option value="college_grad" {{ ($info->education=='college_grad') ? 'selected':null }}>College Graduate</option>
                                <option value="vocational" {{ ($info->education=='vocational') ? 'selected':null }}>Vocational Course</option>
                                <option value="master" {{ ($info->education=='master') ? 'selected':null }}>Masteral Degree</option>
                                <option value="unable_provide" {{ ($info->education=='unable_provide') ? 'selected':null }}>Unable to provide</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Diagnosed with Cancer :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->cancer=='yes') echo 'checked'; ?> name="cancer" class="cancer" value="yes" style="display:inline;"> Yes </label>
                            &emsp;<span class="cancer_type"><?php if($info->cancer=='yes') echo"Type: <input type='text' value='$info->cancer_type' name='cancer_type' style='width:50%;'>";?></span> <br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->cancer=='no') echo 'checked'; ?> name="cancer" class="cancer" value="no"> No </label>
                        </td>
                    </tr>
                    <tr class="hypertensionClass hide">
                        <td>Hypertension :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->hypertension=='Medication Avail') echo 'checked'; ?> name="hypertension" class="hypertension" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->hypertension=='No Medication Avail') echo 'checked'; ?> name="hypertension" class="hypertension" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr class="diabetesClass hide">
                        <td>Diabetic :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->diabetic=='Medication Avail') echo 'checked'; ?> name="diabetic" class="diabetic" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->diabetic=='No Medication Avail') echo 'checked'; ?> name="diabetic" class="diabetic" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Mental Health Medication :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->mental_med=='Medication Avail') echo 'checked'; ?> name="mental_med" class="mental_med" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->mental_med=='No Medication Avail') echo 'checked'; ?> name="mental_med" class="mental_med" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr>
                        <td>TBDOTS Availment :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->tbdots_med=='Medication Avail') echo 'checked'; ?> name="tbdots_med" class="tbdots_med" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->tbdots_med=='No Medication Avail') echo 'checked'; ?> name="tbdots_med" class="tbdots_med" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr>
                        <td>CVD Medication :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->cvd_med=='Medication Avail') echo 'checked'; ?> name="cvd_med" class="cvd_med" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->cvd_med=='No Medication Avail') echo 'checked'; ?> name="cvd_med" class="cvd_med" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Covid Status :</td>
                        <td><input type="text" name="covid_status" value="{{ $info->covid_status }}" class="form-control"/> </td>
                    </tr>
                    <tr class="menarcheClass hide">
                        <td>Menarche :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input <?php if($info->menarche=='yes') echo 'checked'; ?> onclick="showMenarche()" type="radio" name="menarche" class="menarche_yes" value="yes" style="display:inline;"> Yes</label>
                            &emsp;<span class="menarche_age"><?php if($info->menarche=='yes') echo"Age of Menarche: <input type='number' value='$info->menarche_age' name='menarche_age' style='width:30%;' min='9'>";?></span><br/>
                            <label style="cursor: pointer;"><input <?php if($info->menarche=='no') echo 'checked'; ?> onclick="showMenarche()" type="radio" name="menarche" class="menarche_no" value="no"> No</label>&emsp;

                        </td>
                    </tr>
                    <tr class="sexuallyActiveClass hide">
                        <td>Sexually Active :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->sexually_active=='yes') echo 'checked'; ?> name="sexually_active" class="sexually_active" value="yes" style="display:inline;"> Yes </label><br>
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->sexually_active=='no') echo 'checked'; ?> name="sexually_active" class="sexually_active" value="no"> No </label>
                        </td>
                    </tr>
                    <tr class="has-group unmetClass hide">
                        <td>Unmet Need :</td>
                        <td>
                            <input type="hidden" name="unmet" id="unmet" value="{{ $info->unmet }}"  />
                            <?php
                            $unmet = ($info->unmet!=0) ? 'Option '.$info->unmet : 'Not set';
                            ?>
                            <div class="form-inline">
                                <input type="text" id="unmet2" class="form-control" readonly value="{{ ($info->unmet!=0) ? 'Option '.$info->unmet : 'Not set' }}" data-toggle="modal" data-target="#unmetNeed" />
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#unmetNeed">Yes</button>
                                <button type="button" class="btn btn-warning" onclick="unmet_need()"> No </button>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>PWD :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->pwd=="yes") echo "checked"; ?> name="pwd" class="pwd" value="yes" style="display:inline;"> Yes</label>
                            &emsp;<span class="pwd_description"><?php if($info->pwd=='yes') echo"Specify: <input type='text' value='$info->pwd_desc' name='pwd_desc' style='width:60%;'>";?></span><br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->pwd=="no") echo "checked"; ?> name="pwd" class="pwd" value="no" > No</label>
                        </td>
                    </tr>
                    <tr class="nutritionClass hide">
                        <td>Nutrition Status :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input class="form-check-input nutri_deworm" name="nutri_stat[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Deworming"> Deworming </label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input nutri_vitamina" name="nutri_stat[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Vitamin A Supplement"> Vitamin A Supplement</label>&emsp;
                        </td>
                    </tr>
                    <tr class="immuClass hide">
                        <td>Immunization Status: <br><br><br><br><br><br><br><br><br></td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input class="form-check-input immu_bcg" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="BCG"> BCG </label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input immu_hepb" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="HEP B"> HEP B</label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input immu_penta1" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Penta 1"> Penta 1</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input immu_penta2" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Penta 2"> Penta 2</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input immu_penta3" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Penta 3"> Penta 3</label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input immu_opv1" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="OPV 1"> OPV 1</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input immu_opv2" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="OPV 2"> OPV 2</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input immu_opv3" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="OPV 3"> OPV 3</label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input immu_ipv1" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="IPV 1"> IPV 1</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input immu_ipv2" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="IPV 2"> IPV 2</label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input immu_mmr1" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="MMR 1"> MMR 1</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input immu_mmr2" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="MMR 2"> MMR 2</label>&emsp;
                        </td>
                    </tr>
                    <tr class="newbornClass hide">
                        <td>Newborn Screening :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->newborn_screen=='yes') echo 'checked'; ?> onclick="showNewborn()" name="newborn_screen" value="yes" style="display:inline;"> Yes</label>
                            &emsp; <span class="newbornYes"><?php if($info->newborn_screen=='yes') echo"Result: <input type='text' value='$info->newborn_text' name='newborn_text' style='width:50%;'>";?></span> <br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->newborn_screen=='no') echo 'checked'; ?> onclick="showNewborn()" name="newborn_screen" value="no" > No</label>
                        </td>
                    </tr>
                    <tr class="has-group hide pregnant_lmp">
                        <td>Pregnant Date LMP:</td>
                        <td><input type="date" value="{{ $info->pregnant }}" name="pregnant" class="form-control" /> </td>
                    </tr>
                    <tr>
                        <td><span class="text-red">Deceased : </span></td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->deceased=="yes") echo "checked"; ?> name="deceased" value="yes" style="display:inline;"> Yes</label>
                            &emsp;<span class="deceased_date"><?php if($info->deceased=='yes') echo"Date of Death: <input value='$info->deceased_date' type='date' name='deceased_date' style='width:30%;' min='1910-05-11'>";?></span><br />
                            <label style="cursor: pointer;"><input type="radio" <?php if($info->deceased=="no") echo "checked"; ?> name="deceased" value="no" > No</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="pull-right">
                                <a href="{{ asset('user/population') }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
{{--                                @if(in_array(Date("F"), array("April","August","December","June"), true))--}}
                                <button type="submit" class="btn btn-success btn-sm" name="update" value="1">
                                    <i class="fa fa-pencil"></i> Update
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-target="#remove" data-toggle="modal">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fa fa-arrow-right"></i> Proceed to EMR
                                </button>
                                {{--@endif--}}
                                <a href="{{ asset('deng/form') }}" type="button" class="btn btn-primary btn-sm">
                                    <i class="fa fa-user-md"></i> Proceed to dengvaxia
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    @include('sidebar')
    @include('modal.profile')
    @include('modal.link')
@endsection

@section('js')
    @include('script.profile')

    <script>
        var head = $('#head').val();
        removeRequired(head);
        $('#head').on("change",function(){
            var head = $(this).val();
            removeRequired(head);
        });

        function removeRequired(head){
            if(head=='NO'){
                $('.relation').removeClass('hide');
                $('#relation').attr('required',true);

                $('.head').addClass('hide');
            }else{
                $('.relation').addClass('hide');
                $('#relation').removeAttr('required');
                $('.head').removeClass('hide');
            }
        }
    </script>
    <script>
        function changeGender(form){
            var gender = form.val();
            $("input[name=sex]").prop('checked',false);
            if(gender == 'Son' || gender == 'Husband' || gender == 'Father' || gender == 'Brother' || gender == 'Nephew' || gender == 'Grandfather' || gender == 'Grandson' || gender == 'Brother in Law' || gender == 'Son in Law' || gender == 'Father in Law')
            {
                gender = 'Male';
            }
            else if(gender == 'Daughter' || gender == 'Wife' || gender == 'Mother' || gender == 'Sister' || gender == 'Niece' || gender == 'Grandmother' || gender == 'Granddaughter' || gender == 'Sister in Law' || gender == 'Daughter in Law' || gender == 'Mother in Law')
            {
                gender = 'Female';
            }
            console.log(gender);
            $("input[name=sex][value=" + gender + "]").prop('checked',true);
        }

        $('a[href="#dengvaxia"]').on('click',function(){
            var id = $(this).data('id');
            var unique_id = $(this).data('unique');
            var url = "{{ asset('verify_dengvaxia') }}"+"/"+id+"/"+unique_id;
            $('.verify-dengvaxia').html('<center><img src="<?php echo asset('resources/img/spin.gif');?>" width="100"></center>');
            console.log(url);
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(result){
                        $('.verify-dengvaxia').html(result);
                    }
                });
            },300);
        });

    </script>
@endsection