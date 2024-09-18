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
                    <form method="POST" action="{{ asset('users-search') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Search User</label>
                                <input type="text" style="width: 100%;" class="form-control" placeholder="Input name..." name="keyword" value="{{ request('keyword') }}" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Access Level</label>
                                <select name="level" class="form-control chosen-select">
                                    <option value="">Select Level...</option>
                                    <option value="7" @if(request('level') == '7') selected @endif>Region Level</option>
                                    <option value="3" @if(request('level') == '3') selected @endif>Provincial Level</option>
                                    <option value="8" @if(request('level') == '8') selected @endif>HUC Level</option>
                                    <option value="6" @if(request('level') == '6') selected @endif>Facility Level</option>
                                    <option value="10" @if(request('level') == '10') selected @endif>DSO Level</option>
                                    <option value="11" @if(request('level') == '11') selected @endif>Staff DSO Level</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Province</label>
                                <select name="province_id" class="form-control chosen-select filterProvince" id="province">
                                    <option value="">Select Province...</option>
                                    @foreach($provinces as $p)
                                        <option value="{{ $p->id }}" @if(request('province_id') == $p->id) selected @endif>{{ $p->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Municipal / City</label>
                                <input type="hidden" id="muncity_id" value="{{ request('muncity_id') }}" />
                                <select name="muncity_id" class="chosen-select filterMuncity form-control" id="muncity">
                                    <option value="">Select Municipal / City...</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>
                            </div>
                            <div class="form-group">
                                <button type="button" style="margin-top:10px;" class="col-xs-12 btn btn-success" data-toggle="modal" data-target="#AddUser"><i class="fa fa-user-plus" ></i> Add User</button>
                            </div>
                        </form>
            </div>
    </div>
</div>