<?php
    use App\Http\Controllers\LocationCtrl as Location;
    use App\Barangay;
    use App\UserBrgy;
    use App\Muncity;
?>
@extends('app')
@section('content')
    @include('user.sidebar')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Users</h2>

            <div class="clearfix"></div>

            @if(count($users))
                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Address/Contact</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $row)

                            <tr>
                                <td>
                                    <a href="#userInfo" class="title-info userInfo" data-id="{{ $row->id }}" data-toggle="modal">
                                        {{ $row->lname }},
                                        {{ $row->fname }}
                                    </a>
                                </td>
                                <td>
                                    {{ Location::getMuncity($row->muncity) }},
                                    {{ Location::getProvince($row->province) }}
                                    @if($row->contact)
                                        <br />
                                        <small class="text-warning">({{ $row->contact }})</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $row->username }}
                                </td>
                                <td>
                                    @if($row->user_priv==1)
                                        <font class="text-success text-bold">Admin</font>
                                    @elseif($row->user_priv==0)
                                        <font class="text-info text-bold">Municipal</font>
                                    @elseif($row->user_priv==3)
                                        <font class="text-danger text-bold">Provincial</font>
                                    @elseif($row->user_priv==4)
                                        <font class="text-danger text-bold">Dentist</font>
                                    @else
                                        <font class="text-warning text-bold">Barangay</font>
                                    @endif
                                </td>
                                <td class="text-bold text-warning">
                                    @if($row->user_priv==1)
                                        <font class="text-success text-bold">All Barangay</font>
                                    @elseif($row->user_priv==0)
                                        <?php $count = Barangay::where('muncity_id',$row->muncity)->count();?>
                                        <font class="text-bold text-info"> {{ $count }} Barangay</font>
                                    @elseif($row->user_priv==3)
                                        <?php $count = Muncity::where('province_id',$row->province)->count();?>
                                        <font class="text-bold text-danger">{{ $count }} Municipality / City</font>
                                    @elseif($row->user_priv==4)
                                        <?php $count = Barangay::where('muncity_id',$row->muncity)->count();?>
                                        <font class="text-bold text-danger">{{ $count }} Barangay</font>
                                    @else
                                        <?php
                                        $brgy = UserBrgy::leftJoin('barangay','UserBrgy.barangay_id','=','barangay.id')
                                                ->where('UserBrgy.user_id',$row->id)->get();
                                        $count = count($brgy);
                                        $c = 1;
                                        ?>
                                        @foreach($brgy as $b)
                                            {{ $b->description }}
                                            @if($c<$count)
                                                <br />
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            @else
                <div class="alert alert-warning">
                    <strong><font class="text-warning"><i class="fa fa-warning fa-lg"></i> No data found! </font></strong>
                </div>
            @endif
        </div>
    </div>
    @include('user.modal')
@endsection

@section('js')
    <?php
    $success = Session::get('success');
    Session::forget('success');

    $delete = Session::get('delete');
    Session::forget('delete');

    $update = Session::get('update');
    Session::forget('update');
    ?>
    @if($success)
        <script>
            Lobibox.notify('success', {
                msg: 'Added successfully!'
            });
        </script>
    @endif

    @if($update)
        <script>
            Lobibox.notify('success', {
                msg: 'Updated successfully!'
            });
        </script>
    @endif

    @if($delete)
        <script>
            Lobibox.notify('success', {
                msg: 'Deleted successfully!'
            });
        </script>
    @endif

    @if(isset($_GET['duplicate'])&&$_GET['duplicate']=='username')
        <script>
            Lobibox.notify('error', {
                msg: 'Username was already taken!'
            });
        </script>
    @endif

    @if(isset($_GET['duplicate'])&&$_GET['duplicate']=='name')
        <script>
            Lobibox.notify('error', {
                msg: 'Name was already added!'
            });
        </script>
    @endif

    <script>
        filterProvince($('.filterProvince').val());
        $('.filterProvince').on('change',function(){
            var id = $(this).val();
            filterProvince(id);
        });

        $('.userInfo').on('click',function(){
            $('.loading').show();
            var id = $(this).data('id');
            var url = 'users/info/'+id;
            $('.loading').show();
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#currentID').val(id);
                    $('#fname').val(data.fname);
                    $('#mname').val(data.mname);
                    $('#lname').val(data.lname);
                    $('#contact').val(data.contact);
                    $('.filterProvince').val(data.province).trigger('chosen:updated');
                    filterProvince(data.province,data.muncity);
                    $('#username').val(data.username);
                    $('#user_priv').val(data.user_priv);
                    console.log(data);
                    $('#user_priv').chosen().trigger('chosen:updated');
                    setTimeout(function(){
                        $('.loading').hide();
                    },200);

                }
            });
        });

        function checkPassword()
        {
            var pass1 = $('#password1').val();
            var pass2 = $('#password2').val();

            if(pass1==pass2){
                $('.btn-save').attr('disabled',false);
                $('.has-error').addClass('hide');
                $('.has-match').removeClass('hide');
                console.log('same');
            }else{
                console.log('not same');
                $('.btn-save').attr('disabled',true);
                $('.has-error').removeClass('hide');
                $('.has-match').addClass('hide');
            }
        }

        function checkPassword2()
        {
            var pass1 = $('#password11').val();
            var pass2 = $('#password12').val();

            if(pass1==pass2){
                $('.btn-save').attr('disabled',false);
                $('.has-error').addClass('hide');
                $('.has-match').removeClass('hide');
                console.log('same');
            }else{
                console.log('not same');
                $('.btn-save').attr('disabled',true);
                $('.has-error').removeClass('hide');
                $('.has-match').addClass('hide');
            }
        }

        function filterProvince(id,muncity)
        {
            var url = 'location/muncity/'+id;
            $('.filterMuncity').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Select Municipal / City..."
                    }));
            if(id){
                $('.loading').show();
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        jQuery.each(data, function(i,val){
                            $('.filterMuncity').append($('<option>', {
                                value: val.id,
                                text : val.description,
                                selected : function(){
                                    if(muncity==val.id){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }
                            }));
                            <?php
                                $tmp = Session::get('userKeyword');
                                $muncity_id = $tmp['muncity_id'];
                            ?>
                            <?php echo "var muncity_id='".$muncity_id."';";?>
                            console.log(muncity_id);
                            $('.filterMuncity').chosen().trigger('chosen:updated');
                        });
                        var tmp = $('#muncity_id').val();
                        if(tmp){
                            $('.filterMuncity').val(tmp).trigger('chosen:updated');
                        }
                        setTimeout(function(){
                            $('.loading').hide();
                        },200);
                    }
                });
            }
        }
    </script>
@endsection