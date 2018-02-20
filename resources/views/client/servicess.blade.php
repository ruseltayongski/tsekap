<?php
    $date = Session::get('currentDate') ? Session::get('currentDate') : date('M d, Y');
    use App\Service;
    use App\Cases;
    $cases = \App\Cases::get();
?>
@extends('client')
@section('content')
    @include('sidebarServices')
    <style>
        label {
            cursor: pointer;
        }
    </style>
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Services Availed <small class="btn-age hide"></small> </h2>
            <div class="services">
                <form class="form-inline" method="POST" action="{{ asset('user/services/') }}">
                {{ csrf_field() }}
                <input type="hidden" name="date" id="date" value="{{ $date }}" />
                <input type="hidden" name="profileID" id="profileID" />
                <input type="hidden" name="brgy_id" id="brgy_id" />
                <input type="hidden" name="bracket_id" id="bracket_id" />
                <div class="list_services">
                    <div class="alert alert-warning">
                        <p class="text-danger">Please select date and profile!</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','PE')->first()->id }}" />
                                {{ Service::where('code','PE')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','BP')->first()->id }}" />
                                {{ Service::where('code','BP')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','WM')->first()->id }}" />
                                {{ Service::where('code','WM')->first()->description }}
                            </label>
                            <br />
                            <div class="col-xs-offset-1">
                                <label>
                                    <input type="radio" name="weight" value="" />
                                    Normal
                                </label><br />
                                <label>
                                    <input type="radio" name="weight" value="{{ Service::where('code','OB')->first()->id }}" />
                                    {{ Service::where('code','OB')->first()->description }}
                                </label><br />
                                <label>
                                    <input type="radio" name="weight" value="{{ Service::where('code','UN')->first()->id }}" />
                                    {{ Service::where('code','UN')->first()->description }}
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','HM')->first()->id }}" />
                                {{ Service::where('code','HM')->first()->description }}
                            </label>
                            <br />
                            <div class="col-xs-offset-1">
                                <label>
                                    <input type="radio" name="weight" value="" />
                                    Normal
                                </label><br />
                                <label>
                                    <input type="radio" name="weight" value="{{ Service::where('code','ST')->first()->id }}" />
                                    {{ Service::where('code','ST')->first()->description }}
                                </label>
                            </div>
                        </li>
                    </ul>

                    <ul class="list-group">
                        <li class="list-group-item active">LABORATORY SERVICES</li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','BT')->first()->id }}" />
                                {{ Service::where('code','BT')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','CBC')->first()->id }}" />
                                {{ Service::where('code','CBC')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','URI')->first()->id }}" />
                                {{ Service::where('code','URI')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','FBS')->first()->id }}" />
                                {{ Service::where('code','FBS')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','BST')->first()->id }}" />
                                {{ Service::where('code','BST')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','SE')->first()->id }}" />
                                {{ Service::where('code','SE')->first()->description }}
                            </label>
                        </li>
                    </ul>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','HEPS')->first()->id }}" />
                                {{ Service::where('code','HEPS')->first()->description }}
                            </label>
                        </li>
                    </ul>

                    <ul class="list-group">
                        <li class="list-group-item active">OTHER SERVICES</li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','EE')->first()->id }}" />
                                {{ Service::where('code','EE')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','ERE')->first()->id }}" />
                                {{ Service::where('code','ERE')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','OS')->first()->id }}" />
                                {{ Service::where('code','OS')->first()->description }}
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <ul class="list-group">
                        <li class="list-group-item active">CASES REFERRED</li>
                        @foreach($cases as $c)
                            <li class="list-group-item">
                                <label>
                                    <input type="checkbox" name="cases[]" value="{{ $c->id }}" />
                                    {{ $c->description }}
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    <ul class="list-group">
                        <li class="list-group-item active">DRUG REHABILITATION SERVICES</li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','SC')->first()->id }}" />
                                {{ Service::where('code','SC')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','CNS')->first()->id }}" />
                                {{ Service::where('code','CNS')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','DT')->first()->id }}" />
                                {{ Service::where('code','DT')->first()->description }}
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ Service::where('code','RR')->first()->id }}" />
                                {{ Service::where('code','RR')->first()->description }}
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <hr />
                <button type="button" class="btn btn-success btn-lg"><i class="fa fa-send"></i> Submit</button>
                </form>
            </div>
        </div>
    </div>
    @include('client.modal')
@endsection

@section('js')
    <?php
    $status = session('status');
    ?>
    @if($status=='added')
        <script>
            Lobibox.notify('success', {
                msg: 'Added successfully!'
            });
        </script>
    @endif
    <script>
        $('.chosen-select-service').chosen();

        var select = $('.chosen-select-service').on('change',function(){

        });

        $('.btn-select').on('click',function(){
            var select = $('select[name="profile"]');
            <?php echo 'var url = "'.asset('user/services').'";';?>
            if(select.val())
            {
                $('.loading').show();
                select.siblings('.select2-container').css({border:'none'});
                $.ajax({
                    url: url+'/'+select.val(),
                    type: "GET",
                    success: function(jim){
                        $('.loading').hide();
                        var content = '';
                        console.log(jim);
                        jQuery.each(jim.services,function(i,val){
                            content += '<label class="col-sm-3" style="margin:5px;cursor: pointer;">';
                            content += '<input type="checkbox" value="'+val.id+'" name="services[]"> ';
                            content += '<strong>' + val.description + '</strong>';
                            content += '</label>';
                        });
                        content += '<div class="clearfix"></div><hr />';
                        content += '<button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Submit</button>';
                        $('.list_services').html(content);
                        $('.btn-age').removeClass('hide').html('<strong>[ Age: '+jim.age+' ]</strong>');
                        $('#profileID').val(jim.id);
                        $('#brgy_id').val(jim.brgy_id);
                        $('#bracket_id').val(jim.bracket_id);

                        if(jim.services.length == 0){
                            $('.list_services').html('<div class="alert alert-warning"><p class="text-danger"> No services in this age bracket!</p></div>');
                        }
                    }
                });
            }else{
                select.siblings('.select2-container').css({border:'2px solid red'});
                $('.list_services').html('<div class="alert alert-warning">Please select date and profile!</div>');
            }
        });
        <?php echo 'var link="'.asset('user/profiles/all').'";';?>
        $(".select-profile").select2({
            ajax: {
                url: link,
                dataType: 'json',
                delay: 100,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatProfile, // omitted for brevity, see the source of this page
            templateSelection: formatProfileSelection, // omitted for brevity, see the source of this page

        });

        function formatProfile(profile) {
            if (profile.loading) return profile.text;
            var html = '<div><strong>'+profile.description+'</strong> - <small>('+profile.full_name+')</small></div>';
            return html;
        }

        function formatProfileSelection(profile) {
            return profile.full_name || profile.text;
        }
        $('.filter_familyProfile').on('change',function(){
            if($(this).val()=== 'others'){
                $('.others').removeClass('hide').fadeIn();
            } else {
                $('.others').addClass('hide');
            }
        });

    </script>
@endsection