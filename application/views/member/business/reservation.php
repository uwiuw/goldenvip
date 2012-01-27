<link rel="stylesheet" href="<?php echo base_url(); ?>asset/theme/ui-lightness/base/jquery.ui.all.css" type="text/css" media="screen"> 
<script src="<?php echo base_url(); ?>asset/js/lib/jquery-ui-1.8.16.custom.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.dialog.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.core.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.ui.datepicker.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugin/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/script/public.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $template; ?>jquery.carouFredSel-5.1.0-packed.js"></script>
<script type="text/javascript">
    site = "<?php echo site_url(); ?>";
    image = "<?php echo base_url(); ?>asset/images/loading.gif";

    jQuery(function(){
        jQuery("#tablesorter-demo").tablesorter();	
        var dates = jQuery( "#datepicker, #datepicker1" ).datepicker({
            defaultDate: "+0d",
            changeMonth: true,
            dateFormat:"yy-mm-dd",
            numberOfMonths: 3,
            minDate: -0,
            onSelect: function( selectedDate ) {
                var option = this.id == "datepicker" ? "minDate" : "maxDate",
                instance = jQuery( this ).data( "datepicker" );
                date = jQuery.datepicker.parseDate(
                instance.settings.dateFormat ||
                    jQuery.datepicker._defaults.dateFormat,
                selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
        jQuery('#slider').carouFredSel({
            prev: '#next',
            next: '#prev',
        });
<?php
$compliment = TRUE;
$get_compliment = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'compliment', $this->session->userdata('member'), 'uid');
if ($get_compliment['compliment'] == '1' || $set_compliment == '0') {
    $compliment = FALSE;
    ?>
                jQuery('#compliment_true').hide();
        		
    <?php
} else {
    ?>
                jQuery('#payment').hide();
<?php } ?>
        jQuery('#lipo').hide(); 
		
        jQuery('#cash_payment').hide();
    });
	
    function check_destination_detail()
    {
        uid = jQuery('#propinsi').val();
        load('member/post_data/get_destnation_detail/'+uid,'#destination_detail');
    }
	
    function get_complimentary()
    {
        if(jQuery('#compliment').val()=='Compliment')
        {
            jQuery('#lipo').fadeIn();
            jQuery('#payment').hide();
            jQuery('#cash_payment').hide();
        }
        else if(jQuery('#compliment').val()=='Personal Account')
        {
            jQuery('#lipo').hide();
            jQuery('#payment').fadeIn();
            jQuery('#cash_payment').hide();
        }
        else
        {
            jQuery('#lipo').hide();
            jQuery('#payment').hide();
            jQuery('#cash_payment').hide();
        }
    }
    function get_select_payment()
    {
		
        if(jQuery('#select_payment').val == '1')
        {
            jQuery('#cash_payment').fadeIn();
        }
        else if(jQuery('#select_payment').val == '2')
        {
            jQuery('#cash_payment').fadeIn();
        }
        else
        {
            jQuery('#cash_payment').fadeIn();
        }
    }
    function check(){

        tglmulai = document.getElementById("datepicker").value;
        tglakhir = document.getElementById("datepicker1").value;

        start_d_arr = tglmulai .split("-");
        end_d_arr = tglakhir.split("-");

        tahun_arr = new Array('January','February','March','april','May','June','July','August','September','October','November','December');

        future0 = new Date(tahun_arr[parseFloat(start_d_arr[1])-1]+" "+parseFloat(start_d_arr[0])+","+parseFloat(start_d_arr[2])+" 01:00:00");
        future1 = new Date(tahun_arr[parseFloat(end_d_arr[1])-1]+" "+parseFloat(end_d_arr[0])+","+parseFloat(end_d_arr[2])+" 01:00:00");

        fut0 = Date.parse(future0);
        fut1 = Date.parse(future1);

        selisih = fut1 - fut0;
        miliday = 24 * 60 * 60 * 1000;
        daysleft = selisih/miliday;
        daysleftint = Math.round(daysleft);
		
        if(document.getElementById("compliment").value=="Compliment" && daysleftint > document.getElementById("malam").value){
            document.getElementById("error").innerHTML = "you are only permitted to stay for " + document.getElementById("malam").value + " nights to compliment";
        }
        else if (document.getElementById("datepicker").value == document.getElementById("datepicker1").value){
            document.getElementById("error").innerHTML = "Minimal 1 Night";
        }

        else if(document.getElementById("propinsi").value=="" || document.getElementById("datepicker").value=="" || document.getElementById("datepicker1").value=="" || document.getElementById("compliment").value=="0" ){
            document.getElementById("error").innerHTML = "you must fill all data";
        }else{
            document.forms["reservasi"].submit();
        }
    }
    function checknotkompliment(){
        if (document.getElementById("select_payment").value=="Credit Card"){
            if(document.getElementById("propinsi").value=="" || document.getElementById("datepicker").value=="" || document.getElementById("datepicker1").value=="" || document.getElementById("select_payment").value=="0" )
            {
                document.getElementById("error").innerHTML = "you must fill all data";
            }else if (document.getElementById("datepicker").value == document.getElementById("datepicker1").value){
                document.getElementById("error").innerHTML = "Minimal 1 Night";
            }
            else{
                document.forms["reservasi"].submit();
            }
        }
        else{
            if(document.getElementById("propinsi").value=="" || document.getElementById("datepicker").value=="" || document.getElementById("datepicker1").value=="" || document.getElementById("select_payment").value=="0" )
            {
                document.getElementById("error").innerHTML = "you must fill all data";
            }else if (document.getElementById("datepicker").value == document.getElementById("datepicker1").value){
                document.getElementById("error").innerHTML = "Minimal 1 Night";
            }
            else{
                document.forms["reservasi"].submit();
            }
        }
    }
</script>
<style type="text/css">
    .line-visit-hotel {
        width: 560px;
        text-align:center;
    }
    .line-visit-hotel ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: block;
    }
    .line-visit-hotel li {
        font-size: 40px;
        color: #999;
        text-align: center; 
        padding: 0;
        margin: 5px;
        display: block;
        float: left;
    }
    .line-visit-hotel li img {width:120px; height:120px;}
</style>
<div class="container">
    <div id="box-reservation">
        <div id="reservation-top">
            <div id="home-top"><h2>RESERVATION</h2></div>
        </div>
        <div id="reservation">
            <div id="left">
                <div class="res-middle">
                    <div class="tx-rwadminhotelmlm-pi1">
                        <div id="find">
                            <div id="error" style="color: red; text-align: center;font-size: 12px;"></div>
                            <form method="POST" action="<?php echo site_url('member/reservation/list-hotel'); ?>" class="et-form" name="reservasi" enctype="multipart/form-data">
                                <div>
                                    <label class="desc">Select Destination :</label>
                                    <?php
                                    $id = "id = 'propinsi' onchange= 'check_destination_detail();' ";
                                    echo form_dropdown('destination', $destination, '0', $id);
                                    ?>
                                    <div class="clr"></div>
                                </div>

                                <div id="destination_detail"></div>

                                <div>
                                    <label class="desc">Check-in :
                                    </label><input id="datepicker" name="datepicker" type="text">
                                    <div class="clr"></div>
                                </div>

                                <div>
                                    <label class="desc">Check-out :</label>
                                    <input id="datepicker1" name="datepicker1" type="text">
                                    <div class="clr"></div>
                                </div>

                                <input name="searchHotel" value="1" type="hidden">
                                <input name="booking_now" value="yes" type="hidden">

                                <div id="compliment_true">
                                    <label class="desc">Booking :</label>
                                    <select id="compliment" name="compliment" onchange="get_complimentary();">
                                        <option selected="selected" value="0">-- using your Complimentary ? --</option>
                                        <option value="Compliment">Yes</option>
                                        <option value="Personal Account">No</option>
                                    </select>
                                    <div class="clr"></div>
                                </div>

                                <div id="lipo">By clicking "yes", <a href="lippo-insurance/">Your Mega Insurance</a> is automatically activated</div>

                                <div id="payment">
                                    <label class="desc">Payment :</label>
                                    <select id="select_payment" name="select_payment" onchange="get_select_payment();">
                                        <option selected="selected" value="0">-- Select Payment --</option>
                                        <option value="Cash">Cash</option>
                                       
                                    </select>
                                    <div class="clr"></div>
                                </div>

                                <div id="cash_payment">
                                    <div id="lipo"><center><font color="#FF0000">Payment in Indonesian Rupiah. Kindly Transfer should be made to PT. GOLDEN VICTORY INSANI PRATAMAYINTARA (GOLDEN VIP) Permata Bank, Jl. Prof. Dr. Soepomo No. 30 Jakarta 12810.
                                            Account No. (IDR) 070.137.5068</font></center></div>
                                </div>

                                <div id="creditCardNumber"></div>
                                <input name="malam" id="malam" value="3" type="hidden">
                                <div>
                                    <?php if ($compliment) { ?>
                                        <input value="Submit" id="submit_photo" class="et-form-btn" onclick="check()" type="button">
                                    <?php } else { ?>
                                        <input value="Submit" id="submit_photo" class="et-form-btn" onclick="checknotkompliment()" type="button">
                                    <?php } ?>
                                    <div class="clr"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="right" style="width:560px;">
                <div class="line-visit-hotel"> 
                    <div class="shadow-left"><a id="prev"></a></div>
                    <ul id="slider" style="float:left;">
                        <li><img src="<?php echo base_url(); ?>upload/reservation/1.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/2.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/3.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/4.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/5.jpg" /></li>
                        <li><img src="<?php echo base_url(); ?>upload/reservation/6.jpg" /></li>
                    </ul> 
                    <div class="shadow-right"><a id="next"></a></div>
                </div>

                <div class="visit-hotel">
                    <h2>Thank you for making your reservatiion. Your confirmed booking hotels as follows :</h2>
                    <div class="box-visit-left"></div>
                    <div class="box-visit-middle">
                        <div class="tx-rwadminhotelmlm-pi1">
                            <table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                                <thead>
                                    <tr>
                                        <th width="24" class="header">No.</th>
                                        <th width="87" class="header headerSortDown">Hotel Name</th>
                                        <th width="72" class="header headerSortDown">Room Type</th>
                                        <th width="60" class="header headerSortDown">Check-in</th>
                                        <th width="65" class="header headerSortDown">check-out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'username', $this->session->userdata('member'), 'uid');
                                    $d = $this->Mix->read_row_ret_field_by_value('fe_users', 'uid', $u['username'], 'username');
                                    if (isset($d['uid'])) {
                                        $sql = "select 
                                                a.check_in, 
                                                a.check_out,
                                                b.category_name,
                                                c.hotel_name 
                                                from 
                                                tx_rwadminhotel_booking a INNER JOIN tx_rwadminhotel_cat_room b ON a.uid_room=b.uid INNER JOIN tx_rwadminhotel_hotel c ON b.uid_hotel=c.uid 
                                                where
                                                a.deleted=0 and 
                                                a.PA=1 
                                                and a.uid_member='" . $d['uid'] . "' 
                                                order by a.uid desc
                                                limit 0,10";
                                    } else {
                                        $sql = "select uid from fe_users where username = '" . $u['username'] . "'";
                                    }
                                    $retail_bonus = $this->Mix->read_more_rows_by_sql($sql);
                                    if (!empty($retail_bonus)) {
                                        $i = 1;
                                        foreach ($retail_bonus as $row) {
                                            ?>
                                            <tr class="even">
                                                <td><?php echo $i; ?>.</td>
                                                <td><?php echo $row['hotel_name']; ?></td>
                                                <td><?php echo $row['category_name']; ?></td>
                                                <td><?php echo $row['check_in']; ?></td>
                                                <td><?php echo $row['check_out']; ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-visit-right"></div>
                </div>

            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>