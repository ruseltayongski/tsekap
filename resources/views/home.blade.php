<?php

?>

<style>
    .chosen-search {
        color: black;
    }

    .icon {
        padding-top: 17px;
    }

    .info-box-icon {
        padding-top: 20px;
    }
</style>

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
                        Target Poor ( <font class="old_target"><i class="fa fa-refresh fa-spin"></i></font> )
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
            <hr />
            <div class="col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Population Profiled <br> (Per Municipality)</span>
                        <input type="hidden" id="tmpMuncity" value="{{ Session::get('homeMuncity') }}" />
                        <select name="muncity" class="filterMuncity form-control chosen-select-static">
                            <option value="">Select Municipal/City</option>
                        </select>
                        <span class="info-box-number countPopulationPerMuncity"><i class="fa fa-refresh fa-spin"></i></span>
                        <div class="progress">
                            <div class="progress-bar profilePercentageBarPerMuncity"></div>
                        </div>
                        <span class="progress-description">
                    <span class="profilePercentagePerMuncity"><i class="fa fa-refresh fa-spin"></i></span>% Goal Completion
                  </span>
                    </div><!-- /.info-box-content -->
                </div>
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Population Profiled <br> (Per Barangay)</span>
                        <input type="hidden" id="tmpBarangay" value="{{ Session::get('homeBarangay') }}" />
                        <select name="barangay" class="filterBarangay form-control chosen-select-static">
                            <option value="">Select Barangay</option>
                        </select>
                        <span class="info-box-number countPopulationPerBarangay"><i class="fa fa-refresh fa-spin"></i></span>
                        <div class="progress">
                            <div class="progress-bar profilePercentageBarPerBarangay"></div>
                        </div>
                        <span class="progress-description">
                    <span class="profilePercentagePerBarangay"><i class="fa fa-refresh fa-spin"></i></span>% Goal Completion
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
                $('.old_target').html(jim.old_target);
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

        prov_id = <?php echo Auth::user()->province;?>;
        filterProvince(prov_id);

        $('.filterMuncity').on('change', function() {
            var id = $(this).val();
            var tmp = $('#tmpMuncity').val();
            if(id === tmp)
                refreshBarangay($('#tmpBarangay').val());
            else
                refreshBarangay('');

            refreshMuncity(id);
            getBarangay(id);
        });

        function filterProvince(id) {
            var muncity = $('#tmpMuncity').val();
            var url = 'location/muncity/'+id;
            $('.filterMuncity').empty()
                .append($('<option>', {
                    value: "",
                    text : "Select Municipal / City..."
                }));
            if(id){
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        var sameMuncity = false;
                        console.log("filter province: " + id);
                        jQuery.each(data, function(i,val){
                            $('.filterMuncity').append($('<option>', {
                                value: val.id,
                                text : val.description,
                                selected : function(){
                                    if(muncity==val.id){
                                        sameMuncity = true;
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }
                            }));
                            $('.filterMuncity').chosen().trigger('chosen:updated');
                        });
                        if(sameMuncity)
                            refreshBarangay($('#tmpBarangay').val());
                        else
                            refreshBarangay('');

                        getBarangay(muncity);
                        refreshMuncity(muncity);
                    }
                });
            }
        }

        function refreshMuncity(id) {
            if(id) {
                $.ajax({
                    url: 'home/count/muncity/'+id,
                    type: 'GET',
                    success: function(result) {
                        $('.countPopulationPerMuncity').html(result.countPopulation);
                        $('.profilePercentagePerMuncity').html(result.profilePercentage);
                        $('.profilePercentageBarPerMuncity').css({ width: result.profilePercentage+'%' });
                    }
                });
            } else {
                $('.countPopulationPerMuncity').html(0);
                $('.profilePercentagePerMuncity').html(0);
                $('.profilePercentageBarPerMuncity').css({ width: 0+'%' });
            }
        }


        function getBarangay(id) {
            $('.filterBarangay').empty()
                .append($('<option>', {
                    value: "",
                    text : "Select Barangay..."
                }));

            if(id) {
                var barangay = $('#tmpBarangay').val();
                $.ajax({
                    url: 'location/barangay/'+id,
                    type: 'GET',
                    success: function(data) {
                        jQuery.each(data, function(i,val){
                            $('.filterBarangay').append($('<option>', {
                                value: val.id,
                                text : val.description,
                                selected : function(){
                                    if(barangay==val.id){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }
                            }));
                            $('.filterBarangay').chosen().trigger('chosen:updated');
                        });
                    }
                });
            }
        }


        $('.filterBarangay').on('change', function() {
            refreshBarangay($(this).val());
        });

        function refreshBarangay(id) {
            if (id) {
                $.ajax({
                    url: 'home/count/barangay/' + id,
                    type: 'GET',
                    success: function (result) {
                        $('.countPopulationPerBarangay').html(result.countPopulation);
                        $('.profilePercentagePerBarangay').html(result.profilePercentage);
                        $('.profilePercentageBarPerBarangay').css({width: result.profilePercentage + '%'});
                    }
                });
            } else {
                $('.countPopulationPerBarangay').html(0);
                $('.profilePercentagePerBarangay').html(0);
                $('.profilePercentageBarPerBarangay').css({width: 0 + '%'});
            }
        }
    </script>
@endsection