<?php
use App\Http\Controllers\ParameterCtrl as Param;
use App\FamilyProfile;
?>
@extends('app')
@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Lacking 3 MUST Services (PE, Laboratory and Other Services)</h2>
            <form class="form-inline" method="POST" action="{{ asset('population/less') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Quick Search" name="keyword" value="{{ Session::get('lessKeyword') }}" autofocus>
                </div>
                <div class="form-group">
                    <select name="province" class="filterProvince form-control chosen-select-static">
                        @if(Auth::user()->user_priv==1)
                            <?php $provinces = App\Province::get(); ?>
                            <option value="">Select Province...</option>
                            @foreach($provinces as $p)
                                <option @if(Session::get('lessProvince')==$p->id) selected @endif value="{{ $p->id }}">{{ $p->description }}</option>
                            @endforeach
                        @else
                            <option value="{{ Auth::user()->province }}">{{ App\Province::find(Auth::user()->province)->description }}</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" id="tmpMuncity" value="{{ Session::get('lessMuncity') }}" />
                    <select name="muncity" class="filterMuncity form-control chosen-select-static">
                        <option value="">Select Municipal/City</option>

                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>
                    <div class="clearfix"></div>
                </div>
                @if(Session::get('lessKeyword'))
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning col-xs-12" name="viewAll" value="true"><i class="fa fa-search"></i> View All</button>
                        <div class="clearfix"></div>
                    </div>
                @endif
            </form>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="table-responsive">
                @if(count($profiles))
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Services Availed</th>
                            <th>Family ID</th>
                            <th>Complete Name</th>
                            <th>DOB</th>
                            <th>Sex</th>
                            <th>Barangay</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profiles as $p)
                            <tr>
                                <td>
                                    <a href="#showServices" data-backdrop="static" data-toggle="modal" data-id="{{ $p->unique_id }}" class="btn btn-xs btn-success">
                                        <?php $count = Param::countServicesAvailed($p->unique_id); ?>
                                        <i class="fa fa-stethoscope"></i> {{ $count }} Service<?php if($count>1) echo 's'; ?> Availed
                                    </a>

                                </td>
                                <td>
                                    <a href="#familyProfile" data-backdrop="static" data-id="{{ $p->familyID }}" data-toggle="modal" class="title-info">
                                        {{ $p->familyID }}
                                    </a>
                                </td>
                                <td class="<?php if($p->head=='YES') echo 'text-bold text-primary';?>">{{ $p->fname }} {{ $p->mname }} {{ $p->lname }} {{ $p->suffix }}</td>
                                <td>
                                    {{ date('M d, Y',strtotime($p->dob)) }}
                                </td>
                                <td>{{ $p->sex }}</td>
                                <td>
                                    {{ \App\Barangay::find($p->barangay_id)->description }},
                                    {{ App\Muncity::find($p->muncity_id)->description }},
                                    {{ App\Province::find($p->province_id)->description }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $profiles->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <p class="text-info"><i class="fa fa-info-circle fa-lg text-bold"></i> You don't have any profiles in your location!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('client.populationModal')
@endsection

@section('js')
    <script>
        $('a[href="#familyProfile"]').on('click',function(){
                    <?php echo 'var url="'.asset('population/profiles').'";';?>
            var id = $(this).data('id');
            $('.family-list').html('<center><img src="<?php echo asset('resources/img/spin.gif');?>" width="100"></center>');
            $.ajax({
                url: url+'/'+id,
                type: 'GET',
                success: function(jim){
                    var content = '<ul class="list-group">';
                    jQuery.each(jim,function(i,val){
                        content += '<li class="list-group-item">';
                        content += val.lname+', '+val.fname+' '+val.mname+' '+val.suffix;
                        content += '<br/><small>('+val.relation+')</small>';
                        content += '</li>';
                    });
                    content += '</ul>';
                    $('.family-list').html(content);
                }
            });

        });

        $('a[href="#showServices"]').on('click',function(){
            <?php echo 'var url="'.asset('population/service').'";';?>
            var id = $(this).data('id');
            $('.service-list').html('<center><img src="<?php echo asset('resources/img/spin.gif');?>" width="100"></center>');
            $.ajax({
                url: url+'/'+id,
                type: 'GET',
                success: function(jim){
                    var content = '<ul class="list-group">';
                    jQuery.each(jim,function(i,val){
                        content += '<li class="list-group-item">';
                        content += val.description;
                        content += '<br/><small>('+val.dateProfile+')</small>';
                        content += '</li>';
                    });
                    content += '</ul>';
                    if(jim.length==0){
                        content = '<div class="alert alert-warning"><font class="text-warning"><i class="fa fa-warning"> No services availed!</font></div>';
                    }
                    $('.service-list').html(content);
                }
            });

        });


    </script>
    <script>
        filterProvince($('.filterProvince').val());
        $('.filterProvince').on('change',function(){
            var id = $(this).val();
            filterProvince(id);
        });

        function filterProvince(id,muncity)
        {
            var muncity = $('#tmpMuncity').val();
            console.log(muncity);
            <?php echo 'var tmp="'.asset('location/muncity').'";';?>
            var url = tmp+'/'+id;

            $('.filterMuncity').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Select Municipal / City..."
                    }));

            $('.filterBarangay').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Select Barangay..."
                    }));
            if(id){
                $('.loading').show();
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        jQuery.each(data, function(i,val){
                            $('.filterMuncity').append($('<option>', {
                                value: val.id,
                                text : val.description,
                                selected : function(){
                                    if(muncity==val.id){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }
                            }));
                            $('.filterMuncity').chosen().trigger('chosen:updated');
                        });
                        setTimeout(function(){
                            $('.loading').hide();
                        },200);
                    }
                });
            }
        }
    </script>
@endsection