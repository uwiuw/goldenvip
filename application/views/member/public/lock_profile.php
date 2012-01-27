<div class="container">
    <div id="show-ctn-member"> 
        <div class="tx-rwmembermlm-pi1"> 
            <div id="home-office" class="sponsor">
                <div id="home-top">
                    <h2>Member &gg; Profile</h2>
                </div>
                <div id="home-bottom">
                    <p><strong>* ) To access this page requires user authentication</strong></p>
                    <br/>
                    <p style="color: red; margin: 5px 0;"><?php echo $this->session->flashdata('info'); ?></p>
                    <form action="<?php echo site_url('member/open_profile'); ?>" method="post">
                        <table>
                            <tr>
                                <td>Username</td>
                                <td><input type="text" name="log"></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td><input type="password" name="pwd"></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right"><input type="submit" value="Submit"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="<?php echo site_url('member/profile/forget-secondary-password'); ?>">Forget Password</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
