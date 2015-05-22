<link rel="stylesheet" href="css/dialog.css">
<div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Sign Up For Free</h4>
            </div>
            <div class="modal-body">
                <div>
                    <p id="error-message-signup" style="color:red;"></p>
                </div>
                <form class="signup-form validate-form" id="sign-up-form" novalidate>
                    <div class="create-box">
                        <div class="input-row js-user-profile-fields left">
                            <label>Your name</label>
                            <input autocomplete="off" name="user_name" required="required" type="text">
                        </div>
                        <div class="input-row left">
                            <label>Your email address</label>
                            <input autocomplete="off" id="user_email"
                                   name="user_email" required="required" type="email" value="">

                            <div class="js-email-check-note email-check-note"></div>
                        </div>
                        <div class="input-row left">
                            <label>Choose a password (5 character min.)</label>
                            <input autocomplete="off" id="user_password"
                                   name="user_password" required="required" type="password">
                        </div>
                        <input class="modal-submit-btn" name="commit" type="submit" value="Create Account">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>