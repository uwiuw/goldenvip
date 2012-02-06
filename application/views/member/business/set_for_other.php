<style type="text/css">
	.button_black
	{
		background-color: #666666;
		border: 2px solid #CCCCCC;
		border-radius: 15px 15px 15px 15px;
		color: #CCCCCC;
		cursor: pointer;
		display: block;
		font-size: 16px;
		font-weight: bold;
		padding: 10px 30px;
	}
</style>
<div class="container">
				<div id="hotel-detail">
					<div id="detail-top"></div>
					<div id="detail-hotel">
						<h1></h1>
						<div class="box-detail-hotel"><a id="c122"></a>
							<div class="tx-rwadminhotelmlm-pi1">
								<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/old-site/css/reservation.css" type="text/css">
								<script type="text/javascript">

function check(){
    var email_anda = document.getElementById('email').value;

    if (document.getElementById("name").value=="" || document.getElementById("email").value=="" ){
        document.getElementById("error").innerHTML = "You must fill all data";
	}
	else
	{
		if((email_anda.indexOf('@',0)==-1)||(email_anda.indexOf('.',0)==-1)){
			document.getElementById("error").innerHTML = "Email Not Valid";
		}else{
			
			document.forms["kwitansi"].submit();
	
		}
	}
}
function calculation()
{
	var qty = 0;
	var harga = 0;
	if(document.kwitansi.mega[0].checked)
	{
		qty = qty +1;	
	}
	if(qty >= 1)
	{
		
		harga = (qty * 100) + <?php echo $qty*$sch['retail_rate']; ?>;
		document.getElementById("payment").innerHTML = "With insurance you must pay (USD) : "+harga;
	}
	else
	{
		harga = <?php echo $qty*$sch['retail_rate']; ?>;
		document.getElementById("payment").innerHTML = "WIth out insurance you must pay (USD) : "+harga;
	}
	
}

</script><div id="kwitansi">
									<div style="color: red; text-align: center;font-size: 12px;" id="error"></div>
									<form name="kwitansi" class="et-form" action="<?php echo site_url('member/reservation/business/save-reservation'); ?>" method="POST">
										<div><label class="desc">Name :</label><input type="text" id="name" name="name">
											<div class="clr"></div>
										</div>
										<div><label class="desc">Email :</label><input type="text" id="email" name="email">
											<div class="clr"></div>
										</div>
                                        
										<div><label class="desc">Room Type :</label><input type="text" disabled="1" value="<?php echo $sch['category_name'];?>" id="room_type" name="room_type"><input type="hidden" value="" id="room_type1" name="room_type1">
											<div class="clr"></div>
										</div>
										<div><label class="desc">QTY :</label><input type="text" disabled="1" value="<?php echo $sch['qty'];?>" id="jml" name="jml"><input type="hidden" value="" id="jml1" name="jml1">
											<div class="clr"></div>
										</div>
										<div><label class="desc">Check-in :</label><input type="text" disabled="1" value="<?php echo $sch['check_in'];?>" id="check_in" name="check_in"><input type="hidden" value="" id="check_in1" name="check_in1">
											<div class="clr"></div>
										</div>
										<div><label class="desc">Check-out :</label><input type="text" disabled="1" value="<?php echo $sch['check_out'];?>" id="check_out" name="check_out"><input type="hidden" value="" id="check_out1" name="check_out1">
											<div class="clr"></div>
										</div>
										<div><label class="desc">Received from :</label><input type="text" disabled="1" value="<?php echo $sch['firstname'];?>" name="received" id="received"><input type="hidden" value="" name="received1" id="received1">
											<div class="clr"></div>
										</div>
                                        <div> 
                                        	<table width="100%">
                                            	<tr align="center" valign="middle" style="color: red; text-align: center;font-size: 16px; height:50px">
                                                 	<td colspan="2" id="payment"></td>
                                                </tr>
                                            	<tr align="center">
                                                    <td>
                                            			<input type="button" onclick="check()" name="button" class="button_black" id="submit_photo" value="Booking Now">
                                                    </td>
                                                 </tr>
                                            </table>
											<div class="clr"></div>
										</div>
									</form>
								</div>
                                </div>
                                </div>
						<div class="clear"></div>
					</div>
					<div id="detail-bottom"></div>
				</div>
				<div class="clear"></div>
			</div>