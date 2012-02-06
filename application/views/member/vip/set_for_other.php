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
                            var nilai = 0;
                            if(document.getElementById("email").value=="")
                            {
                                document.getElementById("mail").innerHTML = "email can't blank";
                            }
                            else
                            {
                                if((email_anda.indexOf('@',0)==-1)||(email_anda.indexOf('.',0)==-1)){
                                    document.getElementById("mail").innerHTML = "Email Not Valid";
                                }else{
<?php for ($i = 1; $i <= $qty; $i++) { ?>
    if (document.getElementById("name<?php echo $i; ?>").value==""){
    document.getElementById("error<?php echo $i; ?>").innerHTML = "Can't blank";
    }
    else{
    nilai = nilai +1;
    }
<?php } ?>
if(nilai == <?php echo $qty; ?>)
{
document.forms["kwitansi"].submit();
}
}
}
}
function calculation()
{
var qty = 0;
var harga = 0;
<?php for ($i = 1; $i <= $qty; $i++) { ?>
    if(document.kwitansi.mega<?php echo $i; ?>[0].checked)
    {
    qty = qty +1;	
    }
<?php } ?>
myself = 0;
<?php if ($me != '') { ?>
    myself = 100 + <?php echo $sch['retail_rate']; ?>;
<?php } ?>
if(qty >= 1)
{
		
harga = (qty * 100) + <?php echo $qty * $sch['retail_rate']; ?> + myself;
document.getElementById("payment").innerHTML = "With insurance you must pay (USD) : "+harga;
}
else
{
harga = <?php echo $qty * $sch['retail_rate']; ?> + myself;
document.getElementById("payment").innerHTML = "WIth out insurance you must pay (USD) : "+harga;
}
	
}

                    </script>
                    <div id="kwitansi">
                        <form name="kwitansi" class="et-form" action="<?php echo site_url('member/reservation/vip/set-reservation/?uid=' . $_GET['uid'] . "&qty=" . $_GET['qty'] . "&uidnum=" . $_GET['uidnum']); ?>" method="POST">
                            <div style="width:100%; text-align:center">
                                <label>Please fill this form for making reservation </label>
                                <div class="clr"></div>
                            </div>
                            <div>
                                <label class="desc">Email :</label>
                                <input type="text" id="email" name="email">
                                <div class="clr"></div>
                            </div>
                            <div>
                                <label class="desc"></label><div style="color: red; text-align: center;font-size: 12px;" id="mail"></div>
                                <div class="clr"></div>
                            </div>
                            <input type="hidden" name="qty" value="<?php echo $qty; ?>" />
                            <?php for ($i = 1; $i <= $qty; $i++) { ?>
                                <div>
                                    <label class="desc">Person #<?php echo $i; ?> Name :</label><input type="text" id="name<?php echo $i; ?>" name="name<?php echo $i; ?>">
                                    <div style="color: red; text-align: center;font-size: 12px;" id="error<?php echo $i; ?>"></div>
                                    <div class="clr"></div>
                                </div>

                            <?php } ?>

                            <div><label class="desc">Destination :</label><input type="text" disabled="1" value="<?php echo $sch['destination']; ?>" id="destination" name="destination"> 
                                <div class="clr"></div>
                            </div>
                            <div><label class="desc">Package Type :</label><input type="text" disabled="1" value="<?php echo $sch['package'] . " - " . $sch['travel'] . " travel"; ?>" id="package_type" name="package_type"> 
                                <div class="clr"></div>
                            </div>
                            <div><label class="desc">Schedule Time :</label><input type="text" disabled="1" value="<?php echo $sch['time_sch']; ?>" id="check_in" name="check_in">
                                <div class="clr"></div>
                            </div>
                            <div><label class="desc">Received from :</label><input type="text" disabled="1" value="<?php echo $received['firstname']; ?>" name="received" id="received">
                                <div class="clr"></div>
                            </div>
                            <input type="hidden" name="rate" value="<?php echo $sch['retail_rate']; ?>" />
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