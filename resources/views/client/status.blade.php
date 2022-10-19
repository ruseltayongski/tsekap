<?php
    use App\Http\Controllers\ReportCtrl as Report;
    use App\UserBrgy;
    use App\User;
?>

@extends('client')
@section('content')
    <style>
        .table thead tr th {
            font-weight: bold;
        }
    </style>
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <div class="row">
                <div class="col-md-7">
                    <h3>
                        <i class="fa fa-line-chart"></i> Status Report ({{ $year }})<br>
                        <span style="font-size: 14px;" id="total">
                            @if(count($brgy) > 1)
                                <b>TARGET (TOTAL): </b>&nbsp;&nbsp; {{ number_format($total_target) }}&emsp;&emsp;<b>PROFILED (TOTAL):</b> {{ number_format($total_profiled) }}
                            @endif
                        </span>
                    </h3>
                </div>
                <div class="col-md-5">
                    <form method="get" action="{{ asset('/user/report/status') }}"><br>
                        <select class="form-control select2" name="select_year" id="select_year" style="width:75%;">
                            <option>Select year...</option>
                            <option value="2018">2018</option>
                            <option value="2022">2022</option>
                        </select>&nbsp;
                        <button type="submit" class="btn btn-info btn-sm btn-flat"><i class="fa fa-filter"></i> Filter</button>
                    </form>
                </div>
            </div><br>
            <div class="row">
                @if(count($brgy))
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                            <thead>
                            <tr>
                                <th>Barangay</th>
                                <th>NDP Assigned</th>
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
                                        {{ ($year == '2018') ? number_format($row->target) : number_format($row->target_2022) }}
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $profile = Report::getProfile('brgy',$row->id);
                                        $target = ($year == '2018') ? $row->target : $row->target_2022;
                                        if($target==0){
                                            $target=$profile;
                                        }

                                        if($profile==0){
                                            $profilePercentage = 0;
                                        }else{
                                            $profilePercentage = ($target > 0) ? ($profile / $target) * 100 : 0;
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
                                            $class = 'aqua';
                                        }
                                        ?>
                                        {{ number_format($profile) }}
                                    </td>
                                    <td class="bg-{{$class}} text-center">{{ number_format($profilePercentage,1) }}%</td>
                                    <td class="text-center">
                                        <a class="btn-primary btn" href="{{ asset('generatedownload/barangay') }}/{{ $row->id  }}/{{ Auth::user()->muncity}}/{{ $year }}" method="POST">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            @if(count($brgy) > 1)
                                <tfoot style="background-color: lightgoldenrodyellow">
                                <tr>
                                    <td><b>TOTAL:</b></td>
                                    <td></td>
                                    <td class="text-center">{{ number_format($total_target) }}</td>
                                    <td class="text-center">{{ number_format($total_profiled) }}</td>
                                    <?php $total_percentage = ($total_target > 0) ? ($total_profiled / $total_target) * 100 : 0;?>
                                    <td class="text-center">{{ number_format($total_percentage) }} %</td>
                                    <td></td>
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
        </div>
    </div>
    @include('sidebar')
@endsection

@section('js')

@endsection