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
                    <h4><b>STATUS REPORT ({{ $year }})</b></h4>
                </div>
                <form method="get" action="{{ asset('/report/status') }}">
                    <div class="col-md-3">
                        <select class="select2" name="select_year" style="width:50%;">
                            <option>Select year...</option>
                            <option value="2018" <?php if($year == '2018') echo 'selected';?>>2018</option>
                            <option value="2022" <?php if($year == '2022') echo 'selected';?>>2022</option>
                        </select>&nbsp;
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info btn-sm btn-flat"><i class="fa fa-filter"></i> Filter</button>
                    </div>
                </form>
                {{--<span>--}}
                    {{----}}
                    {{--<b>Year: &nbsp;&nbsp;</b>--}}
                    {{--<select class="select2 pull-right" id="select_year">--}}
                        {{--<?php--}}
                        {{--$cur_year = \Carbon\Carbon::now()->format('Y');--}}
                        {{--echo "<option value='' selected>Select...</option>";--}}
                        {{--while($cur_year >= '2017') {--}}
                            {{--echo "<option>".$cur_year--."</option>";--}}
                        {{--}--}}
                        {{--?>--}}
                    {{--</select>--}}
                {{--</span>--}}
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
                            $profile = Report::getProfile($level,$s->id);

                            if($target==0){
                                $target=$profile;
                            }

                            if($profile==0){
                                $profilePercentage = 0;
                            }else{
                                $profilePercentage = ($profile / $target) * 100;
                            }

                            $a = $profilePercentage;
                            $class = 'danger';
                            if($a>=0 && $a<=20){
                                $class = 'danger';
                            }else if($a>20 && $a<=40){
                                $class = 'warning';
                            }else if($a>40 && $a<=60){
                                $class = 'info';
                            }else if($a>60 && $a<=80){
                                $class = 'success';
                            }else if($a>80){
                                $class = 'aqua';
                            }
                        ?>
                        <tr>
                            <td>{{ $s->description }} {{ $level }}</td>

                            <td class="text-center">{{ number_format($target) }}</td>

                            <td class="text-center">{{ number_format($profile) }}</td>

                            <td class="bg-{{$class}} text-center">{{ number_format($profilePercentage,1) }}%</td>
                            @if($level == 'province')
                            <form action="{{ str_replace('tsekap/vii','project',asset('generatedownload')) }}" method="POST">
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
                                        <button class="btn-primary btn btn-sm">
                                            <i class="fa fa-download"></i> Download
                                        </button>
                                    </div>
                                </td>
                                {{--@foreach(\App\Muncity::where('province_id','=',$s->id)->get() as $row)--}}
                                    {{--<div class="btn-group">--}}
                                        {{--<form action="{{ str_replace('tsekap/vii','project',asset('generatedownload')) }}" method="POSt">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--<input type="hidden" value="{{ $row->province_id }}" name="province_id">--}}
                                            {{--<input type="hidden" value="{{ $s->description }}" name="province_desc">--}}
                                            {{--<input type="hidden" value="{{ $row->id }}" name="muncity_id">--}}
                                            {{--<input type="hidden" value="{{ $row->description }}" name="muncity_desc">--}}
                                            {{--<input type="hidden" value="" name="year_selected" class="year_selected">--}}
                                            {{--<button class="btn-primary btn">--}}
                                                {{--<i class="fa fa-download"></i> {{ $row->description }}--}}
                                            {{--</button>--}}
                                        {{--</form>--}}
                                    {{--</div>--}}
{{--                                        <a href="{{ str_replace('tsekap/vii','project',asset('download')) }}/{{ $row->province_id }}/{{ $s->description }}/{{ $row->id }}/{{ $row->description }}" class="btn btn-primary"><i class="fa fa-download"></i> {{ $row->description }}</a>--}}
                                {{--@endforeach--}}
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
<script>
    $('.loading').show();
    $('.btn-submit').on('click',function(){
        $('.loading').show();
    });
    $(window).on('load',function(){
        $('.loading').fadeOut('slow');
    });
    <?php if(isset($province_id)): ?>
    <?php echo 'var tmp = '.$province_id.';'; ?>
    <?php echo 'var muncity_id = "'.$muncity_id.'";'; ?>
        filterProvince(tmp,muncity_id);
    <?php endif; ?>
    $('.filterProvince').on('change',function(){
        var id = $(this).val();
        filterProvince(id,'');
    });
    function filterProvince(id,muncity_id)
    {
        <?php echo 'var link="'.asset('location/muncity').'";'; ?>
        var url = link+'/'+id;
        $('.filterMuncity').html('<option value="all">Select All...</option>').trigger('change');
        if(id){
            $('.loading').show();
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    var content = '';
                    jQuery.each(data, function(i,val){
                        content += '<option value="'+val.id+'">' +
                                val.description +
                                '</option>'
                    });
                    $('.filterMuncity').append(content).trigger("chosen:updated");
                    if(muncity_id>0){
                        $('.filterMuncity').val(muncity_id).trigger("chosen:updated");
                    }else{
                        $('.filterMuncity').val('all').trigger("chosen:updated");
                    }
                    $('.loading').hide();
                }
            });
        }
    }

    $(".select2").select2({ width: '100%' });

    $('#select_year').on('change', function() {
        $('.year_selected').val($(this).val());
    });

    function filterMuncity(prov_id) {
        muncity_id = $('#muncity_select'+prov_id).val();
        $('#municipality'+prov_id).val(muncity_id);
        $('#barangay'+prov_id).val('');
        if(muncity_id !== '') {
            var url = "{{ asset('population/target/getMuncityTotal') }}";
            $.ajax({
                url: url+'/'+muncity_id,
                type: 'GET',
                success: function(data){
                    index = data.prov;
                    console.log("index: " + index);
                    $('#bar_select'+index).empty()
                        .append($('<option>', {
                                value: '',
                                text : 'Select Barangay...',
                                selected: 'true'
                            }
                        ));
                    jQuery.each(data.barangay, function(i,val){
                        $('#bar_select'+index).append($('<option>', {
                            value: val.id,
                            text : val.description
                        }));
                    });
                    $('#bar_select'+prov_id).trigger('change');
                }
            });
        } else {
            $('#bar_select'+prov_id).empty().append($('<option>', {
                    value: '',
                    text : 'Select Barangay...'
                }
            ));
            $('#bar_select'+prov_id).trigger('change');
        }
    }

    function setBarangay(prov_id) {
        $('#barangay'+prov_id).val($('#bar_select'+prov_id).val());
    }

    function showDetails(prov_id) {
        var muncity = $('#municipality'+prov_id).val();
        var barangay = $('#barangay'+prov_id).val();
        console.log('barangay: ' + barangay);
        if(barangay === '') {
            barangay = 0;
        }
        if(muncity !== '' && muncity !== null) {
            $('.details_body').html(loadingState);
            $('#details_btn'+prov_id).attr('href','#stat_details');

            var link = "{{ asset('admin/report/statdetails') }}";
            link += '/'+muncity+'/'+barangay;
            console.log('link: ' + link);
            $.ajax({
                url: link,
                type: 'GET',
                success: function(data){
                    $('.details_body').html(data);
                }
            });
        } else {
            $('#stat_details').modal('hide');
            $('#details_btn'+prov_id).attr('href','');
        }
    }
</script>
@endsection