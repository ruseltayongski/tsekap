<?php
use App\Barangay;
use App\Muncity;
use App\Http\Controllers\ReportCtrl as Report;
use App\UserBrgy;
use App\User;

$user = Auth::user();
if(isset($bar_id) && $bar_id != '' && $bar_id != 0) {
    $brgy = Barangay::where('id', $bar_id)->get();
} else {
    $brgy = Barangay::where('muncity_id',$muncity)->get();
}

?>
<style>
    .table thead tr th {
        font-weight: bold;
    }
</style>
<div class="modal-header" style="background-color: #2d92a1">
    <span style="font-size: 14pt;">{{ Muncity::find($muncity)->description }} Status Report (Per Barangay)</span>
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
                            {{ number_format($row->target) }}
                        </td>
                        <td class="text-center">
                            <?php
                            $profile = Report::getProfile('brgy',$row->id);
                            $target = $row->target;
                            if($target==0){
                                $target=$profile;
                            }

                            if($profile==0){
                                $profilePercentage = 0;
                            }else{
                                $profilePercentage = ($profile / $target) * 100;
                            }

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
                            {{ number_format($profile) }}
                        </td>
                        <td class="bg-{{$class}} text-center">{{ number_format($profilePercentage,1) }}%</td>
                        <td class="text-center">
                            <a class="btn-primary btn btn-sm" href="{{ asset('generatedownload/barangay') }}/{{ $row->id }}/{{ $muncity }}" method="POST">
                                <i class="fa fa-download"></i> Download
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
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
