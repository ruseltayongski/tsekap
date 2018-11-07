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
            @if(Session::has('deng_updated'))
                <div class="alert alert-success">
                    <font class="text-success">
                        <i class="fa fa-check"></i> {{ Session::get('deng_updated') }}
                    </font>
                </div>
            @endif
            <?php
                if($dengvaxia->id)
                    $dengvaxiaId = $dengvaxia->id;
                else
                    $dengvaxiaId = "No_Id";

                \Request::segments()[0] == "form_dengvaxia_add" ? Session::set("dengvaxia_option","add") : Session::set("dengvaxia_option","update");
            ?>
            <form method="POST" class="form-horizontal form-submit" id="form-submit" action="{{ asset('post_dengvaxia').'/'.$dengvaxiaId.'/'.$unique_id.'/'.$tsekap_id }}">
                {{ csrf_field() }}
                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#general_information" role="button" aria-expanded="false" aria-controls="collapseExample">
                    GENERAL INFORMATION
                </a>
                <div class="collapse" id="general_information">
                    <table class="table table-bordered table-hover"  border="1">
                        <tr>
                            <td>Last Name :</td>
                            <td><input type="text" value="{{ $dengvaxia->lname }}" name="lname" class="form-control" /></td>
                        </tr>

                        <tr>
                            <td>First Name :</td>
                            <td><input type="text" value="{{ $dengvaxia->fname }}" name="fname" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Middle Initial :</td>
                            <td>
                                <input type="text" value="{{ $dengvaxia->mname }}" name="mname" class="form-control" />
                            </td>
                        </tr>
                        <tr class="relation has-group" >
                            <td>Extension: Sr,Jr Etc :</td>
                            <td>
                                <select name="suffix" class="form-control chosen-select" id="suffix" style="width: 100%">
                                    <option value="">Select...</option>
                                    <option <?php if($dengvaxia->suffix=='Jr.') echo 'selected'; ?>>Jr.</option>
                                    <option <?php if($dengvaxia->suffix=='Sr.') echo 'selected'; ?>>Sr.</option>
                                    <option <?php if($dengvaxia->suffix=='I') echo 'selected'; ?>>I</option>
                                    <option <?php if($dengvaxia->suffix=='II') echo 'selected'; ?>>II</option>
                                    <option <?php if($dengvaxia->suffix=='III') echo 'selected'; ?>>III</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Relation to Head :</td>
                            <td>
                                <select name="head" id="relation" class="form-control chosen-select" style="width: 100%">
                                    <option value="">Select...</option>
                                    <option <?php if($dengvaxia->head=='Son') echo 'selected'; ?>>Son</option>
                                    <option <?php if($dengvaxia->head=='Daughter') echo 'selected'; ?>>Daughter</option>
                                    <option <?php if($dengvaxia->head=='Wife') echo 'selected'; ?>>Wife</option>
                                    <option <?php if($dengvaxia->head=='Husband') echo 'selected'; ?>>Husband</option>
                                    <option <?php if($dengvaxia->head=='Father') echo 'selected'; ?>>Father</option>
                                    <option <?php if($dengvaxia->head=='Mother') echo 'selected'; ?>>Mother</option>
                                    <option <?php if($dengvaxia->head=='Brother') echo 'selected'; ?>>Brother</option>
                                    <option <?php if($dengvaxia->head=='Sister') echo 'selected'; ?>>Sister</option>
                                    <option <?php if($dengvaxia->head=='Nephew') echo 'selected'; ?>>Nephew</option>
                                    <option <?php if($dengvaxia->head=='Niece') echo 'selected'; ?>>Niece</option>
                                    <option <?php if($dengvaxia->head=='Grandfather') echo 'selected'; ?>>Grandfather</option>
                                    <option <?php if($dengvaxia->head=='Grandmother') echo 'selected'; ?>>Grandmother</option>
                                    <option <?php if($dengvaxia->head=='Grandson') echo 'selected'; ?>>Grandson</option>
                                    <option <?php if($dengvaxia->head=='Granddaughter') echo 'selected'; ?>>Granddaughter</option>
                                    <option <?php if($dengvaxia->head=='Cousin') echo 'selected'; ?>>Cousin</option>
                                    <option <?php if($dengvaxia->head=='Relative') echo 'selected'; ?>>Relative</option>
                                    <option <?php if($dengvaxia->head=='Daughter in Law') echo 'selected'; ?>>Daughter in Law</option>
                                    <option <?php if($dengvaxia->head=='Son in Law') echo 'selected'; ?>>Son in Law</option>
                                    <option <?php if($dengvaxia->head=='Sister in Law') echo 'selected'; ?>>Sister in Law</option>
                                    <option <?php if($dengvaxia->head=='Brother in Law') echo 'selected'; ?>>Brother in Law</option>
                                    <option <?php if($dengvaxia->head=='Father in Law') echo 'selected'; ?>>Father in Law</option>
                                    <option <?php if($dengvaxia->head=='Mother in Law') echo 'selected'; ?>>Mother in Law</option>
                                    <option <?php if($dengvaxia->head=='partner') echo 'selected'; ?>>Live-in Partner</option>
                                    <option <?php if($dengvaxia->head=='Deceased') echo 'selected'; ?>>Deceased</option>
                                    <option <?php if($dengvaxia->head=='Others') echo 'selected'; ?>>Others</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Respondent :</td>
                            <td><input type="text" name="gen_res" value="{{ $dengvaxia->gen_res }}" class="form-control" /> </td>
                        </tr>
                        <tr class="has-group">
                            <td>Contact No :</td>
                            <td><input type="text" name="gen_con" value="{{ $dengvaxia->gen_con }}" class="form-control"  /> </td>
                        </tr>
                        <tr class="has-group">
                            <td>House No. & Street Name :<br/> <small class="text-info"><em>(Residential Address)</em></small></td>
                            <td><input type="text" name="gen_hou_r" value="{{ $dengvaxia->gen_hou_r }}" class="form-control"  /> </td>
                        </tr>
                        <tr class="has-group">
                            <td>Barangay :<br/> <small class="text-info"><em>(Residential Address)</em></small></td>
                            <td>
                                <select name="barangay_id" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                    @foreach(\App\Barangay::get() as $row)
                                        <option <?php if($dengvaxia->barangay_id==$row->id) echo 'selected'; ?> value="{{ $row->id }}">{{ $row->description }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Municipality :<br/> <small class="text-info"><em>(Residential Address)</em></small></td>
                            <td>
                                <select name="muncity_id" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                    @foreach(\App\Muncity::get() as $row)
                                        <option <?php if($dengvaxia->muncity_id==$row->id) echo 'selected'; ?> value="{{ $row->id }}">{{ $row->description }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Province :<br/> <small class="text-info"><em>(Residential Address)</em></small></td>
                            <td>
                                <select name="province_id" class="form-control chosen-select"  style="width: 100%">
                                    <option value="">Select...</option>
                                    @foreach(\App\Province::get() as $row)
                                        <option <?php if($dengvaxia->province_id==$row->id) echo 'selected'; ?> value="{{ $row->id }}">{{ $row->description }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Sex :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" <?php if(strcasecmp("Male", $dengvaxia->sex) == 0) echo 'checked'; ?> name="sex" class="sex" value="Male" style="display:inline;"> Male</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" <?php if(strcasecmp("Female", $dengvaxia->sex) == 0) echo 'checked'; ?> name="sex" class="sex" value="Female" > Female</label>
                                <span class="span"></span>
                            </td>
                        </tr>
                        <tr class="has-group unmetClass">
                            <td>Age :</td>
                            <td>
                                <div class="form-inline">
                                    <input type="text" name="gen_age" value="{{ $dengvaxia->gen_age }}" class="form-control" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Religion :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->gen_reli=='RC') echo 'checked'; ?> name="gen_reli" value="RC"  style="display:inline;"> RC</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->gen_reli=='Christian') echo 'checked'; ?> name="gen_reli" value="Christian" > Christian</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->gen_reli=='INC') echo 'checked'; ?> name="gen_reli" value="INC"  style="display:inline;"> INC</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->gen_reli=='Islam') echo 'checked'; ?> name="gen_reli" value="Islam" > Islam</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->gen_reli=='Jehovah') echo 'checked'; ?> name="gen_reli" value="Jehovah"  style="display:inline;"> Jehovah</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <input type="radio" <?php if(strpos($dengvaxia->gen_reli, 'Others') !== false) echo 'checked'; ?> name="gen_reli" value="Others" style="display:inline;">
                                <label style="cursor: pointer;">Others:</label>
                                <input type="text" value="<?php if (strpos($dengvaxia->gen_reli, '-') !== false) echo explode(' - ',$dengvaxia->gen_reli)[1]; ?>" name="gen_reli_oth" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Birth Date(mm/dd/yyyy) :</td>
                            <td><input type="date" name="dob" id="dob" class="form-control" value="{{ $dengvaxia->dob }}" /> </td>
                        </tr>
                        <tr class="has-group">
                            <td>Birthplace (Mun/City/Prov):</td>
                            <td>
                                <input type="text" name="birthplace" value="{{ $dengvaxia->birthplace }}" class="form-control" />
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Years. at Current Address:</td>
                            <td>
                                <input type="number" name="gen_rel_yrs" value="{{ $dengvaxia->gen_rel_yrs }}" class="form-control">
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
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->education=='Elementary') echo 'checked'; ?> name="education" value="Elementary" > Elementary</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->education=='High School') echo 'checked'; ?> name="education" value="High School" > High School</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->education=='Vocational') echo 'checked'; ?> name="education" value="Vocational" > Vocational</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" <?php if($dengvaxia->education=='No Completed Schooling') echo 'checked'; ?> name="education" value="No Completed Schooling" > No Completed Schooling</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#phic" aria-expanded="false" aria-controls="collapseExample">
                    PHIC MEMBERSHIP OF PRINCIPAL <small class="text-warning" style="color: white"><em>(PARENTS)</em></small>
                </a>
                <div class="collapse" id="phic" style="padding: 0;">
                    <table class="table table-bordered table-hover" border="1">
                        <?php $phic = json_decode($dengvaxia->phic_membership) ?>
                        <tr class="has-group">
                            <td>Status :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="phic_status" <?php if(isset($phic->status)){if($phic->status=='Member')echo'checked';} ?> value="Member" style="display:inline;"> Member</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="phic_status" <?php if(isset($phic->status)){if($phic->status=='Dependent')echo'checked';} ?> value="Dependent" > Dependent</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="phic_status" <?php if(isset($phic->status)){if($phic->status=='Non-Member') echo 'checked';} ?> value="Non-Member" > Non-Member</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Type :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="phic_sponsoredby" <?php if(isset($phic->status)){if($phic->status=='Lifetime') echo 'checked';} ?> value="Lifetime" style="display:inline;"> Lifetime</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <div class="alert alert-warning">
                                    <font class="text-warning">
                                        <label style="cursor: pointer;"><input type="radio" name="phic_sponsoredby" <?php if(isset($phic->type)){if(strpos($phic->type, 'Sponsored') !== false) echo 'checked';} ?> value="Sponsored By" > Sponsored By:</label>
                                        &nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="phic_sponsored" <?php if(isset($phic->type)){if($phic->type=='Sponsored By DOH') echo 'checked';} ?> value="DOH" > DOH</label>
                                        &nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="phic_sponsored" <?php if(isset($phic->type)){if($phic->type=='Sponsored By PLGU') echo 'checked';} ?> value="PLGU" > PLGU</label>
                                        &nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="phic_sponsored" <?php if(isset($phic->type)){if($phic->type=='Sponsored By MLGU') echo 'checked';} ?> value="MLGU" > MLGU</label>
                                        &nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="phic_sponsored" <?php if(isset($phic->type)){if($phic->type=='Sponsored By Private') echo 'checked';} ?> value="Private" > Private</label>
                                        &nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="phic_sponsored" <?php if(isset($phic->type)){if(strpos($phic->type, 'Others') !== false) echo 'checked';} ?> value="Others" > Others:</label> <input type="text" name="phic_sponsored_others" value="<?php if(isset($phic->type)){if(strpos($phic->type, 'Others') !== false) echo explode(' - ',$phic->type)[1];} ?>" >
                                    </font>
                                </div>
                                <div class="alert alert-success">
                                    <font class="text-success">
                                        <label style="cursor: pointer;"><input type="radio" name="phic_employedby" <?php if(isset($phic->type)){if($phic->employment) echo 'checked';} ?> value="Employed By" > Employed By:</label>
                                        &nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="phic_employed" <?php if(isset($phic->type)){if($phic->employment=='Government') echo 'checked';} ?> value="Government" > Government</label>
                                        &nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="phic_employed" <?php if(isset($phic->type)){if($phic->employment=='Private') echo 'checked';} ?> value="Private" > Private</label>
                                        &nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="phic_employed" <?php if(isset($phic->type)){if($phic->employment=='Self-Employed') echo 'checked';} ?> value="Self-Employed" > Self-Employed</label>
                                    </font>
                                </div>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Are you aware of your PHIC benefits? :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="phic_ben" <?php if(isset($phic->benefit)){if(strpos($phic->benefit, ' - ') !== false) echo 'checked';} ?> value="Yes"  style="display:inline;"> Yes</label>
                                &nbsp;&nbsp;
                                <label style="cursor: pointer;"><input type="radio" name="phic_ben" <?php if(isset($phic->benefit)){if($phic->benefit=='No') echo 'checked';} ?> value="No" > No</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <input type="text" name="phic_ben_spe" value="<?php if(isset($phic->benefit)){if(strpos($phic->benefit, ' - ') !== false) echo explode(' - ',$phic->benefit)[1];} ?>" > <label style="cursor: pointer;">If yes, specify</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#family_history" aria-expanded="false" aria-controls="collapseExample">
                    FAMILY HISTORY <small style="color: white"><em>(Among mother,father,and siblings. Tick all that apply.)</em></small>
                </a>
                <div class="collapse" id="family_history">
                    <?php $fam_his = json_decode($dengvaxia->family_history); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Family History :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Allergy_fam)) echo 'checked'; ?> name="fam_his[]" value="Allergy_fam"> Allergy, specify:</label> <input type="text" value="<?php if(isset($fam_his->Allergy_fam)){if($Allergy_fam=explode(' - ',$fam_his->Allergy_fam)[1])echo $Allergy_fam;} ?>" name="Allergy_fam">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Asthma_fam)) echo 'checked'; ?> name="fam_his[]" value="Asthma_fam" > Asthma</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Cancer_fam)) echo 'checked'; ?> name="fam_his[]" value="Cancer_fam" > Cancer, specify organ:</label> <input type="text" value="<?php if(isset($fam_his->Cancer_fam)){if($Cancer_fam=explode(' - ',$fam_his->Cancer_fam)[1])echo $Cancer_fam;} ?>" name="Cancer_fam">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Immune_fam)) echo 'checked'; ?> name="fam_his[]" value="Immune_fam" > Immune Deficiency Disease, specify:</label> <input type="text" value="<?php if(isset($fam_his->Immune_fam)){if($Immune_fam=explode(' - ',$fam_his->Immune_fam)[1])echo $Immune_fam;} ?>" name="Immune_fam">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Epilepsy_fam)) echo 'checked'; ?> name="fam_his[]" value="Epilepsy_fam" > Epilepsy/Seizure Disorder, specify:</label> <input type="text" value="<?php if(isset($fam_his->Epilepsy_fam)){if($Epilepsy_fam=explode(' - ',$fam_his->Epilepsy_fam)[1])echo $Epilepsy_fam;} ?>" name="Epilepsy_fam">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Heart_fam)) echo 'checked'; ?> name="fam_his[]" value="Heart_fam" > Heart Disease &/or Heart Attach, specify:</label> <input type="text" value="<?php if(isset($fam_his->Heart_fam)){if($Heart_fam=explode(' - ',$fam_his->Heart_fam)[1])echo $Heart_fam;} ?>" name="Heart_fam">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Kidney_fam)) echo 'checked'; ?> name="fam_his[]" value="Kidney_fam" > Kidney Disease, specify:</label> <input type="text" value="<?php if(isset($fam_his->Kidney_fam)){if($Kidney_fam=explode(' - ',$fam_his->Kidney_fam)[1])echo $Kidney_fam;} ?>" name="Kidney_fam">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Mental_fam)) echo 'checked'; ?> name="fam_his[]" value="Mental_fam" > Mental Health Condition</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Thyroid_fam)) echo 'checked'; ?> name="fam_his[]" value="Thyroid_fam" > Thyroid Disease</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" <?php if(isset($fam_his->Tuberculosis_fam)) echo 'checked'; ?> name="fam_his[]" value="Tuberculosis_fam" > Tuberculosis</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#medical_history" aria-expanded="false" aria-controls="collapseExample">
                    MEDICAL HISTORY OF CACCINEE <small style="color: white"><em>(Tick all past and present health condition of the respondent.)</em></small>
                </a>
                <div class="collapse" id="medical_history">
                    <?php $med_his = json_decode($dengvaxia->medical_history); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Medical History :</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Allergy_med)) echo 'checked'; ?> value="Allergy"> Allergy, specify:</label> <input type="text" value="<?php if(isset($med_his->Allergy_med)){if($Allergy_med=explode(' - ',$med_his->Allergy_med)[1])echo $Allergy_med;} ?>" name="Allergy_med">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Asthma_med)) echo 'checked'; ?> value="Asthma" > Asthma (Fill-up Bronchial Astma Section)</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Tuberculosis_med)) echo 'checked'; ?> value="Tuberculosis_med" > Tuberculosis (If yes, fill-up Tuberculosis Section):</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Peptic)) echo 'checked'; ?> value="Peptic" > Peptic Ulcer Disease:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Diabetes)) echo 'checked'; ?> value="Diabetes" > Diabetes mellitus (Fill-up Diabetes Mellitus Section)</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Urinary)) echo 'checked'; ?> value="Urinary" > Urinary Tract Infection:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Malaria)) echo 'checked'; ?> value="Malaria" > Malaria </label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Pnuemonia)) echo 'checked'; ?> value="Pnuemonia" > Pnuemonia</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Epilepsy_med)) echo 'checked'; ?> value="Epilepsy_med" > Epilepsy/Seizure Disorder, specify:</label> <input type="text" value="<?php if(isset($med_his->Epilepsy_med)){if($Epilepsy_med=explode(' - ',$med_his->Epilepsy_med)[1])echo $Epilepsy_med;} ?>" name="Epilepsy_med">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Kidney_med)) echo 'checked'; ?> value="Kidney_med" > Kidney Disease, specify:</label> <input type="text" value="<?php if(isset($med_his->Kidney_med)){if($Kidney_med=explode(' - ',$med_his->Kidney_med)[1])echo $Kidney_med;} ?>" name="Kidney_med">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Immune_med)) echo 'checked'; ?> value="Immune_med" > Immune Deficiency Disease: specify</label> <input type="text" value="<?php if(isset($med_his->Immune_med)){if($Immune_med=explode(' - ',$med_his->Immune_med)[1])echo $Immune_med;} ?>" name="Immune_med">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Hepatitis)) echo 'checked'; ?> value="Hepatitis" > Hepatitis, specify:</label> <input type="text" value="<?php if(isset($med_his->Hepatitis)){if($Hepatitis=explode(' - ',$med_his->Hepatitis)[1])echo $Hepatitis;} ?>" name="Hepatitis">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Heart_med)) echo 'checked'; ?> value="Heart_med" > Heart Disease, specify:</label> <input type="text" value="<?php if(isset($med_his->Heart_med)){if($Heart_med=explode(' - ',$med_his->Heart_med)[1])echo $Heart_med;} ?>" name="Heart_med">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Poisoning)) echo 'checked'; ?> value="Poisoning" > Poisoning, specify:</label> <input type="text" value="<?php if(isset($med_his->Poisoning)){if($Poisoning=explode(' - ',$med_his->Poisoning)[1])echo $Poisoning;} ?>" name="Poisoning">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Stis)) echo 'checked'; ?> value="Stis" > STIs, specify:</label> <input type="text" value="<?php if(isset($med_his->Stis)){if($Stis=explode(' - ',$med_his->Stis)[1])echo $Stis;} ?>" name="Stis">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Thyroid_med)) echo 'checked'; ?> value="Thyroid_med" > Thyroid Disease, specify:</label> <input type="text" value="<?php if(isset($med_his->Thyroid_med)){if($Thyroid_med=explode(' - ',$med_his->Thyroid_med)[1])echo $Thyroid_med;} ?>" name="Thyroid_med">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Cancer_med)) echo 'checked'; ?> value="Cancer_med" > Cancer, specify:</label> <input type="text" value="<?php if(isset($med_his->Cancer_med)){if($Cancer_med=explode(' - ',$med_his->Cancer_med)[1])echo $Cancer_med;} ?>" name="Cancer_med">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="med_his[]" <?php if(isset($med_his->Others_med)) echo 'checked'; ?> value="Others_med" > Others, specify:</label> <input type="text" value="<?php if(isset($med_his->Others_med)){if($Others_med=explode(' - ',$med_his->Others_med)[1])echo $Others_med;} ?>" name="Others_med">
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#bronchial_asthma" aria-expanded="false" aria-controls="collapseExample">
                    BRONCHIAL ASTHMA
                </a>
                <div class="collapse" id="bronchial_asthma">
                    <?php $bronchial_asthma = json_decode($dengvaxia->bronchial_asthma); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td> </td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="diagnosed" <?php if(isset($bronchial_asthma->diagnosed)){if($bronchial_asthma->diagnosed == 'Yes')echo 'checked';} ?> value="Yes" > Diagnosed, No. of attacks per week:</label> <input type="text" value="<?php if(isset($bronchial_asthma->no_attacks)) echo $bronchial_asthma->no_attacks; ?>" name="no_attacks" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="diagnosed" <?php if(isset($bronchial_asthma->diagnosed)){if($bronchial_asthma->diagnosed == 'No')echo 'checked';} ?> value="No" > Not Diagnosed</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>With Medications?</td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="with_medication" <?php if(isset($bronchial_asthma->with_medication)){if(explode(' - ',$bronchial_asthma->with_medication)[0] == 'Yes')echo 'checked';} ?> value="Yes" > Yes, specify:</label> <input type="text" value="<?php if(isset($bronchial_asthma->with_medication)){if(isset(explode(' - ',$bronchial_asthma->with_medication)[1])){echo explode(' - ',$bronchial_asthma->with_medication)[1];}} ?>" name="with_medication_spe" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="with_medication" <?php if(isset($bronchial_asthma->with_medication)){if($bronchial_asthma->with_medication == 'No')echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#tuberculosis" aria-expanded="false" aria-controls="collapseExample">
                    TUBERCULOSIS
                </a>
                <div class="collapse" id="tuberculosis">
                    <?php $tuberculosis = json_decode($dengvaxia->tuberculosis); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Any of the following?(Tick all that apply)</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Weight_Loss)) echo 'checked'; ?> value="Weight_Loss" > Weight loss</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Fever)) echo 'checked'; ?> value="Fever" > Fever</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Loss_Appetite)) echo 'checked'; ?> value="Loss_Appetite" > Loss Appetite</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Cough)) echo 'checked'; ?> value="Cough" > Cough > 2 weeks</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Chest_Pain)) echo 'checked'; ?> value="Chest_Pain" > Chest pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Back_Pain)) echo 'checked'; ?> value="Back_Pain" > Back pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Neck_Nodes)) echo 'checked'; ?> value="Neck_Nodes" > Neck nodes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->New_smear_positive)) echo 'checked'; ?> value="New_smear_positive" > New, smear positive</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->New_smear_negative)) echo 'checked'; ?> value="New_smear_negative" > New, smear negative</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Relapse)) echo 'checked'; ?> value="Relapse" > Relapse</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Extrapulmonary)) echo 'checked'; ?> value="Extrapulmonary" > Extrapulmonary, specify:</label> <input type="text" value="<?php if(isset($tuberculosis->Any_Following->Extrapulmonary)){if(isset(explode(' - ',$tuberculosis->Any_Following->Extrapulmonary)[1]))echo explode(' - ',$tuberculosis->Any_Following->Extrapulmonary)[1];} ?>" name="Extrapulmonary" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->Clinically_Diagnosed)) echo 'checked'; ?> value="Clinically_Diagnosed" > Clinically diagnosed</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Any_Following[]" <?php if(isset($tuberculosis->Any_Following->TB_in_children)) echo 'checked'; ?> value="TB_in_children" > TB in Children</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Diagnosed with TB this year?</td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="Diagnosed" <?php if(isset($tuberculosis->Diagnosed)){if(strpos($tuberculosis->Diagnosed, 'Yes') !== false)echo 'checked';} ?> value="Yes" > If Yes, form of TB:</label> <input type="text" value="<?php if(isset($tuberculosis->Diagnosed)){if($Diagnosed=explode(' - ',$tuberculosis->Diagnosed)[1])echo$Diagnosed;} ?>" name="Diagnosed_Form" >
                                &nbsp;<label style="cursor: pointer;"><input type="radio" name="Diagnosed" <?php if(isset($tuberculosis->Diagnosed)){if($tuberculosis->Diagnosed=='No')echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Labs done:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="Labs_Done[]" <?php if(isset($tuberculosis->Labs_Done->PPD)) echo 'checked'; ?> value="PPD" > PPD</label> <label style="cursor: pointer;">Result:</label> <input type="text" value="<?php if(isset($tuberculosis->Labs_Done->PPD)){if($PPD=explode(' - ',$tuberculosis->Labs_Done->PPD)[1])echo$PPD;} ?>" name="PPD" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Labs_Done[]" <?php if(isset($tuberculosis->Labs_Done->Sputum_Exam)) echo 'checked'; ?> value="Sputum_Exam" > Sputum Exam</label> <label style="cursor: pointer;">Result:</label> <input type="text" value="<?php if(isset($tuberculosis->Labs_Done->Sputum_Exam)){if($Labs_Done=explode(' - ',$tuberculosis->Labs_Done->Sputum_Exam)[1])echo$Labs_Done;} ?>" name="Sputum_Exam" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Labs_Done[]" <?php if(isset($tuberculosis->Labs_Done->CXR)) echo 'checked'; ?> value="CXR" > CXR</label> <label style="cursor: pointer;">Result:</label> <input type="text" value="<?php if(isset($tuberculosis->Labs_Done->CXR)){if($Labs_Done=explode(' - ',$tuberculosis->Labs_Done->CXR)[1])echo$Labs_Done;} ?>" name="CXR" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Labs_Done[]" <?php if(isset($tuberculosis->Labs_Done->Genxpert)) echo 'checked'; ?> value="Genxpert" > GenXpert</label> <label style="cursor: pointer;">Result:</label> <input type="text" value="<?php if(isset($tuberculosis->Labs_Done->Genxpert)){if($Genxpert=explode(' - ',$tuberculosis->Labs_Done->Genxpert)[1])echo$Genxpert;} ?>" name="Genxpert" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Medications:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="Medications[]" <?php if(isset($tuberculosis->Medications->CatI)) echo 'checked'; ?> value="CatI" > Cat I</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Medications[]" <?php if(isset($tuberculosis->Medications->CatII)) echo 'checked'; ?> value="CatII" > Cat II</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Medications[]" <?php if(isset($tuberculosis->Medications->CatIII)) echo 'checked'; ?> value="CatIII" > Cat III </label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="Medications[]" <?php if(isset($tuberculosis->Medications->TTB_in_Children)) echo 'checked'; ?> value="TTB_in_Children" > TB in Children</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#disability" aria-expanded="false" aria-controls="collapseExample">
                    DISABILITY AND INJURY
                </a>
                <div class="collapse" id="disability">
                    <?php $disability_injury = json_decode($dengvaxia->disability_injury); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Disability and Injury</td>
                            <td class="has-group">
                                <label style="cursor: pointer;color: orange;">Disability</label>
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Psychosocial)) echo 'checked'; ?> value="Psychosocial"> Psychosocial and Behavioral Conditions:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Learning)) echo 'checked'; ?> value="Learning" > Learning or Intellectual Disability</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Mental)) echo 'checked'; ?> value="Mental" > Mental Condition</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Visual)) echo 'checked'; ?> value="Visual" > Visual or Seeing Impairment</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Hearing)) echo 'checked'; ?> value="Hearing" > Hearing Impairement</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Speech)) echo 'checked'; ?> value="Speech" > Speech Impairment</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Musculo)) echo 'checked'; ?> value="Musculo" > Musculo-Skeletal or injury impairments</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"> Give description of disability:</label> <textarea name="disability_description" ><?php if(isset($disability_injury->description)) echo $disability_injury->description; ?></textarea>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="with_assistive" <?php if(isset($disability_injury->with_assistive)){if(strpos($disability_injury->with_assistive, 'Yes') !== false) echo 'checked';} ?> value="with_assistive" > With assistive device/s? <input type="radio" name="with_assistive_diagnosed" <?php if(isset($disability_injury->with_assistive)){if(strpos($disability_injury->with_assistive, 'Yes') !== false) echo 'checked';} ?> value="Yes" > Yes, specify:</label> <input type="text" name="with_assistive_spe" value="<?php if(isset($disability_injury->with_assistive)){if(strpos($disability_injury->with_assistive, 'Yes') !== false) echo explode(' - ',$disability_injury->with_assistive)[1];} ?>" > <label style="cursor: pointer;"><input type="radio" name="with_assistive_diagnosed" <?php if(isset($disability_injury->with_assistive)){if(strpos($disability_injury->with_assistive, 'No') !== false) echo 'checked';} ?> value="No" > No </label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="need_assistive" <?php if(isset($disability_injury->need_assistive)){if(strpos($disability_injury->need_assistive, 'Yes') !== false) echo 'checked';} ?> value="need_assistive" > Need for assistive device/s? <input type="radio" name="need_assistive_diagnosed" <?php if(isset($disability_injury->need_assistive)){if(strpos($disability_injury->need_assistive, 'Yes') !== false) echo 'checked';} ?> value="Yes" > Yes, specify:</label> <input type="text" name="need_assistive_spe" value="<?php if(isset($disability_injury->need_assistive)){if(strpos($disability_injury->need_assistive, 'Yes') !== false) echo explode(' - ',$disability_injury->need_assistive)[1];} ?>" > <label style="cursor: pointer;"><input type="radio" name="need_assistive_diagnosed" <?php if(isset($disability_injury->need_assistive)){if(strpos($disability_injury->need_assistive, 'No') !== false) echo 'checked';} ?> value="No" > No </label>

                                <br>
                                <label style="cursor: pointer;color: orange;">Injury</label>
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Vehicular)) echo 'checked'; ?> value="Vehicular"> Vehicular Accident/Traffic-Related Injuries</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Burns)) echo 'checked'; ?> value="Burns" > Burns</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Drowning)) echo 'checked'; ?> value="Drowning" > Drowning</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="disability_injury[]" <?php if(isset($disability_injury->selected_options->Fall)) echo 'checked'; ?> value="Fall" > Fall</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <textarea name="injury_medication" ><?php if(isset($disability_injury->medication)) echo $disability_injury->medication; ?></textarea> <label style="cursor: pointer;"> MEDICATIONS (List all current medicines <br>and food supplements being taken):</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#hospital_history" aria-expanded="false" aria-controls="collapseExample">
                    HOSPITALIZATION HISTORY <small style="color: white"><em>(List all past and current hospitalization/s.)</em></small>
                </a>
                <div class="collapse" id="hospital_history">
                    <div class="table-responsive">
                        <?php $hospital_history = json_decode($dengvaxia->hospital_history); ?>
                        <table class="table table-bordered table-hover"  border="1">
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
                                <td><input type="text" name="reason[]" value="<?php if(isset($hospital_history[$i-1]->reason))echo$hospital_history[$i-1]->reason; ?>"></td>
                                <td><input type="text" name="date[]" value="<?php if(isset($hospital_history[$i-1]->date))echo$hospital_history[$i-1]->date; ?>"></td>
                                <td><input type="text" name="place[]" value="<?php if(isset($hospital_history[$i-1]->place))echo$hospital_history[$i-1]->place; ?>"></td>
                                <td><input type="text" name="phicUsed[]" value="<?php if(isset($hospital_history[$i-1]->phicUsed))echo$hospital_history[$i-1]->phicUsed; ?>"></td>
                                <td><input type="text" name="costNotCovered[]" value="<?php if(isset($hospital_history[$i-1]->costNotCovered))echo$hospital_history[$i-1]->costNotCovered; ?>"></td>
                            </tr>
                            @endfor
                        </table>
                    </div>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#surgical_history" aria-expanded="false" aria-controls="collapseExample">
                    PAST SURGICAL HISTORY <small style="color: white"><em>(Tick all operations,both minor and major,underwent by the respondent.)</em></small>
                </a>
                <div class="collapse" id="surgical_history">
                    <?php $surgical_history = json_decode($dengvaxia->surgical_history); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <th> </th>
                            <th style="text-align: center"> Operation</th>
                        </tr>
                        @for($i = 1; $i<=4; $i++)
                            <tr class="has-group">
                                <td style="width: 5%">{{ $i }}</td>
                                <td><input type="text" name="operation[]" value="<?php if(isset($surgical_history[$i-1]->operation))echo$surgical_history[$i-1]->operation; ?>" class="form-control"></td>
                            </tr>
                        @endfor
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#social_history" aria-expanded="false" aria-controls="collapseExample">
                    PERSONAL/SOCIAL HISTORY
                </a>
                <div class="collapse" id="social_history">
                    <?php $personal_history = json_decode($dengvaxia->personal_history); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>
                                Have you tried smoking?
                            </td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="tried_smoking" <?php if(isset($personal_history->tried_smoking)){if($personal_history->tried_smoking == 'Never Smoked')echo 'checked';} ?> value="Never Smoked" > Never Smoked</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tried_smoking" <?php if(isset($personal_history->tried_smoking)){if($personal_history->tried_smoking == 'Current Smoker')echo 'checked';} ?> value="Current Smoker" > Current Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tried_smoking" <?php if(isset($personal_history->tried_smoking)){if($personal_history->tried_smoking == 'Former Smoker')echo 'checked';} ?> value="Former Smoker" > Former Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tried_smoking" <?php if(isset($personal_history->tried_smoking)){if($personal_history->tried_smoking == 'Secondhand Smoker')echo 'checked';} ?> value="Secondhand Smoker" > Secondhand Smoker</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tried_smoking" <?php if(isset($personal_history->tried_smoking)){if($personal_history->tried_smoking == 'Thirdhand Smoker')echo 'checked';} ?> value="Thirdhand Smoker" > Thirdhand Smoker</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Age started:</td>
                            <td class="has-group"><input type="text" value="<?php if(isset($personal_history->smoking_age_started))echo$personal_history->smoking_age_started; ?>" name="smoking_age_started" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Age quit:</td>
                            <td class="has-group"><input type="text" value="<?php if(isset($personal_history->smoking_age_quit))echo$personal_history->smoking_age_quit; ?>" name="smoking_age_quit" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>No. of stick/s per day:</td>
                            <td class="has-group"><input type="text" value="<?php if(isset($personal_history->smoking_no_sticks))echo$personal_history->smoking_no_sticks; ?>" name="smoking_no_sticks" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>No. of Pack-Years:</td>
                            <td class="has-group"><input type="text" value="<?php if(isset($personal_history->smoking_no_packs))echo$personal_history->smoking_no_packs; ?>" name="smoking_no_packs" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Do you eat fast food/street food(e.g. instant noodles,canned goods,fries,fried chicken skin,etc) weekly?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="fat_salt_intake" <?php if(isset($personal_history->fat_salt_intake)){if($personal_history->fat_salt_intake == 'Yes')echo 'checked';} ?> value="Yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="fat_salt_intake" <?php if(isset($personal_history->fat_salt_intake)){if($personal_history->fat_salt_intake == 'No')echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Do you eat 3 servings of vegetable daily?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="daily_vegetable" <?php if(isset($personal_history->daily_vegetable)){if($personal_history->daily_vegetable == 'Yes')echo 'checked';} ?> value="Yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="daily_vegetable" <?php if(isset($personal_history->daily_vegetable)){if($personal_history->daily_vegetable == 'No')echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Do you eat 2-3 servings of fruits daily?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="daily_fruit" <?php if(isset($personal_history->daily_fruit)){if($personal_history->daily_fruit == 'Yes')echo 'checked';} ?> value="Yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="daily_fruit" <?php if(isset($personal_history->daily_fruit)){if($personal_history->daily_fruit == 'No')echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Does at least 30 minutes per day of moderate-to vigorous-intensity physical activity?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="physical_activity" <?php if(isset($personal_history->physical_activity)){if($personal_history->physical_activity == 'Yes')echo 'checked';} ?> value="Yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="physical_activity" <?php if(isset($personal_history->physical_activity)){if($personal_history->physical_activity == 'No')echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Have you tried drinking alcohol?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="tried_alcohol" <?php if(isset($personal_history->tried_alcohol)){if($personal_history->tried_alcohol == 'Yes')echo 'checked';} ?> value="Yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tried_alcohol" <?php if(isset($personal_history->tried_alcohol)){if($personal_history->tried_alcohol == 'No')echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>In the past 5 months, have you drunk alcohol?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="drunk_in_5mos" <?php if(isset($personal_history->drunk_in_5mos)){if($personal_history->drunk_in_5mos == 'Yes')echo 'checked';} ?> value="Yes" > Yes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="drunk_in_5mos" <?php if(isset($personal_history->drunk_in_5mos)){if($personal_history->drunk_in_5mos == 'No')echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Ever tried any illicit drug/substance?</td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="radio" name="tried_drugs" <?php if(isset($personal_history->tried_drugs)){if(strpos($personal_history->tried_drugs, 'Yes') !== false)echo 'checked';} ?> value="Yes" > Yes, specify:</label> <input type="text" value="<?php if(isset($personal_history->tried_drugs)){if(isset(explode(' - ',$personal_history->tried_drugs)[1]))echo explode(' - ',$personal_history->tried_drugs)[1];} ?>" name="tried_drugs_spe">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="tried_drugs" <?php if(isset($personal_history->tried_drugs)){if(strpos($personal_history->tried_drugs, 'No') !== false)echo 'checked';} ?> value="No" > No</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#menstrual" aria-expanded="false" aria-controls="collapseExample">
                    MENSTRUAL AND GYNECOLOGICAL HISTORY<small style="color: white"><em>(for female respondent only)</em></small>
                </a>
                <div class="collapse" id="menstrual">
                    <?php $gyne_history = json_decode($dengvaxia->mens_gyne_history); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>Age of Menarche:</td>
                            <td class="has-group"><input type="text" value="<?php if(isset($gyne_history->age_menarche))echo$gyne_history->age_menarche; ?>" name="age_menarche" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Date of Last Mendtrual Period:</td>
                            <td class="has-group"><input type="date" value="<?php if(isset($gyne_history->last_period))echo$gyne_history->last_period; ?>" name="last_period" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Duration(number of days):</td>
                            <td class="has-group"><input type="text" value="<?php if(isset($gyne_history->duration))echo$gyne_history->duration; ?>" name="duration" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>Interval/Cycle:</td>
                            <td class="has-group"><input type="text" value="<?php if(isset($gyne_history->interval))echo$gyne_history->interval; ?>" name="interval" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>No. of pads per day:</td>
                            <td class="has-group"><input type="text" value="<?php if(isset($gyne_history->no_pads))echo$gyne_history->no_pads; ?>" name="no_pads" class="form-control" /></td>
                        </tr>
                        <tr class="has-group">
                            <td>
                                Gyne History(Abnormal signs and symptoms: Tick all that apply)
                            </td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="gyne_history[]" <?php if(isset($gyne_history->selected_options->Abnormal_Vaginal)) echo 'checked'; ?> value="Abnormal_Vaginal" > Abnormal Vaginal/Uterine Bleeding</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="gyne_history[]" <?php if(isset($gyne_history->selected_options->Abnormal_Vaginal)) echo 'checked'; ?> value="Dysmenorrhea" > Dysmenorrhea</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="gyne_history[]" <?php if(isset($gyne_history->selected_options->Abnormal_Vaginal)) echo 'checked'; ?> value="Dyspareunia" > Dyspareunia</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="gyne_history[]" <?php if(isset($gyne_history->selected_options->Abnormal_Vaginal)) echo 'checked'; ?> value="Foul_smelling" > Foul-smelling vaginal discharge</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="gyne_history[]" <?php if(isset($gyne_history->selected_options->Abnormal_Vaginal)) echo 'checked'; ?> value="Vaginal_Pruritus" > Vaginal Pruritus</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Others, specify:</label> <input type="text" value="<?php if(isset($gyne_history->selected_options->Others))echo $gyne_history->selected_options->Others; ?>" name="gyne_history_others" >
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#vaccination_history" aria-expanded="false" aria-controls="collapseExample">
                    VACCINATION HISTORY
                </a>
                <div class="collapse" id="vaccination_history">
                    <?php $vaccine_history = json_decode($dengvaxia->vaccine_history); ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td style="width: 17%;">
                                Vaccine/s received:
                            </td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="vaccine_received[]" <?php if(isset($vaccine_history->vaccine_received)){if(in_array('MR', $vaccine_history->vaccine_received))echo 'checked';} ?> value="MR" > MR</label>
                                &nbsp;&nbsp;&nbsp;
                                <label style="cursor: pointer;"><input type="checkbox" name="vaccine_received[]" <?php if(isset($vaccine_history->vaccine_received)){if(in_array('Diphtheria/Tetanus', $vaccine_history->vaccine_received)) echo 'checked';} ?> value="Diphtheria/Tetanus" > Diphtheria/Tetanus</label>
                                &nbsp;&nbsp;&nbsp;
                                <label style="cursor: pointer;"><input type="checkbox" name="vaccine_received[]" <?php if(isset($vaccine_history->vaccine_received)){if(in_array('MMR', $vaccine_history->vaccine_received)) echo 'checked';} ?> value="MMR" > MMR</label>
                                &nbsp;&nbsp;&nbsp;
                                <label style="cursor: pointer;"><input type="checkbox" name="vaccine_received[]" <?php if(isset($vaccine_history->vaccine_received)){if(in_array('HPV', $vaccine_history->vaccine_received)) echo 'checked';} ?> value="HPV" > HPV</label>
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Tetanus Toxoid, No. of Doses:</td>
                            <td><input type="text" name="no_dose" value="<?php if(isset($vaccine_history->no_dose)) echo $vaccine_history->no_dose; ?>" class="form-control"></td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-hover" border="1">
                        @if(isset($vaccine_history->dengvaxia_history))
                            @for($index=0;$index<count($vaccine_history->dengvaxia_history);$index++)
                                <tr class="has-group">
                                    <td style="width: 17%;"><input type="hidden" value="<?php if(isset($vaccine_history->dengvaxia_history[$index]->history_count)) echo $vaccine_history->dengvaxia_history[$index]->history_count; ?>" name="history_count[]">Dengvaxia {{ $index+1 }}</td>
                                    <td>
                                        Date Received: <input type="date" name="vaccine_date[]" value="<?php if(isset($vaccine_history->dengvaxia_history[$index]->date)) echo $vaccine_history->dengvaxia_history[$index]->date; ?>" class="form-control">
                                    </td>
                                    <td>
                                        Place Received:
                                        <label style="cursor: pointer;"><input type="radio" name="place{{$index}}" <?php if(isset($vaccine_history->dengvaxia_history[$index]->place)){if($vaccine_history->dengvaxia_history[$index]->place == 'School')echo'checked';} ?> value="School"> School</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="place{{$index}}" <?php if(isset($vaccine_history->dengvaxia_history[$index]->place)){if($vaccine_history->dengvaxia_history[$index]->place == 'Health Center/Community')echo'checked';} ?> value="Health Center/Community"> Health Center/Community</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="place{{$index}}" <?php if(isset($vaccine_history->dengvaxia_history[$index]->place)){if($vaccine_history->dengvaxia_history[$index]->place == 'Priv. MD')echo'checked';} ?> value="Priv. MD"> Priv. MD</label>
                                    </td>
                                </tr>
                            @endfor
                        @else
                            @foreach(range(1,3) as $index)
                                <tr class="has-group">
                                    <td style="width: 17%;"><input type="hidden" value="{{ $index }}" name="history_count[]">Dengvaxia {{ $index }}</td>
                                    <td>
                                        Date Received: <input type="date" name="vaccine_date[]" class="form-control">
                                    </td>
                                    <td>
                                        Place Received:
                                        <label style="cursor: pointer;"><input type="radio" name="place{{$index}}" value="School"> School</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="place{{$index}}" value="Health Center/Community"> Health Center/Community</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <label style="cursor: pointer;"><input type="radio" name="place{{$index}}" value="Priv. MD"> Priv. MD</label>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <table class="table table-bordered table-hover" border="1">
                        <tr class="has-group">
                            <td>For Adolescent Girls:</td>
                            <td>
                                Given Ferrous sulfate supplementation, Date: <input type="date" name="supplementation_date" value="<?php if(isset($vaccine_history->supplementation_date))echo $vaccine_history->supplementation_date; ?>" class="form-control">
                            </td>
                            <td>
                                Given Iodized Oil Capsule, Date: <input type="date" name="capsule_date" value="<?php if(isset($vaccine_history->capsule_date))echo $vaccine_history->capsule_date; ?>" class="form-control">
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td style="width: 17%;">Dewormed? </td>
                            <td colspan="2">
                                Yes, Date last dewormed: <input type="date" name="dewormed_date" value="<?php if(isset($vaccine_history->dewormed_date))echo $vaccine_history->dewormed_date; ?>" class="form-control">
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#other_procedure" aria-expanded="false" aria-controls="collapseExample">
                    OTHER PROCEDURE DONE
                </a>
                <div class="collapse" id="other_procedure">
                    <?php
                    $other_procedures = json_decode($dengvaxia->other_procedures);
                    $GLOBALS['chestChecked'] = '';
                    $GLOBALS['chestResult'] = '';
                    $GLOBALS['EnzymesChecked'] = '';
                    $GLOBALS['IgG'] = '';
                    $GLOBALS['IgM'] = '';
                    if(isset($other_procedures)){
                        $pattern = 'Chest X-ray*';
                        $array = array_filter($other_procedures, function($entry) use ($pattern) {
                            if(fnmatch($pattern, $entry)){
                                $GLOBALS['chestChecked'] = 'checked';
                                $GLOBALS['chestResult'] = explode(' - ',$entry)[1];
                            }
                        });
                        $pattern = 'Enzymes*';
                        $array = array_filter($other_procedures, function($entry) use ($pattern) {
                            if(fnmatch($pattern, $entry)){
                                $GLOBALS['EnzymesChecked'] = 'checked';
                                if(explode(' - ',$entry)[1] == "IgG Positive")
                                    $GLOBALS['IgG'] = 'checked';
                                elseif(explode(' - ',$entry)[1] == "IgM Positive")
                                    $GLOBALS['IgM'] = 'checked';
                            }
                        });
                    }
                    ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td></td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="other_procedures[]" <?php if(isset($other_procedures)){if(in_array('CBC', $other_procedures))echo 'checked';} ?> value="CBC" > CBC</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="other_procedures[]" <?php if(isset($other_procedures)){if(in_array('Urinalysis', $other_procedures))echo 'checked';} ?> value="Urinalysis" > Urinalysis</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="other_procedures[]" {{ $GLOBALS['chestChecked'] }} value="Chest X-ray" > Chest X-ray, Specify Finding (Result)</label> <input type="text" value="{{ $GLOBALS['chestResult'] }}" name="xray_result" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="other_procedures[]" {{ $GLOBALS['EnzymesChecked'] }} value="Enzymes" > Enzymes Based Rapid Diagnostic Test for Dengue, Specify result:</label> <input type="radio" name="enzymes_result" {{ $GLOBALS['IgG'] }} value="IgG Positive"> IgG Positive <input type="radio" name="enzymes_result" {{ $GLOBALS['IgM'] }} value="IgM Positive"> IgM Positive
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="other_procedures[]" <?php if(isset($other_procedures)){if(in_array('NS1 Test', $other_procedures))echo 'checked';} ?> value="NS1 Test" > NS1 Test</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="other_procedures[]" <?php if(isset($other_procedures)){if(in_array('PCR', $other_procedures))echo 'checked';} ?> value="PCR" > PCR</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#review_system" aria-expanded="false" aria-controls="collapseExample">
                    REVIEW OF SYSTEMS<small style="color: white"><em>(Tick all that apply)</em></small>
                </a>
                <div class="collapse" id="review_system">
                    <?php
                        $review_system = json_decode($dengvaxia->review_systems);
                        if(isset($review_system)){
                            $pattern = 'Others*';
                            $GLOBALS['reviewOtherChecked'] = '';
                            $GLOBALS['reviewOtherResult'] = '';
                            $array = array_filter($review_system, function($entry) use ($pattern) {
                                if(fnmatch($pattern, $entry)){
                                    $GLOBALS['reviewOtherChecked'] = 'checked';
                                    $GLOBALS['reviewOtherResult'] = explode(' - ',$entry)[1];
                                }
                            });
                        }
                    ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>
                                REVIEW OF SYSTEMS:
                            </td>
                            <td class="has-group">
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Jaundice', $review_system))echo 'checked';} ?> value="Jaundice" > Jaundice</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Pallor', $review_system))echo 'checked';} ?> value="Pallor" > Pallor</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Rashes', $review_system))echo 'checked';} ?> value="Rashes" > Rashes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Severe/Recurrent Headache', $review_system))echo 'checked';} ?> value="Severe/Recurrent Headache" > Severe/Recurrent Headache</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Severe/Recurrent Dizziness', $review_system))echo 'checked';} ?> value="Severe/Recurrent Dizziness" > Severe/Recurrent Dizziness</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Blurring of vision', $review_system))echo 'checked';} ?> value="Blurring of vision" > Blurring of vision</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Hearing loss', $review_system))echo 'checked';} ?> value="Hearing loss" > Hearing loss</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Seizures', $review_system))echo 'checked';} ?> value="Seizures" > Seizures</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Easy Fatigability', $review_system))echo 'checked';} ?> value="Easy Fatigability" > Easy Fatigability</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Cough/Colds', $review_system))echo 'checked';} ?> value="Cough/Colds" > Cough/Colds</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Dyspnea', $review_system))echo 'checked';} ?> value="Dyspnea" > Dyspnea</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Orthopnea', $review_system))echo 'checked';} ?> value="Orthopnea" > Orthopnea</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Chest pain', $review_system))echo 'checked';} ?> value="Chest pain" > Chest pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Palpitations', $review_system))echo 'checked';} ?> value="Palpitations" > Palpitations</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Murmur', $review_system))echo 'checked';} ?> value="Murmur" > Murmur</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Breast pain', $review_system))echo 'checked';} ?> value="Breast pain" > Breast pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Nausea and/or vomiting', $review_system))echo 'checked';} ?> value="Nausea and/or vomiting" > Nausea and/or vomiting</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Severe/Recurrent abdominal pain', $review_system))echo 'checked';} ?> value="Severe/Recurrent abdominal pain" > Severe/Recurrent abdominal pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Recurrent Constipation', $review_system))echo 'checked';} ?> value="Recurrent Constipation" > Recurrent Constipation</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Diarrhea', $review_system))echo 'checked';} ?> value="Diarrhea" > Diarrhea</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Polyphagia', $review_system))echo 'checked';} ?> value="Polyphagia" > Polyphagia</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Polydypsia', $review_system))echo 'checked';} ?> value="Polydypsia" > Polydypsia</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Polyuria', $review_system))echo 'checked';} ?> value="Polyuria" > Polyuria</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Vaginal bleeding', $review_system))echo 'checked';} ?> value="Vaginal bleeding" > Vaginal bleeding</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Foul Smelling Vaginal', $review_system))echo 'checked';} ?> value="Foul Smelling Vaginal" > Foul Smelling Vaginal</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Urethral discharge', $review_system))echo 'checked';} ?> value="Urethral discharge" > Urethral discharge</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Dysuria', $review_system))echo 'checked';} ?> value="Dysuria" > Dysuria</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Leg pain', $review_system))echo 'checked';} ?> value="Leg pain" > Leg pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Joint pain', $review_system))echo 'checked';} ?> value="Joint pain" > Joint pain</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Muscle wasting', $review_system))echo 'checked';} ?> value="Muscle wasting" > Muscle wasting</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Muscle weakness', $review_system))echo 'checked';} ?> value="Muscle weakness" > Muscle weakness</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" <?php if(isset($review_system)){if(in_array('Weight Loss', $review_system))echo 'checked';} ?> value="Weight Loss" > Weight Loss</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="review_system[]" {{ $GLOBALS['reviewOtherChecked'] }} value="Others" ></label>
                                <label style="cursor: pointer;">Others,specify: </label> <input type="text" value="{{ $GLOBALS['reviewOtherResult'] }}" name="review_system_others" >
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="btn btn-info" id="btn_collapse" data-toggle="collapse" href="#pertinent_physical" aria-expanded="false" aria-controls="collapseExample">
                    PERTINENT PHYSICAL EXAMINATION
                </a>
                <div class="collapse" id="pertinent_physical">
                    <?php
                        $physical_examination = json_decode($dengvaxia->physical_examination);
                    ?>
                    <table class="table table-bordered table-hover"  border="1">
                        <tr class="has-group">
                            <td>General Status:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="radio" name="general_status" <?php if(isset($physical_examination->general_status)){if($physical_examination->general_status == 'Oriented to Time, Place, and Date')echo 'checked';} ?> value="Oriented to Time, Place, and Date" > Oriented to Time, Place, and Date</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="general_status" <?php if(isset($physical_examination->general_status)){if($physical_examination->general_status == 'Conscious')echo 'checked';} ?> value="Conscious" > Conscious</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="general_status" <?php if(isset($physical_examination->general_status)){if($physical_examination->general_status == 'Ambulatory')echo 'checked';} ?> value="Ambulatory" > Ambulatory</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="radio" name="general_status" <?php if(isset($physical_examination->general_status)){if(strpos($physical_examination->general_status,'Others') !== false)echo 'checked';} ?> value="Others" > Others, specify:</label> <input type="text" value="<?php if(isset($physical_examination->general_status)){if(strpos($physical_examination->general_status,'Others') !== false)echo explode(' - ',$physical_examination->general_status)[1];} ?> " name="general_status_others" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>Vital Signs:</td>
                            <td>
                                <label style="cursor: pointer;">BP:</label> <input type="text" name="bp" value="<?php if(isset($physical_examination->bp)){echo $physical_examination->bp;} ?>">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">HR:</label> <input type="text" name="hr" value="<?php if(isset($physical_examination->hr)){echo $physical_examination->hr;} ?>"> <label style="cursor: pointer;">/min</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">RR:</label> <input type="text" name="rr" value="<?php if(isset($physical_examination->rr)){echo $physical_examination->rr;} ?>"> <label style="cursor: pointer;">/min</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Temp:</label> <input type="text" name="temp" value="<?php if(isset($physical_examination->temp)){echo $physical_examination->temp;} ?>"> <label style="cursor: pointer;">Degree Celcius</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Blood Type:</label> <input type="text" name="blood_type" value="<?php if(isset($physical_examination->blood_type)){echo $physical_examination->blood_type;} ?>">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Weight(kg):</label> <input type="text" name="weight" value="<?php if(isset($physical_examination->weight)){echo $physical_examination->weight;} ?>">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Height(m):</label> <input type="text" name="height" value="<?php if(isset($physical_examination->height)){echo $physical_examination->height;} ?>">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">BMI:</label> <input type="text" name="bmi" value="<?php if(isset($physical_examination->bmi)){echo $physical_examination->bmi;} ?>">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Waist(cm):</label> <input type="text" name="waist" value="<?php if(isset($physical_examination->waist)){echo $physical_examination->waist;} ?>">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">Hip(cm):</label> <input type="text" name="hip" value="<?php if(isset($physical_examination->hip)){echo $physical_examination->hip;} ?>">
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;">W/H Ratio:</label> <input type="text" name="ratio" value="<?php if(isset($physical_examination->ratio)){echo $physical_examination->ratio;} ?>">
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>SKIN:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="skin" <?php if(isset($physical_examination->skin)){if($physical_examination->skin == 'Good Skin Turgor')echo 'checked';} ?> value="Good Skin Turgor" > Good Skin Turgor</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="skin" <?php if(isset($physical_examination->skin)){if($physical_examination->skin == 'Pallor')echo 'checked';} ?> value="Pallor" > Pallor</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="skin" <?php if(isset($physical_examination->skin)){if($physical_examination->skin == 'Jaundice')echo 'checked';} ?> value="Jaundice" > Jaundice</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="skin" <?php if(isset($physical_examination->skin)){if($physical_examination->skin == 'Rashes')echo 'checked';} ?> value="Rashes" > Rashes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="skin" <?php if(isset($physical_examination->skin)){if(strpos($physical_examination->general_status,'Lesions') !== false)echo 'checked';} ?> value="Lesions" > Lesions,specify others:</label> <input type="text" value="<?php if(isset($physical_examination->skin)){if(strpos($physical_examination->skin,'Lesions') !== false)echo explode(' - ',$physical_examination->skin)[1];} ?> " name="lesions_others" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>HEENT:</td>
                            <td>
                                <?php
                                if(isset($physical_examination->selected_options->heent)){
                                    $pattern = 'Visual Acuity*';
                                    $GLOBALS['hentVisualChecked'] = '';
                                    $GLOBALS['hentVisualOtherResult'] = '';
                                    $array = array_filter($physical_examination->selected_options->heent, function($entry) use ($pattern) {
                                        if(fnmatch($pattern, $entry)){
                                            $GLOBALS['heentVisualChecked'] = 'checked';
                                            $GLOBALS['hentVisualOtherResult'] = explode(' - ',$entry)[1];
                                        }
                                    });

                                    $pattern = 'Palpable mass*';
                                    $GLOBALS['heentPalpableChecked'] = '';
                                    $GLOBALS['heentPalpableOtherResult'] = '';
                                    $array = array_filter($physical_examination->selected_options->heent, function($entry) use ($pattern) {
                                        if(fnmatch($pattern, $entry)){
                                            $GLOBALS['heentPalpableChecked'] = 'checked';
                                            $GLOBALS['heentPalpableOtherResult'] = explode(' - ',$entry)[1];
                                        }
                                    });

                                    $pattern = 'Palpable mass*';
                                    $GLOBALS['heentVisualChecked'] = '';
                                    $GLOBALS['heentVisualOtherResult'] = '';
                                    $array = array_filter($physical_examination->selected_options->heent, function($entry) use ($pattern) {
                                        if(fnmatch($pattern, $entry)){
                                            $GLOBALS['heentVisualChecked'] = 'checked';
                                            $GLOBALS['heentVisualOtherResult'] = explode(' - ',$entry)[1];
                                        }
                                    });

                                    $pattern = 'Others*';
                                    $GLOBALS['heentOthersChecked'] = '';
                                    $GLOBALS['heentOthersOtherResult'] = '';
                                    $array = array_filter($physical_examination->selected_options->heent, function($entry) use ($pattern) {
                                        if(fnmatch($pattern, $entry)){
                                            $GLOBALS['heentOthersChecked'] = 'checked';
                                            $GLOBALS['heentOtherResult'] = explode(' - ',$entry)[1];
                                        }
                                    });
                                }
                                ?>
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('No significant findings', $physical_examination->selected_options->heent))echo 'checked';} ?>  value="No significant findings" > No significant findings</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Yellowish sclerae', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Yellowish sclerae" > Yellowish sclerae</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Pale conjunctiva', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Pale conjunctiva" > Pale conjunctiva</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" {{ $GLOBALS['heentVisualChecked'] }} value="Visual Acuity" > Visual Acuity:</label> <input type="text" value="{{ $GLOBALS['heentVisualOtherResult'] }}" name="visual_acuity_others" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Alar flaring', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Alar flaring" > Alar flaring:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Nasal discharge', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Nasal discharge" > Nasal discharge:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Cleft lip', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Cleft lip" > Cleft lip:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Cleft palate', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Cleft palate" > Cleft palate:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Ear discharge', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Ear discharge" > Ear discharge:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Enlarged tonsils', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Enlarged tonsils" > Enlarged tonsils:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" <?php if(isset($physical_examination->selected_options->heent)){if(in_array('Enlarged thyroid', $physical_examination->selected_options->heent))echo 'checked';} ?> value="Enlarged thyroid" > Enlarged thyroid:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" {{ $GLOBALS['heentPalpableChecked'] }} value="Palpable mass" > Palpable mass, specify site:</label> <input type="text" value="{{ $GLOBALS['heentVisualOtherResult'] }}" name="palpable_mass_specify" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heent[]" {{ $GLOBALS['heentOthersChecked'] }} value="Others" > Others,specify:</label> <input type="text" value="{{ $GLOBALS['heentOtherResult'] }}" name="others_specify" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>CHEST AND LUNGS:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="lungs[]" <?php if(isset($physical_examination->selected_options->lungs)){if(in_array('Enlarged thyroid', $physical_examination->selected_options->lungs))echo 'checked';} ?> value="No Significant findings" > No Significant findings</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="lungs[]" <?php if(isset($physical_examination->selected_options->lungs)){if(in_array('Chest retractions', $physical_examination->selected_options->lungs))echo 'checked';} ?> value="Chest retractions" > Chest retractions </label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="lungs[]" <?php if(isset($physical_examination->selected_options->lungs)){if(in_array('Crackles/Rales/Harsh breath sounds', $physical_examination->selected_options->lungs))echo 'checked';} ?> value="Crackles/Rales/Harsh breath sounds" > Crackles/Rales/Harsh breath sounds</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="lungs[]" <?php if(isset($physical_examination->selected_options->lungs)){if(in_array('Wheezes', $physical_examination->selected_options->lungs))echo 'checked';} ?> value="Wheezes" > Wheezes</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="lungs[]" <?php if(isset($physical_examination->selected_options->lungs)){if(in_array('Breast mass/discharge', $physical_examination->selected_options->lungs))echo 'checked';} ?> value="breast_mass" > Breast mass/discharge</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="lungs[]" value="others" > Others,specify:</label> <input type="text" name="per_che_oth" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>HEART:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="heart[]" value="No Significant findings" > No Significant findings</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heart[]" value="Irregular pulse" > Irregular pulse</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heart[]" value="Cyanosis (lips, nails)" > Cyanosis (lips, nails)</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heart[]" value="murmur" > murmur, specify:</label> <input type="text" name="murmur_others" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="heart[]" value="Others" > Others,specify:</label> <input type="text" name="heart_others" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>ABDOMEN:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="abdomen[]" value="No Significant findings" > No Significant findings</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="abdomen[]" value="Tenderness" > Tenderness</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="abdomen[]" value="Palpable mass" > Palpable mass, specify site:</label> <input type="text" name="palpable_others" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="abdomen[]" value="Others" > Others,specify:</label> <input type="text" name="abdomen_others" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>EXTREMITIES:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="extremities[]" value="Abnormal gait" > Abnormal gait</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="extremities[]" value="Edema" > Edema</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="extremities[]" value="Joint swelling" > Joint swelling:</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="extremities[]" value="Gross deformity" > Gross deformity, describe:</label> <input type="text" name="deformity_describe" >
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="extremities[]" value="Others" > Others,specify:</label> <input type="text" name="extremities_others" >
                            </td>
                        </tr>
                        <tr class="has-group">
                            <td>EXTREMITIES OTHERS:</td>
                            <td>
                                <label style="cursor: pointer;"><input type="checkbox" name="extremities_others[]" value="Abnormal gait" > Enzymes Based Rapid Diagnostic Test for Dengue, Specify result:</label> <input type="radio" name="abnormal_gait_others" value="IgG Positive"> IgG Positive <input type="radio" name="IgM Positive" value="IgM Positive"> IgM Positive
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="extremities_others[]" value="NS1 Test" > NS1 Test</label>
                                &nbsp;&nbsp;&nbsp;<br />
                                <label style="cursor: pointer;"><input type="checkbox" name="extremities_others[]" value="PCR" > PCR</label>
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