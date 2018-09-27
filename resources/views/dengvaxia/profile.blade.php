<?php

?>
@extends('app')
@section('content')
    @include('dengvaxia.sidebar')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">
                <div class="pull-right">
                    <small>Result: <span class="text-danger">{{ number_format($total) }}</span> </small>
                </div>
                Dengvaxia Profiles</h3>
            <div class="clearfix"></div>
            @if(count($profiles))
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-black">
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>1st Dose Date Given</th>
                            <th class="text-center">1st Dose Age</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($profiles as $row)
                        <tr>
                            <td>
                                @if($row->tsekap_id > 0)
                                    <span class="text-bold text-success">
                                        <i class="fa fa-link"></i>
                                    </span>
                                @endif
                                <span class="{{ ($row->tsekap_id>0) ? 'text-success text-bold':'' }}">{{ $row->lname }}, {{ $row->fname }} {{ $row->mname }}</span>
                                <br />
                                <small class="text-danger">
                                    {{ $row->barangay }}, {{ $row->muncity }}, {{ $row->province }}
                                </small>
                            </td>
                            <td>{{ \App\Http\Controllers\ParameterCtrl::getAge($row->dob) }}</td>
                            <td>{{ $row->sex }}</td>
                            <td>{{ date('M d, Y',strtotime($row->dose_date_given)) }}</td>
                            <td class="text-center">{{ $row->dose_age }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr />
                <div class="text-center">
                    {{ $profiles->links() }}
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <span class="text-warning">
                    <i class="fa fa-warning"></i> No profiles found!
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
        <?php if($post->province_id): ?>
        <?php echo 'var tmp = '.$post->province_id.';'; ?>
        <?php echo 'var muncity_id = "'.$post->muncity_id.'";'; ?>
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