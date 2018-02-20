<div class="modal fade" role="dialog" id="changeDate">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('user/services/date') }}" class="form-submit">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-calendar"></i> Change Date</legend>
                        <div class="form-group">
                            <label>Select Date</label>
                            <input type="date" class="form-control" name="date" min="2017-01-01" max="{{ date('Y-m-d') }}" />
                        </div>

                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm btn-submit"><i class="fa fa-check"></i> Change</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->