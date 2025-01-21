@php
    use Carbon\Carbon;
    use App\Facilities;
    use App\UserHealthFacility;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $facility = null;

    $user_priv = Auth::user()->user_priv;

    $userHealthFacilityMapping = UserHealthFacility::where('user_id', $user->id)->first();
    if ($userHealthFacilityMapping) {
        $facility = Facilities::find($userHealthFacilityMapping->facility_id);
    }
@endphp

@extends('resu/app1')

@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Risk Patient Assessment List {{ isset($not_updated) && $not_updated ? '(NOT UPDATED)' : "" }}</h2>

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
                    <form class="form-inline" method="POST" action="{{ url('patientRisk') }}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" id="search-keyword" placeholder="Quick Search" name="keyword" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="search-button" class="btn btn-default col-xs-12">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="clearfix"></div>
                        </div>

                        @if(isset($user_priv) && $user_priv->user_priv == 6)
                            <div class="form-group">
                                <a class="btn btn-info col-xs-12" href="{{ url('RiskAssessment') }}"> 
                                    <i class="fa fa-user-plus"></i> Add Risk Forms
                                </a>
                                <div class="clearfix"></div>
                            </div>
                        @endif

                        <br><br> 
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div id="results-container">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                @if(isset($user_priv) && !in_array($user_priv->user_priv, [6,1]))
                                    <th>Facility Name</th>
                                @endif
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Civil Status</th>
                                <th>Province/HUC</th>
                                <th>Municipal</th>
                                <th>Barangay</th>
                                <th>Date Inputted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riskprofiles as $profile)
                                @php
                                    $patientFacilityMapping = Facilities::where('id', $profile->facility_id_updated)
                                        ->select('id', 'name', 'address', 'hospital_type')
                                        ->first();
                                @endphp
                                <tr>
                                    <td nowrap="TRUE">
                                        <a href="{{ url('sublist-risk-patient/'.$profile->id) }}" class="btn btn-xs btn-success">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                    <td nowrap="TRUE">
                                        <form action="{{ url('patientrisk/delete/'.$profile->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            {{csrf_field()}}
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                    @if(isset($user_priv) && !in_array($user_priv->user_priv, [6,1]))
                                        <td>{{ $patientFacilityMapping->name ? $patientFacilityMapping->name : 'N/A' }}</td>
                                    @endif
                                    <td>{{ $profile->fname }} {{ $profile->mname }} {{ $profile->lname }}</td>
                                    <td>{{ Carbon::parse($profile->dob)->age }}</td>
                                    <td>{{ $profile->sex }}</td>
                                    <td>{{ $profile->civil_status }}</td>
                                    <td>{{ $profile->province->description ? $profile->province->description : 'N/A' }}</td>
                                    <td>{{ $profile->muncity->description ? $profile->muncity->description : 'N/A' }}</td>
                                    <td>{{ $profile->barangay->description ? $profile->barangay->description : 'N/A' }}</td>
                                    <td>{{ $profile->created_at->format('F j, Y') ? $profile->created_at->format('F j, Y') : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $riskprofiles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Lobibox.notify('success', {
                msg: "{{ session('success') }}"
            });
        });
    </script>
@endif

@section('js')
    <script>
        $(document).ready(function() {
            $('#search-button').on('click', function(e) {
                e.preventDefault();
                var keyword = $('#search-keyword').val();
                $.ajax({
                    url: '{{ url("patientRisk") }}',
                    type: 'GET',
                    data: { keyword: keyword },
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        $('#results-container').html(response);
                    },
                    complete: function () {
                        $('.loading').hide();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
