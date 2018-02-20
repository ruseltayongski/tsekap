<?php
use App\Bracket;
use App\Barangay;
use App\Service;

$bracket = Bracket::orderBy('id','asc')->get();
$barangay = Barangay::where('muncity_id',Auth::user()->muncity)->orderBy('description','asc')->get();
$service = Service::orderBy('description','asc')->get();
?>
<span id="url" data-link="{{ asset('date_in') }}"></span>
<div class="col-md-3 wrapper">
    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Filter Profile</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" method="POST" action="{{ asset('user/services') }}">
                {{ csrf_field() }}
                <?php $tmp = Session::get('profileKeyword');?>
                <table width="100%">
                    <tr>
                        <td>
                            <label>Select Date</label><br />
                            <button type="button" class="col-xs-12 btn btn-info" data-target="#changeDate" data-toggle="modal"><i class="fa fa-calendar"></i> Date: {{ $date }}</button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <br>
                            <label>Search Profile</label>
                            <input type="text" style="width: 100%;" class="form-control" name="profileKeyword" value="{{ $tmp['keyword'] }}" placeholder="Search Profile" />
                        </td>
                    </tr>
                    <tr>
                        <td><br>
                            <button type="submit" class="col-xs-12 btn btn-success btn-select"><i class="fa fa-filter"></i> Filter</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Select Profile</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                @foreach($profiles as $row)
                <tr>
                    <td>
                        <div class="pull-right">
                            <a href="{{ asset('user/services/'.$row->id) }}" class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> </a>
                        </div>
                        {{ $row->fname }} {{ $row->mname }} {{ $row->lname }} {{ $row->suffix }}
                        <br />
                        <small class="text-info">[{{ $row->familyID }}]</small>
                    </td>
                </tr>
                @endforeach
            </table>
            @if(count($profiles)<1)
            <div class="alert alert-warning">
                <font class="text-warning">No profile found!</font>
            </div>
            @endif
            <div class="text-center">
                {{ $profiles->links() }}
            </div>
        </div>
    </div>
</div>

