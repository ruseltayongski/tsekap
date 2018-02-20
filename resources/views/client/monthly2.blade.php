<?php
    use App\Http\Controllers\ParameterCtrl as Param;
    use App\Cases;

    $peM = 0;
    $peF = 0;

?>
@extends('client')
@section('content')
    <style>
        select, button {
            margin:5px 3px;
        }
    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Monthly Report</h2>
            <form class="form-inline form-submit" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <select class="form-control chosen-select-static" style="width:100%" name="month">
                        <option value="">Select Month...</option>
                        <option value="01" @if($month=='01') selected @endif>January</option>
                        <option value="02" @if($month=='02') selected @endif>February</option>
                        <option value="03" @if($month=='03') selected @endif>March</option>
                        <option value="04" @if($month=='04') selected @endif>April</option>
                        <option value="05" @if($month=='05') selected @endif>May</option>
                        <option value="06" @if($month=='06') selected @endif>June</option>
                        <option value="07" @if($month=='07') selected @endif>July</option>
                        <option value="08" @if($month=='08') selected @endif>August</option>
                        <option value="09" @if($month=='09') selected @endif>September</option>
                        <option value="10" @if($month=='10') selected @endif>October</option>
                        <option value="11" @if($month=='11') selected @endif>November</option>
                        <option value="12" @if($month=='12') selected @endif>December</option>
                        <option value="ALL" @if($month=='ALL') selected @endif>Whole Year</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control chosen-select-static" style="width:100%" name="year">
                        <option value="">Select Year...</option>
                        <?php $yearNow = date('Y'); ?>
                        @for($i=10;$i>0;$i--)
                            <option @if($year==$yearNow) selected @endif>{{ $yearNow }}</option>
                            <?php $yearNow-- ;?>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-submit btn btn-success col-xs-12"><i class="fa fa-search"></i> View Report</button>
                    <div class="clearfix"></div>
                </div>
            </form>
            <hr />
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="font-size: 0.7em;">
                    <thead>
                        <tr>
                            <th width="250" rowspan="4" style="vertical-align:middle;">BASIC HEALTH SERVICES</th>
                            <th colspan="2">NEW BORN</th>
                            <th colspan="2">INFANT</th>
                            <th colspan="4">CHILD</th>
                            <th colspan="4">ADOLESCENT</th>
                            <th colspan="4" rowspan="2" style="vertical-align:middle;">20-49 YRS OLD</th>
                            <th colspan="2" rowspan="2" style="vertical-align:middle;">50-59 YRS OLD</th>
                            <th colspan="2" rowspan="2" style="vertical-align:middle;">60 YRS ABOVE</th>
                            <th colspan="2" rowspan="2" style="vertical-align:middle;">SUBTOTAL</th>
                            <th rowspan="4" style="vertical-align:middle;">GRAND TOTAL</th>
                        </tr>
                        <tr>
                            <th colspan="2">0-28days</th>
                            <th colspan="2">29 days-11mons</th>
                            <th colspan="2">1-5yrs old</th>
                            <th colspan="2">6-9yrs old</th>
                            <th colspan="4">10-19yrs old</th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th rowspan="2" style="vertical-align:middle;">F</th>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th rowspan="2" style="vertical-align:middle;">F</th>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th rowspan="2" style="vertical-align:middle;">F</th>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th rowspan="2" style="vertical-align:middle;">F</th>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th colspan="3" style="vertical-align:middle;">F</th>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th colspan="3" style="vertical-align:middle;">F</th>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th rowspan="2" style="vertical-align:middle;">F</th>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th rowspan="2" style="vertical-align:middle;">F</th>
                            <th rowspan="2" style="vertical-align:middle;">M</th>
                            <th rowspan="2" style="vertical-align:middle;">F</th>
                        </tr>
                        <tr>
                            <th>Pregnant</th>
                            <th>Post Partum</th>
                            <th>Non-Pregnant</th>
                            <th>Pregnant</th>
                            <th>Post Partum</th>
                            <th>Non-Pregnant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-right">Physical Examination</th>
                            <td><?php echo $total = Param::countServices('Male','PE',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','PE',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','PE',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','PE',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','PE',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','PE',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','PE',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','PE',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','PE',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                        </tr>
                        <?php
                            $peM = 0;
                            $peF = 0;
                        ?>
                        <tr>
                            <td class="text-right">Blood Pressure</td>
                            <td><?php echo $total = Param::countServices('Male','BP',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BP',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BP',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BP',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BP',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BP',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BP',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BP',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BP',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                        </tr>
                        <?php
                        $peM = 0;
                        $peF = 0;
                        ?>
                        <tr>
                            <th class="text-right">Weight Measurement</th>
                            <td><?php echo $total = Param::countServices('Male','WM',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Obese</td>
                            <td><?php echo $total = Param::countServices('Male','WM',1,$month,$year,'','ob');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',1,$month,$year,'','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',2,$month,$year,'','ob');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',2,$month,$year,'','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',3,$month,$year,'','ob');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',3,$month,$year,'','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',4,$month,$year,'','ob');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',4,$month,$year,'','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',5,$month,$year,'','ob');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'pregnant','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'post','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'non','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',6,$month,$year,'','ob');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'pregnant','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'post','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'non','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',7,$month,$year,'','ob');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',7,$month,$year,'','ob');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',8,$month,$year,'','ob');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',8,$month,$year,'','ob');$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Undernutrition</td>
                            <td><?php echo $total = Param::countServices('Male','WM',1,$month,$year,'','un');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',1,$month,$year,'','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',2,$month,$year,'','un');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',2,$month,$year,'','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',3,$month,$year,'','un');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',3,$month,$year,'','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',4,$month,$year,'','un');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',4,$month,$year,'','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',5,$month,$year,'','un');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'pregnant','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'post','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',5,$month,$year,'non','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',6,$month,$year,'','un');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'pregnant','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'post','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',6,$month,$year,'non','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',7,$month,$year,'','un');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',7,$month,$year,'','un');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WM',8,$month,$year,'','un');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WM',8,$month,$year,'','un');$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <th class="text-right">Height Measurement</th>
                            <td><?php echo $total = Param::countServices('Male','HM',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Stunted</td>
                            <td><?php echo $total = Param::countServices('Male','HM',1,$month,$year,'','stn');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',1,$month,$year,'','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',2,$month,$year,'','stn');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',2,$month,$year,'','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',3,$month,$year,'','stn');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',3,$month,$year,'','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',4,$month,$year,'','stn');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',4,$month,$year,'','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',5,$month,$year,'','stn');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',5,$month,$year,'pregnant','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',5,$month,$year,'post','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',5,$month,$year,'non','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',6,$month,$year,'','stn');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',6,$month,$year,'pregnant','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',6,$month,$year,'post','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',6,$month,$year,'non','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',7,$month,$year,'','stn');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',7,$month,$year,'','stn');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HM',8,$month,$year,'','stn');$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HM',8,$month,$year,'','stn');$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <th class="text-left">LABORATORY SERVICES</th>
                            <td colspan="23"></td>
                        </tr>
                        <tr>
                            <td class="text-right">Blood Typing</td>
                            <td><?php echo $total = Param::countServices('Male','BT',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BT',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BT',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BT',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BT',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BT',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BT',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BT',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BT',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Complete Blood Count</td>
                            <td><?php echo $total = Param::countServices('Male','CBC',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CBC',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CBC',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CBC',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CBC',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CBC',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CBC',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CBC',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CBC',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Urinalysis</td>
                            <td><?php echo $total = Param::countServices('Male','URI',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','URI',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','URI',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','URI',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','URI',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','URI',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','URI',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','URI',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','URI',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Fasting Blood Sugar</td>
                            <td><?php echo $total = Param::countServices('Male','FBS',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','FBS',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','FBS',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','FBS',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','FBS',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','FBS',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','FBS',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BST',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BST',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','BST',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','BST',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>

                        <tr>
                            <td class="text-right">Stool Examination</td>
                            <td><?php echo $total = Param::countServices('Male','SE',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SE',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SE',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SE',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SE',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SE',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SE',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SE',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SE',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Others</td>
                            <td><?php echo $total = Param::countServices('Male','others',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','others',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','others',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','others',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','others',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','others',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','others',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','others',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','others',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <th class="text-left">FAMILY PLANNING SERVICES</th>
                            <td colspan="23"></td>
                        </tr>
                        <tr>
                            <td class="text-right">With Unmet Need</td>
                            <td><?php echo $total = Param::countServices('Male','WUN',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WUN',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WUN',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WUN',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WUN',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WUN',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WUN',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','WUN',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','WUN',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Counseling</td>
                            <td><?php echo $total = Param::countServices('Male','CNL',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNL',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNL',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNL',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNL',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNL',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNL',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNL',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNL',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Commodities</td>
                            <td><?php echo $total = Param::countServices('Male','CMD',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CMD',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CMD',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CMD',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CMD',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CMD',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CMD',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CMD',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CMD',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <th class="text-right">Health Education and Promotion Services</th>
                            <td><?php echo $total = Param::countServices('Male','HEPS',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HEPS',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HEPS',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HEPS',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HEPS',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HEPS',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HEPS',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','HEPS',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','HEPS',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <th class="text-left">OTHER SERVICES</th>
                            <td colspan="23"></td>
                        </tr>
                        <tr>
                            <td class="text-right">Eye Exam</td>
                            <td><?php echo $total = Param::countServices('Male','EE',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','EE',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','EE',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','EE',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','EE',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','EE',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','EE',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','EE',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','EE',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Ear Exam</td>
                            <td><?php echo $total = Param::countServices('Male','ERE',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','ERE',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','ERE',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','ERE',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','ERE',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','ERE',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','ERE',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','ERE',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','ERE',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Oral Exam</td>
                            <td><?php echo $total = Param::countServices('Male','OS',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','OS',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','OS',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','OS',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','OS',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','OS',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','OS',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','OS',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','OS',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr class="bg-warning">
                            <?php
                                $bracket1 = 0;
                                $bracket2 = 0;
                                $bracket3 = 0;
                                $bracket4 = 0;
                                $bracket5 = 0;
                                $bracket6 = 0;
                                $bracket7 = 0;
                                $bracket8 = 0;
                            ?>
                            <th class="text-left">SUB TOTAL</th>
                            <td><?php echo $total = Param::countServices('Male','SUB',1,$month,$year);$peM+=$total; $bracket1 += $total;?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',1,$month,$year);$peF+=$total;$bracket1 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SUB',2,$month,$year);$peM+=$total; $bracket2 += $total;?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',2,$month,$year);$peF+=$total; $bracket2 += $total;?></td>
                            <td><?php echo $total = Param::countServices('Male','SUB',3,$month,$year);$peM+=$total;$bracket3 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',3,$month,$year);$peF+=$total;$bracket3 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SUB',4,$month,$year);$peM+=$total;$bracket4 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',4,$month,$year);$peF+=$total;$bracket4 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SUB',5,$month,$year);$peM+=$total;$bracket5 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',5,$month,$year,'pregnant');$peF+=$total;$bracket5 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',5,$month,$year,'post');$peF+=$total;$bracket5 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',5,$month,$year,'non');$peF+=$total;$bracket5 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SUB',6,$month,$year);$peM+=$total;$bracket6 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',6,$month,$year,'pregnant');$peF+=$total;$bracket6 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',6,$month,$year,'post');$peF+=$total;$bracket6 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',6,$month,$year,'non');$peF+=$total;$bracket6 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SUB',7,$month,$year);$peM+=$total;$bracket7 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',7,$month,$year);$peF+=$total;$bracket7 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SUB',8,$month,$year);$peM+=$total;$bracket8 += $total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SUB',8,$month,$year);$peF+=$total;$bracket8 += $total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr class="bg-info">
                            <th class="text-left">TOTAL</th>
                                <th colspan="2" class="text-center"><?php echo $bracket1; ?></th>
                                <th colspan="2" class="text-center"><?php echo $bracket2; ?></th>
                                <th colspan="2" class="text-center"><?php echo $bracket3; ?></th>
                                <th colspan="2" class="text-center"><?php echo $bracket4; ?></th>
                                <th colspan="4" class="text-center"><?php echo $bracket5; ?></th>
                                <th colspan="4" class="text-center"><?php echo $bracket6; ?></th>
                                <th colspan="2" class="text-center"><?php echo $bracket7; ?></th>
                                <th colspan="2" class="text-center"><?php echo $bracket8; ?></th>
                            <td></td>
                            <td></td>
                            <th>{{ $bracket1 + $bracket2 + $bracket3 + $bracket4 + $bracket5 + $bracket6 + $bracket7 + $bracket8 }}</th>
                        </tr>
                        <tr>
                            <td>Total no. of clients provided with at least 3 services (Based on form 1A-1H)</td>
                            <?php
                                $monthPrev = 1;
                                if($month!='01'){
                                    $monthPrev = $month-1;
                                }
                            ?>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Male',1,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Male',1,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peM+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',1,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Female',1,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Male',2,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Male',2,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peM+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',2,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Female',2,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Male',3,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Male',3,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peM+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',3,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Female',3,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Male',4,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Male',4,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peM+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',4,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Female',4,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Male',5,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Male',5,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peM+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',5,$month,$year,'pregnant');
                                $totalPrev = Param::countMustServiceMonthly('Female',5,$monthPrev,$year,'pregnant');
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',5,$month,$year,'post');
                                $totalPrev = Param::countMustServiceMonthly('Female',5,$monthPrev,$year,'post');
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',5,$month,$year,'non');
                                $totalPrev = Param::countMustServiceMonthly('Female',5,$monthPrev,$year,'non');
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Male',6,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Male',6,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peM+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',6,$month,$year,'pregnant');
                                $totalPrev = Param::countMustServiceMonthly('Female',6,$monthPrev,$year,'pregnant');
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',6,$month,$year,'post');
                                $totalPrev = Param::countMustServiceMonthly('Female',6,$monthPrev,$year,'post');
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',6,$month,$year,'non');
                                $totalPrev = Param::countMustServiceMonthly('Female',6,$monthPrev,$year,'non');
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Male',7,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Male',7,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peM+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',7,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Female',7,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Male',8,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Male',8,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peM+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNow = Param::countMustServiceMonthly('Female',8,$month,$year);
                                $totalPrev = Param::countMustServiceMonthly('Female',8,$monthPrev,$year);
                                if($month=='01'){
                                    $total = $totalNow;
                                }else{
                                    $total = $totalNow - $totalPrev;
                                }
                                $peF+=$total;
                                echo $total;
                                ?>
                            </td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <th>CASES REFERRED (specify)</th>
                            <td colspan="23"></td>
                        </tr>
                        <?php $cases = Cases::get(); $i=1;?>
                        @foreach($cases as $c)
                        <tr>
                            <td>{{ $i++ }}. {{ $c->description }}</td>
                            <td><?php echo $total = Param::countCases('Male',1,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',1,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',2,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',2,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',3,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',3,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',4,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',4,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',5,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',5,$month,$year,$c->id,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',5,$month,$year,$c->id,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',5,$month,$year,$c->id,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',6,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',6,$month,$year,$c->id,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',6,$month,$year,$c->id,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',6,$month,$year,$c->id,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',7,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',7,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',8,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',8,$month,$year,$c->id);$peM+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        @endforeach
                        <tr class="bg-info text-bold">
                            <th>TOTAL CASES REFERRED</th>
                            <td><?php echo $total = Param::countCases('Male',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Male',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countCases('Female',8,$month,$year);$peM+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <th>DRUG REHABILITATION SERVICES</th>
                            <td colspan="23"></td>
                        </tr>
                        <tr>
                            <td class="text-right">Screening</td>
                            <td><?php echo $total = Param::countServices('Male','SC',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SC',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SC',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SC',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SC',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SC',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SC',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','SC',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','SC',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Counseling</td>
                            <td><?php echo $total = Param::countServices('Male','CNS',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNS',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNS',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNS',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNS',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNS',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNS',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','CNS',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','CNS',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Drug Testing</td>
                            <td><?php echo $total = Param::countServices('Male','DT',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DT',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DT',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DT',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DT',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DT',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DT',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DT',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DT',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr>
                            <td class="text-right">Referral</td>
                            <td><?php echo $total = Param::countServices('Male','RR',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','RR',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','RR',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','RR',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','RR',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','RR',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','RR',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','RR',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','RR',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                        <tr class="bg-info text-bold">
                            <th>TOTAL DRUG REHABILITATION SERVICES</th>
                            <td><?php echo $total = Param::countServices('Male','DRUG',1,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',1,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DRUG',2,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',2,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DRUG',3,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',3,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DRUG',4,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',4,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DRUG',5,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',5,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',5,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',5,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DRUG',6,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',6,$month,$year,'pregnant');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',6,$month,$year,'post');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',6,$month,$year,'non');$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DRUG',7,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',7,$month,$year);$peF+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Male','DRUG',8,$month,$year);$peM+=$total; ?></td>
                            <td><?php echo $total = Param::countServices('Female','DRUG',8,$month,$year);$peF+=$total; ?></td>
                            <td>{{ $peM }}</td>
                            <td>{{ $peF }}</td>
                            <td>{{ $peM + $peF }}</td>
                            <?php
                            $peM = 0;
                            $peF = 0;
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection