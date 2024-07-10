@extends('resu/app1')
@section('content')

@include('sidebar')
<?php
 use App\ResuNatureInjury;
 use App\ResuBodyParts;
 use App\ResuExternalInjury;

 $nature_injury = ResuNatureInjury::all();
 $body_part = ResuBodyParts::all(); 
 $ex_injury = ResuExternalInjury::all();
?>
    <div class="col-md-8 wrapper">
    <div class="alert alert-jim">
        <h2 class="page-header">
            <i class="fa fa-user-plus"></i>&nbsp; Patient Injury Form
        </h2>
        <div class="page-divider"></div>
        <form class="form-horizontal form-submit" id="form-submit" action="">
            <div class="form-step" id="form-step-1">
                <div class="row">
                    <div class="col-md-12 col-divider">
                        <h4 class="patient-font">Disease Reporting Unit</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="facility-name">Name of Reporting Facility</label>
                                <select class="form-control chosen-select" name="facilityname" id="facility">
                                    <option value="">Select Reporting Facility</option>
                                    @foreach($facility as $fact)
                                    <option value="{{ $fact->id }}" data-address="{{$fact->address}}" data-hospital_type="{{ $fact->hospital_type }}">{{ $fact->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dru">Type of DRU</label>
                                <input type="text" class="form-control" name="typedru" id="typedru" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="address-facility">Address of Reporting Facility</label>
                                <input type="text" class="form-control" name="addressfacility" id="addressfacility" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Type of Patient</label>
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="ER name="ER" value="ER"> ER
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="OPD" name="OPD" value="OPD"> OPD
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="In_Patient" name="In_Patient" value="In-Patient"> In-Patient
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="BHS" name="BHS" value="BHS"> BHS
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="RHU" name="RHU" value="RHU"> RHU
                                    </label>
                                </div><br>
                            </div>
                        </div>
                        <h4 class="patient-font mt-4">General Data</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="hospital_no">Hospital Case No.</label>
                                <input type="text" class="form-control" name="hospital_no" id="hospital_no" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lname" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" name="fname" id="fname" value="">
                            </div>
                            <div class="col-md-2">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" name="mname" id="mname" value="">
                            </div>
                            <div class="col-md-1">
                                <label for="sex">Sex</label>
                                <select class="form-control chosen-select" name="facilityname" id="facility">
                                    <option value="">Select sex</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="dateofbirth">Date Of Birth</label>
                                <input type="date" class="form-control" id="dateofbirth" name="dateBirth" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" id="age" name="age" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="province">Province</label>
                                <select class="form-control chosen-select" name="province" id="province">
                                    <option value="">Select Province</option>
                                    @foreach($province as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="municipal">Municipal</label>
                                <select class="form-control chosen-select" name="municipal" id="municipal">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Barangay</label>
                                <select class="form-control chosen-select" name="barangay" id="barangay">
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label for="phil_no">PhilHealth No.</label>
                                <input type="text" class="form-control" name="phil_no" id="phil_no" value=""><br>
                            </div>
                        </div>
                        <h4 class="patient-font mt-4">Pre-admission Data</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Place Of Injury:</label>
                            </div>
                            <div class="col-md-3">
                                <label for="province">Province</label>
                                <select class="form-control chosen-select" name="provinceInjury" id="provinceId">
                                    <option value="">Select Province Injury</option>
                                    @foreach($province as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="municipal">Municipal</label>
                                <select class="form-control chosen-select" name="municipal_injury" id="municipal_injury">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Barangay</label>
                                <select class="form-control chosen-select" name="barangay_injury" id="barangay_injury">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Purok/Sitio</label>
                                <input type="text" class="form-control" name="purok_injury" id="purok_injury" value="" placeholder="Enter purok/Sitio">
                            </div>
                            <div class="col-md-6">
                                <label>Date and Time Injury:</label>
                                <input type="date" class="form-control" name="date_injury" id="date_injury" value="">
                                <input type="time" class="form-control" name="time_injury" id="time_injury" value="">
                            </div>
                            <div class="col-md-6">
                                <label>Date and Time Consultation:</label>
                                <input type="date" class="form-control" name="date_consultation" id="date_consultation" value="">
                                <input type="time" class="form-control" name="time_consultation" id="time_consultation" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                        <button type="button" class="btn btn-primary mx-2" onclick="showNextStep()">Next</button>
                    </div>
                </div>
            </div>
            <div class="form-step" id="form-step-2" style="display: none;">
                <div class="row">
                    
                    <div class="col-md-12">
                        <div>
                            <label>Injury Intent:</label>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-1">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="Accidental" id="Accidental" value="Unintentional/Accidental"> Unintentional/Accidental
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="Selfinflicted" id="Selfinflicted" value="Intentional (Self-inflicted)"> Intentional (Self-inflicted)
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="Violence" id="Violence" value="Intentional/(Violence)"> Intentional/(Violence)
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="Undetermined" id="Undetermined" value="Undetermined"> Undetermined
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="VAWCPatient" id="VAWCPatient" value="VAWC Patient"> VAWC Patient
                        </label>
                    </div>
                  
                    <div class="col-md-12">  <hr>
                        <label>First Aid Given:</label>
                    </div>

                    <div class="col-md-1 col-md-offset-2">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="firstAidYes" id="firstAidYes" value="Yes"> Yes
                        </label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="druWhat" id="druWhat" placeholder="What:" style="display: none;">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="druByWhom" id="druByWhom" placeholder="By whom:" style="display: none;">
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="firstAidNo" id="firstAidNo" value="No"> No
                    </div>


                    <!----------------------------- Nature of Injury ------------------------------>
                    <div class="col-md-12">
                        <hr>
                        <label>Nature of Injuries:</label>
                    </div>

                    <div class="col-md-3 col-md-offset-1">
                        <p>multiple Injuries? &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="multiple_injured" name="multiple_injured" value="Yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="single_injured" name="single_injured" value="No"> No</p>
                    </div>
                    <div class="col-md-12 col-md-offset-.05">
                        <p class="underline-text text-center" id="underline-text">
                            Check all applicable, indicate in the blank space opposite each type of injury the body location [site] and affected and other details
                        </p>
                    </div>
                    <div class="col-md-3">
                        @php
                            $counter = 0;
                        @endphp
                        @foreach($nature_injury as $injured)

                            @php
                                $cleaned_nature = preg_replace('/[\/,]/', ' ', $injured->name);              
                                $natureSingle = explode(' ', trim($cleaned_naturel))[0];
                            @endphp

                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="InjuredBurn" name="InjuredBurn" value="{{$injured->id}}"> {{$injured->name}}
                                    </label><br>

                                    [ Degree:<label>
                                        <input type="radio" id="Degree1" name="Degree1" value="Degree 1">
                                        1
                                    </label>
                                    <label>
                                        <input type="radio" id="Degree2" name="Degree2" value="Degree 2">
                                        2
                                    </label>
                                    <label>
                                        <input type="radio" id="Degree3" name="Degree3" value="Degree 3">
                                        3
                                    </label>
                                    <label>
                                        <input type="radio" id="Degree4" name="Degree4" value="Degree 4">
                                        4
                                    </label> ]
                                </div>
                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="fractureNature" name="fractureNature" value="{{$injured->id}}"> {{$injured->name}}
                                    </label><br>
                                    <div class="col-md-offset-5">
                                        <input type="checkbox" id="clostype" name="closetype" value="close type"> Close Type
                                    </div>
                                    <div class="col-md-offset-5"><br>
                                        <input type="checkbox" id="opentype" name="opentype" value="opentype"> Open Type
                                    </div>
                                </div>  
                            @elseif($injured->name == "others" || $injured->name == "other" || $injured->name == "Other" || $injured->name == "Others")
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="Others_nature_injured" name="Others_nature_injured" value="{{$injured->id}}"> {{$injured->name}}: Please specify injury and the body parts affected: 
                                    </label>
                                    <input type="text" class="form-control" id="other_nature_datails" name="other_nature_datails" id="other_nature_injury">
                                </div>
                            @else
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="nature{{$counter}}" name="nature{{$counter}}" value="{{ $injured->id}} "> {{$injured->name}}
                                    </label>
                                    <input type="text" class="form-control" name="nature_details{{$counter}}" id="nature_details{{$counter}}" placeholder="Enter details">
                                </div>
                            @endif
                            @php
                                $counter++;
                            @endphp
                        @endforeach
                    </div>

                    <div class="col-md-3">
                        @foreach($nature_injury as $injured)
                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <br>
                                <input type="text" class="form-control" id="burnDetail" name="burnDetail" id="burn" placeholder="burn details">
                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")
                                
                                <label>fracture details</label>
                                <input type="text" class="form-control" name="fracture_close_detail" id="fracture_close_detail" placeholder=" fracture close type details">
                                <input type="text" class="form-control" name="fracture_open_detail" id="fracture_open_detail" placeholder=" fracture open type details">
                            @elseif($injured->name == "others" || $injured->name == "other" || $injured->name == "Other" || $injured->name == "Others")
                                <br>
                                <label>Select side</label>
                                <select class="form-control" name="side_others" id="side_others">
                                    <option value="">Select Side for Others</option>
                                    <option value="right">right</option>
                                    <option value="left">left</option>
                                </select>
                            @else
                                <label>Select side</label>
                                <select class="form-control" name="side{{$counter}}" id="side{{$counter}}">
                                    <option value="">Select Side for {{$injured->name}}</option>
                                    <option value="right">right</option>
                                    <option value="left">left</option>
                                </select>
                            @endif
                            @php
                                $counter++;
                            @endphp
                        @endforeach
                        <!----------------------------- Nature of Injury ------------------------------>
                    </div>
                    <div class="col-md-3">
                        @foreach($nature_injury as $injured)
                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <br>
                                <label>Select Side</label>
                                <select class="form-control" name="burnside" id="burnside">
                                    <option value="">Select Side for burn</option>
                                    <option value="right">right</option>
                                    <option value="left">left</option>
                                </select>
                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")
                                <label>Select side</label>
                                <select class="form-control" name="opentype_side" id="opentype_side" value="">
                                    <option value="">Select side close type</option>
                                    <option value="right">right</option>
                                    <option value="left">left</option>
                                </select>
                                <select class="form-control" name="closetype_side" id="closetype_side" value="">
                                    <option value="">Select side open type</option>
                                    <option value="right">right</option>
                                    <option value="left">left</option>
                                </select>
                            @elseif($injured->name == "others" || $injured->name == "other" || $injured->name == "Other" || $injured->name == "Others")
                                <br><br>
                                <label>Select Body parts</label>
                                <select class="form-control chosen-select" name="body_parts_others" id="body_parts_others" value="">
                                    <option value="">Select body parts for Others</option>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <label>Select Body Parts</label>
                                <select class="form-control chosen-select" name="body_parts{{counter}}" id="body_parts{{counter}}" value="">
                                    <option value="">Select body parts for {{$injured->name}}</option>
                                    @foreach($body_part as $body_parts)
                                        <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            @php
                                $counter++;
                            @endphp
                        @endforeach
                    </div>
                    <div class="col-md-3">
                        @foreach($nature_injury as $injured)
                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <br><br><br><br><br><br><br>
                                <select class="form-control chosen-select" name="burn_body_parts" id="burn_body_parts" value="">
                                    <option value="">Select body parts for burn</option>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")    
                                <br><br><br><br><br><br><br><br>
                                <select class="form-control chosen-select" name="burnOpen_bodyparts" id="burnOpen_bodyparts" value="">
                                    <option value="">Select body parts for close type fracture</option>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                                <select class="form-control chosen-select" name="burnclose_bodyparts" id="burnclose_bodyparts" value="">
                                    <option value="">Select body parts for Open type fracture</option>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                        <button type="button" class="btn btn-primary mx-2"  onclick="showPreviousStep()">Previous</button>
                        <button type="button" class="btn btn-primary mx-2" onclick="showNextStep()">Next</button>
                    </div>
                </div>
            </div>
            <div class="form-step" id="form-step-3" style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <label>External Causes/s of Injur/ies:</label>
                        </div>
                    </div>
                    @php
                        $counter = 0;
                    @endphp
                    @foreach($ex_injury as $exInjury)
                        @php
                            $cleaned_external = preg_replace('/[\/,]/', ' ', $exInjury->name);              
                            $externalSingle = explode(' ', trim($cleaned_external))[0];
                        @endphp
                        @if($externalSingle == 'Burns' || $externalSingle == 'Burn')     
                            <div class="col-md-12">
                                <label>
                                    <input type="checkbox" id="ex_burn" name="ex_burn" value="{{$exInjury->id}}"> {{$exInjury->name}}
                                </label><br>
                                <div class="col-md-5">
                                
                                    <div class="checkbox">
                                        <label>
                                            <input type="radio" name="heat" id="heat" value="heat">
                                            Heat
                                        </label>
                                        <label>
                                            <input type="radio" name="fire" id="fire" value="fire">
                                            fire
                                        </label>
                                        <label>
                                            <input type="radio" name="electricity" id="electricity" value="Electricity">
                                            Electricity
                                        </label>
                                        <label>
                                            <input type="radio" name="Oil" id="oil" value="Oil">
                                            Oil
                                        </label>
                                        <label>
                                            <input type="radio" name="friction" id="friction" value="friction">
                                            friction
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control inline-input2" name="exburnDetails" id="exburnDetails" placeholder="specify here"><br>
                                </div>
                            </div>
                        @elseif($externalSingle == "Drowning" || $externalSingle == "drowning")
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <label>
                                        <input type="checkbox" id="exDrowning" name="exDrowning" value="{{ $exInjury->id }}"> {{$exInjury->name}}: Type/Body of Water:
                                    </label><br>
                                    <div class="col-md-5">
                                    
                                        <div class="checkbox">
                                            <label>
                                                <input type="radio" name="Sea" id="Sea" value="Sea">
                                                Sea
                                            </label>
                                            <label>
                                                <input type="radio" name="River" id="River" value="River">
                                                River
                                            </label>
                                            <label>
                                                <input type="radio" name="Lake" id="Lake" value="Lake">
                                                Lake
                                            </label>
                                            <label>
                                                <input type="radio" name="Pool" id="Pool" value="Pool">
                                                Pool
                                            </label>
                                            <label>
                                                <input type="radio" name="BathTub" id="bath_tub" value="Bath Tub">
                                                Bath Tub
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control inline-input2" name="exdrowning_Details" id="exdrowningDetails" placeholder="specify here"><br>
                                </div>
                            </div>
                        @elseif($externalSingle == "Transport")
                            <div class="col-md-12"></div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="Transport" name="externalTransport" value="{{$exInjury->id}}"> <strong>{{$exInjury->name}}</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="external_details{{$counter}}" id="external_details{{$counter}}" placeholder="Enter details">
                                </div>
                        @else
                            <div class="col-md-12"></div>
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="{{$externalSingle}}" name="external{{$counter}}" value="{{$exInjury->id}}"> <strong>{{$exInjury->name}}</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="external_details{{$counter}}" id="external_details{{$counter}}" placeholder="Enter details">
                            </div>
                            @php    
                            $counter++;
                            @endphp
                        @endif
                    @endforeach
                </div>


                <div class="row">
                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                        <button type="button" class="btn btn-primary mx-2"  onclick="showPreviousStep()">Previous</button>
                        <button type="button" class="btn btn-primary mx-2" onclick="showNextStep()">Next</button>
                    </div>
                </div>
            </div>
            <div class="form-step" id="form-step-4" style="display: none;">
               <div class="row">
                <!-- for Transport Group -->
                <div class="Transport-group" style="display: none;">        
                    <div class="col-md-12 transport-related">
                        <label>For Transport Vehicular Accident Only:</label>
                    </div>
                    <div class="col-md-3 transport-related">&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="land" name="land" value="land"> Land
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="checkbox" id="water" name="water" value="water"> Water
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="checkbox" id="air" name="air" value="Air"> Air
                    </div>
                    <div class="col-md-3 transport-related"> 
                        <input type="checkbox" id="collision" name="collision" value="Collision"> Collision&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="checkbox" id="non_collision" name="none-collision" value="Non-Collision"> Non-Collision
                    </div>
                    <div class="col-md-6 transport-related"><hr>
                        <label>Vehicles Involved:</label>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patient's Vehicle</p>
                        <div class="col-md-4">&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="none_pedes" name="none_pedes" value="None (Pedestrian)"> None (Pedestrian)<br>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="patient_motorcycle" name="patient_motorcycle" value="Motorcycle"> Motorcycle<br>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="patient_truck" name="patient_truck" value="Truck"> Truck<br>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="patient_bus" name="patient_bus" value="Bus"> Bus<br>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="patient_jeepney" name="patient_jeepney" value="Jeepney"> Jeepney
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="patient_car" name="patient_car" value="Car"> Car<br>
                            <input type="checkbox" id="patient_bicycle" name="patient_bicycle" value="Bicycle"> Bicycle<br>
                            <input type="checkbox" id="patient_van" name="patient_van" value="Van"> Van<br>
                            <input type="checkbox" id="patient_tricycle" name="patient_tricycle" value="Tricycle"> Tricycle
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="patient_unknown" name="patient_unknown" value="Unknown"> Unknown<br>
                            <input type="checkbox" id="patient_others" name="patient_others" value="others"> Others<br>
                            <input type="text" class="form-control" name="patient_other_details" placeholder="others details">
                        </div>
                        <div class="col-md-12"><br>
                            <p>Other Vehicle/Object Involved (for Collision accident only)</p>
                            <div class="col-md-3">
                                <input type="checkbox" id="objectNone" name="objectNone" value="None"> None<br>
                                <input type="checkbox" id="objectbicycle" name="objectbicycle" value="Bicycle"> Bicycle<br>
                                <input type="checkbox" id="objectcar" name="objectcar" value="Car"> Car<br>
                                <input type="checkbox" id="objectjeepney" name="objectjeepney" value="Jeepney"> Jeepney
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="objectvan" name="objectvan" value="Van"> Van<br>
                                <input type="checkbox" id="objectbus" name="objectbus" value="Bus"> Bus<br>
                                <input type="checkbox" id="objecttruck" name="objecttruck" value="truck"> truck<br>
                                <input type="checkbox" id="objectothers" name="objectothers" value="Others"> Others:
                                <input type="text" class="form-control" id="object_other_details" name="object_other_details" placeholder="others details">
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="objectmotorcycle" name="objectmotorcycle" value="Motorcycle"> Motorcycle<br>
                                <input type="checkbox" id="objectTricycle" name="objectTricycle" value="Tricycle"> Tricycle<br>
                                <input type="checkbox" id="objectunknown" name="objectunknown" value="unknown"> Unknown
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 transport-related"><hr><br>
                        <p>Position of Patient</p>
                        <input type="checkbox" id="position_pedes" name="position_pedes" value="Pedestrian"> Pedestrian<br>
                        <input type="checkbox" id="position_driver" name="position_driver" value="Driver"> Driver<br>
                        <input type="checkbox" id="position_captain" name="position_captain" value="Captain"> Captain<br>
                        <input type="checkbox" id="position_pilot" name="position_pilot" value="Pilot"> Pilot
                        <input type="checkbox" id="position_passenger" name="position_passenger" value="Font Passenger"> Front Passenger<br>
                        <input type="checkbox" id="position_rear_passenger" name="position_rear_passenger" value="Rear Passenger"> Rear Passenger<br>
                        <input type="checkbox" id="position_others" name="position_others" value="Others"> Others:<br>
                        <input type="text" class="form-control" id="position_other_details" name="position_other_details" placeholder="others details">
                        <input type="checkbox" id="position_unknown" name="position_unknown" value="Unknown"> Unknown

                    </div>
                    <div class="col-md-3 transport-related"><hr><br>
                        <p>Place of Occurrence</p>
                        <input type="checkbox" id="place_home" name="place_home" value="Home"> Home<br>
                        <input type="checkbox" id="place_school" name="place_school" value="School"> School<br>
                        <input type="checkbox" id="place_Road" name="place_Road" value="Road"> Road<br>
                        <input type="checkbox" id="place_Bars" name="place_Bars" value="School"> Videoke Bars<br>
                        <input type="checkbox" id="place_workplace" name="place_workplace" value="workplace"> Workplace, specify:<br>
                        <input type="text" class="form-control" id="place_workplace_details" name="place_workplace_details" placeholder="specify here">
                        <input type="checkbox" id="place_others" name="place_others" value="Others"> Others:<br>
                        <input type="text" class="form-control" id="place_other_details" name="place_other_details" placeholder="others details">
                        <input type="checkbox" id="place_unknown" name="place_unknown" value="Unknown"> Unknown
                    </div>
                    <div class="col-md-12 transport-related">
                        <div class="col-md-4"><hr>
                            <label>Activity of the patient at the of incident</label><br>
                            <input type="checkbox" id="activity_sports" name="activity_sports" value="Sports"> Sports<br>
                            <input type="checkbox" id="activity_leisure" name="activity_leisure" value="leisure"> Leisure<br>
                            <input type="checkbox" id="activity_school" name="activity_school" value="School"> Work Related<br>
                            <input type="checkbox" id="activity_others" name="activity_others" value="Others"> Others:
                            <input type="text" class="form-control" id="activity_other_details" name="activity_other_details" placeholder="others details">
                            <input type="checkbox" id="activity_unknown" name="activity_unknown" value="unknown"> Unknown
                        </div>
                        <div class="col-md-4"><hr>
                            <label>Other Risk Factors at the time of the incident:</label><br>
                            <input type="checkbox" id="risk_liquor" name="risk_liquor" value="Alcohol/liquor"> Alcohol/liquor<br>
                            <input type="checkbox" id="risk_mobilephone" name="risk_mobilephone" value="Using Mobile Phone"> Using Mobile Phone<br>
                            <input type="checkbox" id="risk_sleepy" name="risk_sleepy" value="Sleepy"> Sleepy<br>
                            <input type="checkbox" id="risk_smooking" name="risk_smooking" value="smooking"> Smooking<br>
                            <input type="checkbox" id="risk_others" name="risk_others" value="Others"> Others specify:
                            <input type="text" class="form-control" id="risk_others_details" name="risk_others_details" placeholder="others specify here">
                            <p>(eg. Suspected under the influence of substance used)</p>
                        </div>
                        <div class="col-md-4"><hr>
                            <label>Safety: (check all that apply)</label>
                            <div class="col-md-6">
                                <input type="checkbox" id="safe_none" name="safe_none" value="None"> None<br>
                                <input type="checkbox" id="safe_childseat" name="safe_childseat" value="Childseat"> Childseat<br>
                                <input type="checkbox" id="safe_Airbag" name="safe_Airbag" value="Airbag"> Airbag<br>
                                <input type="checkbox" id="safe_smooking" name="safe_smooking" value="smooking"> Lifevest/Lifejacket/flotation device<br>
                                <input type="checkbox" id="safe_others" name="safe_others" value="Others"> Others specify:
                                <input type="text" class="form-control" id="safeothers_details" name="safeothers_details" placeholder="others specify here">
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" id="safeunknown" name="safeunknown" value="unknown"> Unknown<br>
                                <input type="checkbox" id="safehelmet" name="safehelmet" value="Helmet"> Helmet<br>
                                <input type="checkbox" id="safeSeatbelt" name="safeSeatbelt" value="Seatbelt"> Seatbelt<br>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end of transport-group -->
                    
                    <div class="col-md-12"><hr>
                        <h4 class="patient-font mt-4">Hospital/Facility Data</h4>
                        <div class="A_ErOpdGroup">
                            <h6 class="A_Hospital mt-5"> 
                            <input type="checkbox" id="A_ErOpd" name="A_ErOpd" value="A. ER/OPD/BHS/RHU">
                            A. ER/OPD/BHS/RHU</h6>
                            <div class="col-md-12">
                                <label for="transferred facility">Transferred from another hospital/facility</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="YesTransferred" name="YesTransferred" value="Yes"> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="NoTransferred" name="NoTransferred" value="No"> No <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="referred by hospital">Referred by another Hospital/Facility for Laboratory and/or other medical procedures</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="ReferredYes" name="ReferredYes" value="Yes"> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="Referredno" name="Referredno" value="No"> No <br><hr>
                            </div>
                            <div class="col-md-12">
                                <label for="nameofphysician">Name of the Originating Hospital/Physician:</label>
                                <input type="text" class="form-control" id="name_orig" name="name_orig" placeholder="Name of the Originating Hospital/Physician">
                            </div>
                            <div class="col-md-12"><hr></div>
                            <div class="col-md-3">
                                <label for="">Status upon reashing the Facility</label>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="deadonarrive" name="deadonarrive" value=" Dead on Arrival"> Dead on Arrival
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" id="alive" name="alive" value="Alive"> Alive
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="ifalive" name="ifalive" value="If Alive"> If Alive
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="conscious" name="conscious" value="conscious"> conscious
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="Unconscious" name="Unconscious" value="Unconscious"> Unconscious
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-3">
                                <label for="">Mode of Transport to the Hospital/Facility</label>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="ambulance" name="ambulance" value="Ambulance"> Ambulance
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="police_vehicle" name="police_vehicle" value="Police Vehicle"> Police Vehicle
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="private_vehicle" name="private_vehicle" value="Private Vehicle"> Private Vehicle
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" id="ModeOthers" name="ModeOthers" value="Others"> Others
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="mode_others_details" name="mode_others_details" placeholder="others specify here">
                            </div>
                            <div class="col-md-12"><hr>
                            <label for="initial_imp">Initial Impression</label>
                                <input type="text" class="form-control" id="Initial_Impression" name="Initial_Impression" > <br>
                            </div>
                            <div class="col-md-6">
                                <label for="">ICD-10 Code/s: Nature of imjury</label>
                                <input type="text" class="form-control" id="icd10_nature" name="icd10_nature" id="icd10_nature">    
                            </div>
                            <div class="col-md-6">
                                <label for="">ICD-10 Code/s: External Cause injury</label>
                                <input type="text" class="form-control" id="icd10_external" name="icd10_external" id="icd10_external">
                            </div>
                            <div class="col-md-12"><hr>
                                <div class="col-md-1">
                                    <label for="Disposition">Disposition:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="admitted" name="admitted" value="Admitted"> Admitted <br>
                                    <input type="checkbox" id="hama" name="hama" value="HAMA"> HAMA
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="treated_sent" name="treated_sent" value="Treated and Sent Home"> Treated and Sent Home <br>
                                    <input type="checkbox" id="Absconded" name="Absconded" value="Absconded"> Absconded
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="trans_facility_hos" name="trans_facility_hos" value="Transferred to Another facility/hospital"> Transferred to Another facility/hospital, <br>
                                    <input type="text" class="form-control" id="trans_facility_hos_details" name="trans_facility_hos_details" value="" placeholder="Please specify">
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="refused_admiss" name="refused_admiss" value="Refused Admission"> Refused Admission <br>
                                    <input type="checkbox" id="died" name="died" value="died"> Died
                                </div>
                            </div>
                            <div class="col-md-12"><hr>
                                <div class="col-md-2">
                                    <label for="Outcome">Outcome</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="Improved" name="Improved" value="Improved"> Improved
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="Unimproved" name="Unimproved" value="Unimproved"> Unimproved
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="Died1" name="Died1" value="died"> Died
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="B_InpatientGroup">
                        <div class="col-md-12"><hr class="Inpatient_linehr">
                            <h6 class="A_Hospital mt-5"> 
                            <input type="checkbox" id="B_InPatient" name="In-Patient" value="In-Patient(for admitted hospital cases only)">
                            B. In-Patient(for admitted hospital cases only)</h6>
                            <div class="col-md-12">
                                <label for="complete_final">Complete Final Diagnosis</label>
                                <input type="text" class="form-control" id="complete_final" name="complete_final" id="" value="">
                            </div>
                            <div class="col-md-12"><hr>

                                <label for="Disposition">Disposition:</label><br>
                                <div class="col-md-3 col-md-offset-1">
                                    <input type="checkbox" id="discharged" name="discharged" value="discharged"> Discharged <br>
                                    <input type="checkbox" id="refused_admiss1" name="refused_admiss1" value="Refused Admission"> Refused Admission
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="HAMA1" name="HAMA1" value="HAMA"> HAMA <br>
                                    <input type="checkbox" id="died2" name="died2" value="died"> Died
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="trans_facility_hos2" name="trans_facility_hos2" value="Transferred to Another facility/hospital"> Transferred to Another facility/hospital <br>
                                    <input type="text" class="form-control" id="trans_facility_hos_details2" name="trans_facility_hos_details2" value="" placeholder="Please specify">
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="absconded1" name="absconded1" value="Absconded"> Absconded <br>
                                    <input type="checkbox" id="disposition_others" name="disposition_others" value="Others"> Others 
                                    <input type="textbox" class="form-control" id="disposition_others_details" name="disposition_others_details" value="others specify here">
                                </div>
                            </div>
                            <div class="col-md-12"><hr>
                                <label for="Outcome">Outcome</label><br>
                                <div class="col-md-2 col-md-offset-1">
                                    <input type="checkbox" id="Improved1" name="Improved1" value="Improved"> Improved
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="Unimproved1" name="Unimproved1" value="Unimproved"> Unimproved
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="died1" name="died1" value="died"> Died
                                </div>
                            </div>
                            <div class="col-md-6"><br>
                                <label for="">ICD-10 Code/s: Nature of imjury</label>
                                <input type="text" class="form-control" id="icd10_nature1" name="icd10_nature1">    
                            </div>
                            <div class="col-md-6"><br>
                                <label for="">ICD-10 Code/s: External Cause injury</label>
                                <input type="text" class="form-control" id="icd10_external1" name="icd10_external1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                        <button type="button" class="btn btn-primary mx-2" onclick="showPreviousStep()">Previous</button>
                        <button type="submit" class="btn btn-primary mx-2" onclick="submitPatientForm()">Submit</button>
                    </div>
            </div>
        </form>
    </div>
</div>

@endsection


<style>
    .col-divider { 
        border-right: 1px solid #ddd;
    }
    .col-md-8 .patient-font{
        background-color: #727DAB;
        color: white; 
        padding: 3px;
    }
    .col-md-6 .mt-4 {
            margin-top: 10px; /* Adjust this value as needed */
        }
    .col-md-12 .underline-text{
        text-decoration: underline;

    }
    .ex_type{
        font-size: 12px;
    }
    .col-md-6 .others{
        border: none;
        border-bottom: 1px solid black; /* Only bottom border */
        outline: none; /* Remove default outline */
        transition: border-bottom-color 0.3s;
        width: 7em
    }
    .col-md-12 .A_Hospital{
        background-color: #A1A8C7;
        color: #ffff;
        padding: 3px;
        margin-top: -10px;
    }
  
   .col-md-6 .small-input {
    width: 50%; /* Adjust this value to set the desired width */
    max-width: 100%; /* Ensure it does not exceed the container's width */
}
  .indention{
    border-top: 1px solid black; 
    margin-bottom: 3px;
  }
  .mt-3{
    margin-top: 5px;
  }
 .row .inline-input{
    display: inline-block;
    width: 275;
    margin-left: 96px; /* Adjust as necessary */
    vertical-align: middle;
 }
 .col-md-12 .col-md-3 .inline-input2{
    
    margin-left: -100px; /* Adjust as necessary */
    flex-shrink: 0;
 }

</style>