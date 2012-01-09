<script type="text/javascript">
    var kirim = true;
    function check_password()
    {
        p = document.getElementById('password').value;
        p2 = document.getElementById('password1').value;
        if(p != p2)
        {
            document.getElementById('errorpassword').innerHTML='Password not same';
            kirim = false;
        }
    }
    function check_validation()
    {
        if(kirim)
        {
            jQuery.post("<?php echo site_url('admin-tour/account-settings/update'); ?>",jQuery('#user_account').serialize(), 
               function(data) {
                   jQuery('#ac_update').addClass('error');
                   jQuery('#ac_update').text(data);
               });
        }
    }
</script>
<div class="content-admin-right">
    <div class="tx-rwadminhotelmlm-pi1 isi-content-admin-tour">
        <div id="ac_update"></div>
        <br />
        <form method="POST" name="user_account" id="user_account" enctype="multipart/form-data">
            <table cellspacing="1" cellpadding="0" border="0" class="tablesorter">
                <tbody>
                    <tr class="odd">
                        <td>Username</td>
                        <td>
                            <input type="text" name="username" value="<?php echo $username; ?>" readonly="readonly">
                        </td>
                        <td>
                           
                        </td>
                    </tr>
                    
                    <tr class="even" id="travel_pack">
                        <td>Password</td>
                        <td>
                            <input type="password" name="password" id="password">
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    
                    <tr class="odd" id="travel_pack">
                        <td>Confirm Password</td>
                        <td>
                            <input type="password" name="password1" id="password1" onchange="check_password()">
                        </td>
                        <td>
                            <div style="color: red;" id="errorpassword"></div>
                        </td>
                    </tr>
                    
                    <tr class="even" id="vip_pack">
                        <td>Real Name</td>
                        <td>
                           <input type="text" name="name" value="<?php echo $real_name; ?>">
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <input type="button" name="submit" value="Save" onclick="check_validation();">
        </form>
    </div>
</div>
