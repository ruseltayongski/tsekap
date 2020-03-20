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
    <div class="col-md-12">
        <div class="alert alert-jim">
            <h3 class="text-blue">Dengvaxia Vaccinee Health Profile</h3>

            <!--
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            -->

            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <!--
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general_information" data-toggle="tab">General Information</a></li>
                    <li><a href="#level_education" data-toggle="tab">Level of Education</a></li>
                    <li><a href="#phic" data-toggle="tab">PHIC Membership of Principal(PARENTS)</a></li>
                    <li><a href="#family_history" data-toggle="tab">Family History</a></li>
                    <li><a href="#medical_history" data-toggle="tab">Medical History of Vaccinee</a></li>
                    <li><a href="#bronchial_asthma" data-toggle="tab">Bronchial Asthma</a></li>
                    <li><a href="#tuberculosis" data-toggle="tab">Tuberculosis</a></li>
                    <li><a href="#disability" data-toggle="tab">Disability</a></li>
                    <li><a href="#injury" data-toggle="tab">Injury</a></li>
                    <li><a href="#hospitalization" data-toggle="tab">Hospitalization History</a></li>
                    <li><a href="#past_surgical" data-toggle="tab">Past Surgical History</a></li>
                    <li><a href="#personal_history" data-toggle="tab">Personal/Social History</a></li>
                    <li><a href="#menstrual" data-toggle="tab">Menstrual & Gynecological History</a></li>
                    <li><a href="#vaccination_history" data-toggle="tab">Vaccination History</a></li>
                    <li><a href="#other_procedures" data-toggle="tab">Other Procedures Done</a></li>
                    <li><a href="#review_system" data-toggle="tab">Review of Systems</a></li>
                    <li><a href="#pertinent_examination" data-toggle="tab">Pertinent Physical Examination</a></li>
                    <li><a href="#summary_findings" data-toggle="tab">Summary of Findings & Issues</a></li>
                    <li><a href="#assesed" data-toggle="tab">Assessed by MHO/CHO</a></li>
                </ul>
                -->
                <div class="tab-content no-padding">
                    <!-- Morris chart - Sales -->
                    <div class="chart tab-pane active" id="general_information" >
                        <br>
                        <small class="label bg-green" style="font-size: 12pt">General Information</small>
                        <table class="table table-hover table-striped" style="margin-top: 20px">
                            <tr>
                                <td>
                                    <small class="text-green">Last Name</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td>
                                    <small class="text-green">First Name</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td style="width: 10%">
                                    <small class="text-green">MI</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td style="width: 10%" colspan="2">
                                    <small class="text-green">Ext</small>
                                    <input type="text" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small class="text-green">Relation to household head</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td>
                                    <small class="text-green">Respondent</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td colspan="3">
                                    <small class="text-green">Contact No</small>
                                    <input type="text" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small class="text-green">House No. & Street Name</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td>
                                    <small class="text-green">Sitio/Purok</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td >
                                    <small class="text-green">Barangay</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td >
                                    <small class="text-green">Municipality</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td >
                                    <small class="text-green">Province</small>
                                    <input type="text" class="form-control" >
                                </td>
                            </tr>
                        </table>
                        <table class="table table-hover table-striped" style="margin-top: -25px">
                            <tr>
                                <td>
                                    <small class="text-green">Sex</small>
                                    <select name="" id="" class="form-control">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </td>
                                <td>
                                    <small class="text-green">Age</small>
                                    <input type="text" class="form-control" >
                                </td>
                                <td >
                                    <small class="text-green">Religion</small>
                                    <select name="" id="" class="form-control">
                                        <option value="rc">RC</option>
                                        <option value="christian">Christian</option>
                                        <option value="inc">Female</option>
                                        <option value="islam">Female</option>
                                        <option value="jehovah">Female</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-hover table-striped" style="margin-top: -25px">
                            <tr>
                                <td>
                                    <small class="text-green">Level of Education</small>
                                    <select name="" id="" class="form-control">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="chart tab-pane" id="level_education" >

                    </div>
                    <div class="chart tab-pane" id="phic" >

                    </div>
                    <div class="chart tab-pane" id="family_history" >

                    </div>
                    <div class="chart tab-pane" id="medical_history" >

                    </div>
                    <div class="chart tab-pane" id="bronchial_asthma" >

                    </div>
                    <div class="chart tab-pane" id="tuberculosis" >

                    </div>
                    <div class="chart tab-pane" id="disability" >

                    </div>
                    <div class="chart tab-pane" id="injury" >

                    </div>
                    <div class="chart tab-pane" id="hospitalization" >

                    </div>
                    <div class="chart tab-pane" id="past_surgical" >

                    </div>
                    <div class="chart tab-pane" id="personal_history" >

                    </div>
                    <div class="chart tab-pane" id="menstrual" >

                    </div>
                    <div class="chart tab-pane" id="vaccination_history" >

                    </div>
                    <div class="chart tab-pane" id="other_procedures" >

                    </div>
                    <div class="chart tab-pane" id="review_system" >

                    </div>
                    <div class="chart tab-pane" id="pertinent_examination" >

                    </div>
                    <div class="chart tab-pane" id="summary_findings" >

                    </div>
                    <div class="chart tab-pane" id="assesed" >

                    </div>
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
    @include('modal.populationModal')
@endsection

@section('js')
    <script>
        //$(".container_body").removeClass("container");
    </script>
@endsection