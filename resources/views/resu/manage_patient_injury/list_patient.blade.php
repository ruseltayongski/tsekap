@extends('resu/app1')
@section('content')

    @if($user_priv->user_priv == 11)
       
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
                               <a class="btn btn-info col-xs-12" href="{{ url('patient-form') }}"><i class="fa fa-user-plus"></i> Add Patient Injury</a>
                               <div class="clearfix"></div>
                           </div>
                           <!-- <div class="form-group">
                               <a class="btn btn-success col-xs-12" href="#filterResult" data-toggle="modal"><i class="fa fa-filter"></i> Filter Result</a>
                               <div class="clearfix"></div>
                           </div> -->
                       </form>
                   </div>
               </div>
   
               <div class="clearfix"></div>
               <div class="page-divider"></div>
               <div class="table-responsive">
               
                   <table class="table table-hover table-striped">
                       <thead>
                           <tr>
                               <th></th>
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
                        
                           <tr>
                               <td nowrap="TRUE">
                                   <a href="{{ asset('user/population/info/'.$p->id) }}" class="btn btn-xs btn-success">
                                       <i class="fa fa-eye"></i> View
                                   </a>
                               </td>
                               <td class="<?php if($p->head=='YES') echo 'text-bold text-primary';?>">jondy D. Magsayon jr. {{ $p->fname.' '.$p->mname.' '.$p->lname.' '.$p->suffix }}</td>
                               <td>
                                   28
                               </td>
                               <td>male</td>
                               <?php $bar_desc = \App\Http\Controllers\LocationCtrl::getBarangay($p->barangay_id);?>
                               <td>Sambag 1</td>
                           </tr>
                   
                       </tbody>
                   </table>
                   <div class="text-center">
                       <!-- set the pagination here -->
                   </div>
                 
                   <!-- <div class="alert alert-info">
                       <p class="text-info"><i class="fa fa-info-circle fa-lg text-bold"></i> No data found!</p>
                   </div> -->
                  
               </div>
           </div>
       </div>    
    @endif

@endsection