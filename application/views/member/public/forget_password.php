<div class="container">
    <div id="show-ctn-member"> 
        <div class="tx-rwmembermlm-pi1"> 
            <div id="home-office" class="sponsor">
                <div id="home-top">
                    <h2>Member &gg; Profile</h2>
                </div>
                <div id="home-bottom">
                    <p><strong>* ) To reset the 2nd password please fill this form</strong></p>
                    <br/>
                    <p style="color: red; margin: 5px 0;"><?php echo $this->session->flashdata('info'); ?></p>
                    <form action="<?php echo site_url('member/profile/reset-password'); ?>" method="post">
                        <table>
                            <tr>
                                <td>Email</td>
                                <td><input type="text" name="log"></td>
                                <td colspan="2" align="right"><input type="submit" value="Reset Password"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

