<?php
use App\Barangay;
use App\Profile;
use App\UserBrgy;

$user = Auth::user();
$total_target = $total_profiled = 0;

//if($user->user_priv == 2) {
//    $brgy = UserBrgy::select(
//        'barangay.id',
//        'barangay.description',
//        'barangay.province_id',
//        'barangay.muncity_id',
//        'barangay.target'
//    )
//        ->where('userbrgy.user_id',$user->id)
//        ->leftJoin('barangay','barangay.id','=','userbrgy.barangay_id')
//        ->get();
//    $total_target = $total_profiled = 0;
//    foreach($brgy as $bar) {
//        $total_target += Barangay::select(DB::raw("SUM(target) as target_count"))->where('id',$bar->id)->first()->target_count;
//        $total_profiled += Profile::where('barangay_id',$bar->id)->count();
//    }
//} else {
//    $total_target = Barangay::select(DB::raw("SUM(target) as target_count"));
//    if($year == 2018)
//        $total_target = $total_target->where('created_at','<','2022-01-01 00:00:00');
//    else
//        $total_target = $total_target->where('created_at','>=','2022-01-01 00:00:00');
//
//    $total_target = $total_target->where('muncity_id',$user->muncity)->first()->target_count;
//    $total_profiled = Profile::where('muncity_id',$user->muncity)->count();
//}
//$total_percentage = ($total_profiled / $total_target) * 100;
?>

@extends('client')
@section('content')
    <div class="container">
        <div class="col-md-12" style="padding-top: 10px; padding-left: 35px; padding-right: 35px">
        <span> <b style="font-size: 20px">TARGET POPULATION ({{ $year }})</b>
            <div class="pull-right">
                <form action="{{ asset('population/target') }}" method="POST" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom: 10px;">
                        <input type="text" class="form-control" placeholder="Search..." name="keyword" value="{{ Session::get("targetKeyword") }}" >
                        <button type="submit" class="btn btn-success btn-flat">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-flat">
                            <i class="fa fa-eye"></i> View All
                        </button>
                    </div>
                </form>
            </div>
        </span>
        </div><br><br><br>

        <div class="container" style="padding: 10px;">
            <div class="table-responsive" style="background-color: whitesmoke; padding: 15px; width:100%;">
                <table class="table table-bordered table-striped table-fixed-header" style="width:100%;">
                    <thead class="header">
                    <tr class="bg-navy-active">
                        <th class="text-center" style="white-space: nowrap; vertical-align: middle; width:25%;"> Barangay </th>
                        <th class="text-center" style="white-space:nowrap; vertical-align: middle; width: 20%;"> Target </th>
                        <th class="text-center" style="white-space:nowrap; vertical-align: middle; width: 20%;"> Profiled </th>
                        <th class="text-center" style="white-space:nowrap; vertical-align: middle; width: 20%;"> Percentage </th>
                        @if($user_priv === 0 && $year == 2022)
                            <th class="text-center" style="vertical-align: middle; width:20%;"> Action </th>
                        @endif
                    </tr>
                    </thead>
                    @foreach($data as $row)
                        <tr>
                            <th class="text-info" style="font-size: 15px">
                                {{ $row->description }}
                            </th>
                            <td class="text-center" style="font-size: 15px">
                                <?php $total_target += $row->target?>
                                {{ number_format($row->target) }}
                            </td>
                            <td class="text-center" style="font-size: 15px">
                                <?php
                                  if($year == 2018)
                                      $profiled = Profile::where('barangay_id',$row->id)->where('created_at','<','2022-01-01 00:00:00')->count();
                                  else
                                      $profiled = Profile::where('barangay_id',$row->id)->where('updated_at','>=','2022-01-01 00:00:00')->count();
                                  $total_profiled += $profiled;
                                ?>
                                {{ number_format($profiled) }}
                            </td>
                            <td class="text-center text-info" style="font-size: 15px">
                                <?php
                                    if($row->target != 0)
                                        $percent = ($profiled / $row->target) * 100;
                                    else
                                        $percent = 0;
                                ?>
                                <b>{{ number_format($percent, 1) }} %</b>
                            </td>
                            @if($user_priv === 0 && $year == 2022)
                                <td class="text-center">
                                    <a href="#update_target" data-toggle="modal" class="btn btn-sm btn-success btn-flat" onclick="updateTarget('{{ $row->id }}', '{{ $row->description }}', '{{ $row->target }}')">
                                        <i class="fa fa-pencil-square-o"></i> Update
                                    </a>
                                    {{-- &emsp; &emsp; <a href="#delete_target" data-toggle="modal" class="btn btn-sm btn-danger btn-flat" onclick="deleteTarget('{{ $row->id }}', '{{ $row->description }}')">--}}
                                    {{--<i class="fa fa-trash"></i> Reset--}}
                                    {{--</a>--}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @if(count($data) > 1)
                        <tfoot>
                        <tr style="background-color: lightgoldenrodyellow">
                            <td><b>TOTAL:</b></td>
                            <td class="text-center">{{ number_format($total_target) }}</td>
                            <td class="text-center">{{ number_format($total_profiled) }}</td>
                            <?php $total_percentage = ($total_profiled / $total_target) * 100;?>
                            <td class="text-center">{{ number_format($total_percentage, 1) }} %</td>
                            @if($user_priv === 0 && $year == 2022)
                                <td></td>
                            @endif
                        </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    @include('target.target_modal')
@endsection

@section('js')
    <script>
        $('.table-fixed-header').fixedHeader();

        function updateTarget(id, description, target){
            $('#barangay_id').val(id);
            $('#barangay_name').val(description);
            target = target.replace(/[^0-9]/g, '').replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            $('#target_count').val(target);
        }

        /*  ______________________
        *   |    RESET TARGET    |
        *   ----------------------
        */
        function deleteTarget(id, description) {
            $("#id_delete").val(id);
            $("#bar_desc_delete").html(description);
        }

        /*  _________________________
        *   |  NOTIFICATION MESSAGE |
        *   -------------------------
        */
        @if(Session::get('target_notif'))
        Lobibox.notify('success', {
            title: "",
            msg: "<?php echo Session::get("target_msg"); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
        Session::put("target_notif",false);
        Session::put("target_msg",false)
        ?>
        @endif
    </script>
@endsection