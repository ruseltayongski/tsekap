@extends('client')
@section('content')
    <style>
        .family {
            font-size: 0.9em;
        }
        .family label {
            font-weight: bold;
        }
        .family .info {
            color: #337ab7;
        }
        .family .sub-info {
            font-style: italic;
            color: #a94442;
        }
    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Dengvaxia Patients</h2>
            <form class="form-inline" method="POST" action="{{ asset('user/population') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <?php $tmp = Session::get('profileKeyword');?>
                    <input type="text" class="form-control" placeholder="Quick Search" name="keyword" value="{{ $tmp['keyword'] }}" autofocus>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>
                    <div class="clearfix"></div>
                </div>
                @if(Session::get('profileKeyword'))
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning col-xs-12" name="viewAll" value="true"><i class="fa fa-search"></i> View All</button>
                        <div class="clearfix"></div>
                    </div>
                @endif
                <div class="form-group">
                    <a class="btn btn-success col-xs-12" href="#filterResult" data-toggle="modal"><i class="fa fa-filter"></i> Filter Result</a>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <a class="btn btn-primary col-xs-12" href="{{ asset('user/dengvaxia/add') }}"><i class="fa fa-user-plus"></i> Add Profile</a>
                    <div class="clearfix"></div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="table-responsive">
                @if(count($profiles))
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Family ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Suffix</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Barangay</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $profiles->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <p class="text-info"><i class="fa fa-info-circle fa-lg text-bold"></i> No data found!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('modal.populationModal')
@endsection

@section('js')
    @include('script.population')
    <?php
    $status = session('status');
    ?>
    @if($status=='added')
        <script>
            Lobibox.notify('success', {
                msg: 'Added successfully!'
            });
        </script>
    @endif

    @if($status=='updated')
        <script>
            Lobibox.notify('success', {
                msg: 'Updated successfully!'
            });
        </script>
    @endif

    @if($status=='deleted')
        <script>
            Lobibox.notify('success', {
                msg: 'Deleted successfully!'
            });
        </script>
    @endif

    <script>
        <?php echo 'var link="'.asset('user/profiles').'";';?>

        $(".select-profile").select2({
            ajax: {
                url: link,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            templateResult: formatProfile, // omitted for brevity, see the source of this page
            templateSelection: formatProfileSelection, // omitted for brevity, see the source of this page

        });
        $('a[href="#addProfile"]').on('click',function(){
            $('#addProfile').modal('toggle');
            var id = $(this).data('id');
            var description = $(this).data('description');
            $('#familyID').val(id);
            $('#familyName').val(description);
        });


        $('a[href="#infoProfile"]').on('click',function(){
            var id = $(this).data('id');
            $('.loading').show();
            <?php echo 'var url="'.asset('user/population/info').'";';?>
            $.ajax({
                url: url+'/'+id,
                type: 'GET',
                success: function(jim){
                    $('#currentID').val(id);
                    $('#fname').val(jim.fname);
                    $('#mname').val(jim.mname);
                    $('#lname').val(jim.lname);
                    $('#suffix').val(jim.suffix).trigger('change');
                    $('#head').val(jim.head).trigger('change');
                    $('#dob').val(jim.dob);
                    $('#sex').val(jim.sex).trigger('change');
                    $('#barangay').val(jim.barangay_id).trigger('change');
                    $('#currentFamilyID').val(jim.family_id);
                    $('#currentFamilyName').val(jim.description);
                    $('#head').val(jim.head).trigger("chosen:updated");

                    var tmpHead = $('#head').val();
                    if(tmpHead=='YES'){
                        $('#relation').parent('.form-group').hide();
                    }else{
                        $('#relation').parent('.form-group').show();
                    }
                    $('#relation').val(jim.relation).trigger('change');
                    $('.loading').hide();
                }
            });

        });

        $('#head').on('change',function(){
            var tmp = $(this).val();
            console.log(tmp);
            if(tmp=='YES'){
                $('#relation').parent('.form-group').hide();
            }else{
                $('#relation').parent('.form-group').show();
            }
        });

        function formatProfile(profile) {
            if (profile.loading) return profile.text;
            var html = '<div><strong>'+profile.description+'</strong> - <small>('+profile.fname+' '+profile.mname+' '+profile.lname+')</small></div>';
            return html;
        }

        function formatProfileSelection(profile) {
            return profile.description || profile.text;
        }
        $('.filter_familyProfile').on('change',function(){
            if($(this).val()=== 'others'){
                $('.others').removeClass('hide').fadeIn();
            } else {
                $('.others').addClass('hide');
            }
        });


        function validateForm(){
            var familyProfile = $('select[name="familyID"]');
            var brgy = $('select[name="barangay"]');
            var head = $('select[name="head"]');

            if(familyProfile.val()){
                $('select[name="familyID"]').siblings('.chosen-container').css({border:'none'});
            }else{
                $('select[name="familyID"]').siblings('.chosen-container').css({border:'2px solid red'});
            }

            if(brgy.val()){
                $('select[name="barangay"]').siblings('.chosen-container').css({border:'none'});
            }else{
                $('select[name="barangay"]').siblings('.chosen-container').css({border:'2px solid red'});
            }

            if(head.val()){
                $('select[name="head"]').siblings('.chosen-container').css({border:'none'});
            }else{
                $('select[name="head"]').siblings('.chosen-container').css({border:'2px solid red'});
            }
        }

        function validateForm2(){
            var familyProfile = $('select[id="familyID"]');
            var brgy = $('select[id="barangay"]');
            var head = $('select[id="head"]');

            if(familyProfile.val()){
                familyProfile.siblings('.chosen-container').css({border:'none'});
            }else{
                familyProfile.siblings('.chosen-container').css({border:'2px solid red'});
            }

            if(brgy.val()){
                brgy.siblings('.chosen-container').css({border:'none'});
            }else{
                brgy.siblings('.chosen-container').css({border:'2px solid red'});
            }

            if(head.val()){
                head.siblings('.chosen-container').css({border:'none'});
            }else{
                head.siblings('.chosen-container').css({border:'2px solid red'});
            }
        }

        $('.btn-submit').on('click',function(){
            validateForm();
        });

        $('.btn-update').on('click',function(){
            validateForm2();
        });
    </script>
@endsection