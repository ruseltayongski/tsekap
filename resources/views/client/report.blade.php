<?php
use App\Profile;
use App\Service;
use App\Barangay;
use App\Http\Controllers\ParameterCtrl;
?>
@extends('client')
@section('content')
    @include('sidebarfilter')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <div class="result pull-right text-bold text-right">
                <?php
                    $from = ParameterCtrl::getMonthName($monthF);
                    $to = ParameterCtrl::getMonthName($monthT);

                    if($from==='None' && $to==='None')
                    {
                        $from = 'January';
                        $to = 'December';
                        $year = date('Y');
                    }
                ?>
                <div class="text-info">Date: {{ $from }} - {{ $to }} {{ $year }}</div>
                <div class=" text-success">Result: {{ $total }}</div>
            </div>
            <h2 class="page-header">Services Availed</h2>
            <div class="clearfix"></div>
            @if(count($profiles))
            <div class="table-responsive">
                <table class="table table-striped talble-hover">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Age</th>
                            <th>Service Availed</th>
                            <th>Barangay</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $holder = '';?>
                        @foreach($profiles as $p)
                        <tr>
                            <td class="text-bold text-success">
                                <?php $user = Profile::where('unique_id',$p->profile_id)->first(); ?>
                                @if($holder!=$p->profile_id)
                                <?php
                                    $user = Profile::where('unique_id',$p->profile_id)->first();
                                ?>
                                {{ $user->lname }}, {{ $user->fname }} {{ $user->mname }} {{ $user->suffix }}
                                @else
                                    <?php $holder=$p->profile_id; ?>
                                @endif
                            </td>
                            <td class="text-info">
                                @if($holder!=$p->profile_id)
                                {!!  ParameterCtrl::getStaticAge($user->dob,$p->dateProfile)  !!}
                                @endif
                            </td>
                            <td class="text-info">{{ Service::find($p->service_id)->description }}</td>
                            <td class="text-info">
                                @if($holder!=$p->profile_id)
                                    <?php $holder = $p->profile_id; ?>
                                    {{ Barangay::find($p->barangay_id)->description }}
                                @endif
                            </td>
                            <td class="text-info">{{ date('M d, Y',strtotime($p->dateProfile)) }}</td>
                            <td><a href="#remove" data-toggle="modal" data-year="{{ date('Y',strtotime($p->dateProfile)) }}" data-id="{{ $p->id }}" class="text-danger"><i class="fa fa-times"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $profiles->links() }}
            </div>
            @else
            <div class="alert alert-warning">
                <p class="text-warning"><i class="fa fa-warning"></i> No data!</p>
            </div>
            @endif
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="remove">
        <div class="modal-dialog modal-sm" role="document">
            <form method="POST" action="{{ asset('user/report/delete') }}">
                {{ csrf_field() }}
                <div class="modal-content">
                    <input type="hidden" name="currentID" id="currentID" />
                    <input type="hidden" name="year" id="year" />
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <p class="text-danger">Are you sure you want to delete this record?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        <button type="submit" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i> Yes</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('js')
<?php
$status = session('status');
?>
@if($status=='deleted')
    <script>
        Lobibox.notify('success', {
            msg: 'Removed successfully!'
        });
    </script>
@endif
<script>
    $('#reservation').daterangepicker();

    $('a[href="#remove"]').on('click',function(){
        var id = $(this).data('id');
        var year = $(this).data('year');
        $('#year').val(year);
        $('#currentID').val(id);
    });

    $('.monthF').change(function(){
        var c = $(this).val();
        for(i=1;i<c;i++)
        {
            $('.monthT').find('option[value='+i+']').hide();
        }
        $('.monthT').val(c);
        for(c;c<=12;c++)
        {
            $('.monthT').find('option[value='+c+']').show();
        }
    });
</script>
@endsection