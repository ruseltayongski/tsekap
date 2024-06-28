@extends('resu/app1')
@section('content')

<div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header"><i class="fa fa-home"></i> Home</h2>
            <div class="page-divider"></div>
            <div class="col-sm-6 col-xs-12">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3 class="countBarangay"><i class="fa fa-refresh fa-spin"></i></h3>
                        <p>No. of Barangay</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <a href="{{ asset('#') }}" class="small-box-footer">&nbsp;</a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 class="countNotUpdated"><i class="fa fa-refresh fa-spin"></i></h3>
                        <p>No. of Profiles NOT UPDATED</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="{{ asset('#') }}" class="small-box-footer">&nbsp;</a>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-sm-6 col-xs-12">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 class="target_2022"><i class="fa fa-refresh fa-spin"></i></h3>
                        <p>Target Population (2022)</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-line-chart"></i>
                    </div>
                    <a href="{{ asset('#') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    {{--<a href="{{ asset('#') }}" class="small-box-footer">--}}
                        {{--Target Poor ( <font class="old_target"><i class="fa fa-refresh fa-spin"></i></font> )--}}
                    {{--</a>--}}
                </div>
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="countPopulation_2022"><i class="fa fa-refresh fa-spin"></i></h3>
                        <p>Population Profiled (2022)</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="small-box-footer" style="text-align: left">&emsp;
                        <span class="profilePercentage_2022"><i class="fa fa-refresh fa-spin"></i></span>% Goal Completion
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">TARGET POPULATION (2018)</span>
                        <span class="info-box-number target_2018"><i class="fa fa-refresh fa-spin"></i></span>
                    </div><!-- /.info-box-content -->
                </div>
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">POPULATION PROFILED (2018)</span>
                        <span class="info-box-number countPopulation_2018"><i class="fa fa-refresh fa-spin"></i></span>
                        <div class="progress">
                            <div class="progress-bar profilePercentageBar_2018"></div>
                        </div>
                        <span class="progress-description">
                    <span class="profilePercentage_2018"><i class="fa fa-refresh fa-spin"></i></span>% Goal Completion
                  </span>
                    </div><!-- /.info-box-content -->
                </div>
            </div>

            {{--<div class="col-sm-6 col-xs-12">--}}
                {{--<div class="info-box bg-green">--}}
                    {{--<span class="info-box-icon"><i class="fa fa-stethoscope"></i></span>--}}
                    {{--<div class="info-box-content">--}}
                        {{--<span class="info-box-text">Availed 3 MUST Services</span>--}}
                        {{--<span class="info-box-number validServices"><i class="fa fa-refresh fa-spin"></i></span>--}}
                        {{--<div class="progress">--}}
                            {{--<div class="progress-bar servicePercentageBar"></div>--}}
                        {{--</div>--}}
                  {{--<span class="progress-description">--}}
                    {{--<span class="servicePercentage"><i class="fa fa-refresh fa-spin"></i></span>% Goal Completion--}}
                  {{--</span>--}}
                    {{--</div><!-- /.info-box-content -->--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="clearfix"></div>
            <h3 class="page-header">Monthly
                <small>Progress</small>
            </h3>
            <canvas id="montlyProgress" width="400" height="200"></canvas>
        </div>
    </div>
    @include('sidebar')
@endsection