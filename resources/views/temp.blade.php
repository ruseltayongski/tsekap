@extends('client')
@section('content')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Request Unavailable...</h2>
            <div class="page-divider"></div>
            <div class="alert alert-danger">
                <p class="text-danger" style="font-size:1.2em;">
                    <strong>DOWNLOADING</strong> and <strong>UPLOADING</strong> of <strong>DATA</strong> is not <strong>AVAILABLE</strong> as of the moment. Please try again later or contact <strong>System Administrator!</strong>
                </p>
            </div>
        </div>
    </div>
    @include('sidebar')
@endsection

@section('js')

@endsection