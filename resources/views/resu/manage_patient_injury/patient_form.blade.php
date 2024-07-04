@extends('resu/app1')
@section('content')
<?php
 use App\ResuNatureInjury;
 use App\ResuBodyParts;
 use App\ResuExternalInjury;

 $nature_injury = ResuNatureInjury::all();
 $body_part = ResuBodyParts::all(); 
 $ex_injury = ResuExternalInjury::all();
?>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">
            <i class="fa fa-user-plus"></i>&nbsp; Patient Injury Form</h2>
            <div class="page-divider"></div>
            <form method="POST" class="form-horizontal form-submit" id="form-submit" action="">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6 col-divider">

                        <h4 class="patient-font">Disease Reporting Unit</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="facility-name">Name of Reporting Facility</label>
                                <input type="text" class="form-control" name="facilityname" value="" id="facility-name">
                            </div>
                            <div class="col-md-6">
                                <label for="dru">Type of DRU</label>
                                <input type="text" class="form-control" name="dru" value="" id="dru">
                            </div>
                            <div class="col-md-6">
                                <label for="address-facility">Address of Reporting Facility</label>
                                <input type="text" class="form-control" name="facility-add" value="" id="address-facility">
                            </div>
                            <div class="col-md-6">
                                <label>Type of Patient</label>
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType1" value="ER"> ER
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType2" value="OPD"> OPD
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType3" value="In-Patient"> In-Patient
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType4" value="BHS"> BHS
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType5" value="RHU"> RHU
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h4 class="patient-font mt-4">General Data</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="hospital_no">Hospital Case No.</label>
                                <input type="text" class="form-control" name="hospital_no" id="hospital_no">
                            </div>
                            <div class="col-md-3">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lname">
                            </div>
                            <div class="col-md-3">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" name="fname" id="fname">
                            </div>
                            <div class="col-md-2">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" name="mname" id="mname">
                            </div>
                            <div class="col-md-1">
                                <label for="sex">Sex</label>
                                <input type="text" class="form-control" name="sex" id="sex">
                            </div>
                            <div class="col-md-3">
                                <label for="dateofbirth">Date Of Birth</label>
                                <input type="date" class="form-control" id="dateofbirth" name="dateBirth">
                            </div>
                            <div class="col-md-3">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" id="age" name="age" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="province">Province</label>
                                <select class="form-control" name="province">
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="municipal">Municipal</label>
                                <select class="form-control" name="municipal">
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Barangay</label>
                                <select class="form-control" name="barangay">
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label for="phil_no">PhilHealth No.</label>
                                <input type="text" class="form-control" name="phil_no" id="phil_no">
                            </div>
                        </div>

                        <h4 class="patient-font mt-4">Pre-admission Data</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Place Of Injury:</label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="permanent_add">
                                    <option value="">Select Province</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="permanent_add">
                                    <option value="">Select Municipal</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="permanent_add">
                                    <option value="">Select Barangay</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Date and Time Injury:</label>
                                <input type="date" class="form-control" name="date_injury" placeholder="Enter date">
                                <label></label>
                                <input type="time" class="form-control" name="time_injury" placeholder="Enter time">
                            </div>
                            <div class="col-md-6">
                                <label>Date and Time Consultation:</label>
                                <input type="date" class="form-control" name="date_consultation" placeholder="Enter date">
                                <label></label>
                                <input type="time" class="form-control" name="time_consultation" placeholder="Enter time">
                            </div>
                            <div class="col-md-2">
                                <label>Injury Intent:</label>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType1" value="ER"> Unintentional/Accidental
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType1" value="ER"> Intentional (Self-inflicted)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="patientType1" value="ER"> Unintentional/Accidental
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="patientType1" value="ER"> Intentional (Self-inflicted)
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="patientType1" value="ER"> Unintentional/Accidental
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>First Aid Given:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="patientType1" value="Yes"> Yes
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="dru" id="dru" placeholder="What:">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="dru" id="dru" placeholder="By whom:">
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="patientType1" value="No"> No
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-3"></div>
                            <div class="indention"></div>
                            <div class="col-md-12">
                                <label>Nature of Injuries:</label>
                            </div>
                            <div class="col-md-3">
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;multiple Injuries?</p>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="patientType1" value="Yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="patientType2" value="No"> No
                            </div>
                            <div class="col-md-12">
                                <p class="underline-text text-center">Check all applicable, indicate in the blank space opposite each type of injury the body location [site] and affected and other details</p>
                            </div>
                            <div class="col-md-12">
                                @foreach($nature_injury as $injured)
                                        <div>
                                            @if($injured->id == 5)
                                            <input type="checkbox" id="Abrasion" name="{{$injured->name}}" value="{{$injured->id}}"> {{$injured->name}}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            [Degree 
                                            <input type="radio" id="degree1" name="burnDegree" value="Degree1"> 1 
                                            <input type="radio" id="degree2" name="burnDegree" value="Degree2"> 2 
                                            <input type="radio" id="degree3" name="burnDegree" value="Degree3"> 3 
                                            <input type="radio" id="degree4" name="burnDegree" value="Degree4"> 4]
                                            &nbsp;<input type="text" name="BurnDetail" placeholder="Burn Detail">
                                            
                                            <select name="side">
                                                    <option value="">Select Side</option>
                                                    <option value="left">left</option>
                                                    <option value="right">right</option>
                                             </select>
                                            
                                             <select name="body_part" >
                                                    <option value="">Select Body Part</option>
                                                    <option value=""></option>
                                             </select>
                                       
                                            @elseif($injured->id == 8)

                                            <div>
                                                <input type="checkbox" id="injury5" value="Fracture"> Fracture
                                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="checkbox" id="close_type" name="close_type" value="Close Type"> Close Type<strong>:</strong>&nbsp;<input type="text" name="closetype_details" placeholder="Close Type Detail">
                                                   
                                                    <select name="side">
                                                        <option value="">Select Side</option>
                                                        <option value="left">left</option>
                                                        <option value="right">right</option>
                                                    </select>

                                                    <select name="body_part">
                                                        <option value="">Select Body Part</option>
                                                        <option value="left">left</option>
                                                        <option value="right">right</option>
                                                    </select>
                                                   
                                                    <p class="ex_type">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                                                    (ex. Comminuted, depressed fracture)</p>
                                                <div class="col-md-12">
                                                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="open_type" name="Open_type" value="Open Type"> Open Type<strong>:</strong>&nbsp;<input type="text" name="opentype_details" placeholder="Open Type Detail">
                                                    
                                                    <select name="side">
                                                        <option value="">Select Side</option>
                                                        <option value="left">left</option>
                                                        <option value="right">right</option>
                                                    </select>
                                                    <select name="body_part">
                                                        <option value="">Select Body Part</option>
                                                        <option value="left">left</option>
                                                        <option value="right">right</option>
                                                    </select>

                                                    <p class="ex_type">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                                                    (ex. Compound, infected fracture)</p>
                                                </div>

                                            </div>
                                            @elseif($injured->id == 11)
                                                <div>
                                                    <input type="checkbox" id="injury5" value="Others"> Others: Please Specify injury and the body parts affected:&nbsp;<input type="text" name="OthersDetail" placeholder="Others Detail">
                                                    
                                                    <select name="side">
                                                        <option value="">Select Side</option>
                                                        <option value="left">left</option>
                                                        <option value="right">right</option>
                                                    </select>

                                                    <select name="body_part">
                                                        <option value="">Select Body Part</option>
                                                        <option value="left">left</option>
                                                        <option value="right">right</option>
                                                    </select>

                                                </div> 
                                            @elseif($injured->id !=5 && $injured->id != 8 &&  $injured->id != 11)
                                            <input type="checkbox" id="Abrasion" name="Abrasion" value="{{$injured->id}}"> {{$injured->name}}
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="AbrasionDetail" placeholder="{{$injured->name}} details">
                                                
                                                <select name="side">
                                                    <option value="">Select Side</option>
                                                    <option value="left">left</option>
                                                    <option value="right">right</option>
                                                </select>

                                                <select name="body_part">
                                                    <option value="">Select Body Part</option>
                                                    <option value="left">left</option>
                                                    <option value="right">right</option>
                                                </select>
                                                
                                            @endif
                                        </div>
                                @endforeach

                                <!-- <div>
                                            <input type="checkbox" id="Abrasion" name="Abrasion" value="">Abrasion
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="AbrasionDetail" placeholder="Abration Detail">
                                        </div>
                                        <div>
                                            <input type="checkbox" id="Avulsion" name="Avulsion" value="Avulsion"> Avulsion
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="AvulsionDetail" placeholder="Avulsion Detail">
                                        </div>
                                        <div>
                                            <input type="checkbox" id="injury3" value="Burn"> Burn
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            [Degree 
                                            <input type="radio" id="degree1" name="burnDegree" value="Degree1"> 1 
                                            <input type="radio" id="degree2" name="burnDegree" value="Degree2"> 2 
                                            <input type="radio" id="degree3" name="burnDegree" value="Degree3"> 3 
                                            <input type="radio" id="degree4" name="burnDegree" value="Degree4"> 4]
                                            &nbsp;<input type="text" name="BurnDetail" placeholder="Burn Detail">
                                        </div>
                                        <div>
                                            <input type="checkbox" id="injury4" value="Concussion"> Concussion
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ConcussionDetail" placeholder="Concussion Detail">
                                        </div>
                                        <div>
                                            <input type="checkbox" id="injury5" value="Contusion"> Contusion
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ContusionDetail" placeholder="Contusion Detail">
                                        </div>
                                        <div>
                                            <input type="checkbox" id="injury5" value="Fracture"> Fracture
                                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" id="close_type" name="close_type" value="Close Type"> Close Type<strong>:</strong>&nbsp;<input type="text" name="closetype_details" placeholder="Close Type Detail">
                                                <p class="ex_type">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                                                (ex. Comminuted, depressed fracture)</p>
                                            <div class="col-md-12">
                                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="checkbox" id="open_type" name="Open_type" value="Open Type"> Open Type<strong>:</strong>&nbsp;<input type="text" name="opentype_details" placeholder="Open Type Detail">
                                                <p class="ex_type">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                                                (ex. Compound, infected fracture)</p>
                                            </div>

                                        </div>
                                        <div>
                                            <input type="checkbox" id="injury5" value="Open Wound"> Open Wound
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="OpenWoundDetail" placeholder="Open wound Detail">
                                            <p class="ex_type">&nbsp;&nbsp;&nbsp;&nbsp;
                                                (ex. Hacking, gunshot, stabbing, animal(dog,cat,rat,snake, etc) bites,  human bites, insects bites, punctured wound laceration,etc)</p>
                                        </div>
                                        <div>
                                            <input type="checkbox" id="injury5" value="Traumatic Amputation"> Traumatic Amputation
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="TraumaticAmputationDetail" placeholder="Traumatic Amputation Detail">
                                        </div>
                                        <div>
                                            <input type="checkbox" id="injury5" value="Others"> Others: Please Specify injury and the body parts affected:&nbsp;<input type="text" name="OthersDetail" placeholder="Others Detail">
                                        </div> -->
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label>External Cause/s of Injuries:</label>
                            </div>
                            <div class="col-md-12">
                               {{-- <!-- @foreach($ex_injury as $ex)
                                    @if($ex == )

                                    @elseif($ex==)
                                    <div>
                                        <input type="checkbox" id="Abrasion" name="bites" value="bites">&nbsp;{{ $ex->name }}:
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="Bites detail">
                                    </div>
                                    @endif
                                @endforeach --> --}}
                                
                                <div>
                                    <input type="checkbox" id="Abrasion" name="bites" value="bites">&nbsp;Bites/stings/Specify animal/insect::
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="Bites detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="Avulsion" name="burns" value="burns">&nbsp; Burns

                                    [   
                                            <input type="radio" id="degree1" name="heat" value="heat">Heat 
                                            <input type="radio" id="degree2" name="fire" value="fire"> fire 
                                            <input type="radio" id="degree3" name="burnDegree" value="electricity"> Electricity 
                                            <input type="radio" id="degree4" name="burnDegree" value="oil"> Oil
                                            <input type="radio" id="degree4" name="burnDegree" value="friction"> friction<strong> :,</strong>
                                            others specify<strong>:</strong><input type="text" id="othersSpecify" name="othersSpecify" class="others"> ]

                                    &nbsp;&nbsp;&nbsp;<input type="text" name="AvulsionDetail" placeholder="burns detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="Abrasion" name="bites" value="bites">&nbsp;Chemical/Substance, specify:
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="AbrasionDetail" placeholder="chemical/substance detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="Abrasion" name="bites" value="bites">&nbsp;Contact with sharp Objects, specify object
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="AbrasionDetail" placeholder="sharp object detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="Abrasion" name="bites" value="bites">&nbsp;Drowning: Type/Body of Water<strong> :</strong>

                                             <input type="radio" id="degree1" name="sea" value="">Sea 
                                            <input type="radio" id="degree2" name="River" value=""> River 
                                            <input type="radio" id="degree3" name="lake" value="electricity"> Lake
                                            <input type="radio" id="degree4" name="pool" value="oil"> Pool
                                            <input type="radio" id="degree4" name="bathtub" value="friction"> Bath Tub
                                            <input type="radio" id="degree4" name="pool" value="oil">
                                            Others specify<strong>:</strong><input type="text" id="othersSpecify" name="othersSpecify" class="others"> ]

                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="AbrasionDetail" placeholder="drowning detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="fall" name="fall" value="fall">&nbsp;Fall:
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="fall" placeholder="fall detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="firecracker" name="firecracker" value="bites">&nbsp;Firecracker, specify type/s:
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="firecracker detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="sexual" name="bites" value="bites">&nbsp;Sexual Assault/Sexual Abure/Rape (Alleged)
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="gunshot" name="bites" value="bites">&nbsp;Gunshot, Specify Weapon
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="Gunshot detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="Hanging" name="bites" value="bites">&nbsp;Hanging Strangulation:
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="Bites detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="mauling" name="mauling" value="">&nbsp;Mauling/Assult
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="Bites detail">
                                </div>
                                <div>
                                    <input type="checkbox" id="transport" name="transport" value="">&nbsp;Transport/Vehicular Accident
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="Transport/Vehicular Accident">
                                </div>
                                <div>
                                    <input type="checkbox" id="Abrasion" name="bites" value="bites">&nbsp;Others, specify
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bite" placeholder="others detail">
                                </div>

                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="indention">
                                    <div class="mt-3">
                                        <label>For Transport Vehicular Accident Only</label>   
                                        <div> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
                                            <div class="col-md-2">
                                                <input type="checkbox" id="land" name="land" value=""> Land
                                            </div>
                                            <div class="col-md-2">
                                                <input type="checkbox" id="water" name="water" value=""> Water
                                            </div>
                                            <div class="col-md-2">
                                                <input type="checkbox" id="air" name="air" value=""> Air
                                            </div>
                                            <div class="col-md-2"> 
                                                <input type="checkbox" id="collision" name="collision" value=""> Collision&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <div class="col-md-3">
                                                <input type="checkbox" id="non-col" name="none-col" value=""> Non-Collision
                                            </div>

                                        </div>  
                                    </div>
                                </div>           
                            </div>  
                            <div class="col-md-12">
                                <div class="indention">
                                    <div class="mt-3">
                                            <div class="col-md-6">
                                                <label>Vehicles Involved:</label>
                                                <div>
                                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patient's Vehicle</p>        
                                                </div>
                                                <div>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="pedestrian" name="pedestrian" value="bites">&nbsp;None (Pedestrian)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="car" name="car" value="">&nbsp;Car
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                    <input type="checkbox" id="unknown" name="unknown" value="">&nbsp;Unknown
                                                </div>
                                                <div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="motor" name="motor" value="">&nbsp;Motorcycle
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="bicycle" name="bicycle" value="">&nbsp;Bicycle &nbsp;&nbsp; 
                                                    <input type="checkbox" id="othersvehicle" name="othersvehicle" value="">&nbsp;Other<strong>:</strong>&nbsp;&nbsp;
                                                    <input type="text" class="others" name="other_patient" value="">
                                                </div>
                                                <div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="motor" name="motor" value="">&nbsp;Truck
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="bicycle" name="bicycle" value="">&nbsp;Van &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="bus" name="bus" value="">&nbsp;Bus
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                    <input type="checkbox" id="tricycle" name="tricycle" value="">&nbsp;Tricycle &nbsp;    
                                                    <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;Jeepney &nbsp;    
                                                </div>
                                                <div>
                                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Others Vehicle/Object Involved (for Collision accident only)</p>        
                                                </div>
                                                <div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="none" name="none" value="">&nbsp;None
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="van" name="van" value="">&nbsp;Van &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                                    <input type="checkbox" id="motor1" name="motor1" value="">&nbsp;Motorcycle
                                                </div>
                                                <div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="bicycle2" name="bicycle2" value="">&nbsp;Bicycle
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="bus2" name="bus2" value="">&nbsp;Bus &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                                    <input type="checkbox" id="tricycle1" name="tricycle" value="">&nbsp;Tricycle
                                                </div>
                                                <div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="car3" name="car3" value="">&nbsp;Car
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="truck2" name="truck2" value="">&nbsp;Truck &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                                    <input type="checkbox" id="unknown2" name="unknown2" value="">&nbsp;Unknown
                                                </div>
                                                <div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="jepp2" name="jeep2" value="">&nbsp;Jeep
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="Others3" name="others3" value="">&nbsp;Others<strong>:</strong>&nbsp;<input type="text" class="others" name="other_patient" value="">
                                                </div>
                                            </div>
                                        <div class="col-md-6">
                                            <div class="col-md-6">
                                                <label>Position Of Patient</label>
                                                <div><br>
                                                    <input type="checkbox" id="tricycle" name="tricycle" value="">&nbsp;Pedestrian &nbsp;       
                                                </div>
                                                <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;Driver &nbsp; 
                                                <div>
                                                    <input type="checkbox" id="tricycle" name="tricycle" value="">&nbsp;Captain &nbsp;        
                                                </div>
                                                <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;Pilot &nbsp;
                                                <div>
                                                    <input type="checkbox" id="tricycle" name="tricycle" value="">&nbsp;Front Passenger &nbsp;    
                                                </div>
                                                <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;Rear Passenger &nbsp;    
                                                <div>
                                                    <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;Unknown &nbsp;    
                                                </div>
                                                <input type="checkbox" id="tricycle" name="tricycle" value="">&nbsp;Others: <input type="text" class="others" name="other_patient" value="">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Place of Occurrence</label>
                                                <div><br>
                                                    <input type="checkbox" id="tricycle" name="tricycle" value="">&nbsp;Home &nbsp;       
                                                </div>
                                                <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;School &nbsp; 
                                                <div>
                                                    <input type="checkbox" id="tricycle" name="tricycle" value="">&nbsp;Road &nbsp;        
                                                </div>
                                                <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;Videoke Bars &nbsp;
                                                <div>
                                                    <input type="checkbox" id="tricycle" name="tricycle" value="">&nbsp;Workplace,specify:&nbsp; &nbsp; 
                                                    &nbsp;&nbsp;&nbsp;<input type="text" class="others" name="other_patient" value="">
                                                </div>
                                                <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;Others<strong>:</strong> &nbsp;<input type="text" class="others" name="other_patient" value="">
                                                <div>
                                                    <input type="checkbox" id="jeep" name="jeep" value="">&nbsp;Unknown &nbsp;    
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-12"><br>
                                <div class="indention">
                                    <div class = "mt-3">
                                        <div class="col-md-4">
                                            <label>Activity of the Patient at the time of incident</label>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="degree1" name="heat" value="heat"> Sports&nbsp;&nbsp;
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="degree2" name="fire" value="fire"> Leisure&nbsp;&nbsp;&nbsp; 
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="degree3" name="burnDegree" value="electricity"> Work Related&nbsp;&nbsp;
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="degree4" name="burnDegree" value="oil"> Others&nbsp;&nbsp;&nbsp;<input type="text" class="others" name="other_patient" value="">
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Other Risk Factors at the time of the incident</label>
                                            <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="alcohol" name="alcohol" value=""> Alcohol/Liquor&nbsp;&nbsp;
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="mobile" name="mobile" value=""> Using Mobile Phone&nbsp;&nbsp;&nbsp; 
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="sleep" name="sleep" value="electricity"> Sleepy&nbsp;&nbsp;
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="smoke" name="smoke" value=""> smoking&nbsp;&nbsp;
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="others" name="burnDegree" value="oil"> Others, specify&nbsp;&nbsp;&nbsp;<input type="text" class="others" name="other_patient" value="">
                                                </div>
                                                <p class="ex_type">(eg. Suspected under the influence of substance used)</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Safety: (check all that apply)</label>

                                            <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="alcohol" name="alcohol" value=""> None&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="alcohol" name="alcohol" value=""> Unknown&nbsp;&nbsp;
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="mobile" name="mobile" value=""> Childseat&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="mobile" name="mobile" value=""> Helmet&nbsp;&nbsp;&nbsp; 
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="sleep" name="sleep" value="electricity"> Airbag&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                    <input type="checkbox" id="sleep" name="sleep" value="electricity"> Seatbelt&nbsp;&nbsp;

                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="smoke" name="smoke" value=""> Lifevest/Lifejacket/flotation device&nbsp;&nbsp;
                                                </div>
                                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="others" name="burnDegree" value="oil"> Others&nbsp;&nbsp;&nbsp;<input type="text" class="others" name="other_patient" value="">
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <h4 class="patient-font mt-4">Hospital/Facility Data:</h4>
                                <h5 class="A_Hospital mt-5"> &nbsp;&nbsp;
                                <input type="checkbox" id="alcohol" name="alcohol" value="">
                                &nbsp;A. ER/OPD/BHS/RHU</h5>    
                            </div>
                            <div class="col-md-8">
                                <label>Transferred from another hospital/facility:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="sleep" name="sleep" value="electricity"> Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="sleep" name="sleep" value="electricity"> No                                
                            </div>
                            <div class="col-md-10">&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>Referred by another Hospital/Facility for Laboratory and/or other medical procedures:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="sleep" name="sleep" value="electricity"> Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="sleep" name="sleep" value="electricity"> No      
                            </div>
                            <div class="col-md-12">
                                <div class="indention">
                                    <div class="mt-3">
                                        <label>Name of the Originating Hospital/Physician:</label>
                                        <input type="text" class="small-input" name="originating_hospital" value ="">
                                    </div>
                                </div>
                                <div class="indention">
                                    <div class="mt-3">
                                        <label>Status upon reashing the Facility</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" id="mobile" name="mobile" value=""> Dead on Arrival&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" id="mobile" name="mobile" value=""> Alive&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <input type="checkbox" id="mobile" name="mobile" value=""> If Alive&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" id="mobile" name="mobile" value=""> Conscious&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <input type="checkbox" id="mobile" name="mobile" value=""> Unconscious&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <div>
                                            <label>Mode of Transport to the Hospital/Facility</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" id="mobile" name="mobile" value=""> Ambulance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                            <input type="checkbox" id="mobile" name="mobile" value=""> Police Vehicle&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" id="mobile" name="mobile" value=""> Pirate Vehicle&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" id="mobile" name="mobile" value=""> Others, specify&nbsp;&nbsp;<input type="text" class="others" name="other_patient" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="indention">
                                    <div class="mt-3">
                                        <label for="">Initial Impression:</label>
                                        <input type="text" style="width: 80%; max-width:100%" name="originating_hospital" value ="">
                                    </div>
                                </div>
                                <div class="indention">
                                    <div class="mt-3">
                              
                                        <div class="col-md-6">
                                         
                                            <input type="text"  style="width: 100%; max-width:100%" name="originating_hospital" value ="" placeholder="ICD-10 Code/s: Nature of Injury">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"  style="width: 100%; max-width:100%" name="originating_hospital" value ="" placeholder="ICD-10 Code/s:External cause of Injury">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mt-3">
                                    <div>
                                        <label for="">Disposition</label>
                                    </div>
                                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" id="admitted" name="admitted" value="Admitted"> Admitted&nbsp;&nbsp;
                                    </div>
                                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" id="hama" name="heat" value="HAMA"> HAMA&nbsp;&nbsp;
                                    </div> -->
                                    
                                    <!-- <div class="col-md-4">
                                        <input type="checkbox" id="treated" name="treated" value="Treated and Sent Home"> Treated and Sent Home&nbsp;&nbsp;
                                        <input type="checkbox" id="absconded" name="absconded" value="Adbsconded"> Absconded&nbsp;&nbsp;
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="degree1" name="heat" value="heat"> Sports&nbsp;&nbsp;
                                        <input type="checkbox" id="degree1" name="heat" value="heat"> Sports&nbsp;&nbsp;
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>  


<style>
    .col-divider { 
        border-right: 1px solid #ddd;
    }
    .col-md-6 .patient-font{
        background-color: #727DAB;
        color: white; 
        padding: 3px;
    }
    .col-md-6 .mt-4 {
            margin-top: 10px; /* Adjust this value as needed */
        }
    .col-md-6 .underline-text{
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
    .col-md-6 .A_Hospital{
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

</style>

<script>

    $(document).ready(function() {

        $.ajax({
            url: '/body-parts',
            method: 'GET',
            success: function(data){
                console.log("data", data);
            },
            error: function(xhr, status, error){
                console.error('Failed to fetch body parts:', error);
            }

        });

    });

 
</script>

@endsection