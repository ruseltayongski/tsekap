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