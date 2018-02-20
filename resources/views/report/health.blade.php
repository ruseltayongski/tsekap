@extends('client')
@section('content')
    <style>
        .chart-header {
            padding-bottom: 9px;
            margin: 10px 0 10px;
            border-bottom: 2px solid #eee;
        }
        .title-header {
            padding-bottom: 9px;
            margin: 0px;
        }
    </style>
    <div class="col-sm-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="title-header">Environmental Health Graph</h2>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="chart-header">Unmet Need</h2>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div id="canvas-holder" style="width:100%">
                <canvas id="unmet" />
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="chart-header">Safe Water Supply</h2>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div id="canvas-holder" style="width:100%">
                <canvas id="water" />
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="chart-header">Sanitary Toilet</h2>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div id="canvas-holder" style="width:100%">
                <canvas id="toilet" />
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="chart-header">Family Income</h2>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div id="canvas-holder" style="width:100%">
                <canvas id="income" />
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('resources/plugin/Chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('resources/plugin/Chartjs/utils.js') }}"></script>
    <script>
        <?php echo 'var url="'.asset('/user/report/health/data').'";';?>
        $.ajax({
            url: url,
            type: 'GET',
            success: function(jim){
                var data = jim.unmet;
                console.log(data);
                var labels = ['Option 1','Option 2', 'Option 3'];
                var config = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                window.chartColors.blue,
                                window.chartColors.green,
                                window.chartColors.yellow,
                                window.chartColors.orange,
                                window.chartColors.red,
                            ],
                            label: 'Unmet Need'
                        }],
                        labels: labels
                    },
                    options: {
                        responsive: true
                    }
                };

                var data = jim.water;
                var labels = ['Level 1','Level 2', 'Level 3'];
                var config_water = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                window.chartColors.blue,
                                window.chartColors.green,
                                window.chartColors.yellow,
                                window.chartColors.orange,
                                window.chartColors.red,
                            ],
                            label: 'Unmet Need'
                        }],
                        labels: labels
                    },
                    options: {
                        responsive: true
                    }
                };

                var data = jim.toilet;
                var labels = ['None','Communal', 'Individual Household'];
                var config_toilet = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                window.chartColors.blue,
                                window.chartColors.green,
                                window.chartColors.yellow,
                                window.chartColors.orange,
                                window.chartColors.red,
                            ],
                            label: 'Unmet Need'
                        }],
                        labels: labels
                    },
                    options: {
                        responsive: true
                    }
                };

                var data = jim.income;
                var labels = ['Poor','Low Income', 'Lower Middle','Middle Class', 'Upper Middle', 'Upper Income', 'Rich'];
                var config_income = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                window.chartColors.blue,
                                window.chartColors.green,
                                window.chartColors.yellow,
                                window.chartColors.orange,
                                window.chartColors.red,
                                window.chartColors.purple,
                                window.chartColors.grey,
                            ],
                            label: 'Unmet Need'
                        }],
                        labels: labels
                    },
                    options: {
                        responsive: true
                    }
                };

                var ctx_water = document.getElementById("water").getContext("2d");
                window.myPie = new Chart(ctx_water, config_water);

                var ctx_toilet = document.getElementById("toilet").getContext("2d");
                window.myPie = new Chart(ctx_toilet, config_toilet);

                var ctx_income = document.getElementById("income").getContext("2d");
                window.myPie = new Chart(ctx_income, config_income);

                var ctx = document.getElementById("unmet").getContext("2d");
                window.myPie = new Chart(ctx, config);
            }
        });
    </script>
@endsection