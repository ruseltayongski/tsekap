@extends('resu/app1')
@section('content')
<!-- @include('resu/resuSidebar') -->
<?php
 use App\ResuNatureInjury;
 use App\ResuBodyParts;
 use App\ResuExternalInjury;
 use App\ResuTransportAccident;
 use App\ResuHospitalFacility;
 use App\Muncity;

 //use Carbon\Carbon;
 //$dob = Carbon::parse($profile->dob);

 $nature_injury = ResuNatureInjury::all();
 $body_part = ResuBodyParts::all(); 
 $ex_injury = ResuExternalInjury::all();
 $rtacident = ResuTransportAccident::all();

 $hospital_type = ResuHospitalFacility::all();

 $muncities = Muncity::select('id', 'description')->get();

 function isSimilar($str1, $str2) { // this is for Hospital/Facility Data function
     similar_text(strtolower(trim($str1)), strtolower(trim($str2)), $percent);
     return $percent >= 80; // You can adjust the threshold as needed
 }
?>
    <div class="col-md-8 wrapper" style="flex-direction: column; justify-content: center; align-items: center; padding: 10px; left: 15%; padding-bottom: 5%">
       <div class="alert alert-jim">
        <h2 class="page-header"  style="text-align: center">
            <i class="fa fa-user"></i>&nbsp; PHILPEN RISK ASSESSMENT FORM (REVISED 2022)
            <br>
            <p style="font-size: 15pt; font-style: italic; text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adults > 20 years old</p>
        </h2>
        <div class="page-divider"></div>
        <form class="form-horizontal form-submit" id="form-submit" method="POST" action="{{ route('submit-patient-form') }}">
            {{ csrf_field() }}
            <input type="hidden" id="muncities-data" value="{{ json_encode($muncities) }}">
            <div class="form-step" id="form-step-1">
                <div class="row">
                    <div class="col-md-12 col-divider">
                        <!-- <h4 class="patient-font" style="background-color: #727DAB;color: white;padding: 3px;margin-top: -28px; ">Patient Informations</h4> -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="facility-name">Name of Health Facility</label>
                                <input type="text" class="form-control" name="facilityname" id="facility" readonly value="{{ $facility->name }}">
                                <input type="hidden" name="facility_id" value="{{ $facility->id }}">
                            </div> 
                            <div class="col-md-6">
                                <label for="address-facility">Date of Assessment</label>
                                <input type="text" class="form-control" name="addressfacility" id="addressfacility" readonly value="{{$facility->address}}">
                            </div><br><br>
                            <!--
           
                            <div class="col-md-6">
                                <label for="dru">Type of DRU</label>
                                <input type="text" class="form-control" name="typedru" id="typedru" readonly value="{{ $facility->hospital_type}}">
                            </div>
                            <div class="col-md-6">
                                <label for="address-facility">Address of Reporting Facility</label>
                                <input type="text" class="form-control" name="addressfacility" id="addressfacility" readonly value="{{$facility->address}}">
                            </div> -->
                            <!-- <div class="col-md-6">
                                <label>Type of Patient<span class="text-danger">*</span></label>
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input type="radio" id="ER" name="typePatient" value="ER"> ER
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" id="OPD" name="typePatient" value="OPD"> OPD
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" id="In_Patient" name="typePatient" value="In-Patient"> In-Patient
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" id="BHS" name="typePatient" value="BHS"> BHS
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" id="RHU" name="typePatient" value="RHU"> RHU
                                    </label> 
                                </div><br>
                            </div> -->
                            <br><br><br>
                        </div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 2px;margin-top: -10px; ">I. PATIENT'S INFORMATION</h4>
                        <div class="row">
                            <!-- <div class="col-md-3">
                                <label for="hospital_no">Hospital Case No. <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="hospital_no" id="hospital_no" value="">
                            </div> -->
                            <div class="col-md-3">
                                <label for="lname">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lname" id="lname" value="">
                            </div>
                            <div class="col-md-2">
                                <label for="fname">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fname" id="fname" value="">
                            </div>
                            <div class="col-md-2">
                                <label for="mname">Middle Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mname" id="mname" value="">
                            </div>
                            <div class="col-md-2">
                                <label for="sex">Sex</label>
                                <select class="form-control chosen-select" name="sex" id="sex">
                                    <option value="">Select sex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sex">Civil Status</label>
                                <select class="form-control chosen-select" name="sex" id="sex">
                                    <option value="">Select sex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="dateofbirth">Date Of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="dateofbirth" name="dateBirth">
                            </div>
                            <div class="col-md-3">
                                <label for="age">Age <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="age" name="age" value="" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="province">Province/HUC <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="province" id="province">
                                    <option value="">Select Province</option>
                                    @foreach($province as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="municipal">Municipal <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="municipal" id="municipal">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Barangay <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="barangay" id="barangay">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="lname">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lname" id="lname" value="">
                            </div>
                         
                            <div class="col-md-5">
                                <label for="phil_no">PhilHealth No.</label>
                                <input type="text" class="form-control" name="phil_no" id="phil_no" value=""><br>
                            </div>

                            <div class="col-md-5">
                                <label for="phil_no">Persons with Disability ID Card No. if applicable:</label>
                                <input type="text" class="form-control" name="phil_no" id="phil_no" value=""><br>
                            </div>
                            <div class="col-md-5 d-flex align-items-center">
                                    <label class="mr-2">Employment Status:</label><br>
                                    <input type="checkbox" name="employment_status" id="employment_status">
                                    <label for="employment_status" class="ml-2">Employed</label>
                                    <input type="checkbox" name="employment_status" id="employment_status">
                                    <label for="employment_status" class="ml-2">Unemployed</label>
                                    <input type="checkbox" name="employment_status" id="employment_status">
                                    <label for="employment_status" class="ml-2">Self-Employed</label>
                                    <br>
                                    <!-- <div class="col-md-5">
                                    <label for="ethnicity">Ethnicity:</label>
                                    <select class="form-control" name="ethnicity" id="ethnicity">
                                        <option value="">Select an Option</option>
                                        <option value="asian">Asian</option>
                                        <option value="black">Black or African American</option>
                                        <option value="hispanic">Hispanic or Latino</option>
                                        <option value="white">White</option>
                                        <option value="native">Native American or Alaska Native</option>
                                        <option value="pacific">Native Hawaiian or Pacific Islander</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div> -->
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">II. ASSESS FOR RED FLAGS <span class="text-danger">*</span></h4>
                        </div>
                    </div>
                    <div class="col-md-12" style="display: flex; align-items: center;">
                                <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th>Description</th>
                                    <th>Option (Yes / No)</th>
                                    <th>Details</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                   <tr>
                                        <td>2.1 Chest Pain</td>
                                        <td>
                                            <input type="checkbox" class="chestPainCheckbox" id="chestPainYes" value="Yes"> Yes
                                            <input type="checkbox" class="chestPainCheckbox" id="chestPainNo" value="No" style="margin-left: 15px;"> No
                                        </td>
                                        <td>
                                            <input type="text" class="form-control chestPainDetails" id="chestPainDetails" 
                                                placeholder="By whom:" disable>
                                        </td>
                                    </tr>
                                <tr>
                                    <td>2.2 Difficulty of Breathing</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.3 Loss of Consciousness</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.4 Slurred Speech</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.5 Facial Asymmetry</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                <td>2.6 Weakness/Numbness on arm <br> of the left on one side of the body</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.7 Disoriented as to time, <br> place and person</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.8 Chest Retractions</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.9 Seizure or Convulsion</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.10 Act of self-harm or suicide</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.11 Agitated and/or aggressive behavior</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.12 Eye Injury/ Foreign Body on the eye</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.13 Severe Injuries</td>
                                    <td>
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidYes" value="Yes"> Yes
                                        <input type="checkbox" class="firstAidCheckbox" id="firstAidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    <td>
                                        <input type="text" class="form-control firstAidDetails" id="druWhat" name="druWhat" 
                                            placeholder="What:" style="display: none; margin-bottom: 5px;">
                                        <input type="text" class="form-control firstAidDetails" id="druByWhom" name="druByWhom" 
                                            placeholder="By whom:" style="display: none;">
                                    </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-12 text-center" style="margin-top: 20px;">
                            <!-- <button type="button" class="btn btn-primary mx-2" >Next</button> -->
                            <button type="button" class="btn btn-primary mx-2" onclick="showNextStep()">Next</button>
                        </div>
                    </div>
            </div>
            <div class="form-step" id="form-step-2" style="display: none;">
                <div class="row">                                      
                    <div class="col-md-12">
                    <hr class="bold-line">
                        <label>Nature of Injuries:</span></label>
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                     
                        <p style="display: flex; align-items: center; margin: 0">
                            <p style="margin: 0; padding-right: 10px">Multiple Injuries ? <span class="text-danger">*</span></p>
                            <input type="radio" id="multiple_injured" name="multiple_injured" value="Yes" style="margin: 0 10px">Yes
                            <input type="radio" id="single_injured" name="multiple_injured" value="No" style="margin: 0 10px">No
                        </p>
                    </div>
                    <div class="col-md-12 col-md-offset-.05">  
                        <p class="underline-text text-center" id="underline-text">
                            Check all applicable indicate in the blank space opposite each type of injury the body location [site] and affected and other details
                        </p>
                    </div>
                    <div class="col-md-3">
                            @php
                                $counter = 1;
                            @endphp

                            @foreach($nature_injury as $injured)
                                @php
                                    $cleaned_nature = preg_replace('/[\/,]/', ' ', $injured->name);              
                                $natureSingle = explode(' ', trim($cleaned_naturel))[0];
                                @endphp

                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="InjuredBurn" name="InjuredBurn" value="{{ $injured->id }}"> {{$injured->name}}
                                    </label>
                                    <input type="text" class="form-control" id="burnDetail" name="burnDetail" placeholder="burn details" disabled>
                                </div>
                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="fractureNature" name="fractureNature" value="{{$injured->id}}"> {{$injured->name}}
                                    </label><br>

                                    <div class="col-md-offset-5" syle=" margin-left: 400px">
                                        <input type="checkbox" id="closetype" name="fracttype" value="close type" onclick="toggleCheckbox(this)"> Close Type <!--close type details-->
                                    </div>
                                    <div class="col-md-offset-5"syle=" margin-left: 400px"><br>
                                        <input type="checkbox" id="opentype" name="fracttype" value="open type" onclick="toggleCheckbox(this)"> Open Type <!--open type details-->
                                    </div>
                                </div>  
                                
                            @elseif($injured->name == "others" || $injured->name == "other" || $injured->name == "Other" || $injured->name == "Others")
                                <div class="checkbox">
                                                <label>
                                        <input type="checkbox" id="Others_nature_injured" name="Others_nature_injured" value="{{$injured->id}}"> {{$injured->name}}: Please specify injury and the body parts affected: 
                                                </label>
                                    <input type="text" class="form-control" id="other_nature_datails" name="other_nature_datails" id="other_nature_injury" disabled>
                                            </div>
                                        @else
                                <div class="checkbox">
                                            <label>
                                        <input type="checkbox" id="nature{{$counter}}" name="nature{{$counter}}" value="{{ $injured->id}} "> {{$injured->name}}
                                            </label>
                                    <input type="text" class="form-control" name="nature_details{{$counter}}" id="nature_details{{$counter}}" placeholder="Enter details" disabled>
                                </div>
                                
                            @endif
                                @php
                                    $counter++;
                                @endphp
                            @endforeach
                        </div>
                    <!-- <div class="col-md-3">
                        @php
                            $counter = 1;
                        @endphp
                        @foreach($nature_injury as $injured)
                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <br>
                                <input type="text" class="form-control" id="burnDetail" name="burnDetail" placeholder="burn details" disabled>
                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")
                                
                                <label>fracture details</label>
                                <input type="text" class="form-control" name="fracture_close_detail" id="fracture_close_detail" placeholder=" fracture close type details" disabled>
                                <input type="text" class="form-control" name="fracture_open_detail" id="fracture_open_detail" placeholder=" fracture open type details" disabled>
                            @elseif($injured->name == "others" || $injured->name == "other" || $injured->name == "Other" || $injured->name == "Others")
                                <br>
                                <label>Select side</label>
                                <select class="form-control" name="side_others" id="side_others" disabled>
                                    <option value="">Select Side for Others</option>
                                    <option value="right">right</option>
                                    <option value="left">left</option>
                                    <option value="Both left and Right">Both Left & right</option>
                                </select>
                            @else
                                <label>Select side</label>
                                <select class="form-control" name="sideInjured{{$counter}}" id="sideInjured{{$counter}}" disabled>
                                    <option value="">Select Side for {{$injured->name}}</option>
                                    <option value="right">right</option>
                                    <option value="left">left</option>
                                    <option value="Both left and Right">Both Left & right</option>
                                </select>
                            @endif
                            @php
                                $counter++;
                            @endphp
                        @endforeach                        
                    </div> -->  

                    <!----------------------------- Nature of Injury ------------------------------>
                    
                    <input type="hidden" name="injured_count" class="injured_count" value="{{ $counter }}">
                    <div class="col-md-3">
                        @php
                            $counter = 1;
                        @endphp
                        @foreach($nature_injury as $injured)
                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <br><br>    
                                <label>Select Body Parts</label>
                                <select class="form-control chosen-select" name="burn_body_parts[]" id="burnbody_parts" multiple disabled>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")
                            <br><br>
                                <label>Fracture details</label>
                                <input type="text" class="form-control" name="fracture_detail" id="fracture_close_detail" placeholder=" fracture close type details" disabled>
                                <!-- <input type="text" class="form-control" name="fracture_open_detail" id="fracture_open_detail" placeholder=" fracture open type details" disabled> -->

                            @elseif($injured->name == "others" || $injured->name == "other" || $injured->name == "Other" || $injured->name == "Others")
                                <br><br><br>
                                <label>Select Body parts</label>
                                <select class="form-control chosen-select" name="body_parts_others[]" id="body_parts_others" multiple disabled>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <label>Select Body Parts</label>
                                <select class="form-control chosen-select" name="body_parts_injured{{$counter}}[]" id="body_parts_injured{{$counter}}" multiple disabled>
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
                         @php
                            $counter = 1;
                        @endphp
                        @foreach($nature_injury as $injured)
                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <br><br><br><br><br><br><br>
                                [ Degree:<label>
                                        <input type="radio" id="Degree1" name="Degree" value="Degree 1" disabled>
                                        1
                                    </label>
                                    <label>
                                        <input type="radio" id="Degree2" name="Degree" value="Degree 2" disabled>
                                        2
                                    </label>
                                    <label>
                                        <input type="radio" id="Degree3" name="Degree" value="Degree 3" disabled>
                                        3
                                    </label>
                                    <label>
                                        <input type="radio" id="Degree4" name="Degree" value="Degree 4" disabled>
                                        4
                                    </label> ]
                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")    
                                <br><br><br><br><br><br><br><br><br>
                                <label for="bodyparts">Select Body Parts</label>
                                <select class="form-control chosen-select" name="fracture_bodyparts[]" id="fractureclose_bodyparts" multiple disabled>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                                <!-- <select class="form-control chosen-select" name="fracture_Open_bodyparts[]" id="fracture_Open_bodyparts" multiple disabled>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}">{{ $body_parts->name }}</option>
                                    @endforeach
                                </select> -->
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
                            <label>External Causes/s of Injuries: </label>
                        </div>
                    </div>
                    @php
                        $counter = 1;
                    @endphp
                    @foreach($ex_injury as $exInjury)
                        @php
                            $cleaned_external = preg_replace('/[\/,]/', ' ', $exInjury->name);              
                            $externalSingle = explode(' ', trim($cleaned_external))[0];
                        @endphp
                        <input type="hidden" name="external_id" id="external_id" value="{{$exInjury->id}}">
                        @if($externalSingle == 'Burns' || $externalSingle == 'Burn')     
                            <div class="col-md-12">
                                <label>
                                    <input type="checkbox" id="ex_burn" name="ex_burn" value="{{$exInjury->id}}"> {{$exInjury->name}}
                                </label><br>
                                <div class="col-md-5">
                                
                                    <div class="checkbox">
                                        <label>
                                            <input type="radio" name="burn_type" id="burn1" value="heat" disabled>
                                            Heat
                                        </label>
                                        <label>
                                            <input type="radio" name="burn_type" id="burn2" value="fire" disabled>
                                            fire
                                        </label>
                                        <label>
                                            <input type="radio" name="burn_type" id="burn3" value="Electricity" disabled>
                                            Electricity
                                        </label>
                                        <label>
                                            <input type="radio" name="burn_type" id="burn4" value="Oil" disabled>
                                            Oil
                                        </label>
                                        <label>
                                            <input type="radio" name="friction" id="burn5" value="friction" disabled>
                                            friction
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control inline-input2" name="exburnDetails" id="exburnDetails" placeholder="specify here" disabled><br>
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
                                                <input type="radio" name="drowningType" id="drowning1" value="Sea" disabled>
                                                Sea
                                            </label>
                                            <label>
                                                <input type="radio" name="drowningType" id="drowning2" value="River" disabled>
                                                River
                                            </label>
                                            <label>
                                                <input type="radio" name="drowningType" id="drowning3" value="Lake" disabled>
                                                Lake
                                            </label>
                                            <label>
                                                <input type="radio" name="drowningType" id="drowning4" value="Pool" disabled>
                                                Pool
                                            </label>
                                            <label>
                                                <input type="radio" name="drowningType" id="drowning5" value="Bath Tub" disabled>
                                                Bath Tub
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control inline-input2" name="exdrowning_Details" id="exdrowningDetails" placeholder="specify here" disabled><br>
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
                                    <input type="text" class="form-control" name="transport_details" id="Transport_details" placeholder="Enter details" disabled>
                                </div>
                        @else
                            <div class="col-md-12"></div>
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="external{{$counter}}" name="external{{$counter}}" value="{{$exInjury->id}}"> <strong>{{$exInjury->name}}</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="external_details{{$counter}}" id="external_details{{$counter}}" placeholder="Enter details" disabled>
                            </div>
                            @php    
                            $counter++;
                            @endphp
                        @endif
                    @endforeach
                    <input type="hidden" name="external_count" class="external_count" value="{{ $counter }}">
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
                    <div class="col-md-6 transport-related">
                        <label>For Transport Vehicular Accident Only:</label>
                    </div>
                    <div class="col-md-6 transport-related">
                        <label>Vehicular Accident Type: </label>
                    </div>
                    @foreach($rtacident as $rtAct)
                        <div class="col-md-2 transport-related">&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="Land" name="transport_accident_id" value="{{$rtAct->id}}"> {{$rtAct->description}}
                        </div>
                    @endforeach
                    <div class="col-md-3 transport-related">&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="Collision" name="transport_collision" value=" Collision "> Collision
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="radio" id="non_collision" name="transport_collision" value="Non-Collision"> Non-Collision
                    </div>  
                    <!-- <div class="col-md-2 transport-related">
                        <input type="checkbox" id="water" name="transport_vehic" value="water"> Water
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="checkbox" id="air" name="transport_vehic" value="Air"> Air
                    </div>
                    <div class="col-md-3 transport-related"> 
                        <input type="checkbox" id="Collision" name="transport_vehic" value="Collision"> Collision&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="col-md-2 transport-related">
                        <input type="checkbox" id="non_collision" name="transport_vehic" value="Non-Collision"> Non-Collision
                    </div> -->
            
                    <div class="col-md-6 transport-related"><hr class="bold-line">
                        <label>Vehicles Involved:</label>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patient's Vehicle</p>
                        <div class="col-md-4">&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="none_pedes" name="Patient_vehicle" value="None(Pedestrian)" onclick="togglePlaceInput()">None (Pedestrian)<br><br>
                            <input type="radio" id="patient_motorcycle" name="Patient_vehicle" value="Motorcycle" onclick="togglePlaceInput()"> Motorcycle<br>
                            <input type="radio" id="patient_truck" name="Patient_vehicle" value="Truck" onclick="togglePlaceInput()"> Truck<br>
                            <input type="radio" id="patient_bus" name="Patient_vehicle" value="Bus" onclick="togglePlaceInput()"> Bus<br>
                            <input type="radio" id="patient_jeepney" name="Patient_vehicle" value="Jeepney" onclick="togglePlaceInput()"> Jeepney 
                        </div>
                        <div class="col-md-4">
                            <input type="radio" id="patient_car" name="Patient_vehicle" value="Car" onclick="togglePlaceInput()"> Car<br>
                            <input type="radio" id="patient_bicycle" name="Patient_vehicle" value="Bicycle" onclick="togglePlaceInput()"> Bicycle<br>
                            <input type="radio" id="patient_van" name="Patient_vehicle" value="Van" onclick="togglePlaceInput()"> Van<br>
                            <input type="radio" id="patient_tricycle" name="Patient_vehicle" value="Tricycle" onclick="togglePlaceInput()"> Tricycle
                        </div>
                        <div class="col-md-4">
                                <input type="radio" id="patient_unknown" name="Patient_vehicle" value="Unknown" onclick="togglePlaceInput()"> Unknown<br>
                                <input type="radio" id="patient_others" name="Patient_vehicle" value="others" onclick="togglePlaceInput()"> Others<br>
                                <input type="text" class="form-control hidden" id="patient_vehicle_others" name="Patient_vehicle_others" placeholder="Others details">  
                        </div>
                        <div class="col-md-12 collision_group"><br>
                            <p>Other Vehicle/Object Involved (for Collision accident only)</p>
                            <div class="col-md-4"> <!--  <div class="col-md-3">  -->
                                <input type="radio" id="objectNone" name="Othercollision" value="None" onclick="togglePlaceInput()"> None<br>
                                <input type="radio" id="objectbicycle" name="Othercollision" value="Bicycle" onclick="togglePlaceInput()">Bicycle<br>
                                <input type="radio" id="objectcar" name="Othercollision" value="Car" onclick="togglePlaceInput()">Car <br>
                                <input type="radio" id="objectjeepney" name="Othercollision" value="Jeepney" onclick="togglePlaceInput()">Jeepney <br>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" id="objectvan" name="Othercollision" value="Van" onclick="togglePlaceInput()">Van<br>
                                <input type="radio" id="objectbus" name="Othercollision" value="Bus" onclick="togglePlaceInput()">Bus<br>
                                <input type="radio" id="objecttruck" name="Othercollision" value="truck" onclick="togglePlaceInput()">truck<br>
                                <input type="radio" id="objectothers" name="Othercollision" value="Others" onclick="togglePlaceInput()">Others:<br>
                                <input type="text" class="form-control hidden" id="other_collision_details" name="other_collision_details" placeholder="others details">
                            </div>
                            <div class="col-md-4">
                                <input type="radio" id="objectmotorcycle" name="Othercollision" value="Motorcycle" onclick="togglePlaceInput()">Motorcycle<br>
                                <input type="radio" id="objectTricycle" name="Othercollision" value="Tricycle" onclick="togglePlaceInput()">Tricycle<br>
                                <input type="radio" id="objectunknown" name="Othercollision" value="unknown" onclick="togglePlaceInput()">Unknown
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 transport-related">
                    <hr class="bold-line">
                        <br>
                        <p>Position of Patient</p>
                        <input type="radio" id="position_pedes" name="position_patient" value="Pedestrian" onclick="togglePlaceInput()"> Pedestrian<br>
                        <input type="radio" id="position_driver" name="position_patient" value="Driver" onclick="togglePlaceInput()"> Driver<br>
                        <input type="radio" id="position_captain" name="position_patient" value="Captain" onclick="togglePlaceInput()"> Captain<br>
                        <input type="radio" id="position_pilot" name="position_patient" value="Pilot" onclick="togglePlaceInput()"> Pilot<br>
                        <input type="radio" id="position_passenger" name="position_patient" value="Front Passenger" onclick="togglePlaceInput()"> Front Passenger<br>
                        <input type="radio" id="position_rear_passenger" name="position_patient" value="Rear Passenger" onclick="togglePlaceInput()"> Rear Passenger<br>
                        <input type="radio" id="position_unknown" name="position_patient" value="Unknown" onclick="togglePlaceInput()"> Unknown <br>
                        <input type="radio" id="position_others" name="position_patient" value="Others" onclick="togglePlaceInput()"> Others:<br>
                        <input type="text" class="form-control hidden" id="position_patient_details" name="position_other_details" placeholder="Others details">
                    </div>

                    <div class="col-md-3 transport-related">  <hr class="bold-line"><br>
                        <p>Place of Occurrence</p>
                        <input type="radio" id="place_home" name="Occurrence" value="Home" onclick="togglePlaceInput()"> Home<br>
                        <input type="radio" id="place_school" name="Occurrence" value="School" onclick="togglePlaceInput()"> School<br>
                        <input type="radio" id="place_Road" name="Occurrence" value="Road" onclick="togglePlaceInput()"> Road<br>
                        <input type="radio" id="place_Bars" name="Occurrence" value="School" onclick="togglePlaceInput()"> Videoke Bars<br>
                        <input type="radio" id="place_workplace" name="Occurrence" value="workplace" onclick="togglePlaceInput()"> Workplace, specify:<br>
                        <input type="text" class="form-control" id="workplace_occurence_details" name="workplace_occ_specify" placeholder="specify here" onclick="togglePlaceInput()">
                        <input type="radio" id="place_others" name="Occurrence" value="Others" onclick="togglePlaceInput()"> Others:<br>
                        <input type="text" class="form-control" id="place_other_details" name="Occurrence_others" placeholder="others details" onclick="togglePlaceInput()">
                        <input type="radio" id="place_unknown" name="Occurrence" value="Unknown" onclick="togglePlaceInput()"> Unknown
                    </div>
                    <div class="col-md-12 transport-related">
                            <hr class="bold-line">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Activity of the patient at the time of incident</label><br>
                                    <input type="radio" id="activity_sports" name="activity_patient" value="Sports" onclick="togglePlaceInput()"> Sports<br>
                                    <input type="radio" id="activity_leisure" name="activity_patient" value="leisure" onclick="togglePlaceInput()"> Leisure<br>
                                    <input type="radio" id="activity_school" name="activity_patient" value="Work Related" onclick="togglePlaceInput()"> Work Related<br>
                                    <input type="radio" id="activity_others" name="activity_patient" value="Others" onclick="togglePlaceInput()"> Others:
                                    <input type="text" class="form-control" id="activity_Patient_other" name="activity_patient_other" placeholder="others details" onclick="togglePlaceInput()"><br>
                                    <input type="radio" id="activity_unknown" name="activity_patient" value="unknown" onclick="togglePlaceInput()"> Unknown
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Other Risk Factors at the time of the incident:</label><br>
                                    <input type="radio" id="risk_liquor" name="risk_factors" value="Alcohol/liquor" onclick="togglePlaceInput()"> Alcohol/liquor<br>
                                    <input type="radio" id="risk_mobilephone" name="risk_factors" value="Using Mobile Phone" onclick="togglePlaceInput()"> Using Mobile Phone<br>
                                    <input type="radio" id="risk_sleepy" name="risk_factors" value="Sleepy" onclick="togglePlaceInput()"> Sleepy<br>
                                    <input type="radio" id="risk_smooking" name="risk_factors" value="smooking" onclick="togglePlaceInput()"> Smooking<br>
                                    <input type="radio" id="risk_others" name="risk_factors" value="Others" onclick="togglePlaceInput()"> Others specify:
                                    <input type="text" class="form-control" id="risk_others_details" name="rf_others" placeholder="others specify here">
                                    <p>(e.g., Suspected under the influence of substances)</p>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Safety: (check all that apply)</label><br>
                                    @foreach($safety as $safe)
                                        <div class="col-md-6">
                                            <input type="checkbox" id="safe_{{ $safe->id }}" name="safe[]" value="{{ $safe->id }}">{{ $safe->name }}<br>
                                        </div>
                                        @if(trim($safe->name) == 'Others')
                                            <input type="hidden" name="safety_others_id" value="{{ $safe->id }}">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="safeothers_details" name="safeothers_details" placeholder="others specify here">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                    </div>
                </div>
                <!-- end of transport-group -->
          
                    <div class="col-md-12">
                        <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 2px;margin-top: -10px; ">Hospital/Facility Data</h4>
                        @foreach($hospital_type as $hos)
                            @if(isSimilar($hos->category_name, "ER/OPD/BHS/RHU"))
                            <div class="A_ErOpdGroup">
                                <h6 class="A_Hospital mt-5" style="background-color: #A1A8C7;color: #ffff;padding: 3px;margin-top: -10px"> 
                                <input type="checkbox" id="A_ErOpd" name="hospital_data" value="{{$hos->id}}">
                                {{$hos->category_name}}</h6>
                                <div class="ER_Content" style="display:none">
                                    <div class="col-md-12">
                                        <label for="transferred facility">Transferred from another hospital/facility <span class="text-danger">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="YesTransferred" name="Transferred" value="1"> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="NoTransferred" name="Transferred" value="0"> No <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label for="referred by hospital">Referred by another Hospital/Facility for Laboratory and/or other medical procedures</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="ReferredYes" name="Referred" value="1"> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="Referredno" name="Referred" value="0"> No <br> <hr class="bold-line">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="nameofphysician">Name of the Originating Hospital/Physician: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name_orig" name="name_orig" placeholder="Name of the Originating Hospital/Physician">
                                    </div>
                                    <div class="col-md-12"><hr></div>
                                    <div class="col-md-3">
                                        <label for="">Status upon reashing the Facility</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="deadonarrive" name="reashingFact" value=" Dead on Arrival"> Dead on Arrival
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="alive" name="reashingFact" value="Alive"> Alive
                                    </div>
                                    <div class="col-md-1">
                                        <label for=""> If Alive: </label> 
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="conscious" name="ifAlive" value="conscious"> conscious
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="Unconscious" name="ifAlive" value="Unconscious"> Unconscious
                                    </div>
                                    <div class="col-md-12"></div>
                                    
                                    <div class="col-md-3"> <br><br>
                                        <label for="">Mode of Transport to the Hospital/Facility</label>
                                    </div>
                                    <div class="col-md-2"><br><br>
                                        <input type="radio" id="ambulance" name="mode_transport" value="Ambulance" onclick="togglePlaceInput()"> Ambulance
                                    </div>
                                    <div class="col-md-2"><br><br>
                                            <input type="radio" id="police_vehicle" name="mode_transport" value="Police Vehicle" onclick="togglePlaceInput()"> Police Vehicle
                                        </div>
                                        <div class="col-md-2"><br><br>
                                            <input type="radio" id="private_vehicle" name="mode_transport" value="Private Vehicle" onclick="togglePlaceInput()"> Private Vehicle
                                        </div>
                                        <div class="col-md-1"><br><br>
                                            <input type="radio" id="ModeOthers" name="mode_transport" value="Others" onclick="togglePlaceInput()"> Others:
                                        </div>
                                        <div class="col-md-2"><br><br>
                                            <input type="text" class="form-control" id="mode_others_details" name="mode_others_details" placeholder="others specify here">
                                    </div>
                                    <div class="col-md-12"> <hr class="bold-line">
                                    <label for="initial_imp">Initial Impression</label>
                                        <input type="text" class="form-control" id="Initial_Impression" name="Initial_Impression"> <br>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ICD-10 Code/s: Nature of injury</label>
                                        <input type="text" class="form-control" id="icd10_nature" name="icd10_nature" id="icd10_nature" >    
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ICD-10 Code/s: External Cause injury</label>
                                        <input type="text" class="form-control" id="icd10_external" name="icd10_external" id="icd10_external" >
                                    </div>
                                    <div class="col-md-12"> 
                                    <div class="row">
                                            <div class="col-md-12">
                                                <label for="Disposition">Disposition:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="radio" id="admitted" name="disposition" value="Admitted" onclick="togglePlaceInput()"> Admitted <br>
                                                <input type="radio" id="hama" name="disposition" value="HAMA"> HAMA
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" id="treated_sent" name="disposition" value="Treated and Sent Home" onclick="togglePlaceInput()"> Treated and Sent Home <br>
                                                <input type="radio" id="Absconded" name="disposition" value="Absconded" onclick="togglePlaceInput()"> Absconded
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" id="trans_facility_hos" name="disposition" value="Transferred to Another facility/hospital" onclick="togglePlaceInput()"> Transferred to Another facility/hospital,<br>
                                                <input type="text" class="form-control" id="trans_facility_hos_details" name="trans_facility_hos_details" value="" placeholder="Please specify">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <input type="radio" id="refused_admiss" name="disposition" value="Refused Admission" onclick="togglePlaceInput()"> Refused Admission <br>
                                                <input type="radio" id="died" name="disposition" value="died" onclick="togglePlaceInput()"> Died
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label for="Outcome">Outcome</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="Improved" name="outcome" value="Improved"> Improved
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="Unimproved" name="outcome" value="Unimproved"> Unimproved
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="Died1" name="outcome" value="died"> Died
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>                      
                    @foreach($hospital_type as $hos)
                        @if(isSimilar($hos->category_name,"In-patient(admitted)"))
                            <div class="B_InpatientGroup">
                                <div class="col-md-12">
                                    <h6 class="A_Hospital mt-5" style="background-color: #A1A8C7;color: #ffff;padding: 3px;margin-top: -10px"> 
                                    <input type="checkbox" id="B_InPatient" name="hospital_data_second" value="{{$hos->id}}">
                                    {{$hos->category_name}}</h6>
                                    <div class="In_patient_content" style="display:none">
                                        <div class="col-md-12">
                                            <label for="complete_final">Complete Final Diagnosis</label>
                                            <input type="text" class="form-control" id="complete_final" name="final_diagnose" id="" value="">
                                        </div>
                                        <div class="col-md-12"><hr>

                                            <label for="Disposition">Disposition:</label><br>
                                            <div class="col-md-3 col-md-offset-1">
                                                <input type="radio" id="discharged" name="disposition1" value="discharged" onclick="togglePlaceInput()"> Discharged <br>
                                                <input type="radio" id="refused_admiss1" name="disposition1" value="Refused Admission" onclick="togglePlaceInput()"> Refused Admission
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" id="HAMA1" name="disposition1" value="HAMA" onclick="togglePlaceInput()"> HAMA <br>
                                                <input type="radio" id="died2" name="disposition1" value="died" onclick="togglePlaceInput()"> Died
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" id="trans_facility_hos2" name="disposition1" value="Transferred to Another facility/hospital" onclick="togglePlaceInput()"> Transferred to Another facility/hospital <br>
                                                <input type="text" class="form-control" id="trans_facility_hos_details2" name="trans_facility_hos_details2" value="" placeholder="Please specify">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" id="absconded1" name="disposition1" value="Absconded" onclick="togglePlaceInput()"> Absconded <br>
                                                <input type="radio" id="disposition_others" name="disposition1" value="Others" onclick="togglePlaceInput()"> Others: 
                                                <input type="textbox" class="form-control" id="disposition_others_details" name="disposition_others_details" value="" placeholder="Others">
                                            </div>
                                        </div>
                                        <div class="col-md-12"><hr>
                                            <label for="Outcome">Outcome</label><br>
                                            <div class="col-md-2 col-md-offset-1">
                                                <input type="radio" id="Improved1" name="Outcome1" value="Improved"> Improved
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" id="Unimproved1" name="Outcome1" value="Unimproved"> Unimproved
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" id="died1" name="Outcome1" value="died"> Died
                                            </div>
                                        </div>
                                        <div class="col-md-6"><br>
                                            <label for="">ICD-10 Code/s: Nature of injury</label>
                                            <input type="text" class="form-control" id="icd10_nature1" name="icd10_nature1">    
                                        </div>
                                        <div class="col-md-6"><br>
                                            <label for="">ICD-10 Code/s: External Cause injury</label>
                                            <input type="text" class="form-control" id="icd10_external1" name="icd10_external1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach                 
                        <div class="col-md-12 text-center" style="margin-top: 20px;">
                            <button type="button" class="btn btn-primary mx-2" onclick="showPreviousStep()">Previous</button>
                            <button type="submit" class="btn btn-success mx-2">Submit</button>
                        </div>
                  
            </div>
        </form>
    </div>
