<?php
use App\Barangay;
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
$last = Profile::orderBy('id','desc')->first();
$ctrlNo = date('His');
$ctrlNo = str_pad($ctrlNo, 4, '0', STR_PAD_LEFT);
$brgyNo = str_pad(Auth::user()->barangay, 4, '0', STR_PAD_LEFT);
$idNo = str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);
//$profileID = $muncityNo.'-'.$brgyNo.'-'.$ctrlNo;
$profileID = date('mdy').'-'.$idNo.'-'.$ctrlNo;
$today = date('Y-m-d');
?>
@extends('client')
@section('content')
    <style>
        .table-input tr td:first-child {
            background: #f5f5f5;
            text-align: right;
            vertical-align: middle;
            font-weight: bold;
            padding: 3px;
            width:30%;
        }
        .table-input tr td {
            border:1px solid #bbb !important;
        }
    </style>
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">
                <i class="fa fa-user-plus"></i>
                Add Family Head
            </h2>
            <div class="page-divider"></div>
            <form method="POST" class="form-horizontal form-submit" id="form-submit" action="{{ asset('user/population/head/save') }}">
                {{ csrf_field() }}
                <table class="table-input table table-bordered table-hover" border="1">
                    <tr>
                        <td>Family Profile ID :</td>
                        <td><input type="text" name="familyProfile" readonly class="form-control" value="{{ $profileID }}" required /></td>
                    </tr>
                    <tr>
                        <td>Household No. :</td>
                        <td><input type="text" name="household_num" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>PhilHealth Category :<br><small class="text-info"><i>(if applicable)</i></small></td>
                        <td>
                            <select class="form-control select2" name="philhealth_categ">
                                <option value="">Select...</option>
                                <option value="direct">Direct Contributors</option>
                                <option value="indirect">Indirect Contributors</option>
                                <option value="unknown">Unknown</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>PhilHealth ID :<br/> <small class="text-info"><em>(If applicable)</em></small></td>
                        <td><input type="text" name="phicID" class="form-control" value="" /></td>
                    </tr>
                    <tr>
                        {{--<td>NHTS ID :<br/> <small class="text-info"><em>(If applicable)</em></small></td>--}}
                        {{--<td><input type="text" name="nhtsID" class="form-control" value="" /></td>--}}
                        <td>Beneficiaries :<br><small class="text-info"><em>(Check applicable)</em></small></td>
                        <td>
                            <div class="col-md-6">
                                <label style="font-size: 110%"><input class="form-check-input" style="height: 20px;width: 20px;cursor: pointer;" type="checkbox" name="nhts" value="yes">&nbsp; NHTS  </label>&emsp;&emsp;
                                <label style="font-size: 110%"><input class="form-check-input" style="height: 20px;width: 20px;cursor: pointer;" type="checkbox" name="four_ps" id="4ps" value="yes">&nbsp; 4Ps</label>&emsp;&emsp;
                                <label style="font-size: 110%"><input class="form-check-input" style="height: 20px;width: 20px;cursor: pointer;" type="checkbox" name="ip" value="yes">&nbsp; IP</label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="fourps_num" id="4ps_num" placeholder="(4Ps number)">
                            </div>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>First Name <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td>
                            <input type="text" name="fname" class="fname form-control" required />
                            <small class="text-red" id="fname_warning"><br>This field is required.</small>
                        </td>
                    </tr>
                    <tr>
                        <td>Middle Name <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td>
                            <input type="text" name="mname" class="mname form-control" required />
                            <small class="text-red" id="mname_warning"><br>This field is required.</small>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Last Name <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td>
                            <input type="text" name="lname" class="lname form-control" required />
                            <small class="text-red" id="lname_warning"><br>This field is required.</small>
                        </td>
                    </tr>
                    <tr>
                        <td>Suffix :</td>
                        <td>
                            <select name="suffix" class="form-control chosen-select" id="suffix" style="width: 100%">
                                <option value="">Select...</option>
                                <option>Jr.</option>
                                <option>Sr.</option>
                                <option>I</option>
                                <option>II</option>
                                <option>III</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Contact Number :</td>
                        <td><input type="text" name="contact" class="form-control" /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Birth Date <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td>
                            <input type="date" name="dob" onchange="calculateAge()" id="dob" max="{{ $today }}" class="form-control" required />
                            <small class="text-red" id="dob_warning">This field is required.</small>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Birth Place :</td>
                        <td>
                            <input type="text" name="birth_place" class="form-control birth_place" />
                        </td>
                    </tr>
                    <tr>
                        <td>Sex <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input onclick="showUnmet()" type="radio" name="sex" class="sex" value="Male" required style="display:inline;"> Male</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input onclick="showUnmet()" type="radio" name="sex" class="sex" value="Female" required> Female</label>
                            <span class="span"></span>
                            <small class="text-red" id="sex_warning"><br>This field is required.</small>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Height <i>(cm)</i>:</td>
                        <td>
                            <span><input type="number" name="height" class="form-control" min="0" style="width: 25%"/></span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Weight <i>(kg)</i>:</td>
                        <td>
                            <span><input type="number" name="weight" class="form-control" min="0" style="width: 25%"/></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Civil Status <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Single" style="display:inline;"> Single</label> &emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Married" style="display:inline;"> Married</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Live-in" style="display:inline;"> Live-in</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Widowed" style="display:inline;"> Widowed</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Cohabitation" style="display:inline;"> Cohabitation</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Separated" style="display:inline;"> Separated</label>&emsp;
                            <span class="text-red" id="cs_warning"><br>This field is required.</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Religion <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td>
                            <select name="religion" class="form-control chosen-select" id="religion" style="width: 100%">
                                <option value="">Select...</option>
                                <option value="RC">Roman Catholic</option>
                                <option>Christian</option>
                                <option value="inc">Iglesia ni Cristo</option>
                                <option>Catholic</option>
                                <option>Islam</option>
                                <option>Baptist</option>
                                <option value="born_again">Born Again Christian</option>
                                <option>Buddhism</option>
                                <option value="cog">Church of God</option>
                                <option value="jehovas">Jehova's Witness</option>
                                <option>Protestant</option>
                                <option value="adventist">Seventh Day Adventist</option>
                                <option value="mormons">LDS-Mormons</option>
                                <option>Evangelical</option>
                                <option>Pentecostal</option>
                                <option>Unknown</option>
                                <option value="other">Others <i>(specify)</i></option>
                            </select>
                            <span class="other_religion"></span>
                            <span class="text-red" id="religion_warning"><br>This field is required.</span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Barangay <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td>
                            <select name="barangay_id" class="form-control chosen-select" required id="brgy" style="width: 100%">
                                <option value="">Select...</option>
                                @foreach($brgy as $row)
                                <option value="{{ $row->id }}">{{ $row->description }}</option>
                                @endforeach
                            </select>
                            <small class="text-red" id="brgy_warning"><br>This field is required.</small>
                        </td>
                    </tr>
                    <?php $validBrgy = \App\Http\Controllers\UserCtrl::validateBrgy();?>
                    @if($validBrgy)
                    <tr>
                        <td>Monthly Family Income :</td>
                        <td>
                            <select name="income" class="form-control chosen-select" id="income" style="width: 100%">
                                <option value="">Select...</option>
                                <option value="1">Less than 7,890</option>
                                <option value="2">Between 7,890 to 15,780</option>
                                <option value="3">Between 15,780 to 31,560</option>
                                <option value="4">Between 31,560 to 78,900</option>
                                <option value="5">Between 78,900 to 118,350</option>
                                <option value="6">Between 118,350 to 157,800</option>
                                <option value="7">At least 157,800</option>
                                <option value="8">Unable to provide</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Safe Water Supply <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td>
                            <input type="hidden" name="water" id="water" />
                            <div class="form-inline">
                                <input type="text" id="water2" class="form-control" readonly value="Not set" data-toggle="modal" data-target="#waterLvl" />
                                <button type="button" style="margin:5px 0;" class="btn btn-info" data-toggle="modal" data-target="#waterLvl">Select...</button>
                            </div>
                            <small class="text-red" id="water_warning"><br>This field is required.</small>
                        </td>
                    </tr>
                    <tr>
                        <td>Sanitary Toilet <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        <td>
                            <select name="toilet" class="form-control chosen-select" id="toilet" style="width: 100%" required>
                                <option value="">Select...</option>
                                <option value="non">None/Without Toilet</option>
                                {{--<option value="comm">Communal</option>--}}
                                {{--<option value="indi">Individual Household</option>--}}
                                <option value="septic">Pour/flush toilet connected to septic tank</option>
                                <option value="sewage">Pour/flush toilet connected to connected to septic tank AND to sewerage system</option>
                                <option value="compost">Ventilated improved pit latrine (VIP) or Composting toilet</option>
                                <option value="open_drain">Water-sealed connected to open drain</option>
                                <option value="overhung_l">Overhung Latrine</option>
                                <option value="openpit_l">Open-pit Latrine</option>
                            </select>
                            <small class="text-red" id="toilet_warning"><br>This field is required.</small>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Educational Attainment :</td>
                        <td>
                            <select name="education" class="form-control chosen-select" id="education" style="width: 100%">
                                <option value="">Select...</option>
                                <option value="non">No Education</option>
                                <option value="preschool">Preschool</option>
                                <option value="elem_stud">Elementary Student</option>
                                <option value="elem_undergrad">Elementary Undergraduate</option>
                                <option value="elem">Elementary Graduate</option>
                                <option value="high_stud">High School Student</option>
                                <option value="high_undergrad">High School Undergraduate</option>
                                <option value="high">High School Graduate</option>
                                <option value="senior_high">Senior High School</option>
                                <option value="als">ALS</option>
                                <option value="college_stud">College Student</option>
                                <option value="college_undergrad">College Undergraduate</option>
                                <option value="college">College Graduate</option>
                                <option value="post_grad">Post Graduate/Masteral/Doctorate Degree</option>
                                <option value="vocational">Vocational Course</option>
                                <option value="unable_provide">Unable to provide</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Balik Probinsya, Bagong Pag-asa (BP2) :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="balik_probinsya" value="yes" style="display:inline;"> Yes </label>&emsp;&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="balik_probinsya" value="no" > No </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Classification by Age/Health Risk Group :</td>
                        <td>
                            <input type="hidden" name="health_group" id="hg">
                            <select class="form-control" id="health_group" disabled>
                                <option value="N">Newborn (0-28 days)</option>
                                <option value="I">Infant (0-1 y/0)</option>
                                <option value="PSAC">PSAC (1-4 y/0)</option>
                                <option value="SAC">School Age (5-9 y/o)</option>
                                <option value="AD">Adolescent (10-19 y/0)</option>
                                <option value="A">Adult (20-59 y/0)</option>
                                <option value="SC">Senior Citizen</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Diagnosed with Cancer :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="cancer" class="cancer" value="yes" style="display:inline;"> Yes </label>
                            &emsp;<span class="cancer_type"></span> <br />
                            <label style="cursor: pointer;"><input type="radio" name="cancer" class="cancer" value="no"> No </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Hypertension : <br><small class="text-info"><em>(If applicable)</em></small></td>
                        <td class="has-group">
                            <div class="col-md-4" style="padding-left: 0px; margin-left: 0px;">
                                <label style="cursor: pointer;"><input type="radio" name="hypertension" class="hypertension" value="Medication Avail" style="display:inline;"> Medication Avail</label><br>
                                <label style="cursor: pointer;"><input type="radio" name="hypertension" class="hypertension" value="No Medication Avail" > No Medication Avail</label><br>
                                <input type="button" class="btn btn-xs btn-flat btn-warning" id="clear_hypertension" onclick="clearMedication('hypertension')" value="Clear Choice">
                            </div>
                            <div class="col-md-7">
                                <span class="hypertension_remarks"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Diabetic : <br><small class="text-info"><em>(If applicable)</em></small></td>
                        <td class="has-group">
                            <div class="col-md-4" style="padding-left: 0px; margin-left: 0px;">
                                <label style="cursor: pointer;"><input type="radio" name="diabetic" class="diabetic" value="Medication Avail" style="display:inline;"> Medication Avail</label><br>
                                <label style="cursor: pointer;"><input type="radio" name="diabetic" class="diabetic" value="No Medication Avail" > No Medication Avail</label><br>
                                <input type="button" class="btn btn-xs btn-flat btn-warning" id="clear_diabetic" onclick="clearMedication('diabetic')" value="Clear Choice">
                            </div>
                            <div class="col-md-7">
                                <span class="diabetic_remarks"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>TB Medication : <br><small class="text-info"><em>(If applicable)</em></small></td>
                        <td class="has-group">
                            <div class="col-md-4" style="padding-left: 0px; margin-left: 0px;">
                                <label style="cursor: pointer;"><input type="radio" name="tbdots_med" class="tb" value="Medication Avail" style="display:inline;"> Medication Avail</label><br>
                                <label style="cursor: pointer;"><input type="radio" name="tbdots_med" class="tb" value="No Medication Avail" > No Medication Avail</label><br>
                                <input type="button" class="btn btn-xs btn-flat btn-warning" id="clear_tb" onclick="clearMedication('tb')" value="Clear Choice">
                            </div>
                            <div class="col-md-7">
                                <span class="tb_remarks"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Mental Health Medication : <br><small class="text-info"><em>(If applicable)</em></small></td>
                        <td class="has-group">
                            <div class="col-md-4" style="padding-left: 0px; margin-left: 0px;">
                                <label style="cursor: pointer;"><input type="radio" name="mental_med" class="mental" value="Medication Avail" style="display:inline;"> Medication Avail</label><br>
                                <label style="cursor: pointer;"><input type="radio" name="mental_med" class="mental" value="No Medication Avail" > No Medication Avail</label><br>
                                <input type="button" class="btn btn-xs btn-flat btn-warning" id="clear_mental" onclick="clearMedication('mental')" value="Clear Choice">
                            </div>
                            <div class="col-md-7">
                                <span class="mental_remarks"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>CVD Medication : <br><small class="text-info"><em>(If applicable)</em></small></td>
                        <td class="has-group">
                            <div class="col-md-4" style="padding-left: 0px; margin-left: 0px;">
                                <label style="cursor: pointer;"><input type="radio" name="cvd_med" class="cvd" value="Medication Avail" style="display:inline;"> Medication Avail</label><br>
                                <label style="cursor: pointer;"><input type="radio" name="cvd_med" class="cvd" value="No Medication Avail" > No Medication Avail</label><br>
                                <input type="button" class="btn btn-xs btn-flat btn-warning" id="clear_cvd" onclick="clearMedication('cvd')" value="Clear Choice">
                            </div>
                            <div class="col-md-7">
                                <span class="cvd_remarks"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Other Medical History :<br><small class="text-info"><em>(If applicable)</em></small></td>
                        <td>
                            <textarea class="form-control" name="other_med_history" style="resize: none;width: 100%;" rows="2"></textarea>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Latest Covid Vaccination Status <span class="text-red" style="font-size: 20px"><b>*</b></span> :</td>
                        {{--<td><input type="text" name="covid_status" class="form-control"/> </td>--}}
                        <td>
                            <label style="cursor: pointer;"><input required type="radio" class="covid_status" name="covid_status" value="Primary Dose" style="display:inline;"> Primary Dose </label>&emsp;
                            <label style="cursor: pointer;"><input required type="radio" class="covid_status" name="covid_status" value="Second Dose" style="display:inline;"> Second Dose </label>&emsp;
                            <label style="cursor: pointer;"><input required type="radio" class="covid_status" name="covid_status" value="Booster Dose" style="display:inline;"> Booster Dose </label>&emsp;
                            <label style="cursor: pointer;"><input required type="radio" class="covid_status" name="covid_status" value="None" style="display:inline;"> None </label>
                            <small class="text-red" id="vaccine_warning"><br>This field is required.</small>
                        </td>
                    </tr>
                    <tr class="menarcheClass hide">
                        <td>Menarche :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input onclick="showMenarche()" type="radio" name="menarche" value="yes" style="display:inline;"> Yes</label>
                            &emsp;<span class="menarche_age"></span><br/>
                            <label style="cursor: pointer;"><input onclick="showMenarche()" type="radio" name="menarche" value="no"> No</label>&emsp;
                        </td>
                    </tr>
                    <tr class="sexuallyActiveClass hide">
                        <td>Sexually Active :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="sexually_active" id="sexually_active" value="yes" style="display:inline;"> Yes </label><br>
                            <label style="cursor: pointer;"><input type="radio" name="sexually_active" id="sexually_active" value="no"> No </label>
                        </td>
                    </tr>
                    <tr class="famPlan hide">
                        <td>Using Family Planning : </td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" onclick="showFamPlan()" name="fam_plan" value="yes" style="display:inline;"> Yes </label><br>
                            <label style="cursor: pointer;"><input type="radio" onclick="showFamPlan()" name="fam_plan" value="no"> No </label>
                        </td>
                    </tr>
                    <tr class="famPlanClass hide">
                        <td>Family Planning Methods Used :</td>
                        <td>
                            <select class="form-control select2" style="width: 100%;" name="fam_plan_method" id="fam_plan_method">
                                <option value="">Select...</option>
                                <option>COC</option>
                                <option>POP</option>
                                <option>Injectibles</option>
                                <option>IUD</option>
                                <option>Condom</option>
                                <option>LAM</option>
                                <option>BTL</option>
                                <option>Implant</option>
                                <option>SDM</option>
                                <option>DPT</option>
                                <option>Withdrawal</option>
                                <option value="other">Others (Specify)</option>
                            </select><br>
                            <input class="form-control" style="margin-top: 10px" name="fam_plan_other_method" id="fam_plan_other_method" placeholder="(Other Family Planning Method)">
                        </td>
                    </tr>
                    <tr class="famPlanClass hide">
                        <td>Family Planning Status :</td>
                        <td class="has-group">
                            <select class="form-control select2" style="width: 100%;" name="fam_plan_status" id="fam_plan_status">
                                <option value="">Select...</option>
                                <option value="withdrawal">Withdrawal</option>
                                <option value="new_acceptors">New Acceptors</option>
                                <option value="other">Others (Specify)</option>
                            </select><br>
                            <input class="form-control" style="margin-top: 10px" name="fam_plan_other_status" id="fam_plan_other_status" placeholder="(Other Family Planning Status)">
                        </td>
                    </tr>
                    <tr class="unmetClass hide">
                        <td>Unmet Need :</td>
                        <td>
                            <input type="hidden" name="unmet" id="unmet" />
                            <div class="form-inline">
                                <input type="text" id="unmet2" class="form-control" readonly value="Not set" data-toggle="modal" data-target="#unmetNeed" />
                                <button type="button" style="margin:5px 0;" class="btn btn-info" data-toggle="modal" data-target="#unmetNeed">Yes</button>
                                <button type="button" style="margin:5px 0;" class="btn btn-warning" onclick="unmet_need()"> No </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>PWD :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="pwd" class="pwd" value="yes" style="display:inline;"> Yes</label>
                            &emsp;<span class="pwd_description"></span><br />
                            <label style="cursor: pointer;"><input type="radio" name="pwd" class="pwd" value="no" > No</label>
                        </td>
                    </tr>
                    <tr class="has-group pregnant_lmp hide">
                        <td>Last Menstrual Period : <br><small class="text-info">(if pregnant)</small></td>
                        <td><input type="date" name="pregnant" class="form-control" max="{{ $today }}" /> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href="{{ asset('user/population') }}" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success btn-sm" id="submitHeadBtn">
                                <i class="fa fa-send"></i> Submit
                            </button>
                            {{--<button class="btn btn-info btn-sm">--}}
                                {{--<i class="fa fa-arrow-right"></i> Proceed to EMR--}}
                            {{--</button>--}}
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    @include('sidebar')
    @include('modal.profile')
    @include('modal.checkProfile')
