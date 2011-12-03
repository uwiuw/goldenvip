<div class="container">
			<div id="page-backoffice">             
				<div id="home-office">
					<div id="home-top">
						<h2>Home Office</h2>
                        <div id="show-message">
                        </div>						
					</div>
					<div id="home-bottom">
						<p>
                        	<b>Welcome <?php echo $this->session->userdata('name'); ?> Our Main Regional Distributor of <?php echo $this->session->userdata('regional'); ?> By clicking HERE You can register and fill in your new member's profile completely 
                            </b>
                        </p>
                        <p>
                        	This page facilitates you to edit your existing profile, updating your genealogy, confirming your simply reservations, mastering your compensation plans and updating your direct members and Cycle Bonuses achievements. Kindly remind to LOGOUT  when it's done.
                            <pre style="display:none;">
                        	  Conratulation on achieving your 6000 poin point rewards, you've entitle to have your 1 (one) complimentary of VIP Package.
                            </pre>
                        </p>
					</div>
				</div> 
                <div class="garis-homeoffice"></div>
                <div class="left-backoffice">
                    <div class="box-home-office geneology">
                        <div class="heading">
                            <h2>Geneology Information</h2>
                        </div>
                        <div class="section-cont" id="genelogy-cepat">
                        <!-- geneology view -->
                            <div class="tx-rwmembermlm-pi1">
                                
                                <div style='width:100%;text-align:center;float:left;'>
                                    <!-- root -->
                                    <p class='gen'>
										<?php 
											$id  = $this->session->userdata('member');
											get_tips_info($id);
											$child_left = get_downline($id,'1'); # placement 1 kiri, 2 kanan 
											$child_right = get_downline($id,'2');
											
										?>
                                    </p>
                                    
                                    <!-- kaki sebelah kiri -->
                                    <div style='width:50%;text-align:center;float:left;'>
                                        	<p class='gen'>
												<?php
													$id  = $child_left;
													get_tips_info($id);
													$child_1 = get_downline($id,'1'); # placement 1 kiri, 2 kanan 
													$child_2 = get_downline($id,'2');
												?>
                                             </p> 
                                        	 
                                             <!-- kiri -->
                                      <div style='width:50%;text-align:center;float:left;'>
                                       	<p class='gen'>
                                                	<?php
														$id = $child_1;
														get_tips_info($id);
														$child_11 = get_downline($id,'1'); 
														$child_12 = get_downline($id,'2'); 
													?>
                                        </p>
                                              </div> 
                                              
                                              <!-- kanan -->
                                      <div style='width:50%;text-align:center;float:right;'>
                                       	<p class='gen'>
                                                	<?php 
														$id = $child_2;
														get_tips_info($id);
														$child_21 = get_downline($id,'1'); 
														$child_22 = get_downline($id,'2'); 
													?>
                                        </p>
                                              </div> 
                                        </div>
                                        
                                        <!-- kaki sebelah kanan -->
                                    	<div style='width:50%;text-align:center;float:right;'>
                                        	<p class='gen'>
													<?php   
														$id = $child_right;
														get_tips_info($id);
														$child_1 = get_downline($id,'1'); 
														$child_2 = get_downline($id,'2'); 
													?>
                                            </p> 
                                            
                                            <!-- kiri -->
                                          <div style='width:50%;text-align:center;float:left;'>
                                       	    <p class='gen'>
                                                	<?php 
														$id = $child_1;
														get_tips_info($id);
														$child_11 = get_downline($id,'1'); 
														$child_12 = get_downline($id,'2'); 
													?>
                                              </p>
                                          </div> 
                                              
                                              <!-- kanan -->
                                       	  <div style='width:50%;text-align:center;float:right;'>
                                       	    <p class='gen'>
                                                	<?php
														$id = $child_2;
														get_tips_info($id);
														$child_21 = get_downline($id,'1'); 
														$child_22 = get_downline($id,'2'); 
													?>
                                           	 </p>
                                       	  </div> 
                                              
                                        </div> 			 
                                </div>
                                
                            </div>
                        <!-- stop of geneology view -->     
                        </div>
                    </div>
                    <div class="box-home-office cycle">
                        <div class="heading">
                            <h2>10 Latest Cycle</h2>
                        </div>
                        <div class="section-cont" id="genelogy-cepat"> 
                        	<?php 
								$sql = "select crdate, bonus from tx_rwmembermlm_historycycle where uid_member = '".$this->session->userdata('member')."' order by uid limit 0,10";
								$cycle = $this->Mix->read_more_rows_by_sql($sql);
								
							?>  
                        	   <table id="myTable2" class="tablesorter">
                                    <thead>
                                        <tr>

                                            <th>Date Time</th>
                                            <th>Bonus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php foreach ($cycle as $row) { ?>
                                        <tr>
                                            <td><strong><?php echo date('Y-m-d H:i:s',$row['crdate']); ?></strong></td>

                                            <td><strong>$<?php echo $row['bonus']; ?></strong></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>              
                        </div>
                    </div>
                </div>
                <div class="right-backoffice">
                    <div class="box-home-office binary">
                        <div class="heading">
                            <h2>Binary Information </h2>
                        </div>
                        <div class="section-cont" id="info-binary">
                        		
                                <p>
                                	Current Level
                                </p>
                          		<p>
                                	<table width="100%" border="0">
                                    	<tr valign="middle" align="right">
                                        	<td colspan="2" height="30px"></td>
                                          	<td rowspan="4">
                                            	<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','grade',$this->session->userdata('member'),'uid'); ?>
                                                <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_grade','simbol',$d['grade'],'uid'); ?>
                                            	<img src="<?php echo base_url(); ?>/asset/theme/old-site/images/icon/<?php echo $d['simbol'] ?>" />
                                             </td>
                                        </tr>
                                    	<tr>
                                    	  <td>Left Poin : <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','point_left',$this->session->userdata('member'),'uid'); echo "<b>".$d['point_left']."</b>"; ?></td>
                                    	  <td>Right Point: <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','point_right',$this->session->userdata('member'),'uid'); echo "<b>".$d['point_right']."</b>"; ?></td>
                                   	  </tr>
                                    	<tr>
                                          <?php $d = getDirectSponsored($this->session->userdata('member'),'67'); ?>
                                    	  <td>Direct Sponsored - Left : <b><?php if(isset($d['kiri'])) {echo count($d['kiri']);} ?></b></td>
                                    	  <td>Direct Sponsored - Right : <b><?php if(isset($d['kanan'])){echo count($d['kanan']); } ?></b></td>
                                   	  </tr>
                                    	<tr>
                                    	  <td>Commision: <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$this->session->userdata('member'),'uid'); echo "<b>$".$d['commission']."</b>"; ?></td>
                                    	  <td>CV Point: <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','cv',$this->session->userdata('member'),'uid'); echo "<b>".$d['cv']."</b>"; ?></td>
                                   	  </tr>
                                    </table>
                                </p>
                      	</div>
                    </div>
                    
                    <div class="box-home-office sponsor">
                        <div class="heading">
                            <h2>Direct Sponsors (10 Latest)</h2>
                        </div>
                        <div class="section-cont" id="direct-sponsored">  
                        	<?php 
								$sql = "select uid from tx_rwmembermlm_member where sponsor = '".$this->session->userdata('member')."' order by uid limit 0,10";
								$direct_sponsor = $this->Mix->read_more_rows_by_sql($sql);
							?>
                        	       <table id="myTable2" class="tablesorter">
											<thead>
												<tr>
													<th>Username</th>

													<th>Full Name</th>
													<th>Sponsors</th>
												</tr>
											</thead>
											<tbody>
                                            	<?php foreach($direct_sponsor as $row) { ?>
												<tr>
													<td width="30%">
														<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$row['uid'],'uid'); echo $d['username']; ?>
                                                    </td>
                                                    <td>
                                                    	<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','firstname',$row['uid'],'uid'); echo $d['firstname']; ?>
                                                        <?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','lastname',$row['uid'],'uid'); echo $d['lastname']; ?>
                                                    </td>
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
												</tr>
                                               	<?php } ?>
											</tbody>
										</table>          
                        </div>
                    </div>
                </div>
                               
            </div>
            <div class="clear"></div>
		</div>