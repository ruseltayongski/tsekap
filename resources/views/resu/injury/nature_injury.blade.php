@extends('resu/app1')
@section('content')

    @if($user_priv->user_priv == 10)
        @include('resu.injury.sidebar1')

            <div class="col-md-9 wrapper">
                <div class="alert alert-jim">
                    <h2 class="page-header">Injury</h2>

                    <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                                <thead>
                                <tr>
                                    <th>Nature Injury Name</th>  
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($injured as $injury)
                                    <tr>
                                        <td>
                                            <font class="text-success text-bold">{{ $injury->name }}</font>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                
                
                </div>
            </div>
    @elseif($user_priv->user_priv == 11)
       
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Manage Patient Injury {{ $not_updated  ? '(NOT UPDATED)' : ""}}</h2>
            @if(Session::has('deng_add'))
                <div class="alert alert-success">
                    <font class="text-success">
                        <i class="fa fa-check"></i> {!! Session::get('deng_add') !!}
                    </font>
                </div>
            @endif
            @if(Session::has('crossMatch'))
                <div class="alert alert-success">
                    <font class="text-success">
                        <i class="fa fa-check"></i> {!! Session::get('crossMatch') !!}
                    </font>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <form class="form-inline" method="POST" action="{{ asset('user/population') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <?php $tmp = Session::get('profileKeyword');?>
                            <input type="text" class="form-control" placeholder="Quick Search" name="keyword" value="{{ $tmp['keyword'] }}" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>
                            <div class="clearfix"></div>
                        </div>
                        @if(Session::get('profileKeyword') || Session::get('view_not_updated'))
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning col-xs-12" name="viewAll" value="true"><i class="fa fa-search"></i> View All</button>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                        @if(!$not_updated)
                            <div class="form-group">
                                <button class="btn btn-warning col-xs-12" name="viewNotUpdated" value="true"><i class="fa fa-search"></i>{{ $not_updated }} View Not Updated</button>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                        <div class="form-group">
                            <a class="btn btn-info col-xs-12" href="{{ asset('user/population/head') }}"><i class="fa fa-user-plus"></i> Add Patient Injury</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-success col-xs-12" href="#filterResult" data-toggle="modal"><i class="fa fa-filter"></i> Filter Result</a>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="table-responsive">
                @if(count($profiles))
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Family ID<br>&nbsp;</th>
                            <th>Full Name<br>&nbsp;</th>
                            <th>Age<br>&nbsp;</th>
                            <th>Sex<br>&nbsp;</th>
                            <th>Barangay<br>&nbsp;</th>
                            {{--<th class="text-center">--}}
                                {{--Sitio<br>--}}
                                {{--<small class="text-info">(Update by family)</small>--}}
                            {{--</th>--}}
                            {{--<th class="text-center">--}}
                                {{--Purok<br>--}}
                                {{--<small class="text-warning">(Update by family)</small>--}}
                            {{--</th>--}}
                            {{--<th class="text-center">Harmonized<br>&nbsp;</th>--}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profiles as $p)
                        <tr>
                            <td nowrap="TRUE">
                                <a href="{{ asset('user/population/info/'.$p->id) }}" class="btn btn-xs btn-success">
                                    <i class="fa fa-eye"></i> View
                                </a>
                                <a href="{{ asset('user/population/add/' . $p->familyID) }}" class="btn btn-xs btn-info">
                                    <i class="fa fa-user-plus"></i> Add Member
                                </a>
                                <!--
                                <a href="#dengvaxia" data-backdrop="static" data-id="{{ $p->id }}" data-unique="{{ $p->unique_id }}" class="btn btn-xs btn-danger"  data-toggle="modal">
                                    <i class="fa fa-user-md"></i> Dengvaxia
                                </a>
                                -->
                            </td>
                            <td>
                                <a href="#familyProfile" data-backdrop="static" data-id="{{ $p->familyID }}" data-toggle="modal" class="title-info">
                                    {{ $p->familyID }}
                                </a>
                            </td>
                            <td class="<?php if($p->head=='YES') echo 'text-bold text-primary';?>">{{ $p->fname.' '.$p->mname.' '.$p->lname.' '.$p->suffix }}</td>
                            <td>
                                <?php
                                    $age = Param::getAge($p->dob);
                                    $tmp = '';
                                ?>
                                @if($age==0)
                                    <?php
                                        $age = Param::getAgeMonth($p->dob);
                                        $tmp = 'M/o';
                                    ?>
                                    @if($age==0)
                                    <?php
                                        $age = Param::getAgeDay($p->dob);
                                        $tmp = 'D/o';
                                    ?>
                                    @endif
                                @endif

                                @if($tmp)
                                    <small class="text-info">({{$age}} {{$tmp}})</small>
                                @else
                                    {{ $age }}
                                @endif
                            </td>
                            <td>{{ $p->sex }}</td>
                            <?php $bar_desc = \App\Http\Controllers\LocationCtrl::getBarangay($p->barangay_id);?>
                            <td>{{ $bar_desc }}</td>
                            {{--<td>--}}
                                {{--<small class="text-info cursor" onclick="selectSitio('{{ $p->familyID }}','{{ $p->barangay_id }}')"><i class="fa fa-institution"></i>--}}
                                    {{--@if($p->sitio_id)--}}
                                        {{--<b>{{ \App\Sitio::find($p->sitio_id)->sitio_name }}</b>--}}
                                    {{--@else--}}
                                        {{--Update--}}
                                    {{--@endif--}}
                                {{--</small>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--<small class="text-warning cursor" onclick="selectPurok('{{ $p->familyID }}','{{ $p->barangay_id }}')"><i class="fa fa-building"></i>--}}
                                    {{--@if($p->purok_id)--}}
                                        {{--<b>{{ \App\Purok::find($p->purok_id)->purok_name }}</b>--}}
                                    {{--@else--}}
                                        {{--Update--}}
                                    {{--@endif--}}
                                {{--</small>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--@if($p->dengvaxia == 'yes')--}}
                                    {{--<small class="text-blue"><i class="fa fa-user"></i> Dengvaxia</small><br>--}}
                                    {{--<!----}}
                                    {{--<small class="text-green"><i class="fa fa-users"></i> Bhert</small><br>--}}
                                    {{--<small class="text-yellow"><i class="fa fa-users"></i> E - Referral</small><br>--}}
                                    {{--<small class="text-purple"><i class="fa fa-users"></i> IHOMIS</small><br>--}}
                                    {{---->--}}
                                    {{--<small class="text-danger cursor" href="#select_harmonized" data-toggle="modal" onclick="setSession({{ $p->id }})"><i class="fa fa-plus"></i> Add</small>--}}
                                {{--@else--}}
                                    {{--<small class="text-danger cursor" href="#select_harmonized" data-toggle="modal" onclick="setSession({{ $p->id }})"><i class="fa fa-plus"></i> Add</small>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $profiles->links() }}
                </div>
                @else
                <div class="alert alert-info">
                    <p class="text-info"><i class="fa fa-info-circle fa-lg text-bold"></i> No data found!</p>
                </div>
                @endif
            </div>
        </div>
    </div>    


    @endif

@endsection
