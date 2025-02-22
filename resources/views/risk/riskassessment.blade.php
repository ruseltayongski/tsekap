@extends('resu/app1')
@section('content')
    <!-- @include('risk/riskSidebar') -->
    @include('risk.risk_check_profile.riskCheckProfile')

    <?php
        use App\Facilities;
        use App\Province;
        use App\Muncity;
        use App\UserHealthFacility;
        use Illuminate\Support\Facades\Auth;
        
        $user = Auth::user();
        
        // Retrieve the user health facility mapping
        $userHealthFacilityMapping = UserHealthFacility::where('user_id', $user->id)->first();
        
        // Fetch the facility details based on the mapping
        $facility = null;
        if ($userHealthFacilityMapping) {
            $facility = Facilities::select('id', 'name', 'address', 'hospital_type')
                ->where('id', $userHealthFacilityMapping->facility_id)
                ->first();
        }

        $muncities = Muncity::select('id', 'description')->get();
        $province = Province::select('id', 'description')->get();
    ?>
    
    <div class="col-md-12 wrapper"
        style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class="col-md-8 wrapper" style="padding-bottom: 5%">
            <div class="alert alert-jim">
                <h2 class="page-header" style="text-align: center">
                    <i class="fa fa-user"></i>&nbsp; PHILPEN RISK ASSESSMENT FORM (REVISED 2022)
                    <br>
                    <p style="font-size: 15pt; font-style: italic; text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adults >
                        20 years old</p>
                </h2>
                <div class="page-divider"></div>
                <!-- <form class="form-horizontal form-submit" id="form-submit" method="POST" action="{{ route('submit-patient-risk-form') }}"> -->
                <form class="form-horizontal form-submit" id="form-submit" method="POST"
                    action="{{ route('submit-patient-risk-form') }}">
                    {{ csrf_field() }}
                    <div class="form-step" id="form-step-1">
                        <div class="row">
                            <div class="col-md-12 col-divider">
                                <!-- <h4 class="patient-font" style="background-color: #727DAB;color: white;padding: 3px;margin-top: -28px; ">Patient Informations</h4> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="facility-name">Name of Health Facility</label>
                                        <input type="text" class="form-control" name="facilityname" id="facility"
                                            readonly
                                            value="{{ $facility ? $facility->name : 'N/A' }}">
                                        <input type="hidden" name="facility_id_updated" id="facility_id_updated"
                                            value="{{ $facility ? $facility->id : 'N/A' }}">
                                        <input type="hidden" name="encoded_by" id="encoded_by"
                                            value="{{ $user ? $user->id : 0 }}">
                                    </div>
                                    @php
                                        use Carbon\Carbon;
                                    @endphp
                                    <!-- <label for="address-facility">Date of Assessment</label>
                                    <input type="text" class="form-control" name="addressfacility" id="addressfacility" readonly value="{{ $facility->address }}"> -->
                                    <div class="col-md-6">
                                        <label for="date-of-assessment">Date of Assessment</label>
                                        <input type="text" class="form-control" name="date_of_assessment"
                                            id="date-of-assessment" readonly value="{{ Carbon::now()->format('F d, Y') }}">
                                    </div>
                                    <br><br>
                                    <br><br>
                                </div>
                                <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 2px;">I.
                                    PATIENT'S INFORMATION</h4>
                                <div class="row">
                                    <input type="hidden" name="profile_id" id="profile_id">
                                    <div class="col-md-3">
                                        <label for="lname">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="lname" maxlength="25"
                                            id="lname" value="" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fname">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="fname" maxlength="25"
                                            id="fname" value="" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="mname">Middle Name </label>
                                        <input type="text" class="form-control" name="mname" maxlength="25"
                                            id="mname" value="" required>
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
                                            <option value="VI">VI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="sex">Sex <span class="text-danger">*</span></label>
                                        <select class="form-control" name="sex" id="sex" required>
                                            <option value="">Select sex</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="dateofbirth">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dateofbirth" name="dateofbirth"
                                            required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="age">Age <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="age" name="age"
                                            value="" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="civil_status">Civil Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="civil_status" id="civil_status" required>
                                            <option value="">Select status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Legally Separated">Legally Separated</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="religion">Religion <span class="text-danger">*</span></label>
                                        <select class="form-control " name="religion" id="religion"
                                            onchange="showOtherReligionField()" required>
                                            <option value="">Select Religion</option>
                                            <option value="Roman Catholic">Roman Catholic</option>
                                            <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                                            <option value="Evangelical">Evangelical</option>
                                            <option value="Born Again">Born Again</option>
                                            <option value="Jehovah’s Witnesses">Jehovah’s Witnesses</option>
                                            <option value="Seventh-day Adventist">Seventh-day Adventist</option>
                                            <option value="Bible Baptist Church">Bible Baptist Church</option>
                                            <option value="Assemblies of God">Assemblies of God</option>
                                            <option value="Church of Christ">Church of Christ</option>
                                            <option value="Iglesia Filipina Independiente">Iglesia Filipina Independiente/Aglipayan</option>
                                            <option value="Methodist">Methodist</option>
                                            <option value="Latter-Day Saints">Latter-Day Saints</option>
                                            <option value="Kingdom of Jesus Christ">Kingdom of Jesus Christ</option>
                                            <option value="UCCP">United Church of Christ in The Philippines</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Buddhism">Buddhism</option>
                                            <option value="Hinduism">Hinduism</option>
                                            <option value="Judaism">Judaism</option>
                                            <option value="Jainism">Jainism</option>
                                            <option value="Baha'i">Baha'i</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>

                                    <!-- This div will only appear if "Others" is selected -->
                                    <div class="col-md-3" id="other-religion-div" style="display:none;">
                                        <label for="other_religion">Specify Other Religion <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="other_religion"
                                            id="other_religion" maxlength="50" placeholder="Please specify" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="contact">Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="contact" id="contact"
                                            maxlength="11">
                                    </div>
                                    <div class="row"></div>
                                    <div class="col-md-4">
                                        <label for="province">Province/HUC <span class="text-danger">*</span></label>
                                        <select class="form-control" name="province" id="province_risk" required>
                                            <option value="">Select Province</option>
                                            @foreach ($province as $prov)
                                                <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="municipal">Municipality/City <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="municipal" id="municipal" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="barangay">Barangay <span class="text-danger">*</span></label>
                                        <select class="form-control" name="barangay" id="barangay" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="street">Street</label>
                                        <input type="text" class="form-control" name="street" id="street"
                                            maxlength="25" value="">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="purok">Purok</label>
                                        <input type="text" class="form-control" name="purok" id="purok"
                                            maxlength="25" value="">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="sitio">Sitio</label>
                                        <input type="text" class="form-control" name="sitio" id="sitio"
                                            maxlength="25" value="">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="phic_id">PhilHealth No.</label>
                                        <input type="text" class="form-control" name="phic_id" id="phic_id"
                                            maxlength="12" value=""><br>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="pwd_id">Persons with Disability ID Card No. if applicable:</label>
                                        <input type="text" class="form-control" name="pwd_id" id="pwd_id"
                                            maxlength="13" value=""><br>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="citizenship">Citizenship</label>
                                        <select class="form-control" name="citizenship" id="citizenship"
                                            onchange="showOtherCitizenshipField()">
                                            <option value="">Select Citizenship</option>
                                            <option value="Filipino">Filipino</option>
                                            <option value="Chinese">Chinese</option>
                                            <option value="American">American</option>
                                            <option value="Japanese">Japanese</option>
                                            <option value="Korean">Korean</option>
                                            <option value="Indian">Indian</option>
                                            <option value="Australian">Australian</option>
                                            <option value="Canadian">Canadian</option>
                                            <option value="British">British</option>
                                            <option value="German">German</option>
                                            <option value="French">French</option>
                                            <option value="Spanish">Spanish</option>
                                            <option value="Singaporean">Singaporean</option>
                                            <option value="Taiwanese">Taiwanese</option>
                                            <option value="Saudi Arabian">Saudi Arabian</option>
                                            <option value="Kuwaiti">Kuwaiti</option>
                                            <option value="Qatari">Qatari</option>
                                            <option value="Emirati">Emirati</option>
                                            <option value="Omani">Omani</option>
                                            <option value="Swiss">Swiss</option>
                                            <option value="Irish">Irish</option>
                                            <option value="Mexican">Mexican</option>
                                            <option value="Italian">Italian</option>
                                            <option value="Russian">Russian</option>
                                            <option value="Brazilian">Brazilian</option>
                                            <option value="Argentinian">Argentinian</option>
                                            <option value="South African">South African</option>
                                            <option value="Egyptian">Egyptian</option>
                                            <option value="Thai">Thai</option>
                                            <option value="Vietnamese">Vietnamese</option>
                                            <option value="Indonesian">Indonesian</option>
                                            <option value="Malaysian">Malaysian</option>
                                            <option value="Pakistani">Pakistani</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>

                                    <!-- This div will only appear if "Others" is selected -->
                                    <div class="col-md-3" id="other-citizenship-div" style="display:none;">
                                        <label for="other_citizenship">Specify Other Citizenship <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="other_citizenship"
                                            id="other_citizenship" placeholder="Please specify citizenship" required>
                                    </div>

                                    <div class="col-md-3 d-flex align-items-center">
                                        <label for="indigenous_person" class="mr-2">Indigenous Person <span
                                                class="text-danger">*</span></label><br>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="indigenous_person" id="indigenous_person_yes"
                                                value="Yes"
                                                onclick="toggleCheckbox('indigenous_person_yes', 'indigenous_person_no')">
                                            <label for="indigenous_person_yes" class="ml-2">Yes</label>
                                        </span>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="indigenous_person" id="indigenous_person_no"
                                                value="No"
                                                onclick="toggleCheckbox('indigenous_person_no', 'indigenous_person_yes')">
                                            <label for="indigenous_person_no" class="ml-2">No</label>
                                        </span>
                                        <!--Shows if there is selected option or not-->
                                        <span style="padding-right: 10px;">
                                            <p id="no_selected_indigenous_person" style="font-weight: 300; color: red;"
                                                class="ml-2"></p>
                                        </span>
                                        <br />
                                    </div>

                                    <div class="row"></div>
                                    <br />
                                    <div class="col-md-6 d-flex align-items-center">
                                        <label for="employment_status" class="mr-2">Employment Status <span
                                                class="text-danger">*</span></label><br>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="employment_status"
                                                id="employment_status_employed" value="Employed">
                                            <label for="employment_status_employed" class="ml-2">Employed</label>
                                        </span>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="employment_status"
                                                id="employment_status_unemployed" value="Unemployed">
                                            <label for="employment_status_unemployed" class="ml-2">Unemployed</label>
                                        </span>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="employment_status"
                                                id="employment_status_self_employed" value="Self-employed">
                                            <label for="employment_status_self_employed"
                                                class="ml-2">Self-Employed</label>
                                        </span>
                                        <!--Shows if there is selected option or not-->
                                        <span style="padding-right: 10px;">
                                            <p id="no_selected_employment_status" style="font-weight: 300; color: red;"
                                                class="ml-2"></p>
                                        </span>
                                        <br>
                                    </div>
                                </div>
                                <br /><br />
                            </div>
                            <div class="col-md-12">
                                <div>
                                    <h4 class="patient-font mt-4"
                                        style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">II.
                                        ASSESS FOR RED FLAGS</h4>
                                    <p style="font-style: italic; font-size: 15px;">
                                        If YES to ANY, REFER IMMEDIATELY to a Physician for further management and/or
                                        referral to the next level of care. If ALL answers are NO, proceed to Part III.
                                    </p>
                                </div>
                                <div style="display: flex; justify-content: end">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="checkAllNo()">Check
                                        All No</button>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-12" style="display: flex; align-items: center; ">
                                <table class="table table-bordered">
                                    <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                        <tr>
                                            <td>2.1 Chest Pain</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="chest_pain_yes"
                                                    name="ar_chest_pain" value="Yes"
                                                    onclick="toggleCheckbox('chest_pain_yes', 'chest_pain_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="chest_pain_no"
                                                    name="ar_chest_pain" value="No"
                                                    onclick="toggleCheckbox('chest_pain_no', 'chest_pain_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.2 Difficulty of Breathing</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox"
                                                    id="difficulty_breathing_yes" name="ar_difficulty_breathing"
                                                    value="Yes"
                                                    onclick="toggleCheckbox('difficulty_breathing_yes', 'difficulty_breathing_no')">
                                                Yes
                                                <input type="checkbox" class="healthCheckbox"
                                                    id="difficulty_breathing_no" name="ar_difficulty_breathing"
                                                    value="No"
                                                    onclick="toggleCheckbox('difficulty_breathing_no', 'difficulty_breathing_yes')">
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.3 Loss of Consciousness</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="loss_con_yes"
                                                    name="ar_loss_of_consciousness" value="Yes"
                                                    onclick="toggleCheckbox('loss_con_yes', 'loss_con_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="loss_con_no"
                                                    name="ar_loss_of_consciousness" value="No"
                                                    onclick="toggleCheckbox('loss_con_no', 'loss_con_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.4 Slurred Speech</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="slurred_yes"
                                                    name ="ar_slurred_speech" value="Yes"
                                                    onclick="toggleCheckbox('slurred_yes', 'slurred_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="slurred_no"
                                                    name ="ar_slurred_speech" value="No"
                                                    onclick="toggleCheckbox('slurred_no', 'slurred_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.5 Facial Asymmetry</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="facial_yes"
                                                    name= "ar_facial_asymmetry" value="Yes"
                                                    onclick="toggleCheckbox('facial_yes', 'facial_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="facial_no"
                                                    name= "ar_facial_asymmetry" value="No"
                                                    onclick="toggleCheckbox('facial_no', 'facial_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.6 Weakness/Numbness on arm <br> of the left on one side of the body</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="weak_numb_yes"
                                                    name="ar_weakness_numbness" value="Yes"
                                                    onclick="toggleCheckbox('weak_numb_yes', 'weak_numb_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="weak_numb_no"
                                                    name="ar_weakness_numbness" value="No"
                                                    onclick="toggleCheckbox('weak_numb_no', 'weak_numb_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.7 Disoriented as to time, <br> place and person</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="disoriented_yes"
                                                    name="ar_disoriented" value="Yes"
                                                    onclick="toggleCheckbox('disoriented_yes', 'disoriented_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="disoriented_no"
                                                    name="ar_disoriented" value="No"
                                                    onclick="toggleCheckbox('disoriented_no', 'disoriented_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.8 Chest Retractions</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="chest_retract_yes"
                                                    name="ar_chest_retractions" value="Yes"
                                                    onclick="toggleCheckbox('chest_retract_yes', 'chest_retract_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="chest_retract_no"
                                                    name="ar_chest_retractions" value="No"
                                                    onclick="toggleCheckbox('chest_retract_no', 'chest_retract_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.9 Seizure or Convulsion</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="seizure_yes"
                                                    name="ar_seizure_convulsion" value="Yes"
                                                    onclick="toggleCheckbox('seizure_yes', 'seizure_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="seizure_no"
                                                    name="ar_seizure_convulsion" value="No"
                                                    onclick="toggleCheckbox('seizure_no', 'seizure_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.10 Act of self-harm or suicide</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="self_harm_yes"
                                                    name="ar_act_self_harm_suicide" value="Yes"
                                                    onclick="toggleCheckbox('self_harm_yes', 'self_harm_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="self_harm_no"
                                                    name="ar_act_self_harm_suicide" value="No"
                                                    onclick="toggleCheckbox('self_harm_no', 'self_harm_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.11 Agitated and/or aggressive behavior</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="agitated_yes"
                                                    name="ar_agitated_behavior" value="Yes"
                                                    onclick="toggleCheckbox('agitated_yes', 'agitated_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="agitated_no"
                                                    name="ar_agitated_behavior" value="No"
                                                    onclick="toggleCheckbox('agitated_no', 'agitated_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.12 Eye Injury/ Foreign Body on the eye</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="eye_injury_yes"
                                                    name="ar_eye_injury" value="Yes"
                                                    onclick="toggleCheckbox('eye_injury_yes', 'eye_injury_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="eye_injury_no"
                                                    name="ar_eye_injury" value="No"
                                                    onclick="toggleCheckbox('eye_injury_no', 'eye_injury_yes')"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.13 Severe Injuries</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="severe_yes"
                                                    value="Yes" name="ar_severe_injuries"
                                                    onclick="toggleCheckbox('severe_yes', 'severe_no')"> Yes
                                                <input type="checkbox" class="healthCheckbox" id="severe_no"
                                                    value="No" name="ar_severe_injuries"
                                                    onclick="toggleCheckbox('severe_no', 'severe_yes')"> No
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="error-message" style="color: red; display: none;">Please fill out all required fields.
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <!-- <button type="button" class="btn btn-primary mx-2" >Next</button> -->
                                <button type="button" id="first-page-button" class="btn btn-primary mx-2"
                                    onclick="validateStep1()">Next</button>
                            </div>
                        </div>
                    </div>

                    <!-- # STEP 2 # -->
                    <div class="form-step" id="form-step-2" style="display: none;">
                        <div class="row">
                            <!-- PAST MEDICAL HISTORY -->
                            <div class="col-md-12">
                                <div>
                                    <h4 class="patient-font mt-4"
                                        style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">III.
                                        PAST MEDICAL HISTORY</h4>
                                </div>
                            </div>
                            <div class="col-md-12" style="display: flex; align-items: center;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                        <tr>
                                            <td>3.1 Hypertension</td>
                                            <td>
                                                <input type="checkbox" class="hypertensionCheckbox"
                                                    id="pmh_hypertension_yes" name="pmh_hypertension" value="Yes"> Yes
                                                <input type="checkbox" class="hypertensionCheckbox"
                                                    id="pmh_hypertension_no" name="pmh_hypertension" value="No"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.2 Heart Disease</td>
                                            <td>
                                                <input type="checkbox" class="heartdiseaseCheckbox"
                                                    id="pmh_heart_disease_yes" name="pmh_heart_disease" value="Yes">
                                                Yes
                                                <input type="checkbox" class="heartdiseaseCheckbox"
                                                    id="pmh_heart_disease_no" name="pmh_heart_disease" value="No"
                                                    style="margin-left: flex"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.3 Diabetes</td>
                                            <td>
                                                <input type="checkbox" class="diabetesCheckbox" id="pmh_diabetes_yes"
                                                    name="pmh_diabetes" value="Yes"> Yes
                                                <input type="checkbox" class="diabetesCheckbox" id="pmh_diabetes_no"
                                                    name="pmh_diabetes" value="No" style="margin-left: flex"> No
                                                <br />
                                                <textarea class="col-md-12" id="diabetesDetailsInput" style="display:none;" name="pmh_diabetes_details"
                                                    placeholder="Please provide"></textarea>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.4 Cancer</td>
                                            <td>
                                                <input type="checkbox" class="cancerCheckbox" id="pmh_cancer_yes"
                                                    name= "pmh_cancer" value="Yes"> Yes
                                                <input type="checkbox" class="cancerCheckbox" id="pmh_cancer_no"
                                                    name= "pmh_cancer" value="No" style="margin-left: flex"> No
                                                <br />
                                                <textarea class="col-md-12" id="cancerDetailsInput" style="display:none;" name="pmh_cancer_details"
                                                    placeholder="Please provide"></textarea>
                                            </td>
                                        </tr>
                                        </tr>

                                        <tr>
                                            <td>3.5 COPD</td>
                                            <td>
                                                <input type="checkbox" class="codCheckbox" id="pmh_copd_yes"
                                                    name="pmh_COPD" value="Yes"> Yes
                                                <input type="checkbox" class="codCheckbox" id="pmh_copd_no"
                                                    name="pmh_COPD" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.6 Asthma</td>
                                            <td>
                                                <input type="checkbox" class="asthmaCheckbox" id="pmh_asthma_yes"
                                                    name="pmh_asthma" value="Yes"> Yes
                                                <input type="checkbox" class="asthmaCheckbox" id="pmh_asthma_no"
                                                    name="pmh_asthma" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td> 3.7 Allergies</td>
                                            <td>
                                                <input type="checkbox" class="allergiesCheckbox" id="pmh_allergies_yes"
                                                    name="pmh_allergies" value="Yes"> Yes
                                                <input type="checkbox" class="allergiesCheckbox" id="pmh_allergies_no"
                                                    name="pmh_allergies" value="No" style="margin-left: flex"> No
                                                <br />
                                                <textarea class="col-md-12" id="allergiesDetailsInput" style="display:none;" name="pmh_allergies_details"
                                                    placeholder="Please provide"></textarea>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.8 Mental, Neurological, and Substance-Abuse Disorder</td>
                                            <td>
                                                <input type="checkbox" class="mnsCheckbox" id="pmh_mns_yes"
                                                    name="pmh_mnsad" value="Yes"> Yes
                                                <input type="checkbox" class="mnsCheckbox" id="pmh_mns_no"
                                                    name="pmh_mnsad" value="No" style="margin-left: flex"> No
                                                <br />
                                                <textarea class="col-md-12" id="mnsDetailsInput" style="display:none;" name="pmh_mnsad_details"
                                                    placeholder="Please provide"></textarea>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.9 Vision Problems</td>
                                            <td>
                                                <input type="checkbox" class="visionCheckbox" id="pmh_vision_yes"
                                                    name= "pmh_vision" value="Yes"> Yes
                                                <input type="checkbox" class="visionCheckbox" id="pmh_vision_no"
                                                    name= "pmh_vision" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.10 Previous Surgical History</td>
                                            <td>
                                                <input type="checkbox" class="surgicalhistoryCheckbox"
                                                    id="pmh_surgical_history_yes" name= "pmh_psh" value="Yes"> Yes
                                                <input type="checkbox" class="surgicalhistoryCheckbox"
                                                    id="pmh_surgical_history_no" name= "pmh_psh" value="No"
                                                    style="margin-left: flex"> No
                                                <br />
                                                <textarea class="col-md-12" id="surgicalDetailsInput" style="display:none;" name="pmh_psh_details"
                                                    placeholder="Please provide"></textarea>

                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.11 Thyroid Disorders</td>
                                            <td>
                                                <input type="checkbox" class="thyroidCheckbox" id="pmh_thyroid_yes"
                                                    name="pmh_thyroid" value="Yes"> Yes
                                                <input type="checkbox" class="thyroidCheckbox" id="pmh_thyroid_no"
                                                    name="pmh_thyroid" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.12 Kidney Disorders</td>
                                            <td>
                                                <input type="checkbox" class="kidneyCheckbox" id="pmh_kidney_yes"
                                                    name="pmh_kidney" value="Yes"> Yes
                                                <input type="checkbox" class="kidneyCheckbox" id="pmh_kidney_no"
                                                    name="pmh_kidney" value="No" style="margin-left: flex"> No
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <div>
                                    <h4 class="patient-font mt-4"
                                        style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">IV.
                                        FAMILY HISTORY</h4>
                                </div>
                            </div>
                            <div class="col-md-12" style="display: flex; align-items: center;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                        <tr>
                                            <td>4.1 Hypertension</td>
                                            <td>
                                                <input type="checkbox" class="hyperCheckbox" id="fmh_hypertension_yes"
                                                    name="fmh_hypertension" value="Yes"> Yes
                                                <input type="checkbox" class="hyperCheckbox" id="fmh_hypertension_no"
                                                    name="fmh_hypertension" value="No"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.2 Stroke</td>
                                            <td>
                                                <input type="checkbox" class="strokeCheckbox" id="fmh_stroke_yes"
                                                    name="fmh_stroke" value="Yes"> Yes
                                                <input type="checkbox" class="strokeCheckbox" id="fmh_stroke_no"
                                                    name="fmh_stroke" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.3 Heart Disease (change from "Cardiovascular") </td>
                                            <td>
                                                <input type="checkbox" class="heartdisCheckbox"
                                                    id="fmh_heart_disease_yes" name="fmh_heart_disease" value="Yes">
                                                Yes
                                                <input type="checkbox" class="heartdisCheckbox" id="fmh_heart_disease_no"
                                                    name="fmh_heart_disease" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.4 Diabetes Mellitus</td>
                                            <td>
                                                <input type="checkbox" class="diabetesMelCheckbox"
                                                    id="fmh_diabetes_mel_yes" name="fmh_diabetes_mellitus"
                                                    value="Yes"> Yes
                                                <input type="checkbox" class="diabetesMelCheckbox"
                                                    id="fmh_diabetes_mel_no" name="fmh_diabetes_mellitus" value="No"
                                                    style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.5 Asthma</td>
                                            <td>
                                                <input type="checkbox" class="asthmasCheckbox" id="fmh_asthma_yes"
                                                    name="fmh_asthma" value="Yes"> Yes
                                                <input type="checkbox" class="asthmasCheckbox" id="fmh_asthma_no"
                                                    name="fmh_asthma" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.6 Cancer</td>
                                            <td>
                                                <input type="checkbox" class="cancerCheckbox" id="fmh_cancer_yes"
                                                    name="fmh_cancer" value="Yes"> Yes
                                                <input type="checkbox" class="cancerCheckbox" id="fmh_cancer_no"
                                                    name="fmh_cancer" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td> 4.7 Kidney Disease </td>
                                            <td>
                                                <input type="checkbox" class="kidneyDiseaseCheckbox"
                                                    id="fmh_kidney_disease_yes" name="fmh_kidney" value="Yes"> Yes
                                                <input type="checkbox" class="kidneyDiseaseCheckbox"
                                                    id="fmh_kidney_disease_no" name="fmh_kidney" value="No"
                                                    style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.8 1st Degree relative with premature coronary <br> disease or vascular
                                                disease <br> (includes "Heart Attack")</td>
                                            <td>
                                                <input type="checkbox" class="firstDegreeRelativeCheckbox"
                                                    id="fmh_degree_relative_yes" name="fmh_first_degree" value="Yes">
                                                Yes
                                                <input type="checkbox" class="firstDegreeRelativeCheckbox"
                                                    id="fmh_degree_relative_no" name="fmh_first_degree" value="No"
                                                    style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.9 Family having TB in the last 5 years </td>
                                            <td>
                                                <input type="checkbox" class="familyTbCheckbox" id="fmh_family_tb_yes"
                                                    name="fmh_famtb" value="Yes"> Yes
                                                <input type="checkbox" class="familyTbCheckbox" id="fmh_family_tb_no"
                                                    name="fmh_famtb" value="No" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.10 Mental, Neurological and Substance Abuse Disorder</td>
                                            <td>
                                                <input type="checkbox" class="mnsadCheckbox" id="fmh_mnsad_yes"
                                                    name="fmh_mnsad" value="Yes"> Yes
                                                <input type="checkbox" class="mnsadCheckbox" id="fmh_mnsad_no"
                                                    name="fmh_mnsad" value="No" style="margin-left: flex"> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4.11 COPD</td>
                                            <td>
                                                <input type="checkbox" class="COPCheckbox" id="fmh_copd_yes"
                                                    value="Yes" name="fmh_copd"> Yes
                                                <input type="checkbox" class="COPCheckbox" id="fmh_copd_no"
                                                    value="No" name="fmh_copd" style="margin-left: flex"> No
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="showPreviousStep()">Previous</button>
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="validateStep2()">Next</button>
                            </div>
                        </div>
                    </div>

                    <!-- # STEP 3 # -->
                    <div class="form-step" id="form-step-3" style="display: none;">
                        <div class="row">
                            <!-- risk factors -->
                            <div class="col-md-12">
                                <div>
                                    <h4 class="patient-font mt-4"
                                        style="background-color: #727DAB;color:white;padding: 3px;margin-top: -10px; ">V.
                                        NCD RISK FACTORS</h4>
                                </div>
                            </div>
                            <div class="col-md-12" style="display: flex; align-items: center;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                        <tr>
                                            <td><span id="tobacco-use-label">5.1 Tobacco Use</span></td>
                                            <td>
                                                <input type="checkbox" class="tobaccoCheckbox" id="q1"
                                                    name="tobaccoUse[]" value="q1"> Never Used (proceed to Q2) <br>
                                                <input type="checkbox" class="tobaccoCheckbox" id="q2"
                                                    name="tobaccoUse[]" value="q2"> Exposure to secondhand smoke <br>
                                                <input type="checkbox" class="tobaccoCheckbox" id="q3"
                                                    name="tobaccoUse[]" value="q3"> Former tobacco user (stopped
                                                smoking > 1 year) <br>
                                                <input type="checkbox" class="tobaccoCheckbox" id="q4"
                                                    name="tobaccoUse[]" value="q4"> Current tobacco user (currently
                                                smoking or stopped smoking) <br> <br>
                                                <p style="font-style: italic; font-size: 15px;">
                                                    If YES to Q2-Q4, follow the tobacco cessation protocol (5As) and use
                                                    Form 1. Tobacco Cessation Referral Protocol, if needed.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span id="alcohol-intake-label">5.2 Alcohol Intake</span></td>
                                            <td>
                                                <input type="checkbox" class="alcoholCheckbox" id="alcohol_never"
                                                    name="ncd_alcohol" value="No"> Never Consumed
                                                <input type="checkbox" class="alcoholCheckbox" id="alcohol_yes"
                                                    name="ncd_alcohol" value="Yes"> Yes, drinks alcohol

                                                <br><br>
                                                <label id="bingeLabel" style="opacity: 0.5;">
                                                    <input type="checkbox" class="alcoholCheckbox" id="alcohol_binge"
                                                        name="ncd_alcohol_binge" value="Yes">
                                                    Do you drink 5 or more standard drinks for men, and 4 or more for women
                                                    (in one sitting/occasion) in the past year?
                                                </label>
                                                <br><br>

                                                <p style="font-style: italic; font-size: 15px;">
                                                    If NO, congratulate the patient. The patient is at a lower risk of
                                                    drinking alcohol.<br>
                                                    If YES, proceed using AUDIT SCREENING TOOL (Form 2) to assess alcohol
                                                    consumption and alcohol problems.
                                                    If binge drinker, provide brief advice and/or extended brief advice. The
                                                    patient is on the higher risk category level of drinking or in harmful
                                                    use of alcohol.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span id="physical-activity-label">5.3 Physical Activity</span></td>
                                            <td>
                                                Does the patient do at least 2.5 hours a week of moderate-intensity physical
                                                activity? <br><br>
                                                <input type="checkbox" class="physicalCheckbox" id="physical_yes"
                                                    name="ncd_physical" value="Yes"> Yes
                                                <input type="checkbox" class="physicalCheckbox" id="physical_no"
                                                    name="ncd_physical" value="No" style="margin-left: flex"> No
                                                <br>

                                                <br>
                                                <p style="font-style: italic; font-size: 15px;">
                                                    If NO or patient does not reach the recommended hours/week of
                                                    moderate-intensity physical activity, give lifestyle modification advice
                                                    following Annex 1. Healthy Lifestyle Module.
                                                    <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span id="nutrition-and-dietary-assessment-label">5.4 Nutrition and Dietary
                                                    Assessment</span></td>
                                            <td>
                                                Does the patient eat high fat, high salt food,(processed/fast food such as
                                                instant <br> noodles, burgers, fries, dried fish),
                                                "ihaw-ihaw/fried" (e.g isaw, barbecue, liver, chicken skin)and high sugar
                                                food and drinks (e.g chocolates, cakes, pastries, softdrinks) weekly?
                                                <br><br><br>
                                                <input type="checkbox" class="nutritionDietCheckbox"
                                                    id="nutrition_diet_yes" name="ncd_nutrition" value="Yes"> Yes
                                                <input type="checkbox" class="nutritionDietCheckbox"
                                                    id="nutrition_diet_no" name="ncd_nutrition" value="No"
                                                    style="margin-left: flex"> No
                                                <br><br><br>
                                                <p style="font-style: italic; font-size: 15px;">
                                                    If YES to the question, give lifestyle modification advice following
                                                    Annex 2. Nutrition Practice Guidelines for Health Professionals in the
                                                    Primary Care Screening.
                                                    <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                5.5 Weight (kg)
                                            </td>
                                            <td>
                                                <input type="text" class="textbox" id="weight" value=""
                                                    name="rf_weight" oninput="calculateBMI()">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                5.6 Height (cm)
                                            </td>
                                            <td>
                                                <input type="text" class="textbox" id="height" value=""
                                                    name="rf_height" oninput="calculateBMI()">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                5.7 Body Mass Index (wt.[kgs]/ht[cm]x 10,000):
                                            </td>
                                            <td>
                                                <input type="text" class="textbox" id="bmi" value=""
                                                    name="rf_bmi" readonly>
                                                <p><i><span style="font-size: 13.5px; font-weight: 300; padding-left: 5px;"
                                                            id="bmiStrVal" value=""></span></i></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                5.8 Waist Circumference (cm): F < 80cm M < 90 </td>
                                            <td>
                                                <input type="text" class="textbox" id="waist" name ="rf_waist"
                                                    value="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="error-message-step-3" style="color: red; display: none;">Please fill out all required
                            fields.</div>
                        <div class="row">
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="showPreviousStep()">Previous</button>
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="validateStep3()">Next</button>
                            </div>
                        </div>
                    </div>

                    <!-- # STEP 4 #-->
                    <div class="form-step" id="form-step-4" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <h4 class="patient-font mt-4"
                                        style="background-color: #727DAB; color: white; padding: 3px; margin-top: -10px;">
                                        VI. RISK SCREENING <span class="text-danger">*</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                    <tr>
                                        <th colspan="2"
                                            style="border: 1px solid #000; padding: 10px; background-color: #f2f2f2;">
                                            6.1 Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                            Blood Pressure
                                        </td>
                                        <td style="border: 1px solid #000; padding: 10px;">
                                            <label>First Measurement</label>
                                            <div style="display:flex">
                                                <div style="margin-bottom: 10px; display: flex; flex-direction: column;">
                                                    <label>Systolic:</label>
                                                    <input type="text" name="systolic_t1"
                                                        style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                                </div>
                                                <div style="margin-bottom: 10px; display: flex; flex-direction: column;">
                                                    <label>Diastolic:</label>
                                                    <input type="text" name="diastolic_t1"
                                                        style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                                </div>
                                            </div>
                                            <br>
                                            <label>Second Measurement</label>
                                            <div style="display:flex">
                                                <div style="margin-bottom: 10px; display: flex; flex-direction: column;">
                                                    <label>Systolic:</label>
                                                    <input type="text" name="systolic_t2"
                                                        style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                                </div>
                                                <div style="margin-bottom: 10px; display: flex; flex-direction: column;">
                                                    <label>Diastolic:</label>
                                                    <input type="text" name="diastolic_t2"
                                                        style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                            Blood Sugar
                                        </td>
                                        <td style="border: 1px solid #000; padding: 10px;">
                                            <div style="margin-bottom: 10px;">
                                                <label>FBS Result:</label>
                                                <input type="text" name="fbs_result" id="fbs_result"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>RBS Result:</label>
                                                <input type="text" name="rbs_result" id="rbs_result"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Date Taken:</label>
                                                <input type="date" id="blood_sugar_date_taken"
                                                    name="blood_sugar_date_taken"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                            Check if DM clinical symptoms are present
                                        </td>
                                        <td style="border: 1px solid #000; padding: 10px;">
                                            <input type="checkbox" name="dm_symptoms[]" value="polyphagia"> Polyphagia
                                            <input type="checkbox" name="dm_symptoms[]" value="polydipsia"> Polydipsia
                                            <input type="checkbox" name="dm_symptoms[]" value="polyuria"> Polyuria
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                            Lipid Profile
                                        </td>
                                        <td style="border: 1px solid #000; padding: 10px;">
                                            <div style="margin-bottom: 10px;">
                                                <label>Total Cholesterol:</label>
                                                <input type="text" name="lipid_cholesterol"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>HDL:</label>
                                                <input type="text" name="lipid_hdl"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>LDL:</label>
                                                <input type="text" name="lipid_ldl"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>VLDL:</label>
                                                <input type="text" name="lipid_vldl"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Triglyceride:</label>
                                                <input type="text" name="lipid_triglyceride"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Date Taken:</label>
                                                <input type="date" name="lipid_date_taken"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="<?= date('Y-m-d') ?>">
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
                                                <input type="text" name="uri_protein"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Date Taken:</label>
                                                <input type="date" name="uri_protein_date_taken"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="<?= date('Y-m-d') ?>">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Ketones:</label>
                                                <input type="text" name="uri_ketones"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Date Taken:</label>
                                                <input type="date" name="uri_ketones_date_taken"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2"
                                            style="border: 1px solid #000; padding: 10px; background-color: #f2f2f2;">
                                            6.2 Chronic Respiratory Disease (Asthma and COPD)
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                            CHECK all applicable
                                        </td>
                                        <td style="border: 1px solid #000; padding: 10px; ">
                                            <div class="checkbox-group"
                                                style="display: flex; gap: 10px; flex-wrap: wrap;">
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_breathlessness"
                                                        value="1"> Breathlessness (or a 'need for air')
                                                </label>
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_sputum_production"
                                                        value="1"> Sputum (mucous) production
                                                </label>
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_chronic_cough"
                                                        value="1"> Chronic cough
                                                </label>
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_chest_tightness"
                                                        value="1"> Chest tightness
                                                </label>
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_wheezing" value="1">
                                                    Wheezing
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
                                            <div class="checkbox-group"
                                                style="display: flex; flex-direction: column; gap: 5px;">
                                                <label>
                                                    <input type="checkbox" name="pefr_above_20_percent"
                                                        value="1"> &gt; 20% change from baseline (consider Probable
                                                    Asthma)
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="pefr_below_20_percent"
                                                        value="1"> &lt; 20% change from baseline (consider Probable
                                                    COPD)
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div id="error-message-step-4" style="color: red; display: none;">Please fill out all
                                    required fields.</div>
                            </div>
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="showPreviousStep()">Previous</button>
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="validateStep4()">Next</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-step" id="form-step-5" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <h4 class="patient-font mt-4"
                                        style="background-color: #727DAB; color: white; padding: 3px; margin-top: -10px;">
                                        VII. MANAGEMENT
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                    <?php
                                    // PHP array to define the management sections
                                    $management = [
                                        'Lifestyle Modification' => [
                                            'type' => 'textarea',
                                            'name' => 'lifestyle_modification',
                                        ],
                                        'Medications' => [
                                            'Anti-Hypertensives' => [
                                                'name' => 'anti_hypertensives',
                                                'options' => ['Yes', 'No', 'Unknown'],
                                                'specify' => 'anti_hypertensives_specify',
                                            ],
                                            'Anti-Diabetes' => [
                                                'name' => 'anti_diabetes',
                                                'options' => ['Yes', 'No', 'Unknown'],
                                                'sub-options' => ['Oral Hypoglycemic', 'Insulin', 'Not Known', 'Others'],
                                                'specify' => 'anti_diabetes_specify',
                                            ],
                                        ],
                                        'Date of Follow-up' => [
                                            'type' => 'date',
                                            'name' => 'follow_up_date',
                                        ],
                                        'Remarks' => [
                                            'type' => 'textarea',
                                            'name' => 'remarks',
                                        ],
                                    ];
                                    ?>

                                    <!-- HTML Table Structure for Management Section -->
                                    <table border="1" cellpadding="10" cellspacing="0"
                                        style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                                        <thead>
                                            <tr>
                                                <th colspan="2"
                                                    style="text-align: left; background-color: #f1f1f1; padding: 10px;">
                                                    Lifestyle Modification</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Medications Section -->
                                            <tr>
                                                <td style="font-weight: bold; padding: 10px;">Medications</td>
                                                <td>
                                                    <!-- Anti-Hypertensives -->
                                                    <div style="margin: 10px;">
                                                        <label id="anti-hypertensives-label"
                                                            style="font-weight: bold;">a. Anti-Hypertensives:</label>
                                                        <div style="display: flex; gap: 10px; margin-top: 5px;">
                                                            <?php foreach ($management['Medications']['Anti-Hypertensives']['options'] as $option): ?>
                                                            <label>
                                                                <input type="radio" name="anti_hypertensives"
                                                                    value="<?= strtolower($option) ?>"
                                                                    onchange="toggleAntiHypertensivesOptions()">
                                                                <?= $option ?>
                                                            </label>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div id="antiHypertensivesOptions" style="display: none;">
                                                            <input type="text" id="anti_hypertensives_specify"
                                                                name="anti_hypertensives_specify"
                                                                placeholder="Specify medicine"
                                                                style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                                        </div>
                                                    </div>
                                                    <br />
                                                    <!-- Anti-Diabetes Section -->
                                                    <div style="margin: 10px;">
                                                        <label id="anti-diabetes-label" style="font-weight: bold;">b.
                                                            Anti-Diabetes:</label>
                                                        <div style="display: flex; gap: 10px; margin-top: 5px;">
                                                            <?php foreach ($management['Medications']['Anti-Diabetes']['options'] as $option): ?>
                                                            <label>
                                                                <input type="radio" name="anti_diabetes"
                                                                    value="<?= strtolower($option) ?>"
                                                                    onchange="toggleAntiDiabetesOptions()"> <?= $option ?>
                                                            </label>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div id="antiDiabetesOptions" style="display: none;">
                                                            <div style="display: flex; gap: 10px; margin-top: 5px;">
                                                                <?php foreach ($management['Medications']['Anti-Diabetes']['sub-options'] as $subOption): ?>
                                                                <label>
                                                                    <input type="radio" name="anti_diabetes_type"
                                                                        value="<?= strtolower(str_replace(' ', '_', $subOption)) ?>">
                                                                    <?= $subOption ?>
                                                                </label>
                                                                <?php endforeach; ?>
                                                            </div>

                                                            <input type="text" id="anti_diabetes_specify"
                                                                name="anti_diabetes_specify"
                                                                placeholder="Specify medicine"
                                                                style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Date of Follow-up Section -->
                                            <tr>
                                                <td style="font-weight: bold; padding: 10px;">Date of Follow-up</td>
                                                <td>
                                                    <input type="date" name="follow_up_date"
                                                        value="<?= date('Y-m-d') ?>"
                                                        style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 8px;">
                                                </td>
                                            </tr>

                                            <!-- Remarks Section -->
                                            <tr>
                                                <td style="font-weight: bold; padding: 10px;">Remarks</td>
                                                <td>
                                                    <textarea name="remarks" rows="3"
                                                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </table>
                            </div>
                            <div id="error-message-step-5" style="color: red; display: none;">Please fill out all
                                required fields.</div>
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="showPreviousStep()">Previous</button>
                                <button type="submit" class="btn btn-success mx-2"
                                    onclick="validateStep5()">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Internal JS-->
    <script language="javascript" type="text/javascript">
        // controls the anti-hypertensive options
        const toggleAntiHypertensivesOptions = () => {
            const antiHypertensivesRadios = document.getElementsByName('anti_hypertensives');
            const antiHypertensivesSelected = Array.from(antiHypertensivesRadios).find(radio => radio.checked);

            const antiHypertensivesOptionsDiv = document.getElementById('antiHypertensivesOptions');

            if (antiHypertensivesSelected && (antiHypertensivesSelected.value === 'yes' || antiHypertensivesSelected
                    .value === 'unknown')) {
                antiHypertensivesOptionsDiv.style.display = 'block';
            } else {
                antiHypertensivesOptionsDiv.style.display = 'none';
            }
        }

        // controls the anti-diabetic options
        const toggleAntiDiabetesOptions = () => {
            const antiDiabetesRadios = document.getElementsByName('anti_diabetes');
            const antiDiabetesSelected = Array.from(antiDiabetesRadios).find(radio => radio.checked);

            const antiDiabetesOptionsDiv = document.getElementById('antiDiabetesOptions');

            if (antiDiabetesSelected && (antiDiabetesSelected.value === 'yes' || antiDiabetesSelected.value ===
                    'unknown')) {
                antiDiabetesOptionsDiv.style.display = 'block';
            } else {
                antiDiabetesOptionsDiv.style.display = 'none';
            }
        }

        // controls the other religion field
        const showOtherReligionField = () => {
            let religionSelect = document.getElementById("religion");
            let otherReligionDiv = document.getElementById("other-religion-div");
            let otherReligionInput = document.getElementById("other_religion");

            if (religionSelect.value === "Others") {
                otherReligionDiv.style.display = "block";
                otherReligionInput.required = true; // Make the 'Other' religion input required
            } else {
                otherReligionDiv.style.display = "none";
                otherReligionInput.required = false; // Remove the 'required' attribute if not selecting 'Others'
            }
        }

        // controls the other citizenship field
        const showOtherCitizenshipField = () => {
            let citizenshipSelect = document.getElementById("citizenship");
            let otherCitizenshipDiv = document.getElementById("other-citizenship-div");
            let otherCitizenshipInput = document.getElementById("other_citizenship");

            if (citizenshipSelect.value === "Others") {
                otherCitizenshipDiv.style.display = "block";
                otherCitizenshipInput.required = true; // Make the 'Other' citizenship input required
            } else {
                otherCitizenshipDiv.style.display = "none";
                otherCitizenshipInput.required = false; // Remove the 'required' attribute if not selecting 'Others'
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
            document.getElementById(yesId).addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById(noId).checked = false;
                    document.getElementById(noId).dispatchEvent(new Event('change'));
                }
            });

            document.getElementById(noId).addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById(yesId).checked = false;
                    document.getElementById(yesId).dispatchEvent(new Event('change'));
                }
            });
        }

        // Function to classify BMI result
        const bmiResultToStr = (bmi) => {
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

        // age calculation function
        const calculateAge = (birthdate) => {
            const today = new Date();
            const birthDate = new Date(birthdate);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();

            // Check if the birth date hasn't occurred yet this year
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            return age;
        }

        // Event listener for date of birth input
        document.getElementById('dateofbirth').addEventListener('change', function() {
            const birthdate = this.value;
            const age = calculateAge(birthdate);
            document.getElementById('age').value = age;
        });

        // BMI calculation function
        const calculateBMI = () => {
            let weight = parseFloat(document.getElementById('weight').value);
            let height = parseFloat(document.getElementById('height').value);

            if (weight > 0 && height > 0) {
                let heightInMeters = height / 100;
                let bmi = weight / (heightInMeters * heightInMeters);

                // Set BMI values in the UI
                document.getElementById('bmi').value = bmi.toFixed(2);
                document.getElementById('bmiStrVal').textContent = bmiResultToStr(bmi);
            } else {
                document.getElementById('bmi').value = "";
                document.getElementById('bmiStrVal').textContent = "";
            }
        }

        // Initialize checkbox toggling for each condition
        document.addEventListener('DOMContentLoaded', () => {
            // Toggle checkboxes for all conditions
            //past medical history
            toggleCheckbox('pmh_hypertension_yes', 'pmh_hypertension_no');
            toggleCheckbox('pmh_heart_disease_yes', 'pmh_heart_disease_no');
            toggleCheckbox('pmh_diabetes_yes', 'pmh_diabetes_no');
            toggleCheckbox('pmh_cancer_yes', 'pmh_cancer_no');
            toggleCheckbox('pmh_copd_yes', 'pmh_copd_no');
            toggleCheckbox('pmh_asthma_yes', 'pmh_asthma_no');
            toggleCheckbox('pmh_allergies_yes', 'pmh_allergies_no');
            toggleCheckbox('pmh_mns_yes', 'pmh_mns_no');
            toggleCheckbox('pmh_vision_yes', 'pmh_vision_no');
            toggleCheckbox('pmh_surgical_history_yes', 'pmh_surgical_history_no');
            toggleCheckbox('pmh_thyroid_yes', 'pmh_thyroid_no');
            toggleCheckbox('pmh_kidney_yes', 'pmh_kidney_no');

            //family history
            toggleCheckbox('fmh_hypertension_yes', 'fmh_hypertension_no');
            toggleCheckbox('fmh_stroke_yes', 'fmh_stroke_no');
            toggleCheckbox('fmh_heart_disease_yes', 'fmh_heart_disease_no');
            toggleCheckbox('fmh_diabetes_mel_yes', 'fmh_diabetes_mel_no');
            toggleCheckbox('fmh_asthma_yes', 'fmh_asthma_no');
            toggleCheckbox('fmh_cancer_yes', 'fmh_cancer_no');
            toggleCheckbox('fmh_kidney_disease_yes', 'fmh_kidney_disease_no');
            toggleCheckbox('fmh_degree_relative_yes', 'fmh_degree_relative_no');
            toggleCheckbox('fmh_family_tb_yes', 'fmh_family_tb_no');
            toggleCheckbox('fmh_mnsad_yes', 'fmh_mnsad_no');
            toggleCheckbox('fmh_copd_yes', 'fmh_copd_no');

            //NCD RISK FACTORS
            toggleCheckbox('alcohol_yes', 'alcohol_never');
            toggleCheckbox('physical_yes', 'physical_no');
            toggleCheckbox('nutrition_diet_yes', 'nutrition_diet_no');

            // // Show/hide additional inputs based on checkbox state
            // const additionalInputs = document.querySelector('.additional-inputs');
            // additionalInputs.style.display = 'none'; // Hide by default

            const healthCheckboxes = document.querySelectorAll('.healthCheckbox');
            healthCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    const anyChecked = Array.from(healthCheckboxes).some(cb => cb.checked && cb.id
                        .endsWith('Yes'));
                    // additionalInputs.style.display = anyChecked ? 'block' : 'none';
                });
            });
        });

        const tobaccoCheckboxes = document.querySelectorAll('.tobaccoCheckbox');

        tobaccoCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCheckboxes = Array.from(tobaccoCheckboxes).filter(cb => cb.checked);
                tobaccoCheckboxCount = checkedCheckboxes.length;
                if (checkedCheckboxes.length >= 2) {
                    // Disable all unchecked checkboxes if two are checked
                    tobaccoCheckboxes.forEach(cb => {
                        if (!cb.checked) {
                            cb.disabled = true;
                        }
                    });
                } else {
                    // Re-enable all checkboxes if fewer than two are checked
                    tobaccoCheckboxes.forEach(cb => cb.disabled = false);
                }
            });
        });

        const alcoholYes = document.getElementById('alcohol_yes');
        const alcoholNo = document.getElementById('alcohol_never');
        const bingeLabel = document.getElementById('bingeLabel');

        // Check initial state
        bingeLabel.style.opacity = alcoholYes.checked ? '1' : '0.5';

    // Event listener to toggle opacity
    alcoholYes.addEventListener('change', function() {
        if (alcoholYes.checked) {
            bingeLabel.style.opacity = '1';  // Full opacity when "Yes, drinks alcohol" is checked
            document.getElementById('alcohol_never').checked = false;
            document.getElementById('alcohol_binge').disabled = false;
        }
    });
    // Event listener for "No" option to toggle opacity and uncheck binge question
    alcoholNo.addEventListener('change', function() {
        if (alcoholNo.checked) {
            bingeLabel.style.opacity = '0.5';  // Translucent when "No" is checked
            document.getElementById('alcohol_binge').checked = false; // Uncheck binge question
            document.getElementById('alcohol_yes').checked = false; // Uncheck binge question
            document.getElementById('alcohol_binge').disabled = true;
        }
    });

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
                    formerUser.dispatchEvent(new Event('change')); // Trigger change
                    currentUser.checked = false;
                    currentUser.dispatchEvent(new Event('change')); // Trigger change
                }
                // If "Former User" is selected, uncheck "Never Used" and "Current User"
                else if (this === formerUser) {
                    neverUsed.checked = false;
                    neverUsed.dispatchEvent(new Event('change')); // Trigger change
                    currentUser.checked = false;
                    currentUser.dispatchEvent(new Event('change')); // Trigger change
                }
                // If "Current User" is selected, uncheck "Never Used" and "Former User"
                else if (this === currentUser) {
                    neverUsed.checked = false;
                    neverUsed.dispatchEvent(new Event('change')); // Trigger change
                    formerUser.checked = false;
                    formerUser.dispatchEvent(new Event('change')); // Trigger change
                }
            }
        });
    });

        // Function to toggle "No" checkboxes for all conditions
        function checkAllNo() {
            // Select all checkboxes with value="No" and exclude those with name="indigenous_person"
            const noCheckboxes = Array.from(document.querySelectorAll('input[type="checkbox"][value="No"]'))
                .filter(checkbox => checkbox.name !== 'indigenous_person');

            // Check if all relevant "No" checkboxes are already checked
            const allChecked = noCheckboxes.every(checkbox => checkbox.checked);

            // Toggle the state of all "No" checkboxes
            noCheckboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
                checkbox.dispatchEvent(new Event('change'));
            });

            // // Hide additional inputs if all "No" are checked
            // const additionalInputs = document.querySelector('.additional-inputs');
            // additionalInputs.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle multiple checkboxes and their corresponding input fields
            const conditions = [{
                    checkboxId: 'pmh_cancer_yes',
                    detailsInputId: 'cancerDetailsInput'
                },
                {
                    checkboxId: 'pmh_allergies_yes',
                    detailsInputId: 'allergiesDetailsInput'
                },
                {
                    checkboxId: 'pmh_mns_yes',
                    detailsInputId: 'mnsDetailsInput'
                },
                {
                    checkboxId: 'pmh_diabetes_yes',
                    detailsInputId: 'diabetesDetailsInput'
                },
                {
                    checkboxId: 'pmh_surgical_history_yes',
                    detailsInputId: 'surgicalDetailsInput'
                }
            ];

            conditions.forEach(condition => {
                const checkbox = document.getElementById(condition.checkboxId);
                const detailsInput = document.getElementById(condition.detailsInputId);

                checkbox.addEventListener('change', function() {
                    checkbox.checked ? detailsInput.style.display = "block" : detailsInput.style
                        .display = "none";
                });
            });
        });
    </script>
    <!--Validation Functions-->

    <!-- Step 1 validation -->
    <script language="javascript" type="text/javascript">
        // Function to reset the error styles (remove red borders and hide error message)
        const resetErrorStep1Styles = () => {
            // Remove red border from all fields
            document.getElementById('lname').style.borderColor = '';
            document.getElementById('fname').style.borderColor = '';
            document.getElementById('sex').style.borderColor = '';
            document.getElementById('contact').style.borderColor = '';
            document.getElementById('dateofbirth').style.borderColor = '';
            document.getElementById('age').style.borderColor = '';
            document.getElementById('civil_status').style.borderColor = '';
            document.getElementById('religion').style.borderColor = '';
            // document.getElementById('citizenship').style.borderColor = '';
            document.getElementById('other_religion').style.borderColor = '';
            document.getElementById('other_citizenship').style.borderColor = '';
            document.getElementById('province_risk').style.borderColor = '';
            document.getElementById('municipal').style.borderColor = '';
            document.getElementById('barangay').style.borderColor = '';

            document.getElementById('no_selected_indigenous_person').style.color = '';
            document.getElementById('no_selected_indigenous_person').textContent = '';

            document.getElementById('no_selected_employment_status').style.color = '';
            document.getElementById('no_selected_employment_status').textContent = '';

            // Hide the error message
            document.getElementById('error-message').style.display = 'none';
        };

        const validateStep1 = () => {
            // Get the values of the fields
            const lname = document.getElementById('lname').value;
            const fname = document.getElementById('fname').value;
            const sex = document.getElementById('sex').value;
            const age = document.getElementById('age').value;
            const contact = document.getElementById('contact').value;
            const dateofbirth = document.getElementById('dateofbirth').value;
            const citizenship = document.getElementById('citizenship').value;
            const otherCitizenship = document.getElementById('other_citizenship').value;
            const civilStatus = document.getElementById('civil_status').value;
            const religion = document.getElementById('religion').value;
            const otherReligion = document.getElementById('other_religion').value;
            const province = document.getElementById('province_risk').value;
            const municipal = document.getElementById('municipal').value;
            const barangay = document.getElementById('barangay').value;

            // indigenous person checkboxes
            const indigenousPersonYes = document.getElementById('indigenous_person_yes').checked;
            const indigenousPersonNo = document.getElementById('indigenous_person_no').checked;

            // employment status checkboxes
            const employmentStatusEmployed = document.getElementById('employment_status_employed').checked;
            const employmentStatusUnemployed = document.getElementById('employment_status_unemployed').checked;
            const employmentStatusSelfEmployed = document.getElementById('employment_status_self_employed').checked;

            // Reset previous error styles and message
            resetErrorStep1Styles();

            const extractNumbers = (str) => {
                return str.replace(/\D/g, '');
            };

            let errorMessage = "<strong>Please review and check these fields:</strong> <br/>";
            let isValid = true;

            // Check if any of the required fields are empty
            if (!lname) {
                document.getElementById('lname').style.borderColor = 'red';
                errorMessage += "Last Name<br>";
                isValid = false;
            }

            if (!fname) {
                document.getElementById('fname').style.borderColor = 'red';
                errorMessage += "First Name<br>";
                isValid = false;
            }

            if (!sex) {
                document.getElementById('sex').style.borderColor = 'red';
                errorMessage += "Sex<br>";
                isValid = false;
            }

            if (!religion) {
                document.getElementById('religion').style.borderColor = 'red';
                errorMessage += "Religion<br>";
                isValid = false;
            }

            if (!contact) {
                document.getElementById('contact').style.borderColor = 'red';
                errorMessage += "Contact<br>";
                isValid = false;
            }

            if (!dateofbirth) {
                document.getElementById('dateofbirth').style.borderColor = 'red';
                errorMessage += "Date of Birth<br>";
                isValid = false;
            }

            // Age validation
            if (Number(extractNumbers(age)) < 18) {
                document.getElementById('age').style.borderColor = 'red';
                errorMessage += "<strong>Patient is not eligible for this form.</strong><i> (Under 18)</i><br>";
                isValid = false;
            }

            if (!civilStatus) {
                document.getElementById('civil_status').style.borderColor = 'red';
                errorMessage += "Civil Status<br>";
                isValid = false;
            }

            if (!province) {
                document.getElementById('province_risk').style.borderColor = 'red';
                errorMessage += "Province<br>";
                isValid = false;
            }

            if (!municipal) {
                document.getElementById('municipal').style.borderColor = 'red';
                errorMessage += "Municipality/City<br>";
                isValid = false;
            }

            if (!barangay) {
                document.getElementById('barangay').style.borderColor = 'red';
                errorMessage += "Barangay<br>";
                isValid = false;
            }

            if (citizenship === "Others" && !otherCitizenship) {
                document.getElementById('other_citizenship').style.borderColor = 'red';
                errorMessage += "Other Citizenship is required when 'Others' is selected.<br>";
                isValid = false;
            }

            if (religion === "Others" && !otherReligion) {
                document.getElementById('other_religion').style.borderColor = 'red';
                errorMessage += "Other Religion is required when 'Others' is selected.<br>";
                isValid = false;
            }

            if (!indigenousPersonYes && !indigenousPersonNo) {
                document.getElementById('no_selected_indigenous_person').style.color = 'red';
                document.getElementById('no_selected_indigenous_person').textContent = 'Please select one.';
                errorMessage += "Please tick an option in 'Indigenous Person' field.<br>";
                isValid = false;
            }

            if (!employmentStatusEmployed && !employmentStatusUnemployed && !employmentStatusSelfEmployed) {
                document.getElementById('no_selected_employment_status').style.color = 'red';
                document.getElementById('no_selected_employment_status').textContent = 'Please select one.';
                errorMessage += "Please tick an option in 'Employment Status' field.<br>";
                isValid = false;
            }

            // If there is an error, display the specific error message
            if (!isValid) {
                document.getElementById('error-message').style.display = 'block';
                document.getElementById('error-message').innerHTML = errorMessage;
                return; // Prevent moving to the next step if validation fails
            }

            // If validation passes, hide the error message and proceed
            document.getElementById('error-message').style.display = 'none'; // Hide the error message
            console.log("Step 1 is validated");
            showNextStep(); // Assuming showNextStep() handles the page transition
        };
    </script>

    <!-- Step 2 validation -->
    <script language="javascript" type="text/javascript">
        const validateStep2 = () => {
            console.log("Step 2 is validated");
            showNextStep();
        }
    </script>

    <!-- Step 3 validation -->
    <script language="javascript" type="text/javascript">
        // Function to reset the error styles (remove red borders and hide error message)
        const resetErrorStep3Styles = () => {
            // Remove red border from all fields
            document.getElementById('weight').style.borderColor = '';
            document.getElementById('height').style.borderColor = '';
            document.getElementById('waist').style.borderColor = '';
            document.getElementById('tobacco-use-label').style.color = ''

            // Hide the error message
            document.getElementById('error-message-step-3').style.display = 'none';
        };

        const validateStep3 = () => {
            // Get the values of the fields
            const weight = document.getElementById('weight').value;
            const height = document.getElementById('height').value;
            const waist = document.getElementById('waist').value;

            // Reset previous error styles and message
            resetErrorStep3Styles();

            let errorMessage = "<strong>Please review and check these fields:</strong><br/>";
            let isValid = true;

            // Check if any of the required fields are empty
            if (!weight) {
                document.getElementById('weight').style.borderColor = 'red';
                errorMessage += "Weight<br>";
                isValid = false;
            }

            if (!height) {
                document.getElementById('height').style.borderColor = 'red';
                errorMessage += "Height<br>";
                isValid = false;
            }

            if (!waist) {
                document.getElementById('waist').style.borderColor = 'red';
                errorMessage += "Waist<br>";
                isValid = false;
            }

            // tobacco
            const getTobaccoCheckboxCount = () => {
                const tobaccoCheckboxes = document.querySelectorAll('.tobaccoCheckbox');

                const updateCheckboxCount = () => {
                    const checkedCheckboxes = Array.from(tobaccoCheckboxes).filter(cb => cb.checked);
                    return checkedCheckboxes.length;
                }


                tobaccoCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateCheckboxCount);
                });

                return updateCheckboxCount();
            }

            if (getTobaccoCheckboxCount() <= 0) {
                document.getElementById('tobacco-use-label').style.color = 'red';
                errorMessage += "Please review tobacco use fields.<br>";
                isValid = false;
            }

            // alcohol
            const getAlcoholCheckboxCount = () => {
                const alcoholCheckboxes = document.querySelectorAll('.alcoholCheckbox');

                const updateCheckboxCount = () => {
                    const checkedCheckboxes = Array.from(alcoholCheckboxes).filter(cb => cb.checked);
                    return checkedCheckboxes.length;
                }


                alcoholCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateCheckboxCount);
                });

                return updateCheckboxCount();
            }

            if (getAlcoholCheckboxCount() <= 0) {
                document.getElementById('alcohol-intake-label').style.color = 'red';
                errorMessage += "Please review alcohol intake fields.<br>";
                isValid = false;
            }

            // physical activity
            const getPhysicalActivityCheckboxCount = () => {
                const physicalActivityCheckboxes = document.querySelectorAll('.physicalCheckbox');

                const updateCheckboxCount = () => {
                    const checkedCheckboxes = Array.from(physicalActivityCheckboxes).filter(cb => cb.checked);
                    return checkedCheckboxes.length;
                }


                physicalActivityCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateCheckboxCount);
                });

                return updateCheckboxCount();
            }

            if (getPhysicalActivityCheckboxCount() <= 0) {
                document.getElementById('physical-activity-label').style.color = 'red';
                errorMessage += "Please review physical activity fields.<br>";
                isValid = false;
            }

            // nutrition and dietary assessment
            const getNutritionAndDietaryCheckboxCount = () => {
                const nutritionAndDietaryCheckboxes = document.querySelectorAll('.nutritionDietCheckbox');

                const updateCheckboxCount = () => {
                    const checkedCheckboxes = Array.from(nutritionAndDietaryCheckboxes).filter(cb => cb
                    .checked);
                    return checkedCheckboxes.length;
                }


                nutritionAndDietaryCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateCheckboxCount);
                });

                return updateCheckboxCount();
            }

            if (getNutritionAndDietaryCheckboxCount() <= 0) {
                document.getElementById('nutrition-and-dietary-assessment-label').style.color = 'red';
                errorMessage += "Please review nutrition and dietary fields.<br>";
                isValid = false;
            }


            // If there is an error, display the specific error message
            if (!isValid) {
                document.getElementById('error-message-step-3').style.display = 'block';
                document.getElementById('error-message-step-3').innerHTML = errorMessage;
                return; // Prevent moving to the next step if validation fails
            }

            // If validation passes, hide the error message and proceed
            document.getElementById('error-message-step-3').style.display = 'none'; // Hide the error message
            console.log("Step 3 is validated");
            showNextStep(); // Assuming showNextStep() handles the page transition
        };
    </script>

    <script language="javascript" type="text/javascript">
        const validateStep4 = () => {
            console.log("Step 4 is validated");
            showNextStep();
        }
    </script>

    <script language="javascript" type="text/javascript">
        const resetErrorStep5Styles = () => {
            // Remove red border from all fields
            document.getElementById('anti_hypertensives_specify').style.borderColor = '';
            document.getElementById('anti_diabetes_specify').style.borderColor = '';

            document.getElementById('anti-hypertensives-label').style.color = '';
            document.getElementById('anti-diabetes-label').style.color = '';
            // Hide the error message
            document.getElementById('error-message-step-5').style.display = 'none';
        };

        const validateStep5 = () => {
            let errorMessage = "";
            let isValid = true;

            // Reset previous error styles and message
            resetErrorStep5Styles();

            const antiHypertensivesRadios = document.getElementsByName('anti_hypertensives');
            const antiHypertensivesSelected = Array.from(antiHypertensivesRadios).find(radio => radio.checked);
            const antiHypertensivesSpecifyMedicine = document.getElementById('anti_hypertensives_specify').value.trim();

            if (!antiHypertensivesSelected) {
                document.getElementById('anti-hypertensives-label').style.color = 'red';
                errorMessage += "Please select an option for anti-hypertensives.<br>";
                isValid = false;
            }

            if (antiHypertensivesSelected &&
                (antiHypertensivesSelected.value === 'yes' || antiHypertensivesSelected.value === 'unknown') &&
                (antiHypertensivesSpecifyMedicine === "" || antiHypertensivesSpecifyMedicine === null)) {
                document.getElementById('anti_hypertensives_specify').style.borderColor = 'red';
                errorMessage +=
                "Please specify the anti-hypertensive medicine when 'Yes' or 'Unknown' is selected.<br>";
                isValid = false;
            }

            const antiDiabetesRadios = document.getElementsByName('anti_diabetes');
            const antiDiabetesSelected = Array.from(antiDiabetesRadios).find(radio => radio.checked);
            const antiDiabetesSpecifyMedicine = document.getElementById('anti_diabetes_specify').value.trim();

            if (!antiDiabetesSelected) {
                document.getElementById('anti-diabetes-label').style.color = 'red';
                errorMessage += "Please select an option for anti-diabetes.<br>";
                isValid = false;
            }

            if (antiDiabetesSelected &&
                (antiDiabetesSelected.value === 'yes' || antiDiabetesSelected.value === 'unknown') &&
                (antiDiabetesSpecifyMedicine === "" || antiDiabetesSpecifyMedicine === null)) {
                document.getElementById('anti_diabetes_specify').style.borderColor = 'red';
                errorMessage += "Please specify the anti-diabetes medicine when 'Yes' or 'Unknown' is selected.<br>";
                isValid = false;
            }

            // If there is an error, display the specific error message
            if (!isValid) {
                document.getElementById('error-message-step-5').style.display = 'block';
                document.getElementById('error-message-step-5').innerHTML = errorMessage;
                return false; // Prevent moving to the next step if validation fails
            }

            // If validation passes, hide the error message and proceed
            document.getElementById('error-message-step-5').style.display = 'none'; // Hide the error message
            console.log("Step 5 is validated");

            // Submit the form
            document.getElementById('form-submit').submit();
        };
    </script>
