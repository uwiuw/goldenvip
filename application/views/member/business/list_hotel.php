<style>
	table{
		text-align: center;
		background: #000000;
		width: 930px;
		font-family: Arial,Helvetica,sans-serif;
	}
	table th, table td{
		padding-top: 10px;
		padding-bottom: 10px;
	}
	table th{
		background-color: #D6C194;
		font-size: 20px;
	}
	table td{
		background-color: #FFFFFF;
	}
	#jumlah_hotel{
		font-size: 30px;
		text-align: center;
		margin-bottom: 20px;
		font-family: Arial,Helvetica,sans-serif;
		color:#003580;
	}
	.link a{
		text-decoration: underline;
	}
	.link a:hover{
		color: red;
		text-decoration: none;
	}
	table th.number, table td.star-hotel{
		padding-top: 10px;
		padding-bottom: 10px;
		padding-left: 5px;
		padding-right: 5px;
	}
</style>
<div class="container">
    <div id="hotel-detail">
    	<div id="detail-top"></div>
    	<div id="detail-hotel">
    		<div class="box-detail-hotel">
    			<div class="tx-rwadminhotelmlm-pi1">
    				<div id="jumlah_hotel"> <?php echo count($listhotel);?> available in <?php echo $city['destination']; ?> </div>
                    <table cellpadding="8" align="center">
                        <tbody>
                        	<tr>
                                <th class="number">No</th>
                                <th>Hotel Name</th>
                                <th class="star-hotel">Star</th>
                                <th>Location</th>
                            </tr>
                            <?php
								$i = 1;
								foreach($listhotel as $row)
								{
							?>
                            <tr>
                                <td class="number"><?php echo $i; ?></td>
                                <td class="link">
                                <a href="<?php echo site_url('member/post_data/list-hotel/'.$row['uid']); ?>">Hermes Palace <?php echo $row['hotel_name']; ?></a>
                                </td>
                                <td class="star-hotel"><?php echo $row['star']; ?></td>
                                <td><?php echo $row['location']; ?></td>
                            </tr>
                            <?php 
									$i++;
								}
							?>
                        </tbody>
                    </table>
    				</div>
    			</div>
    			<div class="clear"></div>
    		</div>
   			 <div id="detail-bottom"></div>
    	</div>
    <div class="clear"></div>
</div>