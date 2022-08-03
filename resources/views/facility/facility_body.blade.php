<?php
$user = Auth::user();
?>

<style>
    .container2 {
        border: 1px solid lightgrey;
        width: 100%;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 5px;
        padding-right: 5px;
    }
</style>

<form method="POST" action="{{ asset('facility/add') }}">
    {{ csrf_field() }}
    <fieldset>
        <legend><i class="fa fa-hospital-o"></i> Facility</legend>
    </fieldset>
    <input type="hidden" value="@if(isset($data->id)){{ $data->id }}@endif" name="id">
    {{--<input type="hidden" value="1" name="status">--}}
    <div class="form-group">
        <label>Facility Name:</label>
        <input type="text" class="form-control" value="@if(isset($data->name)){{ $data->name }}@endif" autofocus name="name" required>
    </div>
    <div class="form-group">
        <label>Facility Code:</label>
        <input type="text" class="form-control" value="@if(isset($data->facility_code)){{ $data->facility_code }}@endif" name="facility_code" required>
    </div>
    <div class="form-group">
        <label>Abbr:</label>
        <input type="text" class="form-control" value="@if(isset($data->abbr)){{ $data->abbr }}@endif" name="abbr">
    </div>
    <div class="form-group">
        <label>Province:</label>
        <select class="form-control select_province" name="province" required>
            @if(!isset($data->province))
                <option value="">Select Province</option>
            @endif
            @foreach(\App\Province::get() as $row)
                <option value="{{ $row->id }}"
                <?php
                    if(isset($data->province)){
                        if($data->province == $row->id){
                            echo 'selected';
                        }
                    }
                    ?>
                >{{ $row->description }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Municipality:</label>
        <select class="form-control select_muncity select2" name="muncity" required>
            @if(isset($data->muncity))
                @foreach(\App\Muncity::where("province_id",$data->province)->get() as $row)
                    <option value="{{ $row->id }}" <?php if($data->muncity == $row->id)echo 'selected'; ?> >{{ $row->description }}</option>
                @endforeach
            @else
                @if($user->user_priv == 0 || $user->user_priv == 2)
                    <?php $muncity_desc = \App\Http\Controllers\FacilityCtrl::getMuncityDesc($user->muncity);?>
                    <option value="{{ $user->muncity }}">{{ $muncity_desc->description }}</option>
                @else
                    <option value="">Select Municipality</option>
                @endif
            @endif
        </select>
    </div>
    <div class="form-group">
        <label>Barangay:</label>
        <select class="form-control select_barangay select2" name="brgy" required>
            @if(isset($data->brgy))
                @foreach(\App\Barangay::where("province_id",$data->province)->where("muncity_id",$data->muncity)->get() as $row)
                    <option value="{{ $row->id }}" <?php if($data->brgy == $row->id)echo 'selected'; ?> >{{ $row->description }}</option>
                @endforeach
            @else
                <option value="">Select Barangay</option>
                <?php
                if($user->user_priv == 0 || $user->user_priv == 2) {
                    $barangay = \App\Http\Controllers\FacilityCtrl::getBarangays($user->province, $user->muncity);
                    foreach($barangay as $b)
                        echo "<option value='".$b->id."'>".$b->description."</option>";
                }
                ?>
            @endif

        </select>
    </div>
    <div class="form-group">
        <label>Address:</label>
        <input type="text" class="form-control" value="@if(isset($data->address)){{ $data->address }}@endif" name="address" required>
    </div>
    <div class="form-group">
        <label>Contact:</label>
        <input type="text" class="form-control" value="@if(isset($data->contact)){{ $data->contact }}@endif" name="contact" required>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="text" class="form-control" value="@if(isset($data->email)){{ $data->email }}@endif" name="email" required>
    </div>
    <div class="form-group">
        <label>Head of Facility (Name):</label>
        <input type="text" class="form-control" value="@if(isset($data->chief_hospital)){{ $data->chief_hospital }}@endif" name="chief_hospital" required>
    </div>
    <div class="form-group">
        <label>Service Capability:</label>
        <select class="form-control" name="service_cap" >
            @if(!isset($add_info->service_cap))
                <option value="">Select Service Capability</option>
            @endif
            <option value="Birthing Home"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "Birthing Home"){
                        echo 'selected';
                    }
                }
                ?>
            >Birthing Home
            </option>
            <option value="Level 1"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "Level 1"){
                        echo 'selected';
                    }
                }
                ?>
            >Level 1
            </option>
            <option value="Level 2"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "Level 2"){
                        echo 'selected';
                    }
                }
                ?>
            >Level 2
            </option>
            <option value="Level 3"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "Level 3"){
                        echo 'selected';
                    }
                }
                ?>
            >Level 3
            </option>
            <option value="TTMF"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "TTMF"){
                        echo 'selected';
                    }
                }
                ?>
            >TTMF
            </option>
            <option value="Primary Care Facility"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "Primary Care Facility"){
                        echo 'selected';
                    }
                }
                ?>
            >Primary Care Facility
            </option>
            <option value="Dental Clinic"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == 'Dental Clinic'){
                        echo 'selected';
                    }
                }
                ?>
            >Dental Clinic
            </option>
            <option value="Laboratory (Level 1)"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "Laboratory (Level 1)"){
                        echo 'selected';
                    }
                }
                ?>
            >Laboratory (Level 1)
            </option>
            <option value="Laboratory (Level 2)"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "Laboratory (Level 2)"){
                        echo 'selected';
                    }
                }
                ?>
            >Laboratory (Level 2)
            </option>
            <option value="Laboratory (Level 3)"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == "Laboratory (Level 3)"){
                        echo 'selected';
                    }
                }
                ?>
            >Laboratory (Level 3)
            </option>
            <option value="Radiology"
            <?php
                if(isset($add_info->service_cap)){
                    if($add_info->service_cap == 'Radiology'){
                        echo 'selected';
                    }
                }
                ?>
            >Radiology
            </option>
            <option value="Pharmacy"
            <?php
                if(isset($add_info->service_cap)){
                    if($data->service_cap == 'Pharmacy'){
                        echo 'selected';
                    }
                }
                ?>
            >Pharmacy
            </option>
        </select>
    </div>
    <div class="form-group">
        <label>Licensing Status:</label>
        <div class="container" style="width:inherit; border: 1px solid lightgrey; padding: 3px;">
            &emsp;&emsp;<label><input type="radio" value="1" name="licensed" <?php if($add_info->licensed== '1') echo 'checked'; ?>> Licensed </label>
            &emsp;&emsp;<label><input type="radio" value="0" name="licensed" <?php if($add_info->licensed== '0') echo 'checked'; ?>> Unlicensed </label>
        </div>
    </div>
    <div class="form-group">
        <label>Ownership:</label>
        <select class="form-control" name="hospital_type">
            @if(!isset($data->hospital_type))
                <option value="">Select Ownership</option>
            @endif
            <option value="private"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == 'private'){
                        echo "selected";
                    }
                }
            ?>
            >Private</option>
            <option value="RHU"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == 'RHU'){
                        echo "selected";
                    }
                }
                ?>
            >(Government) Rural Health Unit </option>
            <option value="CIU/TTMF"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == 'CIU/TTMF'){
                        echo "selected";
                    }
                }
                ?>
            >(Government) CIU/TTMF
            </option>
            <option value="gov_birthing_home"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == 'gov_birthing_home'){
                        echo "selected";
                    }
                }
                ?>
            >(Government) Birthing Home
            </option>
            <option value="Emergency Operations Center"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == "Emergency Operations Center"){
                        echo "selected";
                    }
                }
                ?>
            >(Government) Emergency Operations Center
            </option>
            <option value="lgu_owned"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == "lgu_owned"){
                        echo "selected";
                    }
                }
                ?>
            >(Government) LGU-Owned Hospital
            </option>
            <option value="doh_hospital"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == "doh_hospital"){
                        echo "selected";
                    }
                }
                ?>
            >(Government) DOH Hospital
            </option>
            <option value="city_owned"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == "city_owned"){
                        echo "selected";
                    }
                }
                ?>
            >(Government) City Owned Hospital
            </option>
            <option value="City Health Office"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == "City Health Office"){
                        echo "selected";
                    }
                }
                ?>
            >(Government) City Health Office
            </option>
            <option value="Department of National Defense"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == "Department of National Defense"){
                        echo "selected";
                    }
                }
                ?>
            >(Government) Department of National Defense
            </option>
            <option value="Philippine National Police"
            <?php
                if(isset($data->hospital_type)){
                    if($data->hospital_type == "Philippine National Police"){
                        echo "selected";
                    }
                }
                ?>
            >(Government) Philippine National Police
            </option>
        </select>
    </div>
    <div class="form-group">
        <label>PHIC Accreditation Status:</label>
        <div class="container" style="width:inherit; border: 1px solid lightgrey; padding: 3px;">
            &emsp;&emsp;<label><input type="radio" value="Accredited" name="phic_status" <?php if($add_info->phic_status== 'Accredited') echo 'checked'; ?>> Accredited </label>
            &emsp;&emsp;<label><input type="radio" value="Non-Accredited" name="phic_status" <?php if($add_info->phic_status== 'Non-Accredited') echo 'checked'; ?>> Non-Accredited </label>
        </div>
    </div>
    <div class="form-group">
        <label>Availability and Type of Transport:</label>
        <select class="form-control" name="transport">
            <option value="">Select ...</option>
            @if(!isset($add_info->transport))
                <option value="">Select...</option>
            @endif
            <option value="Level 1 Ambulance"
            <?php
                if(isset($add_info->transport)){
                    if($add_info->transport == 'Level 1 Ambulance'){
                        echo 'selected';
                    }
                }
                ?>
            >Level 1 Ambulance
            </option>
            <option value="Level 2 Ambulance"
            <?php
                if(isset($add_info->transport)){
                    if($add_info->transport == 'Level 2 Ambulance'){
                        echo 'selected';
                    }
                }
                ?>
            >Level 2 Ambulance
            </option>
            <option value="Level 3 Ambulance"
            <?php
                if(isset($add_info->transport)){
                    if($add_info->transport == 'Level 3 Ambulance'){
                        echo 'selected';
                    }
                }
                ?>
            >Level 3 Ambulance
            </option>
            <option value="ER Transport Vehicle"
            <?php
                if(isset($add_info->transport)){
                    if($add_info->transport == 'ER Transport Vehicle'){
                        echo 'selected';
                    }
                }
                ?>
            >ER Transport Vehicle
            </option>
        </select>
    </div>
    <div class="form-group">
        <label>Clinic Hours / Schedule:</label><br>
        <div class="container" style="width:inherit; border: 1px solid lightgrey; padding: 5px;">
            <small> DAYS: </small>
            <select class="form-control-select" name="sched_day_from" id="sched_day_from">
                <option value="">Select day...</option>
                <option <?php if($add_info->sched_day_from == 'Sunday') echo 'selected';?> value="Sunday">Sunday</option>
                <option <?php if($add_info->sched_day_from == 'Monday') echo 'selected';?> value="Monday">Monday</option>
                <option <?php if($add_info->sched_day_from == 'Tuesday') echo 'selected';?> value="Tuesday">Tuesday</option>
                <option <?php if($add_info->sched_day_from == 'Wednesday') echo 'selected';?> value="Wednesday">Wednesday</option>
                <option <?php if($add_info->sched_day_from == 'Thursday') echo 'selected';?> value="Thursday">Thursday</option>
                <option <?php if($add_info->sched_day_from == 'Friday') echo 'selected';?> value="Friday">Friday</option>
                <option <?php if($add_info->sched_day_from == 'Saturday') echo 'selected';?> value="Saturday">Saturday</option>
            </select>
            <small> to </small>
            <select class="form-control-select" name="sched_day_to" id="sched_day_to">
                <option value="">Select day...</option>
                <option <?php if($add_info->sched_day_to == 'Sunday') echo 'selected';?> value="Sunday">Sunday</option>
                <option <?php if($add_info->sched_day_to == 'Monday') echo 'selected';?> value="Monday">Monday</option>
                <option <?php if($add_info->sched_day_to == 'Tuesday') echo 'selected';?> value="Tuesday">Tuesday</option>
                <option <?php if($add_info->sched_day_to == 'Wednesday') echo 'selected';?> value="Wednesday">Wednesday</option>
                <option <?php if($add_info->sched_day_to == 'Thursday') echo 'selected';?> value="Thursday">Thursday</option>
                <option <?php if($add_info->sched_day_to == 'Friday') echo 'selected';?> value="Friday">Friday</option>
                <option <?php if($add_info->sched_day_to == 'Saturday') echo 'selected';?> value="Saturday">Saturday</option>
            </select>&emsp;&emsp;

            <small> TIME: </small>
            <input <?php if(isset($add_info->sched_time_from)) echo 'value='.$add_info->sched_time_from;?> id="sched_time_from" type="time" name="sched_time_from">
            <small> to </small>
            <input <?php if(isset($add_info->sched_time_to)) echo 'value='.$add_info->sched_time_to;?> id="sched_time_to" type="time" name="sched_time_to" style="margin-bottom: 10px;">

            <small>NOTES: </small><br>
            <textarea {{--class="form-control"--}} name="sched_notes" style="resize: none;width: 100%;" rows="3">{{ $add_info->sched_notes}}</textarea>
        </div>
    </div>
    <label> Available Services: </label>
    <div class="form-group">
        <div class="container_tsekap">
            <button class="btn btn-m collapsed" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapse_lab" aria-expanded="false" aria-controls="collapse_lab">
                <span class="pull-left"><small><b> LABORATORY SERVICES </b></small></span>
                <span class="pull-right"><i class="fa fa-plus"></i></span>
            </button>
        </div>
        <div class="collapse" id="collapse_lab" style="width: 100%;">
            <div class="container2">
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab1' onchange="triggerLabCosting(1)" value="Complete Blood Count with Platelet Count"> Complete Blood Count w/ Platelet Count </label> <br>
                        <span class="labsign1"><input class="money_format1" oninput="formatMoney(1)" type="text" id="labcost1" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab2' onchange="triggerLabCosting(2)" value="Oral Glucose Tolerance Test"> Oral Glucose Tolerance Test </label> <br>
                        <span class="labsign2"><input class="money_format2" oninput="formatMoney(2)" type="text" id="labcost2" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab3' onchange="triggerLabCosting(3)" value="Fecalysis"> Fecalysis </label> <br>
                        <span class="labsign3"><input class="money_format3" oninput="formatMoney(3)" type="text" id="labcost3" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab4' onchange="triggerLabCosting(4)" value="Sputum Microscopy"> Sputum Microscopy </label> <br>
                        <span class="labsign4"><input class="money_format4" oninput="formatMoney(4)" type="text" id="labcost4" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab5' onchange="triggerLabCosting(5)" value="Fecal Occult Blood"> Fecal Occult Blood</label> <br>
                        <span class="labsign5"><input class="money_format5" oninput="formatMoney(5)" type="text" id="labcost5" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab6' onchange="triggerLabCosting(6)" value="Pap Smear"> Pap Smear </label> <br>
                        <span class="labsign6"><input class="money_format6" oninput="formatMoney(6)" type="text" id="labcost6" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab7' onchange="triggerLabCosting(7)" value="FBS"> FBS </label> <br>
                        <span class="labsign7"><input class="money_format7" oninput="formatMoney(7)" type="text" id="labcost7" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab8' onchange="triggerLabCosting(8)" value="Urinalysis"> Urinalysis </label> <br>
                        <span class="labsign8"><input class="money_format8" oninput="formatMoney(8)" type="text" id="labcost8" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab9' onchange="triggerLabCosting(9)" value="ECG"> ECG </label> <br>
                        <span class="labsign9"><input class="money_format9" oninput="formatMoney(9)" type="text" id="labcost9" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab10' onchange="triggerLabCosting(10)" value="Chest X-Ray"> Chest X-Ray </label> <br>
                        <span class="labsign10"><input class="money_format10" oninput="formatMoney(10)" type="text" id="labcost10" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab11' onchange="triggerLabCosting(11)" value="Creatinine"> Creatinine </label> <br>
                        <span class="labsign11"><input class="money_format11" oninput="formatMoney(11)" type="text" id="labcost11" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab12' onchange="triggerLabCosting(12)" value="HbAIC"> HbAIC </label> <br>
                        <span class="labsign12"><input class="money_format12" oninput="formatMoney(12)" type="text" id="labcost12" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="lab_services[]" id='lab13' onchange="triggerLabCosting(13)" value="Lipid Profile"> Lipid Profile </label> <br>
                        <span class="labsign13"><input class="money_format13" oninput="formatMoney(13)" type="text" id="labcost13" name="lab_costing[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="container_tsekap">
            <button class="btn btn-m collapsed" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapse_consult" aria-expanded="false" aria-controls="collapse_consult">
                <span class="pull-left"><small><b> CONSULTATION </b></small></span>
                <span class="pull-right"><i class="fa fa-plus"></i></span>
            </button>
        </div>
        <div class="collapse" id="collapse_consult" style="width: 100%;">
            <div class="container2">
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name=consultation[]" id='service1' onchange="triggerServiceCosting(1)" value="Private Clinic"> Private Clinic </label> <br>
                        <span class="servicesign1"><input class="money_format14" oninput="formatMoney(14)" type="text" id="servicecost1" name="consultation_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="consultation[]" id='service2' onchange="triggerServiceCosting(2)" value="Public Clinic"> Public Clinic </label> <br>
                        <span class="servicesign2"><input class="money_format15" oninput="formatMoney(15)" type="text" id="servicecost2" name="consultation_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="container_tsekap">
            <button class="btn btn-m collapsed" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapse_dental" aria-expanded="false" aria-controls="collapse_dental">
                <span class="pull-left"><small><b> DENTAL </b></small></span>
                <span class="pull-right"><i class="fa fa-plus"></i></span>
            </button>
        </div>
        <div class="collapse" id="collapse_dental" style="width: 100%;">
            <div class="container2">
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="dental[]" id='service3' onchange="triggerServiceCosting(3)" value="Extraction"> Extraction </label> <br>
                        <span class="servicesign3"><input class="money_format16" oninput="formatMoney(16)" type="text" id="servicecost3" name="dental_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="dental[]" id='service4' onchange="triggerServiceCosting(4)" value="Temporary Filling"> Temporary Filling </label> <br>
                        <span class="servicesign4"><input class="money_format17" oninput="formatMoney(17)" type="text" id="servicecost4" name="dental_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="dental[]" id='service5' onchange="triggerServiceCosting(5)" value="Permanent Filling"> Permanent Filling </label> <br>
                        <span class="servicesign5"><input class="money_format18" oninput="formatMoney(18)" type="text" id="servicecost5" name="dental_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="dental[]" id='service6' onchange="triggerServiceCosting(6)" value="Oral Prophylaxis (Cleaning)"> Oral Prophylaxis (Cleaning) </label> <br>
                        <span class="servicesign6"><input class="money_format19" oninput="formatMoney(19)" type="text" id="servicecost6" name="dental_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="dental[]" id='service7' onchange="triggerServiceCosting(7)" value="Orthodontics"> Orthodontics </label> <br>
                        <span class="servicesign7"><input class="money_format20" oninput="formatMoney(20)" type="text" id="servicecost7" name="dental_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="container_tsekap">
            <button class="btn btn-m collapsed" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapse_abtc" aria-expanded="false" aria-controls="collapse_abtc">
                <span class="pull-left"><small><b> ANIMAL BITE TREATMENT CENTER (ABTC) </b></small></span>
                <span class="pull-right"><i class="fa fa-plus"></i></span>
            </button>
        </div>
        <div class="collapse" id="collapse_abtc" style="width: 100%;">
            <div class="container2">
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="abtc[]" id='service8' onchange="triggerServiceCosting(8)" value="Category 1"> Category 1 </label> <br>
                        <span class="servicesign8"><input class="money_format21" oninput="formatMoney(21)" type="text" id="servicecost8" name="abtc_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="abtc[]" id='service9' onchange="triggerServiceCosting(9)" value="Category 2"> Category 2 </label> <br>
                        <span class="servicesign9"><input class="money_format22" oninput="formatMoney(22)" type="text" id="servicecost9" name="abtc_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="abtc[]" id='service10' onchange="triggerServiceCosting(10)" value="Category 3"> Category 3 </label> <br>
                        <span class="servicesign10"><input class="money_format23" oninput="formatMoney(23)" type="text" id="servicecost10" name="abtc_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="container_tsekap">
            <button class="btn btn-m collapsed" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapse_tb" aria-expanded="false" aria-controls="collapse_tb">
                <span class="pull-left"><small><b> TB DOTS </b></small></span>
                <span class="pull-right"><i class="fa fa-plus"></i></span>
            </button>
        </div>
        <div class="collapse" id="collapse_tb" style="width: 100%;">
            <div class="container2">
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="tb_dots[]" id='service11' onchange="triggerServiceCosting(11)" value="Category 1"> Category 1 </label> <br>
                        <span class="servicesign11"><input class="money_format24" oninput="formatMoney(24)" type="text" id="servicecost11" name="tb_dots_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="tb_dots[]" id='service12' onchange="triggerServiceCosting(12)" value="Category 2"> Category 2 </label> <br>
                        <span class="servicesign12"><input class="money_format25" oninput="formatMoney(25)" type="text" id="servicecost12" name="tb_dots_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="container_tsekap">
            <button class="btn btn-m collapsed" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapse_fam_plan" aria-expanded="false" aria-controls="collapse_fam_plan">
                <span class="pull-left"><small><b> FAMILY PLANNING </b></small></span>
                <span class="pull-right"><i class="fa fa-plus"></i></span>
            </button>
        </div>
        <div class="collapse" id="collapse_fam_plan" style="width: 100%;">
            <div class="container2">
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id='service13' onchange="triggerServiceCosting(13)" value="Condom"> Condom </label> <br>
                        <span class="servicesign13"><input class="money_format26" oninput="formatMoney(26)" type="text" id="servicecost13" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id='service14' onchange="triggerServiceCosting(14)" value="NSV"> NSV </label> <br>
                        <span class="servicesign14"><input class="money_format27" oninput="formatMoney(27)" type="text" id="servicecost14" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id='service15' onchange="triggerServiceCosting(15)" value="BTL"> BTL </label> <br>
                        <span class="servicesign15"><input class="money_format28" oninput="formatMoney(28)" type="text" id="servicecost15" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service16" onchange="triggerServiceCosting(16)" value="LAM"> LAM </label><br>
                        <span class="servicesign16"><input class="money_format29" oninput="formatMoney(29)" type="text" id="servicecost16" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service17" onchange="triggerServiceCosting(17)" value="Progesterone"> Progesterone </label><br>
                        <span class="servicesign17"><input class="money_format30" oninput="formatMoney(30)" type="text" id="servicecost17" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service18" onchange="triggerServiceCosting(18)" value="Implant"> Implant </label><br>
                        <span class="servicesign18"><input class="money_format31" oninput="formatMoney(31)" type="text" id="servicecost18" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service19" onchange="triggerServiceCosting(19)" value="(Oral Pills) Combined Oral Contraceptives"> (Oral Pills) Combined Oral Contraceptives</label><br>
                        <span class="servicesign19"><input class="money_format32" oninput="formatMoney(32)" type="text" id="servicecost19" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service28" onchange="triggerServiceCosting(28)" value="(Oral Pills) Progesterone Only"> (Oral Pills) Progesterone Only </label><br>
                        <span class="servicesign28"><input class="money_format40" oninput="formatMoney(40)" type="text" id="servicecost28" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service20" onchange="triggerServiceCosting(20)" value="(IUD) Internal"> (IUD) Internal </label><br>
                        <span class="servicesign20"><input class="money_format33" oninput="formatMoney(33)" type="text" id="servicecost20" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service21" onchange="triggerServiceCosting(21)" value="(IUD) Postpartum"> (IUD) Pospartum </label><br>
                        <span class="servicesign21"><input class="money_format34" oninput="formatMoney(34)" type="text" id="servicecost21" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service22" onchange="triggerServiceCosting(22)" value="(DMPA) Pure Inject Contraceptives"> (DMPA) Pure Inject Contraceptives</label><br>
                        <span class="servicesign22"><input class="money_format35" oninput="formatMoney(35)" type="text" id="servicecost22" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="fam_plan[]" id="service23" onchange="triggerServiceCosting(23)" value="(DMPA) Combined Inject Contraceptives"> (DMPA) Combined Inject Contraceptives</label><br>
                        <span class="servicesign23"><input class="money_format36" oninput="formatMoney(36)" type="text" id="servicecost23" name="fam_plan_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="container_tsekap">
            <button class="btn btn-m collapsed" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapse_other_services" aria-expanded="false" aria-controls="collapse_other_services">
                <span class="pull-left"><small><b> OTHER SERVICES </b></small></span>
                <span class="pull-right"><i class="fa fa-plus"></i></span>
            </button>
        </div>
        <div class="collapse" id="collapse_other_services" style="width: 100%;">
            <div class="container2">
                <div class="row">
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="other_services[]" id="service24" onchange="triggerServiceCosting(24)" value="Birthing"> Birthing </label><br>
                        <span class="servicesign24"><input class="money_format37" oninput="formatMoney(37)" type="text" id="servicecost24" name="other_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    {{--<div class="col-md-4">--}}
                        {{--<label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="other_services[]" id="service25" onchange="triggerServiceCosting(25)" value="Private Clinic"> Private Clinic </label><br>--}}
                        {{--<span class="servicesign25"><input class="money_format38" oninput="formatMoney(38)" type="text" id="servicecost25" name="other_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>--}}
                    {{--</div>--}}
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="other_services[]" id="service26" onchange="triggerServiceCosting(26)" value="Dialysis Center"> Dialysis Center </label> <br>
                        <span class="servicesign26"><input class="money_format39" oninput="formatMoney(39)" type="text" id="servicecost26" name="other_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>
                    </div>
                    <div class="col-md-4">
                        <label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="other_services[]" id="service27" value="Pharmacy"> Pharmacy </label><br>
                        {{--<label style="cursor: pointer; font-size: 12px;"><input type="checkbox" name="other_services[]" id="service27" onchange="triggerServiceCosting(27)" value="Pharmacy"> Pharmacy </label><br>--}}
                        {{--<span class="servicesign27"><input class="money_format40" oninput="formatMoney(40)" type="text" id="servicecost27" name="other_cost[]" placeholder="Cost" style="margin-bottom: 10px; width:75%;"></span>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>E-Referral Health Facility Status:</label>
        <div class="container" style="width:inherit; border: 1px solid lightgrey; padding: 3px;">
            &emsp;&emsp;<label><input type="radio" value="1" name="status" <?php if($data->status== '1') echo 'checked'; ?>> Active </label>
            &emsp;&emsp;<label><input type="radio" value="0" name="status" <?php if($data->status== '0') echo 'checked'; ?>> Inactive </label>
        </div>
    </div>
    <div class="form-group">
        <label>Health Facility Status:</label><br>
        <div class="container" style="width:inherit; border: 1px solid lightgrey; padding: 3px;">
            &emsp;&emsp;<label><input type="radio" value="1" name="facility_status" <?php if($add_info->facility_status== '1') echo 'checked'; ?>> Functional </label>
            &emsp;&emsp;<label><input type="radio" value="0" name="facility_status" <?php if($add_info->facility_status== '0') echo 'checked'; ?>> Not Functional </label>
        </div>
    </div>
    {{--<div class="form-group">--}}
        {{--<label>Latitude:</label>--}}
        {{--<input type="text" class="form-control" value="@if(isset($data->latitude)){{ $data->latitude }}@endif" name="latitude">--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
        {{--<label>Longitude:</label>--}}
        {{--<input type="text" class="form-control" value="@if(isset($data->longitude)){{ $data->longitude }}@endif" name="longitude">--}}
    {{--</div>--}}
    <hr />
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        @if(isset($data->id))
            <a href="#facility_delete" data-toggle="modal" class="btn btn-danger btn-sm btn-flat" onclick="FacilityDelete('<?php echo $data->id; ?>')">
                <i class="fa fa-trash"></i> Remove
            </a>
        @endif
        <button type="submit" class="btn btn-success btn-sm buttonsubmit"><i class="fa fa-check"></i> Save</button>
    </div>
</form>

<script>
    $(".select2").select2({ width: '100%' });

    @if($user->user_priv == 0 || $user->user_priv == 2)
        $('.select_province').val({{ $user->province }});
    @endif

    $('.select_province').on('change',function(){
        $('.loading').show();
        var province_id = $(this).val();
        var url = "{{ asset('location/muncity/') }}";
        $.ajax({
            url: url+'/'+province_id,
            type: 'GET',
            success: function(data){
                console.log(data);
                $('.loading').hide();
                $('.select_muncity').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Municipality'
                    }));
                $('.select_barangay').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Barangay'
                    }));
                jQuery.each(data, function(i,val){
                    $('.select_muncity').append($('<option>', {
                        value: val.id,
                        text : val.description
                    }));
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('.select_muncity').on('change',function(){
        $('.loading').show();
        var province_id = $(".select_province").val();
        var muncity_id = $(this).val();
        var url = "{{ asset('location/barangay/') }}";
        $.ajax({
            url: url+'/'+muncity_id,
            type: 'GET',
            success: function(data){
                $('.loading').hide();
                $('.select_barangay').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Barangay'
                    }));
                jQuery.each(data, function(i,val){

                    $('.select_barangay').append($('<option>', {
                        value: val.id,
                        text : val.description
                    }));
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });
</script>

<script>

    /*  _____________________
    *   |  COLLAPSIBLE MENU |
    *   ---------------------
    */
    $(".collapse").on('show.bs.collapse', function(){
        $(this).prev(".container_tsekap").find(".fa").removeClass("fa-plus").addClass("fa-minus");
    }).on('hide.bs.collapse', function(){
        $(this).prev(".container_tsekap").find(".fa").removeClass("fa-minus").addClass("fa-plus");
    });

    /*  _________________
    *   |  LAB SERVICES |
    *   -----------------
    */
    for(i = 1; i <= 13; i++) {
        $('#labcost'+i).prop('disabled', true);
        $('.labsign'+i).hide();
    }

    function triggerLabCosting(id) {
        if($('#lab'+id).is(':checked')) {
            $('.labsign'+id).show();
            $('#labcost'+id).prop('disabled', false);
        } else {
            $('#labcost'+id).val('');
            $('#labcost'+id).prop('disabled', true);
            $('.labsign'+id).hide();
        }
    }

    /*  ___________________
    *   |  OTHER SERVICES |
    *   -------------------
    */
    for(i = 1; i <= 28; i++) {
        $('#servicecost'+i).prop('disabled', true);
        $('.servicesign'+i).hide();
    }

    function triggerServiceCosting(id) {
        if($('#service'+id).is(':checked')) {
            $('.servicesign'+id).show();
            $('#servicecost'+id).prop('disabled', false);
        } else {
            $('#servicecost'+id).val('');
            $('#servicecost'+id).prop('disabled', true);
            $('.servicesign'+id).hide();
        }
    }

    /*  ______________
    *   |  SCHEDULE  |
    *   --------------
    */
    $('#sched_day_from').on('change', function() {
        if($(this).val())
            $('#sched_day_to').prop('required', true);
        else
            $('#sched_day_to').prop('required', false);
    });

    $('#sched_day_to').on('change', function() {
        if($(this).val())
            $('#sched_day_from').prop('required', true);
        else
            $('#sched_day_from').prop('required', false);
    });

    $('#sched_time_from').on('change', function() {
        if($(this).val())
            $('#sched_time_to').prop('required', true);
        else
            $('#sched_time_to').prop('required', false);
    });

    $('#sched_time_to').on('change', function() {
        if($(this).val())
            $('#sched_time_from').prop('required', true);
        else
            $('#sched_time_from').prop('required', false);
    });

    /*  ____________________
    *   |  CURRENCY FORMAT |
    *   --------------------
    */
    function formatMoney(id) {
        money = $('.money_format'+id).val();
        $('.money_format'+id).val(transformString(money));
    }

    function transformString(str){
        str = str.replace(/[^0-9]/g, '');

        integer = str.slice(0, str.length-2).toLocaleString();
        decimal = str.slice(-2);

        final = "PHP " + integer + '.' + decimal;
        final = final.replace(/\d(?=(\d{3})+\.)/g, '$&,');
        return final;
    }

    /*  _______________________
    *   |  SET COSTING VALUES |
    *   -----------------------
    */
    @if(isset($services))
        @foreach($services as $s)
            name = '<?php echo $s->service?>';
            cost = '<?php echo $s->costing?>';

            for(i = 1; i <= 13; i++){
                if($('#lab'+i).val() == name) {
                    $('#lab'+i).prop('checked', true);
                    $('#labcost'+i).val(transformString(cost));
                    $('#labcost'+i).prop('disabled', false);
                    $('.labsign'+i).show();
                }
            }
            for(i = 1; i <= 28; i++) {
                if($('#service'+i).val() == name) {
                    $('#service'+i).prop('checked', true);
                    if(name != 'Pharmacy') {
                        $('#servicecost'+i).val(transformString(cost));
                        $('#servicecost'+i).prop('disabled', false);
                        $('.servicesign'+i).show();
                    }
                }
            }
        @endforeach
    @endif

</script>
