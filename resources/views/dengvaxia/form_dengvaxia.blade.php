@extends('client')
@section('content')
    <style>
        .table tr td:first-child {
            background: #f5f5f5;
            text-align: right;
            vertical-align: middle;
            font-weight: bold;
            padding: 3px;
            width:30%;
            color: #25863b;
        }
        .table tr td {
            border:1px solid #bbb !important;
        }
        .help-block {
            font-weight:bold;
        }
        .btn {
            margin: 5px 0;
        }
        #btn_collapse{
            width: 100%;
            text-align: left;
        }

    </style>

    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">
                <i class="fa fa-user"></i>
                Dengvaxia Details
            </h2>
            <div class="page-divider"></div>
            <form method="POST" class="form-horizontal form-submit" id="form-submit" action="{{ asset('post_dengvaxia').'/'.$dengvaxia->id }}">
                {{ csrf_field() }}
                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#general_information" role="button" aria-expanded="false" aria-controls="collapseExample">
                    GENERAL INFORMATION
                </a>
                <div class="collapse" id="general_information">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr>
                            <td>Last Name :</td>
                            <td><input type="text" value="{{ $dengvaxia->lname }}" name="gen_lname" class="form-control" /></td>
                        </tr>

                        <tr>
                            <td>First Name :</td>
                            <td><input type="text" value="{{ $dengvaxia->fname }}" name="gen_fname" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Middle Initial :</td>
                            <td>
                                <input type="text" value="{{ $dengvaxia->mname }}" name="gen_mname" class="form-control" />
                            </td>
                        </tr>
                        <tr class="relation has-group" >
                            <td>Extension: Sr,Jr Etc :</td>
                            <td>
                                <select name="gen_ext" class="form-control chosen-select" id="suffix" style="width: 100%">
                                    <option value="">Select...</option>
                                    <option selected>Jr.</option>
                                    <option>Sr.</option>
                                    <option>I</option>
                                    <option>II</option>
                                    <option>III</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Relation to Head :</td>
                            <td>
                                <select name="gen_rel" id="relation" class="form-control chosen-select" style="width: 100%">
                                    <option value="">Select...</option>
                                    <option selected>Son</option>
                                    <option>Daughter</option>
                                    <option>Wife</option>
                                    <option>Husband</option>
                                    <option>Father</option>
                                    <option>Mother</option>
                                    <option>Brother</option>
                                    <option>Sister</option>
                                    <option>Nephew</option>
                                    <option>Niece</option>
                                    <option>Grandfather</option>
                                    <option>Grandmother</option>
                                    <option>Grandson</option>
                                    <option>Granddaughter</option>
                                    <option>Cousin</option>
                                    <option>Relative</option>
                                    <option>Daughter in Law</option>
                                    <option>Son in Law</option>
                                    <option>Sister in Law</option>
                                    <option>Brother in Law</option>
                                    <option>Father in Law</option>
                                    <option>Mother in Law</option>
                                    <option>Live-in Partner</option>
                                    <option>Deceased</option>
                                    <option>Others</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Respondent :</td>
                            <td><input type="text" name="gen_res" value="" class="form-control" /> </td>
                        </tr>
                        <tr class="has-group">
                            <td>Contact No :</td>
                            <td><input type="text" name="gen_con" value="" class="form-control"  /> </td>
                        </tr>
                        <tr class="has-group">
                            <td>House No. & Street Name :<br/> <small class="text-info"><em>(Residential Address)</em></small></td>
                            <td><input type="text" name="gen_hou_r" value="" class="form-control"  /> </td>
                        </tr>
                        <tr class="has-group">
                            <td>Barangay :<br/> <small class="text-info"><em>(Residential Address)</em></small></td>
                            <td>
                                <select name="gen_bar_r" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Municipality :<br/> <small class="text-info"><em>(Residential Address)</em></small></td>
                            <td>
                                <select name="gen_mun_r" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Province :<br/> <small class="text-info"><em>(Residential Address)</em></small></td>
                            <td>
                                <select name="gen_pro_r" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Sex :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" checked name="gen_sex" class="sex" value="Male"  style="display:inline;"> Male</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="gen_sex" class="sex" value="Female" > Female</label>
                                <span class="span"></span>
                            </td>
                        </tr>
                        <tr class="has-group unmetClass">
                            <td>Age :</td>
                            <td>
                                <div class="form-inline">
                                    <input type="text" name="gen_age" class="form-control" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Religion :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="gen_reli" value="RC"  style="display:inline;"> RC</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="gen_reli" value="Christian" > Christian</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="gen_reli" value="INC"  style="display:inline;"> INC</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="gen_reli" value="Islam" > Islam</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="gen_reli" value="Jehovah"  style="display:inline;"> Jehovah</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <input type="text" name="gen_reli_oth" ><label style="cursor: pointer;"> Others</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Birth Date(mm/dd/yyyy) :</td>
                            <td><input type="date" name="gen_dob" id="dob" class="form-control" value=""  /> </td>
                        </tr>
                        <tr class="has-group">
                            <td>Barangay :<br/> <small class="text-info"><em>(Birthplace)</em></small></td>
                            <td>
                                <select name="gen_bar_p" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Municipality :<br/> <small class="text-info"><em>(Birthplace)</em></small></td>
                            <td>
                                <select name="gen_mun_p" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Province :<br/> <small class="text-info"><em>(Birthplace)</em></small></td>
                            <td>
                                <select name="gen_pro_p" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Years. at Current Address:</td>
                            <td>
                                <input type="number" name="gen_rel_yrs" class="form-control">
                            </td>
                        </tr>

                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#level_of_education" aria-expanded="false" aria-controls="collapseExample">
                    LEVEL OF EDUCATION
                </a>
                <div class="collapse" id="level_of_education">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Level of Education :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="lvl_edu[]" value="elementary" > Elementary</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="lvl_edu[]" value="high_school" > High School</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="lvl_edu[]" value="vocational" > Vocational</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="lvl_edu[]" value="no_complete_school" > No Completed Schooling</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#phic" aria-expanded="false" aria-controls="collapseExample">
                    PHIC MEMBERSHIP OF PRINCIPAL <small class="text-warning" style="color: white"><em>(PARENTS)</em></small>
                </a>
                <div class="collapse" id="phic">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Status :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_stat" value="member"  style="display:inline;"> Member</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_stat" value="dependent" > Dependent</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_stat" value="non_member" > Non-Member</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Type :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="lifetime"  style="display:inline;"> Lifetime</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="sponsored" > Sponsored</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="doh" > DOH</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="plgu" > PLGU</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="mlgu" > MLGU</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="private" > Private</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="employed" > Employed</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="government" > Government</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="phi_typ" value="self_employed" > Self-Employed</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <input type="text" name="phi_typ_oth" > <label style="cursor: pointer;">Others</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Are you aware of your PHIC benefits? :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="phi_ben" value="yes"  style="display:inline;"> Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="phi_ben" value="no" > No</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <input type="text" name="phi_ben_spe" > <label style="cursor: pointer;">If yes, specify</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#family_history" aria-expanded="false" aria-controls="collapseExample">
                    FAMILY HISTORY <small style="color: white"><em>(Among mother,father,and siblings. Tick all that apply.)</em></small>
                </a>
                <div class="collapse" id="family_history">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Family History :</td>
                            <td class="has-group">
                                <input type="checkbox" name="fam_his[]" value="alergy"> <label style="cursor: pointer;">Allergy, specify:</label> <input type="text" name="ale_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="astma" > Asthma</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="cancer" > Cancer, specify organ:</label> <input type="text" name="can_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="immune" > Immune Deficiency Disease, specify:</label> <input type="text" name="imm_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="epilepsy" > Epilepsy/Seizure Disorder, specify:</label> <input type="text" name="epi_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="heart_disease" > Heart Disease &/or Heart Attach, specify:</label> <input type="text" name="hea_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="kidney" > Kidney Disease, specify:</label> <input type="text" name="kid_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="mental" > Mental Health Condition</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="thyroid" > Thyroid Disease</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="fam_his[]" value="tuberculosis" > Tuberculosis</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#medical_history" aria-expanded="false" aria-controls="collapseExample">
                    MEDICAL HISTORY OF CACCINEE <small style="color: white"><em>(Tick all past and present health condition of the respondent.)</em></small>
                </a>
                <div class="collapse" id="medical_history">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Medical History :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="alergy"> Allergy, specify:</label> <input type="text" name="m_ale_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="astma" > Asthma (Fill-up Bronchial Astma Section)</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="tuberculosis" > Tuberculosis (If yes, fill-up Tuberculosis Section):</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="peptic" > Peptic Ulcer Disease:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="diabetes" > Diabetes mellitus (Fill-up Diabetes Mellitus Section)</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="urinary" > Urinary Tract Infection:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="malaria" > Malaria </label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="pnuemonia" > Pnuemonia</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="epilepsy" > Epilepsy/Seizure Disorder, specify:</label> <input type="text" name="med_epi_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="kidney" > Kidney Disease, specify:</label> <input type="text" name="med_kid_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="immune" > Immune Deficiency Disease: specify</label> <input type="text" name="med_imm_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="hepatitis" > Hepatitis, specify:</label> <input type="text" name="med_hep_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="heart" > Heart Disease, specify:</label> <input type="text" name="med_hea_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="poisoning" > Poisoning, specify:</label> <input type="text" name="med_poi_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="stis" > STIs, specify:</label> <input type="text" name="med_sti_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="thyroid" > Thyroid Disease, specify:</label> <input type="text" name="med_thy_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="cancer" > Cancer, specify:</label> <input type="text" name="med_can_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" value="others" > Others, specify:</label> <input type="text" name="med_oth_spe">
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Disability :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="psychosocial"> Psychosocial and Behavioral Conditions:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="learning" > Learning or Intellectual Disability</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="mental" > Mental Condition</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="visual" > Visual or Seeing Impairment</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="hearing" > Hearing Impairement</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="speech" > Speech Impairment</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="musculo" > Musculo-Skeletal or injury impairments</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"> Give description of disability:</label> <textarea name="dis[]" ></textarea>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="with_assistive" > With assistive device/s? <input type="radio" name="wit_ass_yes" value="yes" > Yes, specify:</label> <input type="text" name="with_ass_spe" > <label style="cursor: pointer;"><input type="radio" name="with_ass_no" value="no" > No </label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="dis[]" value="need_assistive" > Need for assistive device/s? <input type="radio" name="need_ass_yes" value="yes" > Yes, specify:</label> <input type="text" name="need_ass_spe"> <label style="cursor: pointer;"><input type="radio" name="need_ass_no" value="no" > No </label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Injury :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="inj[]" value="vehicular"> Vehicular Accident/Traffic-Related Injuries</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="inj[]" value="burns" > Burns</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="inj[]" value="mental" > Drowning</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="inj[]" value="visual" > Fall</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <textarea name="inj[]" ></textarea> <label style="cursor: pointer;"> MEDICATIONS (List all current medicines <br>and food supplements being taken):</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#hospital_history" aria-expanded="false" aria-controls="collapseExample">
                    HOSPITALIZATION HISTORY <small style="color: white"><em>(List all past and current hospitalization/s.)</em></small>
                </a>
                <div class="collapse" id="hospital_history">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover"  border="1">
                            <tr class="has-group">
                                <th> </th>
                                <th colspan="2"> Where you previously hospitalized?</th>
                                <th colspan="3"><input type="radio" name="hos_pre" value="yes"> Yes <input type="radio" name="hos_pre" value="no"> No</th>
                            </tr>
                            <tr class="has-group">
                                <th> </th>
                                <th> Resason/Diagnosis</th>
                                <th> Date Hospitalized</th>
                                <th> Place Hospitalized</th>
                                <th> Philhealth used? Y/N</th>
                                <th> Cost/s not covered by PhilHealth?</th>
                            </tr>
                            @for($i = 1; $i<=5; $i++)
                            <tr class="has-group">
                                <td>{{ $i }}</td>
                                <td><input type="text" name="hos_rea[]"></td>
                                <td><input type="text" name="hos_dat[]"></td>
                                <td><input type="text" name="hos_pla[]"></td>
                                <td><input type="text" name="hos_phi[]"></td>
                                <td><input type="text" name="hos_cos[]"></td>
                            </tr>
                            @endfor
                        </table>
                    </div>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#surgical_history" aria-expanded="false" aria-controls="collapseExample">
                    PAST SURGICAL HISTORY <small style="color: white"><em>(Tick all operations,both minor and major,underwent by the respondent.)</em></small>
                </a>
                <div class="collapse" id="surgical_history">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <th> </th>
                            <th> Operation</th>
                            <th> Date From</th>
                            <th> Date To</th>
                        </tr>
                        @for($i = 1; $i<=5; $i++)
                            <tr class="has-group">
                                <td style="width: 5%">{{ $i }}</td>
                                <td><input type="date" name="sur_ope[]" class="form-control"></td>
                                <td><input type="date" name="sur_to[]" class="form-control"></td>
                                <td><input type="date" name="sur_fro[]" class="form-control"></td>
                            </tr>
                        @endfor
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#social_history" aria-expanded="false" aria-controls="collapseExample">
                    PERSONAL/SOCIAL HISTORY
                </a>
                <div class="collapse" id="social_history">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>
                                Have you tried smoking?
                            </td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="soc_smo" value="never_smoked" > Never Smoked</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_smo" value="current_smoker" > Current Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_smo" value="former_smoker" > Current Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_smo" value="secondhand_smoker" > Secondhand Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_smo" value="thirdhand_smoker" > Thirdhand Smoker</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Age started:</td>
                            <td class="has-group"><input type="text" value="" name="soc_age_sta" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Age quit:</td>
                            <td class="has-group"><input type="text" value="" name="soc_age_qui" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>No. of stick/s per day:</td>
                            <td class="has-group"><input type="text" value="" name="soc_sti_day" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>No. of Pack-Years:</td>
                            <td class="has-group"><input type="text" value="" name="soc_sti_yea" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Do you eat fast food/street food(e.g. instant noodles,canned goods,fries,fried chicken skin,etc) weekly?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="soc_fas_foo" value="yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_fas_foo" value="no" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Do you eat 3 servings of vegetable daily?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="soc_veg" value="yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_veg" value="no" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Do you eat 2-3 servings of fruits daily?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="soc_fru" value="yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_fru" value="no" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Does at least 30 minutes per day of moderate-to vigorous-intensity physical activity?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="soc_act" value="yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_act" value="no" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Have you tried drinking alcohol?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="soc_alc" value="yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_alc" value="no" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>In the past 5 months, have you drunk alcohol?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="soc_dru" value="yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_dru" value="no" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Ever tried any illicit drug/substance?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="soc_ill" value="yes" > Yes, specify:</label> <input type="text" name="soc_dru_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="soc_ill" value="no" > No</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#menstrual" aria-expanded="false" aria-controls="collapseExample">
                    MENSTRUAL AND GYNECOLOGICAL HISTORY<small style="color: white"><em>(for female respondent only)</em></small>
                </a>
                <div class="collapse" id="menstrual">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Age of Menarche:</td>
                            <td class="has-group"><input type="text" value="" name="men_age_sta" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Date of Last Mendtrual Period:</td>
                            <td class="has-group"><input type="date" value="" name="men_per" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Duration(number of days):</td>
                            <td class="has-group"><input type="text" value="" name="men_day" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Interval/Cycle:</td>
                            <td class="has-group"><input type="text" value="" name="men_cyc" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>
                                Gyne History(Abnormal signs and symptoms: Tick all that apply)
                            </td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="gyn_his[]" value="abnormal_vaginal" > Abnormal Vaginal/Uterine Bleeding</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="gyn_his[]" value="dysmenorrhea" > Current Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="gyn_his[]" value="dyspareunia" > Current Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="gyn_his[]" value="foul_smelling" > Secondhand Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="gyn_his[]" value="vaginal_pruritus" > Thirdhand Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Others, specify:</label> <input type="text" name="gyn_his_oth" >
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#vaccination_history" aria-expanded="false" aria-controls="collapseExample">
                    VACCINATION HISTORY
                </a>
                <div class="collapse" id="vaccination_history">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>
                                Vaccine/s received:
                            </td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_his[]" value="mr" > MR</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_his[]" value="dyphteria" > Diphteria/Tetanus</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_his[]" value="mmr" > MMR</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_his[]" value="hpv" > HPV</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_his[]" value="doses" > Tetanus Toxoid, No. of Doses:</label> <input type="text" name="vac_dos" >
                            </td>
                        </tr>
                        @foreach(range(1,3) as $index)
                        <tr class="has-group">
                            <td></td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_deng[]" value="vac_deng{{ $index }}" > DENGVAXIA {{ $index }}</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Date Received</td>
                            <td>
                                <input type="date" name="vac_dat_rec[]" class="form-control">
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Place Received</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_sch[]" value="school{{ $index }}"> School</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_hea_cen[]" value="heath_center{{ $index }}"> Health Center/Community</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="vac_priv[]" value="priv{{ $index }}"> Priv. MD</label>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="has-group">
                            <td>Dewormed?</td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="vac_dew" value="yes"> Yes</label> <label style="cursor: pointer;">,date last dewormed:</label> <input type="date" name="vac_dew_las">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="vac_dew" value="no"> No</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#review_system" aria-expanded="false" aria-controls="collapseExample">
                    REVIEW OF SYSTEMS<small style="color: white"><em>(Tick all that apply)</em></small>
                </a>
                <div class="collapse" id="review_system">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>
                                REVIEW OF SYSTEMS:
                            </td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="jaundice" > Jaundice</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="pailor" > Pailor</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="rashes" > Rashes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="severe_headache" > Severe/Recurrent Headache</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="sever_dizziness" > Severe/Recurrent Dizziness</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="blurring" > Blurring og vision</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="seizures" > Seizures</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="fatigability" > Easy Fatigability</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="cough" > Cough/Colds</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="dyspnea" > Dyspnea</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="orthopnea" > Orthopnea</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="chest_pain" > Chest Pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="palpitations" > Palpitations</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="murmur" > Murmur</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="breast_pain" > Breast Pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="nausea" > Nausea and/or vomiting</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="severe" > Severe/Recurrent abdominal pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="recurrent" > Recurrent Constipation</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="diarrhea" > Diarrhea</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="polyphagia" > Polyphagia</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="polydypsia" > Polydypsia</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="polyuria" > Polyuria</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="vaginal_bleeding" > Vaginal bleeding</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="smelling_vaginal" > Foul Smelling Vaginal</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="Urethral discharge" > Urethral discharge</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="dysuria" > Dysuria</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="leg_pain" > Leg pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="joint_pain" > Joint Pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="muscle_wasting" > Muscle Wasting</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="muscle_weakness" > Muscle Weakness</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="rev_sys[]" value="weight_loss" > Weight Loss</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Others,specify: </label> <input type="text" name="rev_oth" >
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#pertinent_physical" aria-expanded="false" aria-controls="collapseExample">
                    PERTINENT PHYSICAL EXAMINATION
                </a>
                <div class="collapse" id="pertinent_physical">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>General Status:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="per_gen" value="oriented_time" > Oriented to Time, Place, and Date</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="per_gen" value="conscious" > Conscious</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="per_gen" value="ambulatory" > Ambulatory</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="per_gen" value="others" > Others, specify:</label> <input type="text" name="pertinent_general_others" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Vital Signs:</td>
                            <td>
                                <label style="cursor: pointer;">BP:</label> <input type="text" name="per_vit_bp" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">HR:</label> <input type="text" name="per_vit_hr" > <label style="cursor: pointer;">/min</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">RR:</label> <input type="text" name="per_vit_rr" > <label style="cursor: pointer;">/min</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Temp:</label> <input type="text" name="per_vit_tem" > <label style="cursor: pointer;">Degree Celcius</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Blood Type:</label> <input type="text" name="per_vit_blo" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Weight(kg):</label> <input type="text" name="per_vit_wei" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Height(m):</label> <input type="text" name="per_vit_hei" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">BMI:</label> <input type="text" name="per_vit_bmi" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Waist(cm):</label> <input type="text" name="per_vit_wai" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Hip(cm):</label> <input type="text" name="per_vit_hip" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">W/H Ratio:</label> <input type="text" name="per_vit_rat" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>SKIN:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ski" value="good_skin" > Good Skin Turgor</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ski" value="pailor" > Pallor</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ski" value="jaundice" > Jaundice</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ski" value="rashes" > Rashes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ski" value="lesions" > Lesions,specify others:</label> <input type="text" name="per_ski_oth" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>HEENT:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="no_significant" > No significant findings</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="yellowish_sclerae" > Yellowish Sclerae</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="pale_conjunctive" > Pale Conjunctive</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="visual_acuity" > Visual Acuity:</label> <input type="text" name="pertinent_visual_others" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="alar_flaring" > Alar flaring:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="nasal_discharge" > Nasal discharge:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="cleft_lip" > Cleft lip:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="cleft_palate" > Cleft palate:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="ear_discharge" > Ear discharge:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="enlarged_tonsils" > Enlarged Tonsils:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="enlarged_thyroid" > Enlarged Thyroid:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="palpable_mass" > Palpable mass, specify site:</label> <input type="text" name="per_pal_spe" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hee[]" value="others" > Others,specify:</label> <input type="text" name="per_oth_spe" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>CHEST AND LUNGS:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="per_che[]" value="no_significant" > No significant findings</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_che[]" value="chest_retractions" > Chest retractions</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_che[]" value="crackles" > Crackles/Rales/Harsh breath sounds</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_che[]" value="wheezes" > Wheezes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_che[]" value="breast_mass" > Breast mass/discharge</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_che[]" value="others" > Others,specify:</label> <input type="text" name="per_che_oth" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>HEART:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hea[]" value="no_significant" > No significant findings</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hea[]" value="irregular_pulse" > Irregular pulse</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hea[]" value="cyanosis" > Cyanosis(lips,nails)</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_hea[]" value="others" > Others,specify:</label> <input type="text" name="per_hea_oth" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>ABDOMEN:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="per_abd[]" value="no_significant" > No significant findings</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_abd[]" value="ternerness" > Ternerness</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_abd[]" value="palpable_mass" > Palpable mass, specify site:</label> <input type="text" name="pertinent_abdomen_site" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_abd[]" value="others" > Others,specify:</label> <input type="text" name="per_abd_oth" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>EXTREMITIES:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ext[]" value="abnormal_gait" > Abnormal gait</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ext[]" value="ederma" > ederma</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ext[]" value="joint_swelling" > Joint swelling:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ext[]" value="gross_deformity,describe:" > Joint swelling:</label> <input type="text" name="per_ext_des" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="per_ext[]" value="others" > Others,specify:</label> <input type="text" name="per_ext_oth" >
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#bronchial_asthma" aria-expanded="false" aria-controls="collapseExample">
                    BRONCHIAL ASTHMA
                </a>
                <div class="collapse" id="bronchial_asthma">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td> </td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="bro_dia" value="diagnosed" > Diagnosed</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="bro_dia" value="not_diagnosed" > Not Diagnosed</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>No. of attacks per week:</td>
                            <td>
                                <input type="text" name="bro_att" class="form-control" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>With Medications?</td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="bro_med" value="yes" > Yes, specify:</label> <input type="text" name="bro_spe" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="bro_med" value="no" > No</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#tuberculosis" aria-expanded="false" aria-controls="collapseExample">
                    TUBERCULOSIS
                </a>
                <div class="collapse" id="tuberculosis">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Any of the following?(Tick all that apply)</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_fol[]" value="weight_loss" > Weight loss</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_fol[]" value="fever" > Fever</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_fol[]" value="loss_appetite" > Loss Appetite</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_fol[]" value="cough" > Cough > 2 weeks</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_fol[]" value="chest_pain" > Chest pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_fol[]" value="back_pain" > Back pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_fol[]" value="neck_nodes" > Neck nodes</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Labs done:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_lab[]" value="ppd" > PPD</label> <label style="cursor: pointer;">Result:</label> <input type="text" name="bro_ppd_res" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_lab[]" value="sputum_exam" > Sputum Exam</label> <label style="cursor: pointer;">Result:</label> <input type="text" name="bro_spu_res" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_lab[]" value="cxr" > CXR</label> <label style="cursor: pointer;">Result:</label> <input type="text" name="bro_cxr_res" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="bro_lab[]" value="genxpert" > GenXpert</label> <label style="cursor: pointer;">Result:</label> <input type="text" name="pro_gen_res" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Diagnosed with TB this year?</td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="tb_dia" value="yes" > If Yes, form of TB:</label> <input type="text" name="tb_for" >
                                &nbsp;<label style="cursor: pointer;"><input type="radio" name="tb_dia" value="no" > No</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tb_dia" value="smear_positive" > New, smear positive</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tb_dia" value="smear_negative" > New, smear negative</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tb_dia" value="relapse" > Relapse</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tb_dia" value="smear_positive" > Extrapulmonary, specify:</label> <input type="radio" name="tb_ext_spe" value="catI" > Cat I <input type="radio" name="tb_ext_spe" value="catII" > Cat I <input type="radio" name="tb_ext_spe" value="catIII" > Cat III <input type="radio" name="tb_ext_spe" value="in_children" > TB in Children
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tb_dia" value="clinically_diagnosed" > Clinically diagnosed</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tb_dia" value="in_children" > TB in Children</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#other_procedure" aria-expanded="false" aria-controls="collapseExample">
                    OTHER PROCEDURE DONE
                </a>
                <div class="collapse" id="other_procedure">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td></td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="oth_pro_don[]" value="cbc" > CBC</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="oth_pro_don[]" value="urinalysis" > urinalysis</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="oth_pro_don[]" value="chest" > Chest X-ray, Specify Finding (Result)</label> <input type="text" name="oth_che_spe" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="oth_pro_don[]" value="enzymes" > Enzymes Based Rapid Diagnostic Test for Dengue, Specify result:</label> <input type="radio" name="oth_che_igg" value="igg_positive"> IgG Positive <input type="radio" name="enzymes_result" value="oth_che_igm"> IgM Positive
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="oth_pro_don[]" value="ns1_test" > NS1 Test</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="oth_pro_don[]" value="pcr" > PCR</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#summary" aria-expanded="false" aria-controls="collapseExample">
                    SUMMARY
                </a>
                <div class="collapse" id="summary">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <th style="text-align: center;width:33.3%;">Summary of Findings and Issues</th>
                            <th style="text-align: center;width:33.3%;">Referred To</th>
                            <th style="text-align: center;width:33.3%;">Other Actions Taken</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea name="sum_fin" id="" rows="10" class="form-control"></textarea>
                            </td>
                            <td>
                                <textarea name="sum_ref" id="" rows="10" class="form-control"></textarea>
                            </td>
                            <td>
                                <textarea name="sum_oth" id="" rows="10" class="form-control"></textarea>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-hover"  border="1" style="margin-top:-20px;">
                        <tr class="has-group">
                            <th>Assessed by NDP:</th>
                            <th>Noted by DMO IV:</th>
                        </tr>
                        <tr>
                            <td style="width:50%;">
                                <input type="text" class="form-control" name="sum_ass">
                            </td>
                            <td style="width:50%;">
                                <input type="text" class="form-control" name="sum_not">
                            </td>
                        </tr>
                    </table>
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
    @include('sidebar')
    @include('modal.profile')
@endsection

@section('js')

@endsection