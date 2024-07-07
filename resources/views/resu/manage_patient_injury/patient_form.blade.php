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
                                <input type="text" class="form-control" name="facilityname" id="facility-name" value="">
                            </div>
                            <div class="col-md-6">
                                <label for="dru">Type of DRU</label>
                                <input type="text" class="form-control" name="dru" id="dru" value="">
                            </div>
                            <div class="col-md-6">
                                <label for="address-facility">Address of Reporting Facility</label>
                                <input type="text" class="form-control" name="facility-add" id="address-facility" value="">
                            </div>
                            <div class="col-md-6">
                                <label>Type of Patient</label>
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType1" name="patientType1" value="ER"> ER
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType2" name="patientType2" value="OPD"> OPD
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType3" name="patientType3" value="In-Patient"> In-Patient
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType4" name="patientType4" value="BHS"> BHS
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="patientType5" name="patientType5" value="RHU"> RHU
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
                                <select class="form-control" name="province" id="province" value="">
                                    <option value="">Select Province</option>
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="municipal">Municipal</label>
                                <select class="form-control" name="municipal" id="municipal" value="">
                                    <option value="">Select Municipal</option>
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay">Barangay</label>
                                <select class="form-control" name="barangay" id="barangay" value="">
                                    <option value="">Select Barangay</option>
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
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
                                <select class="form-control" name="permanent_add_province" id="permanent_add_province" value="">
                                    <option value="">Select Province</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="permanent_add_municipal" id="permanent_add_municipal" value="">
                                    <option value="">Select Municipal</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                                    <option value="">Select Barangay</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
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
                            <input type="checkbox" name="firstAidGiven"> Yes
                        </label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="druWhat" placeholder="What:">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="druByWhom" placeholder="By whom:">
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" name="firstAidGiven"> No
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <label>Nature of Injuries:</label>
                    </div>

                    <div class="col-md-3 col-md-offset-1">
                        <p>multiple Injuries?
                        <input type="checkbox" id="patientType1" value="Yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="patientType2" value="No"> No</p>
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
                                <input type="checkbox" id="Avulsion" name="Avulsion"> Avulsion
                            </label>
                            <input type="text" class="form-control" name="AvulsionDetail" id="natureinput">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="Avulsion" name="Avulsion"> Avulsion
                            </label>
                            <input type="text" class="form-control" name="AvulsionDetail" id="natureinput">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                        <label>Select side</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select Side</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Select Body Parts</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                        <label>Select Body Parts</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                        <label>Select Body Parts</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                        <label>Select Body Parts</label>
                        <select class="form-control" name="permanent_add_barangay" id="permanent_add_barangay" value="">
                            <option value="">Select body parts</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
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
                    <p>Third form</p>
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
                   <p>4th form</p>

                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                        <button type="button" class="btn btn-primary mx-2" onclick="showPreviousStep()">Previous</button>
                        <button type="button" class="btn btn-primary mx-2" onclick="submitForm()">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    function showNextStep(){
        var currentStep =  document.querySelector('.form-step:not([style*="display: none"])');
        var nextStep = currentStep.nextElementSibling;

        if(nextStep){
            currentStep.style.display = 'none';
            nextStep.style.display = 'block';
        }

    }
    
    function showPreviousStep(){
        var currentStep = document.querySelector('.form-step:not([style*="display: none"])');
        var previousStep = currentStep.previousElementSibling;

        if(previousStep){
            currentStep.style.display = 'none';
            previousStep.style.display = 'block';
        }
    }


    function submitForm(){
        document.getElementById('form-submit').submit();
    }
 
</script>

@endsection