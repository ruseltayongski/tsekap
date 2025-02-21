<?php
    use App\Province;
    use App\Facilities;

    $user = Auth::user();
    $provinces = Province::orderBy('description','asc');
    if($user->user_priv == 3){
        $provinces = $provinces->where('id', $user->province);
    }
    $provinces = $provinces->get();

    // Get facilities if user is Admin or Provincial Level
    $facilities = null;
    if ($user->user_priv == 1 || $user->user_priv == 3) {
        $facilities = Facilities::orderBy('name', 'asc')->get();
    }
?>
<div class="modal fade" tabindex="-1" role="dialog" id="addUser">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('users/save') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-user-plus"></i> Add User</legend>
                    </fieldset>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="fname" required>
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="mname">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lname" required>
                    </div>
                    <div class="form-group">
                        <label>Contact #</label>
                        <input type="text" class="form-control" name="contact" required maxlength="11">
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Province</label>
                        <select name="province" class="form-control chosen-select filterProvince" required>
                            <option value="">Select Province...</option>
                            @foreach($provinces as $row)
                                <option value="{{ $row->id }}">{{ $row->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Municipal / City</label>
                        <select name="muncity" class="chosen-select filterMuncity form-control" required>
                            <option value="">Select Municipal / City...</option>
                        </select>
                    </div>
                    <hr />
                    @if($user->user_priv == 1 || $user->user_priv == 3)
                    <div class="form-group">
                        <label>Facility</label>
                        <select name="facility" class="form-control chosen-select" required>
                            <option value="">Select Facility...</option>
                            @foreach($facilities as $facility)
                                <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Level</label>
                        <select name="user_priv" class="form-control chosen-select" required>
                            <option value="">Select Level...</option>
                            @if($user->user_priv == 1)
                                <option value="1">Admin</option>
                                <option value="3">Provincial Level</option>
                            @endif
                            <option value="0">Municipal Level</option>
                            <option value="2">Barangay Level</option>
                            <option value="4">Dentist</option>
                            <option value="5">Rural Health Unit</option>
                            <option value="6">Hospital</option>
                            <option value="0">BHS Head</option>
                            <option value="2">BHS</option>
                            <option value="10">DSO</option>  <!-- Surveillance -->
                            <option value="11">Staff DSO</option>  <!-- Surveillance -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>User Designation</label>
                        <input type="text" class="form-control" name="user_designation" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" pattern=".{3,}" title="Password - minimum of 3 characters" class="form-control" id="password1" name="password" required onkeyup="checkPassword()">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" pattern=".{3,}" title="Confirm password - minimum of 3 characters" class="form-control" id="password2" name="confirm" required onkeyup="checkPassword()">
                        <div class="has-error text-bold text-danger hide">
                            <small>Password does not match!</small>
                        </div>
                        <div class="has-match text-bold text-success hide">
                            <small><i class="fa fa-check-circle"></i> Password matched!</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm btn-save"><i class="fa fa-check"></i> Save</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->