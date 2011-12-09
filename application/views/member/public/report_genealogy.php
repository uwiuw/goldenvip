<div class="container">
	<div id="show-ctn-member">
    	<div class="tx-rwmembermlm-pi1">
      		<div id="home-office" class="sponsor">
            	<div id="home-top">
                	<h2>Report &raquo; Genealogy</h2>
            	</div>
            	<div id="home-bottom">
                	<div class="csc-textpic-text">
                        <p style="margin-bottom: 25px;"><strong>click the username in order to see the next existing downlines registered.</strong></p>
                        <!-- genealogy -->
                        	<div class="tx-rwmembermlm-pi1">
                                
                                <div style='width:100%;text-align:center;float:left;'>
                                    <!-- root -->
                                    <p class='gen'>
										<?php 
											$url = $this->uri->segment('4');
											if($url == '')
											{
												$idf  = $this->session->userdata('member');
											}
											else
											{
												$idf = $url;
											}
											
											get_tips_info($idf);
											$child_left = get_downline($idf,'1'); # placement 1 kiri, 2 kanan 
											$child_right = get_downline($idf,'2');
											
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
                        <!-- end of genealogy -->
                        <div class="clear"></div>
                        <!-- btn top level -->
                        <p style="margin-top: 25px;">
                        	<?php $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','upline',$idf,'uid'); if($idf == $this->session->userdata('member')){ }else {?>
                        	<input type="button" name="back" value="Back To Top Level" onclick="location.href='<?php echo site_url('member/post_data/get_genealogy/'.$d['upline']);?>'" /> <?php } ?>
                        </p>
                        <!-- top level -->
                    </div>
                </div>
          </div>
        </div>
	</div>
	<div class="clear"></div>
</div>