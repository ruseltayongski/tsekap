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
              

                            <tr>
                                <td>
                                    <a href="#userInfo" class="title-info userInfo" data-id="" data-toggle="modal">
                                       
                                     
                                    </a>
                                </td>
                                <td>
                                        <br />
                                        <small class="text-warning"></small>
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                   
                                </td>
                                <td>
                           
                                         <font class="text-success text-bold">Admin</font>
                  
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

                    
                        </tbody>
                    </table>
                </div>
              <!-- pagination -->
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