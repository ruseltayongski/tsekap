<?php
    use App\Province;
    use App\Muncity;
    use App\Facility;

    $user = Auth::user();
    $facility = Facility::select('id', 'name')->get();
    $provinces = Province::orderBy('description','asc');
    if($user->user_priv==3){
        $provinces = $provinces->where('id',$user->province);
    }
    $provinces = $provinces->get();
    $muncity = Muncity::select('id','province_id', 'description')
                ->whereNotIn('id',['63','76','80'])
                ->get();

    $selectedMuncity = Muncity::select('id','description')
    ->whereIn('id', ['63','76','80'])
    ->get();

?>
<div class="modal fade" tabindex="-1" role="dialog" id="AddUser">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('add-users') }}">
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
                        <input type="text" class="form-control" name="contact" required>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Level</label>
                        <select name="user_priv" id='level-select' class="form-control chosen-select" required>
                            <option value="">Select Level...</option>
                            <option value="7">Region Level</option>
                            <option value="3">Provincial Level</option>
                            <option value="8">HUC Level</option>
                            <option value="6">Facility level</option>
                           <option value="10">DSO</option>  <!-- I add this for the user of Survellance -->
                           <option value="11">Staff DSO</option>  <!-- I add this for the user of Survellance -->
                        </select>
                    </div>

                    <div class="form-group" id="facilities-select-group"  style="display:none">
                        <label>Facilities</label>
                        <select name="Selected_facilities" id="facilities-select" class="form-control chosen-select">
                            <option value="">Select Facilities...</option>
                                @foreach($facility as $fact)
                                    <option value="{{ $fact->id }}">{{ $fact->name }}</option>
                                @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Province</label>
                        <select name="province" class="form-control chosen-select filterProvince" id="Selectprovince" required>
                            <option value="">Select Province...</option>
                            @foreach($provinces as $row)
                            <option value="{{ $row->id }}">{{ $row->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="get-province" value="{{ $provinces }}">

                    <div class="form-group">
                        <label>Municipal / City</label>
                        <select name="muncity" class="chosen-select form-control" id="SelectedMuncity">
                           
                        </select>
                    </div>
                    <input type="hidden" id="get_all_muncity" value="{{ $muncity }}">
                    <input type="hidden" id="get_muncity" value="{{ $selectedMuncity }}">
                    <hr />
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
                            <small>Password not match!</small>
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

<div class="modal fade" tabindex="-1" role="dialog" id="userInfo">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('users/update') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-user"></i> User Info</legend>
                    </fieldset>
                    <input type="hidden" name="currentID" id="currentID">
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
                        <label>Level</label>
                        <select name="user_priv" class="form-control chosen-select" id="user_priv" required>
                            <option value="">Select Level...</option>
                            @if($user->user_priv==1)
                                <option value="1">Admin</option>
                                <option value="3">Provincial Level</option>
                            @endif
                            <option value="0">Municipal Level</option>
                            <option value="2">Barangay Level</option>
                            <option value="4">Dentist</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <select name="province" class="form-control chosen-select filterProvince" id="province" style="width: 100%;" required>
                            <option value="">Select Province...</option>
                            @foreach($provinces as $row)
                                <option value="{{ $row->id }}">{{ $row->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Municipal / City</label>
                        <select name="muncity" class="chosen-select filterMuncity form-control" id="muncity" required>
                            <option value="">Select Municipal / City...</option>
                        </select>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                   
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" pattern=".{3,}" title="Password - minimum of 3 characters" class="form-control" id="password11" name="password" onkeyup="checkPassword2()" placeholder="Unchanged">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" pattern=".{3,}" title="Confirm password - minimum of 3 characters" class="form-control" id="password12" name="confirm" onkeyup="checkPassword2()" placeholder="Unchanged">
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
