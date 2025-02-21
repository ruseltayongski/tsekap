<?php
use App\Province;
$provinces = Province::orderBy('description', 'asc');
$user = \Illuminate\Support\Facades\Auth::user();

if ($user->user_priv == 3) {
    $provinces = $provinces->where('id', $user->province);
}

$provinces = $provinces->get();
?>

{{-- Override --}}
<!-- Include the change password modal -->
@include('user.changepass')

<div class="col-md-3 wrapper">
    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">User Menu</h3>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ asset('users') }}">
                {{ csrf_field() }}
                <!-- Search users -->
                <div class="form-group">
                    <label>Search User</label>
                    <input type="text" class="form-control" placeholder="Input name..." name="keyword" value="{{ $keyword }}" autofocus>
                </div>
                <div class="form-group">
                    <label>Access Level</label>
                    <select name="level" class="form-control chosen-select">
                        <option value="">Select Level...</option>
                        <option value="1" @if ($level == '1') selected @endif>Admin Level</option>
                        <option value="3" @if ($level == '3') selected @endif>Provincial Level</option>
                        <option value="0" @if ($level == '0') selected @endif>Municipal Level</option>
                        <option value="2" @if ($level == '2') selected @endif>Barangay Level</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Province</label>
                    <select name="province_id" class="form-control chosen-select filterProvince" id="province">
                        <option value="">Select Province...</option>
                        @foreach ($provinces as $p)
                            <option value="{{ $p->id }}" @if ($province_id == $p->id) selected @endif>{{ $p->description }}</option>
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
                    <button type="button" class="col-xs-12 btn btn-success" style="margin-top:10px;" data-toggle="modal" data-target="#addUser"><i class="fa fa-user-plus"></i> Add User</button>
                </div>
                @if ($user->user_priv == 1 || $user->user_priv == 3)
                    <div class="form-group">
                        <button type="button" class="col-xs-12 btn btn-success" style="margin-top:10px;" data-toggle="modal" data-target="#changePass"><i class="fa fa-key"></i> Change a User's Password</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
