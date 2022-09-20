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
                        <td>PhilHealth ID :<br/> <small class="text-info"><em>(If applicable)</em></small></td>
                        <td><input type="text" name="phicID" class="form-control" value="" /></td>
                    </tr>
                    <tr>
                        {{--<td>NHTS ID :<br/> <small class="text-info"><em>(If applicable)</em></small></td>--}}
                        {{--<td><input type="text" name="nhtsID" class="form-control" value="" /></td>--}}
                        <td>Beneficiaries :<br><small class="text-info"><em>(Check applicable)</em></small></td>
                        <td>&emsp;
                            <label style="font-size: 110%"><input class="form-check-input" style="height: 20px;width: 20px;cursor: pointer;" type="checkbox" name="nhts" value="yes">&nbsp; NHTS  </label>&emsp;&emsp;
                            <label style="font-size: 110%"><input class="form-check-input" style="height: 20px;width: 20px;cursor: pointer;" type="checkbox" name="four_ps" value="yes">&nbsp; 4Ps</label>&emsp;&emsp;
                            <label style="font-size: 110%"><input class="form-check-input" style="height: 20px;width: 20px;cursor: pointer;" type="checkbox" name="ip" value="yes">&nbsp; IP</label>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>First Name :</td>
                        <td><input type="text" name="fname" class="fname form-control" required /> </td>
                    </tr>
                    <tr>
                        <td>Middle Name :</td>
                        <td><input type="text" name="mname" class="mname form-control" /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Last Name :</td>
                        <td><input type="text" name="lname" class="lname form-control" required /> </td>
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
                        <td>Birth Date :</td>
                        <td><input type="date" name="dob" onkeyup="calculateAge()" onkeypress="calculateAge()" onblur="calculateAge()" id="dob" max="{{ $today }}" class="form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Birth Place :</td>
                        <td><input type="text" name="birth_place" class="form-control birth_place" required /> </td>
                    </tr>
                    <tr>
                        <td>Sex :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input onclick="showUnmet()" type="radio" name="sex" class="sex" value="Male" required style="display:inline;"> Male</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input onclick="showUnmet()" type="radio" name="sex" class="sex" value="Female" required> Female</label>
                            <span class="span"></span>
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
                        <td>Civil Status :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Single" style="display:inline;"> Single</label> &emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Married" > Married</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Divorced" > Divorced</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Separated" > Separated</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Widowed" > Widowed</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="civil_status" class="civil_status" value="Annulled" > Annulled</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Religion Status :<br><br><br><br></td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="religion" class="religion" value="RC" style="display:inline;"> RC</label> &emsp;
                            <label style="cursor: pointer;"><input type="radio" name="religion" class="religion" value="Christian" > Christian</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="religion" class="religion" value="INC" > INC</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="religion" class="religion" value="Islam" > Islam</label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="religion" class="religion" value="Jehovah" > Jehovah</label><br/>
                            <label style="cursor: pointer;"><input type="radio" name="religion" class="religion" value="other" > Others: <i>(specify)</i></label><br/>
                            <span class="other_religion"></span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Barangay :</td>
                        <td>
                            <select name="barangay" class="form-control chosen-select" required id="suffix" style="width: 100%">
                                <option value="">Select...</option>
                                @foreach($brgy as $row)
                                <option value="{{ $row->id }}">{{ $row->description }}</option>
                                @endforeach
                            </select>
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
                        <td>Safe Water Supply :</td>
                        <td>
                            <input type="hidden" name="water" id="water" />
                            <div class="form-inline">
                                <input type="text" id="water2" class="form-control" readonly value="Not set" data-toggle="modal" data-target="#waterLvl" />
                                <button type="button" style="margin:5px 0;" class="btn btn-info" data-toggle="modal" data-target="#waterLvl">Select...</button>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>Sanitary Toilet :</td>
                        <td>
                            <select name="toilet" class="form-control chosen-select" id="toilet" style="width: 100%">
                                <option value="">Select...</option>
                                <option value="non">None</option>
                                <option value="comm">Communal</option>
                                <option value="indi">Individual Household</option>
                            </select>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Educational Attainment :</td>
                        <td>
                            <select name="education" class="form-control chosen-select" id="education" style="width: 100%">
                                <option value="">Select...</option>
                                <option value="non">No Education</option>
                                <option value="elem">Elementary Level</option>
                                <option value="elem_grad">Elementary Graduate</option>
                                <option value="high">High School Level</option>
                                <option value="high_grad">High School Graduate</option>
                                <option value="college">College Level</option>
                                <option value="college_grad">College Graduate</option>
                                <option value="vocational">Vocational Course</option>
                                <option value="master">Masteral Degree</option>
                                <option value="doctorate">Doctorate Degree</option>
                                <option value="unable_provide">Unable to provide</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Balik Probinsya, Bagong Pag-asa (PP2) :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="balik_probinsya" value="yes" style="display:inline;"> Yes </label>&emsp;&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="balik_probinsya" value="no" > No </label>
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
                        <td>Hypertension :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="hypertension" class="hypertension" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" name="hypertension" class="hypertension" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Diabetic :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="diabetic" class="diabetic" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" name="diabetic" class="diabetic" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Mental Health Medication :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="mental_med" class="mental_med" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" name="mental_med" class="mental_med" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr>
                        <td>TBDOTS Availment :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="tbdots_med" class="tbdots_med" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" name="tbdots_med" class="tbdots_med" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr>
                        <td>CVD Medication :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="cvd_med" class="cvd_med" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" name="cvd_med" class="cvd_med" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Latest Covid Vaccination Status :</td>
                        {{--<td><input type="text" name="covid_status" class="form-control"/> </td>--}}
                        <td>
                            <label style="cursor: pointer;"><input type="radio" name="covid_status" value="Primary Dose" style="display:inline;"> Primary Dose </label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="covid_status" value="Second Dose" style="display:inline;"> Second Dose </label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="covid_status" value="Booster Dose" style="display:inline;"> Booster Dose </label>&emsp;
                            <label style="cursor: pointer;"><input type="radio" name="covid_status" value="None" style="display:inline;"> None </label>
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
                            <label style="cursor: pointer;"><input type="radio" name="sexually_active" class="sexually_active" value="yes" style="display:inline;"> Yes </label><br>
                            <label style="cursor: pointer;"><input type="radio" name="sexually_active" class="sexually_active" value="no"> No </label>
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
                        <td>Pregnant Date LMP:</td>
                        <td><input type="date" name="pregnant" class="form-control" /> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href="{{ asset('user/population') }}" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success btn-sm">
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
            var sex = $('input[name="sex"]:checked').val();
            console.log(sex);
            if (sex === 'Female') {
                $('.unmetClass').removeClass('hide');
                $('.menarcheClass').removeClass('hide');
                $('.pregnant_lmp').removeClass('hide');
                $('.sexuallyActiveClass').removeClass('hide');
            } else {
                $('.unmetClass').addClass('hide');
                $('.menarcheClass').addClass('hide');
                $('.pregnant_lmp').addClass('hide');
                $('.sexuallyActiveClass').addClass('hide');
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

        $('input[name="religion"]').on('click', function() {
            var val = $(this).val();
            if(val === "other") {
                $('.other_religion').show();
                $('.other_religion').html("<input type='text' style='width:50%;' name='other_religion' value='{{ $info->other_religion }}' class='form-control'/>");
            } else {
                $('.other_religion').html("");
                $('.other_religion').hide();
            }
        });
    </script>
@endsection