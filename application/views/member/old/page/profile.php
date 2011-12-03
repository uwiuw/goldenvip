<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/ui-lightness/base/jquery.ui.all.css" type="text/css" media="screen"> 
<script src="<?php echo base_url(); ?>asset/js/lib/jquery-ui-1.8.16.custom.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.dialog.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.core.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.datepicker.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/public.js"></script>

<script type="text/javascript">
	site = "<?php echo site_url(); ?>";
	jQuery(function(){
		jQuery('.password').hide();
		jQuery( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url(); ?>asset/images/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			dateFormat:"d MM, yy",
			numberOfMonths: 3,
			showButtonPanel: false
		});
		jQuery('#country').change(function(){
			uid = jQuery(this).val();
			load_to_val('member/post_data/get_phone_code/'+uid,'.countrycode');
			load_no_image('member/post_data/get_province/'+uid,'#block_province');
			load_no_image('member/post_data/get_city/'+uid,'#block_city');
			load_no_image('member/post_data/get_regional/'+uid,'#block_regional');
		});
		jQuery('#tablesorter tr:even').addClass('odd');
		jQuery('#change-pwd').click(function(){
			if(jQuery('.password').is(':visible')){
				jQuery(this).val('Change Password');
				cancel_reset_password();
			}
			else
			{
				jQuery(this).val('Cancel Change Password');
				reset_password();
			}
		});
		jQuery("#myTable").tablesorter();
	});
	
	
	function get_city()
	{
		uid = jQuery('#province').val();
		load_no_image('member/post_data/get_regional/'+uid,'#block_regional');
		load_no_image('member/post_data/get_city/'+uid,'#block_city');
		
	}
	
	function reset_password(){
		jQuery('.password').fadeIn();
	}
	
	function cancel_reset_password(){
		jQuery('.password').fadeOut();
	}
	
	function check_val_pwd()
	{
		if(jQuery('input#password2').val() != jQuery('input#password').val())
		{
			jQuery('.info').text('Password Not Same');
		}
	}
</script>
<div class="container">
<div id="show-ctn-member"> 
	<div class="tx-rwmembermlm-pi1"> 
		<div id="home-office" class="sponsor">
			<div id="home-top">
				<h2>Report » Genealogy</h2>
            </div>
			<div id="home-bottom">
				<p><strong>* ) Field should be completed and not empty</strong></p>
				<div align="right">
                    <input type="button" value="Change Password" id="change-pwd" />
                </div>
				
<br />
<table class="tablesorter" id="tablesorter" cellspacing="1" cellpadding="0">
    <thead>
        <tr>
            <th width="30%">
                <a href="#"><span>Field</span></a>
            </th>
            <th width="70%">
                <a href="#">Data</a>
            </th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td>Create Date</td>
            <td>
				<?php 
					$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','crdate',$this->session->userdata('member'),'uid'); 
					echo date('d M, Y H:i:s',$d['crdate']);
				?>
            </td>
        </tr>
        
        <tr>
        	<td>Username *</td>
            <td><input type="text" readonly value="<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$this->session->userdata('member'),'uid'); echo $d['username'];  ?>"></td>
        </tr>
 		
        <tr class="password">
        	<td>New Password *</td>
            <td><input type="password" name="password" id = "password"></td>
        </tr>
        
        <tr class="password">
        	<td>Confirm Password *</td>
            <td><input type="password" name="password2"  id = "password2" onchange="check_val_pwd();"><font color="#FF0000" class="info"></font></td>
        </tr>
               
        <tr>
        	<td>First Name *</td>
            <td><input type="text" value="<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','firstname',$this->session->userdata('member'),'uid'); echo $d['firstname']; ?>" name="firstname"></td>
        </tr>
        
        <tr>
        	<td>Last Name *</td>
            <td><input type="text" value="<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','lastname',$this->session->userdata('member'),'uid'); echo $d['lastname']; ?>" name="lastname"></td>
        </tr>
        
        <tr>
        	<td>DOB *</td>
            <td><input type="text" value="<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','dob',$this->session->userdata('member'),'uid'); echo $d['dob']; ?>" name="dob" id="datepicker"></td>
        </tr>
        
        <tr>
        	<td>Email *</td>
            <td><input type="text" value="<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','email',$this->session->userdata('member'),'uid'); echo $d['email']; ?>" name="email"></td>
        </tr>
        
        <tr>
        	<td>Country *</td>
            <td>
            	<?php 
					$id = "id='country'";
					echo form_dropdown('country',$country,$member['country'],$id); 
				?>
            </td>
        </tr>
        
        <tr>
        	<td>Home/Office Phone *</td>
            <td>
            	<input type="text" class="countrycode" name="contrycode" value="<?php echo $code[$member['country']]; ?>" readonly="readonly" size="4" />
                <input type="text" value="<?php $string = trim($member['homephone'],$code[$member['country']]."-"); echo $string; ?>" id="homephone" name="homephone"></td>
        </tr>
        
        <tr>
        	<td>Mobile/Cellular Phone *</td>
            <td>
            	<input type="text" class="countrycode" name="contrycode" value="<?php echo $code[$member['country']]; ?>" readonly="readonly" size="4" />
            	<input type="text" value="<?php $string = trim($member['mobilephone'],$code[$member['country']]."-"); echo $string; ?>" name="mobilephone">
           	</td>
        </tr>
        
        <tr>
        	<td>State/Province*</td>
            <td id="block_province">
            	<?php 
					$id = "id='province' onchange='get_city();'";
					echo form_dropdown('province',$province,$member['province'],$id); 
				?>
            </td>
        </tr>
        
        <tr>
        	<td>City *</td>
            <td id="block_city">
				<?php 
					$id = "id='city'";
					echo form_dropdown('city',$city,$member['city'],$id); 
				?>
            </td>
        </tr>
        
        <tr>
        	<td>Street Address*</td>
            <td>
            	<textarea rows="5"><?php echo $member['address']; ?></textarea>
            </td>
        </tr>
        
        <tr>
        	<td>Regional *</td>
            <td>
				<?php 
					$ex = "disabled='1'";
					echo form_dropdown('regional',$city,$member['regional'],$ex); 
				?>
            </td>
        </tr>
        
        <tr>
        	<td>Bank Account Number *</td>
            <td><input type="text" value="<?php echo $member['bank_account_number']; ?>" name="bank_account_number" /></td>
        </tr>
        
        <tr>
        	<td>Bank Name *</td>
            <td>
           		<?php
					echo form_dropdown('bank_name',$bank,$member['bank_name']);
				?>
           	</td>
        </tr>
        
        <tr>
        	<td>Name On Bank Account *</td>
            <td><input type="text" value="<?php echo $member['name_on_bank_account']; ?>" name="name_on_bank_account" /></td>
        </tr>
        
        <tr>
        	<td valign="middle" align="center"><img src="<?php echo base_url(); ?>asset/theme/old-site/images/bank.png" /></td>
            <td>
            	<font color="#FF0000">
