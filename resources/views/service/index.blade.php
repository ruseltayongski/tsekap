@extends('app')
@section('content')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Services</h2>
            <form class="form-inline" method="POST" action="{{ asset('services') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Quick Search" name="keyword" value="{{ Session::get('serviceKeyword') }}" autofocus>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success col-xs-12" data-toggle="modal" data-target="#addService"><i class="fa fa-plus"></i> Add Services</button>
                    <div class="clearfix"></div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="page-divider"></div>

            @if(count($services))
                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Code</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $row)
                            <tr>
                                <td>
                                    <a href="#serviceInfo" class="title-info serviceInfo" data-id="{{ $row->id }}" data-toggle="modal">
                                    {{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td>
                                    {{ $row->code }}
                                </td>
                                <td>{{ $row->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $services->links() }}
            @else
                <div class="alert alert-warning">
                    <font class="text-warning"><strong><i class="fa fa-warning fa-lg"></i> No services found! </strong></font>
                </div>
            @endif
        </div>
    </div>
    @include('sidebar')
    @include('service.modal')
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

    @if(isset($_GET['duplicate'])&&$_GET['duplicate']=='code')
        <script>
            Lobibox.notify('error', {
                msg: 'Code already taken!'
            });
        </script>
    @endif

    @if(isset($_GET['duplicate'])&&$_GET['duplicate']=='desc')
        <script>
            Lobibox.notify('error', {
                msg: 'Description already taken!'
            });
        </script>
    @endif

    <script>
        $('.serviceInfo').on('click',function(){
            $('.loading').show();
            var id = $(this).data('id');
            var url = 'service/info/'+id;
            $('.loading').show();
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#currentID').val(id);
                    $('#code').val(data.code);
                    $('#description').val(data.description);
                    setTimeout(function(){
                        $('.loading').hide();
                    },200);
                }
            });
        });

    </script>
@endsection