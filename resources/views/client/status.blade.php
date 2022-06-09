<?php
    use App\Barangay;
    use App\Http\Controllers\ReportCtrl as Report;
    use App\UserBrgy;
    use App\User;

    $user = Auth::user();
    $brgy = Barangay::where('muncity_id',$user->muncity)->get();
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
            <h2 class="page-header">
                <i class="fa fa-line-chart"></i> Status Report
            </h2>
            @if(count($brgy))
            <div class="table-responsive">
                <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                    <thead>
                    <tr>
                        <th>Barangay</th>
                        <th>NDP Assigned</th>
                        <th>Target</th>
                        <th>Profiled</th>
                        <th>Percentage</th>
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
                            <td>
                                {{ number_format($row->target) }}
                            </td>
                            <td>
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
                                        $class = 'aqua';
                                    }
                                ?>
                                {{ number_format($profile) }}
                            </td>
                            <td class="bg-{{$class}}">{{ number_format($profilePercentage,1) }}%</td>
                            <td class="text-center">
                                <a class="btn-primary btn" href="{{ asset('generatedownload/barangay') }}/{{ $row->id  }}/{{ Auth::user()->muncity}}" method="POST">
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
    </div>
    @include('sidebar')
@endsection

@section('js')

@endsection