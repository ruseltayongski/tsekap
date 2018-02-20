@extends('client')
@section('content')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Change Password</h2>
            <div class="page-divider"></div>
            <form method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-3 control-label">Current Password</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" name="current">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">New Password</label>
                    <div class="col-sm-7">
                        <input type="password" pattern=".{3,}" title="New password - minimum of 3 Character" class="form-control" name="new" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Confirm Password</label>
                    <div class="col-sm-7">
                        <input type="password" pattern=".{3,}" title="Confirm password - minimum of 3 Character" class="form-control" name="confirm" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-7">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-send"></i> Change Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('sidebar')
@endsection

@section('js')
    <?php
    $status = session('status');
    $try = Session::get('tryPass');
    ?>
    @if($status=='updated')
        <script>
            Lobibox.notify('success', {
                msg: 'Password successfully changed!'
            });
        </script>
    @endif
    @if($status=='notequal')
        <?php
          if($try>1){
              $msg = 'You have '.(3-$try).' try left!';
          } else{
              $msg = 'You have '.(3-$try).' tries left!';
          }
        ?>
        <script>
            Lobibox.notify('error', {
                msg: 'Current password is incorrect. <?php echo $msg;?>'
            });
        </script>
    @endif
    @if($status=='notsame')
        <script>
            Lobibox.notify('error', {
                msg: 'Password did not match!'
            });
        </script>
    @endif
@endsection