<div class="modal fade" role="dialog" id="remove">
    <div class="modal-dialog modal-sm" role="document">
        <form method="GET" action="{{ asset('delete') }}">
            {{ csrf_field() }}
            <div class="modal-content">

                <div class="modal-body">
                    <div class="alert alert-danger">
                        <p class="text-danger">Are you sure you want to delete this record?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    <button type="submit" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i> Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="downloadData">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('user/report/download') }}" class="form-submit">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-calendar"></i> Select Year
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control chosen-select" name="year" required>
                            <option value="">Select Year...</option>
                            <?php $yearNow = date('Y'); ?>
                            <?php $current = date('Y'); ?>
                            @for($i=10;$i>0;$i--)
                                <option @if($current==$yearNow) selected @endif>{{ $yearNow }}</option>
                                <?php $yearNow-- ;?>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-sm btn-submit" ><i class="fa fa-download"></i> Download</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="uploadData">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('user/report/upload') }}" enctype="multipart/form-data" class="form-submit">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-file-excel-o"></i> UPLOAD DATA
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="file" class="form-control" required accept=".DOH7" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-sm btn-submit" ><i class="fa fa-upload"></i> Upload</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="feedback">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('feedback/send') }}" class="form-submit">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-envelope"></i> SEND FEEDBACK
                </div>
                <div class="modal-body">
                    <?php
                        $user = Auth::user();
                        $name = $user->fname.' '.$user->mname.' '.$user->lname.' '.$user->suffix;
                        $muncity = App\Muncity::find($user->muncity)->description;
                        $province = App\Province::find($user->province)->description;
                        $location = $muncity.', '.$province;
                    ?>
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" readonly class="form-control" value="{{ $name }}"/>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" readonly class="form-control" value="{{ $location }}"/>
                    </div>
                    <div class="form-group">
                        <label>Message:</label>
                        <textarea class="form-control" style="resize: none;" rows="8" name="message"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-sm btn-submit" ><i class="fa fa-send"></i> Send</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->