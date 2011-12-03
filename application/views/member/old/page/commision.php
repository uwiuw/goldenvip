<div class="container">
				<div id="show-ctn-member">
					<div class="tx-rwmembermlm-pi1">
						<div id="home-office" class="sponsor">
							<div id="home-top">
								<h2>Report Commision</h2>
						  </div>
							<div id="home-bottom">
								<div class="csc-textpic-text">
									<p style="margin-bottom: 10px;margin-top: 10px;"><strong>Fast Bonus</strong></p>
                                    <?php 
										# awal dari fast bonus
										$sql = "SELECT a.*, b.username as downline_name 
                    							FROM tx_rwmembermlm_historyfastbonus a, tx_rwmembermlm_member b
                   								WHERE a.deleted = 0 and a.hidden = 0 and 
                          						a.uid_member='".$this->session->userdata('member')."' and a.pid='67' and a.uid_downline=b.uid
                    							ORDER BY a.uid DESC";
										$fast_bonus = $this->Mix->read_more_rows_by_sql($sql);
										if(!empty($fast_bonus))
										{
									?>
									<div style="border:1px solid #ccc; width:98%; padding: 10px;">
										<table id="myTable2" class="tablesorter">
											<thead>
												<tr>
													<th>No</th>
													<th>Date Time</th>
													<th>Username</th>
													<th>Bonus</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												
                                                <?php
                                                	$i = 1;
													foreach($fast_bonus as $row)
													{
												?>
												<tr>
													<td width="30px"><?php echo $i; ?>.</td>
													<td><?php echo date('Y-m-d H:i:s',$row['crdate']); ?></td>
													<td><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$row['uid_downline'],'uid'); echo $d['username']; ?></td>
													<td>$ <?php echo $row['bonus']; ?></td>
													<td><strong><?php if($row['paid'] =='1'){echo "paid"; }else{ echo "unpaid"; }; ?></strong></td>
												</tr>
												<?php $i++;}?>
											</tbody>
										</table>
									</div>
                                    <?php 
										}
										else
										{
											echo "<div class=\"error\">Data Not Found</div>";
										}
										# akhir dari fast bonus
									?>
                                    
									<p style="margin-bottom: 10px;margin-top: 10px;"><strong>Cycle Bonus</strong></p>
                                    <?php
										# awal dari cycle bonus
										$sql = "SELECT *  
												FROM tx_rwmembermlm_historycycle
												WHERE deleted = 0 and hidden = 0 and 
													  uid_member='".$this->session->userdata('member')."' and pid='67' 
												ORDER BY uid DESC                    
												";
										#$sql = "select * from tx_rwmembermlm_historycycle where uid_member = '".$this->session->userdata('member')."'";
										$cycle_bonus = $this->Mix->read_more_rows_by_sql($sql);
										if(!empty($cycle_bonus))
										{ 
									?>
									<div style="border:1px solid #ccc; width:98%; padding: 10px;">
										<table id="myTable1" class="tablesorter">
											<thead>
												<tr>
													<th>No</th>
													<th>Date Time</th>
													<th>Bonus</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
                                            	<?php
                                                	$i = 1;
													foreach($cycle_bonus as $row)
													{
												?>
												<tr>
													<td width="30px"><?php echo $i; ?>.</td>
													<td><?php echo date('Y-m-d H:i:s',$row['crdate']); ?></td>
													<td>$ <?php echo $row['bonus']; ?></td>
													<td><strong><?php if($row['paid'] =='1'){echo "paid"; }else{ echo "unpaid"; }; ?></strong></td>
												</tr>
                                                <?php $i++; } ?>
											</tbody>
										</table>
									</div>
                                   	<?php 
										}
										else
										{
											echo "<div class=\"error\">Data Not Found</div>";
										}
										# akhir dari cycle bonus
									?>
                                    
									<p style="margin-bottom: 10px;margin-top: 10px;"><strong>Matching Bonus</strong></p>
                                    <?php
										# awal dari matching bonus
										$sql = "SELECT *  
												FROM tx_rwmembermlm_historymatchingbonus
												WHERE deleted = 0 and hidden = 0 and 
													  uid_member='".$this->session->userdata('member')."' and pid='67'
												ORDER BY uid DESC                    
												";
										$matching_bonus = $this->Mix->read_more_rows_by_sql($sql);
										if(!empty($matching_bonus))
										{ 
									?>
                                    <div style="border:1px solid #ccc; width:98%; padding: 10px;">
										<table id="myTable1" class="tablesorter">
											<thead>
												<tr>
													<th>No</th>
													<th>Date Time</th>
													<th>Bonus</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
                                            	<?php
                                                	$i = 1;
													foreach($matching_bonus as $row)
													{
												?>
												<tr>
													<td width="30px"><?php echo $i; ?>.</td>
													<td><?php echo date('Y-m-d H:i:s',$row['crdate']); ?></td>
													<td>$ <?php echo $row['bonus']; ?></td>
													<td><strong><?php if($row['paid'] =='1'){echo "paid"; }else{ echo "unpaid"; }; ?></strong></td>
												</tr>
                                                <?php $i++; } ?>
											</tbody>
										</table>
									</div>
                                    <?php 
										}
										else
										{
											echo "<div class=\"error\">Data Not Found</div>";
										}
										# akhir dari matching bonus
									?>
									<p style="margin-bottom: 10px;margin-top: 10px;"><strong>Mentor Bonus</strong></p>
									<?php
										# awal dari mentor bonus
										
										$sql = "SELECT a.*, b.username as downline_name 
												FROM tx_rwmembermlm_historymentorbonus a, tx_rwmembermlm_member b
												WHERE a.deleted = 0 and a.hidden = 0 and 
													  a.uid_member='".$this->session->userdata('member')."' and a.pid='67' and a.uid_downline=b.uid
												ORDER BY a.uid DESC                    
												";
										#$sql = "select * from tx_rwmembermlm_historymentorbonus where uid_member = ";
										$mentor_bonus = $this->Mix->read_more_rows_by_sql($sql);
										if(!empty($mentor_bonus))
										{ 
									?>
                                    <div style="border:1px solid #ccc; width:98%; padding: 10px;">
										<table id="myTable2" class="tablesorter">
											<thead>
												<tr>
													<th>No</th>
													<th>Date Time</th>
													<th>Downline</th>
													<th>Bonus</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
                                                	$i = 1;
													foreach($mentor_bonus as $row)
													{
												?>
												<tr>
													<td width="30px"><?php echo $i; ?>.</td>
													<td><?php echo date('Y-m-d H:i:s',$row['crdate']); ?></td>
													<td><?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$row['uid_downline'],'uid'); echo $d['username']; ?></td>
													<td>$ <?php echo $row['bonus']; ?></td>
													<td><strong><?php if($row['paid'] =='1'){echo "paid"; }else{ echo "unpaid"; }; ?></strong></td>
												</tr>
												<?php $i++;}?>
											</tbody>
										</table>
									</div>
                                    <?php 
										}
										else
										{
											echo "<div class=\"error\">Data Not Found</div>";
										}
										# akhir dari matching bonus
									?>
									<p style="margin-bottom: 10px;margin-top: 10px;"><strong>Retail Rates Bonus</strong></p>
                                    <?php
										# awal dari retail rates bonus
										$u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$this->session->userdata('member'),'uid');
										$d = $this->Mix->read_row_ret_field_by_value('fe_users','uid',$u['username'],'username');
										if(isset($d['uid']))
										{
										$sql = "select a.*,b.category_name,b.retail_rate,b.rate as golden_rate,c.hotel_name from tx_rwadminhotel_booking a INNER JOIN tx_rwadminhotel_cat_room b ON a.uid_room=b.uid INNER JOIN tx_rwadminhotel_hotel c ON b.uid_hotel=c.uid where a.deleted=0 and a.PA=1 and a.uid_member='".$d['uid']."' order by a.uid desc";
										}
										else
										{
											$sql = "select uid from fe_users where username = '".$u['username']."'";
										}
										$retail_bonus = $this->Mix->read_more_rows_by_sql($sql);
										if(!empty($retail_bonus))
										{ 
									?>
									<div style="border:1px solid #ccc; width:98%; padding: 10px;">
										<table id="myTable4" class="tablesorter">
											<thead>
												<tr>
													<th>No</th>
													<th>Date Booking</th>
													<th>Name</th>
													<th>Hotel</th>
													<th>Room Type</th>
													<th>Qty</th>
													<th>Nights</th>
													<th>Profit</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$i = 1;
													foreach($retail_bonus as $row)
													{
												?>
												<tr>
													<td width="30px"><?php echo $i; ?>.</td>
													<td><?php echo $row['date_booking']; ?></td>
													<td><?php echo $row['name_reservation']; ?></td>
													<td><?php echo $row['hotel_name']; ?></td>
													<td><?php echo $row['category_name']; ?></td>
													<td><?php echo $row['qty']; ?></td>
													<td><?php $night = diffDay($row['check_in'],$row['check_out']); echo $night; ?></td>
													<td><?php $profit = $night * $row['rate']; echo "IDR ".number_format($profit); ?></td>
													<td><strong><?php if($row['payed']=='1'){echo "paid";}else{echo "unpaid";} ?></strong></td>
												</tr> 
                                                <?php $i++;}?>
											</tbody>
										</table>
									</div>
                                    <?php 
										}
										else
										{
											echo "<div class=\"error\">Data Not Found</div>";
										}
										# akhir dari retail bonus
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>