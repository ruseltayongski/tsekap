<?php
use App\Http\Controllers\ParameterCtrl as Param;
use App\FamilyProfile;
?>
@extends('client')
@section('content')
    <style>
        .family {
            font-size: 0.9em;
        }
        .family label {
            font-weight: bold;
        }
        .family .info {
            color: #337ab7;
        }
        .family .sub-info {
            font-style: italic;
            color: #a94442;
        }
        .cursor{
            cursor: pointer;
        }
    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Manage Children Head <i><small class="text-yellow">below 18 years old</small></i></h2>
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
                    <form class="form-inline" method="POST" action="{{ asset('duplicate/population') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <?php $tmp = Session::get('profileKeyword');?>
                            <input type="text" class="form-control" placeholder="Quick Search" name="keyword" value="{{ $tmp['keyword'] }}" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default col-xs-12"><i class="fa fa-search"></i> Search</button>
                            <div class="clearfix"></div>
                        </div>
                        @if(Session::get('profileKeyword'))
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning col-xs-12" name="viewAll" value="true"><i class="fa fa-search"></i> View All</button>
                                <div class="clearfix"></div>
                            </div>
                        @endif
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
                            <th>Family ID</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Suffix</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Barangay</th>
                            <th>Head</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profiles as $p)
                            <tr>
                                <td>
                                    <a href="#familyProfile" data-backdrop="static" data-id="{{ $p->familyID }}" data-toggle="modal" class="title-info">
                                        {{ $p->familyID }}
                                    </a>
                                </td>
                                <td class="<?php if($p->head=='YES') echo 'text-bold text-primary';?>">{{ $p->fname }}</td>
                                <td class="<?php if($p->head=='YES') echo 'text-bold text-primary';?>">{{ $p->mname }}</td>
                                <td class="<?php if($p->head=='YES') echo 'text-bold text-primary';?>">{{ $p->lname }}</td>
                                <td class="<?php if($p->head=='YES') echo 'text-bold text-primary';?>">{{ $p->suffix }}</td>
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
                                <td>{{ \App\Barangay::find($p->barangay_id)->description }}</td>
                                <td>{{ $p->head }}</td>
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
    @include('modal.populationModal')
@endsection

@section('js')
    @include('script.population')



@endsection