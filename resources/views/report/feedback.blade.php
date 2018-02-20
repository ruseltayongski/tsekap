<?php
    use App\User;
    use App\Http\Controllers\ParameterCtrl as Param;
?>
@extends('app')
@section('content')

    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">User's Feedback</h2>
            <div class="page-divider"></div>
            <form method="POST" class="form-horizontal">
                {{ csrf_field() }}
                @if(count($feedback))
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Location</th>
                                <th>Message</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedback as $row)
                            <?php
                                $user = User::find($row->user_id);
                                $name = $user->fname.' '.$user->mname.' '.$user->lname.' '.$user->suffix;
                                $muncity = App\Muncity::find($user->muncity)->description;
                                $province = App\Province::find($user->province)->description;
                                $location = $muncity.', '.$province;
                            ?>
                            <tr>
                                <td nowrap="nowrap">
                                    <font class="text-success text-bold">
                                        {{ date('M d, Y',strtotime($row->created_at)) }}
                                    </font><br />
                                        <small>({{ date('h:i A',strtotime($row->created_at)) }})</small>
                                </td>
                                <td class="title-info">
                                    {{ $name }}
                                    @if($user->contact)
                                    <br />
                                    <small class="text-primary">({{ $user->contact }})</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $muncity }}, {{ $province }}
                                </td>
                                <td>
                                    <?php
                                        $class = 'text-success text-bold';
                                        $class2 = 'btn-danger';

                                        if($row->status==1){
                                            $class = 'text-warning';
                                            $class2 = 'btn-success';
                                        }else if($row->status==2){
                                            $class = 'text-info';
                                            $class2 = 'btn-warning';
                                        }
                                    ?>
                                    <font class="{{ $class }}">
                                    @if($row->status==1)
                                        <del>{{ Param::string_limit_words($row->message,5) }}...</del>
                                    @else
                                        {{ Param::string_limit_words($row->message,5) }}...
                                    @endif
                                    </font>
                                </td>
                                <td>
                                    <a href="#feedback" data-toggle="modal" class="view-feedback text-warning" data-id="{{ $row->id }}">
                                    @if($row->status==0)
                                        <button type="button" class="btn btn-sm {{ $class2 }}">
                                            <i class="fa fa-hourglass"></i> Pending
                                        </button>
                                    @elseif($row->status==1)
                                        <button type="button" class="btn btn-sm {{ $class2 }}">
                                            <i class="fa fa-check"></i> Done!
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm {{ $class2 }}">
                                            <i class="fa fa-check"></i> Seen!
                                        </button>
                                    @endif
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {{ $feedback->links() }}
                </div>
                @else
                <div class="alert alert-warning">
                    <font class="text-warning text-bold">
                        <i class="fa fa-warning"></i> No feedbacks yet!
                    </font>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="feedback">
        <div class="modal-dialog modal-sm" role="document">
            <form method="POST" action="{{ asset('feedback/status') }}" class="form-submit">
                {{ csrf_field() }}
                <input type="hidden" name="currentID" id="currentID" />
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-envelope"></i> USER'S FEEDBACK
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Sender</label>
                            <input type="text" disabled class="form-control" id="sender"/>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" id="message" style="resize: none;" rows="6" disabled></textarea>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" style="resize: none;" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button title="Close" type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        <button title="Delete" type="button" data-target="#removeFeedback" data-toggle="modal" value="true" name="remove" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></button>
                        <button title="Pending" type="submit" value="true" name="pending" class="btn btn-warning btn-sm" ><i class="fa fa-hourglass"></i></button>
                        <button title="Seen" type="submit" value="true" name="seen" class="btn btn-warning btn-sm" ><i class="fa fa-eye"></i></button>
                        <button title="Done" type="submit" value="true" name="done" class="btn btn-success btn-sm" ><i class="fa fa-check"></i></button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" role="dialog" id="removeFeedback">
        <div class="modal-dialog modal-sm" role="document">
            <form method="POST" action="{{ asset('feedback/status') }}" class="form-submit">
                {{ csrf_field() }}
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <p class="text-danger">Are you sure you want to delete this feedback?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        <button type="submit" value="true" name="remove"  class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i> Yes</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('js')
    <?php
    $status = session('status');
    ?>
    @if($status=='updated')
        <script>
            Lobibox.notify('success', {
                msg: 'Password successfully changed!'
            });
        </script>
    @endif

    @if($status=='done')
        <script>
            Lobibox.notify('success', {
                msg: 'Feedback successfully solved!'
            });
        </script>
    @endif

    @if($status=='remove')
        <script>
            Lobibox.notify('success', {
                msg: 'Feedback successfully removed!'
            });
        </script>
    @endif

    <script>
        <?php echo 'var url = "'.asset('feedback/view').'";';?>
        $('.view-feedback').on('click',function(){
            $('#sender').val('Loading...');
            $('#message').html('Loading...');
            $('#remarks').html('Loading...');
            var id = $(this).data('id');
            $.ajax({
                url: url+'/'+id,
                type: 'GET',
                success: function(jim) {
                    console.log(jim.sender);
                    $('#currentID').val(id);
                    $('#sender').val(jim.sender);
                    $('#message').html(jim.message);
                    $('#remarks').html(jim.remarks);
                }
            });
        });
    </script>
@endsection