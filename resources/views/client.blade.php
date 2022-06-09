<?php
use App\Muncity;
use App\Province;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('resources/img/favicon.png') }}">
    <meta http-equiv="cache-control" content="max-age=0" />
    <title>PHA Check-Up</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('resources/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('resources/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/plugin/Lobibox/lobibox.css') }}">
    <link href="{{ asset('resources/plugin/chosen/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/plugin/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/plugin/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/plugin/table-fixed-header/table-fixed-header.css') }}" rel="stylesheet">

    @yield('css')
    <style>
        body {
            background: url('{{ asset('resources/img/backdrop.png') }}'), -webkit-gradient(radial, center center, 0, center center, 460, from(#ccc), to(#ddd));
        }
        .loading {
            opacity:0.4;
            background:#ccc url('{{ asset('resources/img/spin.gif')}}') no-repeat center;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:9999;
            display: none;
        }
        .select2 {
            position: relative;
            z-index: 2;
            float: left;
            width: 100%;
            margin-bottom: 0;
            display: table;
            table-layout: fixed;
        }
        .select2-hidden-accessible{
            position:absolute !important;
        }

        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: rgba(38, 125, 61, 0.92);
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
        }
        #myBtn:hover {
            background-color: #555;
        }


    </style>
    <script src="{{ asset('resources/assets/js/ie-emulation-modes-warning.js') }}"></script>
</head>

<body>

<!-- Fixed navbar -->

<nav class="navbar navbar-default navbar-static-top">
    <div class="header" style="background-color:#2F4054;padding:10px;">
        <div class="col-md-4">
            <span class="title-info">Welcome,</span> <span class="title-desc">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</span>
        </div>
        <div class="col-md-4">
            <span class="title-info">Location:</span>

            <span class="title-desc">
                <?php
                $priv = Auth::user()->user_priv;
                ?>
                @if($priv==1)
                    Region VII
                @elseif($priv==3)
                    Province of {{ Province::find(Auth::user()->province)->description }}
                @else
                    {{ Muncity::find(Auth::user()->muncity)->description }}
                @endif
            </span>
        </div>
        <div class="col-md-4">
            <span class="title-info">Date:</span> <span class="title-desc">{{ date('M d, Y') }}</span>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="header" style="background-color:#028482;padding:15px;">
        <div class="container">
            <img src="{{ asset('resources/img/banner_2020.png') }}" class="img-responsive" />
        </div>
    </div>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/user/home') }}"><i class="fa fa-home"></i> Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> Population<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/user/population') }}"><i class="fa fa-user-plus"></i>&nbsp;&nbsp; Manage Population</a></li>
                        <li><a href="{{ asset('population/target') }}"><i class="fa fa-line-chart"></i>&nbsp;&nbsp; Target Population</a></li>
                        {{--<li><a href="{{ asset('/user/population/less')  }}"><i class="fa fa-user-times"></i>&nbsp;&nbsp; 3 Must Services Status</a></li>--}}
                        {{--<li><a href="{{ asset('issue/duplicate/population')  }}"><i class="fa fa-user-times"></i>&nbsp;&nbsp; Duplicate Population</a></li>--}}
                        {{--<li><a href="{{ asset('issue/head/child')  }}"><i class="fa fa-user-times"></i>&nbsp;&nbsp; Children Head</a></li>--}}
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i> Manage<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('facility') }}"><i class="fa fa-hospital-o"></i> Facilities</a></li>
                        <li><a href="{{ url('specialist') }}"><i class="fa fa-user-md"></i> Health Specialists</a></li>
                    </ul>
                </li>
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-map-o"></i> Address<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li><a href="{{ url('sitio') }}"><i class="fa fa-institution"></i> Sitio</a></li>--}}
                        {{--<li><a href="{{ url('purok') }}"> <i class="fa fa-building"></i> Purok</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="{{ url('user/profiles/pending') }}">--}}
                        {{--<span class="badge bg-yellow">--}}
                            {{--<?php--}}
                                {{--$tmpBrgy = \App\UserBrgy::where('user_id',Auth::user()->id)->get();--}}
                                {{--$profile_pending_count = \App\ProfilePending::where(function($query) use ($tmpBrgy){--}}
                                    {{--if(count($tmpBrgy) > 0){--}}
                                        {{--foreach($tmpBrgy as $tmp){--}}
                                            {{--$query->orwhere('barangay_id','=',$tmp->barangay_id);--}}
                                        {{--}--}}
                                    {{--} else {--}}
                                        {{--$query->where('barangay_id','=','no_barangay');--}}
                                    {{--}--}}
                                {{--})--}}
                                {{--->count();--}}

                                {{--echo $profile_pending_count;--}}
                            {{--?>--}}
                        {{--</span> Profile Pending--}}
                    {{--</a>--}}
                {{--</li>--}}
                <!--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wheelchair"></i> Dengvaxia<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('/user/dengvaxia')  }}"><i class="fa fa-hourglass-half"></i>&nbsp;&nbsp; Pending List</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/user/dengvaxia/cross') }}"><i class="fa fa-exchange"></i>&nbsp;&nbsp; Cross Match</a></li>
                    </ul>
                </li>
                -->
                <li><a href="{{ url('/user/services') }}"><i class="fa fa-stethoscope"></i>&nbsp;Services Availed</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-line-chart"></i> Report<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('/user/report')  }}"><i class="fa fa-table"></i>&nbsp;&nbsp; Services Availed</a></li>
                        <li><a href="{{ asset('/user/report/cases')  }}"><i class="fa fa-table"></i>&nbsp;&nbsp; Diagnoses</a></li>
                        <li class="divider"></li>
                        <?php $validBrgy = \App\Http\Controllers\UserCtrl::validateBrgy();?>
                        @if($validBrgy)
                        <li><a href="{{ asset('/user/report/health') }}"><i class="fa fa-pie-chart"></i>&nbsp;&nbsp; {{--Environmental Health Graph--}} Statistical Data</a></li>
                        @endif
                        <li><a href="{{ asset('/user/report/monthly') }}"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp; Monthly Report</a></li>
                        @if(Auth::user()->user_priv==0)
                        <li><a href="{{ asset('/user/report/status') }}"><i class="fa fa-table"></i>&nbsp;&nbsp; Status Report</a></li>
                        @endif
                        @if(Auth::user()->user_priv==2)
                        <?php
                            $brgy = \App\UserBrgy::where('user_id',Auth::user()->id)->first()->barangay_id;
                        ?>
                        <li><a href="{{ asset('generatedownload/barangay') }}/{{ $brgy }}/{{ Auth::user()->muncity}}"><i class="fa fa-download"></i>&nbsp;&nbsp; Status Report</a></li>
                        @endif
                    </ul>
                </li>
                <li class="dropdown hide">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-gear"></i> Settings<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        {{--<li><a href="#downloadData" data-toggle="modal"><i class="fa fa-download"></i>&nbsp;&nbsp; Download Data</a></li>--}}
                        {{--<li><a href="{{ asset('user/download/data/') }}" ><i class="fa fa-download"></i>&nbsp;&nbsp; Download Data (v1.4)</a></li>--}}
                        <li><a href="{{ asset('user/download/old/data/') }}" ><i class="fa fa-download"></i>&nbsp;&nbsp; Download Data</a></li>
                        <li class="divider"></li>

                        {{--<li><a href="#uploadData" data-toggle="modal"><i class="fa fa-upload"></i>&nbsp;&nbsp; Upload Data</a></li>--}}
{{--                        <li><a href="{{ asset('user/upload/data') }}" ><i class="fa fa-upload"></i>&nbsp;&nbsp; Upload Data (v1.4)</a></li>--}}
                        <li><a href="{{ asset('user/upload/old/data') }}" ><i class="fa fa-upload"></i>&nbsp;&nbsp; Upload Data</a></li>
                    </ul>
                </li>
                @if(Auth::user()->user_priv==0)
                <li><a href="{{ url('/user/add') }}"><i class="fa fa-users"></i> Users</a></li>
                @endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-gear"></i> Account<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('/user/change/password')  }}"><i class="fa fa-unlock"></i>&nbsp;&nbsp; Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Logout</a></li>
                    </ul>
                </li>
            </ul>
            {{--<ul class="nav navbar-nav navbar-right">--}}
            {{--<li class="active"><a href="#send" data-toggle="modal"><i class="fa fa-envelope"></i> Contact Admin</a></li>--}}
            {{--</ul>--}}
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container-fluid container_body">
    <div class="loading"></div>
    @yield('content')
    <div class="clearfix"></div>
