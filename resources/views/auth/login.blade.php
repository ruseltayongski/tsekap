<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHA Check-Up | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('resources/assets/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('resources/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/assets/css/AdminLTE.min.css') }}">
    <link rel="icon" href="{{ asset('resources/img/favicon.png') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page" style="background-color:#E8F5FD;">
@if(Session::has('ok'))
    <div class="row">
        <div class="alert alert-success text-center">
            <strong class="text-center">{{ Session::get('ok') }}</strong>
        </div>
    </div>
@endif

<div class="modal fade" tabindex="-1" role="dialog" id="loginModal" style="margin-top: 30px;z-index: 99999 ">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-success">
                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><b>PHILIPPINE HEALTH AGENDA CHECK-UP SYSTEM</b></h4>
                </div><br>

                <div class="">
                    <div style="font-size:1.1em;">
                        <i class="fa fa-phone"></i> <b class="text-warning">Main Contact Person:</b>
                        <ul>
                            <li style="font-size: 0.95em;">
                                <span style="color: darkslategray">Amalio Enero Jr. - SMU Office 260-9740 local 104 / amaliojrenero@gmail.com</span>
                            </li>
                        </ul><br>

                        <span style="font-size: 0.95em; color: darkslategray;">
                            <b class="text-warning">For further assistance, you may contact the following:</b>
                            <ol type="I">
                                <li>System Concerns</li>
                                <ol type="1">
                                    <li>Amalio S. Enero Jr. - 09978755253</li>
                                </ol>
                                <li>Non - Technical</li>
                                <ol type="1">
                                    <li>HSDS Office - 260-9740 local 204</li>
                                    <li>Dr. Nelner D. Omus, HSDS Head - 09175748119</li>
                                    <li>Jane Michelle E. Raagas, DMO IV - 09173100611 </li>
                                    <li>Prince Japee Neil C. Seno, PDO II - 09928947312</li>
                                    <li>Gian Ricki M. Bontilao, Nurse II - 09608522236</li>
                                </ol>
                            </ol>
                        </span>

                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="login-box">
    <div class="login-logo">
        <img style="height: 100px;" class=logo-login" src="{{ asset('resources/img/doh logo.png') }}" />
        <img style="height: 95px;" src="{{ asset('resources/img/tsekap-logo.png') }}" />
        <br />
        <h3><b>PHILIPPINE HEALTH AGENDA</b></h3>
        <h4><b>CHECK-UP SYSTEM</b></h4>
        {{--<a href="#"><b>PHA</b> CHECK-UP</a>--}}
    </div><!-- /.login-logo -->

    <form role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <div class="login-box-body">
            {{--<p class="login-box-msg">Sign in to start your session</p>--}}
            <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
                <input id="username" type="text" placeholder="Login ID" class="form-control" name="username" value="{{ old('username') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="form-group">
                        <label style="cursor:pointer;">
                            <input type="checkbox" name="remember"> Remember Me
                        </label><br><br>
                        <a href="{{ asset("resources/apk/Tsekap-3.1-dummy.apk") }}" type="button" class="btn btn-success">
                            <i class="fa fa-mobile"></i> <small> Mobile Check-Up (.apk) </small>
                        </a>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
            {{--<i class="fa fa-phone-square"></i> For further assistance/questions, please contact--}}
            {{--<strong><span class="text-success">Amalio S. Enero Jr.</span></strong>--}}
                {{--<ul>--}}
                    {{--<li>Contact #: <b class="text-primary">09978755253 </b> </li>--}}
                    {{--<li>Email: <b class="text-primary">amaliojrenero@gmail.com </b></li>--}}
                {{--</ul>--}}

        </div><!-- /.login-box-body -->

    </form>
</div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script>
    $('#loginModal').modal('show');
</script>
</body>
</html>
