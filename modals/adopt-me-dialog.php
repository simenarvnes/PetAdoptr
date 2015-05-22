<link rel="stylesheet" href="css/dialog.css">
<div class="modal fade" id="adopt-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-big">
        <div class="modal-content">
            <div class="adopt-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="adoptme-title">Interested in adopting <?php echo $name; ?> ?</h4>
            </div>
            <div class="adoptme-body">
                <div>
                    <p id="error-message-adoptme" style="color:red;"></p>
                </div>
                <p>
                    We will forward your message to the organization and they will reply directly to your inquiry using
                    your email address displayed below.
                    <br><br>
                </p>

                <form class="adopt-form validate-form" id="adopt-form" novalidate>
                    <div class="create-box">
                        <div class="input-row js-user-profile-fields left">
                            <label class="red">Confirm or correct the email address below. Replies will be sent
                                here.</label>
                            <?php
                            if (isset($_SESSION['login_user'])) {
                                echo '<input name="from" type="text" value="' . $_SESSION['login_user'] . '">';
                            } else {
                                echo '<input name="from" type="text" value="">';
                            }
                            ?>
                        </div>
                        <div class="input-row left">
                            <label>Subject</label>

                            <?php echo "<input name='subject' placeholder='I saw your pet on Pet Adoptr and want to adopt him/her' type='text'>"; ?>
                            <div class="js-email-check-note email-check-note"></div>
                        </div>
                        <div class="input-row left">
                            <label>Message</label>
                            <textarea class="adopt-textarea" cols="58" name="body"
                                      placeholder="Please write your message here." rows="8"></textarea>
                        </div>

                        <button class="modal-submit-btn" type="submit">Send Message</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>