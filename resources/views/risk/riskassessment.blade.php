@extends('resu/app1')
@section('content')
@include('risk/riskSidebar')
@include('risk.risk_check_profile.riskCheckProfile');

<?php
 use App\Muncity;
 use App\Facility;
 use App\Province;
 
 $user = Auth::user();
 
 $facility = Facility::select('id','name','address','hospital_type')
 ->where('id', $user->facility_id)    
 ->get();

 //use Carbon\Carbon;
 //$dob = Carbon::parse($profile->dob);
 $province = Province::select('id', 'description')->get();

 $muncities = Muncity::select('id', 'description')->get();

?>
    <div class="col-md-8 wrapper" style="flex-direction: column; justify-content: center; align-items: center; padding-bottom: 5%">
       <div class="alert alert-jim">
        <h2 class="page-header"  style="text-align: center">
            <i class="fa fa-user"></i>&nbsp; PHILPEN RISK ASSESSMENT FORM (REVISED 2022)
            <br>
            <p style="font-size: 15pt; font-style: italic; text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adults > 20 years old</p>
        </h2>
        <div class="page-divider"></div>
        <!-- <form class="form-horizontal form-submit" id="form-submit" method="POST" action="{{ route('submit-patient-form') }}"> -->
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
                                <input type="text" class="form-control" name="facilityname" id="facility" readonly value="{{ json_decode($facility, true)[0]['name'] ?? 'N/A' }}">
                             </div> 
                                 @php
                                    use Carbon\Carbon;
                                @endphp
                                <!-- <label for="address-facility">Date of Assessment</label>
                                <input type="text" class="form-control" name="addressfacility" id="addressfacility" readonly value="{{$facility->address}}"> -->
                                    <div class="col-md-6">
                                        <label for="date-of-assessment">Date of Assessment</label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="date_of_assessment" 
                                            id="date-of-assessment" 
                                            readonly 
                                           value="{{ Carbon::now()->format('F d, Y') }}"
                                        >
                                    </div>
                            <br><br>
                            <br><br>
                        </div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 2px;">I. PATIENT'S INFORMATION</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="lname">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lname" id="lname" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="fname">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fname" id="fname" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="mname">Middle Name </label>
                                <input type="text" class="form-control" name="mname" id="mname" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="suffix">Suffix</label>
                                <select class="form-control chosen-select" name="suffix" id="suffix">
                                    <option value="">Select suffix</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="sex">Sex <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="sex" id="sex">
                                    <option value="">Select sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="dateofbirth">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="dateofbirth" name="dateofbirth">
                            </div>
                            <div class="col-md-3">
                                <label for="age">Age <span class="text-danger"></span></label>
                                <input type="text" class="form-control" id="age" name="age" value="" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="civil_status">Civil Status <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="civil_status" id="civil_status">
                                    <option value="">Select status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Legally Separated">Legally Separated</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="religion">Religion <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="religion" id="religion" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="contact">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contact" id="contact" value="">
                            </div>
                            <div class="row"></div>
                            <div class="col-md-4">
                                <label for="province">Province/HUC <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="province" id="province">
                                    <option value="">Select Province</option>
                                    @foreach($province as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="municipal">Municipal <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="municipal" id="municipal">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="barangay">Barangay <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="barangay" id="barangay">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="street">Street</label>
                                <input type="text" class="form-control" name="street" id="street" value="">
                            </div>
                            <div class="col-md-4">
                                <label for="purok">Purok</label>
                                <input type="text" class="form-control" name="purok" id="purok" value="">
                            </div>
                            <div class="col-md-4">
                                <label for="sitio">Sitio</label>
                                <input type="text" class="form-control" name="sitio" id="sitio" value="">
                            </div>
                            <div class="col-md-5">
                                <label for="phic_id">PhilHealth No.</label>
                                <input type="text" class="form-control" name="phic_id" id="phic_id" value=""><br>
                            </div>
                            <div class="col-md-7">
                                <label for="pwd_id">Persons with Disability ID Card No. if applicable:</label>
                                <input type="text" class="form-control" name="pwd_id" id="pwd_id" value=""><br>
                            </div>
                            <div class="col-md-3">
                                <label for="ethnicity">Ethnicity:</label>
                                <select class="form-control" name="ethnicity" id="ethnicity">
                                    <option value="">Select an Option</option>
                                    <option value="bisaya">Bisaya</option>
                                    <option value="ilonggo">Ilonggo</option>
                                    <option value="waray">Waray</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <label class="mr-2">Indigenous Person:</label><br>
                                <input type="checkbox" name="indigenous_person" id="indigenous_person">
                                <label for="indigenous_person" class="ml-2">Yes</label>
                                <input type="checkbox" name="indigenous_person" id="indigenous_person">
                                <label for="indigenous_person" class="ml-2">No</label>
                                <br>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <label class="mr-2">Employment Status:</label><br>
                                <input type="checkbox" name="employment_status" id="employment_status">
                                <label for="employment_status" class="ml-2">Employed</label>
                                <input type="checkbox" name="employment_status" id="employment_status">
                                <label for="employment_status" class="ml-2">Unemployed</label>
                                <input type="checkbox" name="employment_status" id="employment_status">
                                <label for="employment_status" class="ml-2">Self-Employed</label>
                                <br>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <div>
                            <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">II. ASSESS FOR RED FLAGS <span class="text-danger">*</span></h4>
                            <p style="font-style: italic; font-size: 15px;">
                                If YES to ANY, REFER IMMEDIATELY to a Physician for further management and/or referral to the next level of care. If ALL answers are NO, proceed to Part III.
                            </p>
                        </div>
                        <div style="display: flex; justify-content: end">
                            <button type="button" class="btn btn-sm btn-primary" onclick="checkAllNo()">Check All No</button>
                        </div>
                        <!-- <button type="button" class="btn btn-sm btn-primary" onclick="checkAllNo()">Check All No</button> -->
                        <br>
                    </div>
                    <div class="col-md-12" style="display: flex; align-items: center; ">
                                <table class="table table-bordered" >
                            <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;">                                                                       
                                   <tr>
                                        <td>2.1 Chest Pain</td>
                                        <td>
                                            <input type="checkbox" class="healthCheckbox" id="dfbYes" value="Yes" onclick="toggleCheckbox('dfbYes', 'dfbNo')"> Yes
                                            <input type="checkbox" class="healthCheckbox" id="dfbNo" value="No" onclick="toggleCheckbox('dfbNo', 'dfbYes')"> No
                                        </td>
                                    </tr>
                                <tr>
                                    <td>2.2 Difficulty of Breathing</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="dfbYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="dfbNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.3 Loss of Consciousness</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="lossConYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="lossConNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.4 Slurred Speech</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="slurredYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="slurredNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.5 Facial Asymmetry</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="facialYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="facialNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                <td>2.6 Weakness/Numbness on arm <br> of the left on one side of the body</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="weaknumbYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="weaknumbNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.7 Disoriented as to time, <br> place and person</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="disYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="disNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.8 Chest Retractions</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="chestRetractYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="chestRetractNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.9 Seizure or Convulsion</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="seizureYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="seizuredNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.10 Act of self-harm or suicide</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="selfharmYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="selfharmNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.11 Agitated and/or aggressive behavior</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="agitatedYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="agitatedNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.12 Eye Injury/ Foreign Body on the eye</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="eyeInjuryYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="eyeInjuryNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.13 Severe Injuries</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="severeYes" value="Yes"> Yes
                                        <input type="checkbox" class="healthCheckbox" id="severeNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
                <div class="additional-inputs">
                        <div class="col-md-3">
                            <label for="physicianName">Physician Name:</label>
                            <input type="text" class="form-control" id="physicianName" placeholder="Enter physician name">
                        </div>
                        <div class="col-md-3" style="right: -10%">
                            <label for="reason">Reason:</label>
                            <input type="text" class="form-control" id="reason" placeholder="Enter reason">
                        </div>
                        <div class="col-md-3" style="right: -20%">
                            <label for="facility">What Facility:</label>
                            <input type="text" class="form-control" id="facility" placeholder="Enter facility"> 
                            <!-- Dropdown Menu -->
                        </div>
                </div>
                <div class="row">
                        <div class="col-md-12 text-center" style="margin-top: 20px;">
                            <!-- <button type="button" class="btn btn-primary mx-2" >Next</button> -->
                             <button type="button" class="btn btn-primary mx-2" onclick="showNextStep()">Next</button>
                        </div>
                 </div>
            </div>
         <!-- PAST MEDICAL HISTORY -->
         <div class="form-step" id="form-step-2" style="display: none;">
             <div class="row">
                    <div class="col-md-12">
                        <div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">III. PAST MEDICAL HISTORY <span class="text-danger">*</span></h4>
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
                            <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;"> 
                                   <tr>
                                        <td>3.1 Hypertension</td>
                                        <td>
                                            <input type="checkbox" class="hypertensionCheckbox" id="hypertensionYes" value="Yes"> Yes
                                            <input type="checkbox" class="hypertensionCheckbox" id="hypertensionNo" value="No"> No
                                        </td>
                                    </tr>
                                <tr>
                                    <td>3.2 Heart Disease</td>
                                    <td>
                                        <input type="checkbox" class="heartdiseaseCheckbox" id="heartsdiseaseYes" value="Yes"> Yes
                                        <input type="checkbox" class="heartdiseaseCheckbox" id="heartdiseaseNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.3 Diabetes</td>
                                    <td>
                                        <input type="checkbox" class="diabetesCheckbox" id="diabetesYes" value="Yes"> Yes
                                        <input type="checkbox" class="diabetesCheckbox" id="diabetesNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.4 Cancer</td>
                                    <td>
                                        <input type="checkbox" class="cancerCheckbox" id="cancerYes" value="Yes"> Yes
                                        <input type="checkbox" class="cancerCheckbox" id="cancerNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.5 COPD</td>
                                    <td>
                                        <input type="checkbox" class="codCheckbox" id="codYes" value="Yes"> Yes
                                        <input type="checkbox" class="codCheckbox" id="codNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                <td>3.6 Asthma</td>
                                    <td>
                                        <input type="checkbox" class="asthmaCheckbox" id="asthmaYes" value="Yes"> Yes
                                        <input type="checkbox" class="asthmaCheckbox" id="asthmaNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td> 3.7 Allergies</td>
                                    <td>
                                        <input type="checkbox" class="allergiesCheckbox" id="allergiesYes" value="Yes"> Yes
                                        <input type="checkbox" class="allergiesCheckbox" id="allergiesNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>3.8 Mental, Neurological, and Substance-Abuse Disorder</td>
                                    <td>
                                        <input type="checkbox" class="mnsCheckbox" id="mnsYes" value="Yes"> Yes
                                        <input type="checkbox" class="mnsCheckbox" id="mnsNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>3.9 Vision Problems</td>
                                    <td>
                                        <input type="checkbox" class="visionCheckbox" id="visionYes" value="Yes"> Yes
                                        <input type="checkbox" class="visionCheckbox" id="visionNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>3.10 Previous Surgical History</td>
                                    <td>
                                        <input type="checkbox" class="surgicalhistoryCheckbox" id="surgicalhistoryYes" value="Yes"> Yes
                                        <input type="checkbox" class="surgicalhistoryCheckbox" id="surgicalhistoryNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>3.11 Thyroid Disorders</td>
                                    <td>
                                        <input type="checkbox" class="thyroidCheckbox" id="thyroidYes" value="Yes"> Yes
                                        <input type="checkbox" class="thyroidCheckbox" id="thyroidNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>3.12 Kidney Disorders</td>
                                    <td>
                                        <input type="checkbox" class="kidneyCheckbox" id="kidneyYes" value="Yes"> Yes
                                        <input type="checkbox" class="kidneyCheckbox" id="kidneyNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">IV. FAMILY HISTORY <span class="text-danger">*</span></h4>
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
                            <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;"> 
                                   <tr>
                                        <td>4.1 Hypertension</td>
                                        <td>
                                            <input type="checkbox" class="hyperCheckbox" id="hyperYes" value="Yes"> Yes
                                            <input type="checkbox" class="hyperCheckbox" id="hyperNo" value="No"> No
                                        </td>
                                       
                                    </tr>
                                <tr>
                                    <td>4.2 Stroke</td>
                                    <td>
                                        <input type="checkbox" class="strokeCheckbox" id="strokeYes" value="Yes"> Yes
                                        <input type="checkbox" class="strokeCheckbox" id="strokeNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>4.3 Heart Disease (change from "Cardiovascular") </td>
                                    <td>
                                        <input type="checkbox" class="heartdisCheckbox" id="heartdisYes" value="Yes"> Yes
                                        <input type="checkbox" class="heartdisCheckbox" id="heartdisNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>4.4 Diabetes Mellitus</td>
                                    <td>
                                        <input type="checkbox" class="diabetesmelCheckbox" id="diabetesmelYes" value="Yes"> Yes
                                        <input type="checkbox" class="diabetemelCheckbox" id="diabetesmelNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>4.5 Asthma</td>
                                    <td>
                                        <input type="checkbox" class="asthmas_Checkbox" id="asthmaYes" value="Yes"> Yes
                                        <input type="checkbox" class="asthmas_Checkbox" id="asthmaNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                <td>4.6 Cancer</td>
                                    <td>
                                        <input type="checkbox" class="cancer_Checkbox" id="cancer_Yes" value="Yes"> Yes
                                        <input type="checkbox" class="cancer_Checkbox" id="cancer_No" value="No" style="margin-left: flex"> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td> 4.7 Kidney Disease </td>
                                    <td>
                                        <input type="checkbox" class="kidneyDis_Checkbox" id="kidney_diYes" value="Yes"> Yes
                                        <input type="checkbox" class="kidneyDis_Checkbox" id="kidney_disNo" value="No" style="margin-left: flex"> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>4.8 1st Degree relative with premature coronary <br> disease or vascular disease <br> (includes "Heart Attack")</td>
                                    <td>
                                        <input type="checkbox" class="degreerelativeCheckbox" id="degreerelativeYes" value="Yes"> Yes
                                        <input type="checkbox" class="degreerelativeCheckbox" id="degreerelativeNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>4.9 Family having TB in the last 5 years </td>
                                    <td>
                                        <input type="checkbox" class="familytbCheckbox" id="familytbYes" value="Yes"> Yes
                                        <input type="checkbox" class="familytbCheckbox" id="familytbNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>4.10 Mental, Neuroligical and Substance Abuse Disorder</td>
                                    <td>
                                        <input type="checkbox" class="mnsadCheckbox" id="mnsadYes" value="Yes"> Yes
                                        <input type="checkbox" class="mnsadCheckbox" id="mnsadNo" value="No" style="margin-left: flex"> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>4.11 COPD</td>
                                    <td>
                                        <input type="checkbox" class="COPCheckbox" id="COPYes" value="Yes"> Yes
                                        <input type="checkbox" class="COPCheckbox" id="COPNo" value="No" style="margin-left: flex"> No
                                    </td>
                                   
                                </tr>
                            </tbody>
                        </table>
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
                <!-- risk factors -->
                <div class="col-md-12">
                        <div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">V. NCD RISK FACTORS <span class="text-danger">*</span></h4>
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
                            <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;"> 
                                   <tr>
                                        <td>5.1 Tobacco Use</td>
                                        <td>
                                            <input type="checkbox" class="q1Checkbox" id="q1" value="Yes"> Q1 Never Used (proceed to Q2) <br>
                                            <input type="checkbox" class="q2Checkbox" id="q2" value="Yes"> Q2 Exposure to secondhand smoke <br>
                                            <input type="checkbox" class="q3Checkbox" id="q3" value="Yes"> Q3 Former tobacco user (stopped smoking > 1 year) <br>
                                            <input type="checkbox" class="q4Checkbox" id="q4" value="Yes"> Q4 Current tobacco user (currently smoking or stopped smoking) <br> <br>
                                            
                                            <p style="font-style: italic; font-size: 15px;">
                                                If YES to Q2-Q4, follow the tobacco cessation protocol (5As) and use Form 1. Tobacco Cessation Referral Protocol, if needed.
                                            </p>
                                        </td>
                                       
                                    </tr>
                                <tr>
                                    <td>5.2 Alcohol Intake</td>
                                    <td>
                                         <input type="checkbox" class= "alcoholq1Checkbox" id="alcoholq1Never" value="No"> Never Consumed 
                                         <input type="checkbox" class="alcoholq1Checkbox" id="alcoholq1Yes" value="Yes"> Yes, drinks alcohol
                                        <br><br><br><br>
                                        <input type="checkbox" class="alcoholq1Checkbox" id="alcoholq1Yes" value="Yes"> Do you drink 5 or more standards drinks for men, and 4 or more for women (in one sitting/occasion) in the past year? <br><br>
                                        <br>
                                            <p style="font-style: italic; font-size: 15px;">
                                                If NO, congratulate the patient. The patient is at a lower risk of drinking alcohol.
                                                If YES, proceed using AUDIT SCREENING TOOL (Form 2) to assess alcohol consumption and alcohol problems.
                                                If binge drinker, provide brief advice and/or extended brief advice. The patient is on the higher risk category level of drinking or in harmful use of alcohol.
                                            </p>
                                         <br>
                                    </td>
                                   
                                    
                                </tr>
                                <tr>
                                    <td>5.3 Physical Activity </td>
                                    <td>
                                        Does the patient do at least 2.5 hours a week of moderate-intensity physical activity?  <br><br>
                                        <input type="checkbox" class="physicalCheckbox" id="physicalYes" value="Yes"> Yes
                                        <input type="checkbox" class="physicalCheckbox" id="physicalNo" value="No" style="margin-left: flex"> No
                                        <br>

                                        <br>
                                            <p style="font-style: italic; font-size: 15px;">
                                            If NO or patient does not reach the recommended hours/week of moderate-intensity physical activity, give lifestyle modification advice following Annex 1. Healthy Lifestyle Module.
                                         <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5.4 Nutrition and Dietary Assessment </td>
                                    <td>
                                        Q1 Does the patient eat high fat, high salt food,(processed/fast food such as instant <br> noodles, burgers, fries, dried fish),
                                        "ihaw-ihaw/fried" (e.g isaw, barbecue, liver, chicken skin)and high sugar food and drinks (e.g chocolates, cakes, pastries, softdrinks) weekly? <br><br><br>
                                        <input type="checkbox" class="nutritionDietCheckbox" id="nutritionDietYes" value="Yes"> Yes
                                        <input type="checkbox" class="nutritionDietCheckbox" id="nutritionDietNo" value="No" style="margin-left: flex"> No
                                        <br><br><br>
                                            <p style="font-style: italic; font-size: 15px;">
                                            If YES to the question, give lifestyle modification advice following Annex 2. Nutrition Practice Guidelines for Health Professionals in the Primary Care Screening.
                                         <br>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        5.5 Weight (kg) 
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="weight" value=""> 
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        5.6 Height (cm) 
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="height" value=""> 
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                        5.7 Body Mass Index (wt.[kgs]/ht[cm]x 10,000): 
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="BMI" value=""> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        5.8 Waist Circumference (cm): F < 80cm M < 90
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="waist" value=""> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        5.9 Blood Pressure (mmHg)
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="bloodPressure" value=""> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                <div class="col-md-12">
                    <div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB; color: white; padding: 3px; margin-top: -10px;">
                            V. RISK SCREENING <span class="text-danger">*</span>
                        </h4>
                    </div>
                </div>
                <div class="col-md-12">
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                        <tr>
                            <th colspan="2" style="border: 1px solid #000; padding: 10px; background-color: #f2f2f2;">
                                6.1 Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases
                            </th>
                        </tr>

                        <?php 
                        // PHP array to define sections and inputs
                        $sections = [
                            "Blood Sugar" => [
                                ["label" => "FBS Result", "type" => "text"],
                                ["label" => "RBS Result", "type" => "text"],
                                ["label" => "Date Taken", "type" => "date"]
                            ],
                            "Check if DM clinical symptoms are present" => [
                                ["label" => "Polyphagia", "type" => "checkbox"],
                                ["label" => "Polydipsia", "type" => "checkbox"],
                                ["label" => "Polyuria", "type" => "checkbox"]
                            ],
                            "Lipid Profile" => [
                                ["label" => "Total Cholesterol", "type" => "text"],
                                ["label" => "HDL", "type" => "text"],
                                ["label" => "LDL", "type" => "text"],
                                ["label" => "VLDL", "type" => "text"],
                                ["label" => "Triglyceride", "type" => "text"],
                                ["label" => "Date Taken", "type" => "date"]
                            ],
                            "Urinalysis/ Urine Dipstick Test" => [
                                ["label" => "Protein", "type" => "text"],
                                ["label" => "Ketones", "type" => "text"],
                                ["label" => "Date Taken", "type" => "date"]
                            ]
                        ];
                        // Loop through the sections to generate the table rows
                        foreach ($sections as $section => $inputs): ?>
                            <tr>
                                <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                    <?= $section ?>
                                </td>
                                <td style="border: 1px solid #000; padding: 10px;">
                                    <?php if ($inputs[0]['type'] === 'checkbox'): ?>
                                        <div class="checkbox-group" style="display: flex; gap: 10px;">
                                            <?php foreach ($inputs as $input): ?>
                                                <label>
                                                    <input type="checkbox" name="<?= strtolower($input['label']) ?>"> 
                                                    <?= $input['label'] ?>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($inputs as $input): ?>
                                            <div style="margin-bottom: 10px;">
                                                <label><?= $input['label'] ?>:</label>
                                                <input type="<?= $input['type'] ?>" name="<?= strtolower(str_replace(' ', '_', $input['label'])) ?>" 
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="2" style="border: 1px solid #000; padding: 10px; background-color: #f2f2f2;">
                                6.2 Chronic Respiratory Disease (Asthma and COPD)
                            </th>
                        </tr>

                        <?php 
                // PHP array to define sections and inputs
                    $sections = [
                        "CHECK all applicable" => [
                            ["label" => "Breathlessness (or a 'need for air')", "type" => "checkbox"],
                            ["label" => "Chronic cough", "type" => "checkbox"],
                            ["label" => "Sputum (mucous) production", "type" => "checkbox"],
                            ["label" => "Chest tightness", "type" => "checkbox"],
                            ["label" => "Wheezing", "type" => "checkbox"]
                        ],
                        "If YES to any of the symptoms, obtain peak expiratory flow rate (PEFR). 
                        Give inhaled salbutamol, then repeat after 15 minutes." => [
                            "RESULTS" => [
                                ["label" => ">20% change from baseline (consider Probable Asthma)", "type" => "checkbox"],
                                ["label" => "<20% change from baseline (consider Probable COPD)", "type" => "checkbox"]
                            ]
                        ]
                    ];

                    // Loop through the sections to generate the table rows
                    foreach ($sections as $section => $inputs): ?>
                        <tr>
                            <td style="border: 1px solid #000; padding: 10px; font-weight: bold; width: 25%;">
                                <?= $section ?>
                            </td>
                            <td style="border: 1px solid #000; padding: 10px;">
                                <div class="checkbox-group" style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                                <?php if (is_array($inputs) && isset($inputs['RESULTS'])): ?>
                                            <p><strong>Results:</strong></p>
                                            <div class="checkbox-group" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                <?php foreach ($inputs['RESULTS'] as $input): ?>
                                                    <label style="display: flex; align-items: center; gap: 5px;">
                                                        <input type="<?= $input['type'] ?>" name="<?= strtolower(str_replace(' ', '_', $input['label'])) ?>"> 
                                                        <?= $input['label'] ?> 
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="checkbox-group" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                <?php foreach ($inputs as $input): ?>
                                                    <label style="display: flex; align-items: center; gap: 5px;">
                                                        <input type="<?= $input['type'] ?>" name="<?= strtolower(str_replace(' ', '_', $input['label'])) ?>"> 
                                                        <?= $input['label'] ?> 
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                    </div>

                        <div class="col-md-12 text-center" style="margin-top: 20px;">
                            <button type="button" class="btn btn-primary mx-2" onclick="showPreviousStep()">Previous</button>
                            <button type="button" class="btn btn-primary mx-2" onclick="showNextStep()">Next</button>
                        </div>
                    </div>
                </div>

            <div class="form-step" id="form-step-5" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB; color: white; padding: 3px; margin-top: -10px;">
                            VII. MANAGEMENT <span class="text-danger">*</span>
                        </h4>
                    </div>
                </div>
                <div class="col-md-12">
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                        <?php
                        // PHP array to define the management sections
                        $management = [
                            "Lifestyle Modification" => [
                                "type" => "textarea",
                                "name" => "lifestyle_modification"
                            ],
                            "Medications" => [
                                "Anti-Hypertensives" => [
                                    "name" => "anti_hypertensives",
                                    "options" => ["Yes", "No", "Unknown"],
                                    "specify" => "anti_hypertensives_specify"
                                ],
                                "Anti-Diabetes" => [
                                    "name" => "anti_diabetes",
                                    "options" => ["Yes", "No", "Unknown"],
                                    "sub-options" => ["Oral Hypoglycemic", "Insulin", "Not Known", "Others"],
                                    "specify" => "anti_diabetes_specify"
                                ]
                            ],
                            "Date of Follow-up" => [
                                "type" => "date",
                                "name" => "follow_up_date"
                            ],
                            "Remarks" => [
                                "type" => "textarea",
                                "name" => "remarks"
                            ]
                        ];
                        ?>

                <!-- HTML Table Structure for Management Section -->
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: left; background-color: #f1f1f1; padding: 10px;">Lifestyle Modification</th>
                        </tr>
                    </thead>
                    <tbody>
                     <!-- Medications Section -->
                        <tr>
                            <td style="font-weight: bold;">Medications</td>
                            <td>
                                <!-- Anti-Hypertensives -->
                                <div>
                                    <label style="font-weight: bold;">a. Anti-Hypertensives:</label>
                                    <div style="display: flex; gap: 10px; margin-top: 5px;">
                                        <?php foreach ($management['Medications']['Anti-Hypertensives']['options'] as $option): ?>
                                            <label>
                                                <input type="radio" name="anti_hypertensives" value="<?= strtolower($option) ?>"> <?= $option ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="text" name="anti_hypertensives_specify" placeholder="Specify medicine" 
                                         style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                </div>

                                <!-- Anti-Diabetes -->
                                <div style="margin-top: 10px;">
                                    <label style="font-weight: bold;">b. Anti-Diabetes:</label>
                                    <div style="display: flex; gap: 10px; margin-top: 5px;">
                                        <?php foreach ($management['Medications']['Anti-Diabetes']['options'] as $option): ?>
                                            <label>
                                                <input type="radio" name="anti_diabetes" value="<?= strtolower($option) ?>"> <?= $option ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>

                                    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px;">
                                        <?php foreach ($management['Medications']['Anti-Diabetes']['sub-options'] as $subOption): ?>
                                            <label>
                                                <input type="radio" name="anti_diabetes_type" value="<?= strtolower(str_replace(' ', '_', $subOption)) ?>"> <?= $subOption ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="text" name="anti_diabetes_specify" placeholder="Specify medicine" 
                                        style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                </div>
                            </td>
                        </tr>
                        <!-- Date of Follow-up Section -->
                        <tr>
                            <td style="font-weight: bold;">Date of Follow-up</td>
                            <td>
                                <input type="date" name="follow_up_date" value="<?= date('Y-m-d') ?>" 
                                    style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 8px;">
                            </td>
                        </tr>

                        <!-- Remarks Section -->
                        <tr>
                            <td style="font-weight: bold;">Remarks</td>
                            <td>
                                <textarea name="remarks" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>

                    </table>
                    </div>
                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                            <button type="button" class="btn btn-primary mx-2" onclick="showPreviousStep()">Previous</button>
                            <button type="submit" class="btn btn-success mx-2">Submit</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>

