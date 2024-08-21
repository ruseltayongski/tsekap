@extends('resu/app1')
@section('content')

@include('resu/resuSidebar')
<?php
 use App\ResuNatureInjury;
 use App\ResuBodyParts;
 use App\ResuExternalInjury;
 use App\ResuTransportAccident;
 use App\ResuHospitalFacility;
 use App\Muncity;

 $nature_injury = ResuNatureInjury::all();
 $body_part = ResuBodyParts::all(); 
 $ex_injury = ResuExternalInjury::all();
 $rtacident = ResuTransportAccident::all();
 $hospital_type = ResuHospitalFacility::all();
 $muncities = Muncity::select('id', 'description')->get();
 use Carbon\Carbon;

 $dob = Carbon::parse($profile->dob);
 $age = $dob->diffInYears(Carbon::now());

 function isSimilar($str1, $str2) { // this is for Hospital/Facility Data function
     similar_text(strtolower(trim($str1)), strtolower(trim($str2)), $percent);
     return $percent >= 80; // You can adjust the threshold as needed
 }

?>
    <div class="col-md-8 wrapper">
    <div class="alert alert-jim">
        <h2 class="page-header">
            <i class="fa fa-user"></i>&nbsp; Patient: {{ $profile->fname.' '.$profile->mname.'. '.$profile->lname.' '.$profile->suffix }}
        </h2>
        <!-- <div class="page-divider"></div> -->
        <form class="form-horizontal form-submit" id="form-submit" method="POST" action="{{ route('update-patient-form') }}">
            {{ csrf_field() }}
            <input type="hidden" id="muncities-data" value="{{ json_encode($muncities) }}">
            <input type="hidden" name="reportfacility_id" value="{{$profile->reportfacility->id}}">
            <input type="hidden" name="preadmission_id" value="{{$profile->preadmission->id}}">
            <input type="hidden" name="preadmission_id_update" id="preadmission_id_update" value="{{$profile->preadmission->id}}">
            <input type="hidden" name="profile_id" id="profile_id" value="{{ $profile->id }}">
            <input type="hidden" name="profile_id_update" value="{{ $profile->id }}">

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
                                        <option value="{{ $fact->id }}" data-address="{{$fact->address}}" data-hospital_type="{{ $fact->hospital_type }}"
                                        {{$profile->reportfacility && $profile->reportfacility->facility_id == $fact->id ? 'selected' : ''}}>{{ $fact->name }}
                                        </option>
                                    @endforeach

                                    @if(!$profile->reportfacility || !$profile->reportfacility->facility_id)
                                        <option value="others" selected>
                                            {{ $profile->reportfacility->others ?: 'Others' }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dru">Type of DRU</label>
                                <input type="text" class="form-control" name="typedru" id="typedru" readonly value="{{ $profile->reportfacility->typeOfdru }}">
                            </div>
                            <div class="col-md-6">
                                <label for="address-facility">Address of Reporting Facility</label>
                                <input type="text" class="form-control" name="addressfacility" id="addressfacility" readonly value="{{ $profile->reportfacility->Addressfacility }}">
                            </div>
                            
                            <div class="col-md-6">
                                <label>Type of Patient</label>
                                <div class="checkbox">
                                        @php
                                            $typePatients = explode(',', $profile->typeofpatient ?? '')
                                        @endphp
                                    <label class="checkbox-inline">
                                        <input type="radio" id="ER" name="typePatient" value="ER" {{ in_array('ER', $typePatients) ? 'checked' : ''}}> ER
                                    </label> 
                                    <label class="checkbox-inline">
                                        <input type="radio" id="OPD" name="typePatient" value="OPD" {{ in_array('OPD', $typePatients) ? 'checked' : ''}}> OPD
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" id="In_Patient" name="typePatient" value="In-Patient" {{ in_array('In-Patient', $typePatients) ? 'checked' : '' }}> In-Patient
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" id="BHS" name="typePatient" value="BHS" {{ in_array('BHS', $typePatients)? 'checked' : '' }}> BHS
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" id="RHU" name="typePatient" value="RHU" {{ in_array('RHU', $typePatients)? 'checked' : ''}}> RHU
                                    </label>
                                </div><br>
                            </div>
                        </div>
        
                        <h4 class="patient-font mt-4">General Data</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="hospital_no">Hospital Case No.</label>
                                <input type="text" class="form-control" name="hospital_no" id="hospital_no" value="{{$profile->Hospital_caseno}}">
                            </div>
                            <div class="col-md-3">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lname" value="{{ $profile->lname }}">
                            </div>
                            <div class="col-md-2">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" name="fname" id="fname" value="{{ $profile->fname}}">
                            </div>
                            <div class="col-md-2">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" name="mname" id="mname" value="{{ $profile->mname}}">
                            </div>

                            <div class="col-md-2">
                                <label for="sex">Sex</label>
                                <select class="form-control chosen-select" name="sex" id="sex">
                                    <option value="">Select sex</option>
                                    <option value="male" {{ trim($profile->sex) == 'male' ? 'selected' : '' }}>male</option>
                                    <option value="female" {{trim($profile->sex) == 'female' ? 'selected' : '' }}>female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="dateofbirth">Date Of Birth</label>
                                <input type="date" class="form-control" id="dateofbirth" name="dateBirth" value="{{ $profile->dob }}">
                            </div>
                            <div class="col-md-3">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" id="age" name="age" readonly value="{{$age}}">
                            </div>
                            <div class="col-md-3">
                                <label for="province">Province/HUC</label>
                                <select class="form-control chosen-select" name="province" id="update-province" value="{{$profile->province_id}}" required>
                                    <option value="">Select Province</option>
                                    @foreach($province as $prov)
                                    <option value="{{ $prov->id }}" {{ $profile->province_id == $prov->id ? 'selected' : ''}}>{{ $prov->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="municipal">Municipal</label>
                                <select class="form-control chosen-select" name="municipal" id="update-municipal" data-selected="{{ $profile->muncity_id }}" required>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Barangay</label>
                                <select class="form-control chosen-select" name="barangay" id="update-barangay" data-selected="{{ $profile->barangay_id }}" required>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label for="phil_no">PhilHealth No.</label>
                                <input type="text" class="form-control" name="phil_no" id="phil_no" value="{{$profile->phicID}}"><br>
                            </div>
                        </div>
                        <h4 class="patient-font mt-4">Pre-admission Data</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Place Of Injury:</label>
                            </div>
                            <div class="col-md-3">
                                <label for="province">Province/HUC</label>
                                <select class="form-control chosen-select" name="provinceInjury" id="update_provinceId">
                                    <option value="0" selected>Select Province Injury</option>
                                    @foreach($province as $prov)
                                    <option value="{{ $prov->id }}" {{ $profile->preadmission && $profile->preadmission->POIProvince_id ==  $prov->id ? 'selected' : ''}}>{{ $prov->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="municipal">Municipal</label>
                                <select class="form-control chosen-select" name="municipal_injury" id="update_municipal_injury" data-selected="{{ $profile->preadmission->POImuncity_id }}" required>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Barangay</label>
                                <select class="form-control chosen-select" name="barangay_injury" id="update_barangay_injury" data-selected="{{ $profile->preadmission->POIBarangay_id}}" required>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Purok/Sitio</label>
                                <input type="text" class="form-control" name="purok_injury" id="purok_injury" value="{{ $profile->preadmission->POIPurok }}" placeholder="Enter purok/Sitio">
                            </div>
                            <div class="col-md-6">
                                <label>Date and Time Injury:</label>
                                <input type="date" class="form-control" name="date_injury" id="date_injury" value="{{ $profile->preadmission->dateInjury}}">
                                <input type="time" class="form-control" name="time_injury" id="time_injury" value="{{ $profile->preadmission->timeInjury}}">
                            </div>
                            <div class="col-md-6">
                                <label>Date and Time Consultation:</label>
                                <input type="date" class="form-control" name="date_consult" id="date_consultation" value="{{$profile->preadmission->dateConsult}}">
                                <input type="time" class="form-control" name="time_consult" id="time_consultation" value="{{$profile->preadmission->timeConsult}}">
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
                    @php
                        $intent = $profile->preadmission->injury_intent ? explode(',', $profile->preadmission->injury_intent) : [];
                    @endphp
                    <div class="col-md-4 col-md-offset-1">
                        <label class="checkbox-inline">
                            <input type="radio" name="injury_intent" id="Accidental" value="Unintentional/Accidental" {{ in_array('Unintentional/Accidental', $intent) ? 'checked' : '' }}> Unintentional/Accidental
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="injury_intent" id="Selfinflicted" value="Intentional (Self-inflicted)" {{ in_array('Intentional (Self-inflicted)', $intent) ? 'checked' : '' }}> Intentional (Self-inflicted)
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input type="radio" name="injury_intent" id="Violence" value="Intentional/(Violence)" {{ in_array('Intentional/(Violence)', $intent) ? 'checked' : '' }}> Intentional/(Violence)
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="injury_intent" id="Undetermined" value="Undetermined" {{ in_array('Undetermined', $intent) ? 'checked' : '' }}> Undetermined
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input type="radio" name="injury_intent" id="VAWCPatient" value="VAWC Patient" {{ in_array('VAWC Patient', $intent) ? 'checked' : '' }}> VAWC Patient
                        </label>
                    </div>
                  
                    <div class="col-md-12">  <hr>
                        <label>First Aid Given:</label>
                    </div>
                    @php
                        $firstaid = $profile->preadmission->first_aid ? explode(',', $profile->preadmission->first_aid) : [];
                    @endphp
                    <div class="col-md-1 col-md-offset-2">
                        <input type="radio" name="firstAidGive" id="firstAidYes" value="Yes" {{ in_array('Yes', $firstaid) ? 'checked' : '' }}> Yes
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="druWhat" id="druWhat" placeholder="What:" style="display: none;" value="{{ $profile->preadmission->what}}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="druByWhom" id="druByWhom" placeholder="By whom:" style="display: none;" value="{{ $profile->preadmission->bywhom }}">
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="firstAidGive" id="firstAidNo" value="No" {{ in_array('No', $firstaid) ? 'checked' : '' }}> No
                    </div>


                    <!----------------------------- Nature of Injury ------------------------------>
                    <div class="col-md-12">
                        <hr>
                        <label>Nature of Injuries:</label>
                    </div>
                    @php
                        $minjuries = explode(',', $profile->preadmission->multipleInjury);
                    @endphp
                    <div class="col-md-3 col-md-offset-1">
                        <p>multiple Injuries? &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="multiple_injured" name="multiple_injured" value="Yes" {{ in_array('Yes', $minjuries) ? 'checked' : '' }}> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="single_injured" name="multiple_injured" value="No" {{ in_array('No', $minjuries) ? 'checked' : '' }}> No</p>
                    </div>
                    <div class="col-md-12 col-md-offset-.05">
                        <p class="underline-text text-center" id="underline-text">
                            Check all applicable, indicate in the blank space opposite each type of injury the body location [site] and affected and other details
                        </p>
                    </div>
                    <div class="col-md-3">
                        @php
                            $counter = 1;
                            $renderedInjuredIds = [];
                            $natureInjury_id_array = $profile->preadmission->natureInjuryPreadmissions 
                            ? $profile->preadmission->natureInjuryPreadmissions->pluck('natureInjury_id')->toArray() : [];
                            $natureDetails = [];
                            $natureside = [];
                            $subtype_nature = $profile->preadmission->natureInjuryPreadmissions ?
                            array_filter($profile->preadmission->natureInjuryPreadmissions->pluck('subtype')->toArray()) : [];

                            foreach($profile->preadmission->natureInjuryPreadmissions as $natureItem){
                                $natureDetails[$natureItem->natureInjury_id] = $natureItem->details;
                                $natureside[$natureItem->natureInjury_id] = $natureItem->side;
                            }
                        @endphp
                        @foreach($profile->preadmission->natureInjuryPreadmissions as $natureItem)
                            <input type="hidden" name="Pre_admission_id" value="{{ $natureItem->Pre_admission_id }}">
                            <input type="hidden" name="nature_Pread_id{{$counter}}" value="{{ $natureItem->id }}">
                            @php 
                                $natureArray = explode(',', $natureItem->natureInjury_id); 
                            @endphp
                        @endforeach
                            @foreach($nature_injury as $injured)
                                @php
                                    $cleaned_nature = preg_replace('/[\/,]/', ' ', $injured->name);
                                    $checkIdInjured = 'injured_' . $injured->id;
                                @endphp
                               
                                @if(!in_array($checkIdInjured, $renderedInjuredIds))
                                    @php
                                        $renderedInjuredIds[] = $checkIdInjured;
                                        $injuryDatails = $natureDetails[$injured->id] ?? '';
                                    @endphp
                                    
                                    <div class="checkbox">
                                        @if(strtolower($injured->name) == "burn")
                                            <label>
                                                <input type="checkbox" id="InjuredBurn"  name="InjuredBurn" value="{{ $injured->id }}" data-category="nature" {{ in_array($injured->id, $natureInjury_id_array) ? 'checked' : '' }}> {{$injured->name}}
                                            </label><br>
                                            <input type="text" class="form-control" name="burnDetail" id="burn"  value="{{$injuryDatails}}" placeholder="burn details">

                                        @elseif(strtolower($injured->name) == "fracture")
                                            <label>
                                                <input type="checkbox" name="fractureNature" value="{{$injured->id}}" data-category="nature" {{ in_array($injured->id, $natureInjury_id_array) ? 'checked' : '' }}> {{$injured->name}}
                                            </label><br>
                                            <div class="col-md-offset-5">
                                                <input type="radio" name="fracttype" value="close type" {{ in_array('close type', $subtype_nature) ? 'checked' : '' }}> Close Type
                                            </div>
                                            <div class="col-md-offset-5">
                                                <input type="radio" name="fracttype" value="open type" {{ in_array('open type', $subtype_nature) ? 'checked' : '' }}> Open Type
                                            </div>
                                        @elseif(in_array(strtolower($injured->name), ['others', 'other', 'Other', 'Others']))
                                            <label>
                                                <input type="checkbox" id="{{$checkIdInjured}}" name="Others_nature_injured" value="{{$injured->id}}" data-category="nature" {{ in_array($injured->id, $natureInjury_id_array) ? 'checked' : '' }}> {{$injured->name}}: Please specify injury and the body parts affected:
                                            </label>
                                            <input type="text" class="form-control" id="natureDetails" name="other_nature_details" placeholder="Specify details"  value="{{ $injuryDatails }}">
                                        @else
                                            <label> 
                                                <input type="checkbox" id="{{$checkIdInjured}}" name="nature{{$counter}}" value="{{ $injured->id }}" data-category="nature" data-details="{{ $natureItem->details }}" {{ in_array($injured->id, $natureInjury_id_array) ? 'checked' : ''}}> {{$injured->name}}
                                            </label>
                                            <input type="text" class="form-control" name="nature_details{{$counter}}"  placeholder="Enter details" value="{{$injuryDatails}}">
                                        @endif
                                    </div>
                                    @php
                                        $counter++;
                                    @endphp
                                @endif

                              
                            @endforeach
                            
                     
                    </div>
                    <!-- <div class="col-md-3">
                        @php
                            $counter = 1;
                            $renderedInjuredIds = [];
                        @endphp
                        @foreach($profile->preadmission->natureInjuryPreadmissions as $natureItem)
                       
                        @endforeach
                            @foreach($nature_injury as $injured)
                                @php
                                    $checkIdInjured = 'injured_' . $injured->id;
                                @endphp
                     
                                @if(!in_array($checkIdInjured, $renderedInjuredIds))
                                
                                     @php
                                        $renderedInjuredIds[] = $checkIdInjured;
                                        $injuryDatails = $natureDetails[$injured->id] ?? '';
                                        $sides = $natureside[$injured->id] ?? '';
                                    @endphp

                                    @if($injured->name == "Burn" || $injured->name == "burn")
                                        <br>
                                        <input type="text" class="form-control" name="burnDetail" id="burn"  value="{{$injuryDatails}}" placeholder="burn details">
                                    @elseif($injured->name == "Fracture" || $injured->name == "fracture")
                                        <br>
                                        <label>fracture details</label>
                                        <input type="text" class="form-control" name="fracture_detail" id="fracture_close_detail" value="{{$injuryDatails}}" placeholder=" fracture close type details">
                                       
                                    @elseif($injured->name == "others" || $injured->name == "other" || $injured->name == "Other" || $injured->name == "Others")
                                        <br>
                                        <label>Select side</label>
                                        <select class="form-control" name="side_others" id="side_others">
                                            <option value="">Select Side for Others</option>
                                            <option value="right" {{ $sides == 'right' ? 'selected' : '' }}>right</option>
                                            <option value="left" {{ $sides == 'left' ? 'selected' : '' }}>left</option>
                                            <option value="Both left and Right" {{ $sides == 'Both left and Right' ? 'selected' : '' }}>Both Left & right</option>
                                        </select>
                                    @else
                                        <label>Select side </label>
                                        <select class="form-control" name="sideInjured{{$counter}}" id="sideInjured{{$counter}}">
                                            <option value="">Select Side for {{$injured->name}}</option>
                                            <option value="right" {{ $sides == 'right' ? 'selected' : '' }}>right</option>
                                            <option value="left" {{ $sides == 'left' ? 'selected' : '' }}>left</option>
                                            <option value="Both left and Right" {{ $sides == 'Both left and Right' ? 'selected' : '' }}>Both Left & right</option>
                                        </select>
                                    @endif
                                    @php
                                        $counter++;
                                    @endphp
                                @endif
                            @endforeach
                      
                        
                       
                    </div> -->
                     <!----------------------------- Nature of Injury ------------------------------>
                    <input type="hidden" name="injured_count" class="injured_count" value="{{ $counter }}">
                    <div class="col-md-3">
                        @php
                            $counter = 1;
                            $renderedInjuredIds = [];
                            $body_parts_id = [];
                        @endphp
                        @foreach($profile->preadmission->natureInjuryPreadmissions as $natureadmission)
                            @php
                                $natureDetails[$natureadmission->natureInjury_id] =$natureadmission->details;
                            @endphp
                            @foreach($natureadmission->bodyParts as $bodyPart)
                                @if($bodyPart->nature_injury_id == $natureadmission->natureInjury_id)
                                    @php
                                        $body_parts_id[$bodyPart->nature_injury_id][] = $bodyPart->bodyparts_id;
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach
                        @foreach($nature_injury as $injured)
                            @php
                                $checkIdInjured = 'injured_' . $injured->id;
                                $sides = $natureside[$injured->id] ?? '';
                                $body_parts_ids = $body_parts_id[$injured->id] ?? [];
                            @endphp
                            
                            @if(!in_array($checkIdInjured, $renderedInjuredIds))
                              @php                      
                                $injuryDatails = $natureDetails[$injured->id] ?? '';
                              @endphp
                                @if($injured->name == "Burn" || $injured->name == "burn")
                                    <br>
                                    <label for="bodyParts">Select Body Parts</label>
                                    <select class="form-control chosen-select" name="burn_body_parts[]" id="burn_body_parts" multiple>
                                    @foreach($body_part as $body_parts)
                                        <option value="{{ $body_parts->id }}" {{ in_array($body_parts->id, $body_parts_ids) ? 'selected' : '' }}>{{ $body_parts->name }}</option>
                                    @endforeach
                                </select>
                                @elseif($injured->name == "Fracture" || $injured->name == "fracture")
                                    <br><br>
                                    <label>fracture details</label>
                                    <input type="text" class="form-control" name="fracture_detail" id="fracture_close_detail" value="{{$injuryDatails}}" placeholder=" fracture close type details">
                                
                                @elseif($injured->name == "others" || $injured->name == "other" || $injured->name == "Other" || $injured->name == "Others")
                                    <br><br><br>
                                    <label>Select Body parts</label>
                                    <select class="form-control chosen-select" name="body_parts_others[]" id="body_parts_others" multiple>
                                        @foreach($body_part as $body_parts)
                                        <option value="{{ $body_parts->id }}"  {{ in_array($body_parts->id, $body_parts_ids) ? 'selected' : '' }}>{{ $body_parts->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <label>Select Body Parts</label>
                                    <select class="form-control chosen-select" name="body_parts_injured{{$counter}}[]" id="body_parts_injured{{$counter}}" multiple>
                                        @foreach($body_part as $body_parts)
                                            <option value="{{ $body_parts->id }}" {{ in_array($body_parts->id, $body_parts_ids) ? 'selected' : '' }}>{{ $body_parts->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                @php
                                    $renderedInjuredIds[] = $checkIdInjured;
                                @endphp
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
                            @php 
                                $body_parts_ids = $body_parts_id[$injured->id] ?? [];
                            @endphp                            
                            @if($injured->name == "Burn" || $injured->name == "burn")
                                <br><br><br><br><br><br><br>
                                Degree:
                                @foreach([1, 2, 3, 4] as $degree)
                                    <label>
                                        <input type="radio" id="Degree1" name="Degree" value="Degree {{$degree}}" {{ in_array($injured->id, $natureInjury_id_array) ? 'checked' : '' }}>
                                        {{$degree}}
                                    </label>
                                @endforeach

                            @elseif($injured->name == "Fracture" || $injured->name == "fracture")    
                                <br><br><br><br><br><br><br><br>
                                <label for="bodyparts">Body parts</label>
                                <select class="form-control chosen-select" name="fracture_bodyparts[]" id="fractureclose_bodyparts" multiple>
                                    @foreach($body_part as $body_parts)
                                    <option value="{{ $body_parts->id }}" {{ in_array($body_parts->id, $body_parts_ids) ? 'selected' : '' }}>{{ $body_parts->name }}</option>
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
                        $counter = 1; 
                        $externaldetails = [];
                        $exInjury_id = $profile->preadmission->externalPreadmissions?
                        array_filter($profile->preadmission->externalPreadmissions->pluck('externalinjury_id')->toArray()) : [];
                        $subtype_external = $profile->preadmission->externalPreadmissions?
                        array_filter($profile->preadmission->externalPreadmissions->pluck('subtype')->toArray()) : [];

                        foreach($profile->preadmission->externalPreadmissions as $externalItem){
                                $externaldetails[$externalItem->externalinjury_id] = $externalItem->details;
                            }  
                    @endphp
                     
                    @foreach($ex_injury as $exInjury)
                        @php
                            $cleaned_external = preg_replace('/[\/,]/', ' ', $exInjury->name);              
                            $externalSingle = explode(' ', trim($cleaned_external))[0];
                            $ex_details = $externaldetails[$exInjury->id] ?? '';
                        @endphp
                        <input type="hidden" name="external_id" id="external_id" value="{{$exInjury->id}}">
                        @if($externalSingle == 'Burns' || $externalSingle == 'Burn')     
                            <div class="col-md-12">
                                <label>
                                    <input type="checkbox" id="ex_burn" name="ex_burn" value="{{$exInjury->id}}" data-category="external" {{ in_array($exInjury->id, $exInjury_id) ? 'checked' : '' }}> {{$exInjury->name}}
                                </label><br>
                                <div class="col-md-5">
                                
                                    <div class="checkbox">
                                        <label>
                                            <input type="radio" name="burn_type" id="heat" value="heat" {{in_array('heat', $subtype_external) ? 'checked' : '' }}>
                                            Heat
                                        </label>
                                        <label>
                                            <input type="radio" name="burn_type" id="fire" value="fire" {{in_array('fire', $subtype_external) ? 'checked' : '' }}>
                                            fire
                                        </label>
                                        <label>
                                            <input type="radio" name="burn_type" id="electricity" value="Electricity" {{in_array('Electricity', $subtype_external) ? 'checked' : '' }}>
                                            Electricity
                                        </label>
                                        <label>
                                            <input type="radio" name="burn_type" id="oil" value="Oil" {{in_array('Oil', $subtype_external) ? 'checked' : '' }}>
                                            Oil
                                        </label>
                                        <label>
                                            <input type="radio" name="friction" id="friction" value="friction" {{in_array('friction', $subtype_external) ? 'checked' : '' }}>
                                            friction
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control inline-input2" name="exburnDetails" id="exburnDetails" value="{{$ex_details}}" placeholder="specify here"><br>
                                </div>
                            </div>
                        @elseif($externalSingle == "Drowning" || $externalSingle == "drowning")
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <label>
                                        <input type="checkbox" id="exDrowning" name="exDrowning" value="{{ $exInjury->id }}" data-category="external" {{ in_array($exInjury->id, $exInjury_id) ? 'checked' : '' }}> {{$exInjury->name}}: Type/Body of Water:
                                    </label><br>
                                    <div class="col-md-5">
                                    
                                        <div class="checkbox">
                                            <label>
                                                <input type="radio" name="drowningType" id="Sea" value="Sea" {{in_array('Sea', $subtype_external) ? 'checked' : '' }}>
                                                Sea
                                            </label>
                                            <label>
                                                <input type="radio" name="drowningType" id="River" value="River" {{in_array('River', $subtype_external) ? 'checked' : '' }}>
                                                River
                                            </label>
                                            <label>
                                                <input type="radio" name="drowningType" id="Lake" value="Lake" {{in_array('Lake', $subtype_external) ? 'checked' : '' }}>
                                                Lake
                                            </label>
                                            <label>
                                                <input type="radio" name="drowningType" id="Pool" value="Pool" {{in_array('Pool', $subtype_external) ? 'checked' : '' }}>
                                                Pool
                                            </label>
                                            <label>
                                                <input type="radio" name="drowningType" id="bath_tub" value="Bath Tub" {{in_array('Bath Tub', $subtype_external) ? 'checked' : '' }}>
                                                Bath Tub
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control inline-input2" name="exdrowning_Details" id="exdrowningDetails" value="{{$ex_details}}" placeholder="specify here"><br>
                                </div>
                            </div>
                        @elseif($externalSingle == "Transport")
                            <div class="col-md-12"></div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="Transport" name="externalTransport" value="{{$exInjury->id}}" data-category="external" {{ in_array($exInjury->id, $exInjury_id) ? 'checked' : '' }}> <strong>{{$exInjury->name}}</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="transport_details" id="Transport_details" value="{{$ex_details}}" placeholder="Enter details">
                                </div>
                        @else
                            <div class="col-md-12"></div>
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label> 
                                        <input type="checkbox" id="external{{$counter}}" name="external{{$counter}}" value="{{$exInjury->id}}" data-category="external" {{ in_array($exInjury->id, $exInjury_id) ? 'checked' : '' }}> <strong>{{$exInjury->name}}</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="external_details{{$counter}}" id="external_details{{$counter}}" value="{{$ex_details}}" placeholder="Enter details">
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
                @php
                    $safety = [];
                @endphp
                {{-- @foreach($tranportData->transport as $trans) --}}
                     
                    <div class="Transport-group" style="display: none;">        
                        <div class="col-md-6 transport-related">
                            <label>For Transport Vehicular Accident Only:</label>
                        </div>
                        <div class="col-md-6 transport-related">
                            <label>Vehicular Accident Type: </label>
                        </div>
                        @php
                            function isChecked($value, $selectedValue) {
                                return $value == trim($selectedValue) ? 'checked' : '';
                            }
                        @endphp
                        @foreach($rtacident as $rtAct)
                        <div class="col-md-2 transport-related">&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="Land" name="transport_accident_id" value="{{$rtAct->id}}" {{ $rtAct->id == $trans->transport_accident_id ? 'checked' : '' }}> {{$rtAct->description}}
                        </div>
                        @endforeach
                        <div class="col-md-3 transport-related">&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="Collision" name="transport_collision" value="Collision" {{ isChecked("Collision", $trans->Vehicular_acc_type) }}> Collision
                        </div>
                        <div class="col-md-2 transport-related">
                            <input type="radio" id="non_collision" name="transport_collision" value="Non-Collision" {{ isChecked("Non-Collision", $trans->Vehicular_acc_type) }}> Non-Collision
                        </div>  
                        <div class="col-md-6 transport-related"><hr>
                            <label>Vehicles Involved:</label>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patient's Vehicle</p>
                            <div class="col-md-4">&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="none_pedes" name="Patient_vehicle" value="None (Pedestrian)" {{isChecked('None (Pedestrian)', $trans->PatientVehicle)}}> None (Pedestrian)<br>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="patient_motorcycle" name="Patient_vehicle" value="Motorcycle" {{isChecked('Motorcycle', $trans->PatientVehicle)}}> Motorcycle<br>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="patient_truck" name="Patient_vehicle" value="Truck" {{isChecked('Truck', $trans->PatientVehicle)}}> Truck<br>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="patient_bus" name="Patient_vehicle" value="Bus" {{isChecked('Bus', $trans->PatientVehicle)}}> Bus<br>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="patient_jeepney" name="Patient_vehicle" value="Jeepney" {{isChecked('Jeepney', $trans->PatientVehicle)}}> Jeepney
                            </div>
                            <div class="col-md-4">
                                <input type="radio" id="patient_car" name="Patient_vehicle" value="Car" {{isChecked('Car', $trans->PatientVehicle)}}> Car<br>
                                <input type="radio" id="patient_bicycle" name="Patient_vehicle" value="Bicycle" {{isChecked('Bicycle', $trans->PatientVehicle)}}> Bicycle<br>
                                <input type="radio" id="patient_van" name="Patient_vehicle" value="Van" {{isChecked('Van', $trans->PatientVehicle)}}> Van<br>
                                <input type="radio" id="patient_tricycle" name="Patient_vehicle" value="Tricycle" {{ isChecked('Tricycle', $trans->PatientVehicle)}} > Tricycle
                            </div>
                            <div class="col-md-4">
                                <input type="radio" id="patient_unknown" name="Patient_vehicle" value="Unknown" {{isChecked('Unknown', $trans->PatientVehicle)}} > Unknown<br>
                                <input type="radio" id="patient_others" name="Patient_vehicle" value="others" {{isChecked('others', $trans->PatientVehicle)}}> Others<br>
                                <input type="text" class="form-control" name="Patient_vehicle_others" value="{{$trans->PvOther_detail}}" placeholder="others details">
                            </div>
                            <div class="col-md-12 collision_group" style="display:none"><br>
                                <p>Other Vehicle/Object Involved (for Collision accident only)</p>
                                <div class="col-md-3">
                                    <input type="radio" id="objectNone" name="Othercollision" value="None" {{isChecked('None', $trans->other_collision) }}> None<br>
                                    <input type="radio" id="objectbicycle" name="Othercollision" value="Bicycle" {{isChecked('Bicycle', $trans->other_collision) }}> Bicycle<br>
                                    <input type="radio" id="objectcar" name="Othercollision" value="Car" {{isChecked('Car', $trans->other_collision)}}> Car<br>
                                    <input type="radio" id="objectjeepney" name="Othercollision" value="Jeepney" {{isChecked('Jeepney', $trans->other_collision) }}> Jeepney
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" id="objectvan" name="Othercollision" value="Van" {{isChecked('Van', $trans->other_collision)}}> Van<br>
                                    <input type="radio" id="objectbus" name="Othercollision" value="Bus" {{isChecked('Bus', $trans->other_collision)}}> Bus<br>
                                    <input type="radio" id="objecttruck" name="Othercollision" value="truck" {{isChecked('truck', $trans->other_collision)}}> truck<br>
                                    <input type="radio" id="objectothers" name="Othercollision" value="Others" {{isChecked('Others', $trans->other_collision)}}> Others:
                                    <input type="text" class="form-control" name="other_collision_details" value="{{$trans->other_collision_details}}" placeholder="others details">
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" id="objectmotorcycle" name="Othercollision" value="Motorcycle" {{isChecked('Motorcycle', $trans->other_collision)}}> Motorcycle<br>
                                    <input type="radio" id="objectTricycle" name="Othercollision" value="Tricycle" {{isChecked('Tricycle', $trans->other_collision)}}> Tricycle<br>
                                    <input type="radio" id="objectunknown" name="Othercollision" value="unknown" {{isChecked('unknown', $trans->other_collision)}}> Unknown
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 transport-related"><hr><br>
                            <p>Position of Patient</p>
                            <input type="radio" id="position_pedes" name="position_patient" value="Pedestrian" {{isChecked('Pedestrian', $trans->positionPatient)}}> Pedestrian<br>
                            <input type="radio" id="position_driver" name="position_patient" value="Driver" {{isChecked('Driver', $trans->positionPatient)}}> Driver<br>
                            <input type="radio" id="position_captain" name="position_patient" value="Captain" {{isChecked('Captain', $trans->positionPatient)}}> Captain<br>
                            <input type="radio" id="position_pilot" name="position_patient" value="Pilot"{{isChecked('Pilot', $trans->positionPatient)}}> Pilot <br>
                            <input type="radio" id="position_passenger" name="position_patient" value="Font Passenger"{{isChecked('Font Passenger', $trans->positionPatient)}}> Front Passenger<br>
                            <input type="radio" id="position_rear_passenger" name="position_patient" value="Rear Passenger"{{isChecked('Rear Passenger', $trans->positionPatient)}}> Rear Passenger<br>
                            <input type="radio" id="position_others" name="position_patient" value="Others" {{isChecked('Others', $trans->positionPatient)}}> Others:<br>
                            <input type="text" class="form-control" id="position_patient" name="position_other_details" placeholder="others details" value="{{$trans->ppother_detail}}">
                            <input type="radio" id="position_unknown" name="position_patient" value="Unknown" {{isChecked('Unknown', $trans->positionPatient)}}> Unknown

                        </div>
                        <div class="col-md-3 transport-related"><hr><br>
                            <p>Place of Occurrence</p>
                            <input type="radio" id="place_home" name="Occurrence" value="Home" {{isChecked('Home', $trans->pofOccurence)}}> Home<br>
                            <input type="radio" id="place_school" name="Occurrence" value="School" {{isChecked('School', $trans->pofOccurence)}}> School<br>
                            <input type="radio" id="place_Road" name="Occurrence" value="Road" {{isChecked('Road', $trans->pofOccurence)}}> Road<br>
                            <input type="radio" id="place_Bars" name="Occurrence" value="School" {{isChecked('School', $trans->pofOccurence)}}> Videoke Bars<br>
                            <input type="radio" id="place_workplace" name="Occurrence" value="workplace" {{isChecked('workplace', $trans->pofOccurence)}}> Workplace, specify:<br>
                            <input type="text" class="form-control" id="workplace_occurence_details" name="workplace_occ_specify" value="{{$trans->workplace_occurence_specify}}" placeholder="specify here">
                            <input type="radio" id="place_others" name="Occurrence" value="Others" {{isChecked('Others', $trans->pofOccurence)}}> Others:<br>
                            <input type="text" class="form-control" id="place_other_details" name="Occurrence_others" placeholder="others details" value="{{$trans->pofOccurence_others}}">
                            <input type="radio" id="place_unknown" name="Occurrence" value="Unknown" {{isChecked('Unknown', $trans->pofOccurence)}}> Unknown
                        </div>
                        <div class="col-md-12 transport-related">
                            <div class="col-md-4"><hr>
                                <label>Activity of the patient at the of incident</label><br>
                                <input type="radio" id="activity_sports" name="activity_patient" value="Sports" {{isChecked('Sports', $trans->activity_patient)}}> Sports<br>
                                <input type="radio" id="activity_leisure" name="activity_patient" value="leisure" {{isChecked('leisure', $trans->activity_patient)}}> Leisure<br>
                                <input type="radio" id="activity_school" name="activity_patient" value="Work Related" {{isChecked('Work Related', $trans->activity_patient)}}> Work Related<br>
                                <input type="radio" id="activity_others" name="activity_patient" value="Others" {{isChecked('Others', $trans->activity_patient)}}> Others:
                                <input type="text" class="form-control" id="activity_Patient_other" name="activity_patient_other" value="{{$trans->AP_others}}" placeholder="others details">
                                <input type="radio" id="activity_unknown" name="activity_patient" value="unknown" {{isChecked('unknown', $trans->activity_patient)}}> Unknown
                            </div>
                            <div class="col-md-4"><hr>
                                <label>Other Risk Factors at the time of the incident:</label><br>
                                <input type="radio" id="risk_liquor" name="risk_factors" value="Alcohol/liquor" {{isChecked('Alcohol/liquor', $trans->risk_factors)}}> Alcohol/liquor<br>
                                <input type="radio" id="risk_mobilephone" name="risk_factors" value="Using Mobile Phone" {{isChecked('Using Mobile Phone', $trans->risk_factors)}}> Using Mobile Phone<br>
                                <input type="radio" id="risk_sleepy" name="risk_factors" value="Sleepy" {{isChecked('Sleepy', $trans->risk_factors)}}> Sleepy<br>
                                <input type="radio" id="risk_smooking" name="risk_factors" value="smooking" {{isChecked('smooking', $trans->risk_factors)}}> Smooking<br>
                                <input type="radio" id="risk_others" name="risk_factors" value="Others" {{isChecked('Others', $trans->risk_factors)}}> Others specify:
                                <input type="text" class="form-control" id="risk_others_details" name="rf_others" value="{{ $trans->rf_others }}" placeholder="others specify here">
                                <p>(eg. Suspected under the influence of substance used)</p>
                            </div>
                            <div class="col-md-4"><hr>
                                <label>Safety: (check all that apply)</label>
                                        <input type="hidden" name="transport_ids" value="{{ $trans->id }}">
                                    @foreach($list_safety as $safe)
                                 
                                        <div class="col-md-6">
                                            <input type="checkbox" id="safe_{{ $index }}" name="categsafe[]" value="{{ $safe->id }}" data-category="safety" {{ in_array($safe->id, $safe_ids) ? 'checked' : '' }}>{{ $safe->name }}<br>                                  
                                        </div>

                                    @if(trim($safe->name) == 'Others')

                                        <input type="hidden" name="safety_others_id" value="{{ $safe->id }}">
                                        <div class="col-md-6 col-md-offset-6">
                                            <input type="text" class="form-control" id="safeothers_details" name="safeothers_details" value="{{ $trans->safety_others }}" placeholder="others specify here">
                                        </div>
                                    @endif
                                    @endforeach
                            </div>
                        </div>
                   {{-- @endforeach --}}
                </div>
                <!-- end of transport-group -->
                {{-- @if($hospitalData->hospitalfacility_id == 1) --}}
                    <div class="col-md-12"><hr class="hrA_ErOpdGroup">
                        <h4 class="patient-font mt-4">Hospital/Facility Data</h4>
                        @foreach($hospital_type as $hos)
                            @if(isSimilar($hos->category_name, "ER/OPD/BHS/RHU"))
                            <div class="A_ErOpdGroup">
                                <h6 class="A_Hospital mt-5"> 
                                <input type="checkbox" id="A_ErOpd" name="hospital_data" value="{{$hos->id}}" data-category="department"  {{isChecked($hos->id, $hospitalData->hospitalfacility_id)}}>
                                 <input type="hidden" name="Eropd_id" value ="{{ $hospitalData->id }}">
                                {{$hos->category_name}}</h6>
                                <div class="col-md-12">
                                    <label for="transferred facility">Transferred from another hospital/facility</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="YesTransferred" name="Transferred" value="1" {{isChecked('1', $hospitalData->transferred_facility)}}> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="NoTransferred" name="Transferred" value="0" {{isChecked('0', $hospitalData->transferred_facility)}}> No <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label for="referred by hospital">Referred by another Hospital/Facility for Laboratory and/or other medical procedures</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="ReferredYes" name="Referred" value="1" {{isChecked('1', $hospitalData->referred_facility)}}> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="Referredno" name="Referred" value="0" {{isChecked('0', $hospitalData->referred_facility)}}> No <br><hr>
                                </div>
                                <div class="col-md-12">
                                    <label for="nameofphysician">Name of the Originating Hospital/Physician:</label>
                                    <input type="text" class="form-control" id="name_orig" name="name_orig" placeholder="Name of the Originating Hospital/Physician" value="{{$hospitalData->originating_hospital}}">
                                </div>
                                <div class="col-md-12"><hr></div>
                                <div class="col-md-3">
                                    <label for="">Status upon reashing the Facility</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="radio" id="deadonarrive" name="reashingFact" value="Dead on Arrival" {{isChecked('Dead on Arrival', $hospitalData->status_facility)}}> Dead on Arrival
                                </div>
                                <div class="col-md-2">
                                    <input type="radio" id="alive" name="reashingFact" value="Alive" {{isChecked('Alive', $hospitalData->status_facility)}}> Alive
                                </div>
                                <div class="col-md-1">
                                    <label for=""> If Alive: </label> 
                                </div>
                                <div class="col-md-2">
                                    <input type="radio" id="conscious" name="ifAlive" value="conscious" {{ isChecked('conscious', $hospitalData->Ifalive) }}> conscious
                                </div>
                                <div class="col-md-2">
                                    <input type="radio" id="Unconscious" name="ifAlive" value="Unconscious" {{ isChecked('Unconscious', $hospitalData->Ifalive) }}> Unconscious
                                </div>
                                <div class="col-md-12"></div>
                                <div class="col-md-3"><hr>
                                    <label for="">Mode of Transport to the Hospital/Facility</label>
                                </div>
                                <div class="col-md-2"><hr>
                                    <input type="radio" id="ambulance" name="mode_transport" value="Ambulance" {{isChecked('Ambulance', $hospitalData->mode_transport_facility)}}> Ambulance
                                </div>
                                <div class="col-md-2"><hr>
                                    <input type="radio" id="police_vehicle" name="mode_transport" value="Police Vehicle" {{isChecked('Police Vehicle', $hospitalData->mode_transport_facility)}}> Police Vehicle
                                </div>
                                <div class="col-md-2"><hr>
                                    <input type="radio" id="private_vehicle" name="mode_transport" value="Private Vehicle" {{isChecked('Private Vehicle', $hospitalData->mode_transport_facility)}}> Private Vehicle
                                </div>
                                <div class="col-md-1"><hr>
                                    <input type="radio" id="ModeOthers" name="mode_transport" value="Others" {{isChecked('Others', $hospitalData->mode_transport_facility)}}> Others
                                </div>
                                <div class="col-md-2"><hr>
                                    <input type="text" class="form-control" id="mode_others_details" name="mode_others_details" value="{{$hospitalData->other_details}}" placeholder="others specify here">
                                </div>
                                <div class="col-md-12"><hr>
                                <label for="initial_imp">Initial Impression</label>
                                    <input type="text" class="form-control" id="Initial_Impression" name="Initial_Impression" value="{{$hospitalData->initial_impression}}" > <br>
                                </div>
                                <div class="col-md-6">
                                    <label for="">ICD-10 Code/s: Nature of imjury</label>
                                    <input type="text" class="form-control" id="icd10_nature" name="icd10_nature" id="icd10_nature" value="{{$hospitalData->icd10Code_nature}}">    
                                </div>
                                <div class="col-md-6">
                                    <label for="">ICD-10 Code/s: External Cause injury</label>
                                    <input type="text" class="form-control" id="icd10_external" name="icd10_external" id="icd10_external" value="{{$hospitalData->icd10Code_external}}">
                                </div>
                                <div class="col-md-12"><hr>
                                    <div class="col-md-1">
                                        <label for="Disposition">Disposition:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" id="admitted" name="disposition" value="Admitted" {{isChecked('Admitted', $hospitalData->disposition)}}> Admitted <br>
                                        <input type="radio" id="hama" name="disposition" value="HAMA" {{isChecked('HAMA', $hospitalData->disposition)}}> HAMA
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" id="treated_sent" name="disposition" value="Treated and Sent Home" {{isChecked('Treated and Sent Home', $hospitalData->disposition)}}> Treated and Sent Home <br>
                                        <input type="radio" id="Absconded" name="disposition" value="Absconded" {{isChecked('Absconded', $hospitalData->disposition)}}> Absconded
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" id="trans_facility_hos" name="disposition" value="Transferred to Another facility/hospital" {{isChecked('Transferred to Another facility/hospital', $hospitalData->disposition)}}> Transferred to Another facility/hospital, <br>
                                        <input type="text" class="form-control" id="trans_facility_hos_details" name="trans_facility_hos_details" value="{{ $hospitalData->details }}" placeholder="Please specify">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="refused_admiss" name="disposition" value="Refused Admission" {{isChecked('Refused Admission', $hospitalData->disposition)}}> Refused Admission <br>
                                        <input type="radio" id="died" name="disposition" value="died" {{isChecked('died', $hospitalData->disposition)}}> Died
                                    </div>
                                </div>
                                <div class="col-md-12"><hr>
                                    <div class="col-md-2">
                                        <label for="Outcome">Outcome</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="Improved" name="outcome" value="Improved" {{isChecked('Improved', $hospitalData->outcome)}}> Improved
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="Unimproved" name="outcome" value="Unimproved" {{isChecked('Unimproved', $hospitalData->outcome)}}> Unimproved
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="Died1" name="outcome" value="died" {{isChecked('died', $hospitalData->outcome)}}> Died
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                {{-- @elseif($hospitalData->hospitalfacility_id == 2) --}}
                    @foreach($hospital_type as $hos)
                        @if(isSimilar($hos->category_name, "In-patient (admitted)"))
                            <div class="B_InpatientGroup">
                                <input type="hidden" name="inPatient_id" value="{{ $hospitalData->id }}">
                                <div class="col-md-12"><hr class="Inpatient_linehr">
                                <!-- <h4 class="patient-font mt-4">Hospital/Facility Data</h4> -->
                                    <h6 class="A_Hospital mt-5"> 
                                    <input type="checkbox" id="B_InPatient" name="hospital_data_second" value="{{$hos->id}}" data-category="in-patient" {{isChecked($hos->id, $hospitalData->hospitalfacility_id)}}>
                                    {{$hos->category_name}}</h6>
                                   
                                    <div class="col-md-12">
                                        <label for="complete_final">Complete Final Diagnosis</label>
                                        <input type="text" class="form-control" id="complete_final" name="final_diagnose" id="" value="{{$hospitalData->complete_Diagnose}}">
                                    </div>
                                    <div class="col-md-12"><hr>

                                        <label for="Disposition">Disposition:</label><br>
                                        <div class="col-md-3 col-md-offset-1">
                                            <input type="radio" id="discharged" name="disposition1" value="discharged" {{isChecked('discharged', $hospitalData->Disposition)}}> Discharged <br>
                                            <input type="radio" id="refused_admiss1" name="disposition1" value="Refused Admission" {{isChecked('Refused Admission', $hospitalData->Disposition)}}> Refused Admission
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="HAMA1" name="disposition1" value="HAMA" {{isChecked('HAMA', $hospitalData->Disposition)}}> HAMA <br>
                                            <input type="radio" id="died2" name="disposition1" value="died" {{isChecked('dieid', $hospitalData->Disposition)}}> Died
                                        </div>
                                        <div class="col-md-3">
                                            <input type="radio" id="trans_facility_hos2" name="disposition1" value="Transferred to Another facility/hospital" {{isChecked('Transferred to Another facility/hospital', $hospitalData->Disposition)}}> Transferred to Another facility/hospital <br>
                                            @if(trim($hospitalData->Disposition) == "Transferred to Another facility/hospital")
                                                <input type="text" class="form-control" id="trans_facility_hos_details2" name="trans_facility_hos_details2" value="{{$hospitalData->details}}" placeholder="Please specify">
                                            @else
                                                <input type="text" class="form-control" id="trans_facility_hos_details2" name="trans_facility_hos_details2" value="" placeholder="Please specify">
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="radio" id="absconded1" name="disposition1" value="Absconded" {{isChecked('Absconded', $hospitalData->Disposition)}}> Absconded <br>
                                            <input type="radio" id="disposition_others" name="disposition1" value="Others" {{isChecked('Others', $hospitalData->Disposition)}}> Others 
                                            @if(trim($hospitalData->Disposition) == "Others")
                                                <input type="textbox" class="form-control" id="disposition_others_details" name="disposition_others_details" value="{{$hospitalData->details}}">
                                            @else
                                                <input type="textbox" class="form-control" id="disposition_others_details" name="disposition_others_details" value="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12"><hr>
                                        <label for="Outcome">Outcome</label><br>
                                        <div class="col-md-2 col-md-offset-1">
                                            <input type="radio" id="Improved1" name="Outcome1" value="Improved" {{isChecked('Improved', $hospitalData->Outcome)}}> Improved
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="Unimproved1" name="Outcome1" value="Unimproved" {{isChecked('Unimproved', $hospitalData->Outcome)}}> Unimproved
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="died1" name="Outcome1" value="died" {{isChecked('died', $hospitalData->Outcome)}}> Died
                                        </div>
                                    </div>
                                    <div class="col-md-6"><br>
                                        <label for="">ICD-10 Code/s: Nature of injury</label>
                                        <input type="text" class="form-control" id="icd10_nature1" name="icd10_nature1" value="{{ $hospitalData->icd10Code_nature }}">    
                                    </div>
                                    <div class="col-md-6"><br>
                                        <label for="">ICD-10 Code/s: External Cause injury</label>
                                        <input type="text" class="form-control" id="icd10_external1" name="icd10_external1" value="{{ $hospitalData->icd10Code_external}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
              
                {{-- @else
                <p>No Data Found!</p>
                @endif --}}
                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                        <button type="button" class="btn btn-primary mx-2" onclick="showPreviousStep()">Previous</button>
                        <button type="submit" class="btn btn-success mx-2" onclick="submitProfileId()">update</button>
                    </div>
            </div>
        </form>

    </div>
</div>
<script>
    var deleteNatureUrl = "{{ route('delete-nature') }}";
    // var deleteNatureUrl = "//?php echo url('delete/nature'); ?>";

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