<?php
use App\Http\Controllers\LocationCtrl as Location;
use App\Barangay;
use App\UserBrgy;
?>
@extends('app')
@section('content')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header"><a href="{{ asset('users') }}" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Back</a> Assigned Barangay</h2>
            <div class="clearfix"></div>
            @if(count($barangay))
                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                        <thead>
                        <tr>
                            <th>Barangay</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($barangay as $row)
                        <tr>
                            <td>
                                {{ $row->description }}
                            </td>
                            <td>
                                <?php $assign = UserBrgy::where('user_id',$user_id)->where('barangay_id',$row->id)->count(); ?>
                                @if($assign > 0)
                                    <a href="#" class="btn btn-default btn-sm">Assigned</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning">
                    <strong><i class="fa fa-warning fa-lg"></i> No data found! </strong>
                </div>
            @endif
        </div>
    </div>
    @include('sidebar')
@endsection

@section('js')


@endsection