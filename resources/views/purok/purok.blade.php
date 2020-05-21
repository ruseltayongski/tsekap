<?php
use App\Http\Controllers\ParameterCtrl as Param;
use App\FamilyProfile;
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
        .cursor{
            cursor: pointer;
        }
    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Manage Purok</h2>

            <div class="row">
                <div class="col-md-8">
                    <form class="form-inline" method="POST" action="{{ asset('purok') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <?php $tmp = Session::get('profileKeyword');?>
                            <input type="text" class="form-control" placeholder="Quick Search" name="keyword" value="{{ $tmp['keyword'] }}" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-info col-xs-12" onclick="addPurok()"><i class="fa fa-user-plus"></i> Add Purok</a>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="table-responsive">
                @if(count($purok))
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created By</th>
                            <th>Barangay</th>
                            <th>Purok Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($purok as $row)
                            <tr>
                                <td><a href="#" class="title-info" onclick="editPurok({{ $row->purok_id }})">{{ $row->purok_name }}</a></td>
                                <td>{{ $row->created_by }}</td>
                                <td>{{ $row->barangay }}</td>
                                <td>{{ $row->purok_target }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        <p class="text-info"><i class="fa fa-info-circle fa-lg text-bold"></i> No data found!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_purok" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Purok</h5>
                </div>
                <div class="purok_content"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="remove_purok" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form action="{{ asset('purok/remove') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-trash"></i></h5>
                    </div>
                    <div class="alert alert-danger">
                        <label class="text-red">Are you sure you want to remove this purok?</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-sm btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn-sm btn-danger purok_id" name="purok_id">Yes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    @if(Session::get('add'))
        <script>
            <?php Session::put('add',false); ?>
            Lobibox.notify('success', {
                size: 'mini',
                title: '',
                msg: 'Successfully Saved!'
            });
        </script>
    @endif
    @if(Session::get('remove'))
        <script>
            <?php Session::put('remove',false); ?>
            Lobibox.notify('error', {
                size: 'mini',
                title: '',
                msg: 'Deleted purok!'
            });
        </script>
    @endif

    <script>
        function addPurok(){
            $('#add_purok').modal({backdrop: 'static', keyboard: false});
            $(".purok_content").html(loadingState);

            setTimeout(function(){
                var url = "<?php echo asset('purok/add/content'); ?>";
                $.get(url,function(result){
                    $(".purok_content").html(result);
                });
            },200);
        }

        function editPurok($purok_id){
            event.preventDefault();
            $('#add_purok').modal({backdrop: 'static', keyboard: false});
            $(".purok_content").html(loadingState);

            setTimeout(function(){
                var url = "<?php echo asset('purok/add/content'); ?>";
                var json = {
                    "purok_id" : $purok_id
                };
                $.ajaxSetup(
                    {
                        headers:
                            {
                                'X-CSRF-Token': "<?php echo csrf_token(); ?>"
                            }
                    });
                $.ajax({
                    url:url,
                    data: json,
                    type: 'POST',
                    success: function(result) {
                        $(".purok_content").html(result);
                    }
                });
            },200);
        }

        function removePurok($purok_id){
            event.preventDefault();
            $('#remove_purok').modal({backdrop: 'static', keyboard: false});
            $('.purok_id').val($purok_id);
        }
    </script>
@endsection