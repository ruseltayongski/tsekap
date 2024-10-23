<?php
  use App\Province;
  use App\Muncity;
  use App\Facility;
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

@extends('resu/app1')
@section('content')

 @include('resu.admin.userSidebar')

  <div class="col-md-9 wrapper">
    <div class="alert alert-jim">
        <h2 class="page-header">Users</h2>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $u)
                            <tr>
                                @php
                                    $fnameParts = str_replace('-DSO', '', $u->fname);
                                    $dso = explode('-', $u->fname);
                                    $lastDso = end($dso);                    
                                @endphp
                                <td>
                                <div class="title-info" 
                                    data-target="#userInfo">
                                    {{ $u->fname }} {{ $u->lname }}
                                </div>
                                <!-- <div class="title-info" 
                                    data-id="{{ $u->id }}" 
                                    data-fname="{{ $u->fname }}" 
                                    data-mname="{{ $u->mname }}" 
                                    data-lname="{{ $u->lname }}" 
                                    data-contact="{{ $u->contact }}" 
                                    data-province="{{ Province::find($u->province)->description }}" 
                                    data-muncity="{{ Muncity::find($u->muncity)->description }}" 
                                    data-username="{{$u -> username}}"
                                    data-user_priv="{{ $u->user_priv }}" 
                                    data-toggle="modal" 
                                    data-target="#userInfo">
                                    {{ $u->fname }} {{ $u->lname }}
                                </div> -->
                                </td>
                                <td>
                                        {{ Muncity::find($u->muncity)->description }},
                                        {{ Province::find($u->province)->description }}
                                 </td>
                                <td>{{ $u->contact }}</td>
                                <td>{{ $u->username }}</td>
                                <td>
                                        @if($u->user_priv == 6)
                                            <font class="text-info text-bold">Facility</font>
                                        @elseif($u->user_priv == 7)
                                            <font class="text-danger text-bold">Region</font>
                                        @elseif($u->user_priv == 3)
                                            <font class="text-danger text-bold">Provincial</font>
                                        @elseif($u->user_priv == 8)
                                            <font class="text-danger text-bold">HUC</font>
                                        @elseif($u->user_priv == 10)
                                            <font class="text-bold text-danger">DSO</font>
                                        @elseif($u->user_priv == 11)
                                            <font class="text-bold text-danger">Staff DSO</font>
                                        @endif
                                        </td>
                                        <td>
                                        <button type="button" class="btn btn-danger btn-sm openDeleteModal" 
                                                data-id="{{ $u->id }}" 
                                                data-toggle="modal" 
                                                data-target="#deleteModal">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>                                        
                                            <button type="button" class="btn btn-success btn-sm updateUser" 
                                                    data-id="{{ $u->id }}" 
                                                    data-toggle="modal" 
                                                    data-target="#updateUser">
                                                <i class="fa fa-edit"></i> Update
                                            </button>
                                        </td>
                                    </tr>                                    
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    {{ $user->links() }}
                    @if(request()->has('keyword') || request()->has('level') || request()->has('province_id') || request()->has('muncity_id'))
                        <a href="{{ route('resu.admin.view_Users') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    @endif        
            </div>
    </div>

  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <!-- Form for delete action -->
                <form id="deleteUserForm" method="POST" action="{{ route('resu.admin.delete_user') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" id="delete_user_id">  <!-- Hidden Input -->
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-labelledby="updateUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="updateUser">Update User Information</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <hr>
            <div class="modal-body"> 
                <!-- Form for update action -->
                <form id="updateUserForm" action="{{ route('update-User', ['id' => ':id']) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="user_id" id="update_user_ids">  <!-- Hidden Input for user ID -->
                    
                    <!-- First Name -->
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname">
                    </div>

                    <!-- Middle Name -->
                    <div class="form-group">
                        <label for="mname">Middle Name</label>
                        <input type="text" class="form-control" name="mname" id="mname">
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" >
                    </div>

                    <!-- Contact Number -->
                    <div class="form-group">
                        <label for="contact">Contact #</label>
                        <input type="text" class="form-control" name="contact" id="contact">
                    </div>
                    
                    <hr />
                    <div class="form-group">
                        <label>Level</label>
                        <select name="user_priv" id='level-select-update' class="form-control chosen-select" >
                            <option value="">Select Level...</option>
                            <option value="7">Region Level</option>
                            <option value="3">Provincial Level</option>
                            <option value="8">HUC Level</option>
                            <option value="6">Facility level</option>
                            <option value="10">DSO</option>  <!-- I add this for the user of Surveillance -->
                            <option value="11">Staff DSO</option>  <!-- I add this for the user of Surveillance -->
                        </select>
                    </div>
                    
                    <div class="form-group" id="facilities-select-group-update" style="display:none;">
                        <label>Facilities</label>
                        <select name="Selected_facilities" id="facilities-select-update" class="form-control chosen-select">
                            <option value="">Select Facilities...</option>
                            @foreach($facility as $fact)
                                <option value="{{ $fact->id }}">{{ $fact->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Province</label>
                        <select name="province" class="form-control chosen-select filterProvince" id="Selectprovince-update" >
                            <option value="">Select Province...</option>
                            @foreach($provinces as $row)
                                <option value="{{ $row->id }}">{{ $row->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <input type="hidden" id="get-province" value="{{ $provinces }}">
                    
                    <div class="form-group">
                        <label>Municipal / City</label>
                        <select name="muncity" class="chosen-select form-control" id="SelectedMuncity-update" >
                        </select>
                    </div>
                    
                    <input type="hidden" id="get_all_muncity" value="{{ $muncity }}">
                    <input type="hidden" id="get_muncity" value="{{ $selectedMuncity }}">
                    
                    <hr />
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" >
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('resu.admin.Usermodal')

@endsection

@section('js')

<script>
    $(document).ready(function(){

        $('#level-select').on('change', function() {
            var selectedLevel = $(this).val();
            if(selectedLevel == '6'){
                $('#facilities-select-group').show();
                $('#facilities-select').attr('required', true);
            }else{
                $('#facilities-select-group').hide();
                $('#facilities-select').removeAttr('required');
                $('#facilities-select').val('').trigger('chosen:updated');
                $('#facilities-select').val('').trigger('change');
            }
            if (selectedLevel == 8) {
                var selectedMuncity = JSON.parse(document.getElementById("get_muncity").value);
                $('#SelectedMuncity').empty().append('<option value="">Select Municipal / City...</option>');
                $.each(selectedMuncity, function(index, muncity) {
                    console.log('muncity:' ,muncity.description);
                    $('#SelectedMuncity').append('<option value="' + muncity.id + '">' + muncity.description + '</option>');
                });

                $('#SelectedMuncity').trigger('chosen:updated');
                $('#Selectprovince').trigger('chosen:updated');
            }else{
                $('#Selectprovince').empty().append('<option value="">Select Province..</option>');
                var provinces = JSON.parse(document.getElementById("get-province").value);

                $.each(provinces, function(index, province){
                    $('#Selectprovince').append('<option value=" ' + province.id + ' ">' + province.description + '</option>')
                });
                $('#SelectedMuncity').append('<option value="' + muncity.id + '">' + muncity.description + '</option>');

                $('#SelectedMuncity').trigger('chosen:updated');
                $('#Selectprovince').trigger('chosen:updated');
            } 
        });

        $("#Selectprovince").change(function () {
            var provinceId = $(this).val();
            var allmuncity = JSON.parse(document.getElementById("get_all_muncity").value);
            $('#SelectedMuncity').empty().append('<option value="">Select Municipal / City...</option>'); // Clear existing options
            $.each(allmuncity, function(index, mun){
                if(provinceId == mun.province_id){
                    $('#SelectedMuncity').append('<option value=" '+ mun.id +' ">' + mun.description +'</option>');
                }
            });
            $('#SelectedMuncity').trigger('chosen:updated');
        });
        
        //for update modal
        $('#level-select-update').on('change', function() {
            var selectedLevelUpdate = $(this).val();
            if(selectedLevelUpdate == '6'){
                $('#facilities-select-group-update').show();
                $('#facilities-select-update').attr('required', true);
            }else{
                $('#facilities-select-group-update').hide();
                $('#facilities-select-update').removeAttr('required');
                $('#facilities-select-update').val('').trigger('chosen:updated');
                $('#facilities-select-update').val('').trigger('change');
            }
            if (selectedLevelUpdate == 8) {
                var selectedMuncityUpdate = JSON.parse(document.getElementById("get_muncity").value);
                $('#SelectedMuncity-update').empty().append('<option value="">Select Municipal / City...</option>');
                $.each(selectedMuncityUpdate, function(index, muncity) {
                    console.log('muncity:' ,muncity.description);
                    $('#SelectedMuncity-update').append('<option value="' + muncity.id + '">' + muncity.description + '</option>');
                });

                $('#SelectedMuncity-update').trigger('chosen:updated');
                $('#Selectprovince-update').trigger('chosen:updated');
            }else{
                $('#Selectprovince-update').empty().append('<option value="">Select Province..</option>');
                var provincesUpdate = JSON.parse(document.getElementById("get-province").value);

                $.each(provincesUpdate, function(index, province){
                    $('#Selectprovince-update').append('<option value=" ' + province.id + ' ">' + province.description + '</option>')
                });
                $('#SelectedMuncity-update').append('<option value="' + muncity.id + '">' + muncity.description + '</option>');

                $('#SelectedMuncity-update').trigger('chosen:updated');
                $('#Selectprovince-update').trigger('chosen:updated');
            } 
        });
        $("#Selectprovince-update").change(function () {
            var provinceIdUpdate = $(this).val();
            var allmuncityUpdate = JSON.parse(document.getElementById("get_all_muncity").value);
            $('#SelectedMuncity-update').empty().append('<option value="">Select Municipal / City...</option>'); // Clear existing options
            $.each(allmuncityUpdate, function(index, mun){
                if(provinceIdUpdate == mun.province_id){
                    $('#SelectedMuncity-update').append('<option value=" '+ mun.id +' ">' + mun.description +'</option>');
                }
            });
            $('#SelectedMuncity-update').trigger('chosen:updated');
        });

    //    // This will trigger whenever a user clicks the 'Full Name' link
    //     $('.userInfo').on('click', function () {
    //     var userId = $(this).data('id');
    //     var fname = $(this).data('fname');
    //     var mname = $(this).data('mname');
    //     var lname = $(this).data('lname');
    //     var contact = $(this).data('contact');
    //     var username = $(this).data('username');
    //     var userPriv = $(this).data('user_priv'); 
    //     var province = $(this).data('province'); 
    //     var muncity = $(this).data('muncity'); 

    //     var userPrivDisplay;
    //     switch (userPriv) {
    //         case 6:
    //             userPrivDisplay = 'Facility';
    //             break;
    //         case 7:
    //             userPrivDisplay = 'Region';
    //             break;
    //         case 3:
    //             userPrivDisplay = 'Provincial';
    //             break;
    //         case 8:
    //             userPrivDisplay = 'HUC';
    //             break;
    //         case 10:
    //             userPrivDisplay = 'DSO';
    //             break;
    //         case 11:
    //             userPrivDisplay = 'Staff DSO';
    //             break;
    //         default:
    //             userPrivDisplay = 'Unknown';
    //     }

    //     // Populate modal fields
    //     $('#currentID').val(userId);
    //     $('#fname').val(fname);
    //     $('#mname').val(mname);
    //     $('#lname').val(lname);
    //     $('#contact').val(contact);
    //     $('#username').val(username);
    //     $('#level').val(userPrivDisplay);
    //     $('#provinces').val(province);
    //     $('#muncity').val(muncity);
    //     });

        $('.openDeleteModal').on('click', function () {
            var userId = $(this).data('id');  
            $('#delete_user_id').val(userId);  
        });

        $('.updateUser').on('click', function () {
            var userId = $(this).data('id');  // Get the user ID
            var fname = $(this).data('fname'); 
            var mname = $(this).data('mname'); 
            var lname = $(this).data('lname'); 
            var contact = $(this).data('contact'); 
            var username = $(this).data('username'); 
            var user_priv = $(this).data('user_priv');
            var province = $(this).data('province');
            var muncity = $(this).data('muncity'); 
            $('#update_user_ids').val(userId); 
            $('#fname').val(fname); 
            $('#mname').val(mname);
            $('#lname').val(lname);
            $('#contact').val(contact); 
            $('#username').val(username); 
            $('#level-select-update').val(user_priv);
            $('#Selectprovince-update').val(province);
            $('#SelectedMuncity-update').val(muncity); 
            $('#updateUserForm').attr('action', '{{ route("update-User", ["id" => ""]) }}' + userId);
        });
    });

</script>

@endsection