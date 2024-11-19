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
                <div class="col-md-8">
                    <form class="form-inline" method="POST" action="{{ route('patientInjury') }}">
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
                        @if($user_priv->user_priv == 7)
                        <div class="form-group">
                                <a href="{{ route('export.csv') }}" class="btn btn-info col-xs-12">
                                    <i class="fa fa-download"></i> Download CSV
                                </a>
                            <div class="clearfix"></div>
                        </div>                
                        {{-- <!-- Date Filters -->
                            <div class="form-group">
                                <label for="start-date">Start Date:</label>
                                <input type="date" class="form-control" id="start-date" name="start_date" placeholder="Start Date">
                            </div>
                            <div class="form-group">
                                <label for="end-date">End Date:</label>
                                <input type="date" class="form-control" id="end-date" name="end_date" placeholder="End Date">
                            </div>
                            <div class="form-group">
                                <button type="submit" id="search-button" class="btn btn-default col-xs-12">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>   --}}
                        @endif

                        @if($user_priv->user_priv == 6)
                            <div class="form-group">
                                <a class="btn btn-info col-xs-12" href="{{ url('patient-form') }}">
                                    <i class="fa fa-user-plus"></i> Add Patient Injury
                                </a>
                                <div class="clearfix"></div>
                            </div>
                            
                        @endif
                        <br><br> 
                        <!-- <div class="form-group">
                            <label for="start-date" class="sr-only">Start Date</label>
                            <input type="date" class="form-control" id="start-date" name="start_date" placeholder="Start Date">
                        </div>
                        <div class="form-group">
                            <label for="end-date" class="sr-only">End Date</label>
                            <input type="date" class="form-control" id="end-date" name="end_date" placeholder="End Date">
                        </div> -->
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
                                @if($user_priv->user_priv !== 6)
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
                                    <!-- <td>{{ $NameEncoder ?? 'N/A' }}</td>-->
                                    @if($user_priv->user_priv !== 6)
                                        <td>
                                            @if($p->name_of_encoder)
                                                {{ $p->name_of_encoder }}
                                            @else
                                                {{ $NameEncoder ?? 'N/A' }}
                                            @endif 
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

            // let timer;

            // $("#search-keyword").on('input', function() {

            //     clearTimeout(timer);

            //     timer = setTimeout(() => {
            //         $('#search-button').click(); 
            //     }, 1000);

            // });

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

    </script>

@endsection