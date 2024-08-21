<?php
use App\Muncity;
use App\Province;

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
                                 

                                    <a href="#userInfo" class="title-info userInfo" data-id="" data-toggle="modal">
                                       {{ $fnameParts }},
                                       {{ $u->lname }}
                                    </a>
                                </td>
                                <td>
                                    {{ Muncity::find($u->muncity)->description}},
                                    {{ Province::find($u->province)->description }}
                                </td>
                                <td>
                                    {{ $u->contact}}
                                </td>
                                <td>
                                   {{ $u->username}}
                                </td>
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
                                        <!-- <font class="text-info text-bold">Municipal</font>
                                    
                                        <font class="text-danger text-bold">Provincial</font>
                              
                                        <font class="text-danger text-bold">Dentist</font>
                                
                                        <font class="text-danger text-bold">Rural Health Unit</font>
                                
                                        <font class="text-danger text-bold">Hospital</font> 
                                  
                                        <font class="text-bold text-danger">DSO</font> 
                            
                                        <font class="text-bold text-danger">Staff DSO</font>
                          
                                        <font class="text-warning text-bold">Barangay</font> -->
                                    
                                </td>
                            </tr>
                        @endforeach
                    
                        </tbody>
                    </table>
                </div>
                {{ $user->links() }}
<!--          
                <div class="alert alert-warning">
                    <strong><font class="text-warning"><i class="fa fa-warning fa-lg"></i> No data found! </font></strong>
                </div> -->
            
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

                $('#Selectprovince').find('option').each(function() {
                    if($(this).text() !== "Cebu"){
                        $(this).remove();
                    }else{
                        $(this).prop('selected', true); // Select Cebu option
                    }
                });

                $('#SelectedMuncity').trigger('chosen:updated');
                $('#Selectprovince').trigger('chosen:updated');
            }else{
                $('#Selectprovince').empty().append('<option value="">Select Province..</option>');
                var provinces = JSON.parse(document.getElementById("get-province").value);

                $.each(provinces, function(index, province){
                    $('#Selectprovince').append('<option value=" ' + province.id + ' ">' + province.description + '</option>')
                });
                
                $('#SelectedMuncity').empty().append('<option value="">Select Municipal / City...</option>');

                $('#SelectedMuncity').trigger('chosen:updated');
                $('#Selectprovince').trigger('chosen:updated');
            }

 
        });

        $("#Selectprovince").change(function () {
            var provinceId = $(this).val();
            var allmuncity = JSON.parse(document.getElementById("get_all_muncity").value);
            
            $.each(allmuncity, function(index, mun){
                
                if(mun.province_id == provinceId){
                    $('#SelectedMuncity').append('<option value=" '+ mun.id +' ">' + mun.description +'</option>');
                }
            });

            $('#SelectedMuncity').trigger('chosen:updated');
        });

    });
</script>

@endsection