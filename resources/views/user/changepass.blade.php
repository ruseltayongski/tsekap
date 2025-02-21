<?php
    // Get facilities if user is Admin or Provincial Level
    $facilities = null;
    if ($user->user_priv == 1 || $user->user_priv == 3) {
        $facilities = \App\Facility::all(); // Assuming you have a Facility model
    }
?>

<div class="modal fade" tabindex="-1" role="dialog" id="changePass">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('users/adminchangepass') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-key"></i> Change User's Password</legend>
                    </fieldset>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Password must be at least 8 characters long, contain at least one number, one special character, and one uppercase letter" class="form-control" id="password1" name="password" required onkeyup="checkPassword()">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Confirm password must be at least 8 characters long, contain at least one number, one special character, and one uppercase letter" class="form-control" id="password2" name="confirm" required onkeyup="checkPassword()">
                        <div class="has-error text-bold text-danger hide" id="passwordError">
                            <small>Password does not match!</small>
                        </div>
                        <div class="has-match text-bold text-success hide" id="passwordMatch">
                            <small><i class="fa fa-check-circle"></i> Password matched!</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()"> Show Password
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm btn-save"><i class="fa fa-check"></i> Save</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
function checkPassword() {
    var password1 = document.getElementById('password1').value;
    var password2 = document.getElementById('password2').value;
    var errorDiv = document.getElementById('passwordError');
    var matchDiv = document.getElementById('passwordMatch');

    if (password1 !== password2) {
        errorDiv.classList.remove('hide');
        matchDiv.classList.add('hide');
    } else {
        errorDiv.classList.add('hide');
        matchDiv.classList.remove('hide');
    }
}

function togglePasswordVisibility() {
    var password1 = document.getElementById('password1');
    var password2 = document.getElementById('password2');
    if (password1.type === 'password') {
        password1.type = 'text';
        password2.type = 'text';
    } else {
        password1.type = 'password';
        password2.type = 'password';
    }
}
</script>