@endsection

<style type="text/css">
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
        margin-top: 10px;
        /* Adjust this value as needed */
    }

    .col-md-12 .underline-text {
        text-decoration: underline;

    }

    .ex_type {
        font-size: 12px;
    }

    .col-md-6 .others {
        border: none;
        border-bottom: 1px solid black;
        /* Only bottom border */
        outline: none;
        /* Remove default outline */
        transition: border-bottom-color 0.3s;
        width: 7em
    }

    .col-md-12 .A_Hospital {
        background-color: #A1A8C7;
        color: #ffff;
        padding: 3px;
        margin-top: -10px;
    }

    .col-md-6 .small-input {
        width: 50%;
        /* Adjust this value to set the desired width */
        max-width: 100%;
        /* Ensure it does not exceed the container's width */
    }

    .indention {
        border-top: 1px solid black;
        margin-bottom: 3px;
    }

    .mt-3 {
        margin-top: 5px;
    }

    .row .inline-input {
        display: inline-block;
        width: 275;
        margin-left: 96px;
        vertical-align: middle;
    }

    .col-md-12 .col-md-3 .inline-input2 {
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
        border: none;
        /* Remove default hr styling */
        border-top: 2px solid #000;
        /* Bold line with black color */
        margin: 10px 0;
        width: 100%;
    }

    .is-invalid {
        border-color: red;
    }


    select,
    input {
        border: 1px solid #ced4da;
        transition: border-color 0.3s;
    }

    select:focus,
    input:focus {
        border-color: #80bdff;
        outline: 0;
    }

    select.error,
    input.error {
        border-color: red;
        animation: shake 0.3s;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    .additional-inputs {
        display: none;
        /* Initially hide the inputs */
        margin-top: 15px;
    }

    .translucent-checkbox {
        opacity: 0.5;
        transition: opacity 0.2s;
    }

    .translucent-checkbox:checked {
        opacity: 1;
    }
</style>