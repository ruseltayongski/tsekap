<div class="modal fade" role="dialog" id="checkUserProfile">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-user-plus"></i> PROFILE VERIFICATION
            </div>
            <div class="modal-body verify_user_body">
                <table class="table table-input table-bordered table-hover" border="1">
                    <tr class="has-group">
                        <td>First Name :</td>
                        <td><input type="text" name="fname" class="fname form-control" required /> </td>
                    </tr>
                    <tr>
                        <td>Middle Initial :</td>
                        <td><input type="text" name="mname" class="mname form-control" /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Last Name :</td>
                        <td><input type="text" name="lname" class="lname form-control" required /> </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-closeUserProfile" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <a type="button" class="btn btn-success btn-checkUserProfile"><i class="fa fa-search"></i> Check</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->