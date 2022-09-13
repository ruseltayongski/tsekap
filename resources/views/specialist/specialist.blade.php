<?php
$user = Auth::user();
?>

@extends($dashboard)
@section('content')
    <div class="col-md-12">
        <span> <b style="font-size: 20px">LIST OF HEALTH SPECIALISTS</b>
            <div class="pull-right">
                <form action="{{ asset('specialist') }}" method="POST" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom: 10px;">
                        <input type="text" class="form-control" placeholder="Search name..." name="keyword" value="{{ Session::get("specialistKeyword") }}" >
                        <button type="submit" class="btn btn-success btn-flat">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-flat">
                            <i class="fa fa-eye"></i> View All
                        </button>
                        @if($user->user_priv == 0 || $user->user_priv == 2)
                            <a href="#specialist_modal" data-backdrop="static" data-keyboard="false" data-toggle="modal" onclick="SpecialistBody('')" class="btn btn-info btn-flat">
                                <i class="fa fa-user-md"></i>&nbsp; Add Specialist
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </span>
    </div><br><br><br>

    @if(count($data) > 0 )
        <div class="table-responsive" style="background-color: whitesmoke; padding: 5px; width:100%;">
            <table class="table table-bordered table-striped table-fixed-header" style="width:100%;">
                <thead class="header">
                    <tr class="bg-black-gradient">
                        <th style="vertical-align: middle;"> Name </th>
                        <th class="text-center" style="vertical-align: middle;"> Affiliated Facilities </th>
                        <th class="text-center" style="vertical-align: middle;"> Contact Info </th>
                        <th class="text-center" style="vertical-align: middle;"> Specialization </th>
                        <th class="text-center" style="white-space: nowrap; vertical-align: middle;"> Schedule </th>
                        <th class="text-center" style="vertical-align: middle;"> Specialist Fee </th>
                    </tr>
                </thead>

                @foreach($data as $row)
                    <tr>
                        <th style="white-space: nowrap;">
                            <b>
                                @if($user->user_priv == 0 || $user->user_priv == 2)
                                    <a
                                            href="#specialist_modal"
                                            data-toggle="modal"
                                            data-backdrop="static"
                                            data-keyboard="false"
                                            data-id = "{{ $row->user_id }}"
                                            onclick="SpecialistBody('<?php echo $row->username ?>')"
                                            class="update_info"
                                    >
                                        {{ $row->lname }}, {{ $row->fname }}, {{ $row->mname }}
                                    </a>
                                @else
                                    <span class="text-info"> {{ $row->lname }}, {{ $row->fname }}, {{ $row->mname }} </span>
                                @endif
                            </b><br>
                        </th>
                        <?php $facilities = \App\Http\Controllers\SpecialistCtrl::getUserFacilities($row->username);?>
                        <td>
                        @foreach($facilities as $f)
                            <b class="text-green">{{$f->facility_name}}</b><br><br><br>
                        @endforeach
                        </td>
                        <td>
                        @foreach($facilities as $f)
                            <small>{{ $f->contact }} <br> {{ $f->email }}</small><br><br>
                        @endforeach
                        </td>
                        <td>
                        @foreach($facilities as $f)
                            <small> {{ $f->specialization }} </small><br><br><br>
                        @endforeach
                        </td>
                        <td>
                        @foreach($facilities as $f)
                            <small> {{ $f->schedule }} </small><br><br><br>
                        @endforeach
                        </td>
                        <td>
                        @foreach($facilities as $f)
                            <small> {{ $f->fee }} </small><br><br><br>
                        @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                {{ $data->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <span class="text-warning">
                <i class="fa fa-warning"></i> No records found!
            </span>
        </div>
    @endif
    <br><br>

    @include('specialist.specialist_modal')
    @include('modal.checkUser')
@endsection

@section('js')
<script>
    $('.table-fixed-header').fixedHeader();

    /*  ________________________
    *   |  VERIFY USER PROFILE |
    *   ------------------------
    */
    $('.btn-checkUserProfile').on('click', function() {
        var data = {
            'fname' : $('#checkUserProfile').find('.fname').val(),
            'mname' : $('#checkUserProfile').find('.mname').val(),
            'lname' : $('#checkUserProfile').find('.lname').val()
        };

        $.ajax({
            url: "{{ url('specialist/verify') }}",
            type: 'GET',
            data: data,
            success: function (users) {
                if(users.length > 0) {
                    content = '<table class="table table-hover table-striped">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>First Name</th>' +
                                '<th>Middle Name</th>' +
                                '<th>Last Name</th>' +
                                '<th class="text-center">Update</th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    users.forEach(function (val){
                        var func = 'SpecialistBody("' + val.username + '")';
                        content +=
                            '<tr>' +
                                '<td>'+val.fname+'</td>' +
                                '<td>'+val.mname+'</td>' +
                                '<td>'+val.lname+'</td>' +
                                '<td class="text-center">' +
                                    '<a href="" data-dismiss="modal" data-toggle="modal" onclick=' + func + ' class="btn btn-success btn-sm">' +
                                        '<i class="fa fa-pencil"></i> Update' +
                                    '</a></td>' +
                            '</tr>';
                    });

                    content += '</tbody></table>';
                    $('.verify_user_body').html(content);
                    $('.btn-checkUserProfile').hide();
                } else {
                    $('#input_fname').val(data.fname);
                    $('#input_mname').val(data.mname);
                    $('#input_lname').val(data.lname);
                    $('#checkUserProfile').modal('toggle');
                }
                $('#checkUserProfile').find('.fname').val('');
                $('#checkUserProfile').find('.mname').val('');
                $('#checkUserProfile').find('.lname').val('');
            }
        });
    });

    $('#btn-closeUserProfile').on('click', function() {
        resetVerificationModal();
    });

    function resetVerificationModal() {
        $('.verify_user_body').html("" +
            "<table class=\"table table-input table-bordered table-hover\" border=\"1\">\n" +
            "                    <tr class=\"has-group\">\n" +
            "                        <td>First Name :</td>\n" +
            "                        <td><input type=\"text\" name=\"fname\" class=\"fname form-control\" required /> </td>\n" +
            "                    </tr>\n" +
            "                    <tr>\n" +
            "                        <td>Middle Initial :</td>\n" +
            "                        <td><input type=\"text\" name=\"mname\" class=\"mname form-control\" /> </td>\n" +
            "                    </tr>\n" +
            "                    <tr class=\"has-group\">\n" +
            "                        <td>Last Name :</td>\n" +
            "                        <td><input type=\"text\" name=\"lname\" class=\"lname form-control\" required /> </td>\n" +
            "                    </tr>\n" +
            "                </table>" +
            "");
        $('.btn-checkUserProfile').show();
        $('#checkUserProfile').modal('toggle');
    }

    /*  ________________________
    *   |  GET SPECIALIST INFO |
    *   ------------------------
    */
    <?php $user = Session::get('auth'); ?>
    function SpecialistBody(username){
        if(username == '') {
            resetVerificationModal();
        }
        $.ajax({
            url: "<?php echo asset('specialist/body') ?>",
            type: 'GET',
            data: { "username": username},
            success: function (data) {
                $('.specialist_body').html(data);
            }
        });
    }

    /*  ______________________
    *   |  REMOVE SPECIALIST |
    *   ----------------------
    */
    function SpecialistDelete(user_id, fname, lname, username) {
        $(".user_id").val(user_id);
        $(".username").val(username);
        $(".delete_name").html(fname+" "+lname);
    }

    /*  _________________________
    *   |  NOTIFICATION MESSAGE |
    *   -------------------------
    */
    @if(Session::get('specialist_notif'))
    Lobibox.notify('success', {
        title: "",
        msg: "<?php echo Session::get("specialist_msg"); ?>",
        size: 'mini',
        rounded: true
    });
    <?php
    Session::put("specialist_notif",false);
    Session::put("specialist_msg",false)
    ?>
    @endif
</script>
@endsection