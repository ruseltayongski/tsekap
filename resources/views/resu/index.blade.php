@extends('resu/app1') 
@section('content')

<?php
 $user = Auth::user();
?>

<div class="container">
    <div class="row justify-content-center" style="align-center: 50%">
        <!-- Patient Injury Form Section -->
        <div class="col-md-6 wrapper">
            <div class="alert alert-jim">
                <h2 class="page-header"><i class="fa fa-folder"></i> Patient Injury Form </h2>
                <div class="page-divider"></div>
        
                <div class="form-group-section">
                    <img src="{{ asset('resources/img/patientInjuryLogo.png') }}" alt="Patient Logo" class="img-fluid mb-3" style="width: 100px; height: auto;">
                    <br/><br/><br/>
                    <a href="patientInjury" class="btn btn-primary mt-3">V  iew List</a>
                    @if ($user->user_priv != 7)
                        <a href="patient-form" class="btn btn-primary mt-3">Add Patient Injury</a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Risk Assessment Form Section -->
        <div class="col-md-6 wrapper">
            <div class="alert alert-jim">
                <h2 class="page-header"><i class="fa fa-folder"></i> Risk Assessment Form </h2>
                <div class="page-divider"></div>
                <div class="form-group-section">
                    <img src="{{ asset('resources/img/patientlogo.png') }}" alt="Patient Logo" class="img-fluid mb-3" style="width: 100px; height: auto;">
                    <br/><br/><br/>
                    <a href="patientRisk" class="btn btn-primary mt-3">View List</a>
                    @if ($user->user_priv != 7)
                        <a href="RiskAssessment" class="btn btn-primary mt-3">Add Risk Assessment</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
    .wrapper {
        max-width: 1000px; /* Adjust width as needed */
        margin: 20px auto;
    }
    .alert-jim {
        text-align: center;
    }
    .form-group-section {
        padding: 20px;
        border-bottom: 1px solid #ddd;
        background-color: #f9f9f9;
    }
    .form-group-section:last-child {
        border-bottom: none;
    }
    .section-header {
        font-size: 1.5rem;
        font-weight: bold;
        color: #555;
        margin-bottom: 10px;
    }
    .page-divider {
        border-bottom: 2px solid #ccc;
        margin-top: 10px;
        margin-bottom: 20px;
    }
</style>
