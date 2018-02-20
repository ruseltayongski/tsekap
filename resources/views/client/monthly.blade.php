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
        td:hover {
            background: #00ca6d;
            color: #fff;
        }
    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Monthly Report</h2>
            <form class="form-inline form-submit" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <select class="month form-control" style="width:100%" name="month">
                        <option value="ALL" @if($month=='ALL') selected @endif>Whole Year</option>
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
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control year" style="width:100%" name="year">
                        <?php
                            $years = \App\Http\Controllers\ParameterCtrl::getYear();
                        ?>
                        @foreach($years as $y)
                            <option @if($year==$y) selected @endif>{{ $y }}</option>
                        @endforeach
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
                        @for($i=0; $i<=22; $i++)
                            <td class="pe{{$i}}"></td>
                        @endfor
                    </tr>
                    <?php
                    $peM = 0;
                    $peF = 0;
                    ?>
                    <tr>
                        <td class="text-right">Blood Pressure</td>
                        @for($i=0; $i<=22; $i++)
                            <td class="bp{{$i}}"></td>
                        @endfor
                    </tr>
                    <?php
                    $peM = 0;
                    $peF = 0;
                    ?>
                    <tr>
                        <th class="text-right">Weight Measurement</th>
                        @for($i=0; $i<=22; $i++)
                            <td class="wm{{$i}}"></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Obese</td>
                        @for($i=0; $i<=22; $i++)
                            <td class="obese{{$i}}"></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Undernutrition</td>
                        @for($i=0; $i<=22; $i++)
                            <td class="under{{$i}}"></td>
                        @endfor
                    </tr>
                    <tr>
                        <th class="text-right">Height Measurement</th>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Stunted</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <th class="text-left">LABORATORY SERVICES</th>
                        <th colspan="23">&nbsp;</th>
                    </tr>
                    <tr>
                        <td class="text-right">Blood Typing</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Complete Blood Count</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Urinalysis</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Fasting Blood Sugar</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>

                    <tr>
                        <td class="text-right">Stool Examination</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Others</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <th class="text-left">FAMILY PLANNING SERVICES</th>
                        <th colspan="23">&nbsp;</th>
                    </tr>
                    <tr>
                        <td class="text-right">With Unmet Need</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Counseling</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Commodities</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <th class="text-right">Health Education and Promotion Services</th>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <th class="text-left">OTHER SERVICES</th>
                        <th colspan="23">&nbsp;</th>
                    </tr>
                    <tr>
                        <td class="text-right">Eye Exam</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Ear Exam</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Oral Exam</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr class="bg-warning">
                        <th class="text-left">SUB TOTAL</th>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr class="bg-info">
                        <td class="text-left">TOTAL</td>
                        <td colspan="2" class="text-center"></td>
                        <td colspan="2" class="text-center"></td>
                        <td colspan="2" class="text-center"></td>
                        <td colspan="2" class="text-center"></td>
                        <td colspan="4" class="text-center"></td>
                        <td colspan="4" class="text-center"></td>
                        <td colspan="2" class="text-center"></td>
                        <td colspan="2" class="text-center"></td>
                        <td></td>
                        <td></td>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Total no. of clients provided with at least 3 services (Based on form 1A-1H)</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <th>CASES REFERRED (specify)</th>
                        <th colspan="23">&nbsp;</th>
                    </tr>
                    <?php $cases = Cases::get(); $i=1;?>
                    @foreach($cases as $c)
                        <tr>
                            <td>{{ $i++ }}. {{ $c->description }}</td>
                            @for($i=0; $i<=22; $i++)
                                <td></td>
                            @endfor
                        </tr>
                    @endforeach
                    <tr class="bg-info text-bold">
                        <th>TOTAL CASES REFERRED</th>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <th>DRUG REHABILITATION SERVICES</th>
                        <th colspan="23">&nbsp;</th>
                    </tr>
                    <tr>
                        <td class="text-right">Screening</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Counseling</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Drug Testing</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="text-right">Referral</td>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    <tr class="bg-info text-bold">
                        <th>TOTAL DRUG REHABILITATION SERVICES</th>
                        @for($i=0; $i<=22; $i++)
                            <td></td>
                        @endfor
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('.table').find('td:empty').html('<center><i class="fa fa-spin fa-spinner"></i></center>');

    var month = $('.month').val();
    var year = $('.year').val();
    var step = 0;
    var services = ['pe','bp','wm','obese'];
    console.log(services[step]);

    countServices();

    function countServices()
    {
        var service_code = services[step];

        if(step < services.length){
            var url = "<?php echo asset('user/report/monthly/count/');?>";
            var action = false;
            $.ajax({
                url: url+'/'+service_code+'/'+month+'/'+year,
                type: 'GET',
                success: function(data){
                    console.log(data);
                    var c=0;
                    var interval = setInterval(function(){
                        var cell = '.'+service_code+c;
                        var val = data[c];
                        $(cell).html(val);
                        c++;

                        if(c>22)
                        {
                            countServices();
                            clearInterval(interval);
                        }
                    },100);
                }
            });
        }
        step++;
    }
</script>
@endsection