<?php
use App\Province;
$provinces = Province::orderBy('description','asc');
$user= Auth::user();
if($user->user_priv==3){
    $provinces = $provinces->where('id',$user->province);
}
$provinces = $provinces->get();
?>
<div class="col-md-3 wrapper">
    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">User Menu</h3>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ asset('users') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Search User</label>
                    <input type="text" style="width: 100%;" class="form-control" placeholder="Input name..." name="keyword" value="{{ $keyword }}" autofocus>
                </div>
                <div class="form-group">
                    <label>Access Level</label>
                    <select name="level" class="form-control chosen-select">
                        <option value="">Select Level...</option>
                        <option @if($level=='1') selected @endif value="1">Admin Level</option>
                        <option @if($level=='3') selected @endif value="3">Provincial Level</option>
                        <option @if($level=='0') selected @endif value="0">Municipal Level</option>
                        <option @if($level=='2') selected @endif value="2">Barangay Level</option>
                        <option>Facility Level</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Province</label>
                    <select name="province_id" class="form-control chosen-select filterProvince" id="province">
                        <option value="">Select Province...</option>
                        @foreach($provinces as $p)
                            <option @if($province_id==$p->id) selected @endif value="{{ $p->id }}">{{ $p->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Municipal / City</label>
                    <input type="hidden" id="muncity_id" value="{{ $muncity_id }}" />
                    <select name="muncity_id" class="chosen-select filterMuncity form-control" id="muncity">
                        <option value="">Select Municipal / City...</option>
                    </select>

                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>

                </div>
                <div class="form-group">
                    <button type="button" style="margin-top:10px;" class="col-xs-12 btn btn-success" data-toggle="modal" data-target="#AddUser"><i class="fa fa-user-plus"></i> Add User</button>

                </div>
            </form>
        </div>
    </div>
</div>