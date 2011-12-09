<style>
	.widefat{width:550px;}
</style>
<script type="text/javascript">
	jQuery(function(){
		jQuery('#password').hide();
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
	function update_data_member()
	{
		send_form(document.update_member,'_admin/update_data_member','#info-saving');
	}
</script>
<br /><br />
<table width="550px;">
	<tr>
    	<td><strong>*) Field is required.</strong></td>
        <td align="right" width="120"><a class="button" href="javascript:void();" onclick="update_data_member();">Save all change</a></td>
        <td align="right" width="120"><a class="button" href="javascript:void();" onclick="reset_password();">Reset Password</a></td>
    </tr>
</table>
<br />
<form name="update_member">
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
        	<td>Create Date</td>
            <td><?php echo date('d M, Y H:i:s',$page['crdate']); ?></td>
        </tr>
       
        <tr>
        	<td>Username *</td>
            <td>
            	<input type="text" readonly value="<?php echo $page['username']; ?>">
                <input type="hidden" name="uid" value="<?php echo $page['uid']; ?>" />
            </td>
        </tr>
 		
        <tr id="password">
        	<td>New Password *</td>
            <td><input type="text" name="password"></td>
        </tr>
               
        <tr>
        	<td>First Name *</td>
            <td><input type="text" value="<?php echo $page['firstname'];?>" name="firstname"></td>
        </tr>
        
        <tr>
        	<td>Last Name *</td>
            <td><input type="text" value="<?php echo $page['lastname'];?>" name="lastname"></td>
        </tr>
        
        <tr>
        	<td>DOB *</td>
            <td><input type="text" value="<?php echo $page['dob'];?>" name="dob" id="datepicker"></td>
        </tr>
        
        <tr>
        	<td>Email *</td>
            <td><input type="text" value="<?php echo $page['email'];?>" name="email"></td>
        </tr>
        
        <tr>
        	<td>Country *</td>
            <td>
            	<?php 
					$id = "id='country'";
					echo form_dropdown('country',$country,$page['country'],$id); 
				?>
            </td>
        </tr>
        
        <tr>
        	<td>Home/Office Phone *</td>
            <td>
            	<input type="text" class="countrycode" name="contrycode" value="<?php echo $code[$page['country']]; ?>" readonly="readonly" size="4" />
                <input type="text" value="<?php $string = trim($page['homephone'],$code[$page['country']]."-"); echo $string; ?>" id="homephone" name="homephone"></td>
        </tr>
        
        <tr>
        	<td>Mobile/Cellular Phone *</td>
            <td>
            	<input type="text" class="countrycode" name="contrycode" value="<?php echo $code[$page['country']]; ?>" readonly="readonly" size="4" />
            	<input type="text" value="<?php $string = trim($page['mobilephone'],$code[$page['country']]."-"); echo $string; ?>" name="mobilephone">
           	</td>
        </tr>
        
        <tr>
        	<td>State/Province*</td>
            <td id="block_province">
            	<?php 
					$id = "id='province' onchange='get_city();'";
					echo form_dropdown('province',$province,$page['province'],$id); 
				?>
            </td>
        </tr>
        
        <tr>
        	<td>City *</td>
            <td id="block_city">
				<?php 
					$id = "id='city'";
					echo form_dropdown('city',$city,$page['city'],$id); 
				?>
            </td>
        </tr>
        
        <tr>
        	<td>Street Address*</td>
            <td>
            	<textarea rows="5" name="address"><?php echo $page['address']; ?></textarea>
            </td>
        </tr>
        
        <tr>
        	<td>Regional *</td>
            <td id="block_regional">
				<?php 
					echo form_dropdown('regional',$city,$page['regional']); 
				?>
            </td>
        </tr>
        
        <tr>
        	<td>Bank Account Number *</td>
            <td><input type="text" value="<?php echo $page['bank_account_number']; ?>" name="bank_account_number" /></td>
        </tr>
        
        <tr>
        	<td>Bank Name *</td>
            <td>
           		<?php
					echo form_dropdown('bank_name',$bank,$page['bank_name']);
				?>
           	</td>
        </tr>
        
        <tr>
        	<td>Name On Bank Account *</td>
            <td><input type="text" value="<?php echo $page['name_on_bank_account']; ?>" name="name_on_bank_account" /></td>
        </tr>
        
    </tbody>
</table>
</form>