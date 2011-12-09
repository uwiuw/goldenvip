<div class="container">
				<div id="show-ctn-member"><a id="c117"></a>
					<div class="tx-rwmembermlm-pi1">
						<div class="sponsor" id="home-office">
							<div id="home-top">
								<h2>Members Request</h2>
							</div>
							<div id="home-bottom">
								<div class="csc-textpic-text">
									<p><strong>The table below is a list of members candidate who registering directly or registering through to your sub domain. Click the browse button to view the complete profile, verification and approving. </strong></p>
                                   <?php if($this->session->flashdata('info')) { ?>
                                   <div class="error">Selected member request has been delete.</div>
                                   <?php }?>
									<table class="tablesorter" id="myTable">
										<thead>
											<tr>
												<th class="header">No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												<th class="header">Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												<th class="header">Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												<th class="header">Mobile Phone&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												<th class="header">City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												<th class="header">Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
											</tr>
										</thead>
										<tbody>
                                        	<?php $i = 1; foreach($list_member as $row) { ?>
											<tr class="even">
												<td width="30px" align="center"><?php echo $i; ?>.</td>
												<td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
												<td><?php echo $row['email']; ?></td>
												<td><?php echo $row['mobilephone']; ?></td>
												<td><?php $c = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_city','city',$row['city'],'uid'); echo $c['city']; ?></td>
												<td align="center">
                                                <a href="javascript:void(0)" onclick="location.href='<?php echo site_url('member/post_data/browse-member-request/'.$row['uid']);?>'" title="Browse data" class="browse-data"></a> 
                                                &nbsp; 
                                                <a href="javascript:void(0)" onclick="if(confirm('Are you sure want to delete this record ? \n Name : <?php echo $row['firstname']." ".$row['lastname']; ?>')) location.href='<?php echo site_url('member/post_data/del-member-request/'.$row['uid']);?>'" title="Delete Data" class="delete-data"></a>
                                                </td>
											</tr>
                                            <?php $i++;} ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>