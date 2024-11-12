@extends('resu/app1')
@section('content')

<?php
 use App\Muncity;
 use App\Facility;
 use App\Province;
 use App\Barangay;
 
 $user = Auth::user();
   $facilities = Facility::select('id', 'name')->get();
   $facilities = Facility::select('id', 'name')->get();
 $facility = Facility::select('id','name','address','hospital_type')
 ->where('id', $user->facility_id)    
 ->get();

 use Carbon\Carbon;
 $dob = Carbon::parse($profile->dob);
 $province = Province::select('id', 'description')->get();
 $barangay = Barangay::select('id', 'description')->get();

    $muncities = Muncity::select('id', 'description')->get();
    function isSimilar($str1, $str2) { // this is for Hospital/Facility Data function
        similar_text(strtolower(trim($str1)), strtolower(trim($str2)), $percent);
        return $percent >= 80; // You can adjust the threshold as needed
    }

?>
    <div class="col-md-12 wrapper" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <div class="col-md-8 wrapper" style="padding-bottom: 5%">
       <div class="alert alert-jim">
        <h2 class="page-header"  style="text-align: center">
            <i class="fa fa-user"></i>&nbsp; PHILPEN RISK ASSESSMENT FORM (REVISED 2022)
            <br>
            <p style="font-size: 15pt; font-style: italic; text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adults > 20 years old</p>
        </h2>
        <div class="page-divider"></div>
        <!-- <form class="form-horizontal form-submit" id="form-submit" method="POST" action="{{ route('submit-patient-risk-form') }}"> -->
        <form class="form-horizontal form-submit" id="form-submit" action="{{ route('sublist.risk.patient', ['id' => $profile->id]) }}" method="GET">
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
                                <input type="hidden" name="facility_id_updated" id="facility_id_updated" value="{{ json_decode($facility, true)[0]['id'] ?? 'N/A' }}"> 
                            </div> 
                                
                                <!-- <label for="address-facility">Date of Assessment</label>
                                <input type="text" class="form-control" name="addressfacility" id="addressfacility" readonly value="{{$facility->address}}"> -->
                                    <div class="col-md-6">
                                        <label for="date-of-assessment">Date of Assessment</label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="date_of_assessment" 
                                            id="date-of-assessment" 
                                            readonly 
                                            value="{{ $profile->created_at ? \Carbon\Carbon::parse($profile->created_at)->format('F d, Y') : '' }}"
                                        >
                                    </div>
                            <br><br>
                            <br><br>
                        </div>
                    <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 2px;">I. PATIENT'S INFORMATION</h4>
                        <div class="row">
                            <input type="hidden" name="profile_id" id="profile_id">
                            <input type="hidden" name="profile_id" id="profile_id" value="{{ $profile->id ?? '' }}">

                            <div class="col-md-3">
                                <label for="lname">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lname" maxlength="25" id="lname" value="{{ $profile->lname ?? '' }}" readonly>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="fname">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fname" maxlength="25" id="fname" value="{{ $profile->fname ?? '' }}" readonly>
                            </div>
                        
                            <div class="col-md-3">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" name="mname" maxlength="25" id="mname" value="{{ $profile->mname ?? '' }}" readonly>
                            </div>
                        
                            <div class="col-md-3">
                                <label for="suffix">Suffix</label>
                                <select class="form-control chosen-select" name="suffix" id="suffix" disabled>
                                    <option value="">Select suffix</option>
                                    <option value="Jr." {{ $profile->suffix == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                    <option value="Sr." {{ $profile->suffix == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                    <option value="I" {{ $profile->suffix == 'I' ? 'selected' : '' }}>I</option>
                                    <option value="II" {{ $profile->suffix == 'II' ? 'selected' : '' }}>II</option>
                                    <option value="III" {{ $profile->suffix == 'III' ? 'selected' : '' }}>III</option>
                                    <option value="IV" {{ $profile->suffix == 'IV' ? 'selected' : '' }}>IV</option>
                                    <option value="V" {{ $profile->suffix == 'V' ? 'selected' : '' }}>V</option>
                            
                                    <!-- Default "N/a" option if suffix is null or empty -->
                                    @if(is_null($profile->suffix) || $profile->suffix === '')
                                        <option value="N/a" selected>N/a</option>
                                    @else
                                        <option value="N/a">N/a</option>
                                    @endif
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="sex">Sex <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="sex" id="sex">
                                    <option value="">Select sex</option>
                                    <option value="Male" {{ $profile->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $profile->sex == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">  
                                <label for="dateofbirth">Date Of Birth</label>
                                <input type="text" class="form-control" id="dateofbirth" name="dateBirth" value="{{ $profile->dob ? \Carbon\Carbon::parse($profile->dob)->format('F d, Y') : '' }}" readonly>
                            </div>
                        
                            <div class="col-md-3">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" id="age" name="age" value="{{ $profile->age ?? '' }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="civil_status">Civil Status <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="civil_status" id="civil_status">
                                    <option value="">Select status</option>
                                    <option value="Single" {{ $profile->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ $profile->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ $profile->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    <option value="Legally Separated" {{ $profile->civil_status == 'Legally Separated' ? 'selected' : '' }}>Legally Separated</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="religion">Religion <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="religion" id="religion" onchange="showOtherReligionField()">
                                    <option value="">Select Religion</option>
                                    <option value="Roman Catholic" {{ $profile->religion == 'Roman Catholic' ? 'selected' : '' }}>Roman Catholic</option>
                                    <option value="Islam" {{ $profile->religion == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Iglesia ni Cristo" {{ $profile->religion == 'Iglesia ni Cristo' ? 'selected' : '' }}>Iglesia ni Cristo</option>
                                    <option value="Seventh-day Adventist" {{ $profile->religion == 'Seventh-day Adventist' ? 'selected' : '' }}>Seventh-day Adventist</option>
                                    <option value="Iglesia Filipina Independiente" {{ $profile->religion == 'Iglesia Filipina Independiente' ? 'selected' : '' }}>Iglesia Filipina Independiente/Aglipayan</option>
                                    <option value="Bible Baptist Church" {{ $profile->religion == 'Bible Baptist Church' ? 'selected' : '' }}>Bible Baptist Church</option>
                                    <option value="UCCP" {{ $profile->religion == 'UCCP' ? 'selected' : '' }}>United Church of Christ in The Philippines</option>
                                    <option value="Jehovah’s Witnesses" {{ $profile->religion == 'Jehovah’s Witnesses' ? 'selected' : '' }}>Jehovah’s Witnesses</option>
                                    <option value="Church of Christ" {{ $profile->religion == 'Church of Christ' ? 'selected' : '' }}>Church of Christ</option>
                                    <option value="Latter-Day Saints" {{ $profile->religion == 'Latter-Day Saints' ? 'selected' : '' }}>Latter-Day Saints</option>
                                    <option value="Assemblies of God" {{ $profile->religion == 'Assemblies of God' ? 'selected' : '' }}>Assemblies of God</option>
                                    <option value="Kingdom of Jesus Christ" {{ $profile->religion == 'Kingdom of Jesus Christ' ? 'selected' : '' }}>Kingdom of Jesus Christ</option>
                                    <option value="Evangelical" {{ $profile->religion == 'Evangelical' ? 'selected' : '' }}>Evangelical</option>
                                    <option value="Baptists" {{ $profile->religion == 'Baptists' ? 'selected' : '' }}>Baptists</option>
                                    <option value="Methodists" {{ $profile->religion == 'Methodists' ? 'selected' : '' }}>Methodists</option>
                                    <option value="Hinduism" {{ $profile->religion == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                                    <option value="Buddhism" {{ $profile->religion == 'Buddhism' ? 'selected' : '' }}>Buddhism</option>
                                    <option value="Judaism" {{ $profile->religion == 'Judaism' ? 'selected' : '' }}>Judaism</option>
                                    <option value="Baha'i" {{ $profile->religion == 'Baha\'i' ? 'selected' : '' }}>Baha'i</option>
                                    <option value="Jainism" {{ $profile->religion == 'Jainism' ? 'selected' : '' }}>Jainism</option>
                                    <option value="Others" {{ $profile->religion == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>
                            
                            <!-- This div will only appear if Others is selected -->
                            <div class="col-md-3" id="other-religion-div">
                                <label for="other_religion">Specify Other Religion <span class="text-danger" readonly>*</span></label>
                                <input type="text" class="form-control" name="other_religion" id="other_religion" maxlength="50" placeholder="Please specify" value="{{ $profile->other_religion ?? '' }}" readonly>
                            </div>

                            <div class="col-md-3">
                                <label for="contact">Contact Number <span class="text-danger" readonly>*</span></label>
                                <input type="text" class="form-control" name="contact" id="contact" maxlength="11" value="{{ $profile->contact ?? '' }}"readonly>
                            </div>
                            <div class="row"></div>
                            <div class="col-md-4">
                                <label for="province">Province/HUC <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="province" id="province">
                                    <option value="">Select Province</option>
                                    @foreach($province as $prov)
                                    <option value="{{ $prov->id }}" {{ $profile->province_id == $prov->id ? 'selected' : ''}}>{{ $prov->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="municipal">Municipality/City <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="municipal" id="municipal">
                                    <option value="">Select Muncity</option>
                                    @foreach($muncities as $mun)
                                    <option value="{{ $mun->id }}" {{ $profile->municipal_id == $mun->id ? 'selected' : ''}}>{{ $mun->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="barangay">Barangay <span class="text-danger">*</span></label>
                                <select class="form-control chosen-select" name="barangay" id="barangay">
                                    <option value="">Select Barangay</option>
                                    @foreach($barangay as $bar)
                                    <option value="{{ $bar->id }}" {{ $profile->barangay_id == $bar->id ? 'selected' : ''}}>{{ $bar->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="street">Street</label>
                                <input type="text" class="form-control" name="street" id="street" maxlength="25" value="{{ $profile->street ?? '' }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="purok">Purok</label>
                                <input type="text" class="form-control" name="purok" id="purok" maxlength="25" value="{{ $profile->purok ?? '' }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="sitio">Sitio</label>
                                <input type="text" class="form-control" name="sitio" id="sitio" maxlength="25" value="{{ $profile->sitio ?? '' }}" readonly>
                            </div>
                            <div class="col-md-5">
                                <label for="phic_id">PhilHealth No.</label>
                                <input type="text" class="form-control" name="phic_id" id="phic_id" maxlength="12" value="{{ $profile->phic_id ?? '' }}" readonly><br>
                            </div>
                            <div class="col-md-7">
                                <label for="pwd_id">Persons with Disability ID Card No. if applicable:</label>
                                <input type="text" class="form-control" name="pwd_id" id="pwd_id" maxlength="13" value="{{ $profile->pwd_id ?? '' }}" readonly><br>
                            </div>
                            <div class="col-md-3">
                                <label for="ethnicity">Ethnicity</label>
                                <select class="form-control" name="ethnicity" id="ethnicity" onchange="showOtherEthnicityField()">
                                    <option value="">Select Ethnicity</option>
                                    <option value="Cebuano" {{ $profile->ethnicity == 'Cebuano' ? 'selected' : '' }}>Cebuano</option> 
                                    <option value="Bisaya" {{ $profile->ethnicity == 'Bisaya' ? 'selected' : '' }}>Bisaya</option>
                                    <option value="Tagalog" {{ $profile->ethnicity == 'Tagalog' ? 'selected' : '' }}>Tagalog</option>
                                    <option value="Waray" {{ $profile->ethnicity == 'Waray' ? 'selected' : '' }}>Waray</option>
                                    <option value="Ilonggo" {{ $profile->ethnicity == 'Illongo' ? 'selected' : '' }}>Illongo</option>
                                    <option value="Bicolano" {{ $profile->ethnicity == 'Bicolano' ? 'selected' : '' }}>Bicolano</option>
                                    <option value="Kampampangan" {{ $profile->ethnicity == 'Kampampangan' ? 'selected' : '' }}>Kapampangan</option> 
                                    <option value="Maguindanao" {{ $profile->ethnicity == 'Maguindanao' ? 'selected' : '' }}>Maguindanao</option>
                                    <option value="Pangasinan" {{ $profile->ethnicity == 'Pangasinan' ? 'selected' : '' }}>Pangasinan</option>
                                    <option value="Badjao" {{ $profile->ethnicity == 'Badjao' ? 'selected' : '' }} >Badjao</option>
                                    <option value="Tausug" {{ $profile->ethnicity == 'Tausug' ? 'selected' : '' }} >Tausug</option>
                                    <option value="Maranao" {{ $profile->ethnicity == 'Maranao' ? 'selected' : '' }} >Maranao</option>
                                    <option value="Thai" {{ $profile->ethnicity == 'Thai' ? 'selected' : '' }}>Thai</option> 
                                    <option value="Vietnamese" {{ $profile->ethnicity == 'Vietnamese' ? 'selected' : '' }}>Vietnamese</option>
                                    <option value="Indonesian" {{ $profile->ethnicity == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                                    <option value="Malaysian" {{ $profile->ethnicity == 'Malaysian' ? 'selected' : '' }}>Malaysian</option> 
                                    <option value="Singaporean" {{ $profile->ethnicity == 'Singaporean' ? 'selected' : '' }}>Singaporean</option> 
                                    <option value="Australian" {{ $profile->ethnicity == 'Australian' ? 'selected' : '' }}>Australian</option>
                                    <option value="Chinese" {{ $profile->ethnicity == 'Chinese' ? 'selected' : '' }}>Chinese</option> 
                                    <option value="Indian" {{ $profile->ethnicity == 'Indian' ? 'selected' : '' }}>Indian</option>
                                    <option value="American" {{ $profile->ethnicity == 'American' ? 'selected' : '' }}>American</option>
                                    <option value="Canadian" {{ $profile->ethnicity == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                    <option value="Swiss" {{ $profile->ethnicity == 'Swiss' ? 'selected' : '' }}>Swiss</option>
                                    <option value="Japanese" {{ $profile->ethnicity == 'Japanese' ? 'selected' : '' }}>Japanese</option>
                                    <option value="Korean" {{ $profile->ethnicity == 'Korean' ? 'selected' : '' }}>Korean</option>
                                    <option value="British" {{ $profile->ethnicity == 'British' ? 'selected' : '' }}>British</option> 
                                    <option value="Spanish" {{ $profile->ethnicity == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                                    <option value="French" {{ $profile->ethnicity == 'French' ? 'selected' : '' }}>French</option>
                                    <option value="German" {{ $profile->ethnicity == 'German' ? 'selected' : '' }}>German</option>
                                    <option value="Russian" {{ $profile->ethnicity == 'Russian' ? 'selected' : '' }}>Russian</option> 
                                    <option value="Others" {{ $profile->ethnicity == 'Others' ? 'selected' : '' }} readonly>Others</option>
                                   
                                </select>
                            </div>
                            
                            <!-- This div will only appear if Others is selected -->
                            <div class="col-md-3" id="other-ethnicity-div" >
                                <label for="other_ethnicity">Specify Other Ethnicity <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="other_ethnicity" id="other_ethnicity" placeholder="Please specify ethnicity" value="{{ $profile->other_ethnicity ?? '' }}" readonly>
                            </div> 
                            <div class="col-md-3 d-flex align-items-center">
                                <label class="mr-2">Indigenous Person</label><br>
                                <span style="padding-right: 10px;">
                                    <input type="checkbox" name="indigenous_person_yes" id="indigenous_person_yes" value="yes" 
                                        {{ $profile->indigenous_person == 'yes' ? 'checked' : '' }} onclick="toggleCheckbox('yes')">
                                    <label for="indigenous_person_yes" class="ml-2">Yes</label>
                                </span>
                                <span style="padding-right: 10px;">
                                    <input type="checkbox" name="indigenous_person_no" id="indigenous_person_no" value="no" 
                                        {{ $profile->indigenous_person == 'no' ? 'checked' : '' }} onclick="toggleCheckbox('no')">
                                    <label for="indigenous_person_no" class="ml-2">No</label>
                                </span>
                            </div>
                            
                            <div class="row"></div>
                            <br/> 
                            <div class="col-md-6 d-flex align-items-center">
                                <label class="mr-2">Employment Status</label><br>
                                <span style="padding-right: 10px;">
                                    <input type="checkbox" name="employment_status" id="employment_status_employed" value="employed" 
                                        {{ $profile->employment_status == 'employed' ? 'checked' : '' }} onclick="toggleEmploymentStatus('employed')">
                                    <label for="employment_status_employed" class="ml-2">Employed</label>
                                </span>
                                <span style="padding-right: 10px;">
                                    <input type="checkbox" name="employment_status" id="employment_status_unemployed" value="unemployed" 
                                        {{ $profile->employment_status == 'unemployed' ? 'checked' : '' }} onclick="toggleEmploymentStatus('unemployed')">
                                    <label for="employment_status_unemployed" class="ml-2">Unemployed</label>
                                </span>
                                <span style="padding-right: 10px;">
                                    <input type="checkbox" name="employment_status" id="employment_status_self_employed" value="self-employed" 
                                        {{ $profile->employment_status == 'self-employed' ? 'checked' : '' }} onclick="toggleEmploymentStatus('self-employed')">
                                    <label for="employment_status_self_employed" class="ml-2">Self-Employed</label>                                   
                                </span> 
                            </div>
                            
                        </div>
                        <br/><br/>
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
                        <br>
                    </div>
                    <div class="col-md-12" style="display: flex; align-items: center; ">
                        <table class="table table-bordered" >
                            <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;">                                                                       
                                <tr>
                                    <td>2.1 Chest Pain</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="chpYes" name="chest_pain" {{ $profile->riskForm->ar_chestpain == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="chpNo" name="chest_pain" {{ $profile->riskForm->ar_chestpain == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.2 Difficulty of Breathing</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="dfbYes" name="difficulty_breathing" {{ $profile->riskForm->ar_diffBreath == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="dfbNo" name="difficulty_breathing" {{ $profile->riskForm->ar_diffBreath == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.3 Loss of Consciousness</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="lossConYes"  name="loss_of_consciousness" {{ $profile->riskForm->ar_lossOfConsciousness == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="lossConNo"  name="loss_of_consciousness" {{ $profile->riskForm->ar_lossOfConsciousness == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.4 Slurred Speech</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="slurredYes" name ="slurred_speech" {{ $profile->riskForm->ar_slurredSpeech == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="slurredNo" name ="slurred_speech" {{ $profile->riskForm->ar_slurredSpeech == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.5 Facial Asymmetry</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="facialYes" name= "facial_asymmetry" {{ $profile->riskForm->ar_facialAsymmetry == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="facialNo" name= "facial_asymmetry" {{ $profile->riskForm->ar_facialAsymmetry == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                <td>2.6 Weakness/Numbness on arm <br> of the left on one side of the body</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="weaknumbYes" name="weakness_numbness" {{ $profile->riskForm->ar_weaknessNumbness == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="weaknumbNo" name="weakness_numbness" {{ $profile->riskForm->ar_weaknessNumbness == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.7 Disoriented as to time, <br> place and person</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="disYes" name="disoriented" {{ $profile->riskForm->ar_disoriented == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="disNo" name="disoriented" {{ $profile->riskForm->ar_disoriented == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.8 Chest Retractions</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="chestRetractYes"  name="chest_retractions" {{ $profile->riskForm->ar_chestRetraction == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="chestRetractNo" name="chest_retractions" {{ $profile->riskForm->ar_chestRetraction == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.9 Seizure or Convulsion</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="seizureYes" name="seizures" {{ $profile->riskForm->ar_seizureConvulsion == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="seizuredNo" name="seizures" {{ $profile->riskForm->ar_seizureConvulsion == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.10 Act of self-harm or suicide</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="selfharmYes" name="self_harm" {{ $profile->riskForm->ar_actSelfHarmSuicide == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="selfharmNo" name="self_harm" {{ $profile->riskForm->ar_actSelfHarmSuicide == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.11 Agitated and/or aggressive behavior</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="agitatedYes" name="agitated_behavior" {{ $profile->riskForm->ar_agitatedBehaivior == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="agitatedNo" name="agitated_behavior" {{ $profile->riskForm->ar_agitatedBehaivior == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.12 Eye Injury/ Foreign Body on the eye</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="eyeInjuryYes" name="eye_injury" {{ $profile->riskForm->ar_eyeInjury == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="eyeInjuryNo" name="eye_injury" {{ $profile->riskForm->ar_eyeInjury == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.13 Severe Injuries</td>
                                    <td>
                                        <input type="checkbox" class="healthCheckbox" id="severeYes" {{ $profile->riskForm->ar_severeInjuries == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="healthCheckbox" id="severeNo" {{ $profile->riskForm->ar_severeInjuries == 'No' ? 'checked' : '' }}> No
                                    </td>
                                    </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
                <div class="additional-inputs">
                        <div class="col-md-4">
                            <label for="physicianName">Physician Name:</label>
                            <input type="text" class="form-control" id="physicianName" name="physician_name" placeholder="Enter physician name" value="{{ $profile->riskForm->ar_refer_physicianName ?? '' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="reason">Reason:</label>
                            <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter reason" value="{{ $profile->riskForm->ar_refer_reason ?? '' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="facility">What Facility:</label>
                            <select class="form-control chosen-select" name="facility" id="facility" style="width: 100%; max-width: 100%;" readonly>
                                <option value="">Select Facility...</option>
                                @foreach($facilities as $fact)
                                    <option value="{{ $fact->id }}" {{ $profile->riskForm->ar_refer_facility == $fact->id ? 'selected' : '' }}>
                                        {{ $fact->name }} {{ $fact->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        
                </div>
                <div class="row">   
                        <div class="col-md-12 text-center" style="margin-top: 20px;">
                             <button type="button" class="btn btn-primary mx-2" onclick="showNextStep()">Next</button>
                        </div>
                 </div>
            </div>
            <!-- PAST MEDICAL HISTORY -->
            <div class="form-step" id="form-step-2" style="display: none">
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
                                            <input type="checkbox" class="hypertensionCheckbox" id="pm_hypertensionYes" name="pm_hypertension" {{ $profile->riskForm->pmh_hypertension == 'Yes' ? 'checked' : '' }}> Yes
                                            <input type="checkbox" class="hypertensionCheckbox" id="pm_hypertensionNo" name="pm_hypertension" {{ $profile->riskForm->pmh_hypertension == 'No' ? 'checked' : '' }}> No
                                        </td>
                                    </tr>
                                <tr>
                                    <td>3.2 Heart Disease</td>
                                    <td>
                                        <input type="checkbox" class="heartdiseaseCheckbox" id="pm_heartsdiseaseYes" name="pm_heartDisease" {{ $profile->riskForm->pmh_heartDisease == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="heartdiseaseCheckbox" id="pm_heartdiseaseNo" name="pm_heartDisease" {{ $profile->riskForm->pmh_heartDisease == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.3 Diabetes</td>
                                    <td>
                                        <input type="checkbox" class="diabetesCheckbox" id="pm_diabetesYes" name="pm_diabetes" {{ $profile->riskForm->pmh_diabetes == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="diabetesCheckbox" id="pm_diabetesNo" name="pm_diabetes" {{ $profile->riskForm->pmh_diabetes == 'No' ? 'checked' : '' }}> No
                                        <br/>
                                        <textarea class="col-md-12" id="diabetesDetailsInput"  name="pm_diabetes_details"  value="{{ $profile->riskForm->pmh_specify_diabetes ?? '' }}" readonly></textarea>
                               
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.4 Cancer</td>
                                    <td>
                                        <input type="checkbox" class="cancerCheckbox" id="pm_cancerYes" name= "pm_cancer"{{ $profile->riskForm->pmh_cancer == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="cancerCheckbox" id="pm_cancerNo"  name= "pm_cancer" {{ $profile->riskForm->pmh_cancer == 'No' ? 'checked' : '' }}> No
                                       <br/>    
                                         <textarea class="col-md-12" id="cancerDetailsInput" name="pm_cancer_details"  value="{{ $profile->riskForm->pmh_specify_cancer ?? '' }}" readonly></textarea>
                                    </td>
                                </tr>
                            </tr>
                           
                                <tr>
                                    <td>3.5 COPD</td>
                                    <td>
                                        <input type="checkbox" class="codCheckbox" id="pm_codYes" name="pm_COPD" {{ $profile->riskForm->pmh_COPD == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="codCheckbox" id="pm_codNo" name="pm_COPD"{{ $profile->riskForm->pmh_COPD == 'No' ? 'checked' : '' }}> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                <td>3.6 Asthma</td>
                                    <td>
                                        <input type="checkbox" class="asthmaCheckbox" id="pm_asthmaYes" name="pm_asthma" {{ $profile->riskForm->pmh_asthma == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="asthmaCheckbox" id="pm_asthmaNo" name="pm_asthma" {{ $profile->riskForm->pmh_asthma == 'No' ? 'checked' : '' }}> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td> 3.7 Allergies</td>
                                    <td>
                                        <input type="checkbox" class="allergiesCheckbox" id="pm_allergiesYes" name="pm_allergies" {{ $profile->riskForm->pmh_allergies == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="allergiesCheckbox" id="pm_allergiesNo" name="pm_allergies" {{ $profile->riskForm->pmh_allergies == 'No' ? 'checked' : '' }}> No
                                        <br/>
                                        <textarea class="col-md-12" id="allergiesDetailsInput"  name="pm_allergies_details"  value="{{ $profile->riskForm->pmh_specify_allergies ?? '' }}" readonly></textarea>
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>3.8 Mental, Neurological, and Substance-Abuse Disorder</td>
                                    <td>
                                        <input type="checkbox" class="mnsCheckbox" id="pm_mnsYes" name ="pm_mnsad" {{ $profile->riskForm->pmh_MNandSDisorder == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="mnsCheckbox" id="pm_mnsNo"  name ="pm_mnsad" {{ $profile->riskForm->pmh_MNandSDisorder == 'No' ? 'checked' : '' }}> No
                                        <br/>
                                        <textarea class="col-md-12" id="mnsDetailsInput" name="pm_mnsad_details"  value="{{ $profile->riskForm->pmh_specify_MNandSDisorder ?? '' }}" readonly></textarea>
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>3.9 Vision Problems</td>
                                    <td>
                                        <input type="checkbox" class="visionCheckbox" id="pm_visionYes" name= "pm_vision" {{ $profile->riskForm->pmh_visionProblems == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="visionCheckbox" id="pm_visionNo"  name= "pm_vision" {{ $profile->riskForm->pmh_visionProblems == 'No' ? 'checked' : '' }}> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>3.10 Previous Surgical History</td>
                                    <td>
                                        <input type="checkbox" class="surgicalhistoryCheckbox" id="pm_surgicalhistoryYes" {{ $profile->riskForm->pmh_previous_Surgical == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="surgicalhistoryCheckbox" id="pm_surgicalhistoryNo" {{ $profile->riskForm->pmh_previous_Surgical == 'No' ? 'checked' : '' }}> No
                                        <br/>
                                        <textarea class="col-md-12" id="surgicalDetailsInput" name="pm_psh_details"  readonly></textarea>
                                   
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>3.11 Thyroid Disorders</td>
                                    <td>
                                        <input type="checkbox" class="thyroidCheckbox" id="pm_thyroidYes" {{ $profile->riskForm->pmh_thyroidDisorders == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="thyroidCheckbox" id="pm_thyroidNo" {{ $profile->riskForm->pmh_thyroidDisorders == 'No' ? 'checked' : '' }}> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>3.12 Kidney Disorders</td>
                                    <td>
                                        <input type="checkbox" class="kidneyCheckbox" id="pm_kidneyYes" name="pm_kidney" {{ $profile->riskForm->pmh_kidneyDisorders == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="kidneyCheckbox" id="pm_kidneyNo" name="pm_kidney" {{ $profile->riskForm->pmh_kidneyDisorders == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <div>
                        <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">IV. FAMILY HISTORY <span class="text-danger" >*</span></h4>
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
                                            <input type="checkbox" class="hyperCheckbox" id="fh_hyperYes" name="fm_hypertension" {{ $profile->riskForm->fm_hypertension == 'Yes' ? 'checked' : '' }}> Yes
                                            <input type="checkbox" class="hyperCheckbox" id="fh_hyperNo"  name="fm_hypertension" {{ $profile->riskForm->fm_hypertension == 'No' ? 'checked' : '' }}> No
                                        </td>
                                       
                                    </tr>
                                <tr>
                                    <td>4.2 Stroke</td>
                                    <td>
                                        <input type="checkbox" class="strokeCheckbox" id="fh_strokeYes" name="fm_stroke" {{ $profile->riskForm->fm_stroke == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="strokeCheckbox" id="fh_strokeNo" name="fm_stroke" {{ $profile->riskForm->fm_stroke == 'No' ? 'checked' : '' }}> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>4.3 Heart Disease (change from "Cardiovascular") </td>
                                    <td>
                                        <input type="checkbox" class="heartdisCheckbox" id="fh_heartdisYes" name="fm_heart" {{ $profile->riskForm->fm_heartDisease == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="heartdisCheckbox" id="fh_heartdisNo" name="fm_heart" {{ $profile->riskForm->fm_heartDisease == 'No' ? 'checked' : '' }}> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>4.4 Diabetes Mellitus</td>
                                    <td>
                                        <input type="checkbox" class="diabetesmelCheckbox" id="fh_diabetesmelYes" {{ $profile->riskForm->fm_diabetesMel == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="diabetemelCheckbox" id="fh_diabetesmelNo"  {{ $profile->riskForm->fm_diabetesMel == 'No' ? 'checked' : '' }}> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>4.5 Asthma</td>
                                    <td>
                                        <input type="checkbox" class="asthmas_Checkbox" id="fh_asthmaYes"   {{ $profile->riskForm->fm_asthma == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="asthmas_Checkbox" id="fh_asthmaNo"  {{ $profile->riskForm->fm_asthma == 'No' ? 'checked' : '' }}> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                <td>4.6 Cancer</td>
                                    <td>
                                        <input type="checkbox" class="cancer_Checkbox" id="fh_cancer_Yes"  {{ $profile->riskForm->fm_cancer == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="cancer_Checkbox" id="fh_cancer_No" {{ $profile->riskForm->fm_cancer == 'No' ? 'checked' : '' }}> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td> 4.7 Kidney Disease </td>
                                    <td>
                                        <input type="checkbox" class="kidneyDis_Checkbox" id="fh_kidney_diYes" {{ $profile->riskForm->fm_kidneyDisease == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="kidneyDis_Checkbox" id="fh_kidney_disNo" {{ $profile->riskForm->fm_kidneyDisease == 'No' ? 'checked' : '' }}> No
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>4.8 1st Degree relative with premature coronary <br> disease or vascular disease <br> (includes "Heart Attack")</td>
                                    <td>
                                        <input type="checkbox" class="degreerelativeCheckbox" id="fh_degreerelativeYes" name="fm_degree" {{ $profile->riskForm->fm_firstDegreRelative == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="degreerelativeCheckbox" id="fh_degreerelativeNo" name="fm_degree" {{ $profile->riskForm->fm_firstDegreRelative == 'No' ? 'checked' : '' }}> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>4.9 Family having TB in the last 5 years </td>
                                    <td>
                                        <input type="checkbox" class="familytbCheckbox" id="fh_familytbYes"  name="fm_famtb"  {{ $profile->riskForm->fm_havingTB5years == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="familytbCheckbox" id="fh_familytbNo"  name="fm_famtb" {{ $profile->riskForm->fm_havingTB5years == 'No' ? 'checked' : '' }}> No
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td>4.10 Mental, Neuroligical and Substance Abuse Disorder</td>
                                    <td>
                                        <input type="checkbox" class="mnsadCheckbox" id="fh_mnsadYes" name="fm_mnsad" {{ $profile->riskForm->fm_MNandSDisorder == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="mnsadCheckbox" id="fh_mnsadNo" name="fm_mnsad" {{ $profile->riskForm->fm_MNandSDisorder == 'No' ? 'checked' : '' }}> No
                                    </td>
                                </tr>
                                <tr>
                                    <td>4.11 COPD</td>
                                    <td>
                                        <input type="checkbox" class="COPCheckbox" id="fh_COPYes" value="Yes" {{ $profile->riskForm->fm_COPD == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="COPCheckbox" id="fh_COPNo" value="No"  {{ $profile->riskForm->fm_COPD == 'No' ? 'checked' : '' }}> No
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
             <div class="form-step" id="form-step-3" style="display: none">
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
                                        <!-- Never Used (proceed to Q2) checkbox -->
                                        <input type="checkbox" class="tobaccoCheckbox" id="q1" name="tobaccoUse[]">
                                        Never Used (proceed to Q2) <br>
                                
                                        <!-- Exposure to secondhand smoke checkbox (this will be checked) -->
                                        <input type="checkbox" class="tobaccoCheckbox" id="q2" name="tobaccoUse[]" checked>
                                        Exposure to secondhand smoke <br>
                                
                                        <!-- Former tobacco user checkbox (this will be checked) -->
                                        <input type="checkbox" class="tobaccoCheckbox" id="q3" name="tobaccoUse[]" checked>
                                        Former tobacco user (stopped smoking > 1 year) <br>
                                
                                        <!-- Current tobacco user checkbox -->
                                        <input type="checkbox" class="tobaccoCheckbox" id="q4" name="tobaccoUse[]">
                                        Current tobacco user (currently smoking or stopped smoking) <br><br>
                                
                                        <p style="font-style: italic; font-size: 15px;">
                                            If YES to Q2-Q4, follow the tobacco cessation protocol (5As) and use Form 1. Tobacco Cessation Referral Protocol, if needed.
                                        </p>
                                    </td>
                                </tr>                        
                                    <td>5.2 Alcohol Intake</td>
                                <td>
                                    <input type="checkbox" class="alcoholCheckbox" id="alcoholNever" name="ncd_alcohol" {{ $profile->riskForm->rf_alcoholIntake == 'No' ? 'checked' : '' }}> Never Consumed 
                                    <input type="checkbox" class="alcoholCheckbox" id="alcoholYes" name="ncd_alcohol" {{ $profile->riskForm->rf_alcoholIntake == 'Yes' ? 'checked' : '' }}> Yes, drinks alcohol
                                    
                                    <br><br>
                                    <label id="bingeLabel" style="opacity: 0.5;">
                                        <input type="checkbox" class="alcoholCheckbox" id="alcoholBinge" name="ncd_alcoholBinge" {{ $profile->riskForm->rf_alcoholBingeDrinker == 'Yes' ? 'checked' : '' }}>
                                        Do you drink 5 or more standard drinks for men, and 4 or more for women (in one sitting/occasion) in the past year?
                                    </label>
                                    <br><br>

                                    <p style="font-style: italic; font-size: 15px;">
                                        If NO, congratulate the patient. The patient is at a lower risk of drinking alcohol.<br>
                                        If YES, proceed using AUDIT SCREENING TOOL (Form 2) to assess alcohol consumption and alcohol problems. 
                                        If binge drinker, provide brief advice and/or extended brief advice. The patient is on the higher risk category level of drinking or in harmful use of alcohol.
                                    </p>
                                </td>
                                </tr>
                                <tr>
                                    <td>5.3 Physical Activity </td>
                                    <td>
                                        Does the patient do at least 2.5 hours a week of moderate-intensity physical activity?  <br><br>
                                        <input type="checkbox" class="physicalCheckbox" id="physicalYes" name="ncd_physical" {{ $profile->riskForm->rf_physicalActivity == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="physicalCheckbox" id="physicalNo" name="ncd_physical" {{ $profile->riskForm->rf_physicalActivity == 'No' ? 'checked' : '' }}> No
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
                                         Does the patient eat high fat, high salt food,(processed/fast food such as instant <br> noodles, burgers, fries, dried fish),
                                        "ihaw-ihaw/fried" (e.g isaw, barbecue, liver, chicken skin)and high sugar food and drinks (e.g chocolates, cakes, pastries, softdrinks) weekly? <br><br><br>
                                        <input type="checkbox" class="nutritionDietCheckbox" id="nutritionDietYes"  {{ $profile->riskForm->rf_nutritionDietary == 'Yes' ? 'checked' : '' }}> Yes
                                        <input type="checkbox" class="nutritionDietCheckbox" id="nutritionDietNo"  {{ $profile->riskForm->rf_nutritionDietary == 'No' ? 'checked' : '' }}> No
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
                                        <input type="text" class="textbox" id="weight" name="rf_weight"oninput="calculateBMI()" value="{{ $profile->riskForm->rf_weight ?? '' }}" readonly> 
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        5.6 Height (cm) 
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="height"  name="rf_height" oninput="calculateBMI()" value="{{ $profile->riskForm->rf_height ?? '' }}" readonly> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        5.7 Body Mass Index (wt.[kgs]/ht[cm]x 10,000): 
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="BMI" value="{{ $profile->riskForm->rf_bodyMass ?? '' }}" name="rf_BMI" readonly><p><i><span style="font-size: 13.5px; font-weight: 300; padding-left: 5px;" id="bmiStrVal" ></span></i></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        5.8 Waist Circumference (cm): F < 80cm M < 90
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="waist" name ="rf_waist" value="{{ $profile->riskForm->rf_waistCircum ?? '' }}" readonly> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        5.9 Blood Pressure (mmHg)
                                    </td>
                                    <td>
                                        <input type="text" class="textbox" id="bloodPressure" name="rf_bloodPressure" value="{{ $profile->riskForm->rf_bloodPressure ?? '' }}" readonly> 
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
                        <tr>
                            <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                Blood Sugar
                            </td>
                            <td style="border: 1px solid #000; padding: 10px;">
                                <div style="margin-bottom: 10px;">
                                    <label>FBS Result:</label>
                                    <input type="text" name="fbs_result" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_bloodSugar_fbs ?? '' }}"readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>RBS Result:</label>
                                    <input type="text" name="rbs_result" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_bloodSugar_rbs ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>Date Taken:</label>
                                    <input type="date" name="bloodSugar_date_taken" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_bloodSugar_date_taken ?? '' }}" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                Check if Blood Sugar Symptoms are present
                            </td>
                            <td style="border: 1px solid #000; padding: 10px;">
                                <input type="checkbox" name="rs_bloodSugar_symptoms[]" value="symptom1" 
                                    {{ in_array('polyphagia', explode(', ', $profile->riskForm->rs_bloodSugar_symptoms ?? '')) ? 'checked' : '' }}> Polyphagia 
                        
                                <input type="checkbox" name="rs_bloodSugar_symptoms[]" value="symptom2" 
                                    {{ in_array('polydipsia', explode(', ', $profile->riskForm->rs_bloodSugar_symptoms ?? '')) ? 'checked' : '' }}> Polydipsia
                        
                                <input type="checkbox" name="rs_bloodSugar_symptoms[]" value="symptom3" 
                                    {{ in_array('polyuria', explode(', ', $profile->riskForm->rs_bloodSugar_symptoms ?? '')) ? 'checked' : '' }}> polyuria
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                Lipid Profile
                            </td>
                            <td style="border: 1px solid #000; padding: 10px;">
                                <div style="margin-bottom: 10px;">
                                    <label>Total Cholesterol:</label>
                                    <input type="text" name="lipid_cholesterol" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_lipid_cholesterol ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>HDL:</label>
                                    <input type="text" name="lipid_hdl" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_lipid_hdl ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>LDL:</label>
                                    <input type="text" name="lipid_ldl" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_lipid_ldl ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>VLDL:</label>
                                    <input type="text" name="lipid_vldl" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_lipid_vldl ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>Triglyceride:</label>
                                    <input type="text" name="lipid_triglyceride" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_lipid_triglyceride ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>Date Taken:</label>
                                    <input type="date" name="lipid_date_taken"  style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_lipid_date_taken ?? '' }}" readonly>
                                </div>
                            </td>
                        </tr>
                       
                        <tr>
                            <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                Urinalysis/ Urine Dipstick Test
                            </td>
                            <td style="border: 1px solid #000; padding: 10px;">
                                <div style="margin-bottom: 10px;">
                                    <label>Protein:</label>
                                    <input type="text" name="uri_protein" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_urine_protein ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>Date Taken:</label>
                                    <input type="date" name="uri_protein_date_taken"  style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_urine_protein_date_taken ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>Ketones:</label>
                                    <input type="text" name="uri_ketones" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_urine_ketones ?? '' }}" readonly>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <label>Date Taken:</label>
                                    <input type="date" name="uri_ketones_date_taken" style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="{{ $profile->riskForm->rs_urine_ketones_date_taken ?? '' }}" readonly>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th colspan="2" style="border: 1px solid #000; padding: 10px; background-color: #f2f2f2;">
                                6.2 Chronic Respiratory Disease (Asthma and COPD)
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                CHECK all applicable
                            </td>
                            <td style="border: 1px solid #000; padding: 10px; ">
                                <div class="checkbox-group" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <label style="margin-right: 20px;">
                                        <input type="checkbox" name="symptom_breathlessness"  
                                        {{ in_array('Breathlessness', explode(', ', $profile->riskForm->rs_Chronic_Respiratory_Disease ?? '')) ? 'checked' : '' }}> Breathlessness (or a 'need for air')
                                    </label>
                                    <label style="margin-right: 20px;">
                                        <input type="checkbox" name="symptom_sputum_production" 
                                        {{ in_array('Sputum (mucous) production', explode(', ', $profile->riskForm->rs_Chronic_Respiratory_Disease ?? '')) ? 'checked' : '' }}> Sputum (mucous) production
                                    </label>
                                    <label style="margin-right: 20px;">
                                        <input type="checkbox" name="symptom_chronic_cough" 
                                        {{ in_array('Chronic cough', explode(', ', $profile->riskForm->rs_Chronic_Respiratory_Disease ?? '')) ? 'checked' : '' }}> Chronic cough
                                    </label>
                                    <label style="margin-right: 20px;">
                                        <input type="checkbox" name="symptom_chest_tightness" 
                                        {{ in_array('Chest tightness', explode(', ', $profile->riskForm->rs_Chronic_Respiratory_Disease ?? '')) ? 'checked' : '' }}> Chest tightness
                                    </label>
                                    <label style="margin-right: 20px;">
                                        <input type="checkbox" name="symptom_wheezing" 
                                        {{ in_array('Wheezing', explode(', ', $profile->riskForm->rs_Chronic_Respiratory_Disease     ?? '')) ? 'checked' : '' }}> Wheezing
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                If YES to any of the symptoms, obtain peak expiratory flow rate (PEFR).
                                <br> Give inhaled salbutamol, then repeat after 15 minutes.
                            </td>
                            <td style="border: 1px solid #000; padding: 10px;">
                                <div class="checkbox-group" style="display: flex; flex-direction: column; gap: 5px;">
                                    <label>
                                        <input type="checkbox" name="pefr_above_20_percent" 
                                        {{ in_array('20% change from baseline (consider Probable Asthma)', explode(', ', $profile->riskForm->rs_if_yes_any_symptoms     ?? '')) ? 'checked' : '' }}> &gt; 20% change from baseline (consider Probable Asthma)
                                    </label>
                                    <label>
                                        <input type="checkbox" name="pefr_below_20_percent" 
                                        {{ in_array('20% change from baseline (consider Probable COPD)', explode(', ', $profile->riskForm->rs_if_yes_any_symptoms     ?? '')) ? 'checked' : '' }}> &lt; 20% change from baseline (consider Probable COPD)
                                    </label>
                                </div>
                            </td>
                        </tr>
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
                            <td style="font-weight: bold; padding: 10px;">Medications</td>
                            <td>
                                <!-- Anti-Hypertensives -->
                                <div style="margin: 10px;">
                                    <label style="font-weight: bold;">a. Anti-Hypertensives:</label>
                                    <div style="display: flex; gap: 10px; margin-top: 5px;">
                                        @foreach (['Yes', 'No', 'Unknown'] as $option)
                                            <label>
                                                <input type="radio" name="anti_hypertensives" value="{{ strtolower($option) }}" 
                                                    {{ $profile->riskForm->mngm_med_hypertension === strtolower($option) ? 'checked' : '' }}> {{ $option }}
                                            </label>
                                        @endforeach
                                    </div>
        
                                    <div id="antiHypertensivesOptions" style="display: {{ $profile->riskForm->mngm_med_hypertension === 'yes' ? 'block' : 'none' }}">
                                        <input type="text" name="anti_hypertensives_specify" value="{{ $profile->riskForm->mngm_med_hypertension_specify }}" 
                                            placeholder="Specify medicine" 
                                            style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" 
                                            readonly>
                                    </div>
                                </div>
        
                                <!-- Anti-Diabetes Section -->
                                <div style="margin: 10px;">
                                    <label style="font-weight: bold;">b. Anti-Diabetes:</label>
                                    <div style="display: flex; gap: 10px; margin-top: 5px;">
                                        @foreach (['Yes', 'No', 'Unknown'] as $option)
                                            <label>
                                                <input type="radio" name="anti_diabetes" value="{{ strtolower($option) }}" 
                                                    {{ $profile->riskForm->mngm_med_diabetes === strtolower($option) ? 'checked' : '' }}> {{ $option }}
                                            </label>
                                        @endforeach
                                    </div>
        
                                    <div id="antiDiabetesOptions" style="display: {{ $profile->riskForm->mngm_med_diabetes === 'yes' ? 'block' : 'none' }}">
                                        <div style="display: flex; gap: 10px; margin-top: 5px;">
                                            @foreach (['Oral Hypoglycemic', 'Insulin', 'Not Known', 'Others'] as $subOption)
                                            <label>
                                                @php
                                                    // Clean and prepare both the option and the stored value for comparison
                                                    $optionValue = strtolower(str_replace(' ', '_', $subOption));
                                                    $storedValue = strtolower(str_replace(' ', '_', $profile->riskForm->mngm_med_diabetes_options));
                                                @endphp
                                                <input type="radio" name="anti_diabetes_type" value="{{ $optionValue }}" 
                                                    {{ $storedValue === $optionValue ? 'checked' : '' }}> {{ $subOption }}
                                            </label>
                                        @endforeach
                                        
                                        </div>
        
                                        <input type="text" name="anti_diabetes_specify" value="{{ $profile->riskForm->mngm_med_diabetes_specify }}" 
                                            placeholder="Specify medicine" 
                                            style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                            readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>
        
                        <!-- Date of Follow-up Section -->
                        <tr>
                            <td style="font-weight: bold; padding: 10px;">Date of Follow-up</td>
                            <td>
                                <input type="date" name="follow_up_date" value="{{ $profile->riskForm->mngm_date_follow_up }}" 
                                    style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 8px;" readonly>
                            </td>
                        </tr>
        
                        <!-- Remarks Section -->
                        <tr>
                            <td style="font-weight: bold; padding: 10px;">Remarks</td>
                            <td>
                                <textarea name="remarks" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" readonly>{{ $profile->riskForm->mngm_remarks }} </textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>

                    </table>
                    </div>
                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                            <button type="button" class="btn btn-primary mx-2" onclick="showPreviousStep()">Previous</button>
                            {{-- <button type="submit" class="btn btn-success mx-2">Submit</button> --}}
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>

<script language="javascript" type="text/javascript">



document.addEventListener('DOMContentLoaded', function() {
        const dobField = document.getElementById('dob');
        if (dobField.value) {
            $(dobField).trigger('change');
        }
    });

    // controls the anti-hypertensive options
    const toggleAntiHypertensivesOptions = () => {
        const antiHypertensivesRadios = document.getElementsByName('anti_hypertensives');
        const antiHypertensivesSelected = Array.from(antiHypertensivesRadios).find(radio => radio.checked);

        const antiHypertensivesOptionsDiv = document.getElementById('antiHypertensivesOptions');

        if (antiHypertensivesSelected && (antiHypertensivesSelected.value === 'yes' || antiHypertensivesSelected.value === 'unknown')) {
            antiHypertensivesOptionsDiv.style.display = 'block';
        } else {
            antiHypertensivesOptionsDiv.style.display = 'none';
        }
    }

    function toggleCheckbox2(selected) {
        if (selected === 'yes') {
            document.getElementById('indigenous_person_no').checked = false;
        } else if (selected === 'no') {
            document.getElementById('indigenous_person_yes').checked = false;
        } else if (sellected === 'yes'){
            document.getElementById('indigenous_person_no').checked = false;
        }
        
    }

    function toggleCheckbox(selectedId, oppositeId) {
    const selectedCheckbox = document.getElementById(selectedId);
    const oppositeCheckbox = document.getElementById(oppositeId);
    
    if (selectedCheckbox.checked) {
        oppositeCheckbox.checked = false;
    }
}


    function toggleEmploymentStatus(selectedStatus) 
    {
        document.getElementById('employment_status_employed').checked = (selectedStatus === 'employed');
        document.getElementById('employment_status_unemployed').checked = (selectedStatus === 'unemployed');
        document.getElementById('employment_status_self_employed').checked = (selectedStatus === 'self-employed');
    }


    // controls the anti-diabetic options
    const toggleAntiDiabetesOptions = () => {
        const antiDiabetesRadios = document.getElementsByName('anti_diabetes');
        const antiDiabetesSelected = Array.from(antiDiabetesRadios).find(radio => radio.checked);

        const antiDiabetesOptionsDiv = document.getElementById('antiDiabetesOptions');

        if (antiDiabetesSelected && (antiDiabetesSelected.value === 'yes' || antiDiabetesSelected.value === 'unknown')) {
            antiDiabetesOptionsDiv.style.display = 'block';
        } else {
            antiDiabetesOptionsDiv.style.display = 'none';
        }
    }

    // controls the other religion field
	const showOtherReligionField = () => {
    	let religionSelect = document.getElementById("religion");
    	let otherReligionDiv = document.getElementById("other-religion-div");
    	if (religionSelect.value === "Others") {
     	   otherReligionDiv.style.display = "block";
   	 	} 
		else {
  	      otherReligionDiv.style.display = "none";
   		}
	}

    // controls the other ethnicity field
    const showOtherEthnicityField = () => {
    	let ethnicitySelect = document.getElementById("ethnicity");
    	let otherEthnicityDiv = document.getElementById("other-ethnicity-div");
    	if (ethnicitySelect.value === "Others") {
     	   otherEthnicityDiv.style.display = "block";
   	 	} 
		else {
  	      otherEthnicityDiv.style.display = "none";
   		}
	}

    // Get all checkboxes with the name 'employment_status'
    const employmentStatusCheckboxes = document.querySelectorAll('input[name="employment_status"]');

    // controls the functionality for the employment checkbox
    employmentStatusCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            // When one checkbox is checked, uncheck all others
            employmentStatusCheckboxes.forEach((box) => {
                if (box !== this) box.checked = false;
            });
        });
    }); 

    // Toggle checkbox behavior (mutual exclusivity)
    const toggleCheckbox = (yesId, noId) => {
        document.getElementById(yesId).addEventListener('change', function () {
            if (this.checked) {
                document.getElementById(noId).checked = false;
            }
        });

        document.getElementById(noId).addEventListener('change', function () {
            if (this.checked) {
                document.getElementById(yesId).checked = false;
            }
        });
    }
    
    // Function to classify BMI result
    function bmiResultToStr(bmi) {
        let strVal = "";
        if (bmi < 18.5) {
            strVal = "Underweight";
        } else if (bmi < 24.9) {
            strVal = "Normal weight";
        } else if (bmi < 29.9) {
            strVal = "Overweight";
        } else if (bmi < 34.9) {
            strVal = "Obesity class 1";
        } else if (bmi < 39.9) {
            strVal = "Obesity class 2";
        } else if (bmi >= 40) {
            strVal = "Obesity class 3";
        } else {
            strVal = "Error...";
        }
        return strVal;
    }

    // BMI calculation function
    function calculateBMI() {
        let weight = parseFloat(document.getElementById('weight').value);
        let height = parseFloat(document.getElementById('height').value);

        if (weight > 0 && height > 0) {
            let heightInMeters = height / 100;
            let bmi = weight / (heightInMeters * heightInMeters);
            
            // Set BMI values in the UI
            document.getElementById('BMI').value = bmi.toFixed(2);
            document.getElementById('bmiStrVal').textContent = bmiResultToStr(bmi);
        } else {
            document.getElementById('BMI').value = "";
            document.getElementById('bmiStrVal').textContent = "";
        }
    }

    // Initialize checkbox toggling for each condition
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle checkboxes for all conditions
        toggleCheckbox('pm_hypertensionYes', 'pm_hypertensionNo');
        toggleCheckbox('pm_heartsdiseaseYes', 'pm_heartdiseaseNo');
        toggleCheckbox('pm_diabetesYes', 'pm_diabetesNo');
        toggleCheckbox('pm_cancerYes', 'pm_cancerNo');
        toggleCheckbox('pm_codYes', 'pm_codNo');
        toggleCheckbox('pm_asthmaYes', 'pm_asthmaNo');
        toggleCheckbox('pm_allergiesYes', 'pm_allergiesNo');
        toggleCheckbox('pm_mnsYes', 'pm_mnsNo');
        toggleCheckbox('pm_visionYes', 'pm_visionNo');
        toggleCheckbox('pm_surgicalhistoryYes', 'pm_surgicalhistoryNo');
        toggleCheckbox('pm_thyroidYes', 'pm_thyroidNo');
        toggleCheckbox('pm_kidneyYes', 'pm_kidneyNo');

        //family history
        toggleCheckbox('fh_hyperYes', 'fh_hyperNo');
        toggleCheckbox('fh_strokeYes', 'fh_strokeNo');
        toggleCheckbox('fh_heartdisYes', 'fh_heartdisNo');
        toggleCheckbox('fh_diabetesmelYes', 'fh_diabetesmelNo');
        toggleCheckbox('fh_asthmaYes', 'fh_asthmaNo');
        toggleCheckbox('fh_cancer_Yes', 'fh_cancer_No');
        toggleCheckbox('fh_kidney_diYes', 'fh_kidney_disNo');
        toggleCheckbox('fh_degreerelativeYes', 'fh_degreerelativeNo');
        toggleCheckbox('fh_familytbYes', 'fh_familytbNo');
        toggleCheckbox('fh_mnsadYes', 'fh_mnsadNo');
        toggleCheckbox('fh_COPYes', 'fh_COPNo');

        //NCD RISK FACTORS
        toggleCheckbox('alcoholYes', 'alcoholNever');
        toggleCheckbox('physicalYes', 'physicalNo');
        toggleCheckbox('nutritionDietYes', 'nutritionDietNo');

        // Show/hide additional inputs based on checkbox state
        const additionalInputs = document.querySelector('.additional-inputs');
        additionalInputs.style.display = 'none';  // Hide by default

        const healthCheckboxes = document.querySelectorAll('.healthCheckbox');
        healthCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const anyChecked = Array.from(healthCheckboxes).some(cb => cb.checked && cb.id.endsWith('Yes'));
                additionalInputs.style.display = anyChecked ? 'block' : 'none';
            });
        });
        // const tobaccoCheckboxes = document.querySelectorAll('.tobaccoCheckbox');
        // tobaccoCheckboxes.forEach(checkbox => {
        //     checkbox.addEventListener('change', function() {
        //         const checkedCheckboxes = Array.from(tobaccoCheckboxes).filter(cb => cb.checked);
                
        //         if (checkedCheckboxes.length >= 2) {
        //             // Disable all unchecked checkboxes if two are checked
        //             tobaccoCheckboxes.forEach(cb => {
        //                 if (!cb.checked) {
        //                     cb.disabled = true;
        //                 }
        //             });
        //         } else {
        //             // Re-enable all checkboxes if fewer than two are checked
        //             tobaccoCheckboxes.forEach(cb => cb.disabled = false);
        //         }
        //     });
        // });
        const alcoholYes = document.getElementById('alcoholYes');
        const alcoholNo = document.getElementById('alcoholNever');
        const bingeLabel = document.getElementById('bingeLabel');

        // Check initial state
        bingeLabel.style.opacity = alcoholYes.checked ? '1' : '0.5';

        // Event listener to toggle opacity
        alcoholYes.addEventListener('change', function() {
            if (alcoholYes.checked) {
                bingeLabel.style.opacity = '1';  // Full opacity when "Yes, drinks alcohol" is checked
            } else {
                bingeLabel.style.opacity = '0.5';  // Translucent when unchecked
                document.getElementById('alcoholBinge').checked = false; // Uncheck binge question
            }
        });
        // Event listener for "No" option to toggle opacity and uncheck binge question
        alcoholNo.addEventListener('change', function() {
            if (alcoholNo.checked) {
                bingeLabel.style.opacity = '0.5';  // Translucent when "No" is checked
                document.getElementById('alcoholBinge').checked = false; // Uncheck binge question
            }
        });

        // checkbox.addEventListener('change', function() {
        //     const checkedBoxes = document.querySelectorAll('.tobaccoCheckbox:checked');
        //     if (checkedBoxes.length > 2) {
        //         this.checked = false;
        //         alert("You can select a maximum of 2 options.");
        //     }
        // });

        document.querySelectorAll('.tobaccoCheckbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const neverUsed = document.getElementById('q1'); // Option 1
                const secondhandExposure = document.getElementById('q2'); // Option 2
                const formerUser = document.getElementById('q3'); // Option 3
                const currentUser = document.getElementById('q4'); // Option 4

                if (this.checked) {
                    // If "Never Used" is selected, uncheck "Former User" and "Current User"
                    if (this === neverUsed) {
                        formerUser.checked = false;
                        currentUser.checked = false;
                    }
                    // If "Former User" is selected, uncheck "Never Used" and "Current User"
                    else if (this === formerUser) {
                        neverUsed.checked = false;
                        currentUser.checked = false;
                    }
                    // If "Current User" is selected, uncheck "Never Used" and "Former User"
                    else if (this === currentUser) {
                        neverUsed.checked = false;
                        formerUser.checked = false;
                    }
                }
            });
        });
    });

    // Function to toggle "No" checkboxes for all conditions
    function checkAllNo() {
        const noCheckboxes = document.querySelectorAll('input[type="checkbox"][value="No"]');
        const allChecked = Array.from(noCheckboxes).every(checkbox => checkbox.checked);

        // Toggle the state of all "No" checkboxes
        noCheckboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });

        // Hide additional inputs if all "No" are checked
        const additionalInputs = document.querySelector('.additional-inputs');
        additionalInputs.style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
    // Handle multiple checkboxes and their corresponding input fields
    const conditions = [
        { checkboxId: 'cancerYes', detailsInputId: 'cancerDetailsInput' },
        { checkboxId: 'allergiesYes', detailsInputId: 'allergiesDetailsInput' },
        { checkboxId: 'mnsYes', detailsInputId: 'mnsDetailsInput' },
        { checkboxId: 'diabetesYes', detailsInputId: 'diabetesDetailsInput' },
        { checkboxId: 'surgicalhistoryYes', detailsInputId: 'surgicalDetailsInput' }
    ];

    conditions.forEach(condition => {
        const checkbox = document.getElementById(condition.checkboxId);
        const detailsInput = document.getElementById(condition.detailsInputId);

        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                detailsInput.style.display = 'block';  // Show the text box
            } else {
                detailsInput.style.display = 'none';  // Hide the text box
            }
        });
    });
});
    
    // Lobibox notifications
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            Lobibox.notify('success', {
                title: 'Success',
                msg: "{{ session('success') }}",
                rounded: true,
                delay: 5000
            });
        @endif

        @if (session('error'))
            Lobibox.notify('error', {
                title: 'Error',
                msg: "{{ session('error') }}",
                rounded: true,
                delay: 5000
            });
        @endif
    });
</script>
@endsection
