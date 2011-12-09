<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
	jQuery(function(){
		jQuery("#myTable").tablesorter();
		jQuery('#myTable tbody tr:odd').addClass('odd');
		});
</script>
<div class="container">
				<div id="show-ctn-member">
					<div class="tx-rwmembermlm-pi1">
						<div id="home-office" class="sponsor">
							<div id="home-top">
								<h2>Direct Sponsored</h2>
							</div>
							<div id="home-bottom">
								<div class="csc-textpic-text">
                                <?php
										$sql = "select uid, pid, firstname, lastname, email, mobilephone, city, sponsor 
												from tx_rwmembermlm_member
												where sponsor = '".$this->session->userdata('member')."' order by uid                   
												";
										$direct_sponsor = $this->Mix->read_more_rows_by_sql($sql);
										if(!empty($direct_sponsor))
										{ 
									?>
									<table id="myTable" class="tablesorter">
										<thead>
											<tr>
												<th class="header">No</th>
												<th class="header">Name</th>
												<th class="header">Email</th>
												<th class="header">Mobile Phone</th>
												<th class="header">City</th>
												<th class="header">Sponsors</th>
												<th class="header">Action</th>
											</tr>
										</thead>
										<tbody>
                                        	<?php $i=1; foreach($direct_sponsor as $row) { ?>
											<tr class="even">
												<td align="center" width="30px"><?php echo $i; ?></td>
												<td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
												<td><?php echo $row['email']; ?></td>
												<td><?php echo $row['mobilephone']; ?></td>
												<td><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_city','city',$row['city'],'uid'); echo $d['city']; ?></td>
												<td>
												<?php 
													$dsp = getDirectSponsored($row['uid'],'67'); 
													if(!empty($dsp))
													{
														$sum = 0;
														if(isset($dsp['kiri']))
														{  
															$sum = count($dsp['kiri']) + $sum;
														}
														
														if(isset($dsp['kanan']))
														{
															$sum = count($dsp['kanan']) + $sum;
														}
														echo $sum;
													}
													else
													{
														echo "0";
													}
												?>
                                                </td>
												<td align="center"><a title="Browse data" class="browse-data" href="<?php echo site_url('member/post_data/get_detail_member/'.$row['uid'].'/'.$row['pid']);?>"></a></td>
											</tr>
                                            <?php $i++; } ?>
										</tbody>
									</table>
                                    <?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>