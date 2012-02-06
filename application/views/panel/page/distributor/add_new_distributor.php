<style>
    .widefat{width:550px;}
</style>
<script type="text/javascript">
    jQuery(function(){
        jQuery('#display_sel_pck2').hide();
        jQuery( "#datepicker" ).datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>asset/images/calendar.gif",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            dateFormat:"yy-m-d",
            numberOfMonths: 3,
            showButtonPanel: false
        });
        jQuery('#country').change(function(){
            uid = jQuery(this).val();
            load_to_val('_admin/post_data/get_phone_code/'+uid,'.countrycode');
            load_no_image('_admin/post_data/get_province/'+uid,'#block_province');
            load_no_image('_admin/post_data/get_city/'+uid,'#block_city');
            load_no_image('_admin/post_data/get_regional/'+uid,'#block_regional');
        });
    });
    function get_city()
    {
        uid = jQuery('#province').val();
        load_no_image('_admin/post_data/get_regional/'+uid,'#block_regional');
        load_no_image('_admin/post_data/get_city/'+uid,'#block_city');
		
    }
    function reset_password(){
        jQuery('#password').fadeIn();
    }
    function add_new_distributor()
    {
        var username = jQuery('#username').val();
        var lusername = jQuery('#username').val().length;
        var pack = jQuery('#pack').val();
        var password = jQuery('#password').val();
        var lpwd = jQuery('#password').val().length;
        var regional = jQuery('#regional').val();
        var firstname = jQuery('#firstname').val();
        var lastname = jQuery('#lastname').val();
        var dob = jQuery('#datepicker').val();
        var email = jQuery('#email').val();
        var country = jQuery('#country').val();
        var mobilephone = jQuery('#mobilephone').val();
        var province = jQuery('#province').val();
        var address = jQuery('#address').val();
        var regional = jQuery('#regional').val();
        var city = jQuery('#city').val();
        var bank_account_number = jQuery('#bank_account_number').val();
        var bank_name = jQuery('#bank_name').val();
        var name_on_bank_account = jQuery('#name_on_bank_account').val();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(!username){
            jQuery('#info-saving').text("Username can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }else{
            if(lusername<4){
                jQuery('#info-saving').text("Username is to short, min 4 character");
                jQuery('#info-saving').addClass('update-nag');
                return false; 
            }
        }
        if(!pack){
            jQuery('#info-saving').text("Package can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false;
        }else{
            var pack2 = jQuery('#package2').val();
            if(pack == '3'){
                if(!pack2){
                    jQuery('#info-saving').text("Detail package VIP can't be empty");
                    jQuery('#info-saving').addClass('update-nag');
                    return false;
                }
            }
        }
        if(!password){
            jQuery('#info-saving').text("Password can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }else{
            if(lpwd<6){
                jQuery('#info-saving').text("password is to short, min 6 character");
                jQuery('#info-saving').addClass('update-nag');
                return false; 
            }
        }
        
        if(!firstname){
            jQuery('#info-saving').text("Firstname can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }
        
        if(!lastname){
            jQuery('#info-saving').text("Lastname can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }
        
        if(!dob){
            jQuery('#info-saving').text("Date of birth can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }
        
        if(!email){
            jQuery('#info-saving').text("Email can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }else{
            if(!emailReg.test(email)){
                jQuery('#info-saving').text("Enter a valid email.");
                jQuery('#info-saving').addClass('update-nag');
                return false;
            }
        }
        
        if(!country){
            jQuery('#info-saving').text("Country can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }
        if(!mobilephone){
            jQuery('#info-saving').text("Mobile phone can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }else{
            if(isNaN(mobilephone)){
                jQuery('#info-saving').text("Mobile phone isn't a number");
                jQuery('#info-saving').addClass('update-nag');
                return false; 
            }
        }
        if(!province){
            jQuery('#info-saving').text("Province can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }
        if(!city){
            jQuery('#info-saving').text("City can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false;
        }
        if(!address){
            jQuery('#info-saving').text("Address can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }
        if(!regional){
            jQuery('#info-saving').text("Regional can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false;
        }  
        if(!bank_account_number){
            jQuery('#info-saving').text("Bank account number can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }else{
            if(isNaN(bank_account_number)){
                jQuery('#info-saving').text("Bank account isn't a number");
                jQuery('#info-saving').addClass('update-nag');
                return false; 
            }
        }
        if(!bank_name){
            jQuery('#info-saving').text("Bank name can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }
        if(!name_on_bank_account){
            jQuery('#info-saving').text("Name on bank account can't be empty");
            jQuery('#info-saving').addClass('update-nag');
            return false; 
        }
        jQuery('#info-saving').addClass('update-nag');
        send_form(document.add_member,'_admin/saving_new_member','#info-saving');
    }
    function select_package()
    {
        e = jQuery('#pack').val();
        if(e=='3')
        {
            jQuery('#display_sel_pck2').show();
            load_no_image('member/post_data/get_pck2/'+e,'#block_pck2');
        }
        else
        {
            jQuery('#display_sel_pck2').hide();
            jQuery('#package2').val('');
        }
    }
</script>
<br /><br />
<table width="550px;">
    <tr>
        <td><strong>*) Field is required.</strong></td>
        <td align="right" width="120"><a class="button" href="javascript:void();" onclick="add_new_distributor();">Save all change</a></td>
    </tr>
</table>
<br />
<form name="add_member">
    <table class="wp-list-table widefat" cellspacing="0">
        <thead>
            <tr>
                <th width="30%">
                    <a href="#"><span>Field</span></a>
                </th>
                <th width="70%">
                    <a href="#">Data</a>
                </th>
        </thead>
        <tbody id="result-show-search-url">
            <tr>
                <td>Username *</td>
                <td>
                    <input type="text" name="username" id="username" />
                </td>
            </tr>

            <tr>
                <td>Package *</td>
                <td>
                    <?php
                    $id = "id='pack' class='dropdown' onchange='select_package()'";
                    echo form_dropdown('package', $package, $page['package'], $id);
                    ?>
                </td>
            </tr>

            <tr id="display_sel_pck2">
                <td>VIP Package</td>
                <td id="block_pck2"></td>
            </tr>

            <tr>
                <td>Password *</td>
                <td><input type="text" name="password" id="password"></td>
            </tr>

            <tr>
                <td>First Name *</td>
                <td><input type="text" name="firstname" id="firstname"></td>
            </tr>

            <tr>
                <td>Last Name *</td>
                <td><input type="text" name="lastname" id="lastname"></td>
            </tr>

            <tr>
                <td>DOB *</td>
                <td><input type="text" name="dob" id="datepicker"></td>
            </tr>

            <tr>
                <td>Email *</td>
                <td><input type="text" name="email" id ="email"></td>
            </tr>

            <tr>
                <td>Country *</td>
                <td>
                    <?php
                    $id = "id='country'";
                    echo form_dropdown('country', $country, '', $id);
                    ?>
                </td>
            </tr>

            <tr>
                <td>Home/Office Phone *</td>
                <td>
                    <input type="text" class="countrycode" name="contrycode"  readonly="readonly" size="4" />
                    <input type="text" id="homephone" name="homephone"></td>
            </tr>

            <tr>
                <td>Mobile/Cellular Phone *</td>
                <td>
                    <input type="text" class="countrycode" name="contrycode"  readonly="readonly" size="4" />
                    <input type="text" name="mobilephone" id ="mobilephone">
                </td>
            </tr>

            <tr>
                <td>State/Province*</td>
                <td id="block_province">
                    <?php
                    $id = "id='province' onchange='get_city();'";
                    echo form_dropdown('province', $province, '', $id);
                    ?>
                </td>
            </tr>

            <tr>
                <td>City *</td>
                <td id="block_city">
                    <?php
                    $id = "id='city'";
                    echo form_dropdown('city', $city, '', $id);
                    ?>
                </td>
            </tr>

            <tr>
                <td>Street Address*</td>
                <td>
                    <textarea rows="5" name="address" id="address"></textarea>
                </td>
            </tr>

            <tr>
                <td>Regional *</td>
                <td id="block_regional">
                    <?php
                    $id = "id='regional'";
                    echo form_dropdown('regional', $city, '', $id);
                    ?>
                </td>
            </tr>

            <tr>
                <td>Bank Account Number *</td>
                <td><input type="text" name="bank_account_number" id ="bank_account_number" /></td>
            </tr>

            <tr>
                <td>Bank Name *</td>
                <td>
                    <input type="text" name="bank_name" id="bank_name" />
                </td>
            </tr>

            <tr>
                <td>Name On Bank Account *</td>
                <td><input type="text" name="name_on_bank_account" id="name_on_bank_account" /></td>
            </tr>

        </tbody>
    </table>
</form>