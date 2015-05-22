<link rel="stylesheet" href="css/dialog.css">
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <div>
                    <p id="error-message-login" style="color:red;"></p>
                </div>
                <form class="login-form validate-form" id="login-form" novalidate>
                    <div class="create-box">
                        <div class="input-row left">
                            <label>Email Address</label>
                            <input autocomplete="off" id="user_email"
                                   name="email" required="required" type="email" value="">

                            <div class="js-email-check-note email-check-note"></div>
                        </div>
                        <div class="input-row left">
                            <label>Password</label>
                            <input autocomplete="off" id="user_password"
                                   name="password" required="required" type="password">
                        </div>
                        <button type="submit" class="modal-submit-btn">Login</button>
                        <div class="center-text">
                            <label>Or <a data-toggle="modal" data-target="#signup-modal">sign up</a> today!</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>