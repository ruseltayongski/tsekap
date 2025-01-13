@php
    use Carbon\Carbon;
    use App\Facility;
    use App\ResuReportFacility;
    $priv_fact = Auth::user()->facility_id_updated;
@endphp

@extends('resu/app1')
@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Risk Patient Assessment List {{ $not_updated ? '(NOT UPDATED)' : "" }}</h2>
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
                    <form class="form-inline" method="POST" action="{{ route('patientRisk') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" id="search-keyword" placeholder="Quick Search" name="keyword" value="" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="search-button" class="btn btn-default col-xs-12">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>  
                        <div class="form-group">
                            <div class="clearfix"></div>
                        </div>
                        @if($user_priv->user_priv == 6)
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
                                @if($user_priv->user_priv !== 6)
                                    <th>Facility Name</th>
                                @endif
                                <th>Full Name<br>&nbsp;</th>
                                <th>Age<br>&nbsp;</th>
                                <th>Sex<br>&nbsp;</th>
                                <th>Civil Status<br>&nbsp;</th>
                                <th>Province/HUC<br>&nbsp;</th>
                                <th>Municipal<br>&nbsp;</th>
                                <th>Barangay<br>&nbsp;</th>
                                <th>Date Inputted<br>&nbsp;</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riskprofiles as $profile)
                                <tr>
                                    <td nowrap="TRUE">
                                        <a href="{{ asset('sublist-risk-patient/'.$profile->id) }}" class="btn btn-xs btn-success">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                    @if($user_priv->user_priv !== 6)
                                        <td>{{ $profile->facility->name ? $profile->facility->name : 'N/A' }}</td>
                                    @endif
                                    <td>{{ $profile->fname }} {{ $profile->mname }} {{ $profile->lname }}</td>
                                    <td>{{ Carbon::parse($profile->dob)->age }}</td>
                                    <td>{{ $profile->sex }}</td>
                                    <td>{{ $profile->civil_status }}</td>
                                    <td>{{ $profile->province->description  ? $profile->province->description : 'N/A' }}</td>
                                    <td>{{ $profile->muncity->description ? $profile->muncity->description : 'N/A' }}</td>
                                    <td>{{ $profile->barangay->description ? $profile->barangay->description : 'N/A' }}</td>
                                    <td>{{ $profile->created_at ? Carbon::parse($profile->created_at)->format('F j, Y') : 'N/A' }}</td>
                                  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $riskprofiles->links () }} <!-- This should now work as $riskprofiles is the correct variable -->
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
                e.preventDefault(); // Prevent form submission
                var keyword = $('#search-keyword').val();
                $.ajax({
                    url: '{{ route("patientRisk") }}',
                    type: 'GET',
                    data: { keyword: keyword },
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (response) {
                        $('tbody').html(response);
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