</div>

<script>

 var baseUrl = "{{ url('sublist-patient') }}";
    function toggleCheckbox(checkbox) 
            { //BEHAVIOR SET-UP FOR CHECKBOX
                var checkboxes = document.querySelectorAll('input[name="fracttype"]');
                    if (checkbox.checked) {
                            checkboxes.forEach(function(cb) {
                            if (cb !== checkbox) {
                            cb.checked = false;
                            }
                        });
                    }
            }
   function togglePlaceInput() {
        const inputs = [
            { radio: document.getElementById('place_workplace'), input: document.getElementById('workplace_occurence_details') },
            { radio: document.getElementById('place_others'), input: document.getElementById('place_other_details') },
            { radio: document.getElementById('activity_others'), input: document.getElementById('activity_Patient_other') },
            { radio: document.getElementById('position_others'), input: document.getElementById('position_patient_details') },
            { radio: document.getElementById('patient_others'), input: document.getElementById('patient_vehicle_others') },
            { radio: document.getElementById('risk_others'), input: document.getElementById('risk_others_details') },
            { radio: document.getElementById('objectothers'), input: document.getElementById('other_collision_details') },
            { radio: document.getElementById('ModeOthers'), input: document.getElementById('mode_others_details') },
            { radio: document.getElementById('trans_facility_hos'), input: document.getElementById('trans_facility_hos_details') },
            { radio: document.getElementById('trans_facility_hos2'), input: document.getElementById('trans_facility_hos_details2') },
            { radio: document.getElementById('disposition_others'), input: document.getElementById('disposition_others_details') },
        ];

        inputs.forEach(item => {
            if (item.radio.checked) {
                item.input.classList.remove('hidden');
            } else {
                item.input.classList.add('hidden');
            }
        });
   }

   // Chest Pain Checkbox Logic
   const chestPainYes = document.getElementById('chestPainYes');
    const chestPainNo = document.getElementById('chestPainNo');
    const chestPainDetails = document.getElementById('chestPainDetails');

    chestPainYes.addEventListener('change', function () {
        if (this.checked) {
            chestPainDetails.disabled = false; // Enable the text box
            chestPainNo.checked = false; // Uncheck 'No' checkbox
        } else {
            chestPainDetails.disabled = true; // Disable the text box
        }
    });

    chestPainNo.addEventListener('change', function () {
        if (this.checked) {
            chestPainDetails.disabled = true; // Disable the text box
            chestPainYes.checked = false; // Uncheck 'Yes' checkbox
        }
    });

    // Difficulty of Breathing Checkbox Logic
    const breathingYes = document.getElementById('breathingYes');
    const breathingNo = document.getElementById('breathingNo');
    const breathingDetails = document.getElementById('breathingDetails');

    breathingYes.addEventListener('change', function () {
        if (this.checked) {
            breathingDetails.disabled = false; // Enable the text box
            breathingNo.checked = false; // Uncheck 'No' checkbox
        } else {
            breathingDetails.disabled = true; // Disable the text box
        }
    });

    breathingNo.addEventListener('change', function () {
        if (this.checked) {
            breathingDetails.disabled = true; // Disable the text box
            breathingYes.checked = false; // Uncheck 'Yes' checkbox
        }
    });

