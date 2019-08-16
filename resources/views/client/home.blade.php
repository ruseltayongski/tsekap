@extends('client')
@section('content')
    @if(!Session::get('featuress'))
        <?php Session::put('features',true); ?>
        <style>

        </style>
        <div class="modal fade" tabindex="-1" role="dialog" id="notificationModal" style="margin-top: 30px;z-index: 99999 ">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                        <h3 style="font-weight: bold" class="text-success">WHAT'S NEW?</h3>
                        <?php
                        $dateNow = date('Y-m-d');
                        ?>
                        @if($dateNow==='2019-07-16')
                            <div class="alert alert-info">
                                <p class="text-info" style="font-size:1.3em;text-align: center;">
                                    <strong>There will be a server maintenance TODAY (July 16, 2019) at 4:00PM to 04:30PM. Server optimization!</strong>
                                </p>
                            </div>
                        @endif

                        @if($dateNow >= '2019-07-19' && $dateNow <= '2019-07-29')
                            <div class="alert alert-info">
                                <p class="text-info" style="font-size:1.1em;">
                                    <strong><i class="fa fa-info"></i> Version 2.1 was successfully launch</strong>
                                <ol type="I" style="color: #31708f">
                                    <li>Adittional field include</li>
                                    <ul >
                                        <li>Hypertension</li>
                                        <li>Diabetic</li>
                                        <li>PWD</li>
                                        <li>Pregnant</li>
                                    </ul>
                                    <li>Profile accomplishment per barangay</li>
                                </ol>
                                </p>
                            </div>
                        @endif
                        <div class="alert alert-success ">
                            <p class="text-success">
                                <i class="fa fa-phone-square"></i> For further assistance, please message these following:
                            <ol type="I" style="color: #2f8030">
                                <li>Technical</li>
                                <ol type="A">
                                    <li >Web</li>
                                    <ul>
                                        <li>Rusel T. Tayong - 09238309990</li>
                                    </ul>
                                    <li >Mobile App</li>
                                    <ul>
                                        <li>Christian Dave L. Tipactipac - 09286039028</li>
                                    </ul>
                                    <li >Server - Can't access in web http://203.177.67.124/tsekap/vii/login</li>
                                    <ul>
                                        <li>Garizaldy B. Epistola - 09338161374</li>
                                        <li>Reyan M. Sugabo - 09359504269</li>
                                        <li>Gerwin D. Gorosin - 09436467174 or 09154512989</li>
                                    </ul>
                                </ol>
                                <li>Non - Technical</li>
                                <ol type="A">
                                    <li >Update barangay assign, Create new user, update target population etc.</li>
                                    <ul>
                                        <li class="text-danger">Ronadith Capala Arriesgado - 09952100815 Please reach via message only</li>
                                        <li class="text-danger">Grace R. Flores - 09328596338 Please reach via message only</li>
                                    </ul>
                                </ol>
                            </ol>
                            <h3 class="text-center" style="color: #2f8030">Thank you and enjoy profiling! &#128512;&#128526;</h3>
                            </p>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">
                <form action="{{ asset('ExportExcelBarangay') }}" method="POST">
                    {{ csrf_field() }}
                    <i class="fa fa-home"></i>
                    Home
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i> Download Excel
                    </button>
                </form>
            </h2>
            <div class="col-md-12">

                @if(Auth::user()->user_priv == 2)
                    <p class="text-center">
                        <strong>Barangay Completion </strong>
                    </p>
                    <?php $profile_percent = 0; ?>
                    @foreach($barangay as $bar)
                        <div class="progress-group">
                            <span class="progress-text">{{ $bar->description }}</span>
                            <span class="progress-number"><b>{{ $profile_count = \App\Profile::where('barangay_id',$bar->id)->count() }}<?php $profile_percent = ($profile_count / $bar->target) * 100; ?></b>/{{ $bar->target }}</span>
                            <div class="progress sm">
                                <div class="progress-bar progress-bar-aqua" style="width: {{ number_format((float)$profile_percent, 0, '.', '') }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            <!-- /.progress-group -->
            </div>
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
                    <a href="{{ asset('user/population') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
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
                    <a href="{{ asset('user/population') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
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
        <?php echo 'var url = "'.asset('user/home/count').'";';?>
        $.ajax({
            url: url,
            type: 'GET',
            success: function(jim) {
                console.log(jim);
                $('.countBarangay').html(jim.countBarangay);
                $('.target').html(jim.target);
                $('.countPopulation').html(jim.countPopulation);
                $('.validServices').html(jim.validServices);
                $('.profilePercentage').html(jim.profilePercentage);
                $('.servicePercentage').html(jim.servicePercentage);
                $('.profilePercentageBar').css({ width: jim.profilePercentage+'%' })
                $('.servicePercentageBar').css({ width: jim.servicePercentage+'%' })
            }
        });
            <?php echo 'var url = "'.asset('user/home/chart').'";';?>
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
        $('#notificationModal').modal('show');
    </script>
@endsection