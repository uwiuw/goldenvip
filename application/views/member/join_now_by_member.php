 <script type="text/javascript" src="<?php echo base_url(); ?>asset/theme/old-site/js/jquery-1.4.3.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/public.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>asset/theme/old-site/js/jquery.fesetup.member.js"></script>
 <script type="text/javascript">
	var site = "<?php echo site_url(); ?>";
	jQuery(function(){
		jQuery('#disp_regional').hide();
		jQuery('#disp_city').hide();
		jQuery('#disp_province').hide();
		jQuery('#display_dist').hide();
		jQuery('#display_sel_pck2').hide();
		jQuery('#display_sel_pck3').hide();
		jQuery('#country').change(function(){
			uid = jQuery(this).val();
			load_to_val('member/post_data/get_phone_code/'+uid,'.countrycode'); 
			load_no_image('member/post_data/get_province/'+uid,'#block_province'); 
			jQuery('#disp_province').fadeIn();
			load_no_image('member/post_data/get_regional/'+uid,'#block_regional');
			load_no_image('member/post_data/get_city/'+uid,'#block_city');
			load_no_image('member/post_data/get_distributor/'+uid,'#block_distributor');
		}); 
	});
	function get_city()
	{
		uid = jQuery('#province').val(); 
		load_no_image('member/post_data/get_city/'+uid,'#block_city');
		jQuery('#disp_city').fadeIn();
		jQuery('#disp_regional').fadeIn(); 
		load_no_image('member/post_data/get_regional/'+uid,'#block_regional');
		load_no_image('member/post_data/get_distributor/0','#block_distributor');
	}
	function regional_change()
	{
		uid = jQuery('#regional').val(); 
		jQuery('#display_dist').fadeIn(); 
		load_no_image('member/post_data/get_distributor/'+uid,'#block_distributor');
	}
	  
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/form.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/picture.css" type="text/css">  
<style>
	.dropdown{width:120px;}
