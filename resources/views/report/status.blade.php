<?php
    use App\Http\Controllers\ReportCtrl as Report;
    use Illuminate\Support\Facades\Session;
    $totalTarget = 0;
    $totalProfile = 0;
    $totalValid = 0;
    $totalProfilePer = 0;
    $totalValidPer = 0;
    $c = 0;
    $muncity = '';
?>
@extends('app')
@section('content')
    <div class="modal fade" role="dialog" id="stat_details">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content details_body">
            </div>
        </div>
    </div>

    {{--@include('report.sidebar')--}}
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <div class="row">
                <div class="col-md-7">
                    <h4><b>STATUS REPORT ({{ $year }})</b></h4><small class="text-red">*Wait for data to load before downloading.</small>
                </div>
                <form method="get" action="{{ asset('/report/status') }}">
                    <div class="col-md-3">
                        <select class="select2" id="select_year" name="select_year">
                            <option>Select year...</option>
                            <option value="2018" <?php if($year == '2018') echo 'selected';?>>2018</option>
                            <option value="2022" <?php if($year == '2022') echo 'selected';?>>2022</option>
                        </select>&nbsp;
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info btn-sm btn-flat"><i class="fa fa-filter"></i> Filter</button>
                    </div>
                </form>
            </div>

            <div class="clearfix" style="margin-bottom: 5px"></div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                    <tr>
                        <th class="bg-primary" width="20%">{{ $title }}</th>
                        <th class="bg-primary text-center">Target</th>
                        <th class="bg-primary text-center">Population<br/>Profiled</th>
                        <th class="bg-primary text-center">(%)</th>
                        @if($level == 'province')
                            <th class="bg-primary text-center">
                                List of Municipalities
                            </th>
                            <th class="bg-primary text-center">
                                List of Barangays
                            </th>
                            <th class="bg-primary text-center">
                                Action
                            </th>
                        @endif
                        @if($level == 'brgy')
                            <th class="bg-primary">
                                No. of children <br><small>(0-59 mos)</small>
                            </th>
                        @endif
                    </tr>
                    <?php
                    $child_count = 0;
                    ?>
                        @foreach($sub as $s)
                        <?php
                            $c++;
                            $target = $s->target;
                            Session::put('statreport_year', $year);
                        ?>
                        <tr>
                            <td>{{ $s->description }} {{ $level }}</td>

                            <td class="text-center">{{ number_format($target) }}</td>

                            <td class="text-center"><span id="prov_profile{{ $s->id }}"><i class="fa fa-refresh fa-spin"></i></span></td>

                            <td class="text-center" id="percent_class{{ $s->id }}"><span id="prov_percentage{{ $s->id }}"><i class="fa fa-refresh fa-spin"></i></span></td>
                            @if($level == 'province')
                            <form action="{{ asset('generatedownload') }}" method="POST">
                                <td width="250px">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $s->id }}" name="province_id">
                                    <input type="hidden" value="" name="year_selected" class="year_selected">
                                    <input type="hidden" value="" id="municipality{{$s->id}}">
                                    <input type="hidden" value="" id="barangay{{$s->id}}">
                                    <div>
                                        <select class="form-control select2" id="muncity_select{{$s->id}}" onchange="filterMuncity({{$s->id}})" name="muncity_id">
                                            <option value="">Select Municipality...</option>
                                            @foreach(\App\Muncity::where('province_id','=',$s->id)->get() as $row)
                                                <option value="{{ $row->id }}">{{ $row->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td width="250px">
                                    <div>
                                        <select class="form-control select2" id="bar_select{{$s->id}}" onchange="setBarangay({{$s->id}})" name="bar_id">
                                            <option value="">Select Barangay...</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <a href="" data-toggle="modal" id="details_btn{{$s->id}}" class="btn-success btn btn-sm" onclick="showDetails({{$s->id}})">
                                            <i class="fa fa-info-circle"></i> Details
                                        </a> &emsp;
                                        <button class="btn-primary btn btn-sm" id="dl_btn{{$s->id}}" disabled>
                                            <i class="fa fa-download"></i> Download
                                        </button>
                                    </div>
                                </td>
                            </form>
                            @endif
                            @if($level == 'brgy')
                                <td>
                                    {{ number_format($s->child) }}
                                    <?php
                                        $child_count += $s->child;
                                    ?>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                        @if($level == 'brgy')
                            <tr>
                                <td colspan="4" class="text-right">
                                    0-59 mos Total:
                                </td>
                                <td >{{ number_format($child_count) }}</td>
                            </tr>
                        @endif
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('script.admin_report')
@endsection