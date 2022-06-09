
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
        .help-block {
            font-weight:bold;
        }
    </style>
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">
                <i class="fa fa-user-plus"></i>
                Add Family Member
            </h2>
            <div class="page-divider"></div>
            <form method="POST" class="form-horizontal form-submit" id="form-submit" action="{{ asset('user/population/save') }}">
                {{ csrf_field() }}
                <table class="table table-input table-bordered table-hover" border="1">
                    <tr>
                        <td>Family Profile ID :</td>
                        <?php
                        $head = Profile::where('familyID',$id)
                                ->where('head','YES')
                                ->where('muncity_id',Auth::user()->muncity)
                                ->first();
                        $brgy_id = $head->barangay_id;
                        ?>
                        <input type="hidden" name="familyID" value="{{ $id }}" />
                        <td><input type="text" readonly value="{{ $head->familyID }} ({{  $head->fname }} {{  $head->mname }} {{  $head->lname }})" class="form-control" required /> </td>
                    </tr>
                    <tr>
                        <td>PhilHealth ID :<br/> <small class="text-info"><em>(If applicable)</em></small></td>
                        <td><input type="text" name="phicID" class="form-control" value="" /></td>
                    </tr>
                    <tr>
                        <td>NHTS ID :<br/> <small class="text-info"><em>(If applicable)</em></small></td>
                        <td><input type="text" name="nhtsID" class="form-control" value="" /></td>
                    </tr>
                    <tr>
                        <td>Relation to Head :</td>
                        <td>
                            <select name="relation" onchange="changeGender($(this))" class="chosen-select form-control" style="width: 100%">
                                <option>Son</option>
                                <option>Daughter</option>
                                <option>Wife</option>
                                <option>Husband</option>
                                <option>Father</option>
                                <option>Mother</option>
                                <option>Brother</option>
                                <option>Sister</option>
                                <option>Nephew</option>
                                <option>Niece</option>
                                <option>Grandfather</option>
                                <option>Grandmother</option>
                                <option>Grandson</option>
                                <option>Granddaughter</option>
                                <option>Cousin</option>
                                <option>Relative</option>
                                <option>Daughter in Law</option>
                                <option>Son in Law</option>
                                <option>Sister in Law</option>
                                <option>Brother in Law</option>
                                <option>Father in Law</option>
                                <option>Mother in Law</option>
                                <option value="partner">Live-in Partner</option>
                                <option>Deceased</option>
                                <option>Others</option>
                            </select>
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
                        <td><input type="date" name="dob" onkeyup="calculateAge()" onkeypress="calculateAge()" onblur="calculateAge()" min="1910-05-11" id="dob" class="form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Birth Place :</td>
                        <td><input type="text" name="birth_place" class="form-control birth_place" required /> </td>
                    </tr>
                    <tr>
                        <td>Sex :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input onclick="calculateAge()" type="radio" name="sex" class="sex" value="Male" required style="display:inline;"> Male</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input onclick="calculateAge()" type="radio" name="sex" class="sex" value="Female" required> Female</label>
                            <span class="span"></span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Height <i>(cm)</i>:</td>
                        <td>
                            <span><input type="number" name="height" class="form-control" style="width: 25%"/></span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Weight <i>(kg)</i>:</td>
                        <td>
                            <span><input type="number" name="weight" class="form-control" style="width: 25%"/></span>
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
                    <tr valign="top">
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
                                <option <?php if($brgy_id==$row->id) echo 'selected'; ?> value="{{ $row->id }}">{{ $row->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group">
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
                                <option value="unable_provide">Unable to provide</option>
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
                    <tr class="hypertensionClass hide">
                        <td>Hypertension :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="hypertension" class="hypertension" value="Medication Avail" style="display:inline;"> Medication Avail</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" name="hypertension" class="hypertension" value="No Medication Avail" > No Medication Avail</label>
                        </td>
                    </tr>
                    <tr class="diabetesClass hide">
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
                        <td>Covid Status :</td>
                        <td><input type="text" name="covid_status" class="form-control"/> </td>
                    </tr>
                    <tr class="has-group unmetClass hide">
                        <td>Unmeet Need :</td>
                        <td>
                            <input type="hidden" name="unmet" id="unmet" />
                            <div class="form-inline">
                                <input type="text" id="unmet2" class="form-control" readonly value="Not set" data-toggle="modal" data-target="#unmetNeed" />
                                <button type="button" style="margin:5px 0;" class="btn btn-info" data-toggle="modal" data-target="#unmetNeed">Yes</button>
                                <button type="button" style="margin:5px 0;" class="btn btn-warning" onclick="unmet_need()"> No </button>
                            </div>

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
                    <tr class="nutritionClass hide">
                        <td>Nutrition Status :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input class="form-check-input" name="nutri_stat[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Deworming"> Deworming </label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input" name="nutri_stat[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Vitamin A Supplement"> Vitamin A Supplement</label>&emsp;
                        </td>
                    </tr>
                    <tr class="immuClass hide">
                        <td>Immunization Status: <br><br><br><br><br><br><br><br><br></td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="BCG"> BCG </label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="HEP B"> HEP B</label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Penta 1"> Penta 1</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Penta 2"> Penta 2</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="Penta 3"> Penta 3</label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="OPV 1"> OPV 1</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="OPV 2"> OPV 2</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="OPV 3"> OPV 3</label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="IPV 1"> IPV 1</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="IPV 2"> IPV 2</label><br/>
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="MMR 1"> MMR 1</label>&emsp;
                            <label style="cursor: pointer;"><input class="form-check-input" name="immunization[]" style="height: 18px;width: 18px;cursor: pointer;" type="checkbox" value="MMR 2"> MMR 2</label>&emsp;
                        </td>
                    </tr>
                    <tr class="newbornClass hide">
                        <td>Newborn Screening :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" onclick="showNewborn()" name="newborn_screen" value="yes" style="display:inline;"> Yes</label>
                            &emsp; <span class="newbornYes"></span> <br />
                            <label style="cursor: pointer;"><input type="radio" onclick="showNewborn()" name="newborn_screen" value="no" > No</label>
                        </td>
                    </tr>
                    <tr>
                        <td>PWD :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="pwd" class="pwd" value="yes" style="display:inline;"> Yes</label>
                            &emsp; <span class="pwd_description"></span><br />
                            <label style="cursor: pointer;"><input type="radio" name="pwd" class="pwd" value="no" > No</label>
                        </td>
                    </tr>
                    <tr class="has-group hide pregnant_lmp">
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
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    @include('sidebar')
    @include('modal.checkProfile')
    @include('modal.profile')
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

    @if($status=='duplicate')
        <script>
            Lobibox.notify('error', {
                msg: 'Duplicate Entry!'
            });
        </script>
    @endif

    <script>
        $.validator.setDefaults({
            errorElement: "span",
            errorClass: "help-block",
            //	validClass: 'stay',
            highlight: function (element, errorClass, validClass) {
                $(element).addClass(errorClass); //.removeClass(errorClass);
                $(element).closest('.has-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass(errorClass); //.addClass(validClass);
                $(element).closest('.has-group').removeClass('has-error').addClass('has-success');
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));
                }else if (element.hasClass('chosen-select')) {
                    error.insertAfter(element.next('div'));
                }else if (element.hasClass('sex')) {
                    error.insertAfter('.span');
                }
                else {
                    error.insertAfter(element);
                }
            }
        });

        $('.chosen-select').on('change', function () {
            $(this).valid();
        });
        //
        //        $("#relation").select2();

        $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })
        var validator = $("#form-submit").validate();
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
    </script>
@endsection