</div> <!-- /container -->
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"></i> Go Top</button>

<footer class="footer">
    <div class="container">
        <p class="pull-right">
            version 3.0
        </p>
        <p>Copyright &copy; 2017 DOH-RO7 All rights reserved</p>
    </div>
</footer>
@include('modal')

        <!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/jquery-validate.js') }}"></script>
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('resources/assets/js/ie10-viewport-bug-workaround.js') }}"></script>
<script>var loadingState = '<center><img src="{{ asset('resources/img/spin.gif') }}" width="150" style="padding:20px;"></center>'; </script>
<!-- bootstrap datepicker -->
<script src="{{ asset('resources/assets/js/script.js') }}?v=1"></script>
<script src="{{ asset('resources/assets/js/form-justification.js') }}"></script>
<script src="{{ asset('resources/plugin/Lobibox/Lobibox.js') }}"></script>
<script src="{{ asset('resources/plugin/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('resources/plugin/select2/select2.full.js') }}"></script>
<script src="{{ asset('resources/plugin/daterangepicker/moment.min.js') }}"></script>
<!-- DATE RANGE SELECT -->
<script src="{{ asset('resources/plugin/daterangepicker/daterangepicker.js') }}"></script>
<!-- FIXED HEADER FOR TABLES -->
<script src="{{ asset('resources/plugin/table-fixed-header/table-fixed-header.js?version=1') }}"></script>

<script>
    $('.chosen-select').chosen({width: "100%"});
    $('.chosen-select-static').chosen();
    $(".select2").select2();
    $('.form-submit').on('submit',function(){
        $('.btn-submit').attr('disabled',true);
    });

    var urlParams = new URLSearchParams(window.location.search);
    var query_string = urlParams.get('search') ? urlParams.get('search') : '';
    $(".pagination").children().each(function(index){
        var _href = $($(this).children().get(0)).attr('href');
        $($(this).children().get(0)).attr('href',_href+'&search='+query_string);
    });

    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        $('body,html').animate({
            scrollTop : 0 // Scroll to top of body
        }, 500);
    }
</script>
@yield('js')
<?php
$status = session('status');
?>
@if($status=='uploaded')
    <script>
        Lobibox.notify('success', {
            msg: 'Uploaded successfully!'
        });
    </script>
@endif

@if($status=='feedbackSent')
    <script>
        Lobibox.notify('success', {
            msg: 'Successfully sent!'
        });
    </script>
@endif

@if($status=='updated')
    <script>
        Lobibox.notify('success', {
            size: 'mini',
            title: '',
            msg: 'Successfully updated!'
        });
    </script>
@endif

@if($status=='duplicate')
    <script>
        Lobibox.notify('error', {
            msg: 'Ooops! Name was already added.'
        });
    </script>
@endif

</body>
</html>
