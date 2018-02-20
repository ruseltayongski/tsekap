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
                            $dateNow = date('m-d-Y');
                        ?>
                        @if($dateNow==='10-11-2017')
                        <div class="alert alert-info">
                            <p class="text-info" style="font-size:1.3em;text-align: center;">
                                <strong>There will be a server maintenance tomorrow (October 12, 2017), 9:00AM. Don't forget to backup your data. Thank you!</strong>
                            </p>
                        </div>
                        @endif
                        <table class="table table-hover hide">
                            <tr class="bg-warning">
                                <td class="text-info" nowrap="true">
                                    1. Uploading of data is now available!
                                </td>
                            </tr>
                        </table>
                        <div class="alert alert-info">
                            <p class="text-info" style="font-size:1.1em;text-align: center;">
                                <strong>DOWNLOADING and UPLOADING of DATA is now AVAILABLE!</strong>
                            </p>
                        </div>
                        <div class="alert alert-success text-center">
                            <p class="text-success">
                            For further assistance, please contact <i class="fa fa-phone-square"></i> 418-7633 or 418-4822.<br /> or chat with us <i class="fa fa-facebook-square"></i>
                            <a href="https://facebook.com/jimmy0923" target="_blank">@Jimmy0923</a> and <a href="https://facebook.com/ronadit.capala" target="_blank">@ronadit.capala</a>
                            <br />
                            Thank you!
                            </p>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif
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
    $('#notificationModal').modal('show');
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
</script>
@endsection