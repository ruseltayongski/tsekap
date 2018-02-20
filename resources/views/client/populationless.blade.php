<?php
use App\Http\Controllers\ParameterCtrl as Param;
use App\FamilyProfile;
use App\Profile;
?>
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
    <?php $tmp = Session::get('profileKeyword');?>
    <?php $year = isset($tmp['year']) ? $tmp['year'] : date('Y'); ?>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">3 Must Services Status
                <small class="pull-right">Year : {{ $year }}</small>
            </h2>

            <form class="form-inline" method="POST" action="{{ asset('user/population/less') }}">
                {{ csrf_field() }}

                <div class="form-group">
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
                    <a class="btn btn-success col-xs-12" href="#filterResultLess" data-toggle="modal"><i class="fa fa-filter"></i> Filter Result</a>
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
                            <th>Services Availed</th>
                            <th>Family ID</th>
                            <th>Complete Name</th>
                            <th>Barangay</th>
                            <th>Physical<br/>Examination</th>
                            <th>Laboratory<br/>Services</th>
                            <th>Other<br/>Services</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profiles as $row)
                            <tr>
                                <td>
                                    <a href="#showServices" data-backdrop="static" data-toggle="modal" data-id="{{ $row->profile_id }}" class="text-success">
                                        <?php $count = Param::countServicesAvailed($row->profile_id,$year); ?>
                                        <i class="fa fa-stethoscope"></i> {{ $count }} Service<?php if($count>1) echo 's'; ?> Availed
                                    </a>
                                </td>
                                <?php $user = Profile::where('unique_id',$row->profile_id)->first(); ?>
                                <td>
                                    <a href="#familyProfile" data-backdrop="static" data-id="{{ $user->familyID }}" data-toggle="modal" class="title-info">
                                        {{ $user->familyID }}
                                    </a>
                                </td>
                                <td class="text-bold text-success">
                                    <a href="{{ asset('user/population/info/'.$user->id) }}" target="_blank">
                                        {{ $user->fname }} {{ $user->mname }} {{ $user->lname }}  {{ $user->suffix }}<br />
                                        <?php $class = ($user->head==='YES') ? 'text-success' : 'text-danger'; ?>
                                        <small class="{{ $class }}"><em>( {{ $user->sex }},
                                                {{ ($user->head==='YES') ? 'HEAD' : 'Member' }}
                                                )</em></small>
                                    </a>
                                </td>
                                <td>
                                    {{ App\Barangay::find($row->barangay_id)->description }}
                                </td>
                                <?php
                                $yes = 'fa fa-check text-success';
                                $no = 'fa fa-times text-danger';
                                ?>
                                <td>
                                    <i class="{{ ($row->group1==1) ? $yes : $no }}"></i>
                                </td>
                                <td>
                                    <i class="{{ ($row->group2==1) ? $yes : $no }}"></i>
                                </td>
                                <td>
                                    <i class="{{ ($row->group3==1) ? $yes : $no }}"></i>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $profiles->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <p class="text-info"><i class="fa fa-info-circle fa-lg text-bold"></i> Profile not found!</p>
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

    @if($status=='duplicate')
        <script>
            Lobibox.notify('error', {
                msg: 'Duplicate Entry!'
            });
        </script>
    @endif

    <script>
        <?php echo 'var link="'.asset('user/profiles').'";';?>

        $('a[href="#addProfile"]').on('click',function(){
            $('#addProfile').modal('toggle');
            var id = $(this).data('id');
            var description = $(this).data('description');
            $('#familyID').val(id);
            $('#familyName').val(description);
        });

        $('a[href="#showServices"]').on('click',function(){
            <?php echo 'var year="'.$year.'";';?>
            <?php echo 'var url="'.asset('user/population/service').'";';?>
            <?php echo 'var less="'.asset('user/population/service/less').'";';?>

            var id = $(this).data('id');
            $('.service-list').html('<center><img src="<?php echo asset('resources/img/spin.gif');?>" width="100"></center>');
            $.ajax({
                url: url+'/'+id+'/'+year,
                type: 'GET',
                success: function(jim){
                    console.log(url+'/'+id+'/'+year);
                    var content = '<ul class="list-group">';
                    jQuery.each(jim,function(i,val){
                        content += '<li class="list-group-item text-warning">';
                        content += val.description;
                        content += '<br/><small class="text-italic text-info text-bold">('+val.dateProfile+')</small>';
                        content += '</li>';
                    });
                    content += '</ul>';
                    if(jim.length==0){
                        content = '<div class="alert alert-warning"><font class="text-warning"><i class="fa fa-warning"> No services availed!</font></div>';
                    }
                    $('.avail').attr("href",less+'/'+id);
                    $('.service-list').html(content);
                }
            });

        });


    </script>
@endsection