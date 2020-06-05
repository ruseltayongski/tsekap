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
                    <form class="form-inline" method="POST" action="{{ asset('purok') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Quick Search" name="purok_keyword" value="{{ Session::get('purok_keyword') }}" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                            <div class="clearfix"></div>
                        </div>
                        @if(Session::get('purok_keyword'))
                            <div class="form-group">
                                <button type="submit" name="view_all" value="true" class="btn btn-warning"><i class="fa fa-eye"></i> View All</button>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="table-responsive">
                @if(count($profile_pending))
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Family ID</th>
                            <th>phicID</th>
                            <th>nhtsID</th>
                            <th>Relation</th>
                            <th>Fname</th>
                            <th>Mname</th>
                            <th>Lname</th>
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
                                <td>
                                    <a href="#familyProfile" data-backdrop="static" data-id="{{ $row->familyID }}" data-toggle="modal" class="title-info">
                                        {{ $profile->familyID }}
                                    </a>
                                </td>
                                <td>
                                    {{ $row->phicID }}<br>
                                    <small class="text-green">{{ $profile->familyID }}</small>
                                </td>
                                <td>
                                    {{ $row->nhtsID }}<br>
                                    <small class="text-green">{{ $profile->nhtsID }}</small>
                                </td>
                                <td>
                                    {{ $row->relation }}<br>
                                    <small class="text-green">{{ $profile->relation }}</small>
                                </td>
                                <td>
                                    {{ $row->fname }}<br>
                                    <small class="text-green">{{ $profile->fname }}</small>
                                </td>
                                <td>
                                    {{ $row->mname }}<br>
                                    <small class="text-green">{{ $profile->mname }}</small>
                                </td>
                                <td>
                                    {{ $row->lname }}<br>
                                    <small class="text-green">{{ $profile->lname }}</small>
                                </td>
                                <td>
                                    {{ $row->dob }}<br>
                                    <small class="text-green">{{ $profile->dob }}</small>
                                </td>
                                <td>
                                    {{ $row->sex }}<br>
                                    <small class="text-green">{{ $profile->sex }}</small>
                                </td>
                                <td>
                                    {{ $row->sitio_id }}<br>
                                    <small class="text-green">{{ $profile->sitio_id }}</small>
                                </td>
                                <td>
                                    {{ $row->purok_id }}<br>
                                    <small class="text-green">{{ $profile->purok_id }}</small>
                                </td>
                                <td>
                                    {{ \App\Barangay::find($row->barangay_id)->description }}<br>
                                    <small class="text-green">{{ \App\Barangay::find($profile->barangay_id)->description }}</small>
                                </td>
                                <td>
                                    <button class="btn-xs btn-success">Approve</button><br>
                                    <button class="btn-xs btn-danger">Disapprove</button>
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