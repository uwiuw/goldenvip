<script type="text/javascript">
    function validasi_form(){
        var pwd = jQuery('#pwd').val();
        var pwd2 = jQuery('#pwd2').val();
        var lpw = jQuery('#pwd').val().length; 
        var lpw2 = jQuery('#pwd2').val().length;
        
        jQuery('#error_pwd').text("");
        jQuery('#error_pwd2').text("");
        
        if(lpw < 6){
            jQuery('#error_pwd').text("password is to short, min 6 character");
            return false;
        }
        
        if(lpw2 < 6){
            jQuery('#error_pwd2').text("password is to short, min 6 character");
            return false;
        }
        
        if(!pwd){
            jQuery('#error_pwd').text("Can't be empty");
            return false;
        }
        if(!pwd2){
            jQuery('#error_pwd2').text("Can't be empty");
            return false;
        }
        if(pwd != pwd2){
            jQuery('#error_pwd2').text("not same!");
            return false;
        }
        
        send_form(document.account_settings,"_admin/saving_account",'#info-saving');
        jQuery('#info-saving').addClass('update-nag');
    }
</script>
<p>&Colon; Account Settings</p>
<form name="account_settings">
    <table>
        <tr>
            <td>Password</td>
            <td><input type="password" name="pwd" id="pwd"/></td>
            <td id="error_pwd"></td>
        </tr>
        <tr>
            <td>Comfirmed Password</td>
            <td><input type="password" name="pwd2" id="pwd2" /></td>
            <td id="error_pwd2"></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><input type="button" class="button" value="Update" onclick="validasi_form();"/></td>
        </tr>
    </table>
</form>