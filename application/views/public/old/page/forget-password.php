<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/admin-hotel.css" type="text/css">
<div class="container">
    <div id="hotel-login-backoffice"><a id="c87"></a>
        <div class="tx-felogin-pi1">
            <div class="error-msg"><?php if($this->session->flashdata('info')) echo $this->session->flashdata('info'); ?></div>
            <form method="post" action="<?php echo site_url('member/reset-password');?>">
                <fieldset><legend>Reset Password</legend>
                    <div><label for="tx_felogin_pi1[forgot_email]">Username or email address:</label><input type="text" id="tx_felogin_pi1[forgot_email]" name="username"></div>
                    <div><input type="submit" value="Reset Password" name="submit"></div>
                </fieldset>
            </form>
            <p><a href="<?php echo site_url('member/back-office/'); ?>">Return to login form</a>&nbsp;</p>
        </div>
    </div>
</div>