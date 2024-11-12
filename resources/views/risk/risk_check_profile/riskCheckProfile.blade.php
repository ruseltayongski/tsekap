<div class="modal fade" id="riskCheckProfile" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-user-plus"></i> PROFILE VERIFICATION
            </div>
            <div class="modal-body default-body">
                <table class="table table-input table-bordered table-hover">
                    <tr class="has-group">
                        <td>First Name :</td>
                        <td><input type="text" name="fname" class="fname form-control" required /> </td>
                    </tr>
                    <tr>
                        <td>Middle Name :</td>
                        <td><input type="text" name="mname" minlength="1" class="mname form-control" /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Last Name :</td>
                        <td><input type="text" name="lname" class="lname form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Birth Date :</td>
                        <td><input type="date" name="dob" class="dob form-control" required /> </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer default-footer">
                <button type="button" class="btn btn-success btn-riskCheckProfiles"><i class="fa fa-search"></i> Check</button> 
            </div>
            <div class="modal-body searched-body" style="display: none;">
                
            </div>
            <div class="modal-footer searched-footer" style="display: none;">
                <div class="col-md-6" style="display:flex;">
                    <button type="button" class="btn btn-primary btn-return-verify"><i class ="fa fa-arrow-left"></i> Return</button>
                </div>
                <div class="col-md-6" style="display:flex; justify-content:end">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
