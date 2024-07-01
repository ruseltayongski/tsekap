@extends('resu/app1')
@section('content')


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
                                <input type="text" class="form-control" name="dru" id="dru" placeholder="What">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="dru" id="dru" placeholder="By whom">
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="patientType1" value="No"> No
                            </div>
                            <div class="col-md-4">
                                <label>Nature of Injuries:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;multiple Injuries?</p>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="patientType1" value="Yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="patientType2" value="No"> No
                            </div>
                            <div class="col-md-12">
                             
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h4>Second Column</h4>
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
    .col-md-6 .patient-font{
        background-color: #727DAB;
        color: white; 
        padding: 3px;
    }
    .col-md-6 .mt-4 {
            margin-top: 10px; /* Adjust this value as needed */
        }
</style>

