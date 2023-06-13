<?php
use App\Http\Controllers\ReportCtrl as Report;
?>

@extends('app')
@section('content')
    <style>
        .table thead tr th {
            font-weight: bold;
        }
    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <div class="row">
                <div class="col-md-8">
                    <h3><b>REPORT FOR ICLINICSYS ({{ $year }})</b></h3><small class="text-red">*Wait for data to load before downloading.</small>
                </div>
                <form method="get" action="{{ asset('/admin/report/iclinicsys') }}"><br>
                    <div class="col-md-3">
                        <select class="form-control select2" name="select_year" id="select_year" style="width:75%;">
                            <option value="">Select year...</option>
                            <option value="2018" <?php if($year == '2018') echo 'selected';?>>2018</option>
                            <option value="2022" <?php if($year == '2022') echo 'selected';?>>2022</option>
                        </select>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-info btn-sm btn-flat"><i class="fa fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearfix" style="margin-bottom: 10px"></div>
            @if(count($province) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" style="border: 1px solid darkslategray">
                        <thead>
                        <tr>
                            <th class="bg-primary" width="20%">{{ $title }}</th>
                            <th class="bg-primary text-center">Target</th>
                            <th class="bg-primary text-center">Profiled</th>
                            <th class="bg-primary text-center">%</th>
                            <th class="bg-primary text-center">List of Municipalities</th>
                            <th class="bg-primary text-center">List of Barangays</th>
                            <th class="bg-primary text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($province as $prov)
                            <tr>
                                <td><small><b>{{ strtoupper($prov->description) }}</b></small></td>
                                <td class="text-center">{{ number_format($prov->target) }}</td>
                                <td class="text-center"><span id="prov_profile{{ $prov->id }}"><i class="fa fa-refresh fa-spin"></i></span></td>
                                <td class="text-center" id="percent_class{{ $prov->id }}"><span id="prov_percentage{{ $prov->id }}"><i class="fa fa-refresh fa-spin"></i></span></td>
                                <form action="{{ asset('download/iclinicsys') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $prov->id }}" name="province_id">
                                    <input type="hidden" value="" name="year_selected" class="year_selected">
                                    <input type="hidden" value="" id="municipality{{$s->id}}">
                                    <input type="hidden" value="" id="barangay{{$s->id}}">
                                    <td width="250px">
                                        <select class="form-control select2" id="muncity_select{{$prov->id}}" onchange="filterMuncity({{ $prov->id }})" name="muncity_id">
                                            <option value="">Select...</option>
                                        @foreach(\App\Muncity::where('province_id',$prov->id)->get() as $row)
                                            <option value="{{ $row->id }}">{{ $row->description }}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                    <td width="250px">
                                        <select class="form-control select2" id="bar_select{{$prov->id}}" onchange="setBarangay({{$prov->id}})" name="bar_id">
                                            <option value="">Select Barangay...</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn-primary btn btn-sm" id="dl_btn{{$prov->id}}" disabled>
                                            <i class="fa fa-download"></i> Download
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                        </tbody>

                        @if(count($brgy) > 1)
                            <tfoot style="background-color: lightgoldenrodyellow">
                            <tr>
                                <td><b>TOTAL:</b></td>
                                <td class="text-center">{{ number_format($total_target) }}</td>
                                <td class="text-center">{{ number_format($total_profiled) }}</td>
                                <?php $total_percentage = ($total_target > 0) ? ($total_profiled / $total_target) * 100 : 0;?>
                                <td class="text-center">{{ number_format($total_percentage) }} %</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            @else
                <div class="alert alert-warning">
                    <p class="text-warning"><strong><i class="fa fa-warning fa-lg"></i> No data found! </strong></p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    @include('script.admin_report')
@endsection