<div class="content">
    <div class="container">
        <div id="hotel-login"><a id="c60"></a>
            <div class="csc-header csc-header-n1">
                <h1 class="csc-firstHeader">login</h1>
            </div>
            <div class="tx-felogin-pi1">
                <div class="error-msg"><?php echo $this->session->flashdata('info'); ?></div>
                <form action="<?php echo site_url('admin-tour/check-login'); ?>" target="_top" method="post" onsubmit="">
                    <fieldset><legend>Login</legend>
                        <div><label for="user">Username:</label><input type="text" id="user" name="user" value="" /></div>
                        <div><label for="pass">Password:</label><input type="password" id="pass" name="pass" value="" /></div>
                        <div><input type="submit" name="submit" value="Login" /></div>
                        <div class="felogin-hidden"><input type="hidden" name="logintype" value="login" /><input type="hidden" name="pid" value="66" /><input type="hidden" name="redirect_url" value="admin-hotel/login/sub-menu-admin/profile/" /><input type="hidden" name="tx_felogin_pi1[noredirect]" value="0" /></div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
