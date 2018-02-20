<?php

?>

@extends('app')
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
                    <a href="{{ asset('#') }}" class="small-box-footer">
                        &nbsp;
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 class="target"><i class="fa fa-refresh fa-spin"></i></h3>
                        <p>Target Population</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{ asset('#') }}" class="small-box-footer">
                        &nbsp;
                    </a>
                </div>
            </div>

            <div class="clearfix"></div>
            <hr />
            <div class="col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Population Profiled</span>
                        <span class="info-box-number countPopulation"><i class="fa fa-refresh fa-spin"></i></span>
                        <div class="progress">
                            <div class="progress-bar profilePercentageBar"></div>
                        </div>
                  <span class="progress-description">
                    <span class="profilePercentage"><i class="fa fa-refresh fa-spin"></i></span>% Goal Completion
                  </span>
                    </div><!-- /.info-box-content -->
                </div>
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-stethoscope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Availed 3 MUST Services</span>
                        <span class="info-box-number validServices"><i class="fa fa-refresh fa-spin"></i></span>
                        <div class="progress">
                            <div class="progress-bar servicePercentageBar"></div>
                        </div>
                  <span class="progress-description">
                    <span class="servicePercentage"><i class="fa fa-refresh fa-spin"></i></span>% Goal Completion
                  </span>
                    </div><!-- /.info-box-content -->
                </div>
            </div>
            <div class="clearfix"></div>
            <h3 class="page-header">Monthly
                <small>Progress</small>
            </h3>
            <canvas id="montlyProgress" width="400" height="200"></canvas>
        </div>
    </div>
    @include('sidebar')
@endsection

@section('js')
    <script src="{{ asset('resources/plugin/Chart.js/Chart.min.js') }}"></script>

    <script>
        <?php echo 'var url = "'.asset('home/count/countBarangay').'";';?>
        $.ajax({
            url: url,
            type: 'GET',
            success: function(jim) {
                console.log(jim);
                $('.countBarangay').html(jim.countBarangay);
            }
        });

        <?php echo 'var url = "'.asset('home/count/target').'";';?>
        $.ajax({
            url: url,
            type: 'GET',
            success: function(jim) {
                console.log(jim);
                $('.target').html(jim.target);
                $('.countPopulation').html(jim.countPopulation);
                $('.profilePercentage').html(jim.profilePercentage);
                $('.profilePercentageBar').css({ width: jim.profilePercentage+'%' });
            }
        });


        <?php echo 'var url = "'.asset('home/count/validServices').'";';?>
        $.ajax({
            url: url,
            type: 'GET',
            success: function(jim) {
                console.log(jim);
                $('.validServices').html(jim.validServices);
                $('.servicePercentage').html(jim.servicePercentage);
                $('.servicePercentageBar').css({ width: jim.servicePercentage+'%' });
            }
        });

        <?php echo 'var url = "'.asset('home/chart').'";';?>
        var jim = [];
        $.ajax({
            url: url,
            type: 'GET',
            success: function(jim) {
                //jim = jQuery.parseJSON(data);
                //chart created docs
                var ctx = document.getElementById("montlyProgress");
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: jim.months,
                        datasets: [{
                            label: '',
                            data: jim.count,
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 206, 86, 1)',
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
                //end chart created docs
            }
        });
    </script>
@endsection