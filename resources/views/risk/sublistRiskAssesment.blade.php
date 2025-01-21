@extends('resu/app1')
@section('content')
    <?php
    use App\Facilities;
    use App\Province;
    use App\Muncity;
    use App\UserHealthFacility;
    use App\Barangay;
    
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
    
    use Carbon\Carbon;
    
    $dob = Carbon::parse($profile->dob);
    
    $barangay = Barangay::select('id', 'description')->get();
    
    $muncities = Muncity::select('id', 'description')->get();
    $province = Province::select('id', 'description')->get();
    $facilities = Facilities::all();
    
    // extract riskform from the profile object
    
    $riskForm = $profile['riskForm'];
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
                <form class="form-horizontal form-submit" method="GET">
                    {{ csrf_field() }}
                    <input type="hidden" id="muncities-data" value="{{ json_encode($muncities) }}">
                    <div class="form-step" id="form-step-1">
                        <div class="row">
                            <div class="col-md-12 col-divider">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="facility-name">Name of Health Facility</label>
                                        <input type="text" class="form-control" name="facilityname" id="facility"
                                            readonly value="{{ $facility['name'] ? $facility['name'] : 'N/A' }}">
                                        <input type="hidden" name="facility_id_updated" id="facility_id_updated"
                                            value="{{ $facility['id'] ? $facility['id'] : 'N/A' }}">
                                        <input type="hidden" name="encoded_by" id="encoded_by"
                                            value="{{ $user['id'] ? $user['id'] : 0 }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="date-of-assessment">Date of Assessment</label>
                                        <input type="text" class="form-control datepicker" name="date_of_assessment"
                                            id="date-of-assessment"
                                            value="{{ $profile['created_at'] ? Carbon::parse($profile['created_at'])->format('F d, Y') : '' }}">
                                    </div>

                                    <br><br>
                                    <br><br>
                                </div>
                                <h4 class="patient-font mt-4" style="background-color: #727DAB;color:white;padding: 2px;">I.
                                    PATIENT'S INFORMATION</h4>
                                <div class="row">
                                    <input type="hidden" name="profile_id" id="profile_id">
                                    <input type="hidden" name="profile_id" id="profile_id"
                                        value="{{ $profile['id'] ? $profile['id'] : '' }}">

                                    <div class="col-md-3">
                                        <label for="lname">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="lname" maxlength="25"
                                            id="lname" value="{{ $profile['lname'] ? $profile['lname'] : '' }}" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="fname">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="fname" maxlength="25"
                                            id="fname" value="{{ $profile['fname'] ? $profile['fname'] : '' }}" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="mname">Middle Name</label>
                                        <input type="text" class="form-control" name="mname" maxlength="25"
                                            id="mname" value="{{ $profile['mname'] ? $profile['mname'] : '' }}" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="suffix">Suffix</label>
                                        <select class="form-control " name="suffix" id="suffix" readonly>
                                            <option value="">Select suffix</option>
                                            <option value="Jr." {{ $profile['suffix'] == 'Jr.' ? 'selected' : '' }}>Jr.
                                            </option>
                                            <option value="Sr." {{ $profile['suffix'] == 'Sr.' ? 'selected' : '' }}>Sr.
                                            </option>
                                            <option value="I" {{ $profile['suffix'] == 'I' ? 'selected' : '' }}>I
                                            </option>
                                            <option value="II" {{ $profile['suffix'] == 'II' ? 'selected' : '' }}>II
                                            </option>
                                            <option value="III" {{ $profile['suffix'] == 'III' ? 'selected' : '' }}>III
                                            </option>
                                            <option value="IV" {{ $profile['suffix'] == 'IV' ? 'selected' : '' }}>IV
                                            </option>
                                            <option value="V" {{ $profile['suffix'] == 'V' ? 'selected' : '' }}>V
                                            </option>

                                            <!-- Default "N/a" option if suffix is null or empty -->
                                            @if (is_null($profile['suffix']) || $profile['suffix'] === '')
                                                <option value="N/a" selected>N/a</option>
                                            @else
                                                <option value="N/a">N/a</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="sex">Sex <span class="text-danger">*</span></label>
                                        <select class="form-control" name="sex" id="sex" readonly>
                                            <option value="">Select sex</option>
                                            <option value="Male" {{ $profile['sex'] == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ $profile['sex'] == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="dateofbirth">Date Of Birth</label>
                                        <input type="date" class="form-control"
                                            value="{{ $profile['dob'] ? $profile['dob'] : '' }}" id="dateofbirth"
                                            name="dateBirth" readonly/>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="age">Age</label>
                                        <input type="text" class="form-control" id="age" name="age"
                                            value="{{ $profile['age'] ? $profile['age'] : '' }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="civil_status">Civil Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="civil_status" id="civil_status" readonly>
                                            <option value="">Select status</option>
                                            <option value="Single"
                                                {{ $profile['civil_status'] == 'Single' ? 'selected' : '' }}>Single
                                            </option>
                                            <option value="Married"
                                                {{ $profile['civil_status'] == 'Married' ? 'selected' : '' }}>Married
                                            </option>
                                            <option value="Widowed"
                                                {{ $profile['civil_status'] == 'Widowed' ? 'selected' : '' }}>Widowed
                                            </option>
                                            <option value="Legally Separated"
                                                {{ $profile['civil_status'] == 'Legally Separated' ? 'selected' : '' }}>
                                                Legally Separated</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="religion">Religion <span class="text-danger">*</span></label>
                                        <select class="form-control" name="religion" id="religion"
                                            onchange="showOtherReligionField()" readonly>
                                            <option value="">Select Religion</option>
                                            <option value="Roman Catholic"
                                                {{ $profile['religion'] == 'Roman Catholic' ? 'selected' : '' }}>Roman
                                                Catholic</option>
                                            <option value="Islam"
                                                {{ $profile['religion'] == 'Islam' ? 'selected' : '' }}>
                                                Islam</option>
                                            <option value="Iglesia ni Cristo"
                                                {{ $profile['religion'] == 'Iglesia ni Cristo' ? 'selected' : '' }}>Iglesia
                                                ni Cristo</option>
                                            <option value="Seventh-day Adventist"
                                                {{ $profile['religion'] == 'Seventh-day Adventist' ? 'selected' : '' }}>
                                                Seventh-day Adventist</option>
                                            <option value="Iglesia Filipina Independiente"
                                                {{ $profile['religion'] == 'Iglesia Filipina Independiente' ? 'selected' : '' }}>
                                                Iglesia Filipina Independiente/Aglipayan</option>
                                            <option value="Bible Baptist Church"
                                                {{ $profile['religion'] == 'Bible Baptist Church' ? 'selected' : '' }}>
                                                Bible
                                                Baptist Church</option>
                                            <option value="UCCP" {{ $profile['religion'] == 'UCCP' ? 'selected' : '' }}>
                                                United Church of Christ in The Philippines</option>
                                            <option value="Jehovah’s Witnesses"
                                                {{ $profile['religion'] == 'Jehovah’s Witnesses' ? 'selected' : '' }}>
                                                Jehovah’s Witnesses</option>
                                            <option value="Church of Christ"
                                                {{ $profile['religion'] == 'Church of Christ' ? 'selected' : '' }}>Church
                                                of
                                                Christ</option>
                                            <option value="Latter-Day Saints"
                                                {{ $profile['religion'] == 'Latter-Day Saints' ? 'selected' : '' }}>
                                                Latter-Day Saints</option>
                                            <option value="Assemblies of God"
                                                {{ $profile['religion'] == 'Assemblies of God' ? 'selected' : '' }}>
                                                Assemblies of God</option>
                                            <option value="Kingdom of Jesus Christ"
                                                {{ $profile['religion'] == 'Kingdom of Jesus Christ' ? 'selected' : '' }}>
                                                Kingdom of Jesus Christ</option>
                                            <option value="Evangelical"
                                                {{ $profile['religion'] == 'Evangelical' ? 'selected' : '' }}>Evangelical
                                            </option>
                                            <option value="Baptists"
                                                {{ $profile['religion'] == 'Baptists' ? 'selected' : '' }}>Baptists
                                            </option>
                                            <option value="Methodists"
                                                {{ $profile['religion'] == 'Methodists' ? 'selected' : '' }}>Methodists
                                            </option>
                                            <option value="Hinduism"
                                                {{ $profile['religion'] == 'Hinduism' ? 'selected' : '' }}>Hinduism
                                            </option>
                                            <option value="Buddhism"
                                                {{ $profile['religion'] == 'Buddhism' ? 'selected' : '' }}>Buddhism
                                            </option>
                                            <option value="Judaism"
                                                {{ $profile['religion'] == 'Judaism' ? 'selected' : '' }}>Judaism</option>
                                            <option value="Baha'i"
                                                {{ $profile['religion'] == 'Baha\'i' ? 'selected' : '' }}>Baha'i</option>
                                            <option value="Jainism"
                                                {{ $profile['religion'] == 'Jainism' ? 'selected' : '' }}>Jainism</option>
                                            <option value="Others"
                                                {{ $profile['religion'] == 'Others' ? 'selected' : '' }}>
                                                Others</option>
                                        </select>
                                    </div>

                                    <!-- This div will only appear if Others is selected -->
                                    <div class="col-md-3" id="other-religion-div">
                                        <label for="other_religion">Specify Other Religion <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="other_religion"
                                            id="other_religion" maxlength="50" placeholder="Please specify"
                                            value="{{ $profile['other_religion'] ? $profile['other_religion'] : '' }}" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="contact">Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="contact" id="contact"
                                            maxlength="11" value="{{ $profile['contact'] ? $profile['contact'] : '' }}" readonly>
                                    </div>
                                    <div class="row"></div>
                                    <div class="col-md-4">
                                        <label for="province">Province/HUC <span class="text-danger">*</span></label>
                                        <select class="form-control" name="province" id="province" readonly>
                                            <option value="">Select Province</option>
                                            @foreach ($province as $prov)
                                                <option value="{{ $prov->id }}"
                                                    {{ $profile['province_id'] == $prov->id ? 'selected' : '' }}>
                                                    {{ $prov->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="municipal">Municipality/City <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="municipal" id="municipal" readonly>
                                            <option value="">Select Muncity</option>
                                            @foreach ($muncities as $mun)
                                                <option value="{{ $mun->id }}"
                                                    {{ $profile['municipal_id'] == $mun->id ? 'selected' : '' }}>
                                                    {{ $mun->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="barangay">Barangay <span class="text-danger">*</span></label>
                                        <select class="form-control" name="barangay" id="barangay" readonly>
                                            <option value="">Select Barangay</option>
                                            @foreach ($barangay as $bar)
                                                <option value="{{ $bar->id }}"
                                                    {{ $profile['barangay_id'] == $bar->id ? 'selected' : '' }}>
                                                    {{ $bar->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="street">Street</label>
                                        <input type="text" class="form-control" name="street" id="street"
                                            maxlength="25" value="{{ $profile['street'] ? $profile['street'] : '' }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="purok">Purok</label>
                                        <input type="text" class="form-control" name="purok" id="purok"
                                            maxlength="25" value="{{ $profile['purok'] ? $profile['purok'] : '' }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="sitio">Sitio</label>
                                        <input type="text" class="form-control" name="sitio" id="sitio"
                                            maxlength="25" value="{{ $profile['sitio'] ? $profile['sitio'] : '' }}" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="phic_id">PhilHealth No.</label>
                                        <input type="text" class="form-control" name="phic_id" id="phic_id"
                                            maxlength="12"
                                            value="{{ $profile['phic_id'] ? $profile['phic_id'] : '' }}" readonly><br>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="pwd_id">Persons with Disability ID Card No. if applicable:</label>
                                        <input type="text" class="form-control" name="pwd_id" id="pwd_id"
                                            maxlength="13"
                                            value="{{ $profile['pwd_id'] ? $profile['pwd_id'] : '' }}" readonly><br>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="citizenship">Citizenship</label>
                                        <select class="form-control" name="citizenship" id="citizenship" readonly
                                            onchange="showOtherCitizenshipField()">
                                            <option value="">Select Citizenship</option>
                                            <option value="Filipino"
                                                {{ $profile['citizenship'] == 'Filipino' ? 'selected' : '' }}>Filipino
                                            </option>
                                            <option value="American"
                                                {{ $profile['citizenship'] == 'American' ? 'selected' : '' }}>American
                                            </option>
                                            <option value="Japanese"
                                                {{ $profile['citizenship'] == 'Japanese' ? 'selected' : '' }}>Japanese
                                            </option>
                                            <option value="South Korean"
                                                {{ $profile['citizenship'] == 'South Korean' ? 'selected' : '' }}>Korean
                                            </option>
                                            <option value="Singaporean"
                                                {{ $profile['citizenship'] == 'Singaporean' ? 'selected' : '' }}>
                                                Singaporean
                                            </option>
                                            <option value="Chinese"
                                                {{ $profile['citizenship'] == 'Chinese' ? 'selected' : '' }}>Chinese
                                            </option>
                                            <option value="Taiwanese"
                                                {{ $profile['citizenship'] == 'Taiwanese' ? 'selected' : '' }}>Chinese
                                            </option>
                                            <option value="Australian"
                                                {{ $profile['citizenship'] == 'Australian' ? 'selected' : '' }}>Australian
                                            </option>
                                            <option value="Canadian"
                                                {{ $profile['citizenship'] == 'Canadian' ? 'selected' : '' }}>Canadian
                                            </option>
                                            <option value="Swiss"
                                                {{ $profile['citizenship'] == 'Swiss' ? 'selected' : '' }}>Swiss</option>
                                            <option value="British"
                                                {{ $profile['citizenship'] == 'British' ? 'selected' : '' }}>British
                                            </option>
                                            <option value="Spanish"
                                                {{ $profile['citizenship'] == 'Spanish' ? 'selected' : '' }}>Spanish
                                            </option>
                                            <option value="French"
                                                {{ $profile['citizenship'] == 'French' ? 'selected' : '' }}>French</option>
                                            <option value="German"
                                                {{ $profile['citizenship'] == 'German' ? 'selected' : '' }}>German</option>
                                            <option value="Thai"
                                                {{ $profile['citizenship'] == 'Thai' ? 'selected' : '' }}>Thai</option>
                                            <option value="Vietnamese"
                                                {{ $profile['citizenship'] == 'Vietnamese' ? 'selected' : '' }}>Vietnamese
                                            </option>
                                            <option value="Indonesian"
                                                {{ $profile['citizenship'] == 'Indonesian' ? 'selected' : '' }}>Indonesian
                                            </option>
                                            <option value="Malaysian"
                                                {{ $profile['citizenship'] == 'Malaysian' ? 'selected' : '' }}>Malaysian
                                            </option>
                                            <option value="Indian"
                                                {{ $profile['citizenship'] == 'Indian' ? 'selected' : '' }}>Indian</option>
                                            <option value="Russian"
                                                {{ $profile['citizenship'] == 'Russian' ? 'selected' : '' }}>Russian
                                            </option>
                                            <option value="Others"
                                                {{ $profile['citizenship'] == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                    </div>

                                    <!-- This div will only appear if Others is selected -->
                                    <div class="col-md-3" id="other-citizenship-div">
                                        <label for="other_citizenship">Specify Other Citizenship <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="other_citizenship"
                                            id="other_citizenship" placeholder="Please specify citizenship"
                                            value="{{ $profile['other_citizenship'] ? $profile['other_citizenship'] : '' }}">
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="mr-2">Indigenous Person</label><br>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="indigenous_person_yes"
                                                id="indigenous_person_yes" value="yes"
                                                {{ strtolower($profile['indigenous_person']) == 'yes' ? 'checked' : '' }}>
                                            <label for="indigenous_person_yes" class="ml-2">Yes</label>
                                        </span>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="indigenous_person_no" id="indigenous_person_no"
                                                value="no"
                                                {{ strtolower($profile['indigenous_person']) == 'no' ? 'checked' : '' }}>
                                            <label for="indigenous_person_no" class="ml-2">No</label>
                                        </span>
                                    </div>
                                    <div class="row"></div>
                                    <br />
                                    <div class="col-md-6 d-flex align-items-center">
                                        <label class="mr-2">Employment Status</label><br>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="employment_status"
                                                id="employment_status_employed" value="Employed"
                                                {{ strtolower($profile['employment_status']) == 'employed' ? 'checked' : '' }}
                                                onclick="toggleEmploymentStatus('Employed')" readonly>
                                            <label for="employment_status_employed" class="ml-2">Employed</label>
                                        </span>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="employment_status"
                                                id="employment_status_unemployed" value="Unemployed"
                                                {{ strtolower($profile['employment_status']) == 'unemployed' ? 'checked' : '' }}
                                                onclick="toggleEmploymentStatus('Unemployed')" readonly>
                                            <label for="employment_status_unemployed" class="ml-2">Unemployed</label>
                                        </span>
                                        <span style="padding-right: 10px;">
                                            <input type="checkbox" name="employment_status"
                                                id="employment_status_self_employed" value="Self-Employed"
                                                {{ strtolower($profile['employment_status']) == 'self-employed' ? 'checked' : '' }}
                                                onclick="toggleEmploymentStatus('Self-Employed')" readonly>
                                            <label for="emp_status_self_employed" class="ml-2">Self-Employed</label>
                                        </span>
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
                                <br>
                            </div>
                            <div class="col-md-12" style="display: flex; align-items: center; ">
                                <table class="table table-bordered">
                                    <tbody style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                        <tr>
                                            <td>2.1 Chest Pain</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="chest_pain_yes"
                                                    name="ar_chest_pain"
                                                    onclick="toggleCheckbox('chest_pain_yes', 'chest_pain_no')"
                                                    {{ strtolower($riskForm['ar_chest_pain']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="healthCheckbox" id="chest_pain_no"
                                                    name="ar_chest_pain"
                                                    onclick="toggleCheckbox('chest_pain_no', 'chest_pain_yes')"
                                                    {{ strtolower($riskForm['ar_chest_pain']) == 'no' ? 'checked' : '' }}> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.2 Difficulty of Breathing</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox"
                                                    id="difficulty_breathing_yes" name="ar_difficulty_breathing"
                                                    onclick="toggleCheckbox('difficulty_breathing_yes', 'difficulty_breathing_no')"
                                                    {{ strtolower($riskForm['ar_difficulty_breathing']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox"
                                                    id="difficulty_breathing_no" name="ar_difficulty_breathing"
                                                    onclick="toggleCheckbox('difficulty_breathing_no', 'difficulty_breathing_yes')"
                                                    {{strtolower($riskForm['ar_difficulty_breathing']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.3 Loss of Consciousness</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="loss_con_yes"
                                                    name="ar_loss_of_consciousness"
                                                    onclick="toggleCheckbox('loss_con_yes', 'loss_con_no')"
                                                    {{ strtolower($riskForm['ar_loss_of_consciousness']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="loss_con_no"
                                                    name="ar_loss_of_consciousness"
                                                    onclick="toggleCheckbox('loss_con_no', 'loss_con_yes')"
                                                    {{ strtolower($riskForm['ar_loss_of_consciousness']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.4 Slurred Speech</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="slurred_yes"
                                                    name ="ar_slurred_speech"
                                                    onclick="toggleCheckbox('slurred_yes', 'slurred_no')"
                                                    {{ strtolower($riskForm['ar_slurred_speech']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="slurred_no"
                                                    name="ar_slurred_speech"
                                                    onclick="toggleCheckbox('slurred_no', 'slurred_yes')"
                                                    {{ strtolower($riskForm['ar_slurred_speech']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.5 Facial Asymmetry</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="facial_yes"
                                                    name= "ar_facial_asymmetry"
                                                    onclick="toggleCheckbox('facial_yes', 'facial_no')"
                                                    {{ strtolower($riskForm['ar_facial_asymmetry']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="facial_no"
                                                    name= "ar_facial_asymmetry"
                                                    onclick="toggleCheckbox('facial_no', 'facial_yes')"
                                                    {{ strtolower($riskForm['ar_facial_asymmetry']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.6 Weakness/Numbness on arm <br> of the left on one side of the body</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="weak_numb_yes"
                                                    name="ar_weakness_numbness"
                                                    onclick="toggleCheckbox('weak_numb_yes', 'weak_numb_no')"
                                                    {{ strtolower($riskForm['ar_weakness_numbness']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="weak_numb_no"
                                                    name="ar_weakness_numbness"
                                                    onclick="toggleCheckbox('weak_numb_no', 'weak_numb_yes')"
                                                    {{ strtolower($riskForm['ar_weakness_numbness']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.7 Disoriented as to time, <br> place and person</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="disoriented_yes"
                                                    name="ar_disoriented"
                                                    onclick="toggleCheckbox('disoriented_yes', 'disoriented_no')"
                                                    {{ strtolower($riskForm['ar_disoriented']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="disNo"
                                                    name="ar_disoriented"
                                                    onclick="toggleCheckbox('disoriented_no', 'disoriented_yes')"
                                                    {{ strtolower($riskForm['ar_disoriented']) == 'no' ? 'checked' : '' }}> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.8 Chest Retractions</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="chest_retract_yes"
                                                    name="ar_chest_retractions"
                                                    onclick="toggleCheckbox('chest_retract_yes', 'chest_retract_no')"
                                                    {{ strtolower($riskForm['ar_chest_retractions']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="chest_retract_no"
                                                    name="ar_chest_retractions"
                                                    onclick="toggleCheckbox('chest_retract_no', 'chest_retract_yes')"
                                                    {{ strtolower($riskForm['ar_chest_retractions']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.9 Seizure or Convulsion</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="seizure_yes"
                                                    name="ar_seizure_convulsion"
                                                    onclick="toggleCheckbox('seizure_yes', 'seizure_no)"
                                                    {{ strtolower($riskForm['ar_seizure_convulsion']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="seizuredNo"
                                                    name="ar_seizure_convulsion"
                                                    onclick="toggleCheckbox('seizure_no', 'seizure_yes')"
                                                    {{ strtolower($riskForm['ar_seizure_convulsion']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.10 Act of self-harm or suicide</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="self_harm_yes"
                                                    name="ar_act_self_harm_suicide"
                                                    onclick="toggleCheckbox('self_harm_yes', 'self_harm_no')"
                                                    {{ strtolower($riskForm['ar_act_self_harm_suicide']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="self_harm_no"
                                                    name="ar_act_self_harm_suicide"
                                                    onclick="toggleCheckbox('self_harm_no', 'self_harm_yes')"
                                                    {{ strtolower($riskForm['ar_act_self_harm_suicide']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.11 Agitated and/or aggressive behavior</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="agitated_yes"
                                                    name="ar_agitated_behavior"
                                                    onclick="toggleCheckbox('agitated_yes', 'agitated_no')"
                                                    {{ strtolower($riskForm['ar_agitated_behavior']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="agitated_no"
                                                    name="ar_agitated_behavior"
                                                    onclick="toggleCheckbox('agitated_no', 'agitated_yes')"
                                                    {{ strtolower($riskForm['ar_agitated_behavior']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.12 Eye Injury/ Foreign Body on the eye</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="eye_injury_yes"
                                                    name="ar_eye_injury"
                                                    onclick="toggleCheckbox('eye_injury_yes', 'eye_injury_no')"
                                                    {{ strtolower($riskForm['ar_eye_injury']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="healthCheckbox" id="eye_injury_no"
                                                    name="ar_eye_injury"
                                                    onclick="toggleCheckbox('eye_injury_no', 'eye_injury_yes')"
                                                    {{ strtolower($riskForm['ar_eye_injury']) == 'no' ? 'checked' : '' }}> No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.13 Severe Injuries</td>
                                            <td>
                                                <input type="checkbox" class="healthCheckbox" id="severe_yes"
                                                name="ar_severe_injuries"
                                                    onclick="toggleCheckbox('severe_yes', 'severe_no')"
                                                    {{ strtolower($riskForm['ar_severe_injuries']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="healthCheckbox" id="severe_no"
                                                name="ar_severe_injuries"
                                                    onclick="toggleCheckbox('severe_no', 'severe_yes')"
                                                    {{ strtolower($riskForm['ar_severe_injuries']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="additional-inputs">
                            <div class="col-md-4">
                                <label for="physicianName">Physician Name:</label>
                                <input type="text" class="form-control" id="physicianName" name="physician_name"
                                    placeholder="Enter physician name"
                                    value="{{ $riskForm['ar_refer_physician_name'] ? $riskForm['ar_refer_physician_name'] : '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="reason">Reason:</label>
                                <input type="text" class="form-control" id="ar_refer_reason" name="reason"
                                    placeholder="Enter reason"
                                    value="{{ $riskForm['ar_refer_reason'] ? $riskForm['ar_refer_reason'] : '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="facility">What Facility:</label>
                                <select class="form-control" name="ar_refer_facility" id="facility"
                                    style="width: 100%; max-width: 100%;">
                                    <option value="">Select Facility...</option>
                                    @foreach ($facilities as $fact)
                                        <option value="{{ $fact->id }}"
                                            {{ $riskForm['ar_refer_facility'] == $fact->id ? 'selected' : '' }}>
                                            {{ $fact->name }} {{ $fact->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="showNextStep()">Next</button>
                            </div>
                        </div>
                    </div>
                    <!-- PAST MEDICAL HISTORY -->
                    <div class="form-step" id="form-step-2" style="display: none">
                        <div class="row">
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
                                                    id="pmh_hypertension_yes" name="pmh_hypertension"
                                                    onclick="toggleCheckbox('pmh_hypertension_yes', 'pmh_hypertension_no')"
                                                    {{ strtolower($riskForm['pmh_hypertension']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="hypertensionCheckbox"
                                                    id="pmh_hypertension_no" name="pmh_hypertension"
                                                    onclick="toggleCheckbox('pmh_hypertension_yes', 'pmh_hypertension_no')"
                                                    {{ strtolower($riskForm['pmh_hypertension']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.2 Heart Disease</td>
                                            <td>
                                                <input type="checkbox" class="heartdiseaseCheckbox"
                                                    id="pmh_heart_disease_yes" name="pmh_heart_disease"
                                                    onclick="toggleCheckbox('pmh_heart_disease_yes', 'pmh_heart_disease_no')"
                                                    {{ strtolower($riskForm['pmh_heart_disease']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="heartdiseaseCheckbox"
                                                    id="pmh_heartdisease_no" name="pmh_heart_disease"
                                                    onclick="toggleCheckbox('pmh_heart_disease_no', 'pmh_heart_disease_yes')"
                                                    {{ strtolower($riskForm['pmh_heart_disease']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.3 Diabetes</td>
                                            <td>
                                                <input type="checkbox" class="diabetesCheckbox" id="pmh_diabetes_yes"
                                                    name="pmh_diabetes"
                                                    onclick="toggleCheckbox('pmh_diabetes_yes', 'pmh_diabetes_no')"
                                                    {{ strtolower($riskForm['pmh_diabetes']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="diabetesCheckbox" id="pmh_diabetes_no"
                                                    name="pmh_diabetes"
                                                    onclick="toggleCheckbox('pmh_diabetes_no', 'pmh_diabetes_yes')"
                                                    {{ strtolower($riskForm['pmh_diabetes']) == 'no' ? 'checked' : '' }}> No
                                                <br />
                                                <textarea class="col-md-12" id="diabetesDetailsInput" name="pmh_diabetes_details"
                                                    placeholder="{{ $riskForm['pmh_specify_diabetes'] ? $riskForm['pmh_specify_diabetes'] : '' }}"></textarea>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.4 Cancer</td>
                                            <td>
                                                <input type="checkbox" class="cancerCheckbox" id="pmh_cancer_yes"
                                                    onclick="toggleCheckbox('pmh_cancer_yes', 'pmh_cancer_no')"
                                                    name= "pmh_cancer"{{ strtolower($riskForm['pmh_cancer']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="cancerCheckbox" id="pmh_cancer_no"
                                                    onclick="toggleCheckbox('pmh_cancer_no', 'pmh_cancer_yes')"
                                                    name= "pmh_cancer"
                                                    {{ strtolower($riskForm['pmh_cancer']) == 'no' ? 'checked' : '' }}> No
                                                <br />
                                                <textarea class="col-md-12" id="cancerDetailsInput" name="pmh_cancer_details"
                                                    placeholder="{{ $riskForm['pmh_specify_cancer'] ? $riskForm['pmh_specify_cancer'] : '' }}"></textarea>
                                            </td>
                                        </tr>
                                        </tr>

                                        <tr>
                                            <td>3.5 COPD</td>
                                            <td>
                                                <input type="checkbox" class="codCheckbox" id="pmh_copd_yes"
                                                    name="pmh_COPD"
                                                    onclick="toggleCheckbox('pmh_copd_yes', 'pmh_copd_no')"
                                                    {{ strtolower($riskForm['pmh_copd']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="codCheckbox" id="pmh_copd_no"
                                                    name="pmh_COPD"
                                                    onclick="toggleCheckbox('pmh_copd_no', 'pmh_copd_yes')"
                                                    {{ strtolower($riskForm['pmh_copd']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.6 Asthma</td>
                                            <td>
                                                <input type="checkbox" class="asthmaCheckbox" id="pmh_asthma_yes"
                                                    name="pmh_asthma"
                                                    onclick="toggleCheckbox('pmh_asthma_yes', 'pmh_asthma_no')"
                                                    {{ strtolower($riskForm['pmh_asthma']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="asthmaCheckbox" id="pmh_asthma_no"
                                                    name="pmh_asthma"
                                                    onclick="toggleCheckbox('pmh_asthma_no', 'pmh_asthma_yes')"
                                                    {{ strtolower($riskForm['pmh_asthma']) == 'no' ? 'checked' : '' }}> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td> 3.7 Allergies</td>
                                            <td>
                                                <input type="checkbox" class="allergiesCheckbox" id="pmh_allergies_yes"
                                                    name="pmh_allergies"
                                                    onclick="toggleCheckbox('pmh_allergies_yes', 'pmh_allergies_no')"
                                                    {{ strtolower($riskForm['pmh_allergies']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="allergiesCheckbox" id="pmh_allergies_no"
                                                    name="pmh_allergies"
                                                    onclick="toggleCheckbox('pmh_allergies_no', 'pmh_allergies_yes')"
                                                    {{ strtolower($riskForm['pmh_allergies']) == 'no' ? 'checked' : '' }}> No
                                                <br />
                                                <textarea class="col-md-12" id="allergiesDetailsInput" name="pmh_allergies_details"
                                                    placeholder="{{ $riskForm['pmh_specify_allergies'] ? $riskForm['pmh_specify_allergies'] : '' }}"></textarea>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.8 Mental, Neurological, and Substance-Abuse Disorder</td>
                                            <td>
                                                <input type="checkbox" class="mnsCheckbox" id="pmh_mns_yes"
                                                    name ="pmh_mnsad"
                                                    onclick="toggleCheckbox('pmh_mns_yes', 'pmh_mns_no')"
                                                    {{ strtolower($riskForm['pmh_mn_and_s_disorder']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="mnsCheckbox" id="pmh_mnsNo"
                                                    name ="pmh_mnsad"
                                                    onclick="toggleCheckbox('pmh_mns_no', 'pmh_mns_yes')"
                                                    {{ strtolower($riskForm['pmh_mn_and_s_disorder']) == 'no' ? 'checked' : '' }}>
                                                No
                                                <br />
                                                <textarea class="col-md-12" id="mnsDetailsInput" name="pmh_mnsad_details"
                                                    placeholder="{{ $riskForm['pmh_specify_mn_and_s_disorder'] ? $riskForm['pmh_specify_mn_and_s_disorder'] : '' }}"></textarea>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.9 Vision Problems</td>
                                            <td>
                                                <input type="checkbox" class="visionCheckbox" id="pmh_vision_yes"
                                                    name= "pmh_vision"
                                                    onclick="toggleCheckbox('pmh_vision_yes', 'pmh_vision_no')"
                                                    {{ strtolower($riskForm['pmh_vision_problems']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="visionCheckbox" id="pmh_visionNo"
                                                    name= "pmh_vision"
                                                    onclick="toggleCheckbox('pmh_vision_no', 'pmh_vision_yes')"
                                                    {{ strtolower($riskForm['pmh_vision_problems']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.10 Previous Surgical History</td>
                                            <td>
                                                <input type="checkbox" class="surgicalhistoryCheckbox"
                                                    id="pmh_surgical_history_yes" name="pmh_psh"
                                                    onclick="toggleCheckbox('pmh_surgical_history_yes', 'pmh_surgical_history_no')"
                                                    {{ strtolower($riskForm['pmh_previous_surgical']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="surgicalhistoryCheckbox"
                                                    id="pmh_surgicalhistoryNo"
                                                    onclick="toggleCheckbox('pmh_surgical_history_no', 'pmh_surgical_history_yes')"
                                                    {{ strtolower($riskForm['pmh_previous_surgical']) == 'no' ? 'checked' : '' }}>
                                                No
                                                <br />
                                                <textarea class="col-md-12" id="surgicalDetailsInput" name="pmh_psh_details"
                                                    placeholder="{{ $riskForm['pmh_specify_previous_surgical'] ? $riskForm['pmh_specify_previous_surgical'] : '' }}"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.11 Thyroid Disorders</td>
                                            <td>
                                                <input type="checkbox" class="thyroidCheckbox" id="pmh_thyroid_yes"
                                                    onclick="toggleCheckbox('pmh_thyroid_yes', 'pmh_thyroid_no')"
                                                    {{ strtolower($riskForm['pmh_thyroid_disorders']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="thyroidCheckbox" id="pmh_thyroid_no"
                                                    onclick="toggleCheckbox('pmh_thyroid_no', 'pmh_thyroid_yes')"
                                                    {{ strtolower($riskForm['pmh_thyroid_disorders']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>3.12 Kidney Disorders</td>
                                            <td>
                                                <input type="checkbox" class="kidneyCheckbox" id="pmh_kidney_yes"
                                                    name="pmh_kidney"
                                                    onclick="toggleCheckbox('pmh_kidney_yes', 'pmh_kidney_no')"
                                                    {{ strtolower($riskForm['pmh_kidney_disorders']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="kidneyCheckbox" id="pmh_kidney_no"
                                                    name="pmh_kidney"
                                                    onclick="toggleCheckbox('pmh_kidney_no', 'pmh_kidney_yes')"
                                                    {{ strtolower($riskForm['pmh_kidney_disorders']) == 'no' ? 'checked' : '' }}>
                                                No
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
                                                    name="fmh_hypertension"
                                                    onclick="toggleCheckbox('fmh_hypertension_yes', 'fmh_hypertension_no')"
                                                    {{ strtolower($riskForm['fmh_hypertension']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="hyperCheckbox" id="fmh_hypertension_no"
                                                    name="fmh_hypertension"
                                                    onclick="toggleCheckbox('loss_con_no', 'loss_con_yes')"
                                                    {{ strtolower($riskForm['fmh_hypertension']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.2 Stroke</td>
                                            <td>
                                                <input type="checkbox" class="strokeCheckbox" id="fmh_stroke_yes"
                                                    name="fmh_stroke"
                                                    onclick="toggleCheckbox('fmh_stroke_yes', 'fmh_stroke_no')"
                                                    {{ strtolower($riskForm['fmh_stroke']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="strokeCheckbox" id="fmh_strokeNo"
                                                    name="fmh_stroke"
                                                    onclick="toggleCheckbox('fmh_stroke_no', 'fmh_stroke_yes')"
                                                    {{ strtolower($riskForm['fmh_stroke']) == 'no' ? 'checked' : '' }}> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.3 Heart Disease (change from "Cardiovascular") </td>
                                            <td>
                                                <input type="checkbox" class="heartdisCheckbox" id="fmh_heart_disease_yes"
                                                    name="fmh_heart_disease"
                                                    onclick="toggleCheckbox('fmh_heart_disease_yes', 'fmh_heart_disease_no')"
                                                    {{ strtolower($riskForm['fmh_heart_disease']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="heartdisCheckbox" id="fmh_heart_disease_no"
                                                    name="fmh_heart_disease"
                                                    onclick="toggleCheckbox('fmh_heart_disease_no', 'fmh_heart_disease_yes')"
                                                    {{ strtolower($riskForm['fmh_heart_disease']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.4 Diabetes Mellitus</td>
                                            <td>
                                                <input type="checkbox" class="diabetesmelCheckbox"
                                                    id="fmh_diabetes_mel_yes"
                                                    name="fmh_diabetes_mellitus"
                                                    onclick="toggleCheckbox('fmh_diabetes_mel_yes', 'fmh_diabetes_mel_no')"
                                                    {{ strtolower($riskForm['fmh_diabetes_mellitus']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="diabetesMelCheckbox" id="fmh_diabetes_mel_no"
                                                name="fmh_diabetes_mellitus"    
                                                onclick="toggleCheckbox('fmh_diabetes_mel_no', 'fmh_diabetes_mel_yes')"
                                                    {{ strtolower($riskForm['fmh_diabetes_mellitus']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4.5 Asthma</td>
                                            <td>
                                                <input type="checkbox" class="asthmasCheckbox" id="fmh_asthma_yes"
                                                    onclick="toggleCheckbox('fmh_asthma_yes', 'fmh_asthma_no')"
                                                    {{ strtolower($riskForm['fmh_asthma']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="asthmas_Checkbox" id="fmh_asthma_no"
                                                    onclick="toggleCheckbox('fmh_asthma_no', 'fmh_asthma_yes')"
                                                    {{ strtolower($riskForm['fmh_asthma']) == 'no' ? 'checked' : '' }}> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.6 Cancer</td>
                                            <td>
                                                <input type="checkbox" class="cancerCheckbox" id="fmh_cancer_yes"
                                                    onclick="toggleCheckbox('fmh_cancer_yes', 'fmh_cancer_no')"
                                                    {{ strtolower($riskForm['fmh_cancer']) == 'yes' ? 'checked' : '' }}> Yes
                                                <input type="checkbox" class="cancerCheckbox" id="fmh_cancer_no"
                                                    onclick="toggleCheckbox('fmh_cancer_no', 'fmh_cancer_yes')"
                                                    {{ strtolower($riskForm['fmh_cancer']) == 'no' ? 'checked' : '' }}> No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td> 4.7 Kidney Disease </td>
                                            <td>
                                                <input type="checkbox" class="kidneyDiseaseCheckbox" name="fmh_kidney" id="fmh_kidney_disease_yes"
                                                    onclick="toggleCheckbox('fmh_kidney_disease_yes', 'fmh_kidney_disease_no')"
                                                    {{ strtolower($riskForm['fmh_kidney_disease']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="kidneyDiseaseCheckbox" id="fmh_kidney_disNo"
                                                    onclick="toggleCheckbox('fmh_kidney_disease_no', 'fmh_kidney_disease_yes')"
                                                    {{ strtolower($riskForm['fmh_kidney_disease']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>4.8 1st Degree relative with premature coronary <br> disease or vascular
                                                disease <br> (includes "Heart Attack")</td>
                                            <td>
                                                <input type="checkbox" class="degreerelativeCheckbox"
                                                    id="fmh_degree_relative_yes" name="fmh_first_degree"
                                                    onclick="toggleCheckbox('fmh_degree_relative_yes', 'fmh_degree_relative_no')"
                                                    {{ strtolower($riskForm['fmh_first_degree_relative']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="degreerelativeCheckbox"
                                                    id="fmh_degree_relative_no" name="fmh_first_degree"
                                                    onclick="toggleCheckbox('fmh_degree_relative_no', 'fmh_degree_relative_yes')"
                                                    {{ strtolower($riskForm['fmh_first_degree_relative']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4.9 Family having TB in the last 5 years </td>
                                            <td>
                                                <input type="checkbox" class="familytbCheckbox" id="fmh_family_tb_yes"
                                                    name="fmh_famtb"
                                                    onclick="toggleCheckbox('fmh_family_tb_yes', 'fmh_family_tb_no')"
                                                    {{ strtolower($riskForm['fmh_having_tuberculosis_5_years']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="familytbCheckbox" id="fmh_family_tb_no"
                                                    name="fmh_famtb"
                                                    onclick="toggleCheckbox('fmh_family_tb_no', 'fmh_family_tb_yes')"
                                                    {{ strtolower($riskForm['fmh_having_tuberculosis_5_years']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4.10 Mental, Neuroligical and Substance Abuse Disorder</td>
                                            <td>
                                                <input type="checkbox" class="mnsadCheckbox" id="fmh_mnsad_yes"
                                                    name="fmh_mnsad"
                                                    onclick="toggleCheckbox('fmh_mnsad_yes', 'fmh_mnsad_no')"
                                                    {{ strtolower($riskForm['fmh_mn_and_s_disorder']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="mnsadCheckbox" id="fmh_mnsad_no"
                                                    name="fmh_mnsad"
                                                    onclick="toggleCheckbox('fmh_mnsad_no', 'fmh_mnsad_yes')"
                                                    {{ strtolower($riskForm['fmh_mn_and_s_disorder']) == 'no' ? 'checked' : '' }}>
                                                No
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4.11 COPD</td>
                                            <td>
                                                <input type="checkbox" class="COPCheckbox" id="fmh_copd_yes"
                                                    onclick="toggleCheckbox('fmh_copd_yes', 'fmh_copd_no')" value="Yes"
                                                    {{ strtolower($riskForm['fmh_copd']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="COPCheckbox" id="fmh_copd_no" value="No"
                                                    onclick="toggleCheckbox('fmh_copd_no', 'fmh_copd_yes')"
                                                    {{ strtolower($riskForm['fmh_copd']) == 'no' ? 'checked' : '' }}> No
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
                                    onclick="showNextStep()">Next</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" id="form-step-3" style="display: none">
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
                                            <td>5.1 Tobacco Use</td>
                                            <td>
                                                <!-- Never Used (proceed to Q2) checkbox -->
                                                <input type="checkbox" class="tobaccoCheckbox" id="q1"
                                                    name="tobaccoUse[]"
                                                    {{ strpos($riskForm['rf_tobacco_use'], 'q1') !== false ? 'checked' : '' }}>
                                                Never Used (proceed to Q2) <br>

                                                <!-- Exposure to secondhand smoke checkbox -->
                                                <input type="checkbox" class="tobaccoCheckbox" id="q2"
                                                    name="tobaccoUse[]"
                                                    {{ strpos($riskForm['rf_tobacco_use'], 'q2') !== false ? 'checked' : '' }}>
                                                Exposure to secondhand smoke <br>

                                                <!-- Former tobacco user checkbox -->
                                                <input type="checkbox" class="tobaccoCheckbox" id="q3"
                                                    name="tobaccoUse[]"
                                                    {{ strpos($riskForm['rf_tobacco_use'], 'q3') !== false ? 'checked' : '' }}>
                                                Former tobacco user (stopped smoking > 1 year) <br>

                                                <!-- Current tobacco user checkbox -->
                                                <input type="checkbox" class="tobaccoCheckbox" id="q4"
                                                    name="tobaccoUse[]"
                                                    {{ strpos($riskForm['rf_tobacco_use'], 'q4') !== false ? 'checked' : '' }}>
                                                Current tobacco user (currently smoking or stopped smoking) <br><br>

                                                <p style="font-style: italic; font-size: 15px;">
                                                    If YES to Q2-Q4, follow the tobacco cessation protocol (5As) and use
                                                    Form 1. Tobacco Cessation Referral Protocol, if needed.
                                                </p>
                                            </td>
                                        </tr>
                                        <td>5.2 Alcohol Intake</td>
                                        <td>
                                            <input type="checkbox" class="alcoholCheckbox" id="alcoholNever"
                                                name="ncd_alcohol"
                                                {{ strtolower($riskForm['rf_alcohol_intake']) == 'no' ? 'checked' : '' }}>
                                            Never Consumed
                                            <input type="checkbox" class="alcoholCheckbox" id="alcoholYes"
                                                name="ncd_alcohol"
                                                {{ strtolower($riskForm['rf_alcohol_intake']) == 'yes' ? 'checked' : '' }}>
                                            Yes, drinks alcohol

                                            <br><br>
                                            <label id="bingeLabel" class="ml-2">
                                                <input type="checkbox" class="alcoholCheckbox" id="alcoholBinge"
                                                    name="ncd_alcoholBinge"
                                                    {{ strtolower($riskForm['rf_alcohol_binge_drinker']) == 'yes' ? 'checked' : '' }}>
                                                Do you drink 5 or more standard drinks for men, and 4 or more for women (in
                                                one sitting/occasion) in the past year?
                                            </label>
                                            <br><br>

                                            <p style="font-style: italic; font-size: 15px;">
                                                If NO, congratulate the patient. The patient is at a lower risk of drinking
                                                alcohol.<br>
                                                If YES, proceed using AUDIT SCREENING TOOL (Form 2) to assess alcohol
                                                consumption and alcohol problems.
                                                If binge drinker, provide brief advice and/or extended brief advice. The
                                                patient is on the higher risk category level of drinking or in harmful use
                                                of alcohol.
                                            </p>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>5.3 Physical Activity </td>
                                            <td>
                                                Does the patient do at least 2.5 hours a week of moderate-intensity physical
                                                activity? <br><br>
                                                <input type="checkbox" class="physicalCheckbox" id="physical_yes"
                                                    name="ncd_physical"
                                                    {{ strtolower($riskForm['rf_physical_activity']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="physicalCheckbox" id="physical_no"
                                                    name="ncd_physical"
                                                    {{ strtolower($riskForm['rf_physical_activity']) == 'no' ? 'checked' : '' }}>
                                                No
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
                                            <td>5.4 Nutrition and Dietary Assessment </td>
                                            <td>
                                                Does the patient eat high fat, high salt food,(processed/fast food such as
                                                instant <br> noodles, burgers, fries, dried fish),
                                                "ihaw-ihaw/fried" (e.g isaw, barbecue, liver, chicken skin)and high sugar
                                                food and drinks (e.g chocolates, cakes, pastries, softdrinks) weekly?
                                                <br><br><br>
                                                <input type="checkbox" class="nutritionDietCheckbox"
                                                    id="nutrition_diet_yes"
                                                    {{ strtolower($riskForm['rf_nutrition_dietary']) == 'yes' ? 'checked' : '' }}>
                                                Yes
                                                <input type="checkbox" class="nutritionDietCheckbox" id="nutritionDietNo"
                                                    {{ strtolower($riskForm['rf_nutrition_dietary']) == 'no' ? 'checked' : '' }}>
                                                No
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
                                                <input type="text" class="textbox" id="weight" name="rf_weight"
                                                    oninput="calculateBMI()"
                                                    value="{{ $riskForm['rf_weight'] ? $riskForm['rf_weight'] : '' }}">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                5.6 Height (cm)
                                            </td>
                                            <td>
                                                <input type="text" class="textbox" id="height" name="rf_height"
                                                    oninput="calculateBMI()"
                                                    value="{{ $riskForm['rf_height'] ? $riskForm['rf_height'] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                5.7 Body Mass Index (wt.[kgs]/ht[cm]x 10,000):
                                            </td>
                                            <td>
                                                <input type="text" class="textbox" id="bmi"
                                                    value="{{ $riskForm['rf_body_mass'] ? $riskForm['rf_body_mass'] : '' }}"
                                                    name="rf_bmi">
                                                <p><i><span style="font-size: 13.5px; font-weight: 300; padding-left: 5px;"
                                                            id="bmiStrVal"></span></i></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                5.8 Waist Circumference (cm): F < 80cm M < 90 </td>
                                            <td>
                                                <input type="text" class="textbox" id="waist" name ="rf_waist"
                                                    value="{{ $riskForm['rf_waist_circumference'] ? $riskForm['rf_waist_circumference'] : '' }}">
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
                                    onclick="showNextStep()">Next</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" id="form-step-4" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <h4 class="patient-font mt-4"
                                        style="background-color: #727DAB; color: white; padding: 3px; margin-top: -10px;">
                                        VI. RISK SCREENING
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
                                                        style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                        value="{{ $riskForm['rs_systolic_t1'] ? $riskForm['rs_systolic_t1'] : '' }}">
                                                </div>
                                                <div style="margin-bottom: 10px; display: flex; flex-direction: column;">
                                                    <label>Diastolic:</label>
                                                    <input type="text" name="diastolic_t1"
                                                        style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                        value="{{ $riskForm['rs_diastolic_t1'] ? $riskForm['rs_diastolic_t1'] : '' }}">
                                                </div>
                                            </div>
                                            <br>
                                            <label>Second Measurement</label>
                                            <div style="display:flex">
                                                <div style="margin-bottom: 10px; display: flex; flex-direction: column;">
                                                    <label>Systolic:</label>
                                                    <input type="text" name="systolic_t2"
                                                        style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                        value="{{ $riskForm['rs_systolic_t2'] ? $riskForm['rs_systolic_t2'] : '' }}">
                                                </div>
                                                <div style="margin-bottom: 10px; display: flex; flex-direction: column;">
                                                    <label>Diastolic:</label>
                                                    <input type="text" name="diastolic_t2"
                                                        style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                        value="{{ $riskForm['rs_diastolic_t2'] ? $riskForm['rs_diastolic_t2'] : '' }}">
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
                                                <input type="text" name="fbs_result"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_blood_sugar_fbs'] ? $riskForm['rs_blood_sugar_fbs'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>RBS Result:</label>
                                                <input type="text" name="rbs_result" id="rbs_result"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_blood_sugar_rbs'] ? $riskForm['rs_blood_sugar_rbs'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Date Taken:</label>
                                                <input type="date" id="blood_sugar_date_taken" name="blood_sugar_date_taken"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_blood_sugar_date_taken'] ? $riskForm['rs_blood_sugar_date_taken'] : '' }}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 10px; font-weight: bold;">
                                            Check if Blood Sugar Symptoms are present
                                        </td>
                                        <td style="border: 1px solid #000; padding: 10px;">
                                            <input type="checkbox" name="rs_blood_sugar_symptoms[]" value="symptom1"
                                                {{ in_array('polyphagia', explode(', ', $riskForm['rs_blood_sugar_symptoms'] ? $riskForm['rs_blood_sugar_symptoms'] : '')) ? 'checked' : '' }}>
                                            Polyphagia

                                            <input type="checkbox" name="rs_blood_sugar_symptoms[]" value="symptom2"
                                                {{ in_array('polydipsia', explode(', ', $riskForm['rs_blood_sugar_symptoms'] ? $riskForm['rs_blood_sugar_symptoms'] : '')) ? 'checked' : '' }}>
                                            Polydipsia

                                            <input type="checkbox" name="rs_blood_sugar_symptoms[]" value="symptom3"
                                                {{ in_array('polyuria', explode(', ', $riskForm['rs_blood_sugar_symptoms'] ? $riskForm['rs_blood_sugar_symptoms'] : '')) ? 'checked' : '' }}>
                                            Polyuria
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
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_lipid_cholesterol'] ? $riskForm['rs_lipid_cholesterol'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>HDL:</label>
                                                <input type="text" name="lipid_hdl"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_lipid_hdl'] ? $riskForm['rs_lipid_hdl'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>LDL:</label>
                                                <input type="text" name="lipid_ldl"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_lipid_ldl'] ? $riskForm['rs_lipid_ldl'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>VLDL:</label>
                                                <input type="text" name="lipid_vldl"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_lipid_vldl'] ? $riskForm['rs_lipid_vldl'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Triglyceride:</label>
                                                <input type="text" name="lipid_triglyceride"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_lipid_triglyceride'] ? $riskForm['rs_lipid_triglyceride'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Date Taken:</label>
                                                <input type="date" name="lipid_date_taken"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_lipid_date_taken'] ? $riskForm['rs_lipid_date_taken'] : '' }}">
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
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_urine_protein'] ? $riskForm['rs_urine_protein'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Date Taken:</label>
                                                <input type="date" name="uri_protein_date_taken"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_urine_protein_date_taken'] ? $riskForm['rs_urine_protein_date_taken'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Ketones:</label>
                                                <input type="text" name="uri_ketones"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_urine_ketones'] ? $riskForm['rs_urine_ketones'] : '' }}">
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                <label>Date Taken:</label>
                                                <input type="date" name="uri_ketones_date_taken"
                                                    style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                                    value="{{ $riskForm['rs_urine_ketones_date_taken'] ? $riskForm['rs_urine_ketones_date_taken'] : '' }}">
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
                                                        {{ in_array('Breathlessness', explode(', ', $riskForm['rs_chronic_respiratory_disease'] ? $riskForm['rs_chronic_respiratory_disease'] : '')) ? 'checked' : '' }}>
                                                    Breathlessness (or a 'need for air')
                                                </label>
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_sputum_production"
                                                        {{ in_array('Sputum (mucous) production', explode(', ', $riskForm['rs_chronic_respiratory_disease'] ? $riskForm['rs_chronic_respiratory_disease'] : '')) ? 'checked' : '' }}>
                                                    Sputum (mucous) production
                                                </label>
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_chronic_cough"
                                                        {{ in_array('Chronic cough', explode(', ', $riskForm['rs_chronic_respiratory_disease'] ? $riskForm['rs_chronic_respiratory_disease'] : '')) ? 'checked' : '' }}>
                                                    Chronic cough
                                                </label>
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_chest_tightness"
                                                        {{ in_array('Chest tightness', explode(', ', $riskForm['rs_chronic_respiratory_disease'] ? $riskForm['rs_chronic_respiratory_disease'] : '')) ? 'checked' : '' }}>
                                                    Chest tightness
                                                </label>
                                                <label style="margin-right: 20px;">
                                                    <input type="checkbox" name="symptom_wheezing"
                                                        {{ in_array('Wheezing', explode(', ', $riskForm['rs_chronic_respiratory_disease'] ? $riskForm['rs_chronic_respiratory_disease'] : '')) ? 'checked' : '' }}>
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
                                                        {{ in_array('20% change from baseline (consider Probable Asthma)', explode(', ', $riskForm['rs_if_yes_any_symptoms'] ? $riskForm['rs_if_yes_any_symptoms'] : '')) ? 'checked' : '' }}>
                                                    &gt; 20% change from baseline (consider Probable Asthma)
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="pefr_below_20_percent"
                                                        {{ in_array('20% change from baseline (consider Probable COPD)', explode(', ', $riskForm['rs_if_yes_any_symptoms'] ? $riskForm['rs_if_yes_any_symptoms'] : '')) ? 'checked' : '' }}>
                                                    &lt; 20% change from baseline (consider Probable COPD)
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="showPreviousStep()">Previous</button>
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="showNextStep()">Next</button>
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
                                                    <label style="font-weight: bold;">a. Anti-Hypertensives:</label>
                                                    <div style="display: flex; gap: 10px; margin-top: 5px;">
                                                        @foreach (['Yes', 'No', 'Unknown'] as $option)
                                                            <label>
                                                                <input type="radio" name="anti_hypertensives"
                                                                    value="{{ strtolower($option) }}"
                                                                    onchange="toggleAntiHypertensivesOptions()"
                                                                    {{ $riskForm['mngm_med_hypertension'] === $option ? 'checked' : '' }}>
                                                                {{ $option }}
                                                            </label>
                                                        @endforeach
                                                    </div>

                                                    <div id="antiHypertensivesOptions"
                                                        style="display: {{ $riskForm['mngm_med_hypertension'] === 'yes' ? 'block' : 'none' }}">
                                                        <input type="text" name="anti_hypertensives_specify"
                                                            value="{{ $riskForm['mngm_med_hypertension_specify'] }}"
                                                            placeholder="Specify medicine"
                                                            style="width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                                    </div>
                                                </div>

                                                <!-- Anti-Diabetes Section -->
                                                <div style="margin: 10px;">
                                                    <label style="font-weight: bold;">b. Anti-Diabetes:</label>
                                                    <div style="display: flex; gap: 10px; margin-top: 5px;">
                                                        @foreach (['Yes', 'No', 'Unknown'] as $option)
                                                            <label>
                                                                <input type="radio" name="anti_diabetes"
                                                                    value="{{ strtolower($option) }}"
                                                                    {{ $riskForm['mngm_med_diabetes'] === $option ? 'checked' : '' }}>
                                                                {{ $option }}
                                                            </label>
                                                        @endforeach
                                                    </div>

                                                    <div id="antiDiabetesOptions"
                                                        style="display: {{ $riskForm['mngm_med_diabetes'] === 'yes' ? 'block' : 'none' }}">
                                                        <div style="display: flex; gap: 10px; margin-top: 5px;">
                                                            @foreach (['Oral Hypoglycemic', 'Insulin', 'Not Known', 'Others'] as $subOption)
                                                                <label>
                                                                    @php
                                                                        // Clean and prepare both the option and the stored value for comparison
                                                                        $optionValue = strtolower(
                                                                            str_replace(' ', '_', $subOption),
                                                                        );
                                                                        $storedValue = strtolower(
                                                                            str_replace(
                                                                                ' ',
                                                                                '_',
                                                                                $riskForm->mngm_med_diabetes_options,
                                                                            ),
                                                                        );
                                                                    @endphp
                                                                    <input type="radio" name="anti_diabetes_type"
                                                                        value="{{ $optionValue }}"
                                                                        {{ $storedValue === $optionValue ? 'checked' : '' }}>
                                                                    {{ $subOption }}
                                                                </label>
                                                            @endforeach

                                                        </div>

                                                        <input type="text" name="anti_diabetes_specify"
                                                            value="{{ $riskForm['mngm_med_diabetes_specify'] }}"
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
                                                    value="{{ $riskForm['mngm_date_follow_up'] }}"
                                                    style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 8px;">
                                            </td>
                                        </tr>

                                        <!-- Remarks Section -->
                                        <tr>
                                            <td style="font-weight: bold; padding: 10px;">Remarks</td>
                                            <td>
                                                <textarea name="remarks" rows="3"
                                                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">{{ $riskForm['mngm_remarks'] }} </textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                </table>
                            </div>
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button type="button" class="btn btn-primary mx-2"
                                    onclick="showPreviousStep()">Previous</button>
                                <a href="{{ route('patientRisk') }}" class="btn btn-success mx-2">Return to Menu</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    input[type="checkbox"],
    .ml-2,
    .checkbox-group {
        pointer-events: none;
    }
</style>