<script>
//  var baseUrl = "{{ url('sublist-patient') }}";
//     function toggleCheckbox(checkbox) 
//             { //BEHAVIOR SET-UP FOR CHECKBOX
//                 var checkboxes = document.querySelectorAll('input[name="fracttype"]');
//                     if (checkbox.checked) {
//                             checkboxes.forEach(function(cb) {
//                             if (cb !== checkbox) {
//                             cb.checked = false;
//                             }
//                         });
//                     }
//             }
//    function togglePlaceInput() {
//         const inputs = [
//             { radio: document.getElementById('place_workplace'), input: document.getElementById('workplace_occurence_details') },
//             { radio: document.getElementById('place_others'), input: document.getElementById('place_other_details') },
//             { radio: document.getElementById('activity_others'), input: document.getElementById('activity_Patient_other') },
//             { radio: document.getElementById('position_others'), input: document.getElementById('position_patient_details') },
//             { radio: document.getElementById('patient_others'), input: document.getElementById('patient_vehicle_others') },
//             { radio: document.getElementById('risk_others'), input: document.getElementById('risk_others_details') },
//             { radio: document.getElementById('objectothers'), input: document.getElementById('other_collision_details') },
//             { radio: document.getElementById('ModeOthers'), input: document.getElementById('mode_others_details') },
//             { radio: document.getElementById('trans_facility_hos'), input: document.getElementById('trans_facility_hos_details') },
//             { radio: document.getElementById('trans_facility_hos2'), input: document.getElementById('trans_facility_hos_details2') },
//             { radio: document.getElementById('disposition_others'), input: document.getElementById('disposition_others_details') },
//         ];