//    function validateAndNextStep() {
//     // Get all the required input fields
//     const requiredFields = [
//         { id: 'hospital_no', name: 'Hospital Case No' },
//         { id: 'fname', name: 'First Name' },
//         { id: 'lname', name: 'Last Name' },
//         { id: 'mname', name: 'Middle Name' },
      
//     ];

//     let allFieldsValid = true;
//     requiredFields.forEach(field => {
//         const inputElement = document.getElementById(field.id);
//         const value = inputElement.value.trim(); // Trim to remove extra spaces
//         if (value === '') {
//             allFieldsValid = false; // Set flag to false if any field is empty
//             inputElement.style.borderColor = 'red'; // Highlight empty field in red
//         } else {
//             inputElement.style.borderColor = ''; // Reset border if filled
//         }
//     });   

//         if (!allFieldsValid) {
//             // Alert user if any field is empty
//             alert('Please fill out all required fields.');
//             return;
//         }        
//         // If all fields are filled, proceed to the next step
//         document.getElementById('form-step-1').style.display = 'none'; 
//         document.getElementById('form-step-2').style.display = 'block';
//     }

//         document.getElementById('form-submit').addEventListener('submit', function (e) {
//             // Check if the form is valid
//             if (!this.checkValidity()) {
//                 e.preventDefault(); 
//                 this.reportValidity();
//             }
//         });

