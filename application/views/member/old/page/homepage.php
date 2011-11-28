<div class="container">
			<div id="page-backoffice">             
				<div id="home-office">
					<div id="home-top">
						<h2>Home Office</h2>
                        <div id="show-message">
                        </div>						
					</div>
					<div id="home-bottom">
						<p><b>Welcome <?php echo $this->session->userdata('name'); ?> Our Main Regional Distributor of <?php $this->session->userdata('regional'); ?>
By clicking HERE You can register and fill in your new member's profile completely</b></p>
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
                                    <p class='gen'>Successfully</p>
                                    
                                    <!-- geneology left  
                                    <div style='width:50%;text-align:center;float:right;'>
                                        <p class='gen'>jenti</p>
                                        
                                        <div style='width:50%;text-align:center;float:right;'>
                                            <p class='gen'>travelshop</p>		 
                                        </div>
                                        
                                    </div>
                                    
                                      geneology right  
                                    <div style='width:50%;text-align:center;float:left;'>
                                        <p class='gen'>mydestiny</p>
                                        <div style='width:50%;text-align:center;float:left;'>
                                            <p class='gen'>vadierika</p>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <?php
										# conventional algorithm
										# check left from root
										# id <= root
										 
										# 	if get_downline_left(id) <> null then
										# 		write <div style='width:50%;text-align:center;float:right;'>
										#		write <p class='gen'>member name child 1</p> 
										
										#		id <= child
										#		if get_downline_left(id) <> null then
										# 			write <div style='width:50%;text-align:center;float:right;'>
										#			write <p class='gen'>member name child 1</p>
										#			write </div> 
										#		end if
										
										#		if get_downline_right(id) <> null then
										# 			write <div style='width:50%;text-align:center;float:right;'>
										#			write <p class='gen'>member name child 1</p>
										#			write </div> 
										#		end if
										
										#		write </div>
										#	end if
									?>
                                    	<div style='width:50%;text-align:center;float:right;'>
                                        	<p class='gen'>child 1</p> 
                                        	 <div style='width:50%;text-align:center;float:right;'>
                                             	<p class='gen'>child 1</p>
                                                	<div style='width:50%;text-align:center;float:right;'>
                                                    	<p class='gen'>child 1</p>
                                                    </div>
                                                    <div style='width:50%;text-align:center;float:left;'>
                                                    	<p class='gen'>child 1</p>
                                                    </div>
                                              </div> 
                                              <div style='width:50%;text-align:center;float:left;'>
                                              	<p class='gen'>child 1</p>
                                                	<div style='width:50%;text-align:center;float:right;'>
                                                    	<p class='gen'>child 1</p>
                                                    </div>
                                                    <div style='width:50%;text-align:center;float:left;'>
                                                    	<p class='gen'>child 1</p>
                                                    </div>
                                              </div> 
                                        </div>
                                        
                                        <div style='width:50%;text-align:center;float:left;'>
                                        	<p class='gen'>child 1</p> 
                                        	 <div style='width:50%;text-align:center;float:right;'>
                                             	<p class='gen'>child 1</p>
                                                	<div style='width:50%;text-align:center;float:right;'>
                                                    	<p class='gen'>child 1</p>
                                                    </div>
                                                    <div style='width:50%;text-align:center;float:left;'>
                                                    	<p class='gen'>child 1</p>
                                                    </div>
                                              </div> 
                                              <div style='width:50%;text-align:center;float:left;'>
                                              	<p class='gen'>child 1</p>
                                                	<div style='width:50%;text-align:center;float:right;'>
                                                    	<p class='gen'>child 1</p>
                                                    </div>
                                                    <div style='width:50%;text-align:center;float:left;'>
                                                    	<p class='gen'>child 1</p>
                                                    </div>
                                              </div> 
                                        </div>
                                    <?php	
										
										
										
										# if get_downline_right <> null then
										# 	write <div style='width:50%;text-align:center;float:left;'>
										#	write <p class='gen'>member name child 1</p>
										#	check left and right from member name child 1
										#	if right <> null then
										# 		write <div style='width:50%;text-align:center;float:left;'>
										#		write <p class='gen'>member name child 2</p>
										#		check left and right from member name child 2
										#	else
										#		write </div>
										# else
										#	write </div>
										#
										
										# function get_downline_left(int: id)
										# 	data <= read-data-base (id)
										#	if data <> null
										#		return true
										#	else
										#		return false
										# end of function
										
										# function get_downline_right(int: id)
										# 	data <= read-data-base (id)
										#	if data <> null
										#		return true
										#	else
										#		return false
										# end of function
									?> 
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
                        	                 
                        </div>
                    </div>
                </div>
                <div class="right-backoffice">
                    <div class="box-home-office binary">
                        <div class="heading">
                            <h2>Binary Information </h2>
                        </div>
                        <div class="section-cont" id="info-binary">                    
                        </div>
                    </div>
                    
                    <div class="box-home-office sponsor">
                        <div class="heading">
                            <h2>Direct Sponsors (10 Latest)</h2>
                        </div>
                        <div class="section-cont" id="direct-sponsored">                    
                        </div>
                    </div>
                </div>
                                
            </div>
            <div class="clear"></div>
		</div>