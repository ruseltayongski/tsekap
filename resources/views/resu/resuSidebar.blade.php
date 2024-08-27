<?php
use App\Facility;
use App\Province;

$user = Auth::user();

$facility = Facility::select('id','name','address','hospital_type')
->where('id', $user->facility_id)    
->get();

$facilities = null;

foreach($facility as $fact){
$facility = $fact;
}

$Selectedprovince = Province::select('id','description')
   ->where('id', $user->province)
   ->get();

?>


<div class="col-md-3 wrapper">
    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Welcome, {{ strtoupper($user->username) }}</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Facility Name</label>
                <input type="text" readonly class="form-control" value="{{ $facility->name }}" />
            </div>

            <div class="form-group">
                <label>Facility Address</label>
                <input type="text" readonly class="form-control" value="{{$facility->address}}" />
            </div>

            <div class="form-group">
                <label>Province</label>
                <input type="text" readonly class="form-control" value="{{ $Selectedprovince[0]->description}}" />
            </div>

            <!-- <div class="form-group">
                <a href="{{ asset('logout') }}" class="btn col-xs-12" style="background-color:727DAB; color:#ffff"><i class="fa fa-sign-out"></i> Logout</a>
            </div> -->

            <div class="form-group">
                <a href="{{ asset('logout') }}" class="btn btn-success col-xs-12"><i class="fa fa-sign-out"></i> Logout</a>
            </div>
     
           
        </div>
    </div>
</div>