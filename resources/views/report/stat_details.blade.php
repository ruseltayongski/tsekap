<?php
use App\Barangay;
use App\Muncity;
use App\Http\Controllers\ReportCtrl as Report;
use App\Http\Controllers\TargetCtrl as Target;
use App\UserBrgy;
use App\User;
use App\Profile;

$user = Auth::user();
$total_target = $total_profiled = 0;
if(isset($bar_id) && $bar_id != '' && $bar_id != 0) {
    $brgy = Barangay::where('id', $bar_id)->get();
} else {
    $brgy = Barangay::where('muncity_id',$muncity)->get();
    $muncitytotal = Target::getMuncityTotal($muncity,$year);
    $total_target = $muncitytotal['mun_target'];
    $total_profiled = $muncitytotal['mun_profiled'];
}
$total_percentage = ($total_target > 0) ? ($total_profiled / $total_target) * 100 : 0;
$total_percentage = number_format($total_percentage, 1);
?>
<style>
    .table thead tr th {
        font-weight: bold;
    }
</style>
<div class="modal-header" style="background-color: #2d92a1">
    <span style="font-size: 14pt;">{{ Muncity::find($muncity)->description }} Status Report (Per Barangay)</span>
    @if(count($brgy) > 1)
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <span class="" style="font-size: 14px;">
            <b>(TOTAL)</b>&nbsp;&nbsp; Target: {{ number_format($total_target) }}&emsp;&emsp;Profiled: {{ number_format($total_profiled) }}
        </span>
    @endif
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<div class="modal-body">
    @if(count($brgy))
        <div class="table-responsive">
            <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                <thead>
                <tr>
                    <th class="text-center">Barangay</th>
                    <th class="text-center">NDP Assigned</th>
                    <th class="text-center">Target</th>
                    <th class="text-center">Profiled</th>
                    <th class="text-center">Percentage</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brgy as $row)
                    <tr>
                        <td class="title-info">
                            {{ $row->description }}
                        </td>
                        <td>
                            <?php
                            $userBrgy = UserBrgy::where('barangay_id',$row->id)->get();
                            $c = 0;
                            ?>
                            @foreach($userBrgy as $tmp)
                                <?php
                                $usertmp = User::where('id',$tmp->user_id)->first();
                                ?>
                                @if($usertmp)
                                    {{ $usertmp->fname }} {{ $usertmp->mname }} {{ $usertmp->lname }}
                                    <br />
                                    <small class="text-warning">({{$usertmp->contact}})</small>
                                    @if($c<count($userBrgy))
                                        <br />
                                        <?php $c++; ?>
                                    @endif
                                @endif

                            @endforeach

                        </td>
                        <td class="text-center">
                            <?php
                            $profile = Report::getProfile('brgy',$row->id);
                            $target = ($year == '2022') ? $row->target_2022 : $row->target;
                            $profilePercentage = ($target > 0 && $profile > 0) ? ($profile / $target) * 100 : 0;

                            $a = $profilePercentage;
                            if($a>=0 && $a<=20){
                                $class = 'danger';
                            }else if($a>20 && $a<=40){
                                $class = 'warning';
                            }else if($a>40 && $a<=60){
                                $class = 'info';
                            }else if($a>60 && $a<=80){
                                $class = 'success';
                            }else if($a>80){
                                $class = 'teal';
                            }
                            ?>
                            {{ number_format($target) }}
                        </td>
                        <td class="text-center">
                            {{ number_format($profile) }}
                        </td>
                        <td class="bg-{{$class}} text-center">{{ number_format($profilePercentage,1) }}%</td>
                        <td class="text-center">
                            <a class="btn-primary btn btn-sm" href="{{ asset('generatedownload/barangay') }}/{{ $row->id }}/{{ $muncity }}/{{ $year }}" method="POST">
                                <i class="fa fa-download"></i> Download
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

                @if(count($brgy) > 1)
                <tfoot style="background-color: lightgoldenrodyellow">
                    <tr>
                        <th><b>TOTAL:</b></th>
                        <th></th>
                        <th class="text-center">{{ number_format($total_target) }}</th>
                        <th class="text-center">{{ number_format($total_profiled) }}</th>
                        <th class="text-center">{{ $total_percentage }} %</th>
                        <th></th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    @else
        <div class="alert alert-warning">
            <p class="text-warning"><strong><i class="fa fa-warning fa-lg"></i> No data found! </strong></p>
        </div>
    @endif
</div>
<div class="modal-footer">
    <button title="Close" type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