</script>
@endsection
@include('resu.manage_patient_injury.checkProfile')
<style>
    .json-display-style {
        background-color: black;
        color: yellow;
        padding: 10px;
        border-radius: 5px;
        }

        .col-divider { 
            border-right: 1px solid #ddd;
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
        margin-left: 96px; 
        vertical-align: middle;
    }
    .col-md-12 .col-md-3 .inline-input2{
        margin-left: -100px; 
        flex-shrink: 0;
    }
    .chosen-container-wrapper {
        max-width: 100%; 
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap; 
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .chosen-container-multi .chosen-choices {
        display: flex;
        flex-wrap: nowrap;
        overflow: hidden;
        white-space: nowrap;
        padding: 5px;
        gap: 5px;
        border: none;
    }

    .chosen-container-multi .chosen-choices li {
        display: inline-block;
        margin: 0 5px;
        list-style: none;
    }

    .chosen-container-multi .chosen-choices input[type="text"] {
        flex: 1;
        min-width: 50px;
        background: transparent;
        border: none;
        outline: none;
    }

    .bold-line {
        border: none;            /* Remove default hr styling */
        border-top: 2px solid #000; /* Bold line with black color */
        margin: 10px 0;          
        width: 100%;            
    }

    .is-invalid {
            border-color: red;
        }


    select, input {
        border: 1px solid #ced4da;
        transition: border-color 0.3s;
    }

    select:focus, input:focus {
        border-color: #80bdff;
        outline: 0;
    }

    select.error, input.error {
        border-color: red;
        animation: shake 0.3s;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

</style>