@endsection

@section('js')
    @include('script.profile')
    <?php
    $status = session('status');
    ?>
    @if($status=='added')
        <script>
            Lobibox.notify('success', {
                msg: 'Successfully added!'
            });
        </script>
    @endif


    <script>
        showUnmet();
        function showUnmet() {
            setHealthGroup();
            var sex = $('input[name="sex"]:checked').val();
            console.log(sex);
            if (sex === 'Female') {
                $('.unmetClass, .menarcheClass, .pregnant_lmp, .sexuallyActiveClass, .famPlan').removeClass('hide');
            } else {
                $('.unmetClass, .menarcheClass, .pregnant_lmp, .sexuallyActiveClass, .famPlan').addClass('hide');
                $('#unmet').val('0');
                $('#unmet2').val('Not set');
            }
        }

        showMenarche();
        function showMenarche() {
            var menarche = $('input[name="menarche"]:checked').val();
            if( menarche === "yes") {
                $('.menarche_age').show();
                $('.menarche_age').html("Age of Menarche: <input type='number' value='{{ $info->menarche_age }}' name='menarche_age' style='width:30%;' min='9'>");
            } else {
                $('.menarche_age').html('');
                $('.menarche_age').hide();
            }
        }

        $('.other_religion').hide();
        $('#religion').on('change', function() {
            var val = $('#religion').val();
            console.log("religion: " +  val);
            if(val === "other") {
                $('.other_religion').show();
                $('.other_religion').html("<br><input required type='text' style='width:75%; margin-top: 5px' name='other_religion' value='{{ $info->other_religion }}' placeholder='Specify other religion' class='form-control'/>");
            } else {
                $('.other_religion').html("");
                $('.other_religion').hide();
            }
        });

        hideWarnings();
        function hideWarnings() {
            $('#fname_warning, #mname_warning, #lname_warning, #dob_warning, #sex_warning, #brgy_warning').hide();
            $('#cs_warning, #religion_warning, #water_warning, #toilet_warning, #vaccine_warning').hide();
        }

        $('#submitHeadBtn').on('click', function() {
            var submit = true;
            var missing = "";

            fname = $('.fname').val();
            if(fname === "undefined" || fname === "") {
                $('#fname_warning').show();
                $('.fname').focus();
                missing += "<u>First Name</u>";
                submit = false;
            } else
                $('#fname_warning').hide();

            mname = $('.mname').val();
            if(mname === "undefined" || mname === "") {
                $('#mname_warning').show();
                $('.mname').focus();
                missing += ", <u>Middle Name</u>";
                submit = false;
            } else
                $('#mname_warning').hide();

            lname = $('.lname').val();
            if(lname === "undefined" || lname === "") {
                $('#lname_warning').show();
                $('.lname').focus();
                missing += ", <u>Last Name</u>";
                submit = false;
            } else
                $('#lname_warning').hide();

            dob = $('#dob').val();
            if(dob === "undefined" || dob === "") {
                $('#dob_warning').show();
                $('#dob').focus();
                missing += ", <u>Birth Date</u>";
                submit = false;
            } else
                $('#dob_warning').hide();

            sex = $('input[name="sex"]:checked').length;
            if(sex == 0) {
                $('#sex_warning').show();
                $('.sex').focus();
                missing += ", <u>Sex</u>";
                submit = false;
            } else
                $('#sex_warning').hide();

            cs = $('input[name="civil_status"]:checked').length;
            if(cs == 0) {
                $('#cs_warning').show();
                $('.civil_status').focus();
                missing += ", <u>Civil Status</u>";
                submit = false;
            } else
                $('#cs_warning').hide();

            religion = $('#religion').val();
            if(religion === "" || religion === null) {
                $('#religion_warning').show();
                $('.religion').focus();
                missing += ", <u>Religion</u>";
                submit = false;
            } else
                $('#religion_warning').hide();

            brgy = $('#brgy').val();
            if(brgy === "undefined" || brgy === "") {
                $('#brgy_warning').show();
                $('#brgy').focus();
                missing += ", <u>Barangay</u>";
                submit = false;
            } else
                $('#brgy_warning').hide();

            water = $('#water').val();
            if(water === "undefined" || water === "") {
                $('#water_warning').show();
                $('#water2').focus();
                missing += ", <u>Safe Water Supply</u>";
                submit = false;
            } else
                $('#water_warning').hide();

            toilet = $('#toilet').val();
            if(toilet === "undefined" || toilet === "") {
                $('#toilet_warning').show();
                $('#toilet').focus();
                missing += ", <u>Sanitary Toilet</u>";
                submit = false;
            } else
                $('#toilet_warning').hide();

            covid = $('input[name="covid_status"]:checked').length;
            if(covid == 0) {
                $('#vaccine_warning').show();
                $('.covid_status').focus();
                missing += ", <u>Covid Vaccination Status</u>";
                submit = false;
            } else
                $('#vaccine_warning').hide();

            if(missing.charAt(0) === ',')
                missing = missing.replace(/, /, '');

            if(submit === false) {
                Lobibox.alert('error', {
                    msg: "Please make sure to enter data in the required fields: <br><br> "+ missing + "<br>"
                });
                return false;
            } else {
                hideWarnings();
            }
        });
    </script>
@endsection