//         inputs.forEach(item => {
//             if (item.radio.checked) {
//                 item.input.classList.remove('hidden');
//             } else {
//                 item.input.classList.add('hidden');
//             }
//         });
//    }

   // Get all checkboxes with class 'healthCheckbox'
   document.addEventListener('DOMContentLoaded', () => {
        // Hide additional inputs on page load
        const additionalInputs = document.querySelector('.additional-inputs');
        additionalInputs.style.display = 'none';

        // Get all checkboxes with class 'healthCheckbox'
        const healthCheckboxes = document.querySelectorAll('.healthCheckbox');

        // Add an event listener to each checkbox
        healthCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                // Check if any "Yes" checkbox is checked
                const anyChecked = Array.from(healthCheckboxes).some(cb => cb.checked && cb.id.endsWith('Yes'));
                // Show or hide additional inputs based on checkbox status
                additionalInputs.style.display = anyChecked ? 'block' : 'none';
            });
        });
    });
    function checkAllNo() {
        const noCheckboxes = document.querySelectorAll('input[type="checkbox"][value="No"]');
        const allChecked = Array.from(noCheckboxes).every(checkbox => checkbox.checked);

        // Check or uncheck all "No" checkboxes based on current state
        noCheckboxes.forEach(checkbox => {
            checkbox.checked = !allChecked; // Toggle the checkbox state
        });

        // Hide additional inputs as "No" is selected
        const additionalInputs = document.querySelector('.additional-inputs');
        additionalInputs.style.display = 'none';
    }

    // Toggle Checkbox
    function toggleCheckbox(currentId, otherId) {
        document.getElementById(otherId).checked = false;
    }
</script>
@endsection

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

    .additional-inputs {
            display: none; /* Initially hide the inputs */
            margin-top: 15px;
        }

</style>