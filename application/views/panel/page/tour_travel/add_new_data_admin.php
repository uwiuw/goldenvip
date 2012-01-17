<br />
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/tour_travel/tour.js" />
<script type="text/javascript">
    function cek_data_dan_kirim(){
        var agen = jQuery('#agen').val();
        var username = jQuery('#username').val();
        var password = jQuery('#password').val();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = jQuery('#email').val();
        jQuery('#error_agen').text("");
        jQuery('#error_username').text("");
        jQuery('#error_pwd').text("");
        jQuery('#error_email').text("");
        
        if(!agen){
            jQuery('#error_agen').text("can't be empty");
            return false;
        }
        if(!email){
            jQuery('#error_email').text("can't be empty");
            return false;
        }else{
            if(!emailReg.test(email)){
                jQuery('#error_email').text("enter a valid email address.");
                return false;
            }
        }
        if(!username){
            jQuery('#error_username').text("can't be empty");
            return false;
        }
        if(!password){
            jQuery('#error_pwd').text("can't be empty");
            return false;
        }
        jQuery("#info-saving").addClass('update-nag');
        send_form(document.form_agen_travel,'_admin/tour_travel/save_agen_tour',"#info-saving");
        return true;
    }
    function cek_data_dan_kirim2(){
        var agen = jQuery('#agen').val();
        var username = jQuery('#username').val();
        var password = jQuery('#password').val();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = jQuery('#email').val();

        jQuery('#error_agen').text("");
        jQuery('#error_username').text("");
        jQuery('#error_pwd').text("Put blank if not changed");
        jQuery('#error_email').text("");
        if(!agen){
            jQuery('#error_agen').text("can't be empty");
            return false;
        }
        if(!email){
            jQuery('#error_email').text("can't be empty");
            return false;
        }else{
            if(!emailReg.test(email)){
                jQuery('#error_email').text("enter a valid email address.");
                return false;
            }
        }
        if(!username){
            jQuery('#error_username').text("can't be empty");
            return false;
        }
        jQuery("#info-saving").addClass('update-nag');
        send_form(document.form_agen_travel,'_admin/tour_travel/update_agen_tour',"#info-saving");
        return true;
    }
    function generate_pwd_agen(){
        jQuery('#password').val('1q2w3e');
    }
</script>
<form name="form_agen_travel" onsubmit="tour_travel_cek_form()" method="post">
    <table>
        <tr>
            <td colspan="3" align="left">&Colon; Tour & Travel &gg; Add Admin Tour </td>
        </tr>
        <tr>
            <td height="25px" id="reload_data"></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Agen Name</td>
            <td>
                <input type="text" name="agen" id="agen" value="<?php echo $agen; ?>">
                <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            </td>
            <td id="error_agen" colspan="2"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <input type="text" name="email" id="email" value="<?php echo $email; ?>">
            </td>
            <td id="error_email"></td>
        </tr>
        <tr>
            <td>Username to login</td>
            <td><input type="text" name="username" id="username" value="<?php echo $username; ?>" <?php echo $read_only; ?>></td>
            <td id="error_username" colspan="2"></td>
        </tr>
        <tr>
            <td>
                Password
            </td>
            <td>
                <input type="text" name="password" id="password">
            </td>
            <td>
                <input type="button" class="button" value="Generate Password" onclick="generate_pwd_agen();">
            </td>
            <td id="error_pwd"><?php echo $error_pwd; ?></td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <input type="button" value="<?php echo $btn_submit; ?>" class="button" onclick="<?php echo $action; ?>">
            </td>
            <td></td>
        </tr>
    </table>
</form>