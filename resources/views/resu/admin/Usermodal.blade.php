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
                        <select name="user_priv" id='level-select' class="form-control chosen-select" >
                            <option value="">Select Level...</option>
                            <option value="7">Region Level</option>
                            <option value="3">Provincial Level</option>
                            <option value="8">HUC Level</option>
                            <option value="6">Facility level</option>
                           <option value="10">DSO</option>  <!-- I add this for the user of Survellance -->
                           <option value="11">Staff DSO</option>  <!-- I add this for the user of Survellance -->
                        </select>
                    </div>

                    <div class="form-group" id="facilities-select-group"  style="display:none";>
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
        <form>
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-user"></i> User Info</legend>
                    </fieldset>
                    <!-- Hidden input to store user ID -->
                    <input type="hidden" name="currentID" id="currentID">
                    <!-- First Name -->
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" readonly>
                    </div>
                    <!-- Middle Name -->
                    <div class="form-group">
                        <label for="mname">Middle Name</label>
                        <input type="text" class="form-control" name="mname" id="mname" readonly>
                    </div>
                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" readonly>
                    </div>
                    <!-- Contact Number -->
                    <div class="form-group">
                        <label for="contact">Contact #</label>
                        <input type="text" class="form-control" name="contact" id="contact" readonly>
                    </div>
                    <hr />
                    <!-- User Level -->
                    <div class="form-group">
                        <label for="level">Level</label>
                        <input type="text" class="form-control" name="user_priv" id="level" readonly>
                    </div>
                    <div class="form-group">
                        <label for="province">Province</label>
                        <input type="text" class="form-control" name="provinces" id="provinces" readonly>
                    </div>
                    <!-- Municipal/City -->
                    <div class="form-group">
                        <label for="muncity">Municipal / City</label>
                        <input type="text" class="form-control" name="muncity" id="muncity" readonly>
                    </div>
                    <hr />
            </div>
        </form>
    </div>
</div>


<script>          
</script>
