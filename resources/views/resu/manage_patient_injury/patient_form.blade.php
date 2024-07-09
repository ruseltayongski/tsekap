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
                                <input type="text" class="form-control" name="addressfacility" id="typedru" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="address-facility">Address of Reporting Facility</label>
                                <input type="text" class="form-control" name="addressfacility" id="addressfact" readonly>
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
                                <input type="text" class="form-control" name="sex" id="sex" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="dateofbirth">Date Of Birth</label>
                                <input type="date" class="form-control" id="dateofbirth" name="dateBirth" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" id="age" name="age" value="" disabled>
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
                            <div class="col-md-4">
                                <label for="province">Province</label>
                                <select class="form-control chosen-select" name="province" id="provinceId">
                                    <option value="">Select Province Injury</option>
                                    @foreach($province as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="municipal">Municipal</label>
                                <select class="form-control chosen-select" name="permanent_add_municipal" id="municipal_injury">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="barangay">Barangay</label>
                                <select class="form-control chosen-select" name="permanent_add_barangay" id="barangay_injury">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Date and Time Injury:</label>
                                <input type="date" class="form-control" name="date_injury" value="">
                                <input type="time" class="form-control" name="time_injury" value="">
                            </div>
                            <div class="col-md-6">
                                <label>Date and Time Consultation:</label>
                                <input type="date" class="form-control" name="date_consultation" value="">
                                <input type="time" class="form-control" name="time_consultation" value="">
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
                            <input type="checkbox" name="unintentionalAccidental"> Unintentional/Accidental
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="intentionalSelfInflicted"> Intentional (Self-inflicted)
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="IntentionalViolence"> Intentional/(Violence)
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="Undetermined"> Undetermined
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="VAWCPatient"> VAWC Patient
                        </label>
                    </div>
                  
                    <div class="col-md-12">  <hr>
                        <label>First Aid Given:</label>
                    </div>

                    <div class="col-md-1 col-md-offset-2">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="firstAidGiven" id="firstAidYes" value="Yes"> Yes
                        </label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="druWhat" id="druWhat" placeholder="What:" style="display: none;">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="druByWhom" id="druByWhom" placeholder="By whom:" style="display: none;">
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="firstAidGiven" id="firstAidNo" value="No"> No
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
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="Abrasion" name="Abrasion"> Abrasion
                            </label>
                            <input type="text" class="form-control" name="AbrasionDetail" id="natureinput">
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="Avulsion" name="Avulsion"> Avulsion
                            </label>
                            <input type="text" class="form-control" name="AvulsionDetail" id="natureinput">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="burn" name="burn"> Burn
                            </label><br>

                            [ Degree:<label>
                                <input type="radio" name="permanent_add_barangay" value="Degree1">
                                1
                            </label>
                            <label>
                                <input type="radio" name="permanent_add_barangay" value="Degree2">
                                2
                            </label>
                            <label>
                                <input type="radio" name="permanent_add_barangay" value="Degree3">
                                3
                            </label>
                            <label>
                                <input type="radio" name="permanent_add_barangay" value="Degree4">
                                4
                            </label> ]
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="concussion" name="concussion"> Concussion
                            </label>
                            <input type="text" class="form-control" name="concussion" id="concussion">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="contusion" name="contusion"> Contusion
                            </label>
                            <input type="text" class="form-control" name="contusion" id="contusion">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="contusion" name="contusion"> Fracture
                            </label><br>
                            <div class="col-md-offset-5">
                                <input type="checkbox" id="contusion" name="closetype" value="close type"> Close Type
                            </div>
                            <div class="col-md-offset-5"><br>
                                <input type="checkbox" id="contusion" name="contusion" value="open ype"> Open Type
                            </div>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="Avulsion" name="Avulsion"> Open Wound
                            </label>
                            <input type="text" class="form-control" name="openwound" id="openwound">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="traumatic" name="traumatic"> Traumatic Amputation
                            </label>
                            <input type="text" class="form-control" name="traumatic_details" id="traumatic_details">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="traumatic" name="traumatic"> Others: Please specify injury and the body parts affected: 
                            </label>
                            <input type="text" class="form-control" name="traumatic_details" id="traumatic_details">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side for Abrasion</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select>
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side for Avulsion</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select><br>

                        <input type="text" class="form-control" name="burnDetail" id="burn" placeholder="burn details">

                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side for Concussion</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select>
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side for contusion</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select>
                        <label>burn details</label>
                        <input type="text" class="form-control" name="concussion" id="concussion" placeholder=" fracture close type details">
                        <input type="text" class="form-control" name="concussion" id="concussion" placeholder=" fracture open type details">

                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side for Open Wound</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select>
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side for Traumatic Amputation</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select><br>
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side for Others</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select>
                        <!----------------------------- Nature of Injury ------------------------------>


                    </div>
                    <div class="col-md-3">
                        <label>Select Body Parts</label>
                        <select class="form-control chosen-select" name="body_parts_Abrasion" id="search_body_parts">
                            <option value="">Select body parts for Abrasion</option>
                            @foreach($body_part as $body_parts)
                            <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select>
                        <label>Select Body Parts</label>
                        <select class="form-control chosen-select" name="body_parts_avulsion" id="permanent_add_barangay" value="">
                            <option value="">Select body parts for Avulsion</option>
                            @foreach($body_part as $body_parts)
                                <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select><br>
                        
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side for burn</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select>
                        <label>Select Body Parts</label>
                        <select class="form-control chosen-select" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts for Concussion</option>
                            @foreach($body_part as $body_parts)
                                <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select>
                        <label>Select Body Parts</label>
                        <select class="form-control chosen-select" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts for contusion</option>
                            @foreach($body_part as $body_parts)
                                <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select>
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select side close type</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select side open type</option>
                            <option value="right">right</option>
                            <option value="left">left</option>
                        </select>

                        <label>Select Body parts</label>
                        <select class="form-control chosen-select" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select side for Open Wound</option>
                            @foreach($body_part as $body_parts)
                            <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select>
                        <label>Select Body parts</label>
                        <select class="form-control chosen-select" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Body parts for Traumatic</option>
                            @foreach($body_part as $body_parts)
                            <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select><br>
                        <label>Select Body parts</label>
                        <select class="form-control chosen-select" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts for Others</option>
                            @foreach($body_part as $body_parts)
                            <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3"><br><br><br><br><br><br><br>
                        <select class="form-control chosen-select" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts for burn</option>
                            @foreach($body_part as $body_parts)
                            <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select><br><br><br><br><br><br><br>

                        <select class="form-control chosen-select" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts for close type fracture</option>
                            @foreach($body_part as $body_parts)
                            <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select>
                        <select class="form-control chosen-select" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts for Open type fracture</option>
                            @foreach($body_part as $body_parts)
                            <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                            @endforeach
                        </select>
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
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="bites"> <strong>Bites/stings/Specify animal/insect:</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="bite_details" id="bitedetails">
                    </div>
                    <div class="col-md-12">
                        <label>
                            <input type="checkbox" id="Abrasion" name="Abrasion"> Burns
                        </label><br>
                        <div class="col-md-5">
                           
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="permanent_add_barangay" value="heat">
                                    Heat
                                </label>
                                <label>
                                    <input type="radio" name="permanent_add_barangay" value="fire">
                                    fire
                                </label>
                                <label>
                                    <input type="radio" name="permanent_add_barangay" value="Electricity">
                                    Electricity
                                </label>
                                <label>
                                    <input type="radio" name="permanent_add_barangay" value="Electricity">
                                    Oil
                                </label>
                                <label>
                                    <input type="radio" name="permanent_add_barangay" value="Electricity">
                                    friction
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control inline-input2" name="bite_details" id="bitedetails" placeholder="specify here"><br>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="bites"> <strong>Chemical/Substance,</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="bite_details" id="bitedetails" laceholder="specify here">
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="bites"><strong> Contact with sharp Objects, </strong>
                            </label>
                            <input type="text" class="form-control inline-input" name="bite_details" id="bitedetails" placeholder="specify here">
                        </div>
                    </div>                 
                    
                    <div class="col-md-12">
                        <div class="d-flex align-items-center">
                            <label>
                                <input type="checkbox" id="Abrasion" name="Abrasion"> Drowning: Type/Body of Water:
                            </label><br>
                            <div class="col-md-5">
                            
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" name="permanent_add_barangay" value="Sea">
                                        Sea
                                    </label>
                                    <label>
                                        <input type="radio" name="permanent_add_barangay" value="River">
                                        River
                                    </label>
                                    <label>
                                        <input type="radio" name="permanent_add_barangay" value="Lake">
                                        Lake
                                    </label>
                                    <label>
                                        <input type="radio" name="permanent_add_barangay" value="Pool">
                                        Pool
                                    </label>
                                    <label>
                                        <input type="radio" name="permanent_add_barangay" value=" Bath Tub">
                                        Bath Tub
                                    </label>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control inline-input2" name="bite_details" id="bitedetails" placeholder="specify here"><br>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="bites"> <strong>Exposure to forces of nature:</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="bite_details" id="bitedetails">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="bites"> <strong>Fall</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="bite_details" id="bitedetails">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="bites"> <strong>Fire Cracker, Specify type</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="bite_details" id="bitedetails">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="bites"> <strong>Sexual Assault/Sexual Abure/Rape (Alleged)</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="Sexual_details" id="Sexual">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="FireCracker" value="Fire Cracker"> <strong>Fire Cracker, Specify type</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="FireCracker_details" id="bitedetails">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="bites" name="FireCracker" value="Others"> <strong>Others, Specify</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="others_exter" id="others_exter">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="gunshot" name="Gunshot" value="Gunshot"> <strong>Gunshot, Specify Weapon</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="gunshot_details" id="gunshot_details">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="Hanging" name="Hanging" value="Hanging"> <strong>Hanging/Strangulation</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="Hanging_details" id="Hanging_details">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="mauling" name="mauling" value="mauling"> <strong>Mauling/Assault</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="mauling_details" id="mauling_details">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="Transport" name="Transport" value="Transport/Vehicular Accident"> <strong>Transport/Vehicular Accident</strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="transport_details" id="transport_details">
                    </div>
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
                        <input type="checkbox" id="land" name="land" value=""> Land
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="checkbox" id="water" name="water" value=""> Water
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="checkbox" id="air" name="air" value=""> Air
                    </div>
                    <div class="col-md-3 transport-related"> 
                        <input type="checkbox" id="collision" name="collision" value=""> Collision&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="checkbox" id="non-col" name="none-col" value=""> Non-Collision
                    </div>
                    <div class="col-md-6 transport-related"><hr>
                        <label>Vehicles Involved:</label>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patient's Vehicle</p>
                        <div class="col-md-4">&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="non-col" name="none-col" value="None (Pedestrian)"> None (Pedestrian)<br>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="non-col" name="none-col" value="Motorcycle"> Motorcycle<br>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="non-col" name="none-col" value="Truck"> Truck<br>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="non-col" name="none-col" value="Bus"> Bus<br>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="non-col" name="none-col" value="Jeepney"> Jeepney
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="non-col" name="car" value="Car"> Car<br>
                            <input type="checkbox" id="non-col" name="none-col" value="Bicycle"> Bicycle<br>
                            <input type="checkbox" id="non-col" name="none-col" value="Van"> Van<br>
                            <input type="checkbox" id="non-col" name="none-col" value="Tricycle"> Tricycle
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="non-col" name="unknown" value="Unknown"> Unknown<br>
                            <input type="checkbox" id="non-col" name="other_patient" value="others"> Others<br>
                            <input type="text" class="form-control" name="other_details" placeholder="others details">
                        </div>
                        <div class="col-md-12"><br>
                            <p>Other Vehicle/Object Involved (for Collision accident only)</p>
                            <div class="col-md-3">
                                <input type="checkbox" id="non-col" name="none" value="None"> None<br>
                                <input type="checkbox" id="non-col" name="bicycle" value="Bicycle"> Bicycle<br>
                                <input type="checkbox" id="non-col" name="car" value="Car"> Car<br>
                                <input type="checkbox" id="non-col" name="jeepney" value="Jeepney"> Jeepney
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="non-col" name="van" value="Van"> Van<br>
                                <input type="checkbox" id="non-col" name="bus" value="Bus"> Bus<br>
                                <input type="checkbox" id="non-col" name="truck" value="truck"> truck<br>
                                <input type="checkbox" id="non-col" name="jeepney" value="Jeepney"> Others:
                                <input type="text" class="form-control" name="other_details" placeholder="others details">
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="non-col" name="motorcycle" value="Motorcycle"> Motorcycle<br>
                                <input type="checkbox" id="non-col" name="Tricycle" value="Tricycle"> Tricycle<br>
                                <input type="checkbox" id="non-col" name="unknown" value="unknown"> Unknown
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 transport-related"><hr><br>
                        <p>Position of Patient</p>
                        <input type="checkbox" id="non-col" name="pedestrian" value="Pedestrian"> Pedestrian<br>
                        <input type="checkbox" id="non-col" name="driver" value="Driver"> Driver<br>
                        <input type="checkbox" id="non-col" name="captain" value="Captain"> Captain<br>
                        <input type="checkbox" id="non-col" name="pilot" value="Pilot"> Pilot
                        <input type="checkbox" id="non-col" name="font_passenger" value="Font Passenger"> Front Passenger<br>
                        <input type="checkbox" id="non-col" name="rear_passenger" value="Rear Passenger"> Rear Passenger<br>
                        <input type="checkbox" id="non-col" name="others" value="Others"> Others:<br>
                        <input type="text" class="form-control" name="other_details" placeholder="others details">
                        <input type="checkbox" id="non-col" name="unknown" value="Unknown"> Unknown

                    </div>
                    <div class="col-md-3 transport-related"><hr><br>
                        <p>Place of Occurrence</p>
                        <input type="checkbox" id="non-col" name="home" value="Home"> Home<br>
                        <input type="checkbox" id="non-col" name="school" value="School"> School<br>
                        <input type="checkbox" id="non-col" name="Road" value="Road"> Road<br>
                        <input type="checkbox" id="non-col" name="school" value="School"> Videoke Bars<br>
                        <input type="checkbox" id="non-col" name="workplace" value="workplace"> Workplace, specify:<br>
                        <input type="text" class="form-control" name="workplace_details" placeholder="specify here">
                        <input type="checkbox" id="non-col" name="others" value="Others"> Others:<br>
                        <input type="text" class="form-control" name="workplace_details" placeholder="others details">
                        <input type="checkbox" id="non-col" name="unknown" value="Unknown"> Unknown
                    </div>
                    <div class="col-md-12 transport-related">
                        <div class="col-md-4"><hr>
                            <label>Activity of the patient at the of incident</label><br>
                            <input type="checkbox" id="sports" name="sports" value="Sports"> Sports<br>
                            <input type="checkbox" id="non-col" name="leisure" value="leisure"> Leisure<br>
                            <input type="checkbox" id="non-col" name="school" value="School"> Work Related<br>
                            <input type="checkbox" id="non-col" name="others" value="Others"> Others:
                            <input type="text" class="form-control" name="workplace_details" placeholder="others details">
                            <input type="checkbox" id="non-col" name="unknown" value="unknown"> Unknown
                        </div>
                        <div class="col-md-4"><hr>
                            <label>Other Risk Factors at the time of the incident:</label><br>
                            <input type="checkbox" id="sports" name="liquor" value="Alcohol/liquor"> Alcohol/liquor<br>
                            <input type="checkbox" id="non-col" name="mobilephone" value="Using Mobile Phone"> Using Mobile Phone<br>
                            <input type="checkbox" id="non-col" name="sleepy" value="Sleepy"> Sleepy<br>
                            <input type="checkbox" id="non-col" name="smooking" value="smooking"> Smooking<br>
                            <input type="checkbox" id="non-col" name="others" value="Others"> Others specify:
                            <input type="text" class="form-control" name="workplace_details" placeholder="others specify here">
                            <p>(eg. Suspected under the influence of substance used)</p>
                        </div>
                        <div class="col-md-4"><hr>
                            <label>Safety: (check all that apply)</label>
                            <div class="col-md-6">
                                <input type="checkbox" id="sports" name="none" value="None"> None<br>
                                <input type="checkbox" id="non-col" name="childseat" value="Childseat"> Childseat<br>
                                <input type="checkbox" id="non-col" name="Airbag" value="Airbag"> Airbag<br>
                                <input type="checkbox" id="non-col" name="smooking" value="smooking"> Lifevest/Lifejacket/flotation device<br>
                                <input type="checkbox" id="non-col" name="others" value="Others"> Others specify:
                                <input type="text" class="form-control" name="others_details" placeholder="others specify here">
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" id="sports" name="unknown" value="unknown"> Unknown<br>
                                <input type="checkbox" id="non-col" name="helmet" value="Helmet"> Helmet<br>
                                <input type="checkbox" id="non-col" name="Seatbelt" value="Seatbelt"> Seatbelt<br>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end of transport-group -->
                    
                    <div class="col-md-12"><hr>
                        <h4 class="patient-font mt-4">Hospital/Facility Data</h4>
                        <div class="A_ErOpdGroup">
                            <h6 class="A_Hospital mt-5"> 
                            <input type="checkbox" id="A_ErOpd" name="alcohol" value="A. ER/OPD/BHS/RHU">
                            A. ER/OPD/BHS/RHU</h6>
                            <div class="col-md-12">
                                <label for="transferred facility">Transferred from another hospital/facility</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="sports" name="Yes" value="Yes"> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="non-col" name="no" value="No"> No <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="referred by hospital">Referred by another Hospital/Facility for Laboratory and/or other medical procedures</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="sports" name="Yes" value="Yes"> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="non-col" name="no" value="No"> No <br><hr>
                            </div>
                            <div class="col-md-12">
                                <label for="nameofphysician">Name of the Originating Hospital/Physician:</label>
                                <input type="text" class="form-control" name="workplace_details" placeholder="Name of the Originating Hospital/Physician">
                            </div>
                            <div class="col-md-12"><hr></div>
                            <div class="col-md-3">
                                <label for="">Status upon reashing the Facility</label>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="non-col" name="dead_on_arrival" value=" Dead on Arrival"> Dead on Arrival
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" id="non-col" name="alive" value="Alive"> Alive
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="non-col" name="ifalive" value="If Alive"> If Alive
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="non-col" name="conscious" value="conscious"> conscious
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="non-col" name="Unconscious" value="Unconscious"> Unconscious
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-3">
                                <label for="">Mode of Transport to the Hospital/Facility</label>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="non-col" name="ambulance" value="Ambulance"> Ambulance
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="non-col" name="police_vehicle" value="Police Vehicle"> Police Vehicle
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="non-col" name="private_vehicle" value="Private Vehicle"> Private Vehicle
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" id="non-col" name="Others" value="Others"> Others
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="others_details" placeholder="others specify here">
                            </div>
                            <div class="col-md-12"><hr>
                            <label for="initial_imp">Initial Impression</label>
                                <input type="text" class="form-control" name="Initial_Imp" > <br>
                            </div>
                            <div class="col-md-6">
                                <label for="">ICD-10 Code/s: Nature of imjury</label>
                                <input type="text" class="form-control" name="icd10_nature" id="icd10_nature">    
                            </div>
                            <div class="col-md-6">
                                <label for="">ICD-10 Code/s: External Cause injury</label>
                                <input type="text" class="form-control" name="icd10_external" id="icd10_external">
                            </div>
                            <div class="col-md-12"><hr>
                                <div class="col-md-1">
                                    <label for="Disposition">Disposition:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="admitted" name="admitted" value="Admitted"> Admitted <br>
                                    <input type="checkbox" id="non-col" name="hama" value="HAMA"> HAMA
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="non-col" name="treated_sent" value="Treated and Sent Home"> Treated and Sent Home <br>
                                    <input type="checkbox" id="non-col" name="Absconded" value="Absconded"> Absconded
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="non-col" name="trans_facility_hos" value="Transferred to Another facility/hospital"> Transferred to Another facility/hospital, <br>
                                    <input type="text" class="form-control" id="trans_facility_hospital" name="trans_facility_hospital" value="" placeholder="Please specify">
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
                                    <input type="checkbox" id="Improved" name="Improved" value="Unimproved"> Unimproved
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="Improved" name="Improved" value="died"> Died
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="B_InpatientGroup">
                        <div class="col-md-12"><hr class="Inpatient_linehr">
                            <h6 class="A_Hospital mt-5"> 
                            <input type="checkbox" id="B_InPatient" name="alcohol" value="In-Patient(for admitted hospital cases only)">
                            B. In-Patient(for admitted hospital cases only)</h6>
                            <div class="col-md-12">
                                <label for="complete_final">Complete Final Diagnosis</label>
                                <input type="text" class="form-control" name="complete_final" id="" value="">
                            </div>
                            <div class="col-md-12"><hr>

                                <label for="Disposition">Disposition:</label><br>
                                <div class="col-md-3 col-md-offset-1">
                                    <input type="checkbox" id="discharged" name="discharged" value="discharged"> Discharged <br>
                                    <input type="checkbox" id="non-col" name="hama" value="refused_ad"> Refused Admission
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="Hama" name="HAMA" value="HAMA"> HAMA <br>
                                    <input type="checkbox" id="died" name="died" value="died"> Died
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="Hama" name="trans_facility_hospital" value="Transferred to Another facility/hospital"> Transferred to Another facility/hospital <br>
                                    <input type="text" class="form-control" id="trans_facility_hospital" name="trans_facility_hospital" value="" placeholder="Please specify">
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="abs" name="absconded" value="Absconded"> Absconded <br>
                                    <input type="checkbox" id="died" name="died" value="died"> Others 
                                    <input type="textbox" class="form-control" id="others" name="others" value="others specify here">
                                </div>
                            </div>
                            <div class="col-md-12"><hr>
                                <label for="Outcome">Outcome</label><br>
                                <div class="col-md-2 col-md-offset-1">
                                    <input type="checkbox" id="Improved" name="Improved" value="Improved"> Improved
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="Improved" name="Improved" value="Unimproved"> Unimproved
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="Improved" name="Improved" value="died"> Died
                                </div>
                            </div>
                            <div class="col-md-6"><br>
                                <label for="">ICD-10 Code/s: Nature of imjury</label>
                                <input type="text" class="form-control" name="icd10_nature" id="icd10_nature">    
                            </div>
                            <div class="col-md-6"><br>
                                <label for="">ICD-10 Code/s: External Cause injury</label>
                                <input type="text" class="form-control" name="icd10_external" id="icd10_external">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                        <button type="button" class="btn btn-primary mx-2" onclick="showPreviousStep()">Previous</button>
                        <button type="button" class="btn btn-primary mx-2" onclick="submitForm()">Submit</button>
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