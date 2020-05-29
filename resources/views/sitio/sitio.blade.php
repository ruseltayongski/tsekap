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
            <h2 class="page-header">Manage Sitio</h2>

            <div class="row">
                <div class="col-md-8">
                    <form class="form-inline" method="POST" action="{{ asset('sitio') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Quick Search" name="sitio_keyword" value="{{ Session::get('sitio_keyword') }}" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-primary" onclick="addSitio()"><i class="fa fa-plus"></i> Add Sitio</a>
                            <div class="clearfix"></div>
                        </div>
                        @if(Session::get('sitio_keyword'))
                            <div class="form-group">
                                <button type="submit" name="view_all" value="true" class="btn btn-warning"><i class="fa fa-eye"></i> View All</button>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="table-responsive">
                @if(count($sitio))
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
                        @foreach($sitio as $row)
                            <tr>
                                <td><a href="#" class="title-info" onclick="editSitio({{ $row->sitio_id }})">{{ $row->sitio_name }}</a></td>
                                <td>{{ $row->created_by }}</td>
                                <td>{{ $row->barangay }}</td>
                                <td>{{ $row->sitio_target }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $sitio->links() }}
                    </div>
                @else
                    <div class="alert alert-warning">
                        <p class="text-warning"><i class="fa fa-info-circle fa-lg text-bold"></i> No data found!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_sitio" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Sitio</h5>
                </div>
                <div class="sitio_content"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="remove_sitio" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form action="{{ asset('sitio/remove') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-trash"></i></h5>
                    </div>
                    <div class="alert alert-danger">
                        <label class="text-red">Are you sure you want to remove this sitio?</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-sm btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn-sm btn-danger sitio_id" name="sitio_id">Yes</button>
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
                msg: 'Deleted sitio!'
            });
        </script>
    @endif

    <script>
        function addSitio(){
            $('#add_sitio').modal({backdrop: 'static', keyboard: false});
            $(".sitio_content").html(loadingState);

            setTimeout(function(){
                var url = "<?php echo asset('sitio/add/content'); ?>";
                $.get(url,function(result){
                    $(".sitio_content").html(result);
                });
            },200);
        }

        function editSitio($sitio_id){
            event.preventDefault();
            $('#add_sitio').modal({backdrop: 'static', keyboard: false});
            $(".sitio_content").html(loadingState);

            setTimeout(function(){
                var url = "<?php echo asset('sitio/add/content'); ?>";
                var json = {
                    "sitio_id" : $sitio_id
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
                        $(".sitio_content").html(result);
                    }
                });
            },200);
        }

        function removeSitio($sitio_id){
            event.preventDefault();
            $('#remove_sitio').modal({backdrop: 'static', keyboard: false});
            $('.sitio_id').val($sitio_id);
        }
    </script>
@endsection