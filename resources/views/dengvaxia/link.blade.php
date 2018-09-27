<?php

?>
@extends('app')
@section('content')
    @include('dengvaxia.sidebar')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">{{ $title }}</h3>
            <div class="clearfix"></div>
            @if(count($barangay) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-black">
                        <tr>
                            <th width="25%">Barangay Name</th>
                            <th>Status Bar</th>
                            <th width="15%">Link</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($barangay as $row)
                        <tr>
                            <td>{{ $row->description }}</td>
                            <td>
                                <div class="progress" style="margin-bottom: 0px;">
                                    <div class="progress-{{ $row->id }} progress-bar progress-bar-bg {{ ($row->dengvaxia_link==0) ? 'progress-bar-striped progress-bar-animated':'' }}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($row->dengvaxia_link==0) ? '0':'100' }}%">{{ ($row->dengvaxia_link==0) ? '0':'Complete' }}</div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-block btn-xs {{ ($row->dengvaxia_link==0) ? 'btn-linked':'' }}" data-id="{{ $row->id }}" {{ ($row->dengvaxia_link!=0) ? 'disabled':'' }}>
                                    <i class="fa fa-link"></i> Link Profiles
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning">
                <span class="text-warning">
                    <i class="fa fa-warning"></i> Please select Province and Municipality/City!
                </span>
                </div>
            @endif
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
        <?php if(isset($post->province_id)): ?>
        var tmp = "{{ $post->province_id }}";
        var muncity_id = "{{ $post->muncity_id}}";

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


    <script>
        var totalAve = 0;
        var ave = 0;
        var titleAve = 0;
        $('body').on('click','.btn-linked',function(){
            //$('.btn-linked').attr('disabled',true);
            var id = $(this).data('id');
            var url = "{{ url('dengvaxia/count/') }}/"+id;
            var bar = '.progress-'+id;
            var offset = 0;
            var add = 0;
            var btn = $(this);
            btn.html('<i class="fa fa-refresh fa-spin"></i> Linking...').attr('disabled',true);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(total){
                    totalAve += parseInt(total);
                    if(total==0)
                    {
                        $(bar).css('width','100%');
                        $(bar).removeClass('progress-bar-animated');
                        $(bar).removeClass('progress-bar-striped');
                        $(bar).addClass('progress-bar-success');
                        $(bar).html('No Dengvaxia Profiles');
                    }else{
                        sendData();
                    }

                    function readAndSend()
                    {
                        if(offset>=total)
                        {
                            setTimeout(function () {
                                $(bar).html('100%');
                                $(bar).css('width','100%');
                                if(titleAve>=totalAve){
                                    $(document).attr("title", '100% - Linking Profile...');
                                }

                            },1000);

                            setTimeout(function () {
                                $(bar).css('width','100%');
                                $(bar).removeClass('progress-bar-animated');
                                $(bar).removeClass('progress-bar-striped');
                                $(bar).addClass('progress-bar-primary');
                                $(bar).html('Complete');
                                if(titleAve>=totalAve){
                                    $(document).attr("title", 'Complete');
                                }

                                var finish = "{{ url('dengvaxia/finish') }}/"+id;
                                $.get(finish);
                                btn.html('<i class="fa fa-link"></i> Link Profiles');
                                //$('.btn-linked').attr('disabled',false);
                                btn.attr('disabled',true).removeClass('btn-linked');
                            },2000);
                        }else{
                            setTimeout(sendData,1000);
                        }
                    }

                    function sendData()
                    {

                        add = Math.round((offset/total)*100);
                        titleAve = Math.round((ave/totalAve)*100);
                        $(bar).html(add+'%');
                        $(bar).css('width',add+'%');
                        console.log(titleAve+'-'+totalAve);
                        $(document).attr("title", titleAve+'% - Linking Profile...');
                        var link = "{{ url('dengvaxia/link/') }}/"+id+"/"+offset;
                        $.ajax({
                            url: link,
                            type: "GET",
                            success: function(data)
                            {
                                offset += 10;
                                ave += 10;
                                readAndSend();
                            },
                            error: function () {
                                alert('Error send data!')
                            }
                        });

                    }
                },
                error: function(){
                    alert('Error fetching data!')
                }
            });
        });
    </script>
@endsection