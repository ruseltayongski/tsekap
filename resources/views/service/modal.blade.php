<div class="modal fade" tabindex="-1" role="dialog" id="addService">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('services/save') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-stethoscope"></i> Add Service</legend>
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" required>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Save</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="serviceInfo">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('services/update') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-stethoscope"></i> Service Info</legend>
                        <input type="hidden" name="currentID" id="currentID">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" id="code" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" id="description" required>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="button" data-toggle="modal" data-target="#remove" data-dismiss="modal" class="remove btn btn-danger btn-sm" name="delete"><i class="fa fa-trash"></i> Delete</button>
                    <button type="submit" class="btn btn-success btn-sm" name="update"><i class="fa fa-check"></i> Update</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->