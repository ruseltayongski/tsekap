@extends('client')
@section('content')
    <style>
        .family {
            font-size: 0.9em;
        }
        .family label {
            font-weight: bold;
        }
        .family .info {
            color: #337ab7;
        }
        .family .sub-info {
            font-style: italic;
            color: #a94442;
        }
    </style>
    <div class="row " style="color:rgba(0,0,0,0.75);">
        <div class="col-md-12">
            <div class="alert alert-jim">
                <h3 class="text-green">Dengvaxia Vaccinee Health Profile</h3>
                <div class="row">
                    <div class="col-md-6">
                        <small class="label bg-green" style="font-size: 12pt">GENERAL INFORMATION</small>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <b>DENGVAXIA RECIPIENT NUMBER:</b> <input type="text">
                        </div>
                    </div>
                </div>
                
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <b>Individual Vaccination Card</b><br>
                            <small><b>Name of Vacinee</b></small><br>
                            <small class=" ">Last Name</small>
                            <input type="text" class="form-control" name="lname">
                        </td>
                        <td>
                            <br><br>
                            <small class=" ">First Name</small>
                            <input type="text" class="form-control" name="fname">
                        </td>
                        <td style="width: 10%">
                            <br><br>
                            <small class=" ">MI</small>
                            <input type="text" class="form-control" name="mi">
                        </td>
                        <td style="width: 10%" colspan="2">
                            <br><br>
                            <small class=" ">Ext</small>
                            <input type="text" class="form-control" name="ext">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small class=" ">Relation to household head</small>
                            <input type="text" class="form-control" name="relation">
                        </td>
                        <td>
                            <small class=" ">Respondent</small>
                            <input type="text" class="form-control" name="respondent">
                        </td>
                        <td colspan="3">
                            <small class=" ">Contact No</small>
                            <input type="text" class="form-control" name="contact_no">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small><b>Address</b></small><br>
                            <small class=" ">House No. & Street Name</small>
                            <input type="text" class="form-control" name="house_and_street">
                        </td>
                        <td>
                            <br>
                            <small class=" ">Sitio/Purok</small>
                            <input type="text" class="form-control" name="purok">
                        </td>
                        <td >
                            <br>
                            <small class=" ">Barangay</small>
                            <select name="barangay" class="form-control">
                                @foreach(\App\Barangay::get() as $row)
                                    <option value="{{ $row->id }}">{{ $row->description }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td >
                            <br>
                            <small class=" ">Municipality</small>
                            <select name="municipality" class="form-control">
                                @foreach(\App\Muncity::get() as $row)
                                    <option value="{{ $row->id }}">{{ $row->description }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td >
                            <br>
                            <small class=" ">Province</small>
                            <select name="province" class="form-control">
                                @foreach(\App\Province::get() as $row)
                                    <option value="{{ $row->id }}">{{ $row->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" ">Sex</small>
                            <select name="sex" class="form-control">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </td>
                        <td style="width: 10%">
                            <small class=" ">Age</small>
                            <input type="text" name="age" class="form-control">
                        </td>
                        <td >
                            <small class=" ">Religion</small><br>
                            <input type="radio" name="religion" value="rc"> RC
                        </td>
                        <td>
                            <br>
                            <input type="radio" name="religion" value="christian"> Christian
                        </td>
                        <td>
                            <br>
                            <input type="radio" name="religion" value="inc"> INC
                        </td>
                        <td>
                            <br>
                            <input type="radio" name="religion" value="islam"> Islam
                        </td>
                        <td>
                            <br>
                            <input type="radio" name="religion" value="jehovah"> Jehovah
                        </td>
                        <td>
                            <br>
                            <small>Others, specify</small>
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" ">Birthdate</small>
                            <input type="text" name="dob" class="form-control">
                        </td>
                        <td>
                            <small class=" ">Birthplace(Mun/City/Prov)</small>
                            <input type="text" name="birthplace" class="form-control">
                        </td>
                        <td >
                            <small class=" ">Yrs. at Current Address</small>
                            <input type="text" name="yrs_current_address" class="form-control">
                        </td>
                    </tr>
                </table>
                <small class="label bg-green" style="font-size: 12pt">LEVEL OF EDUCATION</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <input type="radio" name="level_education"> Elementary
                        </td>
                        <td>
                            <input type="radio" name="level_education"> High School
                        </td>
                        <td>
                            <input type="radio" name="level_education"> Vocational
                        </td>
                        <td>
                            <input type="radio" name="level_education"> No Completed Schooling
                        </td>
                    </tr>
                </table>
                <small class="label bg-green" style="font-size: 12pt;">PHIC MEMBERSHIP OF PRINCIPAL(PARENTS)</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <small><b>Status</b></small><br>
                            <input type="checkbox" name="phic_status"> Member
                        </td>
                        <td>
                            <br>
                            <input type="checkbox" name="phic_status"> Dependent
                        </td>
                        <td>
                            <br>
                            <input type="checkbox" name="phic_status"> Non-Member
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px;">
                    <tr>
                        <td>
                            <small><b>Type</b></small><br>
                            <input type="radio" name="phic_type"> Lifetime<br>
                        </td>
                        <td>
                            <br>
                            <input type="radio" name="phic_type"> Sponsored Specify:
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> DOH
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> PLGU
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> MLGU
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Private
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Others, specify: <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px;">
                    <tr>
                        <td>
                            <small><b>Employed</b></small><br>
                            <input type="radio" name="phic_employed"> Government
                        </td>
                        <td>
                            <br>
                            <input type="radio" name="phic_employed"> Private
                        </td>
                        <td>
                            <br>
                            <input type="radio" name="phic_employed"> Self-Employed
                        </td>
                        <td >
                            <small><b>Are you aware of your PHIC benefits?</b></small><br>
                            <select name="" id="" class="form-control">
                                <option value="">Yes</option>
                                <option value="">No</option>
                            </select>
                        </td>
                        <td>
                            <br>
                            If yes, specify: <input type="text">
                        </td>
                    </tr>
                </table>

                <small class="label bg-green" style="font-size: 12pt;">FAMILY HISTORY(Among mother, father, and siblings. Tick all that apply)</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <input type="checkbox"> Allergy, specify:
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> Epilepsy/Seizure Disorder, specify:
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Heart Disease &/ or Hearth Attack, specify:
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> Cancer, specify organ:
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Immune Deficiency Disease, specify:
                            <input type="text">
                        </td>
                        <td colspan="3">
                            <input type="checkbox"> Kidnet Disease, specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px;">
                    <tr>
                        <td>
                            <input type="checkbox"> Mental Health Condition
                        </td>
                        <td>
                            <input type="checkbox"> Asthma
                        </td>
                        <td>
                            <input type="checkbox"> Thyroid Disease
                        </td>
                        <td>
                            <input type="checkbox"> Tuberculosis
                        </td>
                    </tr>
                </table>
                <small class="label bg-green" style="font-size: 12pt;">MEDICAL HISTORY OF VACCINEE(Tick all past and present health conditions of the vaccinee.)</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <input type="checkbox"> Allergy, specify:
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> Epilepsy/Seizure Disorder, specify:
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Kidney Disease, specify:
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> Immune Deficency Disease, specify:
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Hepatitis, specify
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> Heart Disease, specify:
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Poisoning, specify:
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> STIs, specify:
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Thyroid Disease, specify:
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> Cancer, specify organ:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <input type="checkbox"> Asthma (Fill-up Brochial Asthma Section)
                        </td>
                        <td>
                            <input type="checkbox"> Tuberculosis(If yes, fill-up Tuberculosis Section)
                        </td>
                        <td>
                            <input type="checkbox"> Peptic Ulcer Disease
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Diabetes mellitus (Fill-up Diabetes Mellitus Section)
                        </td>
                        <td>
                            <input type="checkbox"> Urinary Tract Infections
                        </td>
                        <td>
                            <input type="checkbox"> Malaria
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Pneumonia
                        </td>
                        <td colspan="2">
                            <input type="checkbox"> Others, specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <small class="label bg-green" style="font-size: 12pt;">BROCHIAL ASTHMA</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <input type="checkbox"> Diagnosed &nbsp;&nbsp;&nbsp;
                            <input type="checkbox"> Not Diagnosed
                        </td>
                        <td>
                            <small class=" ">No. of attacks per week</small>
                            <input type="text">
                        </td>
                        <td>
                            <small class=" ">With Medications?</small>
                            <input type="radio" name="bro_medication" value="no"> No
                            <input type="radio" name="bro_medication" value="yes"> Yes, specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <small class="label bg-green" style="font-size: 12pt;">TUBERCULOSIS</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <small><b>Any of the following? (Tick all that apply)</b></small><br>
                            <input type="checkbox"> Weight loss
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Fever
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Lost of appetite
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Cough > 2 weeks
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Chestt pain
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Back pain
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Neck nodes
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px;">
                    <tr>
                        <td>
                            <small><b>Diagnosed with TB this year?</b></small><br>
                            <input type="radio" name="diagnosed_tb" value="yes"> Yes <input type="radio" name="diagnosed_tb" value="no"> No, if Yes, form of TB
                            <input type="text">
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> New, smear positive
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> New, smear negative
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px;">
                    <tr>
                        <td>
                            <input type="checkbox"> Relapse
                        </td>
                        <td>
                            <input type="checkbox"> Extrapulmonary, specify:
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> Clinically diagnosed
                        </td>
                        <td>
                            <input type="checkbox"> TB in children
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px;">
                    <tr>
                        <td>
                            <small><b>Labs done:</b></small><br>
                            <input type="checkbox"> PPD Result:
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Sputum Exam Result:
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> CXR Result:
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> GenXpert Result:
                            <input type="text" class="form-control">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px;">
                    <tr>
                        <td>
                            <small><b>Medications:</b></small><br>
                            <input type="checkbox"> Cat I
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Cat II
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Cat III
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> TB in children
                        </td>
                    </tr>
                </table>

                <small class="label bg-green" style="font-size: 12pt;">DISABILITY</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <input type="checkbox"> Psychosocial and Behavioral Conditions
                        </td>
                        <td>
                            <input type="checkbox"> Learning or Intellectual Disability
                        </td>
                        <td>
                            <input type="checkbox">  Mental Conditions
                        </td>
                        <td>
                            <input type="checkbox"> Visual or Seeing Impairment
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Hearing Impairment
                        </td>
                        <td>
                            <input type="checkbox"> Speech Impairment
                        </td>
                        <td>
                            <input type="checkbox"> Musculo-Skeletal or Injury Impairments
                        </td>
                        <td></td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td colspan="2">
                            <small class=" ">Give description of disability:</small>
                            <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small class=" ">With assistive device/s?</small>
                            <input type="radio" name="with_assistive" value="yes"> Yes <input type="radio" name="with_assistive" value="no"> Yes, specify:
                            <input type="text">
                        </td>
                        <td>
                            <small class=" ">Need for assistive device/s?</small>
                            <input type="radio" name="assistive_device" value="yes"> Yes <input type="radio" name="assistive_device" value="no"> Yes, specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <small class="label bg-green" style="font-size: 12pt;">INJURY</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <input type="checkbox"> Vehicular Accident/Traffic-Related Injuries
                            &nbsp;&nbsp;&nbsp;
                            <input type="checkbox"> Burns
                            &nbsp;&nbsp;&nbsp;
                            <input type="checkbox">  Drowning
                            &nbsp;&nbsp;&nbsp;
                            <input type="checkbox"> Fall
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small class=" ">Medications(List all current medicines and food supplement being taken):</small>
                            <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
                        </td>
                    </tr>
                </table>

                <small class="label bg-green" style="font-size: 12pt;">HOSPITALIZATION HISTORY</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td style="width: 20%;">
                            <small class=" ">Were you previously hospitalized?</small> &nbsp;&nbsp;
                            <input type="radio" value="yes" name="prev_hos"> Yes&nbsp;&nbsp; <input type="radio" value="no" name="prev_hos"> No
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td></td>
                        <td>Reason/Diagnosis</td>
                        <td>Date Hospitalized</td>
                        <td>Place Hospitalized</td>
                        <td>PhilHealth used? Y/N</td>
                        <td>PhilHealth used? Y/N</td>
                        <td>Cost/s not covered by PhilHealth?</td>
                    </tr>
                    <tr>
                        <td><b>1</b></td>
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                    </tr>
                    <tbody id="hospital_history_row">

                    </tbody>
                    <tr>
                        <td colspan="7">
                            <a href="#" class="pull-right" onclick="addHospitalHistory()"><i class="fa fa-plus"></i> Add row</a>
                        </td>
                    </tr>
                </table>
                <small class="label bg-green" style="font-size: 12pt;">PAST SURGICAL HISTORY</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <small class=" ">Operation</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" ">Date</small>
                            <input type="text" class="form-control" >
                        </td>
                    </tr>
                    <tbody id="past_surgical_row">

                    </tbody>
                    <tr>
                        <td colspan="2">
                            <a href="#" class="pull-right" onclick="addPastSurgicalHistory()"><i class="fa fa-plus"></i> Add row</a>
                        </td>
                    </tr>
                </table>
                <small class="label bg-green" style="font-size: 12pt;">PERSONAL/SOCIAL HISTORY</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <small class=" ">
                                <b>Smoking:</b><br>
                                Have you tried smoking?
                            </small>
                            <select name="" id="" class="form-control">
                                <option value="male">Never Smoked</option>
                                <option value="female">Current Smoker</option>
                                <option value="female">Former Smoker</option>
                                <option value="female">Secondhand Smoker</option>
                                <option value="female">Thirdhand Smoker</option>
                            </select>
                        </td>
                        <td>
                            <small class=" "><br>Age started</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" "><br>Age quit</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" "><br>No. of stick/s per day</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" "><br>No. of Pack-Years</small>
                            <input type="text" class="form-control" >
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" ">
                                <b>High Fat / High salt Intake:</b><br>
                                Do you eat fast food/street food (e.g instant noodles, canned goods, fries, fried chicken skin, etc) weekly?
                            </small>
                            <select name="" id="" class="form-control">
                                <option value="male">Yes</option>
                                <option value="female">No</option>
                            </select>
                        </td>
                        <td>
                            <small class=" ">
                                <b>Dietary Fiber Intake:</b><br>
                                Do you eat 3 servings of vegetable daily?
                            </small>
                            <select name="" id="" class="form-control">
                                <option value="male">Yes</option>
                                <option value="female">No</option>
                            </select>
                        </td>
                        <td>
                            <small class=" ">
                                <br>
                                Do you eat 2-3 servings of fruits daily?
                            </small>
                            <select name="" id="" class="form-control">
                                <option value="male">Yes</option>
                                <option value="female">No</option>
                            </select>
                        </td>
                        <td>
                            <small class=" ">
                                <b>Physical Activity</b>
                                <br>
                                Does at least 30 minutes per day of moderate - to vigorous-intensity physical activity?
                            </small>
                            <select name="" id="" class="form-control">
                                <option value="male">Yes</option>
                                <option value="female">No</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" ">
                                <b>Alcohol Intake:</b><br>
                                Have you tried drinking alcohol?</small>
                            <select name="" id="" class="form-control">
                                <option value="male">Yes</option>
                                <option value="female">No</option>
                            </select>
                        </td>
                        <td>
                            <small class=" ">
                                <br>In the past 5 months, have you drunk alcohol?
                            </small>
                            <select name="" id="" class="form-control">
                                <option value="male">Yes</option>
                                <option value="female">No</option>
                            </select>
                        </td>
                        <td>
                            <small class=" ">
                                <b>Substance Abuse:</b><br>
                                Ever tried any illicit drug/substance?
                            </small>
                            <select name="" id="" class="form-control">
                                <option value="male">Yes</option>
                                <option value="female">No</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <small class="label bg-green" style="font-size: 12pt;">MENSTRUAL AND GYNECOLOGICAL HISTORY (for female vaccinee only)</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <small class=" ">Age of Menarche</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" ">Date of Last Menstrual Period:</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" ">Duration (number of days)</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" ">Interval/Cycle</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" ">No. of pads per day</small>
                            <input type="text" class="form-control" >
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><small class=" "><b>Gyne History</b></small></td>
                    </tr>
                    <tr>
                        <td colspan="5"><small class=" ">Abnormal signs and symptoms: (tick all that apply)</small></td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <br>
                            <input type="checkbox"> Abnormal Vaginal/Utering Bleeding
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Dysmenorrhea
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Dyspareunia
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Foul-smelling vaginal discharge
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Vaginal Pruritus
                        </td>
                        <td>
                            <small class=" ">Others, specify</small>
                            <input type="text" class="form-control" >
                        </td>
                    </tr>
                </table>

                <small class="label bg-green" style="font-size: 12pt;">VACCINATION HISTORY</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td style="width: 15%">
                            <small class=" "><b>Vaccinee/s received</b></small><br>
                            <input type="checkbox"> MR
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Diphtheria/Tetanus
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> MMR
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> HPV
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Tetanus Toxoid,
                        </td>
                        <td colspan="2">
                            <small class=" ">No. of doses</small>
                            <input type="text" class="form-control" >
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    @for($i=1;$i<=3;$i++)
                    <tr>
                        <td>
                            <br>
                            <input type="checkbox"> Dengvaxia {{ $i }}
                        </td>
                        <td>
                            <small class=" ">Date received</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" ">Place Received</small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> School
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Health Center/Community
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Priv. MD
                        </td>
                    </tr>
                    @endfor
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" ">
                                <b>For Adolescent Girls:</b><br>
                                Given Ferrous sulfate supplementation, Date
                            </small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <small class=" ">
                                <br>
                                Given Iodized Oil Capsule, Date
                            </small>
                            <input type="text" class="form-control" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small class=" ">
                                <b>Dewormed?</b><br>
                                Yes, Date last dewormed?
                            </small>
                            <input type="text" class="form-control" >
                        </td>
                        <td>
                            <br><br>
                            <input type="checkbox"> No
                        </td>
                    </tr>
                </table>

                <small class="label bg-green" style="font-size: 12pt;">OTHER PROCEDURES DONE</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <input type="checkbox"> CBC
                        </td>
                        <td>
                            <input type="checkbox"> Urinalysis
                        </td>
                        <td>
                            <input type="checkbox"> Chest X-ray<br>
                            <small class=" ">Specify result</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <input type="checkbox"> Enzymes Based Rapis Diagnosis Test for Dengue,<br>
                            <small class=" ">Specify result:</small> &nbsp;&nbsp;&nbsp;
                            <input type="checkbox"> IrG Positive &nbsp;&nbsp;&nbsp;
                            <input type="checkbox"> IrM Positive
                        </td>
                        <td>
                            <input type="checkbox"> NS1 Test
                        </td>
                        <td>
                            <input type="checkbox"> PCR
                        </td>
                    </tr>
                </table>

                <small class="label bg-green" style="font-size: 12pt;">REVIEW OF SYSTEMS: (tick all that apply)</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <input type="checkbox"> Jaundice
                        </td>
                        <td>
                            <input type="checkbox"> Seizures
                        </td>
                        <td>
                            <input type="checkbox"> Murmur
                        </td>
                        <td>
                            <input type="checkbox"> Polydypsia
                        </td>
                        <td>
                            <input type="checkbox"> Joint pain
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Pallor
                        </td>
                        <td>
                            <input type="checkbox"> Easy Fatigability
                        </td>
                        <td>
                            <input type="checkbox"> Breast pain
                        </td>
                        <td>
                            <input type="checkbox"> Polyuria
                        </td>
                        <td>
                            <input type="checkbox"> Muscle wasting
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Rashes
                        </td>
                        <td>
                            <input type="checkbox"> Cough/Colds
                        </td>
                        <td>
                            <input type="checkbox"> Nausea and/or vomiting
                        </td>
                        <td>
                            <input type="checkbox"> Vaginal bleeding
                        </td>
                        <td>
                            <input type="checkbox"> Muscle weakness
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Severe/Recurrent Headache
                        </td>
                        <td>
                            <input type="checkbox"> Dyspnea
                        </td>
                        <td>
                            <input type="checkbox"> Severe/Recurrent abdominal pain
                        </td>
                        <td>
                            <input type="checkbox"> Foul Smeling Vaginal
                        </td>
                        <td>
                            <input type="checkbox"> Weigh Loss
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Severe/Recurrent Dizziness
                        </td>
                        <td>
                            <input type="checkbox"> Orthnopnea
                        </td>
                        <td>
                            <input type="checkbox"> Recurrent Constipation
                        </td>
                        <td>
                            <input type="checkbox"> Urethral discharge
                        </td>
                        <td>
                            <input type="checkbox"> Others, Specify:
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Blurring of vision
                        </td>
                        <td>
                            <input type="checkbox"> Chest pain
                        </td>
                        <td>
                            <input type="checkbox"> Diarrhea
                        </td>
                        <td colspan="2">
                            <input type="checkbox"> Dysuria
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Hearing loss
                        </td>
                        <td>
                            <input type="checkbox"> Palpitation
                        </td>
                        <td>
                            <input type="checkbox"> Polyphagia
                        </td>
                        <td colspan="2">
                            <input type="checkbox"> Leg pain
                        </td>
                    </tr>
                </table>

                <small class="label bg-green" style="font-size: 12pt;">PERTINENT PHYSICAL EXAMINATION</small>
                <table class="table table-hover table-striped">
                    <tr>
                        <td>
                            <small class=" "><b>General Status:</b></small><br>
                            <input type="checkbox"> Oriented to Time, Place, and Date
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Conscious
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Ambulatory
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Others, Specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" "><b>Vital Signs:</b></small><br>
                            <small class=" ">BP</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <br>
                            <small class=" ">HR / min</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <br>
                            <small class=" ">RR / min</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <br>
                            <small class=" ">Temp (Degree Celsius)</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <br>
                            <small class=" ">Blood type</small>
                            <input type="text" class="form-control">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" ">Weight (kg)</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <small class=" ">Height(m)</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <small class=" ">BMI</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <small class=" ">Waist(cm)</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <small class=" ">Hip(cm)</small>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <small class=" ">W/H Ratio</small>
                            <input type="text" class="form-control">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" "><b>SKIN:</b></small><br>
                            <input type="checkbox"> Good Skin Turgor
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Pailor
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Jaundice
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Rashes
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Lesions, Specify:
                            <input type="text">
                        </td>
                        <td>
                            <br>
                            Others
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" "><b>HEENT:</b></small><br>
                            <input type="checkbox"> No significant findings
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Visual Activity
                            <input type="text">
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Cleft lip
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Enlarged tonsils
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Others, Specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <input type="checkbox"> Yellowish sclerae
                        </td>
                        <td>
                            <input type="checkbox"> Alar flaring
                        </td>
                        <td>
                            <input type="checkbox"> Cleft palate
                        </td>
                        <td>
                            <input type="checkbox"> Enlarged thyroid
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Pale conjunctiva
                        </td>
                        <td>
                            <input type="checkbox"> Nasal discharge
                        </td>
                        <td>
                            <input type="checkbox"> Ear discharge
                        </td>
                        <td>
                            <input type="checkbox"> Palpable mass, Specify site:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" "><b>CHEST AND LUNGS:</b></small><br>
                            <input type="checkbox"> No significant findings
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Crackles/Rales/Harsh breath sounds
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Breast mass/discharge
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"> Chest retractions
                        </td>
                        <td>
                            <input type="checkbox"> Wheezes
                        </td>
                        <td>
                            <input type="checkbox"> Others, specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" "><b>HEART:</b></small><br>
                            <input type="checkbox"> No Significant findings
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Irregular pulse
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Cyanosis (lips,nails)
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Murmur, Specify:
                            <input type="text">
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Others, Specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" "><b>ABDOMEN:</b></small><br>
                            <input type="checkbox"> No Significant findings
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Tenderness
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Palpable mass, specify site:
                            <input type="text">
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Others, Specify:
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small class=" "><b>EXTREMITIES:</b></small><br>
                            <input type="checkbox"> Abnormal gailt
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Edema
                        </td>
                        <td>
                            <br>
                            <input type="checkbox">Joint swelling
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Gross deformity, describe
                            <input type="text">
                        </td>
                        <td>
                            <br>
                            <input type="checkbox"> Others, specify
                            <input type="text">
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <input type="checkbox"> Enzymes Based Rapid Diagnostic Test for Dengue,Specify result:
                            <input type="text">
                        </td>
                        <td>
                            <input type="checkbox"> IgG Positive
                        </td>
                        <td>
                            <input type="checkbox">IgM Positive
                        </td>
                        <td>
                            <input type="checkbox">NS1 Test
                        </td>
                        <td>
                            <input type="checkbox">PCR
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped" style="margin-top: -25px">
                    <tr>
                        <td>
                            <small><b>SUMMARY OF FINDINGS AND ISSUES</b></small>
                        </td>
                        <td>
                            <small><b>REFERRED TO</b></small>
                        </td>
                        <td>
                            <small><b>OTHER ACTION TAKEN</b></small>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea name="" class="form-control" id="" cols="30" rows="10"></textarea>
                        </td>
                        <td>
                            <textarea name="" class="form-control" id="" cols="30" rows="10"></textarea>
                        </td>
                        <td>
                            <textarea name="" class="form-control" id="" cols="30" rows="10"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @include('modal.populationModal')
@endsection

@section('js')
    <script>
        var hospital_history_count = 2;
        function addHospitalHistory(){
            event.preventDefault();
            var html_append = "<tr id='hospital_history_tr"+hospital_history_count+"'>\n" +
                "                            <td><b>"+hospital_history_count+"</b></td>\n" +
                "                            <td><input type=\"text\" class=\"form-control\"></td>\n" +
                "                            <td><input type=\"text\" class=\"form-control\"></td>\n" +
                "                            <td><input type=\"text\" class=\"form-control\"></td>\n" +
                "                            <td><input type=\"text\" class=\"form-control\"></td>\n" +
                "                            <td><input type=\"text\" class=\"form-control\"></td>\n" +
                "                            <td><input type=\"text\" class=\"form-control\"></td>\n" +
                "                        </tr>";
            $("#hospital_history_row").append(html_append);
            $("#hospital_history_tr"+hospital_history_count).hide().fadeIn();
            hospital_history_count++;
        }

        var past_surgical_history_count = 0;
        function addPastSurgicalHistory(){
            event.preventDefault();
            var html_append = "<tr id='past_surgical_history"+past_surgical_history_count+"'>\n" +
                "                        <td>\n" +
                "                            <small class=\" \">Operation</small>\n" +
                "                            <input type=\"text\" class=\"form-control\" >\n" +
                "                        </td>\n" +
                "                        <td>\n" +
                "                            <small class=\" \">Date</small>\n" +
                "                            <input type=\"text\" class=\"form-control\" >\n" +
                "                        </td>\n" +
                "                    </tr>";
            $("#past_surgical_row").append(html_append);
            $("#past_surgical_history"+past_surgical_history_count).hide().fadeIn();
            past_surgical_history_count++;
        }
    </script>
@endsection