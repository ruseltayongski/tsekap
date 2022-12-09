<?php
use App\Barangay;
$brgy = Barangay::where('muncity_id',Auth::user()->muncity)
        ->orderBy('description','asc')
        ->get();
?>
<div class="modal fade" role="dialog" id="addUser">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('user/save') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-user-plus"></i> Add User</legend>
                    </fieldset>
                    <div class="form-group">
                        <label>User Privilege</label>
                        <select name="user_priv" id="" class="form-control" required>
                            <option value="">Select user type...</option>
                            <option value="2">NDP</option>
                            <option value="4">BHERT</option>
                            <option value="2">RHMPP</option>
                            <option value="2">BHS</option>
                        </select>
                    </div>
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
                        <input type="text" class="form-control" name="contact" required>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Barangay</label>
                        <select name="barangay[]" class="form-control select2" multiple="multiple" style="width: 100%" required>
                            <option value="">Select...</option>
                            @foreach($brgy as $b)
                                <option value="{{ $b->id }}">{{ $b->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" pattern=".{3,}" title="Password - minimum of 3 character" class="form-control" id="password1" name="password" required onkeyup="checkPassword()">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" pattern=".{3,}" title="Confirm password - minimum of 3 Character" class="form-control" id="password2" name="confirm" required onkeyup="checkPassword()">
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

<div class="modal fade" role="dialog" id="userInfo">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('user/update') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-user"></i> User Info</legend>
                    </fieldset>
                    <input type="hidden" name="currentID" id="currentID">
                    <div class="form-group">
                        <label>User Privilege</label>
                        <select name="user_priv" class="form-control user_priv" required>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" required>
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="mname" id="mname">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" required>
                    </div>
                    <div class="form-group">
                        <label>Contact #</label>
                        <input type="text" class="form-control" name="contact" id="contact" required>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Barangay</label>
                        <select name="barangay[]" class="form-control select2" id="barangay" multiple="multiple" style="width: 100%">
                            <option value="">Select...</option>
                            @foreach($brgy as $b)
                                <option value="{{ $b->id }}">{{ $b->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" pattern=".{3,}" title="Password - minimum of 3 character" class="form-control" id="password11" name="password" onkeyup="checkPassword2()" placeholder="Unchanged">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" pattern=".{3,}" title="Confirm password - minimum of 3 Character" class="form-control" id="password12" name="confirm" onkeyup="checkPassword2()" placeholder="Unchanged">
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
                    <button type="button" data-toggle="modal" data-target="#remove" data-dismiss="modal" class="remove btn btn-danger btn-sm" name="delete"><i class="fa fa-trash"></i> Delete</button>
                    <button type="submit" class="btn btn-success btn-save btn-sm" name="update"><i class="fa fa-check"></i> Update</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->