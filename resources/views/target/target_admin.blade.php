<?php
use App\Http\Controllers\ReportCtrl as Report;
$user = Auth::user();
?>

@extends('app')
@section('content')
    <div class="col-md-12" style="padding-top: 15px; padding-left: 45px; padding-right: 35px">
        <span> <b style="font-size: 18px">TARGET POPULATION</b>
        </span>
    </div><br><br><br>

    <div class="container">
        <div class="table-responsive" style="background-color: whitesmoke; padding: 5px; width:100%;">
            <table class="table table-bordered table-striped" style="width:100%;">
                <thead class="header">
                <tr class="bg-navy-active">
                    <th class="text-center" style="white-space: nowrap; vertical-align: middle; width:20%;"> Province </th>
                    <th class="text-center" style="vertical-align: middle; width:10%;"> Target (Total)</th>
                    <th class="text-center" style="vertical-align: middle; width:10%;"> Profiled (Total)</th>
                    <th class="text-center" style="white-space:nowrap; vertical-align: middle;"> Municipality </th>
                    <th class="text-center" style="white-space:nowrap; vertical-align: middle;"> Barangay </th>
                    <th class="text-center" style="vertical-align: middle"> Action </th>
                </tr>
                </thead>
                @foreach($data as $row)
                    <tr>
                        <th style="padding-left: 20px">
                            <?php $prov_total = \App\Barangay::select(DB::raw("SUM(target) as target_count"))->where('province_id',$row->id)->first()->target_count;?>
                            <span style="font-size: 15px" class="text-success">{{ strtoupper($row->description) }}</span>
                        </th>
                        <th class="text-center text-info" style="font-size: 15px">
                            {{ number_format($prov_total) }}
                        </th>
                        <th class="text-center text-info" style="font-size: 15px">
                            <?php $profile = Report::getProfile('province',$row->id);?>
                            {{ number_format($profile) }}
                            </th>
                            <form action="{{ asset('target/generateDownload') }}" method="POST">
                                <input type="hidden" value="{{ $row->id }}" name="province_id">
                                {{ csrf_field() }}
                            <td style="padding-left: 15px; padding-right: 15px; font-size: 12px">
                                <select class="form-control select2 select_muncity" style="width:100%;" name="mun_id">
                                    <option value="">Select municipality...</option>
                                    <?php $muncity = \App\Http\Controllers\TargetCtrl::getMuncity($row->id);?>
                                    @foreach($muncity as $mun)
                                        <option value="{{ $mun->id }}"> {{ $mun->description }} </option>
                                    @endforeach
                                </select><br>
                                <input type="hidden" id="tmpMuncity{{$row->id}}">
                                <b style="color: darkgreen"> Target: </b><input type="text" id="mun_target{{$row->id}}" style="width:60%; border-color: transparent;" disabled><br>
                                <b style="color: darkgreen"> Profiled: </b><input type="text" id="mun_profiled{{$row->id}}" style="width:60%; border-color: transparent" disabled>
                            </td>
                            <td style="padding-left: 15px; padding-right: 15px; font-size: 12px">
                                <select class="form-control select2" id="bar_select{{$row->id}}" name="bar_id">
                                    <option value="">Select barangay...</option>
                                </select><br>
                                <b style="color: darkgreen"> Target: </b><input type="text" id="bar_target{{$row->id}}" style="width:60%; border-color: transparent;" disabled><br>
                                <b style="color: darkgreen"> Profiled: </b><input type="text" id="bar_profiled{{$row->id}}" style="width:60%; border-color: transparent" disabled>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-download"></i> Download
                                </button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </table>
        </div><br>
    </div>

@endsection

@section('js')
    <script>
        $('.table-fixed-header').fixedHeader();
        $(".select2").select2({ width: '100%' });
        /*  _________________________
        *   |  NOTIFICATION MESSAGE |
        *   -------------------------
        */
        @if(Session::get('target_notif'))
        Lobibox.notify('success', {
            title: "",
            msg: "<?php echo Session::get("target_msg"); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
        Session::put("target_notif",false);
        Session::put("target_msg",false)
        ?>
        @endif

        function numberFormat(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        /*  _________________
        *   |  SET BARANGAY |
        *   -----------------
        */
        $('.select_muncity').on('change', function() {
           muncity_id = $(this).val();
           var url = "{{ asset('population/target/getMuncityTotal') }}";
           $.ajax({
               url: url+'/'+muncity_id,
               type: 'GET',
               success: function(data){
                   index = data.prov;
                   tmp = $('#tmpMuncity'+index).val();
                   $('#tmpMuncity'+index).val(muncity_id);
                   $('#mun_target'+index).val(numberFormat(data.mun_target));
                   $('#mun_profiled'+index).val(numberFormat(data.mun_profiled));

                   $('#bar_select'+index).empty()
                       .append($('<option>', {
                           value: '',
                           text : 'Select Barangay...'
                           }
                       ));
                   $('#bar_target'+index).val('');
                   $('#bar_profiled'+index).val('');
                   jQuery.each(data.barangay, function(i,val){
                       $('#bar_select'+index).append($('<option>', {
                           value: val.id,
                           text : val.description
                       }));
                   });
                   $('#bar_select'+index).trigger('change');
               }
           });
        });

        $('#bar_select1, #bar_select2, #bar_select3, #bar_select4').on('change', function() {
            var url = "{{ asset('population/target/getBrgyTotal') }}";
            $.ajax({
                url: url+'/'+($(this).val()),
                type: 'GET',
                success: function(data){
                    $('#bar_target'+data.prov).val(data.bar_target);
                    $('#bar_profiled'+data.prov).val(data.bar_profiled);
                }
            });
        });

    </script>
@endsection