Payment of all E-Vouchers in Indonesian Rupiah.
<br />
Bank Transfer should be made to <b>PT. GOLDEN VICTORY INSANI PRATAMAYINTARA (GOLDEN VIP)</b>
<br />
Permata Bank, Jl. Prof. Dr. Soepomo No. 30 Jakarta 12810.
<br />
<b>Account No. (IDR) 070.137.5068</b>
				</font>
            </td>
        </tr>
        
    </tbody>
</table>
<input type="button" value="Update" /> <input type="button" onclick="history.go(-1)" value="Back" />
        <br />    <br />  
               <!-- barbar area -->
               	<?php 
			   		$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','usercategory',$this->session->userdata('member'),'uid'); 
					if($d['usercategory'] == 3)
					{ 
				?>
               <div style="border:1px solid #ccc; width:98%; padding: 10px;">
									<div style="margin-bottom: 5px;"><strong>Total E-Vouchers : <?php echo count($total_data); ?></strong><br /><strong>Available : <?php echo $data_unused['c_uid']; ?></strong><br /><strong>Used : <?php echo $data_used['c_uid']; ?></strong></div>

									<div align="center"><strong>
											<h1 class="judul">New List Of E-Vouchers</h1>
										</strong></div>
									<table id="myTable" class="tablesorter">
										<thead>
											<tr>
												<th>No</th>
												<th>Voucher Code</th>

												<th>Status</th>
												<th>Downlines</th>
												<th style="text-align: center;">Issued Date</th>
											</tr>
										</thead>
										<tbody>
                                        	<?php 
												$i = 1;
												foreach($total_data as $row)
												{
											?>
											<tr>
												<td width="30px" <?php if($row['status']=='1'){ echo "style='background-color: red;color: white;font-weight: bold;'";} ?>><?php echo $i; ?></td>
												<td <?php if($row['status']=='1'){ echo "style='background-color: red;color: white;font-weight: bold;'";} ?>><?php echo $row['voucher_code']; ?></td>
												<td <?php if($row['status']=='1'){ echo "style='background-color: red;color: white;font-weight: bold;'";} ?>><?php if($row['status']=='1'){echo "Used"; }else{ echo "Available";} ?></td>
												<td <?php if($row['status']=='1'){ echo "style='background-color: red;color: white;font-weight: bold;'";} ?>><strong><?php echo $row['firstname']." ".$row['lastname']; ?></strong></td>
												<td align="center" <?php if($row['status']=='1'){ echo "style='background-color: red;color: white;font-weight: bold;'";} ?>><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_vouchercode','crdate',$row['voucher_code'],'voucher_code'); echo date('Y-m-d H:i:s',$d['crdate']); ?></td>
											</tr>
											<?php $i ++;} ?>	
										</tbody>
									</table>
								</div>
               
               <!-- end of barbar area -->
               <?php } ?>
               
               
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
