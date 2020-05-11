<?php
    use App\Http\Controllers\LocationCtrl as Location;
    use App\Barangay;
    use App\UserBrgy;
?>
@extends('client')
@section('content')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">User (Barangay Level)</h2>
            <form class="form-inline" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Quick Search" name="userKeyword" value="{{ Session::get('userKeyword') }}" autofocus>
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUser"><i class="fa fa-user-plus"></i> Add User</button>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            @if(count($users))
                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Address/Contact</th>
                            <th>Username</th>
                            <th>Assignment</th>
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
                                <td class="text-bold text-warning">
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

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            @else
                <div class="alert alert-warning">
                    <p class="text-warning"><strong><i class="fa fa-warning fa-lg"></i> No data found! </strong></p>
                </div>
            @endif
        </div>
    </div>
    @include('sidebar')
    @include('client.userModal')
@endsection

@section('js')
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

@if($status=='deleted')
    <script>
        Lobibox.notify('success', {
            msg: 'Deleted successfully!'
        });
    </script>
@endif

@if($status=='duplicate2')
    <script>
        Lobibox.notify('error', {
            msg: 'Ooops! Username was already taken.'
        });
    </script>
@endif
    <script>
        $('.filterProvince').on('change',function(){
            var id = $(this).val();
            filterProvince(id);
        });

        $('.userInfo').on('click',function(){
            $('.loading').show();
            var id = $(this).data('id');
            <?php echo 'var url = "'.asset('user/info/').'";';?>
            $('.loading').show();
            $.ajax({
                url: url+'/'+id,
                type: 'GET',
                success: function(dataJim) {
                    var data = dataJim.info;
                    $('#currentID').val(id);

                    $(".user_priv").empty();
                    if(data.user_priv == 2){
                        $(".user_priv").append(new Option("NDP", 2));
                        $(".user_priv").append(new Option("BHERDS", 4));
                    } else {
                        $(".user_priv").append(new Option("BHERDS", 4));
                        $(".user_priv").append(new Option("NDP", 2));
                    } // just order in select user priv

                    $('#fname').val(data.fname);
                    $('#mname').val(data.mname);
                    $('#lname').val(data.lname);
                    $('#username').val(data.username);
                    $('#contact').val(data.contact);
                    $('#barangay').val(dataJim.brgy).trigger('change');

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
            <?php echo 'var url = "'.asset('location/muncity/').'";';?>

            $('.filterMuncity').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Select Municipal / City..."
                    }));

            console.log(url);
            if(id){
                $('.loading').show();
                $.ajax({
                    url: url+'/'+id,
                    type: 'GET',
                    success: function(data) {
                        var content = '';
                        jQuery.each(data, function(i,val){
                            content += '<option value="'+val.id+'">'+val.description+'</option>';
                        });
                        $('.filterMuncity').append(content);
                        setTimeout(function(){
                            $('.loading').hide();
                        },200);
                    }
                });
            }
        }
    </script>
@endsection