<div class="container">
				<div id="show-ctn-member"><a id="c118"></a>
					<div class="tx-rwmembermlm-pi1">
						<div class="sponsor" id="home-office">
							<div id="home-top">
								<h2>Members Request</h2>
							</div>
							<div id="home-bottom">
								<div class="csc-textpic-text">
									<p><strong>This page will display the profile details of the member candidate. If the member is valid you only need to set the <span style="color: red;">Voucher Code (Optional)</span>, <span style="color: red;">Verification</span> and <span style="color: red;">Lock Placement (default value is left)</span> for this member.</strong></p>
                                    
                                    <?php if($this->session->flashdata('error')) { ?>
									<div class="error">Please update your status member (Valid / Not Valid) soon</div>
                                    <?php } ?>
									<form action="<?php echo site_url('member/join-now/set-active-member'); ?>" method="post" name="frmplacement" id="frmplacement">
                                    <input type="hidden" value="<?php echo $mreq['uid']; ?>" id="uid" name="uid">
										<table cellspacing="1" cellpadding="0" border="0" id="tablesorter" class="tablesorter">
											<tbody>
												<tr class="odd">
													<td width="200px"><strong>Create Date</strong></td>
													<td><strong><?php echo date('Y-m-d H:i:s',$mreq['crdate']); ?></strong></td>
												</tr>
												<tr class="odd">
													<td width="200px"><strong>Package</strong></td>
													<td><strong><?php $p = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','package',$mreq['package'],'uid'); echo $p['package'] ; ?></strong>
                                                    <input type="hidden" name="package" value="<?php echo $mreq['package']; ?>">
                                                    </td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>First Name</strong></td>
													<td><strong><?php echo $mreq['firstname']; ?></strong></td>
												</tr>
												<tr class="odd">
													<td width="200px"><strong>Last Name</strong></td>
													<td><strong><?php echo $mreq['lastname']; ?></strong></td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>DOB</strong></td>
													<td><strong><?php echo $mreq['dob']; ?></strong></td>
												</tr>
												<tr class="odd">
													<td width="200px"><strong>Email</strong></td>
													<td><strong><?php echo $mreq['email']; ?></strong></td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>Username</strong></td>
													<td><strong><?php echo $mreq['username']; ?></strong></td>
												</tr>
												<tr class="odd">
													<td width="200px"><strong>Country</strong></td>
													<td><strong><?php $c = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_phonecountrycode','country',$mreq['country'],'uid'); echo $c['country']; ?></strong></td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>Home/Office Phone</strong></td>
													<td><strong><?php echo $mreq['homephone']; ?></strong></td>
												</tr>
												<tr class="odd">
													<td width="200px"><strong>Mobile/Cellular Phone</strong></td>
													<td><strong><?php echo $mreq['mobilephone']; ?></strong></td>
												</tr>
												<tr class="even" id="disp_province">
													<td width="200px"><strong>State/Province</strong></td>
													<td id="disp_option1"><strong><?php $pr = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_province','province',$mreq['province'],'uid'); echo $pr['province']; ?></strong></td>
												</tr>
												<tr class="odd" id="disp_city">
													<td width="200px"><strong>City</strong></td>
													<td><strong><?php $ct = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_city','city',$mreq['city'],'uid'); echo $ct['city']; ?></strong></td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>Street Address</strong></td>
													<td><strong><?php echo $mreq['address']; ?></strong></td>
												</tr>
												<tr class="odd">
													<td width="200px"><strong>Regional</strong></td>
													<td><strong><?php $rg = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_city','city',$mreq['regional'],'uid'); echo $rg['city']; ?></strong></td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>Bank Account Number</strong></td>
													<td><strong><?php echo $mreq['bank_account_number']; ?></strong></td>
												</tr>
												<tr class="odd">
													<td width="200px"><strong>Bank Name</strong></td>
													<td><strong><?php echo $mreq['bank_name']; ?></strong></td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>Name On Bank Account</strong></td>
													<td><strong><?php echo $mreq['name_on_bank_account']; ?></strong></td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>Voucher Code</strong></td>
													<td><input type="text" id="voucher_code" name="voucher_code" size="50" maxlength="100" value=""></td>
												</tr>
												<tr class="odd">
													<td width="200px"><strong>Verification *</strong></td>
													<td><select class="dropdown" name="valid" id="valid"><option selected="1" value="0">NOT VALID</option><option value="1">VALID</option></select></td>
												</tr>
												<tr class="even">
													<td width="200px"><strong>Lock Placement *</strong></td>
													<td><select class="dropdown" name="placement" id="placement"><option selected="1" value="1">LEFT</option><option value="2">RIGHT</option></select></td>
												</tr>
											</tbody>
										</table>
										<input type="submit" id="update" name="update" value="Update"><input type="button" value="Back to List Member" onclick="document.location.href='<?php echo site_url('member/list-member-request');?>'"></form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>