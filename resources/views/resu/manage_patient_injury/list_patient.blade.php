@php
    use Carbon\Carbon;
    use App\Facility;
    use App\ResuReportFacility;
    $priv_fact = Auth::user()->facility_id;
@endphp

@extends('resu/app1')
@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Manage Patient Injury {{ $not_updated ? '(NOT UPDATED)' : "" }}</h2>
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
                <div class="col-md-12">
                    <form class="form-inline" method="POST" action="{{ route('patientInjury') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" id="search-keyword" placeholder="Quick Search" name="keyword" value="" autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="search-button" class="btn btn-primary col-xs-12">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>

                     
                        <div class="form-group">
                            <div class="clearfix"></div>
                        </div>
                        @if($user_priv->user_priv == 7 ) {{--for region can download--}}
                        <div class="form-group" style ="margin-left: 65%;">
                                <a href="{{ route('export.csv') }}" class="btn btn-info"> 
                                    <i class="fa fa-download"></i> Download CSV
                                </a>
                            <div class="clearfix"></div>
                            {{-- <div class="form-group">
                                <button type="button" id="refresh-button" class="btn btn-secondary" style ="margin-left: 10%;">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div> --}}
                        </div>
                        <br><br> 
                        <!-- Date Filters -->
                            {{-- <form method="GET" action="{{ route('patientInjury') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input 
                                        type="date" 
                                        name="start_date" 
                                        id="start_date" 
                                        class="form-control" 
                                        value="{{ request('start_date') ? \Carbon\Carbon::createFromFormat('Y-m-d', request('start_date'))->format('Y-m-d') : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input 
                                        type="date" 
                                        name="end_date" 
                                        id="end_date" 
                                        class="form-control" 
                                        value="{{ request('end_date') ? \Carbon\Carbon::createFromFormat('Y-m-d', request('end_date'))->format('Y-m-d') : '' }}">
                                </div>
                                <button type="submit" class="btn btn-primary" id="search-button-two">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <div class="form-group">
                                    <button type="button" id="refresh-button" class="btn btn-secondary" style ="margin-left: 10%;">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </form>     --}}

                        @elseif($user_priv->user_priv == 10) {{--for DSO download--}}
                                <div class="form-group">
                                        <a href="{{ route('export.csv') }}" class="btn btn-info col-xs-12" style ="margin-left: 500%;">
                                            <i class="fa fa-download"></i> Download CSV
                                        </a>
                                    <div class="clearfix"></div>
                                </div> 
                               
                                <br><br> 

                                <form method="GET" action="{{ route('patientInjury') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input 
                                            type="date" 
                                            name="start_date" 
                                            id="start_date" 
                                            class="form-control" 
                                            value="{{ request('start_date') ? \Carbon\Carbon::createFromFormat('Y-m-d', request('start_date'))->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input 
                                            type="date" 
                                            name="end_date" 
                                            id="end_date" 
                                            class="form-control" 
                                            value="{{ request('end_date') ? \Carbon\Carbon::createFromFormat('Y-m-d', request('end_date'))->format('Y-m-d') : '' }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="search-button-two">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                    <div class="form-group">
                                        <button type="button" id="refresh-button" class="btn btn-secondary" style ="margin-left: 10%;">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                    </div>
                                </form>
                        @endif
                            @if($user_priv->user_priv == 6)
                                <div class="form-group">
                                    <a class="btn btn-info col-xs-12" href="{{ url('patient-form') }}">
                                        <i class="fa fa-user-plus"></i> Add Patient Injury
                                    </a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="refresh-button" class="btn btn-secondary" style ="margin-left: 10%;">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            
                            @endif
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div id="results-container" style="width: 100%">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                @if($user_priv->user_priv !== 6)
                                    <th>Facility Name <br>&nbsp;</th>
                                @endif
                            
                                <th>Full Name<br>&nbsp;</th>
                                <th>Age<br>&nbsp;</th>
                                <th>Sex<br>&nbsp;</th>
                                <th>Province/HUC<br>&nbsp;</th>
                                <th>Municipal<br>&nbsp;</th>
                                <th>Barangay<br>&nbsp;</th>
                                <th>Place Injury<br>&nbsp;</th>
                                <th>Date And Time Injury<br>&nbsp;</th>
                                @if($user_priv->user_priv !== 6 )
                                    <th>Encoder<br>&nbsp;</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profile as $p)
                                @php 
                                    $ad = $p->preadmission;  
                                    $province = $p->province ? $p->province->description : 'N/A';
                                    $muncity = $p->muncity ? $p->muncity->description : 'N/A';
                                    $barangay = $p->barangay ? $p->barangay->description : 'N/A';

                                    $modifiedName = str_replace('-DSO', '', $p->name_of_encoder);
                                    $NameEncoder = preg_replace('/([a-z])([A-Z])/', '$1 $2', $modifiedName);
                                    $preprovince = $ad->POIProvince_id ? $ad->province->description : 'N/A';
                                    $premuncity = $ad->POImuncity_id ? $ad->muncity->description : 'N/A';
                                    $prebarangay = $ad->POIBarangay_id ? $ad->barangay->description : 'N/A';
                                @endphp
                                 <tr>
                                    <td nowrap="TRUE">
                                        <a href="{{ asset('sublist-patient/'.$p->id) }}" class="btn btn-xs btn-success">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                    <td nowrap="TRUE">
                                        <form action="{{ route('patient.delete', $p->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                    
                                    @if($user_priv->user_priv !== 6)
                                        <td>
                                            @if($p->reportFacility && $p->reportFacility->facility)
                                                {{ $p->reportFacility->facility->name }}
                                            @else
                                                {{ $p->facility->name}}
                                            @endif 
                                        </td>
                                    @endif
                                    <td class="{{ $p->head == 'YES' ? 'text-bold text-primary' : '' }}">
                                        {{ $p->fname . ' ' . $p->mname . ' ' . $p->lname . ' ' . $p->suffix }}
                                    </td>
                                    <!-- <td>
                                        @php
                                            $dob = Carbon::parse($p->dob);
                                            $age = $dob->diffInYears(Carbon::now());
                                        @endphp
                                        {{ $age }}
                                    </td> -->
                                    <td>
                                    @php
                                        $dob = Carbon::parse($p->dob);
                                        $ageYears = $dob->diffInYears(Carbon::now());
                                        $ageMonths = $dob->diffInMonths(Carbon::now()) % 12;

                                        $age = $ageYears > 0 
                                                ? "{$ageYears} years old"   
                                                : "{$ageMonths} months old";
                                    @endphp
                                    {{ $age }}
                                    </td>
                                    <td>{{ $p->sex }}</td>
                                    <td>{{ $p->province ? $p->province->description : 'N/A' }}</td>
                                    <td>{{ $p->muncity ? $p->muncity->description : 'N/A' }}</td>
                                    <td>{{ $p->barangay ? $p->barangay->description : 'N/A' }}</td>
                                    <td>{{ $preprovince . ' , ' . $premuncity . ' , ' . $prebarangay . ' , ' . $p->preadmission->POIPurok }}</td>
                                    <td>{{ $p->preadmission->dateInjury . ' ' . $p->preadmission->timeInjury }}</td>
                                    @if($user_priv->user_priv !== 6)
                                    <td>
                                        {{ $p->name_of_encoder }}
                                    </td>
                                @endif
                                </tr>
                            @endforeach
                        </tbody>
                                               
                    </table>
                    <div class="text-center">
                        {{ $profile->links() }}
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
                    e.preventDefault(); // Prevent form submission\
                            
                var keyword = $('#search-keyword').val();

                        $.ajax({
                            url: '{{ route("patientInjury") }}',
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

                $(document).ready(function() {
                    $('#search-button-two').on('click', function(e) { //for date
                        e.preventDefault(); // Prevent form submission\
                                
                        let startDate = $('#start_date').val();
                        let endDate = $('#end_date').val();

                        $.ajax({
                                url: '{{ route("patientInjury") }}',
                                type: 'GET',
                                data: {
                                    start_date: startDate,
                                    end_date: endDate,
                                
                                },
                                success: function(response) {
                                    $('tbody').html(response);
                                },
                                error: function(xhr) {
                                    console.error(xhr.responseText);
                                }
                            });
                        });
                });

            $(document).ready(function() {
                    // Refresh button functionality
                    $('#refresh-button').on('click', function(e) {
                        e.preventDefault(); // Prevent default behavior
                        
                        $.ajax({
                            url: '{{ route("patientInjury") }}', // Route to fetch the data
                            type: 'GET',
                            beforeSend: function() {
                                $('.loading').show(); // Optional: Show loading indicator
                            },
                            success: function(response) {
                                $('tbody').html(response); // Replace table body content
                            },
                            complete: function() {
                                $('.loading').hide(); // Optional: Hide loading indicator
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText); // Log any errors
                            }
                        });
                    });
                });
</script>


@endsection