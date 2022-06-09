<div class="modal fade" role="dialog" id="specialist_modal" style="overflow: auto">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body specialist_body">
                <center>
                    <img src="{{ asset('resources/img/loading.gif') }}" alt="">
                </center>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="remove_specialist">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{ asset('specialist/delete') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" class="user_id">
                    <input type="hidden" name="username" class="username">
                    <fieldset>
                        <legend><i class="fa fa-trash"></i> Remove Specialist</legend>
                    </fieldset>
                    <div class="alert alert-danger">
                        <label for="" class="text-danger">Are you sure you want to delete
                            <b><small class="delete_name"></small>'s</b> information?
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-check"></i> Yes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
