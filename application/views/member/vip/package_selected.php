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
                	
    				<div id="jumlah_hotel">Available <?php echo count($sch); ?> Schedule</div>
                    <table cellpadding="8" align="center">
                        <tbody>
                        	<tr>
                                <th class="number">No</th>
                                <th>Time Schedule</th>
                                <th class="star-hotel">Qty</th>
                                <th>Booking</th>
                                <th>Agen Travel</th>
                                <th>Package</th>
                                <th>Destination</th>
                                <th>Action</th>
                            </tr>
                            <?php $i=1; foreach($sch as $row) { ?>
                            <tr>
                                <td class="number"><?php echo $i; ?></td>
                                <td class="link"><?php echo $row['time_sch']; ?></td>
                                <td class="star-hotel"><?php echo $row['qty']; ?></td>
                                <td><?php echo $row['booking']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['destination']; ?></td>
                                <td class="link"><a href="<?php echo site_url('member/post_data/reservation-vip/'.$row['uid']);?>">Select</a></td>
                            </tr>
                            <?php $i++;} ?>
                          </tbody>
                    </table>
    				</div>
    			</div>
    			<div class="clear"></div>
    		</div>
   			 <div id="detail-bottom"></div>
    	</div>
        </div>