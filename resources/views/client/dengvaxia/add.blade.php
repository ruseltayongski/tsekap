<?php
use App\Barangay;
use App\FamilyProfile;
use App\Profile;
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
@extends('client')
@section('content')
    <style>
        .table-input tr td:first-child {
            background: #f5f5f5;
            text-align: right;
            vertical-align: middle;
            font-weight: bold;
            padding: 3px;
            width:30%;
        }
        .table-input tr td {
            border:1px solid #bbb !important;
        }
        .help-block {
            font-weight:bold;
        }
    </style>
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">
                Add Dengvaxia Patient
            </h2>
            <div class="page-divider"></div>

            <form method="POST" class="form-horizontal form-submit" id="form-submit" action="{{ asset('user/dengvaxia/save') }}">
                {{ csrf_field() }}
                <input type="hidden" name="tsekap_id" value="{{ $profile->id }}" />
                <table class="table-input table table-bordered table-hover" border="1">
                    <tr class="has-group">
                        <td>Profile Name :</td>
                        <td><input type="text" disabled class="form-control" value="{{ $profile->fname }} {{ $profile->mname }} {{ $profile->lname }}" /></td>
                    </tr>
                    <tr class="has-group">
                        <td>Facility Name :</td>
                        <td><input type="text" name="facility_name" class="form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>List Number :</td>
                        <td><input type="text" name="list_number" class="form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>1st Dose Screened :</td>
                        <td>
                            <select name="dose_screened" class="form-control" required>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>1st Dose Date Given :</td>
                        <td>
                            <div class="form-inline">
                                <input type="date" name="dose_date_given" id="dose_date_given" class="form-control" required />
                                <button type="button" class="btn btn-primary btn-sm" onclick="validateDate()"><i class="fa fa-hands"></i> Validate</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>1st Dose Age :</td>
                        <td>
                            <input type="text" readonly name="dose_age" class="form-control" id="dose_age" required />
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Validation within 9-14y/o :</td>
                        <td><input readonly type="text" name="validation" class="form-control" id="validation"  required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>1st Dose Lot #:</td>
                        <td><input type="text" name="dose_lot_no" class="form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>1st Dose Batch #:</td>
                        <td><input type="text" name="dose_batch_no" class="form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>1st Dose Expiration :</td>
                        <td><input type="date" name="dose_expiration" class="form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>1st Dose AEFI :</td>
                        <td>
                            <select name="dose_AEFI" class="form-control" required>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Remarks :</td>
                        <td>
                            <textarea class="form-control" name="remarks" style="resize: none" rows="5"></textarea>
                        </td>
                    </tr>


                    <tr>
                        <td></td>
                        <td>
                            <a href="{{ asset('user/population/info/'.$profile->id) }}" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> View List
                            </a>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add Profile
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
            </form>
        </div>
    </div>
    @include('sidebar')
@endsection

@section('js')

    <?php
    $status = session('status');
    ?>
    @if($status=='added')
        <script>
            Lobibox.notify('success', {
                msg: 'Successfully added!'
            });
        </script>
    @endif

    @if($status=='duplicate')
        <script>
            Lobibox.notify('error', {
                msg: 'Duplicate Entry!'
            });
        </script>
    @endif

    <script>
        var dob = "{{ $profile->dob }}";

        function validateDate()
        {
            var date_given = $('#dose_date_given').val();
            if(date_given){
                var url = "{{ url('user/dengvaxia/validate/date_given') }}";
                $.ajax({
                    url: url+"/"+dob+"/"+date_given,
                    type: "GET",
                    success: function(age){
                        $("#dose_age").val(age);
                        if(age>=9 && age<=14)
                        {
                            $("#validation").val('Yes');
                        }else{
                            $("#validation").val('No');
                        }
                    }
                });
            }else{
                alert('Please put 1st Dose Date Given');
            }
        }
    </script>
@endsection