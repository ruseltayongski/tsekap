<div class="modal fade" role="dialog" id="dengvaxia">
    <div class="modal-dialog modal-md" role="document">
        <input type="hidden" name="currentID" id="currentID">
        <div class="modal-content">
            <div class="modal-body">
                <fieldset>
                    <legend><i class="fa fa-user-md"></i> Dengvaxia</legend>
                    <div class="verify-dengvaxia">
                        <center>
                            <img src="{{ asset('resources/img/spin.gif') }}" width="100" />
                        </center>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" role="dialog" id="loading_page">
    <div class="modal-dialog modal-sm" role="document">
        <center>
            <img src="{{ asset('resources/img/loading.gif') }}" style="margin-top: 50%"/>
        </center>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="proceed_dengvaxia">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-info text-blue">
                    <i class="fa fa-question-circle"></i> <strong>Do you want to proceed dengvaxia form?</strong>
                    <div class="pull-right">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        <a href="{{ asset('deng/form') }}" type="button" class="btn btn-danger btn-sm"><i class="fa fa-check"></i> Yes</a>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="select_harmonized">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <label style="font-size: 15pt">Select System</label>
                <table class="table table-hover table-striped">
                    <tr>
                        <td><label class="text-blue cursor" onclick="openDengvaxia();"><i class="fa fa-stethoscope"></i> Dengvaxia</label></td>
                        <td><label class="text-green cursor"><i class="fa fa-stethoscope"></i> Bhert</label></td>
                    </tr>
                    <tr>
                        <td><label class="text-yellow cursor"><i class="fa fa-stethoscope"></i> E - Referral</label></td>
                        <td><label class="text-red cursor"><i class="fa fa-stethoscope"></i> IHOMIS</label></td>
                    </tr>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="select_sitio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h5 class="modal-title">Select Sitio</h5>
            </div>
            <div class="select_sitio"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="select_purok" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h5 class="modal-title">Select Purok</h5>
            </div>
            <div class="select_purok"></div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="familyProfile">
    <div class="modal-dialog modal-sm" role="document">
        <input type="hidden" name="currentID" id="currentID">
        <div class="modal-content">
            <div class="modal-body">
                <fieldset>
                    <legend><i class="fa fa-users"></i> Family Information</legend>
                    <div class="family-list">
                        <center>
                            <img src="{{ asset('resources/img/spin.gif') }}" width="100" />
                        </center>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="showServices">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <fieldset>
                    <legend><i class="fa fa-stethoscope"></i> Services Availed</legend>
                    <div class="service-list">
                        <center>
                            <img src="{{ asset('resources/img/spin.gif') }}" width="100" />
                        </center>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <a href="#" target="_blank" type="button" class="btn btn-success btn-sm avail"><i class="fa fa-stethoscope"></i> Avail Services</a>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
use App\Barangay;
use App\UserBrgy;

$brgy = Barangay::where('muncity_id',Auth::user()->muncity);

if(Auth::user()->user_priv==2){
    $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
    $brgy = $brgy->where(function($q) use ($tmpBrgy){
        foreach($tmpBrgy as $tmp){
            $q->orwhere('id',$tmp->barangay_id);
        }
    });
    if(count($tmpBrgy)==0){
        $brgy = $brgy->where('id',0);
    }
}
$brgy = $brgy->orderBy('description','asc')
        ->get();
