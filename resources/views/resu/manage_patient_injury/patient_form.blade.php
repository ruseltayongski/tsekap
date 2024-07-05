@extends('resu/app1')

@section('content')
@include('sidebar')
<div id="patient-injury-form-container"></div>


<script src="{{ asset('public/js/bundle.js') }}"></script>

@endsection
<style>
.col-md-8 .patient-font{
        background-color: #727DAB;
        color: white; 
        padding: 3px;
    }
   .col-md-6 #underline-text {
  text-decoration: underline;
}
.col-md-4 #natureinput{
        border: none;
        border-bottom: 1px solid black; /* Only bottom border */
        outline: none; /* Remove default outline */
        transition: border-bottom-color 0.3s;
        width: 10em
}


</style>