</style>
<div class="container">
				<div class="frame-photo"><a id="c76"></a>

					<div class="csc-textpic csc-textpic-center csc-textpic-above">
						<div class="csc-textpic-imagewrap" style="width:651px;">
							<dl class="csc-textpic-image csc-textpic-lastcol" style="width:651px;">
								<dt><img src="<?php echo base_url(); ?>upload/join-now.jpg" width="651" height="262" border="0" alt="" /></dt>
							</dl>
						</div>
					</div>
					<div class="csc-textpic-clear"></div>
				</div>

				<div class="site-map">
					<div class="baseurl"><a href="http://mygoldenvip.com"><img src="<?php echo base_url(); ?>asset/theme/old-site/images/icon_home.png" alt="Icon Home" /></a></div>
					<div class="linkQ"><a href="http://mygoldenvip.com/member/" >Member</a><span>JOIN NOW</span></div>
				</div>
				<div class="clear"></div>
				<div class="main-content">
					<div class="kotak-content"><a id="c38"></a>
						<div class="tx-rwmembermlm-pi1">
								<?php if($this->session->flashdata('info')){ ?>
                                        <div><label class="errdisp" style="color:#F00; font-size:14px; width:100%; text-align:center;"><?php echo $this->session->flashdata('info'); ?></label><div class="clr"></div></div>
                                <?php } ?>
						 
								<form class="et-form"  method="post" id="form-photo" name="form-photo" autocomplete="off" action="<?php echo site_url('member/join-now-by-member');?>"><input type="hidden" name="usercategory" id="usercategory" value="4" />
									<div>
                                    	<label class="desc">First Name * : </label><input class="text" value="" type="text" name="firstname" id="firstname" size="50" maxlength="100"/><label id="error_firstname" class="errdisp"></label>
										<div class="clr"></div>

									</div>
									
                                    <div>
                                    	<label class="desc">Last Name * : </label><input class="text" value="" type="text" name="lastname" id="lastname" size="50" maxlength="100"/><label id="error_lastname" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
									<div>
                                    	<label class="desc">Date Of Birth * : </label> 
                                        <select id="d" name="d" class="dropdown">
                                            <option value="" selected="selected">Date &nbsp; &nbsp;</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                        <select id="m" name="m" class="dropdown">
                                        	<option value="" selected="selected">Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">may</option>
                                            <option value="06">June</option>
                                            <option value="07">july</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                       </select>
                                        <?php 
											$y[]='Year &nbsp; &nbsp;';
											 
											for($i=2010;$i>=1945;$i--)
											{
												$y[$i]=$i;
											}
											echo form_dropdown('y',$y,'1970',"id='y' class='dropdown'");
										?>  
                                        <label id="error_dob" class="errdisp"></label>

										<div class="clr"></div>
                                        
									</div>
                                    
									<div>
                                    	<label class="desc">Email * : </label><input class="text" value="" type="text" name="email" id="email" size="50" maxlength="100"/><label id="error_email" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
									<div>
                                    	<label class="desc">Username (max 12 chars, no space) * : </label><input class="text" value="" type="text" name="username" id="username" size="20" maxlength="12"/><label id="error_username" class="errdisp"></label>
										<div class="clr"></div>

									</div>
                                    
									<div>
                                    	<label class="desc">Password * : </label><input class="text" value="" type="password" name="password1" id="password1" size="50" maxlength="100" /><label id="error_password1" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
									<div><label class="desc">Re-type Password * : </label><input class="text" value="" type="password" name="password2" id="password2" size="50" maxlength="100"/><label id="error_password2" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
									<div>
                                    	<label class="desc">Country * : </label>
                                        <?php 
											$id = "id='country' class='dropdown'";
											echo form_dropdown('country',$country,$page['country'],$id); 
										?>
                                        <label id="error_country" class="errdisp"></label>

										<div class="clr"></div>
									</div>
                                    
									<div>
                                    	<label class="desc">Home/Office Phone : </label>
                                        <input class="text countrycode" readonly="1" value="" type="text" name="countrycode1" id="countrycode1" size="5" maxlength="10"/>
                                        <input class="text" value="" type="text" name="homephone" id="homephone" size="20" maxlength="20"/>
                                        <label id="error_homephone" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
									<div>
                                    	<label class="desc">Mobile/Cellular Phone * : </label>
                                        <input class="text countrycode"  readonly="1" value="" type="text" name="countrycode2" id="countrycode2" size="5" maxlength="10"/>
                                        <input class="text" value="" type="text" name="mobilephone" id="mobilephone" size="20" maxlength="20"/>
                                        <label id="error_mobilephone" class="errdisp"></label>
										<div class="clr"></div>
									</div>

									<div id="disp_province">
                                    	<label class="desc">State/Province * : </label>
                                        <label id="block_province"></label>
                                        <label id="error_province" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
									<div id="disp_city">
                                    	<label class="desc">City * : </label>
                                        <label id="block_city"></label>
                                        <label id="error_city" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
									<div id="disp_address">
                                    <label class="desc">Address * : </label>

										<textarea class="area" name="address" id="address" cols="36" rows="4" >Completely your address</textarea>
										<label id="error_address" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
                                    
                                    
                                    <div id="disp_regional">
                                    	<label class="desc">Regional * : </label>
                                        <label id="block_regional"></label>
                                        <label id="error_regional" class="errdisp"></label>
										<div class="clr"></div>
										<label class="desc">&nbsp;</label> Choose the city based on your nearest residence area 
										<div class="clr"></div>
									</div> 
                                    
									 
                                    	<input type="hidden" name="distributor" value="<?php echo $this->session->userdata('member'); ?>">
                                     
                                    
                                    <div id="display_vc">
                                    	<label class="desc">Voucher Code * : </label>
                                        <label id="block_vc">
                                        	<input type="text" name="vc" id="voucher">
                                        </label>
                                        <label id="error_voucher" class="errdisp"></label>
                                        <div class="clr"></div>
                                    </div>
                                    	
									<div>
                                    	<label class="desc">Package * : </label>
                                        <?php 
											$id = "id='package' class='dropdown' ";
											echo form_dropdown('package',$package,$page['package'],$id); 
										?>
                                        <label id="error_pack" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                     
                                    <div id="display_sel_pck">
                                    	<label class="desc">Placement * : </label>
                                        <select name="placement" id="placement">
                                        	<option value="">-- selected --</option>
                                        	<option value="1">Left</option>
                                            <option value="2">Right</option>
                                        </select>
                                        <label id="error_placement" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                     
									<div>
                                    	<label class="desc">Bank Name * : </label>
                                        <?php 
											$id = "id='bank_name' class='dropdown'";
											echo form_dropdown('bank_name',$bank,$page['bank'],$id); 
										?>
                                        <label id="error_bank_name" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                   
									<div>
                                    	<label class="desc">Bank Account Number * : </label>
                                        <input class="text" value="" type="text" name="bank_account_number" id="bank_account_number" size="50" maxlength="100"/><label id="error_bank_account_number" class="errdisp"></label>

										<div class="clr"></div>
									</div>
                                    
									<div>
                                    	<label class="desc">Name On Bank Account * : </label>
                                        <input class="text" value="" type="text" name="name_on_bank_account" id="name_on_bank_account" size="50" maxlength="100"/>
                                        <label id="error_name_on_bank_account" class="errdisp"></label>
										<div class="clr"></div>
									</div>
                                    
									<div>
                                    	<label class="desc"></label>
                                        <input type="checkbox" name="agree" id="agree" /> &nbsp;&nbsp;<b>By submitting my completely profile, I do agree with the GVIP's <a href="terms-conditions/" >Terms & Conditions</a></b>
                                        <label id="error_agree" class="errdisp"></label>

										<div class="clr"></div>
									</div>
									<div><input class="et-form-btn" name="submitreg1" id="submitreg1" type="submit" value=" Submit " /></div>
								</form>
								<p align="right"><strong>* ) Field should be completed and not empty</strong></p>
							</div>
							<div id="dialog" title="Confirmation Regional Distributor" style="display: none;"></div>
						</div>

					</div>
				</div>
			</div>