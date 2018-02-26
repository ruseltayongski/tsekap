<?php
$date = Session::get('currentDate') ? Session::get('currentDate') : date('M d, Y');
use App\Service;
use App\Cases;
use App\Profile;
use App\Http\Controllers\ClientCtrl as Ctrl;
$cases = \App\Cases::get();
?>
@extends('client')
@section('content')
    @include('sidebarServices')
    <style>
        label {
            cursor: pointer;
        }
        .nav-tabs>li>a {
            border-radius: 0px !important;
            font-weight: bold;
        }
        .tab-pane {
            padding-top:20px;
        }
    </style>
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Services Availed
                @if($bracket)
                    <?php $user = Profile::find($id); ?>
                    <small>[Name: {{ $user->fname }} {{ $user->mname }} {{ $user->lname }} {{ $user->suffix }} | Age: {{ $bracket['age'] }}]</small>
                @endif
            </h2>
            <div class="services">
                @if($bracket)
                <div class="col-sm-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Services</a></li>
                        <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <br />
                            <form class="form-inline form-submit" method="POST" action="{{ asset('user/services/save') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="date" id="date" value="{{ $date }}" />
                                <input type="hidden" name="profileID" value="{{ $id }}" />
                                <input type="hidden" name="brgy_id" value="{{ $bracket['brgy_id'] }}" />
                                <input type="hidden" name="bracket_id" value="{{ $bracket['bracket_id'] }}" />

                                <?php
                                //$gender = Profile::find($id)->sex;
                                ?>
                                @if(!$id)
                                    <div class="list_services">
                                        <div class="alert alert-warning">
                                            <p class="text-danger">Please select date and profile!</p>
                                        </div>
                                    </div>
                                @elseif(!$user->sex)
                                    <div class="alert alert-danger">
                                        <p class="text-danger">Please specify the gender of this profile!</p>
                                        <p>
                                            <a href="{{ asset('user/services/updategender/Male/'.$id) }}" class="btn btn-info btn-sm">Male</a> or
                                            <a href="{{ asset('user/services/updategender/Female/'.$id) }}" class="btn btn-warning btn-sm">Female</a>
                                        </p>
                                    </div>
                                @else
                                    <div class="col-sm-6">
                                        <?php $bracket_id = $bracket['bracket_id']; ?>
                                        @if(($bracket_id==5 || $bracket_id == 6) && $user->sex=='Female')
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="radio" name="femalestatus" value="pregnant" required />
                                                        Pregnant
                                                    </label>
                                                </li>
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="radio" name="femalestatus" value="post" required />
                                                        Post Partum
                                                    </label>
                                                </li>
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="radio" name="femalestatus" value="non" required />
                                                        Non-Pregnant
                                                    </label>
                                                </li>
                                            </ul>
                                        @endif
                                        <ul class="list-group">
                                            @if(Ctrl::validateService($bracket_id,'PE'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" data-code="PE" name="services[]" value="{{ Service::where('code','PE')->first()->id }}" />
                                                        {{ Service::where('code','PE')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'BP'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" data-code="BP" name="services[]" value="{{ Service::where('code','BP')->first()->id }}" />
                                                        {{ Service::where('code','BP')->first()->description }}
                                                    </label>
                                                    <br />
                                                    <div class="col-xs-offset-1 bp_option hide">
                                                        <label>
                                                            <input checked type="radio" name="bp" value="0" />
                                                            Normal
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="bp" value="1" />
                                                            Hypertensive
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="bp" value="2" />
                                                            Hypotensive
                                                        </label>
                                                    </div>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'WM'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" data-code="WM" name="services[]" value="{{ Service::where('code','WM')->first()->id }}" />
                                                        {{ Service::where('code','WM')->first()->description }}
                                                    </label>
                                                    <br />
                                                    <div class="col-xs-offset-1 weight_option hide">
                                                        <label>
                                                            <input type="radio" checked name="weight" value="0" />
                                                            Normal
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="weight" value="1" />
                                                            Obese
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="weight" value="2" />
                                                            Undernutrition
                                                        </label>
                                                    </div>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'HM'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" data-code="HM" name="services[]" value="{{ Service::where('code','HM')->first()->id }}" />
                                                        {{ Service::where('code','HM')->first()->description }}
                                                    </label>
                                                    <br />
                                                    <div class="col-xs-offset-1 height_option hide">
                                                        <label>
                                                            <input type="radio" checked name="height" value="0" />
                                                            Normal
                                                        </label><br />
                                                        <label>
                                                            <input type="radio" name="height" value="1" />
                                                            Stunted
                                                        </label>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>

                                        <ul class="list-group">
                                            <li class="list-group-item active">LABORATORY SERVICES</li>
                                            @if(Ctrl::validateService($bracket_id,'BT'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','BT')->first()->id }}" />
                                                        {{ Service::where('code','BT')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'CBC'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','CBC')->first()->id }}" />
                                                        {{ Service::where('code','CBC')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'URI'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','URI')->first()->id }}" />
                                                        {{ Service::where('code','URI')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'FBS'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','FBS')->first()->id }}" />
                                                        {{ Service::where('code','FBS')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'BST'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','BST')->first()->id }}" />
                                                        {{ Service::where('code','BST')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'SE'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','SE')->first()->id }}" />
                                                        {{ Service::where('code','SE')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'RBS'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','RBS')->first()->id }}" />
                                                        {{ Service::where('code','RBS')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'SPE'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','SPE')->first()->id }}" />
                                                        {{ Service::where('code','SPE')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                        </ul>

                                        <ul class="list-group">
                                            @if(Ctrl::validateService($bracket_id,'HEPS'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','HEPS')->first()->id }}" />
                                                        {{ Service::where('code','HEPS')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                        </ul>

                                        <ul class="list-group">
                                            <li class="list-group-item active">OTHER SERVICES</li>
                                            @if(Ctrl::validateService($bracket_id,'EE'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','EE')->first()->id }}" />
                                                        {{ Service::where('code','EE')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'ERE'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','ERE')->first()->id }}" />
                                                        {{ Service::where('code','ERE')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                            @if(Ctrl::validateService($bracket_id,'OS'))
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','OS')->first()->id }}" />
                                                        {{ Service::where('code','OS')->first()->description }}
                                                    </label>
                                                </li>
                                            @endif
                                        </ul>
                                        @if($bracket_id==6 || $bracket_id==5)
                                            <ul class="list-group">
                                                <li class="list-group-item active">FAMILY PLANNING</li>
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','WUN')->first()->id }}" />
                                                        {{ Service::where('code','WUN')->first()->description }}
                                                    </label>
                                                </li>
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','CNL')->first()->id }}" />
                                                        {{ Service::where('code','CNL')->first()->description }}
                                                    </label>
                                                </li>
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="services[]" value="{{ Service::where('code','CMD')->first()->id }}" />
                                                        {{ Service::where('code','CMD')->first()->description }}
                                                    </label>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="list-group">
                                            <li class="list-group-item active">DIAGNOSES</li>
                                            @foreach($cases as $c)
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" name="cases[]" value="{{ $c->id }}" />
                                                        {{ $c->description }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>

                                        @if($bracket_id >= 5)
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
                                        @endif
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr />
                                    <button type="submit" class="btn-submit btn btn-success btn-lg"><i class="fa fa-send"></i> Submit</button>
                                @endif
                            </form>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="history">
                            @if(count($recordS))
                            <table class="table table-hover table-striped table-bordered" style="margin-top:20px;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th width="50%">Services Availed</th>
                                        <th>Date Availed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($recordS as $record)
                                <tr>
                                    <td>{{ $record['service'] }}</td>
                                    <td>{{ $record['date'] }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif

                            @if(count($recordC))
                                <table class="table table-hover table-striped table-bordered">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th width="50%">Diagnoses</th>
                                        <th>Date Checked / Diagnosed</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recordC as $record)
                                        <tr>
                                            <td>{{ $record['case'] }}</td>
                                            <td>{{ $record['date'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!count($recordS) && !count($recordC))
                                <div class="alert alert-warning">
                                    <p class="text-danger">Patient has no record!</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="clearfix"></div>

                @else
                    <div class="alert alert-warning">
                        <p class="text-danger">Please select date and profile!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('client.modal')
@endsection

@section('js')
    @include('client.servicejs')
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
@endsection