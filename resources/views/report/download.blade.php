@extends('app')
@section('content')
    @include('report.sidebar2')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Status Report</h3>
            <div class="clearfix"></div>
            <div class="table-responsive">
                @if(count($data))
                <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                    <thead>
                        <tr>
                            <th>BARANGAY NAME</th>
                            <th>PROFILE DATA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td class="title-info">{{ $row->description }}</td>
                            <td class="text-bold text-success">
                                <a href="{{ asset('download/'.$row->id) }}" target="_blank">
                                    <i class="fa fa-file-excel-o"></i> {{ date('Y') }}_{{ strtolower($row->description) }}_{{ str_pad($row->id, 4, '0', STR_PAD_LEFT) }}.DOH7
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="alert alert-warning">
                        <font class="text-warning">
                            <i class="fa fa-warning"></i> Please select Province and Municipality / City!
                        </font>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.loading').show();

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
            $('.filterMuncity').html('<option value="">Select Municipality / City</option>').trigger('change');
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
                        $('.filterMuncity').append(content).trigger('change');
                        if(muncity_id>0){
                            $('.filterMuncity').val(muncity_id).trigger('change');
                        }else{
                            $('.filterMuncity').val('').trigger('change');
                        }
                        $('.loading').hide();
                    }
                });
            }
        }
    </script>
@endsection