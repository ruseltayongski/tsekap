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
            <h2 class="page-header">Manage Profile Pending</h2>
            <div class="row">
                <div class="col-md-8">
                    <form class="form-inline" method="POST" action="{{ asset('profile_pending') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Quick Search" name="profile_pending_keyword" value="{{ Session::get('profile_pending_keyword') }}" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                            <div class="clearfix"></div>
                        </div>
                        @if(Session::get('purok_keyword'))
                            <div class="form-group">
                                <button type="button" name="view_all" value="true" class="btn btn-warning"><i class="fa fa-eye"></i> View All</button>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="alert alert-warning">
                        <label for="" class="text-blue">NOTE:</label>
                        <ul>
                            <li ><span class="badge bg-red">RED TEXT MEANS LATEST DATA</span></li>
                            <li ><span class="badge bg-green">GREEN TEXT MEANS PREVIOUS DATA</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                @if(count($profile_pending))
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Family ID</th>
                            <th>phicID</th>
                            <th>nhtsID</th>
                            <th>Relation</th>
                            <th>First name</th>
                            <th>Middle name</th>
                            <th>Last name</th>
                            <th>Suffix</th>
                            <th>DOB</th>
                            <th>Sex</th>
                            <th>Sitio</th>
                            <th>Purok</th>
                            <th>Barangay</th>
                            <th>Option</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profile_pending as $row)
                            <?php $profile = \App\Profile::find($row->id); ?>
                            <tr>
                                <td width="10%">
                                    <a href="#familyProfile" class="text-yellow" data-backdrop="static" data-id="{{ $row->familyID }}" data-toggle="modal">
                                        {{ $profile->familyID }}
                                    </a>
                                </td>
                                <td>
                                    <small class="text-red">{{ $row->phicID }}</small><br>
                                    <small class="text-green">{{ $profile->phicID }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ $row->nhtsID }}</small><br>
                                    <small class="text-green">{{ $profile->nhtsID }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ $row->relation }}</small><br>
                                    <small class="text-green">{{ $profile->relation }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ $row->fname }}</small><br>
                                    <small class="text-green">{{ $profile->fname }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ $row->mname }}</small><br>
                                    <small class="text-green">{{ $profile->mname }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ $row->lname }}</small><br>
                                    <small class="text-green">{{ $profile->lname }}</small>
                                </td>
                                <td width="5%">
                                    <small class="text-red">{{ $row->suffix }}</small><br>
                                    <small class="text-green">{{ $profile->suffix }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ $row->dob }}</small><br>
                                    <small class="text-green">{{ $profile->dob }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ $row->sex }}</small><br>
                                    <small class="text-green">{{ $profile->sex }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ \App\Sitio::find($row->sitio_id)->sitio_name }}</small><br>
                                    <small class="text-green">{{ \App\Sitio::find($profile->sitio_id)->sitio_name }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ \App\Purok::find($row->purok_id)->purok_name }}</small><br>
                                    <small class="text-green">{{ \App\Purok::find($profile->purok_id)->purok_name }}</small>
                                </td>
                                <td>
                                    <small class="text-red">{{ \App\Barangay::find($row->barangay_id)->description }}</small><br>
                                    <small class="text-green">{{ \App\Barangay::find($profile->barangay_id)->description }}</small>
                                </td>
                                <td>
                                    @if($row->status == 'approve')
                                        <small class="label bg-green">Approve</small>
                                    @elseif($row->status == 'disapprove')
                                        <small class="label bg-red">Disapprove</small>
                                    @else
                                        <button class="btn-xs btn-success">Approve</button><br>
                                        <button class="btn-xs btn-danger">Disapprove</button>
                                    @endif

                                </td>
                            </tr>


                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $profile_pending->links() }}
                    </div>
                @else
                    <div class="alert alert-warning">
                        <p class="text-warning"><i class="fa fa-info-circle fa-lg text-bold"></i> No data found!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_purok" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Purok</h5>
                </div>
                <div class="purok_content"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="remove_purok" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form action="{{ asset('purok/remove') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-trash"></i></h5>
                    </div>
                    <div class="alert alert-danger">
                        <label class="text-red">Are you sure you want to remove this purok?</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-sm btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn-sm btn-danger purok_id" name="purok_id">Yes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('modal.populationModal')
@endsection

@section('js')
    @include('script.population')
    @if(Session::get('add'))
        <script>
            <?php Session::put('add',false); ?>
            Lobibox.notify('success', {
                size: 'mini',
                title: '',
                msg: 'Successfully Saved!'
            });
        </script>
    @endif
    @if(Session::get('remove'))
        <script>
            <?php Session::put('remove',false); ?>
            Lobibox.notify('error', {
                size: 'mini',
                title: '',
                msg: 'Deleted purok!'
            });
        </script>
    @endif

    <script>

    </script>
@endsection