?>
<div class="modal fade" role="dialog" id="filterResult">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="{{ asset('user/population') }}" method="POST" class="form-submit">
            <?php $tmp = Session::get('profileKeyword');?>
            {{ csrf_field() }}
            <div class="modal-body">
                <fieldset>
                    <legend><i class="fa fa-filter"></i> Filter Result</legend>
                    <div class="form-group">
                        <label>Keyword:</label>
                        <input type="text" class="form-control" placeholder="Keyword..." name="keyword" value="{{ $tmp['keyword'] }}">
                    </div>
                    <div class="form-group">
                        <label>Family Head:</label>
                        <select name="familyHead" class="form-control chosen-select">
                            <option value="">Select...</option>
                            <option {{ ($tmp['familyHead']=='Yes') ? 'selected': '' }}>Yes</option>
                            <option {{ ($tmp['familyHead']=='No') ? 'selected': '' }}>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <select name="sex" class="form-control chosen-select">
                            <option value="">Select...</option>
                            <option {{ ($tmp['sex']=='Male') ? 'selected': '' }}>Male</option>
                            <option {{ ($tmp['sex']=='Female') ? 'selected': '' }}>Female</option>
                            <option value="non" {{ ($tmp['sex']=='non') ? 'selected': '' }}>No Gender</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Barangay:</label>
                        <select name="barangay" class="form-control chosen-select">
                            <option value="">Select...</option>
                            @foreach($brgy as $row)
                                <option value="{{ $row->id }}"  {{ ($tmp['barangay']==$row->id) ? 'selected': '' }}>{{ $row->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dengvaxia:</label>
                        <select name="dengvaxia" class="form-control chosen-select">
                            <option value="">Select...</option>
                            <option value="yes" {{ ($tmp['dengvaxia']=='yes') ? 'selected': '' }}>Dengvaxia List</option>
                        </select>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn btn-success btn-sm btn-submit"><i class="fa fa-check"></i> Filter</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="filterResultLess">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="{{ asset('user/population/less') }}" method="POST" class="form-submit">
                <?php
                    $tmp = Session::get('profileKeyword');
                    $less = Session::get('profileKeywordLess');
                ?>
                {{ csrf_field() }}
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-filter"></i> Filter Result</legend>
                        <div class="form-group">
                            <label>Year:</label>
                            <select name="year" class="form-control">
                                <?php $years = \App\Http\Controllers\ParameterCtrl::getYear(); ?>
                                @foreach($years as $y)
                                    <option {{ (isset($tmp['year'])==$y) ? 'selected': '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keyword:</label>
                            <input type="text" class="form-control" placeholder="Keyword..." name="keyword" value="{{ $tmp['keyword'] }}">
                        </div>
                        <div class="form-group">
                            <label>Physical Examination:</label>
                            <select name="group1" class="form-control chosen-select">
                                <option value="">Select...</option>
                                <option {{ ($less['group1']==1) ? 'selected': '' }} value="1">Yes</option>
                                <option {{ ($less['group1']==2) ? 'selected': '' }} value="2">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Laboratory Services:</label>
                            <select name="group2" class="form-control chosen-select">
                                <option value="">Select...</option>
                                <option {{ ($less['group2']==1) ? 'selected': '' }} value="1">Yes</option>
                                <option {{ ($less['group2']==2) ? 'selected': '' }} value="2">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Other Services:</label>
                            <select name="group3" class="form-control chosen-select">
                                <option value="">Select...</option>
                                <option {{ ($less['group3']==1) ? 'selected': '' }} value="1">Yes</option>
                                <option {{ ($less['group3']==2) ? 'selected': '' }} value="2">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gender:</label>
                            <select name="sex" class="form-control chosen-select">
                                <option value="">Select...</option>
                                <option {{ ($tmp['sex']=='Male') ? 'selected': '' }}>Male</option>
                                <option {{ ($tmp['sex']=='Female') ? 'selected': '' }}>Female</option>
                                <option value="non" {{ ($tmp['sex']=='non') ? 'selected': '' }}>No Gender</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Barangay:</label>
                            <select name="barangay" class="form-control chosen-select">
                                <option value="">Select...</option>
                                @foreach($brgy as $row)
                                    <option value="{{ $row->id }}"  {{ ($tmp['barangay']==$row->id) ? 'selected': '' }}>{{ $row->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-sm btn-submit"><i class="fa fa-check"></i> Filter</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->