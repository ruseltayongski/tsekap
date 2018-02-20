<?php
    use App\BracketServices;
    use App\Service;
?>
@extends('app')

@section('content')
    <style>
        .alert-warning {
            color:#000 !important;
        }
    </style>
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Age Bracket
                <small></small>
            </h3>
            <form class="form-inline" method="POST" action="{{ asset('bracket') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Quick Search" name="keyword" value="{{ Session::get('bracketKeyword') }}" autofocus>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success col-xs-12" data-toggle="modal" data-target="#assignService"><i class="fa fa-stethoscope"></i> Assign Services</button>
                    <div class="clearfix"></div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            @if(count($brackets))
                @foreach($brackets as $row)
                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                    <?php $services = BracketServices::where('bracket_id',$row->id)->get(); ?>
                        <tr>
                            <th colspan="4" class="bg-success text-bold text-success text-uppercase" style="padding: 15px 10px;">{{ $row->description }}</th>
                        </tr>
                        @if(count($services) > 0)
                        <tr>
                            <th class="col-sm-5">Services</th>
                            <th class="col-sm-3">Male</th>
                            <th class="col-sm-3">Female</th>
                            <th></th>
                        </tr>
                        @foreach($services as $s)
                        <tr>
                            <td>{{ Service::find($s->service_id)->description }}</td>
                            <td>0 Profile</td>
                            <td>0 Profile</td>
                            <td nowrap="true">
                                <a href="{{ asset('bracket/remove/'.$s->id) }}" class="btn btn-xs btn-danger">
                                    <i class="fa fa-trash"></i> Remove
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="bg-warning text-bold text-uppercase">TOTAL</td>
                            <td class="bg-warning text-bold text-uppercase">0</td>
                            <td class="bg-warning text-bold text-uppercase">0</td>
                            <td class="bg-warning text-bold text-uppercase"></td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="alert alert-warning">
                                    <i class="fa fa-warning"></i> No Services under this bracket!
                                </div>
                            </td>
                        </tr>
                        @endif

                    </table>
                </div>
                {{ $brackets->links() }}
                @endforeach
            @else
                <div class="alert alert-warning">
                    <strong><i class="fa fa-warning fa-lg"></i> No age bracket found! </strong>
                </div>
            @endif
        </div>
    </div>
    @include('sidebar')
    @include('bracket.modal')
@endsection

@section('js')
    <?php
        $status = session('status');
    ?>
    @if($status == 'added')
    <script>
        Lobibox.notify('success', {
            msg: 'Added successfully!'
        });
    </script>
    @endif

    @if($status == 'duplicate')
        <script>
            Lobibox.notify('error', {
                msg: 'Duplicate Record!'
            });
        </script>
    @endif

    @if($status == 'deleted')
        <script>
            Lobibox.notify('info', {
                msg: 'Removed successfully!'
            });
        </script>
    @endif

    <script>
        $('.btn-submit').on('click',function(){
            var a = $('select[name="bracket"]').val();
            var b = $('select[name="services"]').val();

            if(!a){
                $('select[name="bracket"]').siblings('.chosen-container').css({border:'2px solid red'});
            }else{
                $('select[name="bracket"]').siblings('.chosen-container').css({border:'none'});
            }
            if(!b){
                $('select[name="services"]').siblings('.chosen-container').css({border:'2px solid red'});
            }else{
                $('select[name="services"]').siblings('.chosen-container').css({border:'none'});
            }
        });
    </script>
@endsection