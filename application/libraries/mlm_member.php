<?php
/*
	* class ini digunakan untuk memberikan kemudahan dalam menangani fungsi-fungsi dalam manajamen member mygoldenvip.com
	* 
*/
class mlm_member {
	/*******************************************************************************
	*                                                                              *
	*                               Public methods                                 *
	*                                                                              *
	*******************************************************************************/
	function get_binary_tree($uid = '0')
	{
		echo "                        
		<div style='width:100%;text-align:center;float:left;'>
			<!-- root -->
			<p class='gen'> ";
					$id  = $uid;
					get_tips_info($id);
					$child_left = get_downline($id,'1'); # placement 1 kiri, 2 kanan 
					$child_right = get_downline($id,'2');
		echo "
			</p>
			
			<!-- kaki sebelah kiri -->
			<div style='width:50%;text-align:center;float:left;'>
					<p class='gen'>";
							$id  = $child_left;
							get_tips_info($id);
							$child_1 = get_downline($id,'1'); # placement 1 kiri, 2 kanan 
							$child_2 = get_downline($id,'2');
		echo "
					 </p> 
					 
					 <!-- kiri -->
			  <div style='width:50%;text-align:center;float:left;'>
				<p class='gen'>";
								$id = $child_1;
								get_tips_info($id);
								$child_11 = get_downline($id,'1'); 
								$child_12 = get_downline($id,'2'); 
		echo "
				</p>
					  </div> 
					  
					  <!-- kanan -->
			  <div style='width:50%;text-align:center;float:right;'>
				<p class='gen'>";
								$id = $child_2;
								get_tips_info($id);
								$child_21 = get_downline($id,'1'); 
								$child_22 = get_downline($id,'2'); 
		echo "
				</p>
					  </div> 
				</div>
				
				<!-- kaki sebelah kanan -->
				<div style='width:50%;text-align:center;float:right;'>
					<p class='gen'>";  
								$id = $child_right;
								get_tips_info($id);
								$child_1 = get_downline($id,'1'); 
								$child_2 = get_downline($id,'2'); 
		echo "
					</p> 
					
					<!-- kiri -->
				  <div style='width:50%;text-align:center;float:left;'>
					<p class='gen'>";
								$id = $child_1;
								get_tips_info($id);
								$child_11 = get_downline($id,'1'); 
								$child_12 = get_downline($id,'2'); 
		echo "
					  </p>
				  </div> 
					  
					  <!-- kanan -->
				  <div style='width:50%;text-align:center;float:right;'>
					<p class='gen'>";
								$id = $child_2;
								get_tips_info($id);
								$child_21 = get_downline($id,'1'); 
								$child_22 = get_downline($id,'2'); 
		echo"
					 </p>
				  </div> 
					  
				</div> 			 
		</div>";     
	}
	
	function get_binary_information()
	{
		
	}
        
        function get_reservation()
        {
        }
}
?>