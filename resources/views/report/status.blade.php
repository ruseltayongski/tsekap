<?php
    use App\Http\Controllers\ReportCtrl as Report;
    $totalTarget = 0;
    $totalProfile = 0;
    $totalValid = 0;
    $totalProfilePer = 0;
    $totalValidPer = 0;
    $c = 0;
?>
@extends('app')
@section('content')
    @include('report.sidebar')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Status Report</h3>
            <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                        <tr>
                            <th class="bg-primary">{{ $title }}</th>
                            <th class="bg-primary">Target</th>
                            <th class="bg-primary">Population<br/>Profiled</th>
                            <th class="bg-primary">(%)</th>
                            <th>Municipality</th>
                        </tr>
                            @foreach($sub as $s)
                            <?php
                                $c++;
                                $target = $s->target;
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
                                <td>{{ $s->description }}</td>
                                <td>{{ number_format($target) }}</td>
                                <td>{{ number_format($profile) }}</td>
                                <td class="bg-{{$class}}">{{ number_format($profilePercentage,1) }}%</td>
                                <td>
                                    @foreach(\App\Muncity::where('province_id','=',$s->id)->get() as $row)
                                        <form action="{{ asset('ExportExcelBarangay') }}" method="POST" target="_blank">
                                            <input type="hidden" value="{{ $row->id }}" name="muncity_id">
                                            <input type="hidden" value="{{ $row->province_id }}" name="province_id">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-download"></i> {{ $row->description }}
                                            </button>
                                        </form>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
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
</script>
@endsection